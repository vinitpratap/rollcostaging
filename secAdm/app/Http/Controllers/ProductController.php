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
use App\Modal\MCategory;
use App\Modal\Category;
use App\Modal\Product;
use App\Modal\Make;
use App\Modal\Model;
use App\Modal\ProYear;
use App\Modal\ProCCM;
use App\Modal\EngineCode;
use App\Modal\Application;
use App\Modal\Mscode;
use Intervention\Image\ImageManagerStatic as Image;
use App\Exports\ProductExport;
use App\Exports\ApplicationExport;
use Zipper;
use File;
use Response;

class ProductController extends Controller {
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
    public function AddNewProduct(Request $request) {
        //dd($request->all());
        $max = 7;
        $validation = Validator::make($request->all(),
                        [
                            'catid' => 'required',
                            'makeid' => 'required',
                            'modelid' => 'required',
                            'proyrid' => 'required',
                            //'proccmid' => 'required',
                            //'engid' => 'required',
                            'prod_nm' => 'required',
                            'prod_part_no' => 'required',
                            //'prod_desc' => 'required',
                            //'prod_stock' => 'required',
                            'prod_add_inf' => 'required',
                        //'prod_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('modelid',
                                    'catid', 'prod_nm', 'prod_part_no'));
        }

        $status = Product::Where('modelid', $request->modelid)
                ->Where('catid', $request->catid)
                ->Where('makeid', $request->makeid)
                ->Where('proyrid', $request->proyrid)
                ->Where('proccmid', $request->proccmid)
                ->Where('engid', $request->engid)
                ->Where('prod_nm', $request->prod_nm)
                ->Where('prod_part_no', $request->prod_part_no)
                ->first();

        $name = $request->prod_part_no;
        if ($status) {
            return redirect()->back()->withErrors(['message', 'Product already exists']);
        } else {


            $dataToSave = array('mcatid' => $request->mcatid,
                'catid' => $request->catid,
                'makeid' => $request->makeid,
                'modelid' => $request->modelid,
                'proyrid' => $request->proyrid,
                'proccmid' => $request->proccmid,
                'engid' => $request->engid,
                'prod_nm' => $request->prod_nm,
                'prod_part_no' => $request->prod_part_no,
                'prod_desc' => $request->prod_desc,
                'prod_volt' => $request->prod_volt,
                'prod_out' => $request->prod_out,
                'prod_regu' => $request->prod_regu,
                'prod_pull_type' => $request->prod_pull_type,
                'prod_fan' => $request->prod_fan,
                //'prod_stock' => $request->prod_stock,
                'prod_add_inf' => $request->prod_add_inf,
                'prod_teeth' => $request->prod_teeth,
                'prod_trans' => $request->prod_trans,
                'prod_rot' => $request->prod_rot,
                'prod_dim' => $request->prod_dim,
                'prod_price' => $request->prod_price,
                //'prod_status' => $request->prod_status,
                //'is_latest' => $request->is_latest,
                'ptype' => $request->ptype,
                'position' => $request->position,
                'gr' => $request->gr,
                'car_fits' => $request->car_fits,
                'fuel' => $request->fuel,
                'external_teeth' => $request->external_teeth,
                'internal_teeth' => $request->internal_teeth,
                'height' => $request->height,
                'abs_ring' => $request->abs_ring,
                'mscode' => $request->mscode,
                'cylinders' => $request->cylinders,
                'prod_overview' => $request->prod_overview,
            );
            $id = Product::create($dataToSave)->id;
            // dd($id);
            $logData = array('subject_id' => $id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_product',
                'description' => 'insert', 'data_prev' => '', 'data_now' => urldecode(http_build_query($request->all()))
            );
            saveQueryLog($logData);
            if ($id) {
                if (isset($request->prod_img) && $request->prod_img != '') {
                    for ($i = 0; $i < count($request->prod_img); $i++) {
                        if ($i <= $max) {

                            $image = $request->file('prod_img')[$i];
                            $ser_img = $image->getClientOriginalName();
                            $destinationPath = public_path('/upload/product/');
                            $valImage = validateImage($image->getClientOriginalExtension());
                            if ($valImage) {
                                if (Image::make($image->getRealPath())->width() == 400 && Image::make($image->getRealPath())->height() == 300) {
                                    $image_resize1 = Image::make($image->getRealPath());
                                    $image_resize1->resize(300, 300);
                                    $image_resize1->save(public_path('/upload/product/th/' . $ser_img));

                                    $image_resize2 = Image::make($image->getRealPath());
                                    $image_resize2->resize(250, 250);
                                    $image_resize2->save(public_path('/upload/product/thm/' . $ser_img));
                                    $image->move($destinationPath, $ser_img);
                                } else {
                                    return redirect()->back()->withErrors(['message',
                                                'Product images are not of specified height and width i.e 400X300']);
                                }
                            } else {
                                return redirect()->back()->withErrors(['message', 'file format is not image']);
                            }
                            $image_update = array('prod_img' . ($i + 1) => $ser_img);
                            Product::where('prod_id', $id)->update($image_update);
                        }
                    }
                }

                return redirect()->back()->with('message',
                                'Product successfully created');
            } else {
                return redirect()->back()->with('message',
                                'Error while creating product');
            }
        }
    }

    /*

     * View list
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function Products(Request $request) {
        $page_val = 50;
        $pagination_arr = array(50, 100);
        if (Auth::guard('admin')->user()->admin_role == 1) {

            $query = Product::query();

            if (!empty($request->search)) {
                $search = $request->search;

                $query = $query->where(function($query) use ($search) {
                    $query->where('prod_part_no', 'LIKE', '%' . $search . '%');
                    $query->orWhere('prod_nm', 'LIKE', '%' . $search . '%');
//                $query->orWhere('spare_nm', 'LIKE', '%' . $search . '%');
//                $query->orWhere('spare_make', 'LIKE', '%' . $search . '%');
                });
            }
            if (!empty($request->data_entries)) {
                $page_val = $request->data_entries;
            }
            $pageData = $query->orderby('created_at', 'DESC')
                    ->paginate($page_val)
                    ->withPath('?search=' . $request->search.'&data_entries='.$page_val);


            $mcategoryData = MCategory::orderBy('mcat_nm', 'ASC')->get();
//            $data = Product::orderBy('created_at', 'DESC')->get();
            return view('admin.product.manage-product',
                    array('data' => $pageData, 'mcategory' => $mcategoryData, 'data_entries' => $page_val,
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

    public function EditProduct(Request $request) {

        $max = 7;
        $validation = Validator::make($request->all(),
                        [
                            'mcatid' => 'required',
                            'catid' => 'required',
                            'makeid' => 'required',
                            'modelid' => 'required',
                            'proyrid' => 'required',
                            //'proccmid' => 'required',
                            //'engid' => 'required',
                            'prod_nm' => 'required',
                            'prod_part_no' => 'required',
                            //'prod_desc' => 'required',
                            // 'prod_stock' => 'required',
                            'prod_add_inf' => 'required',
                        //'prod_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('modelid',
                                    'catid', 'prod_nm', 'prod_part_no'));
        }
        $mcatid = $request->mcatid;
        $catid = $request->catid;
        $makeid = $request->makeid;
        $modelid = $request->modelid;
        $proyrid = $request->proyrid;
        $proccmid = $request->proccmid;
        $engid = $request->engid;
        $prod_part_no = $request->prod_part_no;


        $status = Product::where(function($query) use($modelid, $mcatid, $catid, $makeid, $proyrid, $proccmid, $engid, $prod_part_no) {
                    $query->Where('mcatid', $mcatid)
                    ->Where('catid', $catid)
                    ->Where('makeid', $makeid)
                    ->Where('modelid', $modelid)
                    ->Where('proccmid', $proccmid)
                    ->Where('engid', $engid)
                    ->Where('prod_part_no', $prod_part_no)
                    ->Where('proyrid', $proyrid);
                })
                ->where('prod_id', '!=', $request->prod_id)
                ->first();


        if ($status) {
            return redirect()->back()->withErrors(['message', 'Product already exists']);
        } else {
            $data = Product::where('prod_id', $request->prod_id)->first();

            $changed_data = array('mcatid' => $request->mcatid,
                'catid' => $request->catid,
                'makeid' => $request->makeid,
                'modelid' => $request->modelid,
                'proyrid' => $request->proyrid,
                'proccmid' => $request->proccmid,
                'engid' => $request->engid,
                'prod_nm' => $request->prod_nm,
                'prod_part_no' => $request->prod_part_no,
                'prod_desc' => $request->prod_desc,
                'prod_volt' => $request->prod_volt,
                'prod_out' => $request->prod_out,
                'prod_regu' => $request->prod_regu,
                'prod_pull_type' => $request->prod_pull_type,
                'prod_fan' => $request->prod_fan,
                //'prod_stock' => $request->prod_stock,
                'prod_add_inf' => $request->prod_add_inf,
                'prod_teeth' => $request->prod_teeth,
                'prod_trans' => $request->prod_trans,
                'prod_rot' => $request->prod_rot,
                'prod_dim' => $request->prod_dim,
                'prod_price' => $request->prod_price,
                //'prod_status' => $request->prod_status,
                //'is_latest' => $request->is_latest,
                'ptype' => $request->ptype,
                'position' => $request->position,
                'gr' => $request->gr,
                'car_fits' => $request->car_fits,
                'fuel' => $request->fuel,
                'external_teeth' => $request->external_teeth,
                'internal_teeth' => $request->internal_teeth,
                'height' => $request->height,
                'abs_ring' => $request->abs_ring,
                'mscode' => $request->mscode,
                'cylinders' => $request->cylinders,
                'prod_overview' => $request->prod_overview,
            );

            $diff_in_data = array_diff_assoc($data->getOriginal(), $changed_data);

            $keys_to_be_updated = array_keys($diff_in_data);
            $diff_in_data_to_save = array();
            $data_to_update = array();
            $ser_img = '';
            if (isset($request->prod_img) && count($request->prod_img) > 0) {
                for ($i = 0; $i < count($request->prod_img); $i++) {
                    if ($i <= $max) {
                        $image = $request->file('prod_img')[$i];
                        $ser_img = $image->getClientOriginalName();
                        $destinationPath = public_path('/upload/product/');
                        $valImage = validateImage($image->getClientOriginalExtension());
                        if ($valImage) {
                            if (Image::make($image->getRealPath())->width() == 400 && Image::make($image->getRealPath())->height() == 300) {
                                $image_resize1 = Image::make($image->getRealPath());
                                $image_resize1->resize(300, 300);
                                $image_resize1->save(public_path('/upload/product/th/' . $ser_img));

                                $image_resize2 = Image::make($image->getRealPath());
                                $image_resize2->resize(250, 250);
                                $image_resize2->save(public_path('/upload/product/thm/' . $ser_img));
                                $image->move($destinationPath, $ser_img);
                            } else {
                                return redirect()->back()->withErrors(['message',
                                            'Product images are not of specified height and width i.e 400X300']);
                            }
                        } else {
                            return redirect()->back()->withErrors(['message', 'file format is not image']);
                        }

                        $image_update = array('prod_img' . ($i + 1) => $ser_img == '' ? $data['prod_img' . ($i + 1)] : $ser_img);
                        Product::where('prod_id', $request->prod_id)->update($image_update);
                    }
                }
            }

            for ($i = 0; $i < count($keys_to_be_updated); $i++) {
                if (isset($changed_data[$keys_to_be_updated[$i]])) {
                    $data_to_update[$keys_to_be_updated[$i]] = $changed_data[$keys_to_be_updated[$i]];
                    $diff_in_data_to_save[$keys_to_be_updated[$i]] = $diff_in_data[$keys_to_be_updated[$i]];
                }
            }
            $logData = array('subject_id' => $request->prod_id, 'user_id' => Auth::id(),
                'table_used' => 'rollco_ms_product',
                'description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)),
                'data_now' => urldecode(http_build_query($data_to_update))
            );
            saveQueryLog($logData);
            $updateSubCat = Product::where('prod_id', $request->prod_id)->update($changed_data);
            if ($updateSubCat) {
                return redirect()->back()->with('message',
                                'Product  successfully updated');
            } else {
                return redirect()->back()->with('message',
                                'Error while updating product');
            }
        }
    }

    /*

     * Edit data
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function DeleteProduct($id) {
        $data = Product::where('prod_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(),
            'table_used' => 'rollco_ms_product',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())),
            'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_product')->where('prod_id',
                        base64_decode($id))->delete();
        if ($status) {
            return redirect()->back()->with('message',
                            'Product successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'Error while deleting product');
        }
    }

    public function GetProductData(Request $request) {
        $cat = Product::Where('prod_id', base64_decode($request->id))->first();

        echo json_encode($cat);
    }

    public function GetProductDataByMake(Request $request) {
        //dd($request->all());
        $data = array();
        $cat = Product::Where('makeid', $request->id)->where('prod_status', 1)->get();
        foreach ($cat as $key => $value) {
            $data[] = array(
                'id' => $value['prod_id'],
                'name' => $value['prod_nm'],
            );
        }

        echo json_encode($data);
    }

    public function application(Request $request) {
        $page_val = 50;
        $pagination_arr = array(50, 100);
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $query = Application::query();

            if (!empty($request->get('search'))) {
                $search = $request->search;

                $query = $query->where(function($query) use ($search) {
                    $query->where('make_nm', 'LIKE', '%' . $search . '%');
                    $query->orWhere('model_nm', 'LIKE', '%' . $search . '%');
                    $query->orWhere('eng_nm', 'LIKE', '%' . $search . '%');
                    $query->orWhere('year', 'LIKE', '%' . $search . '%');
                    $query->orWhere('cc', 'LIKE', '%' . $search . '%');
                    $query->orWhere('part_no', 'LIKE', '%' . $search . '%');
                });
            }

            if (!empty($request->data_entries)) {
                $page_val = $request->data_entries;
            }

            $pageData = $query->orderby('created_at', 'DESC')
                    ->paginate($page_val)
					->withPath('?search=' . $request->search.'&data_entries='.$page_val);

            return view('admin.product.uploadapplication',
                    array('data' => $pageData, 'data_entries' => $page_val,
                        'pagination_arr' => $pagination_arr));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function uploadapplication() {
        if (Auth::guard('admin')->user()->admin_role == 1) {

            if (Input::hasFile('application_file')) {
                $file = Input::file('application_file');
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
                    if (count($productArr) > 0) {
                        
                    } else {
                        return redirect()->back()->withErrors(['message', 'Uploaded file is empty']);
                    }
                    //dd($productArr);
                    for ($i = 0; $i < count($productArr); $i++) {
                        $prdata = [];

                        $MAKE = '';
                        $MODEL = '';
                        //$ENG = '';
                        $YEAR = '';
                        $CC = '';
                        $RCnumber = '';
                        $status_check = 0;
                        if (isset($productArr[$i]['MAKE']))
                            $MAKE = trim($productArr[$i]['MAKE']);
                        if (isset($productArr[$i]['MODEL']))
                            $MODEL = trim($productArr[$i]['MODEL']);
                        /* if (isset($productArr[$i]['ENGINE']))
                          $ENG = trim($productArr[$i]['ENGINE']); */
                        if (isset($productArr[$i]['YEAR']))
                            $YEAR = trim($productArr[$i]['YEAR']);
                        if (isset($productArr[$i]['CC']))
                            $CC = trim($productArr[$i]['CC']);
                        if (isset($productArr[$i]['RCnumber']))
                            $RCnumber = trim($productArr[$i]['RCnumber']);
                        if (isset($productArr[$i]['Status']))
                            $status = trim($productArr[$i]['Status']);
                        if ($status == 'ENABLE') {
                            $status_check = 1;
                        } else if ($status == 'DISABLE') {
                            $status_check = 0;
                        }
						
						$MAKE = remove_accents($MAKE);
						$MODEL = remove_accents($MODEL);
						$YEAR = remove_accents($YEAR);
						$CC = remove_accents($CC);
						$RCnumber = remove_accents($RCnumber);
                        if ($MAKE != '' && $MODEL != '' && $RCnumber != '') {
                            $prstatus = Application::select('ap_id')->where('make_nm', $MAKE)
                                    ->where('model_nm', $MODEL)
                                    ->where('part_no', $RCnumber)
                                    //->where('eng_nm', $ENG)
                                    ->where('year', $YEAR)
                                    ->where('cc', $CC)
                                    ->first();
                            $prdata = ['make_nm' => $MAKE, 'model_nm' => $MODEL,
                                'year' => $YEAR, 'cc' => $CC, 'part_no' => $RCnumber, 'ap_status' => $status_check];
                            //dd($prdata);
                            if ($prstatus) {
                                $prid = Application::where('part_no', $RCnumber)
                                        ->where('model_nm', $MODEL)
                                        ->where('make_nm', $MAKE)
                                        //->where('eng_nm', $ENG)
                                        ->where('year', $YEAR)
                                        ->where('cc', $CC)
                                        ->update($prdata);
                                DB::table('rollco_ms_application_log')->insert(
                                        ['make_nm' => $MAKE, 'model_nm' => $MODEL,
                                            'year' => $YEAR, 'cc' => $CC, 'part_no' => $RCnumber, 'status' => 'Exist', 'ap_status' => $status_check]
                                );
                            } else {
                                $prid = Application::create($prdata);
                                DB::table('rollco_ms_application_log')->insert(
                                        ['make_nm' => $MAKE, 'model_nm' => $MODEL,
                                            'year' => $YEAR, 'cc' => $CC, 'part_no' => $RCnumber, 'status' => 'Insert', 'ap_status' => $status_check]
                                );
                            }
                        } else {
                            DB::table('rollco_ms_application_log')->insert(
                                    ['make_nm' => $MAKE, 'model_nm' => $MODEL,
                                        'year' => $YEAR, 'cc' => $CC, 'part_no' => $RCnumber, 'status' => 'Skip', 'ap_status' => $status_check]
                            );
                            //return redirect()->back()->withErrors(['message', 'Required fields are empty']);
                        }
                    }
//exit;
                    return redirect()->back()->with('message',
                                    'Application
successfully uploaded.');
                } else {
                    return redirect()->back()->withErrors(['message', 'file format is not csv']);
                }
            } else {
                return redirect()->back()->withErrors(['message', 'file format is not csv']);
            }
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function getproductApplication($id) {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $data = [];
            $data = Application::Where('part_no', base64_decode($id))->orderBy('created_at',
                            'DESC')->get();
//            dd($data);
            return view('admin.product.manage-product-application',
                    array('data' => $data));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function getproductApplicationData(Request $request) {
        $cat = Application::Where('ap_id', base64_decode($request->id))->first();
        $data = array(
            'ap_id' => $cat['ap_id'],
            'make_nm' => $cat['make_nm'],
            'model_nm' => $cat['model_nm'],
            'eng_nm' => $cat['eng_nm'],
            'year' => $cat['year'],
            'cc' => $cat['cc'],
            'part_no' => $cat['part_no']
        );
        echo json_encode($data);
    }

    public function EditproductApplication(Request $request) {
        $validation = Validator::make($request->all(),
                        [
                            'ap_id' => 'required',
                            'make_nm' => 'required',
                            'model_nm' => 'required',
                            'part_no' => 'required'
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('ap_id',
                                    'make_nm', 'model_nm', 'part_no'));
        }
//dd($request->all());
        $status = Application::where('part_no', $request->part_no)
                ->where('make_nm', $request->make_nm)
                ->where('model_nm', $request->model_nm)
				->where('year', $request->year)
                ->Where('ap_id', '!=', $request->ap_id)
                ->first();
				//dd($status);
        if ($status) {
            return redirect()->back()->withInput($request->only('ap_id',
                                    'make_nm', 'model_nm', 'year', 'cc',
                                    'part_no'))->withErrors(['message', 'Application already exists']);
        } else {
            $data = Application::Where('ap_id', $request->ap_id)->first();
            //dd($data);

            $changed_data = array('make_nm' => $request->make_nm, 'model_nm' => $request->model_nm,
                'year' => $request->year, 'cc' => $request->cc, 'part_no' => $request->part_no);

            $diff_in_data = array_diff_assoc($data->getOriginal(), $changed_data);
            $diff_in_data_to_save = array();
            $keys_to_be_updated = array_keys($diff_in_data);

            for ($i = 0; $i < count($keys_to_be_updated); $i++) {
                if (isset($changed_data[$keys_to_be_updated[$i]])) {
                    $data_to_update[$keys_to_be_updated[$i]] = $changed_data[$keys_to_be_updated[$i]];
                    $diff_in_data_to_save[$keys_to_be_updated[$i]] = $diff_in_data[$keys_to_be_updated[$i]];
                }
            }
            $logData = array('subject_id' => $request->ap_id, 'user_id' => Auth::id(),
                'table_used' => 'rollco_ms_application', 'description' => 'update',
                'data_prev' => urldecode(http_build_query($diff_in_data_to_save)),
                'data_now' => urldecode(http_build_query($changed_data))
            );
            //dd($logData);
            saveQueryLog($logData);
            $update = Application::Where('ap_id', $request->ap_id)->update($changed_data);

            if ($update) {
				if(isset($request->app_upload) && $request->app_upload==1){
					return redirect()->back()
                                ->withInput($request->only('ap_id', 'make_nm',
                                                'model_nm', 'year', 'cc',
                                                'part_no'))
                                ->with('message',
                                        'Application successfully updated');
				}else{
					return redirect('admin/manage-product-application/' . base64_encode($request->part_no))
                                ->withInput($request->only('ap_id', 'make_nm',
                                                'model_nm', 'year', 'cc',
                                                'part_no'))
                                ->with('message',
                                        'Application successfully updated');
				}
            } else {
                return redirect()->back()
                                ->withInput($request->only('ap_id', 'make_nm',
                                                'model_nm', 'year', 'cc',
                                                'part_no'))
                                ->with('message',
                                        'Error while updating Application');
            }
        }
    }

    public function DeleteproductApplication($id, $pid) {
        $data = Application::where('ap_id', '=', base64_decode($pid))->first();

        $logData = array('subject_id' => base64_decode($pid), 'user_id' => Auth::id(),
            'table_used' => 'rollco_ms_application', 'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())),
            'data_now' => '');

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_application')->where('ap_id',
                        base64_decode($pid))->delete();
        if ($status) {
            return redirect('admin/manage-product-application/' . $id)->with('message',
                            'Application successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'error while deleting Application');
        }
    }

    public function MsCode(Request $request) {
		
		$page_val = 50;
        $pagination_arr = array(50, 100);

        if (Auth::guard('admin')->user()->admin_role == 1) {
			
			
            $query = Mscode::query();

            if (!empty($request->search)) {
                $search = $request->search;

                $query = $query->where(function($query) use ($search) {
                    $query->where('part_no', 'LIKE', '%' . $search . '%');
                    $query->orWhere('V8Key', 'LIKE', '%' . $search . '%');
//                $query->orWhere('spare_nm', 'LIKE', '%' . $search . '%');
//                $query->orWhere('spare_make', 'LIKE', '%' . $search . '%');
                });
            }
            if (!empty($request->data_entries)) {
                $page_val = $request->data_entries;
            }
            $query = $query->groupby('part_no');
            $query = $query->groupby('V8Key');
            $pageData = $query->orderby('part_no', 'ASC')
                    ->paginate($page_val)
                    ->withPath('?search=' . $request->search.'&data_entries='.$page_val);


            $prcheck = Product::select('prod_id')->first();
            if ($prcheck) {
                return view('admin.product.uploadMsCode',
                    array('data' => $pageData, 'data_entries' => $page_val,
                        'pagination_arr' => $pagination_arr,'status' => 1));
            } else {
                return view('admin.product.uploadMsCode', array('message' => 'No Products Found, Please Upload Products First', 'status' => 0));
            }
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function uploadMsCode() {
        if (Auth::guard('admin')->user()->admin_role == 1) {

            if (Input::hasFile('MsCode_file')) {
                $file = Input::file('MsCode_file');
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
                    if (count($productArr) > 0) {
                        
                    } else {
                        return redirect()->back()->withErrors(['message', 'Uploaded file is empty']);
                    }
                    //dd(($productArr));
                    $V8Key = '';
                    for ($i = 0; $i < count($productArr); $i++) {
                        $prdata = [];

                        $PartNumber = '';
                        $V8Key = '';

                        if (isset($productArr[$i]['PartNumber']))
                            $PartNumber = trim($productArr[$i]['PartNumber']);

                        if (isset($productArr[$i]['V8Key']) && trim($productArr[$i]['V8Key']) != '')
                            $V8Key = trim($productArr[$i]['V8Key']);


$PartNumber = remove_accents($PartNumber);
$V8Key = remove_accents($V8Key);

                        if ($V8Key != '') {

                            if ($PartNumber != '') {
                                //$prcheck = Product::select('prod_id')->where('prod_part_no', $PartNumber)->first();
                                //if ($prcheck) {
                                $VSDSres = Mscode::select('part_no')->Where('part_no', $PartNumber)
                                        ->Where('V8Key', $V8Key)
                                        ->first();
                                //$VSDSms_id = $VSDSres['ms_id'];
                                if ($VSDSres['part_no'] != '') {
                                    
                                } else {
                                    $mscode_data = array('part_no' => $PartNumber, 'MsCode' => 'NA',
                                        'V8Key' => $V8Key);
                                    $id = Mscode::create($mscode_data)->id;
                                }
                                // }
                            } else {
                                return redirect()->back()->withErrors(['message', 'Required fields are empty']);
                            }
                        } else {
                            return redirect()->back()->withErrors(['message', 'Required fields are empty']);
                        }
                    }
                    return redirect()->back()->with('message',
                                    'MsCode
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

    public function uproducts() {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            return view('admin.product.uploadproducts');
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function uploadproducts() {

        if (Auth::guard('admin')->user()->admin_role == 1) {
            if (Input::hasFile('productstatuschnage_file') || Input::hasFile('products_file') || Input::hasFile('products_file_detail') || Input::hasFile('productsstatus_file')) {

                if (Input::hasFile('productstatuschnage_file')) {
                    $file = Input::file('productstatuschnage_file');
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
                        if (count($productArr) > 0) {
                            
                        } else {
                            return redirect()->back()->withErrors(['message', 'Uploaded file is empty']);
                        }
                        //dd($productArr);
                        for ($i = 0; $i < count($productArr); $i++) {
                            $prdata = [];

                            $part_no = '';
                            $status = '';

                            if (isset($productArr[$i]['part_no']))
                                $part_no = trim($productArr[$i]['part_no']);
                            if (isset($productArr[$i]['status']))
                                $status = trim($productArr[$i]['status']);


$part_no = remove_accents($part_no);
$status = remove_accents($status);
                            $status_check = '';
                            if ($status == 'ENABLE') {
                                $status_check = 1;
                            } else if ($status == 'DISABLE') {
                                $status_check = 0;
                            }

                            if ($part_no != '' && $status != '') {
                                $changed_data = array('prod_status' => $status_check);
                                //dd($changed_data);
                                $update = Product::Where('prod_part_no',
                                                $part_no)->update($changed_data);
                            } else {
                                return redirect()->back()->withErrors(['message', 'Required fileds are empty']);
                            }
                        }
                        return redirect()->back()->with('message',
                                        'Products  status
successfully changed.');
                    } else {
                        return redirect()->back()->withErrors(['message', 'file format is not csv']);
                    }
                }
                if (Input::hasFile('productsstatus_file')) {
                    $file = Input::file('productsstatus_file');
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
                        if (count($productArr) > 0) {
                            
                        } else {
                            return redirect()->back()->withErrors(['message', 'Uploaded file is empty']);
                        }
                        //dd($productArr);
                        for ($i = 0; $i < count($productArr); $i++) {
                            $prdata = [];

                            $part_no = '';
                            $stock_info = '';

                            if (isset($productArr[$i]['part_no']))
                                $part_no = trim($productArr[$i]['part_no']);
                            if (isset($productArr[$i]['stock_info']))
                                $stock_info = trim($productArr[$i]['stock_info']);

                            $prod_stock = '';
                            if ($stock_info == 'EXSTOCK') {
                                $prod_stock = 1;
                            } else if ($stock_info == 'LOW ON STOCK') {
                                $prod_stock = 2;
                            } else if ($stock_info == 'NO STOCK') {
                                $prod_stock = 0;
                            }
$part_no = remove_accents($part_no);
$stock_info = remove_accents($stock_info);


                            if ($part_no != '' && $stock_info != '') {
                                $changed_data = array('prod_stock' => $prod_stock);
                                //dd($changed_data);
                                $update = Product::Where('prod_part_no',
                                                $part_no)->update($changed_data);
                            } else {
                                return redirect()->back()->withErrors(['message', 'Required fileds are empty']);
                            }
                        }
                        return redirect()->back()->with('message',
                                        'Products status
successfully changed.');
                    } else {
                        return redirect()->back()->withErrors(['message', 'file format is not csv']);
                    }
                }
                if (Input::hasFile('products_file')) {
                    $file = Input::file('products_file');
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
                        if (count($productArr) > 0) {
                            
                        } else {
                            return redirect()->back()->withErrors(['message', 'file is empty']);
                        }
                        for ($i = 0; $i < count($productArr); $i++) {
                            $prdata = [];

                            $CATEGORY = '';
                            $SUB_CATEGORY = '';
                            $ROLLCO_PART = '';
                            $MAKE = '';
                            $MODEL = '';
                            $YEAR = '';
                            $FUEL = '';
                            $CCM = '';
                            $CYLINDERS = '';
                            $TRANSMISSION = '';
                            $ENGINE = '';
                            if (isset($productArr[$i]['CATEGORY']))
                                $CATEGORY = utf8_encode(trim($productArr[$i]['CATEGORY']));
                            if (isset($productArr[$i]['SUB_CATEGORY']))
                                $SUB_CATEGORY = utf8_encode(trim($productArr[$i]['SUB_CATEGORY']));
                            if (isset($productArr[$i]['ROLLCO_PART']))
                                $ROLLCO_PART = utf8_encode(trim($productArr[$i]['ROLLCO_PART']));
                            if (isset($productArr[$i]['MAKE']))
                                $MAKE = utf8_encode(trim($productArr[$i]['MAKE']));
                            if (isset($productArr[$i]['MODEL']))
                                $MODEL = utf8_encode(trim($productArr[$i]['MODEL']));
                            if (isset($productArr[$i]['YEAR']))
                                $YEAR = utf8_encode(trim($productArr[$i]['YEAR']));
                            if (isset($productArr[$i]['FUEL']))
                                $FUEL = utf8_encode(trim($productArr[$i]['FUEL']));
                            if (isset($productArr[$i]['CCM']))
                                $CCM = utf8_encode(trim($productArr[$i]['CCM']));
                            if (isset($productArr[$i]['CYLINDERS']))
                                $CYLINDERS = utf8_encode(trim($productArr[$i]['CYLINDERS']));
                            if (isset($productArr[$i]['TRANSMISSION']))
                                $TRANSMISSION = utf8_encode(trim($productArr[$i]['TRANSMISSION']));
                            if (isset($productArr[$i]['ENGINE']))
                                $ENGINE = utf8_encode(trim($productArr[$i]['ENGINE']));


$CATEGORY = remove_accents($CATEGORY);
$SUB_CATEGORY = remove_accents($SUB_CATEGORY);
$ROLLCO_PART = remove_accents($ROLLCO_PART);
$MAKE = remove_accents($MAKE);
$MODEL = remove_accents($MODEL);
$YEAR = remove_accents($YEAR);
$FUEL = remove_accents($FUEL);
$CCM = remove_accents($CCM);
$CYLINDERS = remove_accents($CYLINDERS);
$TRANSMISSION = remove_accents($TRANSMISSION);
$ENGINE = remove_accents($ENGINE);


//print_r($productArr);
//echo 'CATEGORY::'.$CATEGORY;
//echo '<br/>SUB_CATEGORY::'.$SUB_CATEGORY;
//echo '<br/>ROLLCO_PART::'.$ROLLCO_PART;
//echo '<br/>MAKE::'.$MAKE;
//echo '<br/>MODEL::'.$MODEL;
//echo '<br/>YEAR::'.$YEAR;
//exit;
//                           dd($productArr);
                            if ($CATEGORY != '' && $SUB_CATEGORY != '' && $ROLLCO_PART != '' && $MAKE != '' && $MODEL != '' && $YEAR != '') {
//echo '<br/>enter';


                                $mcat_id = 0;
                                if ($CATEGORY != '') {
                                    $mcatres = MCategory::select('mcat_id')->Where('mcat_nm',
                                                    $CATEGORY)->first();
									if (isset($mcatres)){
										 $mcat_id = $mcatres['mcat_id'];
									}
                                    if (isset($mcat_id) && $mcat_id > 0) {
                                        
                                    } else {
                                        $mcatdata = ['mcat_nm' => $CATEGORY, 'mcat_status' => 1];
                                        $mcat_id = MCategory::create($mcatdata)->id;
                                    }
                                }

                                $cat_id = 0;
                                if ($SUB_CATEGORY != '') {
                                    $catres = Category::select('cat_id')->Where('cat_nm',
                                                    $SUB_CATEGORY)
                                            ->Where('mcatid', $mcat_id)
                                            ->first();
									if (isset($catres)){
										 $cat_id = $catres['cat_id'];
									}
                                    
                                    if (isset($cat_id) && $cat_id > 0) {
                                        
                                    } else {
                                        $catdata = ['mcatid' => $mcat_id, 'cat_nm' => $SUB_CATEGORY,
                                            'cat_status' => 1];
                                        $cat_id = Category::create($catdata)->id;
                                    }
                                }
                                $make_id = 0;

                                if ($MAKE != '') {
                                    $makeres = Make::select('make_id')->Where('make_nm', $MAKE)
                                            ->Where('catid', $cat_id)
                                            ->first();
									if (isset($makeres)){
										 $make_id = $makeres['make_id'];
									}
                                    
                                    if (isset($make_id) && $make_id > 0) {
                                        
                                    } else {
                                        $makedata = ['catid' => $cat_id, 'make_nm' => $MAKE,
                                            'make_status' => 1];
                                        $make_id = Make::create($makedata)->id;
                                    }
                                }

                                $model_id = 0;
                                if ($MODEL != '') {
                                    $modelres = Model::select('model_id')->Where('model_nm', $MODEL)
                                            ->Where('catid', $cat_id)
                                            ->Where('makeid', $make_id)
                                            ->first();
									if (isset($modelres)){
										 $model_id = $modelres['model_id'];
									}
                                    
                                    if (isset($model_id) && $model_id > 0) {
                                        
                                    } else {
                                        $modeldata = ['catid' => $cat_id, 'makeid' => $make_id,
                                            'model_nm' => $MODEL, 'model_status' => 1];
                                        $model_id = Model::create($modeldata)->id;
                                    }
                                }

                                $proyr_id = 0;
                                $current_flag = 0;
                                if ($YEAR != '') {
                                    if ($YEAR == 'On') {
                                        $current_flag = 1;
                                        $proyrres = ProYear::select('proyr_id')
                                                ->Where('catid', $cat_id)
                                                ->Where('makeid', $make_id)
                                                ->Where('modelid', $model_id)
                                                ->Where('current_flag', 1)
                                                ->first();
                                        
										if (isset($proyrres)){
											$proyr_id = $proyrres['proyr_id'];
										}
                                        if (isset($proyr_id) && $proyr_id > 0) {
                                            
                                        } else {
                                            $proyrdata = ['catid' => $cat_id,
                                                'makeid' => $make_id, 'modelid' => $model_id,
                                                'proyr_status' => 1, 'current_flag' => 1];
                                            $proyr_id = ProYear::create($proyrdata)->id;
                                        }
                                    } else {
                                        if (strpos($YEAR, '-') !== true) {
                                            $YEAR = $YEAR . '-';
                                        }
                                        $YEAR_arr = explode('-', $YEAR);
                                        $YEAR_from = trim($YEAR_arr[0]);
                                        $YEAR_to = 0;
                                        if (isset($YEAR_arr[1]) && $YEAR_arr[1] != '') {
                                            $YEAR_to = trim($YEAR_arr[1]);
                                        }
                                        $proyrres = ProYear::select('proyr_id')->Where('proyr_from',
                                                        $YEAR_from)
                                                ->Where('proyr_to', $YEAR_to)
                                                ->Where('catid', $cat_id)
                                                ->Where('makeid', $make_id)
                                                ->Where('modelid', $model_id)
                                                ->first();
										if (isset($proyrres)){
											$proyr_id = $proyrres['proyr_id'];
										}
                                        
                                        if (isset($proyr_id) && $proyr_id > 0) {
                                            
                                        } else {
                                            $proyrdata = ['proyr_from' => $YEAR_from,
                                                'proyr_to' => $YEAR_to, 'catid' => $cat_id,
                                                'makeid' => $make_id, 'modelid' => $model_id,
                                                'proyr_status' => 1];
                                            $proyr_id = ProYear::create($proyrdata)->id;
                                        }
                                    }
                                }

                                $proccm_id = 0;
                                if ($CCM != '') {
                                    $proccmres = ProCCM::select('proccm_id')->Where('proccm_inf',
                                                    $CCM)
                                            ->Where('catid', $cat_id)
                                            ->Where('makeid', $make_id)
                                            ->Where('modelid', $model_id)
                                            ->Where('proyrid', $proyr_id)
                                            ->first();
                                 
									if (isset($proccmres)){
											$proccm_id = $proccmres['proccm_id'];
										}
                                    if (isset($proccm_id) && $proccm_id > 0) {
                                        
                                    } else {
                                        $proccmdata = ['proccm_inf' => $CCM, 'catid' => $cat_id,
                                            'makeid' => $make_id, 'modelid' => $model_id,
                                            'proyrid' => $proyr_id, 'proccm_status' => 1];
                                        $proccm_id = ProCCM::create($proccmdata)->id;
                                    }
                                }

                                $engcode_id = 0;
                                if ($ENGINE != '') {
                                    $engcoderes = EngineCode::select('engcode_id')->Where('engcode_inf',
                                                    $ENGINE)
                                            ->Where('catid', $cat_id)
                                            ->Where('makeid', $make_id)
                                            ->Where('modelid', $model_id)
                                            ->Where('proyrid', $proyr_id)
                                            ->Where('proccmid', $proccm_id)
                                            ->first();
									if (isset($engcoderes)){
											$engcode_id = $engcoderes['engcode_id'];
										}
                                    
                                    if (isset($engcode_id) && $engcode_id > 0) {
                                        
                                    } else {
                                        $engcodedata = ['engcode_inf' => $ENGINE,
                                            'catid' => $cat_id, 'makeid' => $make_id,
                                            'modelid' => $model_id, 'proyrid' => $proyr_id,
                                            'proccmid' => $proccm_id, 'engcode_status' => 1];
                                        $engcode_id = EngineCode::create($engcodedata)->id;
                                    }
                                }

                                $productres = Product::select('prod_id')->Where('mcatid', $mcat_id)
                                        ->Where('catid', $cat_id)
                                        ->Where('makeid', $make_id)
                                        ->Where('modelid', $model_id)
                                        ->Where('proyrid', $proyr_id)
                                        ->Where('proccmid', $proccm_id)
                                        ->Where('engid', $engcode_id)
                                        ->Where('prod_trans', $TRANSMISSION)
                                        ->Where('prod_part_no', $ROLLCO_PART)
                                        ->first();
                 //echo '<pre>';print_r(DB::getQueryLog());      
                 $prod_id = 0;
										if (isset($productres)){
											$prod_id = $productres['prod_id'];
										}
                                


                                if (isset($prod_id) && $prod_id > 0) {
                                    /* $changed_data = array('prod_nm' => $ROLLCO_PART,
                                      'fuel' => $FUEL, 'cylinders' => $CYLINDERS,
                                      'prod_trans' => $TRANSMISSION);
                                      $update = Product::Where('prod_id', $prod_id)->update($changed_data); */
                                    DB::table('rollco_prod_notinserted')->insert(
                                            ['CATEGORY' => $CATEGORY,
                                                'SUB_CATEGORY' => $SUB_CATEGORY,
                                                'ROLLCO_PART' => $ROLLCO_PART,
                                                'MAKE' => $MAKE,
                                                'MODEL' => $MODEL,
                                                'YEAR' => $YEAR,
                                                'FUEL' => $FUEL,
                                                'CCM' => $CCM,
                                                'CYLINDERS' => $CYLINDERS,
                                                'TRANSMISSION' => $TRANSMISSION,
                                                'ENGINE' => $ENGINE, 'case_check' => 'Exist']
                                    );
                                } else {
                                   // dd('test');
                                    $prdata = ['mcatid' => $mcat_id, 'catid' => $cat_id,
                                        'makeid' => $make_id, 'modelid' => $model_id,
                                        'proyrid' => $proyr_id, 'proccmid' => $proccm_id,
                                        'engid' => $engcode_id, 'prod_nm' => $ROLLCO_PART,
                                        'prod_part_no' => $ROLLCO_PART, 'fuel' => $FUEL,
                                        'cylinders' => $CYLINDERS, 'prod_trans' => $TRANSMISSION];

                                    $prod_id = Product::create($prdata)->id;
                                    //dd($prod_id);
                                    if (!$prod_id) {
                                        DB::table('rollco_prod_notinserted')->insert(
                                                ['CATEGORY' => $CATEGORY,
                                                    'SUB_CATEGORY' => $SUB_CATEGORY,
                                                    'ROLLCO_PART' => $ROLLCO_PART,
                                                    'MAKE' => $MAKE,
                                                    'MODEL' => $MODEL,
                                                    'YEAR' => $YEAR,
                                                    'FUEL' => $FUEL,
                                                    'CCM' => $CCM,
                                                    'CYLINDERS' => $CYLINDERS,
                                                    'TRANSMISSION' => $TRANSMISSION,
                                                    'ENGINE' => $ENGINE, 'case_check' => 'Skip']
                                        );
                                    } else {
                                        DB::table('rollco_prod_notinserted')->insert(
                                                ['CATEGORY' => $CATEGORY,
                                                    'SUB_CATEGORY' => $SUB_CATEGORY,
                                                    'ROLLCO_PART' => $ROLLCO_PART,
                                                    'MAKE' => $MAKE,
                                                    'MODEL' => $MODEL,
                                                    'YEAR' => $YEAR,
                                                    'FUEL' => $FUEL,
                                                    'CCM' => $CCM,
                                                    'CYLINDERS' => $CYLINDERS,
                                                    'TRANSMISSION' => $TRANSMISSION,
                                                    'ENGINE' => $ENGINE, 'case_check' => 'Insert']
                                        );
                                    }
                                }
                            } else {

                                DB::table('rollco_prod_notinserted')->insert(
                                        ['CATEGORY' => $CATEGORY,
                                            'SUB_CATEGORY' => $SUB_CATEGORY,
                                            'ROLLCO_PART' => $ROLLCO_PART,
                                            'MAKE' => $MAKE,
                                            'MODEL' => $MODEL,
                                            'YEAR' => $YEAR,
                                            'FUEL' => $FUEL,
                                            'CCM' => $CCM,
                                            'CYLINDERS' => $CYLINDERS,
                                            'TRANSMISSION' => $TRANSMISSION,
                                            'ENGINE' => $ENGINE, 'case_check' => 'Skip']
                                );
                                return redirect()->back()->withErrors(['message', 'Required fields are empty']);
                            }
                        }
                        
                        return redirect()->back()->with('message',
                                        'Products
successfully uploaded.');
                    } else {
                        return redirect()->back()->withErrors(['message', 'file format is not csv']);
                    }
                }

                if (Input::hasFile('products_file_detail')) {
                    $file = Input::file('products_file_detail');
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

                        if (count($productArr) > 0) {
                            
                        } else {
                            return redirect()->back()->withErrors(['message', 'file is empty']);
                        }
                        //dd($productArr);
                        for ($i = 0; $i < count($productArr); $i++) {
                            $prdata = [];

                            $Category = '';
                            $Sub_Category = '';
                            $Rollco_Part = '';
                            //$Availability = '';
							
                            $TYPE = '';
                            $POSITION = '';
                            $Volts = '';
                            $Output = '';
                            $Pulley = '';
                            $REGulator = '';
                            $Fan = '';
                            $Teeth = '';
                            $GR = '';

                            $Transmission = '';
                            $Rotation = '';
                            $CAR_FITS = '';
                            $FUEL = '';
                            $APPLICATION = '';
                            $INFORMATION = '';
                            $External_Teeth = '';
                            $Internal_Teeth = '';
                            $Diameter = '';
                            $Height = '';
                            $ABS_ring = '';

                            $Weight = '';
                            $Disc_Dia = '';
                            $Disc_Thick = '';
                            $Piston_Dia = '';
                            $Man = '';
                            $Pump_Type = '';
                            $Pressure = '';
                            $Pully_Ribs = '';
                            $Total_Length = '';
                            $Pin = '';
                            $Fitting_position = '';
                            $No_of_Holes = '';
                            $Bolt_Hole_Circle_Dia = '';
                            $Inner_Dia = '';
                            $Outer_Dia = '';

                            $Teeth_wheel_side = '';
                            $Teeth_Diff_Side = '';
                            $Min_Th = '';
                            $Max_Th = '';
                            $Centre_Dia = '';
                            $PCD = '';
                            $Disc_Type = '';
                            $Width = '';
                            $F_R = '';

                            if (isset($productArr[$i]['Teeth_wheel_side']))
                                $Teeth_wheel_side = trim($productArr[$i]['Teeth_wheel_side']);
                            if (isset($productArr[$i]['Teeth_Diff_Side']))
                                $Teeth_Diff_Side = trim($productArr[$i]['Teeth_Diff_Side']);
                            if (isset($productArr[$i]['Min_Th']))
                                $Min_Th = trim($productArr[$i]['Min_Th']);
                            if (isset($productArr[$i]['Max_Th']))
                                $Max_Th = trim($productArr[$i]['Max_Th']);
                            if (isset($productArr[$i]['Centre_Dia']))
                                $Centre_Dia = trim($productArr[$i]['Centre_Dia']);
                            if (isset($productArr[$i]['PCD']))
                                $PCD = trim($productArr[$i]['PCD']);
                            if (isset($productArr[$i]['Disc_Type']))
                                $Disc_Type = trim($productArr[$i]['Disc_Type']);
                            if (isset($productArr[$i]['Width']))
                                $Width = trim($productArr[$i]['Width']);
                            if (isset($productArr[$i]['F_R']))
                                $F_R = trim($productArr[$i]['F_R']);

                            if (isset($productArr[$i]['Category']))
                                $Category = trim($productArr[$i]['Category']);
                            if (isset($productArr[$i]['Sub_Category']))
                                $Sub_Category = trim($productArr[$i]['Sub_Category']);
                            if (isset($productArr[$i]['Rollco_Part']))
                                $Rollco_Part = trim($productArr[$i]['Rollco_Part']);
                            //if (isset($productArr[$i]['Availability']))
                            //  $Availability = trim($productArr[$i]['Availability']);
                            if (isset($productArr[$i]['TYPE']))
                                $TYPE = trim($productArr[$i]['TYPE']);
                            if (isset($productArr[$i]['POSITION']))
                                $POSITION = trim($productArr[$i]['POSITION']);
                            if (isset($productArr[$i]['Volts']))
                                $Volts = trim($productArr[$i]['Volts']);
                            if (isset($productArr[$i]['Output']))
                                $Output = trim($productArr[$i]['Output']);
                            if (isset($productArr[$i]['Pulley']))
                                $Pulley = trim($productArr[$i]['Pulley']);
                            if (isset($productArr[$i]['REGulator']))
                                $REGulator = trim($productArr[$i]['REGulator']);
                            if (isset($productArr[$i]['Fan']))
                                $Fan = trim($productArr[$i]['Fan']);
                            if (isset($productArr[$i]['Teeth']))
                                $Teeth = trim($productArr[$i]['Teeth']);
                            if (isset($productArr[$i]['GR']))
                                $GR = trim($productArr[$i]['GR']);
                            if (isset($productArr[$i]['Transmission']))
                                $Transmission = trim($productArr[$i]['Transmission']);
                            if (isset($productArr[$i]['Rotation']))
                                $Rotation = trim($productArr[$i]['Rotation']);
                            if (isset($productArr[$i]['CAR_FITS']))
                                $CAR_FITS = trim($productArr[$i]['CAR_FITS']);
                            if (isset($productArr[$i]['FUEL']))
                                $FUEL = trim($productArr[$i]['FUEL']);
                            if (isset($productArr[$i]['APPLICATION']))
                                $APPLICATION = trim($productArr[$i]['APPLICATION']);
                            if (isset($productArr[$i]['INFORMATION']))
                                $INFORMATION = trim($productArr[$i]['INFORMATION']);
                            if (isset($productArr[$i]['External_Teeth']))
                                $External_Teeth = trim($productArr[$i]['External_Teeth']);
                            if (isset($productArr[$i]['Internal_Teeth']))
                                $Internal_Teeth = trim($productArr[$i]['Internal_Teeth']);
                            if (isset($productArr[$i]['Diameter']))
                                $Diameter = trim($productArr[$i]['Diameter']);
                            if (isset($productArr[$i]['Height']))
                                $Height = trim($productArr[$i]['Height']);
                            if (isset($productArr[$i]['ABS_ring']))
                                $ABS_ring = trim($productArr[$i]['ABS_ring']);
                            if (isset($productArr[$i]['Weight']))
                                $Weight = trim($productArr[$i]['Weight']);
                            if (isset($productArr[$i]['Disc_Dia']))
                                $Disc_Dia = trim($productArr[$i]['Disc_Dia']);
                            if (isset($productArr[$i]['Disc_Thick']))
                                $Disc_Thick = trim($productArr[$i]['Disc_Thick']);
                            if (isset($productArr[$i]['Piston_Dia']))
                                $Piston_Dia = trim($productArr[$i]['Piston_Dia']);
                            if (isset($productArr[$i]['Man']))
                                $Man = trim($productArr[$i]['Man']);
                            if (isset($productArr[$i]['Pump_Type']))
                                $Pump_Type = trim($productArr[$i]['Pump_Type']);
                            if (isset($productArr[$i]['Pressure']))
                                $Pressure = trim($productArr[$i]['Pressure']);
                            if (isset($productArr[$i]['Pully_Ribs']))
                                $Pully_Ribs = trim($productArr[$i]['Pully_Ribs']);
                            if (isset($productArr[$i]['Total_Length']))
                                $Total_Length = trim($productArr[$i]['Total_Length']);

                            if (isset($productArr[$i]['Pin']))
                                $Pin = trim($productArr[$i]['Pin']);
                            if (isset($productArr[$i]['Fitting_position']))
                                $Fitting_position = trim($productArr[$i]['Fitting_position']);
                            if (isset($productArr[$i]['No_of_Holes']))
                                $No_of_Holes = trim($productArr[$i]['No_of_Holes']);
                            if (isset($productArr[$i]['Bolt_Hole_Circle_Dia']))
                                $Bolt_Hole_Circle_Dia = trim($productArr[$i]['Bolt_Hole_Circle_Dia']);
                            if (isset($productArr[$i]['Inner_Dia']))
                                $Inner_Dia = trim($productArr[$i]['Inner_Dia']);
                            if (isset($productArr[$i]['Outer_Dia']))
                                $Outer_Dia = trim($productArr[$i]['Outer_Dia']);


//$prod_stock=0;
//if($Availability=='In Stock'){
//$prod_stock=1;
//}
                            // $prod_stock = 1;
                            // $prod_price = 0;
                            // $is_latest = 1;
//print_r($productArr);
//echo 'CATEGORY::'.$Category;
//echo '<br/>SUB_CATEGORY::'.$Sub_Category;
//echo '<br/>ROLLCO_PART::'.$Rollco_Part;
//echo '<br/>MAKE::'.$MAKE;
//echo '<br/>MODEL::'.$MODEL;
//echo '<br/>YEAR::'.$YEAR;
//exit;
							$Category = remove_accents($Category);
							$Category = remove_accents($Category);
							$Sub_Category = remove_accents($Sub_Category);
							$Rollco_Part = remove_accents($Rollco_Part);
							$TYPE = remove_accents($TYPE);
							$POSITION = remove_accents($POSITION);
							$Volts = remove_accents($Volts);
							$Output = remove_accents($Output);
							$Pulley = remove_accents($Pulley);
							$REGulator = remove_accents($REGulator);
							$Fan = remove_accents($Fan);
							$Teeth = remove_accents($Teeth);
							$GR = remove_accents($GR);
							$Transmission = remove_accents($Transmission);
							$Rotation = remove_accents($Rotation);
							$CAR_FITS = remove_accents($CAR_FITS);
							$FUEL = remove_accents($FUEL);
							$APPLICATION = remove_accents($APPLICATION);
							$INFORMATION = remove_accents($INFORMATION);
							$External_Teeth = remove_accents($External_Teeth);
							$Internal_Teeth = remove_accents($Internal_Teeth);
							$Diameter = remove_accents($Diameter);
							$Height = remove_accents($Height);
							$ABS_ring = remove_accents($ABS_ring);
							$Weight = remove_accents($Weight);
							$Disc_Dia = remove_accents($Disc_Dia);
							$Disc_Thick = remove_accents($Disc_Thick);
							$Piston_Dia = remove_accents($Piston_Dia);
							$Man = remove_accents($Man);
							$Pump_Type = remove_accents($Pump_Type);
							$Pressure = remove_accents($Pressure);
							$Pully_Ribs = remove_accents($Pully_Ribs);
							$Total_Length = remove_accents($Total_Length);
							$Pin = remove_accents($Pin);
							$Fitting_position = remove_accents($Fitting_position);
							$No_of_Holes = remove_accents($No_of_Holes);
							$Bolt_Hole_Circle_Dia = remove_accents($Bolt_Hole_Circle_Dia);
							$Inner_Dia = remove_accents($Inner_Dia);
							$Outer_Dia = remove_accents($Outer_Dia);
							$Teeth_wheel_side = remove_accents($Teeth_wheel_side);

							$Teeth_Diff_Side = remove_accents($Teeth_Diff_Side);
							$Min_Th = remove_accents($Min_Th);
							$Max_Th = remove_accents($Max_Th);
							$Centre_Dia = remove_accents($Centre_Dia);
							$PCD = remove_accents($PCD);
							$Disc_Type = remove_accents($Disc_Type);
							$Width = remove_accents($Width);
							$F_R = remove_accents($F_R);
							
                            if ($Category != '' && $Sub_Category != '' && $Rollco_Part != '') {
                                $mcat_id = 0;
                                if ($Category != '') {
                                    $mcatres = MCategory::Where('mcat_nm',
                                                    $Category)->first();
                                    $mcat_id = $mcatres['mcat_id'];
                                }

                                $cat_id = 0;
                                if ($Sub_Category != '') {
                                    $catres = Category::select('cat_id')->Where('cat_nm',
                                                    $Sub_Category)
                                            ->Where('mcatid', $mcat_id)
                                            ->first();
                                    $cat_id = $catres['cat_id'];
                                }

                                if ($mcat_id > 0 && $cat_id > 0 && $Rollco_Part != '') {
                                    $changed_data = array('prod_volt' => $Volts,
                                        'prod_out' => $Output, 'prod_regu' => $REGulator,
                                        'prod_pull_type' => $Pulley, 'prod_fan' => $Fan,
                                        'prod_add_inf' => $INFORMATION,
                                        'prod_teeth' => $Teeth, 'prod_trans' => $Transmission,
                                        'prod_rot' => $Rotation, 'prod_dim' => $Diameter,
                                        'ptype' => $TYPE, 'position' => $POSITION,
                                        'gr' => $GR, 'car_fits' => $CAR_FITS, 'fuel' => $FUEL,
                                        'external_teeth' => $External_Teeth, 'internal_teeth' => $Internal_Teeth,
                                        'height' => $Height, 'abs_ring' => $ABS_ring, 'Weight' => $Weight,
                                        'Disc_Dia' => $Disc_Dia, 'Disc_Thick' => $Disc_Thick, 'Piston_Dia' => $Piston_Dia,
                                        'Man' => $Man, 'Pump_Type' => $Pump_Type, 'Pressure' => $Pressure, 'Pully_Ribs' => $Pully_Ribs,
                                        'Total_Length' => $Total_Length, 'Pin' => $Pin, 'Fitting_position' => $Fitting_position,
                                        'No_of_Holes' => $No_of_Holes, 'Bolt_Hole_Circle_Dia' => $Bolt_Hole_Circle_Dia,
                                        'Inner_Dia' => $Inner_Dia, 'Outer_Dia' => $Outer_Dia, 'Teeth_wheel_side' => $Teeth_wheel_side,
                                        'Teeth_Diff_Side' => $Teeth_Diff_Side,'Min_Th' => $Min_Th,'Max_Th' => $Max_Th,'Centre_Dia' => $Centre_Dia,'PCD' => $PCD,'Disc_Type' => $Disc_Type,'Width' => $Width,'F_R' => $F_R);
                                    //dd($changed_data);
                                                                                                           
                                    $update = Product::Where('prod_part_no',
                                                    $Rollco_Part)->update($changed_data);
                                    //dd($update);
                                }
                            } else {
                                return redirect()->back()->withErrors(['message', 'required fields are empty']);
                            }
                        }
                        return redirect()->back()->with('message',
                                        'Products
successfully uploaded.');
                    } else {
                        return redirect()->back()->withErrors(['message', 'file format is not csv']);
                    }
                }
            } else {
                return redirect()->back()->withErrors(['message', 'file format is not csv']);
            }
            return view('admin.product.uploadspearoem');
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /* function exportToExcelProduct() {
      $exporter = app()->makeWith(ProductExport::class);
      return $exporter->download(date('Y-m-d-H-i-s') . '-product.xlsx');
      } */

    // upload product bulk image

    function bulkProductImageUpload(Request $request) {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $flag = 0;
            if (isset($request->imagesubmit) && $request->imagesubmit == 1) {
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
                        $dd =File::deleteDirectory(public_path('/upload/testzip/'));
                    
                        Zipper::make($Path1)->extractTo(public_path('/upload/testzip/'));

                        $filesInFolder = File::files(public_path('/upload/testzip/'));
//dd($filesInFolder);
                        $imgType = 0;
                        //dd($filesInFolder);
                        foreach ($filesInFolder as $path) {

                            //if (Image::make($path)->width() == 400 && Image::make($path)->height() == 300) {
                            $file = pathinfo($path);
                            $prodName = implode('-', explode('-', $file['filename'], -1));
                            $imgName = explode('-', $file['filename']);
                            $imgType = end($imgName);

                            //dd(count($imgName));
                            if (count($imgName) > 1) {
                                
                            } else {
                                return redirect()->back()->withErrors(['message', 'file name format is not correct']);
                            }

                            if ($file['extension'] == 'png' || $file['extension'] == 'jpg' || $file['extension'] == 'jpeg' || $file['extension'] == 'PNG' || $file['extension'] == 'JPG' || $file['extension'] == 'JPEG') {
                                
                            } else {
                                return redirect()->back()->withErrors(['message', 'file name extension is not png/jpg/jpeg']);
                            }


                            if ($imgType == '1') {
                                $imgCol = "prod_img1";
                            } elseif ($imgType == '2') {
                                $imgCol = "prod_img2";
                            } elseif ($imgType == '3') {
                                $imgCol = "prod_img3";
                            } elseif ($imgType == '4') {
                                $imgCol = "prod_img4";
                            } elseif ($imgType == '5') {
                                $imgCol = "prod_img5";
                            } elseif ($imgType == '6') {
                                $imgCol = "prod_img6";
                            } elseif ($imgType == '7') {
                                $imgCol = "prod_img7";
                            } elseif ($imgType == '8') {
                                $imgCol = "prod_img8";
                            } else {
                                $imgCol = "prod_img1";
                            }

                            $changed_data = array($imgCol => $file['filename'] . "." . $file['extension'],
                                'updated_at' => date("Y-m-d H:i:s"));
                            
                            //dd($changed_data);

                            File::delete(public_path('/upload/product/' . $file['filename'] . "." . $file['extension']));
                            
                            $move = File::move(public_path('/upload/testzip/' . $file['filename'] . "." . $file['extension']),
                                            public_path('/upload/product/' . $file['filename'] . "." . $file['extension']));
                            $updatePro = Product::where('prod_part_no', $prodName)->update($changed_data);
                          
                            $flag = 1;
                            /* } else {
                              return redirect()->back()->with('message',
                              'Product images are not of specified height and width i.e 640X300 ');
                              } */
                        }

                        //echo $updatePro;die;
                        if ($flag) {
                            return redirect()->back()->with('message',
                                            'Product images uploaded successfully');
                        } else {

                            return redirect()->back()->withErrors(['message', 'Error: Product images could not uploaded']);
                        }
                    }
                }
            } else {
                return view('admin.product.upload-bulkproduct-image');
            }
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function DeleteApplication($id) {
        $data = Application::where('ap_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(),
            'table_used' => 'rollco_ms_application',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())),
            'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_application')->where('ap_id',
                        base64_decode($id))->delete();
        if ($status) {
            return redirect()->back()->with('message',
                            'Application successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'Error while deleting application');
        }
    }

    function exportToExcelApplication() {
        $exporter = app()->makeWith(ApplicationExport::class);
        return $exporter->download(date('Y-m-d-H-i-s') . '-application.xlsx');
    }

    public function exportToExcelProduct(Request $request) {

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . date('Y-m-d-H-i-s') . "-products.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $query = DB::table('rollco_ms_product as prod')
                ->select('prod.catid', 'prod.makeid', 'prod.modelid', 'prod.proyrid',
                'prod.proccmid', 'prod.engid', 'prod.prod_part_no'
        ); //'mscode.MsCode', 'mscode.V8Key'

        /* $query = $query->join('rollco_ms_cat as cat',
          'cat.cat_id', '=', 'prod.catid');
          $query = $query->join('rollco_ms_make as make',
          'make.make_id', '=', 'prod.makeid');
          $query = $query->join('rollco_ms_model as model',
          'model.model_id', '=', 'prod.modelid');
          $query = $query->leftjoin('rollco_ms_proyr as proyr',
          'proyr.proyr_id', '=', 'prod.proyrid');
          $query = $query->leftjoin('rollco_ms_proccm as proccm',
          'proccm.proccm_id', '=', 'prod.proccmid');
          $query = $query->leftjoin('rollco_ms_engcode as engcode',
          'engcode.engcode_id', '=', 'prod.engid');
          $query = $query->leftjoin('rollco_ms_mscode as mscode',
          'mscode.part_no', '=', 'prod.prod_part_no'); */


        if (!empty($request->search)) {
            $search = $request->search;

            $query = $query->where(function($query) use ($search) {
                $query->where('prod.prod_part_no', 'LIKE', '%' . $search . '%');
            });
        }


        $reqData = $query->orderBy('prod.created_at', 'DESC')
                ->get();
        //debug($reqData[0]);
        $columns = array("Category", "Make", "Model", "Year", "CCM", "Engine Code", "Product", "Mscode", "V8Key");

        $callback = function() use ($reqData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            //dd($reqData);

            foreach ($reqData as $review) {
                $mscode = '';
                $v8key = '';
                $msinfo = getMsInfo($review->prod_part_no);
                if (isset($msinfo)) {
                    if (isset($msinfo->MsCode) && $msinfo->MsCode != '') {
                        $mscode = $msinfo->MsCode;
                    }
                    if (isset($msinfo->V8Key) && $msinfo->V8Key != '') {
                        $v8key = $msinfo->V8Key;
                    }
                }
                fputcsv($file, array(getCatName($review->catid), getMakeName($review->makeid), getModelName($review->modelid),
                    getProYear($review->proyrid),
                    getProCCM($review->proccmid), getEngineCode($review->engid), $review->prod_part_no, $mscode, $v8key));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
        //return Response::stream($callback, 200, $headers);
    }

    public function uploadproductsstock() {

        if (Auth::guard('admin')->user()->admin_role == 1) {
            if (Input::hasFile('productsstatus_file')) {
                $file = Input::file('productsstatus_file');
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
                    //dd($productArr);
                    for ($i = 0; $i < count($productArr); $i++) {
                        $prdata = [];

                        $part_no = '';
                        $stock_info = '';

                        if (isset($productArr[$i]['part_no']))
                            $part_no = trim($productArr[$i]['part_no']);
                        if (isset($productArr[$i]['stock_info']))
                            $stock_info = trim($productArr[$i]['stock_info']);

                        $prod_stock = 1;
                        if ($stock_info == 'Not in Stock') {
                            $prod_stock = 0;
                        }
						
						$part_no = remove_accents($part_no);
						$stock_info = remove_accents($stock_info);
						

                        if ($part_no != '' && $stock_info != '') {
                            $changed_data = array('prod_stock' => $prod_stock);
                            //dd($changed_data);
                            $update = Product::Where('prod_part_no',
                                            $part_no)->update($changed_data);
                        }
                    }
                    return redirect()->back()->with('message',
                                    'Product Stock information has been updated.');
                } else {
                    return redirect()->back()->withErrors(['message', 'file format is not csv']);
                }
            } else {
                return view('admin.product.upload-productstatus');
            }
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function ProductDesc(Request $request) {
        $page_val = 50;
        $pagination_arr = array(50, 100);
        if (Auth::guard('admin')->user()->admin_role == 1) {

            $query = Product::query();

            if (!empty($request->search)) {
                $search = $request->search;

                $query = $query->where(function($query) use ($search) {
                    $query->where('prod_part_no', 'LIKE', '%' . $search . '%');
                    $query->orWhere('prod_nm', 'LIKE', '%' . $search . '%');
//                $query->orWhere('spare_nm', 'LIKE', '%' . $search . '%');
//                $query->orWhere('spare_make', 'LIKE', '%' . $search . '%');
                });
            }
            if (!empty($request->data_entries)) {
                $page_val = $request->data_entries;
            }
            $pageData = $query->orderby('prod_nm', 'ASC')
                    ->groupBy('prod_nm')
                    ->paginate($page_val)
                    ->withPath('?search=' . $request->search.'&data_entries='.$page_val);


            $mcategoryData = MCategory::orderBy('mcat_nm', 'ASC')->get();
//            $data = Product::orderBy('created_at', 'DESC')->get();
            return view('admin.product.manage-productdesc',
                    array('data' => $pageData, 'mcategory' => $mcategoryData, 'data_entries' => $page_val,
                        'pagination_arr' => $pagination_arr));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function GetProductDescData(Request $request) {
        $cat = Product::Where('prod_nm', base64_decode($request->id))->first();
        $prodstatus = Product::Where('prod_nm', base64_decode($request->id))
                ->Where('prod_status', 1)
                ->first();
        if (isset($prodstatus)) {
            $cat['prod_status'] = $prodstatus['prod_status'];
        }
        echo json_encode($cat);
    }

    public function EditProductDesc(Request $request) {

        $max = 7;
        $validation = Validator::make($request->all(),
                        [
                            'prod_nm' => 'required',
                            'prod_part_no' => 'required',
                            //'prod_desc' => 'required',
                            'prod_stock' => 'required',
                            'prod_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('prod_nm', 'prod_part_no'));
        }

        $prod_part_no = $request->prod_part_no;

        $data = Product::where('prod_nm', $request->prod_name)->first();

        $changed_data = array(
            'prod_nm' => $request->prod_nm,
            'prod_part_no' => $request->prod_part_no,
            'prod_desc' => $request->prod_desc,
            'prod_volt' => $request->prod_volt,
            'prod_out' => $request->prod_out,
            'prod_regu' => $request->prod_regu,
            'prod_pull_type' => $request->prod_pull_type,
            'prod_fan' => $request->prod_fan,
            'prod_stock' => $request->prod_stock,
            'prod_add_inf' => $request->prod_add_inf,
            'prod_teeth' => $request->prod_teeth,
            'prod_trans' => $request->prod_trans,
            'prod_rot' => $request->prod_rot,
            'prod_dim' => $request->prod_dim,
            'prod_price' => $request->prod_price,
            'prod_status' => $request->prod_status,
            'is_latest' => $request->is_latest,
            'ptype' => $request->ptype,
            'position' => $request->position,
            'gr' => $request->gr,
            'car_fits' => $request->car_fits,
            'fuel' => $request->fuel,
            'external_teeth' => $request->external_teeth,
            'internal_teeth' => $request->internal_teeth,
            'height' => $request->height,
            'abs_ring' => $request->abs_ring,
            'mscode' => $request->mscode,
            'cylinders' => $request->cylinders,
            'Weight' => $request->Weight,
            'Disc_Dia' => $request->Disc_Dia,
            'Disc_Thick' => $request->Disc_Thick,
            'Piston_Dia' => $request->Piston_Dia,
            'Man' => $request->Man,
            'Pump_Type' => $request->Pump_Type,
            'Pressure' => $request->Pressure,
            'Pully_Ribs' => $request->Pully_Ribs,
            'Total_Length' => $request->Total_Length,
            'Pin' => $request->Pin,
            'Fitting_position' => $request->Fitting_position,
            'No_of_Holes' => $request->No_of_Holes,
            'Bolt_Hole_Circle_Dia' => $request->Bolt_Hole_Circle_Dia,
            'Inner_Dia' => $request->Inner_Dia,
            'Outer_Dia' => $request->Outer_Dia,
            'Teeth_wheel_side' => $request->Teeth_wheel_side,
            'Min_Th' => $request->Min_Th,
            'Max_Th' => $request->Max_Th,
            'Centre_Dia' => $request->Centre_Dia,
            'PCD' => $request->PCD,
            'Disc_Type' => $request->Disc_Type,
            'Width' => $request->Width,
            'F_R' => $request->F_R,
            'prod_overview' => $request->prod_overview,
        );

        $diff_in_data = array_diff_assoc($data->getOriginal(), $changed_data);

        $keys_to_be_updated = array_keys($diff_in_data);
        $diff_in_data_to_save = array();
        $data_to_update = array();


        for ($i = 0; $i < count($keys_to_be_updated); $i++) {
            if (isset($changed_data[$keys_to_be_updated[$i]])) {
                $data_to_update[$keys_to_be_updated[$i]] = $changed_data[$keys_to_be_updated[$i]];
                $diff_in_data_to_save[$keys_to_be_updated[$i]] = $diff_in_data[$keys_to_be_updated[$i]];
            }
        }
        $logData = array('subject_id' => $request->prod_name, 'user_id' => Auth::id(),
            'table_used' => 'rollco_ms_product',
            'description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)),
            'data_now' => urldecode(http_build_query($data_to_update))
        );
        saveQueryLog($logData);
        $updateSubCat = Product::where('prod_nm', $request->prod_name)->update($changed_data);
        if ($updateSubCat) {
            return redirect()->back()->with('message',
                            'Product Description successfully updated');
        } else {
            return redirect()->back()->with('message',
                            'Error while updating product');
        }
    }

    public function exportToExcelMsCode(Request $request) {

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . date('Y-m-d-H-i-s') . "-mscode.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $query = DB::table('rollco_ms_mscode as mscode')
                ->select('mscode.part_no', 'mscode.V8Key'); //'mscode.MsCode', 'mscode.V8Key'



        $reqData = $query->orderBy('mscode.part_no', 'ASC')
                ->get();
        //debug($reqData[0]);
        $columns = array("Part Number", "V8Key");

        $callback = function() use ($reqData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            //dd($reqData);

            foreach ($reqData as $review) {

                fputcsv($file, array($review->part_no, $review->V8Key));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
        //return Response::stream($callback, 200, $headers);
    }


    public function DeleteMscode($id) {
        $data = Mscode::where('ms_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(),
            'table_used' => 'rollco_ms_mscode',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())),
            'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_mscode')->where('ms_id',
                        base64_decode($id))->delete();
        if ($status) {
            return redirect()->back()->with('message',
                            'Mscode successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'Error while deleting mscode');
        }
    }
	public function DeleteApplicationAjax(Request $request) {

		$status = DB::table('rollco_ms_application')->whereIn('ap_id',
						$request['ids'])->delete();
		if ($status) {
			echo 1;
		} else {
			echo 0;
		}
    }
	
	public function DeleteProductImage($productname) {
        $data = Product::where('prod_nm', '=', base64_decode($productname))->first();

        $logData = array('subject_id' => base64_decode($productname), 'user_id' => Auth::id(),
            'table_used' => 'rollco_ms_product', 'description' => 'remove image', 'data_prev' => urldecode(http_build_query($data->toArray())),
            'data_now' => '');

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_product')->where('prod_nm',
                        base64_decode($productname))->update(array('prod_img1' => '', 'prod_img2' => '', 'prod_img3' => '', 'prod_img4' => '', 'prod_img5' => '', 'prod_img6' => '', 'prod_img7' => '', 'prod_img8' => ''));
        if ($status) {
            return  redirect()->back()->with('message',
                            'Product Image successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'error while deleting Product image');
        }
    }
	
	public function DeleteProductImageSingle(request $request) {
		
            $getProductData = DB::table('rollco_ms_product')->select('prod_img'.$request->img)->where('prod_nm',$request->imgname)->first();
            //dd($getProductData);
            File::delete(public_path('/upload/product/' . $request->imgname));
		$status = DB::table('rollco_ms_product')->where('prod_nm',
                        $request->imgname)->update(array('prod_img'.$request->img => ''));
        if ($status) {
			echo 1;
		} else {
			echo 0;
		}
	}
	
}
