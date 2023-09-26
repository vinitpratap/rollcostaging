<?php

namespace App\Http\Controllers;
ini_set('max_execution_time', '0');
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Auth;
use DB;
use App\Modal\Make;
use App\Modal\Spare;
use App\Modal\SpareService;
use App\Modal\SpareOEM;
use App\Imports\SpareImport;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\ImageManagerStatic as Image;
use App\Exports\SpareExport;
use Zipper;
use File;

class SpareController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//     protected $redirectTo = '/dashboard';



    public function __construct() {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AddNewSpare(Request $request) {
        // dd($request->all());
        $max = 7;
        $validation = Validator::make($request->all(),
                        [
                            'spare_nm' => 'required',
                            'spare_part_no' => 'required',
                            //'spare_desc' => 'required',
                            'spare_avail' => 'required',
                            'spare_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('spare_part_no',
                                    'spare_nm'));
        }

        $status = Spare::Where('spare_part_no', $request->spare_part_no)
                ->first();

        if ($status) {
            return redirect()->back()->withErrors(['message', 'Spare already exists']);
        } else {


            $dataToSave = array('spare_nm' => $request->spare_nm,
                'spare_part_no' => $request->spare_part_no,
                'spare_desc' => $request->spare_desc,
                'spare_avail' => $request->spare_avail,
                'spare_add_inf' => $request->spare_add_inf,
                'spare_price' => $request->spare_price,
                'spare_oem' => $request->spare_oem,
                'spare_make' => $request->spare_make,
                'spare_cargo' => $request->spare_cargo,
                'spare_status' => $request->spare_status,
            );

            $id = Spare::create($dataToSave)->id;
            // dd($id);
            $logData = array('subject_id' => $id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_spare',
                'description' => 'insert', 'data_prev' => '', 'data_now' => urldecode(http_build_query($request->all()))
            );
            saveQueryLog($logData);
            if ($id) {
                for ($i = 0; $i < count($request->spare_img); $i++) {
                    if ($i <= $max) {
                        $image = $request->file('spare_img')[$i];
                        $ser_img = $image->getClientOriginalName();
                        $destinationPath = public_path('/upload/spare/');
                        $valImage = validateImage($image->getClientOriginalExtension());
                        if ($valImage) {
                            if (Image::make($image->getRealPath())->width() == 640 && Image::make($image->getRealPath())->height() == 300) {
                                $image_resize1 = Image::make($image->getRealPath());
                                $image_resize1->resize(300, 300);
                                $image_resize1->save(public_path('/upload/spare/th/' . $ser_img));

                                $image_resize2 = Image::make($image->getRealPath());
                                $image_resize2->resize(250, 250);
                                $image_resize2->save(public_path('/upload/spare/thm/' . $ser_img));
                                $image->move($destinationPath, $ser_img);
                            } else {
                                return redirect()->back()->withErrors(['message',
                                            'Spare images are not of specified height and width i.e 640X300']);
                            }
                        } else {
                            return redirect()->back()->withErrors(['message', 'file format is not image']);
                        }
                        $image_update = array('spare_img' . ($i + 1) => $ser_img);
                        Spare::where('spare_id', $id)->update($image_update);
                    }
                }

                return redirect()->back()->with('message',
                                'Spare successfully created');
            } else {
                return redirect()->back()->with('message',
                                'Error while creating spare');
            }
        }
    }

    /*

     * View list 
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function Spares(Request $request) {
        $page_val = 50;
        $pagination_arr = array(50, 100);
        if (Auth::guard('admin')->user()->admin_role == 1) {

            $query = Spare::query();

            if (!empty($request->search)) {
                $search = $request->search;

                $query = $query->where(function($query) use ($search) {
                    $query->where('spare_part_no', 'LIKE', '%' . $search . '%');
                    $query->orWhere('spare_nm', 'LIKE', '%' . $search . '%');
                    $query->orWhere('spare_make', 'LIKE', '%' . $search . '%');
                });
            }
            if (!empty($request->data_entries)) {
                $page_val = $request->data_entries;
            }
            $pageData = $query->orderby('created_at', 'DESC')
                    ->paginate($page_val)
                    ->withPath('?search=' . $request->search.'&data_entries='.$page_val);

            $makeData = Make::orderBy('make_nm', 'ASC')->get();
//            $data = Spare::orderBy('created_at', 'DESC')->get();
            return view('admin.product.manage-spare',
                    array('data' => $pageData, 'make' => $makeData, 'data_entries' => $page_val,
                        'pagination_arr' => $pagination_arr));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit data
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function EditSpare(Request $request) {

        $max = 7;
		//dd($request->all());
        $validation = Validator::make($request->all(),
                        [
                            'spare_nm' => 'required',
                            'spare_part_no' => 'required',
                            //'spare_desc' => 'required',
                            'spare_avail' => 'required',
                            'spare_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('spare_part_no',
                                    'spare_nm'));
        }


        $status = Spare::Where('spare_part_no', $request->spare_part_no)
                //->Where('spare_desc',  $request->spare_desc)
                ->Where('spare_oem',  $request->spare_oem)
                ->Where('spare_make',  $request->spare_make)
                ->Where('spare_id', '!=', $request->spare_id)
                ->first();
        
        //dd($request->all());

        if ($status) {
            return redirect()->back()->withErrors(['message', 'Spare already exists']);
        } else {
            $data = Spare::where('spare_id', $request->spare_id)->first();

            $changed_data = array('spare_nm' => $request->spare_nm,
                'spare_part_no' => $request->spare_part_no,
                'spare_desc' => $request->spare_desc,
                'spare_avail' => $request->spare_avail,
                'spare_add_inf' => $request->spare_add_inf,
                'spare_price' => $request->spare_price,
                'spare_oem' => $request->spare_oem,
                'spare_make' => $request->spare_make,
                'spare_cargo' => $request->spare_cargo,
                'spare_status' => $request->spare_status,
            );

            $diff_in_data = array_diff_assoc($data->getOriginal(), $changed_data);

            $keys_to_be_updated = array_keys($diff_in_data);
            $diff_in_data_to_save = array();
            $data_to_update = array();
            $ser_img = '';

            if (isset($request->spare_img) && count($request->spare_img) > 0) {
                for ($i = 0; $i < count($request->spare_img); $i++) {
                    if ($i <= $max) {
                        $image = $request->file('spare_img')[$i];
                        $ser_img = $image->getClientOriginalName();
                        $destinationPath = public_path('/upload/spare/');
                        $valImage = validateImage($image->getClientOriginalExtension());
                        if ($valImage) {
                            if (Image::make($image->getRealPath())->width() == 640 && Image::make($image->getRealPath())->height() == 300) {
                                $image_resize1 = Image::make($image->getRealPath());
                                $image_resize1->resize(300, 300);
                                $image_resize1->save(public_path('/upload/spare/th/' . $ser_img));

                                $image_resize2 = Image::make($image->getRealPath());
                                $image_resize2->resize(250, 250);
                                $image_resize2->save(public_path('/upload/spare/thm/' . $ser_img));
                                $image->move($destinationPath, $ser_img);
                            } else {
                                return redirect()->back()->withErrors(['message',
                                            'Spare images are not of specified height and width i.e 640X300']);
                            }
                        } else {
                            return redirect()->back()->withErrors(['message', 'file format is not image']);
                        }

                        $image_update = array('spare_img' . ($i + 1) => $ser_img == '' ? $data['spare_img' . ($i + 1)] : $ser_img);
                        Spare::where('spare_id', $request->spare_id)->update($image_update);
                    }
                }
            }

            for ($i = 0; $i < count($keys_to_be_updated); $i++) {
                if (isset($changed_data[$keys_to_be_updated[$i]])) {
                    $data_to_update[$keys_to_be_updated[$i]] = $changed_data[$keys_to_be_updated[$i]];
                    $diff_in_data_to_save[$keys_to_be_updated[$i]] = $diff_in_data[$keys_to_be_updated[$i]];
                }
            }
            $logData = array('subject_id' => $request->spare_id, 'user_id' => Auth::id(),
                'table_used' => 'rollco_ms_spare',
                'description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)),
                'data_now' => urldecode(http_build_query($data_to_update))
            );
            saveQueryLog($logData);
			//dd($changed_data);
            $updateSubCat = Spare::where('spare_id', $request->spare_id)->update($changed_data);
            if ($updateSubCat) {
                return redirect()->back()->with('message',
                                'Spare  successfully updated');
            } else {
                return redirect()->back()->with('message',
                                'Error while updating spare');
            }
        }
    }

    /*

     * Edit data
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function DeleteSpare($id) {
        $data = Spare::where('spare_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(),
            'table_used' => 'rollco_ms_spare',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())),
            'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_spare')->where('spare_id',
                        base64_decode($id))->delete();
        if ($status) {
            return redirect('admin/manage-spare')->with('message',
                            'Spare successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'Error while deleting spare');
        }
    }

    public function GetSpareData(Request $request) {
//        echo $request->id;
        $cat = Spare::Where('spare_id', base64_decode($request->id))->first();
        echo json_encode($cat);
    }

    // upload spare

    public function UploadSpare2(Request $request) {
        if (Auth::guard('admin')->user()->admin_role == 1) {

            if ($request->upload_spare == 1) {
                $validation = Validator::make($request->all(),
                                [
                                    'spare_file' => 'required',
                ]);
                if ($validation->fails()) {
                    return redirect()->back()->withErrors($validation)->withInput($request->only('spare_file'));
                }
                $file = $request->file('spare_file');
                $destinationPath = public_path('/secAdm/storage/app/');
                $fileExt = $file->getClientOriginalExtension();
                if ($fileExt == 'xls' || $fileExt == 'xlsx') {
                    $file->move($destinationPath, $file->getClientOriginalName());
                    //dd($request->file('spare_file'));
                    //$path = public_path('/secAdm/storage/app/'.$file->getClientOriginalName());

                    $dataArray = Excel::toArray(new SpareImport,
                                    $file->getClientOriginalName());
                    if (count($dataArray) > 0) {
                        for ($i = 0; $i < count($dataArray[0]); $i++) {
                            if ($i == 0) {
                                continue;
                            } else {
                                $dataToInsert = array(
                                    'spare_part_no' => $dataArray[0][$i][0],
                                    'spare_cargo' => $dataArray[0][$i][3],
                                    'spare_oem' => $dataArray[0][$i][2],
                                    'spare_make' => $dataArray[0][$i][1],
                                    'spare_nm' => $dataArray[0][$i][0]
                                );
                                $id = Spare::create($dataToInsert)->id;
                            }
                        }
                        return redirect()->back()->with('message',
                                        'Spare sheet successfully uploaded.');
                    }
                } else {
                    return redirect()->back()->with('message',
                                    'Error while uploading spare sheet.');
                }
            }
            $makeData = Make::orderBy('make_nm', 'ASC')->get();
            $data = Spare::orderBy('created_at', 'DESC')->get();
            return view('admin.product.uploadspare',
                    array('data' => $data, 'make' => $makeData));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function UploadSpare() {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            if (Input::hasFile('spare_file')) {
                $file = Input::file('spare_file');
                if ($file->getClientOriginalExtension() == 'csv') {
                    $name = $file->getClientOriginalName();

                    $name = preg_replace("/[^\.\-\_a-zA-Z0-9]/", "", $name);
                    //Not really uniqe - but for all practical reasons, it is
                    $uniqer = substr(md5(uniqid(rand(), 1)), 0, 6);
                    $name = $uniqer . '_' . $name; //Get Unique Name
//                $path = public_path('/upload/csv');
                    $path = public_path('/upload/product-entity');
                    // Moves file to folder on server
                    $file->move($path, $name);
                    $file1 = public_path('/upload/product-entity/' . $name);
                    $productArr = csvToArray($file1);
					if(count($productArr) >0){
							
						}else{
							return redirect()->back()->withErrors(['message', 'Uploaded file is empty']);
				}
//                 dd($productArr);
                    for ($i = 0; $i < count($productArr); $i++) {
                        $prdata = [];
                        $ROLLCO = '';
                        $MANUFACTURER = '';
                        $OEM = '';
                        $CARGO = '';
                        $STATUS = '';
                        if (isset($productArr[$i]['ROLLCO']))
                            $ROLLCO = trim($productArr[$i]['ROLLCO']);
                        if (isset($productArr[$i]['MANUFACTURER']))
                            $MANUFACTURER = trim($productArr[$i]['MANUFACTURER']);
                        if (isset($productArr[$i]['OEM']))
                            $OEM = trim($productArr[$i]['OEM']);
                        if (isset($productArr[$i]['CARGO']))
                            $CARGO = trim($productArr[$i]['CARGO']);
                        if (isset($productArr[$i]['STATUS']))
                            $STATUS = trim($productArr[$i]['STATUS']);


                        if ($ROLLCO != '' && $MANUFACTURER != '') {
                            $prstatus = Spare::select('spare_id')->where('spare_part_no', $ROLLCO)
                                    ->where('spare_oem', $OEM)
                                    ->where('spare_make', $MANUFACTURER)
                                    ->first();
                            $prdata = ['spare_part_no' => $ROLLCO,'spare_nm' => $ROLLCO, 'spare_oem' => $OEM,
                                'spare_make' => $MANUFACTURER, 'spare_cargo' => $CARGO,
                                'spare_status' => $STATUS];
                            if ($prstatus) {
                                
                            } else {
//                    var_dump($data);
                                $prid = Spare::create($prdata);

                            }
                        }else{
							return redirect()->back()->withErrors(['message', 'Required fields are empty']);
						}
                    }

                    return redirect()->back()->with('message',
                                    'Spare successfully uploaded.');
                } else {
                    return redirect()->back()->withErrors(['message', 'file format is not csv']);
                }
            }
            return view('admin.product.uploadspare');
//            else {
//                $makeData = Make::orderBy('make_nm', 'ASC')->get();
//                $data = Spare::orderBy('created_at', 'DESC')->get();
//                return view('admin.product.uploadspare',
//                        array('data' => $data, 'make' => $makeData));
//            }
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function spearService(Request $request) {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            return view('admin.product.uploadspearservice');
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function uploadspearService() {
        if (Auth::guard('admin')->user()->admin_role == 1) {

            if (Input::hasFile('spearService_file')) {
                $file = Input::file('spearService_file');
                if ($file->getClientOriginalExtension() == 'csv') {
                    $name = $file->getClientOriginalName();

                    $name = preg_replace("/[^\.\-\_a-zA-Z0-9]/", "", $name);
                    //Not really uniqe - but for all practical reasons, it is
                    $uniqer = substr(md5(uniqid(rand(), 1)), 0, 6);
                    $name = $uniqer . '_' . $name; //Get Unique Name
//                $path = public_path('/upload/csv');
                    $path = public_path('/upload/product-entity');

                    // Moves file to folder on server
                    $file->move($path, $name);

                    $file1 = public_path('/upload/product-entity/' . $name);

                    $productArr = csvToArray($file1);

					if(count($productArr) >0){
							
						}else{
							return redirect()->back()->withErrors(['message', 'Uploaded file is empty']);
					}
//                 dd($productArr);
                    for ($i = 0; $i < count($productArr); $i++) {
                        $prdata = [];

                        $SpearCode = '';
                        $ServicingUnits = '';
                        if (isset($productArr[$i]['SpearCode']))
                            $SpearCode = trim($productArr[$i]['SpearCode']);
                        if (isset($productArr[$i]['ServicingUnits']) && $productArr[$i]['ServicingUnits'] != '')
                            $ServicingUnits = trim($productArr[$i]['ServicingUnits']);
                        if ($SpearCode != '' && $ServicingUnits != '') {
                            $prstatus = SpareService::select('sps_id')->where('spare_num',
                                            $SpearCode)
                                    ->where('srvs_num', $ServicingUnits)
                                    ->first();
                            $prdata = ['spare_num' => $SpearCode, 'srvs_num' => $ServicingUnits];
                            if ($prstatus) {
                                
                            } else {
//                    var_dump($data);
                                $prid = SpareService::create($prdata);
                            }
                        }else{
							return redirect()->back()->withErrors(['message', 'Required fields are empty']);
						}
                    }

                    return redirect()->back()->with('message',
                                    'Spare Service Number
successfully uploaded.');
                } else {
                    return redirect()->back()->withErrors(['message', 'file format is not csv']);
                }
            } else {
                return redirect()->back()->withErrors(['message', 'file format is not csv']);
            }


            return view('admin.product.uploadspearservice');
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function spearOEM(Request $request) {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            return view('admin.product.uploadspearoem');
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function uploadspearOEM() {
        if (Auth::guard('admin')->user()->admin_role == 1) {

            if (Input::hasFile('spearOEM_file')) {
                $file = Input::file('spearOEM_file');
                if ($file->getClientOriginalExtension() == 'csv') {
                    $name = $file->getClientOriginalName();

                    $name = preg_replace("/[^\.\-\_a-zA-Z0-9]/", "", $name);
                    //Not really uniqe - but for all practical reasons, it is
                    $uniqer = substr(md5(uniqid(rand(), 1)), 0, 6);
                    $name = $uniqer . '_' . $name; //Get Unique Name
//                $path = public_path('/upload/csv');
                    $path = public_path('/upload/product-entity');

                    // Moves file to folder on server
                    $file->move($path, $name);

                    $file1 = public_path('/upload/product-entity/' . $name);

                    $productArr = csvToArray($file1);
				if(count($productArr) >0){
							
						}else{
							return redirect()->back()->withErrors(['message', 'Uploaded file is empty']);
				}
//                 dd($productArr);
                    for ($i = 0; $i < count($productArr); $i++) {
                        $prdata = [];

                        $SpearCode = '';
                        $ReplacingOEM = '';
                        if (isset($productArr[$i]['SpearCode']))
                            $SpearCode = trim($productArr[$i]['SpearCode']);
                        if (isset($productArr[$i]['ReplacingOEM']))
                            $ReplacingOEM = trim($productArr[$i]['ReplacingOEM']);
                        if ($SpearCode != '' && $ReplacingOEM != '') {
                            $prstatus = SpareOEM::select('spm_id')->where('spare_num', $SpearCode)
                                    ->where('oem_num', $ReplacingOEM)
                                    ->first();
                            $prdata = ['spare_num' => $SpearCode, 'oem_num' => $ReplacingOEM];
                            if ($prstatus) {
                                
                            } else {
//                    var_dump($data);
                                $prid = SpareOEM::create($prdata);
                            }
                        }else{
							return redirect()->back()->withErrors(['message', 'Required fields are empty']);
						}
                    }

                    return redirect()->back()->with('message',
                                    'Spare OEM Number
successfully uploaded.');
                } else {
                    return redirect()->back()->withErrors(['message', 'file format is not csv']);
                }
            } else {
                return redirect()->back()->withErrors(['message', 'file format is not csv']);
            }
            return view('admin.product.uploadspearoem');
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function getspearService($id) {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $data = [];
            $data = SpareService::Where('spare_num', base64_decode($id))->orderBy('created_at',
                            'DESC')->get();
//            dd($data);
            return view('admin.product.manage-spare-service',
                    array('data' => $data));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function getspearServiceData(Request $request) {
        $cat = SpareService::Where('sps_id', base64_decode($request->id))->first();
        $data = array(
            'sps_id' => $cat['sps_id'],
            'spare_num' => $cat['spare_num'],
            'srvs_num' => $cat['srvs_num']
        );
        echo json_encode($data);
    }

    public function EditSpareService(Request $request) {
        $validation = Validator::make($request->all(),
                        [
                            'sps_id' => 'required',
                            'spare_num' => 'required',
                            'srvs_num' => 'required'
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('sps_id',
                                    'spare_num', 'srvs_num'));
        }


        $status = SpareService::where('spare_num', $request->spare_num)
                ->where('srvs_num', $request->srvs_num)
                ->Where('sps_id', '!=', $request->sps_id)
                ->first();
        if ($status) {
            return redirect()->back()->withInput($request->only('sps_id',
                                    'spare_num', 'srvs_num'))->withErrors(['message',
                        'Service already exists']);
        } else {
            $data = SpareService::Where('sps_id', $request->sps_id)->first();
            //dd($data);

            $changed_data = array('srvs_num' => $request->srvs_num);

            $diff_in_data = array_diff_assoc($data->getOriginal(), $changed_data);
            $diff_in_data_to_save = array();
            $keys_to_be_updated = array_keys($diff_in_data);

            for ($i = 0; $i < count($keys_to_be_updated); $i++) {
                if (isset($changed_data[$keys_to_be_updated[$i]])) {
                    $data_to_update[$keys_to_be_updated[$i]] = $changed_data[$keys_to_be_updated[$i]];
                    $diff_in_data_to_save[$keys_to_be_updated[$i]] = $diff_in_data[$keys_to_be_updated[$i]];
                }
            }
            $logData = array('subject_id' => $request->sps_id, 'user_id' => Auth::id(),
                'table_used' => 'rollco_ms_spearservice', 'description' => 'update',
                'data_prev' => urldecode(http_build_query($diff_in_data_to_save)),
                'data_now' => urldecode(http_build_query($changed_data))
            );
            //dd($logData);
            saveQueryLog($logData);
            $update = SpareService::Where('sps_id', $request->sps_id)->update($changed_data);

            if ($update) {
                return redirect('admin/manage-spare-service/' . base64_encode($request->spare_num))
                                ->withInput($request->only('sps_id',
                                                'spare_num', 'srvs_num'))
                                ->with('message', 'Service successfully updated');
            } else {
                return redirect()->back()
                                ->withInput($request->only('sps_id',
                                                'spare_num', 'srvs_num'))
                                ->with('message', 'Error while updating service');
            }
        }
    }

    public function DeletespearService($id, $pid) {
        $data = SpareService::where('sps_id', '=', base64_decode($pid))->first();

        $logData = array('subject_id' => base64_decode($pid), 'user_id' => Auth::id(),
            'table_used' => 'rollco_ms_spearservice', 'description' => 'delete',
            'data_prev' => urldecode(http_build_query($data->toArray())), 'data_now' => '');

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_spearservice')->where('sps_id',
                        base64_decode($pid))->delete();
        if ($status) {
            return redirect('admin/manage-spare-service/' . $id)->with('message',
                            'Service successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'error while deleting service');
        }
    }

    public function getspearOEM($id) {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $data = [];
            $data = SpareOEM::Where('spare_num', base64_decode($id))->orderBy('created_at',
                            'DESC')->get();
//            dd($data);
            return view('admin.product.manage-spare-oem', array('data' => $data));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function getoemData(Request $request) {
        $cat = SpareOEM::Where('spm_id', base64_decode($request->id))->first();
        $data = array(
            'spm_id' => $cat['spm_id'],
            'spare_num' => $cat['spare_num'],
            'oem_num' => $cat['oem_num']
        );
        echo json_encode($data);
    }

    public function EditSpareOEM(Request $request) {
        $validation = Validator::make($request->all(),
                        [
                            'spm_id' => 'required',
                            'spare_num' => 'required',
                            'oem_num' => 'required'
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('spm_id',
                                    'spare_num', 'oem_num'));
        }


        $status = SpareOEM::where('spare_num', $request->spare_num)
                ->where('oem_num', $request->oem_num)
                ->Where('spm_id', '!=', $request->spm_id)
                ->first();
        if ($status) {
            return redirect()->back()->withInput($request->only('spm_id',
                                    'spare_num', 'oem_num'))->withErrors(['message',
                        'OEM already exists']);
        } else {
            $data = SpareOEM::Where('spm_id', $request->spm_id)->first();
            //dd($data);

            $changed_data = array('oem_num' => $request->oem_num);

            $diff_in_data = array_diff_assoc($data->getOriginal(), $changed_data);
            $diff_in_data_to_save = array();
            $keys_to_be_updated = array_keys($diff_in_data);

            for ($i = 0; $i < count($keys_to_be_updated); $i++) {
                if (isset($changed_data[$keys_to_be_updated[$i]])) {
                    $data_to_update[$keys_to_be_updated[$i]] = $changed_data[$keys_to_be_updated[$i]];
                    $diff_in_data_to_save[$keys_to_be_updated[$i]] = $diff_in_data[$keys_to_be_updated[$i]];
                }
            }
            $logData = array('subject_id' => $request->spm_id, 'user_id' => Auth::id(),
                'table_used' => 'rollco_ms_spearoem', 'description' => 'update',
                'data_prev' => urldecode(http_build_query($diff_in_data_to_save)),
                'data_now' => urldecode(http_build_query($changed_data))
            );
            //dd($logData);
            saveQueryLog($logData);
            $update = SpareOEM::Where('spm_id', $request->spm_id)->update($changed_data);

            if ($update) {
                return redirect('admin/manage-spare-oem/' . base64_encode($request->spare_num))
                                ->withInput($request->only('spm_id',
                                                'spare_num', 'oem_num'))
                                ->with('message', 'OEM successfully updated');
            } else {
                return redirect()->back()
                                ->withInput($request->only('spm_id',
                                                'spare_num', 'oem_num'))
                                ->with('message', 'Error while updating OEM');
            }
        }
    }

    public function DeletespearOEM($id, $pid) {
        $data = SpareOEM::where('spm_id', '=', base64_decode($pid))->first();

        $logData = array('subject_id' => base64_decode($pid), 'user_id' => Auth::id(),
            'table_used' => 'rollco_ms_spearoem', 'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())),
            'data_now' => '');

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_spearoem')->where('spm_id',
                        base64_decode($pid))->delete();
        if ($status) {
            return redirect('admin/manage-spare-oem/' . $id)->with('message',
                            'OEM successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'error while deleting OEM');
        }
    }

    function exportToExcelSpare() {
        $exporter = app()->makeWith(SpareExport::class);
        return $exporter->download(date('Y-m-d-H-i-s') . '-spare.xlsx');
    }

    // upload spare bulk image

    function bulkSpareImageUpload() {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            if (Input::hasFile('bulkProduct_file')) {
                $file = Input::file('bulkProduct_file');
                $updatePro = '';
                if ($file->getClientOriginalExtension() == 'zip') {
                    $name = $file->getClientOriginalName();

                    $name = preg_replace("/[^\.\-\_a-zA-Z0-9]/", "", $name);

//                $path = public_path('/upload/csv');
                    $path = public_path('/upload/product-entity');

                    // Moves file to folder on server
                    $file->move($path, $name);

                    $file1 = public_path('/upload/product-entity/' . $name);

                    $Path1 = public_path('/upload/product-entity/' . $name);
                    Zipper::make($Path1)->extractTo(public_path('/upload/testzip/'));

                    $filesInFolder = File::files(public_path('/upload/testzip/'));
                    
                  
                    foreach ($filesInFolder as $path) {
//                        echo Image::make($path)->width() ;
//                        echo Image::make($path)->height() ;
//                        die;
//                        if (Image::make($path)->width() == 500 && Image::make($path)->height() == 250) {
                            $file = pathinfo($path);
                            $imgName = explode('-', $file['filename']);
                            $prodName = $imgName[0];
                            $imgType = 0;
                            if (isset($imgName[1])) {
                                $imgType = $imgName[1];
                            }
                            
                            if ($imgType == '1') {
                                $imgCol = "spare_img1";
                            } elseif ($imgType == '2') {
                                $imgCol = "spare_img2";
                            } elseif ($imgType == '3') {
                                $imgCol = "spare_img3";
                            } elseif ($imgType == '4') {
                                $imgCol = "spare_img4";
                            } elseif ($imgType == '5') {
                                $imgCol = "spare_img5";
                            } elseif ($imgType == '6') {
                                $imgCol = "spare_img6";
                            } elseif ($imgType == '7') {
                                $imgCol = "spare_img7";
                            } elseif ($imgType == '8') {
                                $imgCol = "spare_img8";
                            } else {
                                $imgCol = "spare_img1";
                            }

                            $changed_data = array($imgCol => $file['filename'] . "." . $file['extension'],
                                'updated_at' => date("Y-m-d H:i:s"));

                            $updatePro = Spare::where('spare_part_no',
                                            $prodName)->update($changed_data);
                            $move = File::move(public_path('/upload/testzip/' . $file['filename'] . "." . $file['extension']),
                                            public_path('/upload/spare/' . $file['filename'] . "." . $file['extension']));
//                        } else {
//                            
//                            return redirect()->back()->withErrors(['message', 'Spare images are not of specified height and width i.e 500X200 ']);
//                        }
                    }
                    
             
                    if ($updatePro) {
                        return redirect()->back()->with('message',
                                        'Spare images uploaded successfully');
                    } else {
                        return redirect()->back()->withErrors(['message', 'Error :Spare images not uploaded-> '.$prodName]);
                    }
                }
            }
            return view('admin.product.upload-bulkspare-image');
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

}
