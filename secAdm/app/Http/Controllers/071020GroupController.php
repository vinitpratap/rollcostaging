<?php

namespace App\Http\Controllers;

ini_set('max_execution_time', '0');

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\Modal\Group;
use App\Modal\Currency;
use App\Modal\GroupProduct;
use App\Exports\GroupExport;

class GroupController extends Controller {
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
    public function AddNewGroup(Request $request) {
        $data = [];
        $validation = Validator::make($request->all(),
                        [
                            'gr_nm' => 'required',
                            'gr_currency' => 'required',
                            'gr_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('gr_nm',
                                    'gr_status'));
        }

        $name = $request->gr_nm;

		$valid_currArr = array('GBP','USD','EURO');
        $status = Group::where('gr_nm', $name)
                ->first();

        if ($status) {
            return redirect()->back()->withErrors(['message', 'Group already exists']);
        } else {


            $dataToSave = array('gr_nm' => $request->gr_nm,
                'gr_currency' => $request->gr_currency,
                'gr_status' => $request->gr_status
            );
            $id = Group::create($dataToSave)->id;
            /* --------code for csv--------------- */
            if ($id > 0) {
                if (Input::hasFile('productgroup_file')) {
                $file = Input::file('productgroup_file');
                if ($file->getClientOriginalExtension() == 'csv') {
                    $name = $file->getClientOriginalName();

//                $path = public_path('/upload/csv');
                    $path = public_path('/upload/product-group');

                    // Moves file to folder on server
                    $file->move($path, $name);

                    $file1 = public_path('/upload/product-group/' . $name);

                    $productArr = csvToArray($file1);

//                 dd($productArr);
                     for ($i = 0; $i < count($productArr); $i++) {
                            $prdata = [];

                            $AcCode = '';
                            $PartName = '';
                            $Price = '';
                            $Currency = '';
                            if (isset($productArr[$i]['GroupName']))
                                $AcCode = trim($productArr[$i]['GroupName']);
                            if (isset($productArr[$i]['PartName']))
                                $PartName = trim($productArr[$i]['PartName']);
                            if (isset($productArr[$i]['Currency']))
                                $Currency = trim($productArr[$i]['Currency']);
                            if (isset($productArr[$i]['Price']) && $productArr[$i]['Price'] >= '0')
                                $Price = trim($productArr[$i]['Price']);
							
							//dd(in_array($Currency, $valid_currArr));
                            if ($PartName != '' && $Price >= '0') {
//                            $gr_id = $id;
                                if ($AcCode != '') {
									if (in_array($Currency, $valid_currArr)) {
										 
									}else{
										return redirect()->back()->withErrors(['message', 'Currency not available , Please replace £ to GBP, $ to USD and € to EURO']);
									}
                                    if ($Currency=='USD') $Currency='2';
									else if ($Currency=='GBP') $Currency='3';
									else if ($Currency=='EURO') $Currency='4';
									
                                    $grres = Group::select('gr_id')->Where('gr_nm', $AcCode)->first();
                                    //dd($grres);
                                    $grid = $grres['gr_id'];
                                    if (isset($grid) && $grid > 0) {
                                        $gr_id = $grid;
                                        $grdata = ['gr_nm' => $AcCode, 'gr_currency' => $Currency,
                                            'gr_status' => 1];
                                        Group::where('gr_id', $gr_id)->update($grdata);
                                    } else {
                                        $grdata = ['gr_nm' => $AcCode, 'gr_currency' => $Currency,
                                            'gr_status' => 1];
                                        $gr_id = Group::create($grdata)->id;
                                    }
                                }


                                $prstatus = GroupProduct::select('gr_id')->where('gr_id', $gr_id)
                                        ->where('part_nm', $PartName)
                                        ->first();
                                if ($prstatus) {
                                    $prdata = ['pr_price' => $Price];
                                    GroupProduct::where('gr_id', $gr_id)
                                        ->where('part_nm', $PartName)->update($prdata);
                                } else {
                                    $prdata = ['gr_id' => $gr_id, 'part_nm' => $PartName,
                                        'pr_price' => $Price];
										//dd($prdata);
//                    var_dump($data);
                                    GroupProduct::create($prdata);
                                }
                            }
                        }
                    redirect()->back()->with('message', 'Group Price uploaded successfully');
                } else {
                    return redirect()->back()->withErrors(['message', 'file format is not csv']);
                }
            }
            }
            /* --------code for csv end----------- */
            $logData = array('subject_id' => $id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_group',
                'description' => 'insert', 'data_prev' => '', 'data_now' => urldecode(http_build_query($dataToSave))
            );
            saveQueryLog($logData);
            if ($id) {
                return redirect()->back()->with('message',
                                'Group successfully created');
            } else {
                return redirect()->back()->with('message',
                                'Error while creating group');
            }
        }

        return view('admin.group.add-new-group', array('data' => $data));
    }

    /*

     * View customers 
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function Groups(Request $request) {
        $page_val = 50;
        $pagination_arr = array(50, 100);
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $query = Group::query();

            if (!empty($request->search)) {
                $search = $request->search;

                $query = $query->where(function($query) use ($search) {
                    $query->where('gr_nm', 'LIKE', '%' . $search . '%');
                });
            }
            $pageData = $query->orderby('created_at', 'DESC')
                    ->paginate($page_val)
                    ->withPath('?search=' . $request->search);

            //$data = Group::with('getCurrency')->orderBy('created_at', 'DESC')->get();
            $currData = Currency::orderBy('curr_name', 'ASC')->get();
            //dd($pageData);
            return view('admin.group.view-groups',
                    array('data' => $pageData, 'currency' => $currData, 'data_entries' => $page_val, 'pagination_arr' => $pagination_arr));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function EditGroup(Request $request) {
		$valid_currArr = array('GBP','USD','EURO');
        $validation = Validator::make($request->all(),
                        [
                            'gr_nm' => 'required',
                            'gr_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('gr_nm',
                                    'gr_currency', 'gr_status'));
        }
        $name = $request->gr_nm;

        $status = Group::where('gr_nm', $name)
                ->where('gr_currency', $request->gr_currency)
                ->where('gr_id', '!=', $request->gr_id)
                ->first();
        if ($status) {
            return redirect()->back()->withErrors(['message', 'Group already exists']);
        } else {
            $data = Group::Where('gr_id', $request->gr_id)->first();
            //dd($data);

            $changed_data = array('gr_nm' => $request->gr_nm, 'gr_currency' => $request->gr_currency,
                'gr_status' => $request->gr_status,
            );
			
			//dd($changed_data);
            $diff_in_data = array_diff_assoc($data->getOriginal(), $changed_data);
            $diff_in_data_to_save = array();
            $keys_to_be_updated = array_keys($diff_in_data);

            for ($i = 0; $i < count($keys_to_be_updated); $i++) {
                if (isset($changed_data[$keys_to_be_updated[$i]])) {
                    $data_to_update[$keys_to_be_updated[$i]] = $changed_data[$keys_to_be_updated[$i]];
                    $diff_in_data_to_save[$keys_to_be_updated[$i]] = $diff_in_data[$keys_to_be_updated[$i]];
                }
            }
            $logData = array('subject_id' => $request->gr_id, 'user_id' => Auth::id(),
                'table_used' => 'rollco_ms_group',
                'description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)),
                'data_now' => urldecode(http_build_query($changed_data))
            );
            //dd($logData);
            saveQueryLog($logData);
            $updateCat = Group::Where('gr_id', $request->gr_id)->update($changed_data);

            /* --------code for csv----------- */
            if ($request->gr_id > 0) {
                if (Input::hasFile('productgroup_file')) {
                $file = Input::file('productgroup_file');
                if ($file->getClientOriginalExtension() == 'csv') {
                    $name = $file->getClientOriginalName();

//                $path = public_path('/upload/csv');
                    $path = public_path('/upload/product-group');

                    // Moves file to folder on server
                    $file->move($path, $name);

                    $file1 = public_path('/upload/product-group/' . $name);

                    $productArr = csvToArray($file1);

//                 dd($productArr);
                     for ($i = 0; $i < count($productArr); $i++) {
                            $prdata = [];

                            $AcCode = '';
                            $PartName = '';
                            $Price = '';
                            $Currency = '';
                            if (isset($productArr[$i]['GroupName']))
                                $AcCode = trim($productArr[$i]['GroupName']);
                            if (isset($productArr[$i]['PartName']))
                                $PartName = trim($productArr[$i]['PartName']);
                            if (isset($productArr[$i]['Currency']))
                                $Currency = trim($productArr[$i]['Currency']);
                            if (isset($productArr[$i]['Price']) && $productArr[$i]['Price'] >= '0')
                                $Price = trim($productArr[$i]['Price']);
							
							//dd(in_array($Currency, $valid_currArr));
                            if ($PartName != '' && $Price >= '0') {
//                            $gr_id = $id;
                                if ($AcCode != '') {
									if (in_array($Currency, $valid_currArr)) {
										 
									}else{
										return redirect()->back()->withErrors(['message', 'Currency not available , Please replace £ to GBP, $ to USD and € to EURO']);
									}
                                    if ($Currency=='USD') $Currency='2';
									else if ($Currency=='GBP') $Currency='3';
									else if ($Currency=='EURO') $Currency='4';
									
                                    $grres = Group::select('gr_id')->Where('gr_nm', $AcCode)->first();
                                    //dd($grres);
                                    $grid = $grres['gr_id'];
                                    if (isset($grid) && $grid > 0) {
                                        $gr_id = $grid;
                                        $grdata = ['gr_nm' => $AcCode, 'gr_currency' => $Currency,
                                            'gr_status' => 1];
                                        Group::where('gr_id', $gr_id)->update($grdata);
                                    } else {
                                        $grdata = ['gr_nm' => $AcCode, 'gr_currency' => $Currency,
                                            'gr_status' => 1];
                                        $gr_id = Group::create($grdata)->id;
                                    }
                                }


                                $prstatus = GroupProduct::select('gr_id')->where('gr_id', $gr_id)
                                        ->where('part_nm', $PartName)
                                        ->first();
                                if ($prstatus) {
                                    $prdata = ['pr_price' => $Price];
                                    GroupProduct::where('gr_id', $gr_id)
                                        ->where('part_nm', $PartName)->update($prdata);
                                } else {
                                    $prdata = ['gr_id' => $gr_id, 'part_nm' => $PartName,
                                        'pr_price' => $Price];
										//dd($prdata);
//                    var_dump($data);
                                    GroupProduct::create($prdata);
                                }
                            }
                        }
                    redirect()->back()->with('message', 'Group Price uploaded successfully');
                } else {
                    return redirect()->back()->withErrors(['message', 'file format is not csv']);
                }
            }
            }
            /* --------code for csv end----------- */

            if ($updateCat) {
                return redirect('admin/view-group')->with('message',
                                'Group successfully updated');
            } else {
                return redirect()->back()->with('message',
                                'Error while updating group');
            }
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function DeleteGroup($id) {
        $data = Group::where('gr_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(),
            'table_used' => 'rollco_ms_group',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())),
            'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_group')->where('gr_id',
                        base64_decode($id))->delete();
        //DB::table('rollco_ms_subcat')->where('catid', base64_decode($id))->delete();
        //DB::table('rollco_ms_services')->where('catid', base64_decode($id))->delete();
        if ($status) {
            return redirect('admin/view-group')->with('message',
                            'group successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'error while deleting group');
        }
    }

    public function GetGroupData(Request $request) {
        $cat = Group::Where('gr_id', base64_decode($request->id))->first();
        $data = array(
            'id' => $cat['gr_id'],
            'name' => $cat['gr_nm'],
            'currency' => $cat['gr_currency'],
            'status' => $cat['gr_status'],
        );
        echo json_encode($data);
    }

//    

    public function ProductsGroup($id) {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $data = [];
            $data = GroupProduct::Where('gr_id', base64_decode($id))->with('getGroup')->orderBy('created_at',
                            'DESC')->get();
//            dd($data);
            return view('admin.group.manage-products-group',
                    array('data' => $data));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function DeleteProductsGroup($id, $pid) {
        $data = GroupProduct::where('grp_id', '=', base64_decode($pid))->first();

        $logData = array('subject_id' => base64_decode($pid), 'user_id' => Auth::id(),
            'table_used' => 'rollco_ms_grproduct', 'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())),
            'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_grproduct')->where('grp_id',
                        base64_decode($pid))->delete();
        if ($status) {
            return redirect('admin/manage-product-group/' . $id)->with('message',
                            'Price successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'error while deleting price');
        }
    }

    public function EditProductGroup(Request $request) {
        $validation = Validator::make($request->all(),
                        [
                            'grp_id' => 'required',
                            'gr_id' => 'required',
                            'part_nm' => 'required',
                            'pr_price' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('grp_id',
                                    'gr_id', 'part_nm', 'pr_price'));
        }


        $status = GroupProduct::where('gr_id', $request->gr_id)
                ->where('part_nm', $request->part_nm)
                ->where('grp_id', '!=', $request->grp_id)
                ->first();
        if ($status) {
            return redirect()->back()->withInput($request->only('grp_id',
                                    'gr_id', 'part_nm', 'pr_price'))->withErrors([
                        'message', 'Part No. already exists']);
        } else {
            $data = GroupProduct::Where('grp_id', $request->grp_id)->first();
            //dd($data);

            $changed_data = array('part_nm' => $request->part_nm, 'pr_price' => $request->pr_price);

            $diff_in_data = array_diff_assoc($data->getOriginal(), $changed_data);
            $diff_in_data_to_save = array();
            $keys_to_be_updated = array_keys($diff_in_data);

            for ($i = 0; $i < count($keys_to_be_updated); $i++) {
                if (isset($changed_data[$keys_to_be_updated[$i]])) {
                    $data_to_update[$keys_to_be_updated[$i]] = $changed_data[$keys_to_be_updated[$i]];
                    $diff_in_data_to_save[$keys_to_be_updated[$i]] = $diff_in_data[$keys_to_be_updated[$i]];
                }
            }
            $logData = array('subject_id' => $request->grp_id, 'user_id' => Auth::id(),
                'table_used' => 'rollco_ms_grproduct', 'description' => 'update',
                'data_prev' => urldecode(http_build_query($diff_in_data_to_save)),
                'data_now' => urldecode(http_build_query($changed_data))
            );
            //dd($logData);
            saveQueryLog($logData);
            $updatePrice = GroupProduct::Where('grp_id', $request->grp_id)->update($changed_data);

            if ($updatePrice) {
                return redirect('admin/manage-product-group/' . base64_encode($request->gr_id))
                                ->withInput($request->only('grp_id', 'gr_id',
                                                'part_nm', 'pr_price'))
                                ->with('message', 'Price successfully updated');
            } else {
                return redirect()->back()
                                ->withInput($request->only('grp_id', 'gr_id',
                                                'part_nm', 'pr_price'))
                                ->with('message', 'Error while updating price');
            }
        }
    }

    public function GetProductGroupData(Request $request) {
        $cat = GroupProduct::Where('grp_id', base64_decode($request->id))->first();
        $data = array(
            'grp_id' => $cat['grp_id'],
            'gr_id' => $cat['gr_id'],
            'part_nm' => $cat['part_nm'],
            'pr_price' => $cat['pr_price']
        );
        echo json_encode($data);
    }

    public function exportToExcelGroup() {
        $exporter = app()->makeWith(GroupExport::class);
        return $exporter->download(date('Y-m-d-H-i-s') . '-group.xlsx');
    }

    public function UploadGroupPrice(Request $request) {
		$valid_currArr = array('GBP','USD','EURO');
        if (Auth::guard('admin')->user()->admin_role == 1) {
            if (Input::hasFile('productgroup_file')) {
                $file = Input::file('productgroup_file');
                if ($file->getClientOriginalExtension() == 'csv') {
                    $name = $file->getClientOriginalName();

//                $path = public_path('/upload/csv');
                    $path = public_path('/upload/product-group');

                    // Moves file to folder on server
                    $file->move($path, $name);

                    $file1 = public_path('/upload/product-group/' . $name);

                    $productArr = csvToArray($file1);

//                 dd($productArr);
                    for ($i = 0; $i < count($productArr); $i++) {
                            $prdata = [];

                            $AcCode = '';
                            $PartName = '';
                            $Price = '';
                            $Currency = '';
                            if (isset($productArr[$i]['GroupName']))
                                $AcCode = trim($productArr[$i]['GroupName']);
                            if (isset($productArr[$i]['PartName']))
                                $PartName = trim($productArr[$i]['PartName']);
                            if (isset($productArr[$i]['Currency']))
                                $Currency = trim($productArr[$i]['Currency']);
                            if (isset($productArr[$i]['Price']) && $productArr[$i]['Price'] >= '0')
                                $Price = trim($productArr[$i]['Price']);
							
							//dd(in_array($Currency, $valid_currArr));
                            if ($PartName != '' && $Price >= '0') {
//                            $gr_id = $id;
                                if ($AcCode != '') {
									if (in_array($Currency, $valid_currArr)) {
										 
									}else{
										return redirect()->back()->withErrors(['message', 'Currency not available , Please replace £ to GBP, $ to USD and € to EURO']);
									}
                                    if ($Currency=='USD') $Currency='2';
									else if ($Currency=='GBP') $Currency='3';
									else if ($Currency=='EURO') $Currency='4';
									
                                    $grres = Group::select('gr_id')->Where('gr_nm', $AcCode)->first();
                                    //dd($grres);
                                    $grid = $grres['gr_id'];
                                    if (isset($grid) && $grid > 0) {
                                        $gr_id = $grid;
                                        $grdata = ['gr_nm' => $AcCode, 'gr_currency' => $Currency,
                                            'gr_status' => 1];
                                        Group::where('gr_id', $gr_id)->update($grdata);
                                    } else {
                                        $grdata = ['gr_nm' => $AcCode, 'gr_currency' => $Currency,
                                            'gr_status' => 1];
                                        $gr_id = Group::create($grdata)->id;
                                    }
                                }


                                $prstatus = GroupProduct::select('gr_id')->where('gr_id', $gr_id)
                                        ->where('part_nm', $PartName)
                                        ->first();
                                if ($prstatus) {
                                    $prdata = ['pr_price' => $Price];
                                    GroupProduct::where('gr_id', $gr_id)
                                        ->where('part_nm', $PartName)->update($prdata);
                                } else {
                                    $prdata = ['gr_id' => $gr_id, 'part_nm' => $PartName,
                                        'pr_price' => $Price];
										//dd($prdata);
//                    var_dump($data);
                                    GroupProduct::create($prdata);
                                }
                            }
                        }
                    redirect()->back()->with('message', 'Group Price uploaded successfully');
                } else {
                    return redirect()->back()->withErrors(['message', 'file format is not csv']);
                }
            }
            return view('admin.group.upload-groupprice');
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

}
