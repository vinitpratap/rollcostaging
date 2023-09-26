<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\Modal\MCategory;

class MCategoryController extends Controller {
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
    public function AddNewMCategory(Request $request) {
        $data = [];
        $validation = Validator::make($request->all(), [
                    'mcat_nm' => 'required',
                    'mcat_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('mcat_nm', 'mcat_status'));
        }

        $name = $request->mcat_nm;

        $status = MCategory::where('mcat_nm', $name)
                ->first();

        if ($status) {
            return redirect()->back()->withErrors(['message', 'Master Category already exists']);
        } else {


            $dataToSave = array('mcat_nm' => $request->mcat_nm,
                'mcat_status' => $request->mcat_status,
            );
            $id = MCategory::create($dataToSave)->id;
            $logData = array('subject_id' => $id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_mcat',
                'description' => 'insert', 'data_prev' => '', 'data_now' => urldecode(http_build_query($dataToSave))
            );
            saveQueryLog($logData);
            if ($id) {
                
                if ($request->hasFile('mcat_image')) {
                    
                    
                    $image = $request->file('mcat_image');
                    $ser_img = time() . $image->getClientOriginalName();
                    $ser_img = preg_replace("/[^\.\-\_a-zA-Z0-9]/", "", $ser_img);
                    $destinationPath = public_path('/upload/product/');
                    $valImage = validateImage($image->getClientOriginalExtension());
                    if ($valImage) {
//                        $image_resize1 = Image::make($image->getRealPath());
//                        $image_resize1->resize(300, 300);
//                        $image_resize1->save(public_path('/upload/product/th/' . $ser_img));

//                        $image_resize2 = Image::make($image->getRealPath());
//                        $image_resize2->resize(250, 250);
//                        $image_resize2->save(public_path('/upload/product/thm/' . $ser_img));
                        $image->move($destinationPath, $ser_img);
                        copy($destinationPath . $ser_img, public_path('/upload/mcat/thm/') . $ser_img);
                        copy($destinationPath . $ser_img, public_path('/upload/mcat/th/') . $ser_img);
                    } else if ($image->getClientOriginalExtension() == 'svg') {
                        $image->move($destinationPath, $ser_img);
                        copy($destinationPath . $ser_img, public_path('/upload/mcat/thm/') . $ser_img);
                        copy($destinationPath . $ser_img, public_path('/upload/mcat/th/') . $ser_img);
                    } else {
                        return redirect()->back()->withErrors(['message', 'file format is not image']);
                    }
                    $image_update = array('mcat_image' => $ser_img);
                    MCategory::where('mcat_id', $id)->update($image_update);
                }
                return redirect()->back()->with('message', 'Master Category successfully created');
            } else {
                return redirect()->back()->with('message', 'Error while creating category');
            }
        }

        return view('admin.mcategory.add-new-mcategory', array('data' => $data));
    }

    /*

     * View customers 
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function MCategories() {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $data = [];
            $data = MCategory::orderBy('created_at', 'DESC')->get();
            return view('admin.mcategory.view-mcategories', array('data' => $data));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function EditMCategory(Request $request) {

        $validation = Validator::make($request->all(), [
                    'mcat_nm' => 'required',
                    'mcat_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('mcat_nm', 'mcat_status'));
        }
        $name = $request->mcat_nm;

        $status = MCategory::where('mcat_nm', $name)
                ->where('mcat_id', '!=', $request->mcat_id)
                ->first();

        if ($status) {
            return redirect()->back()->withErrors(['message', 'Master Category already exists']);
        } else {
            $data = MCategory::Where('mcat_id', $request->mcat_id)->first();
//            dd($data);
            
            $changed_data = array('mcat_nm' => $request->mcat_nm,
                'mcat_status' => $request->mcat_status,
            );

            $diff_in_data = array_diff_assoc($data->getOriginal(), $changed_data);
            $diff_in_data_to_save = array();
            $keys_to_be_updated = array_keys($diff_in_data);

            for ($i = 0; $i < count($keys_to_be_updated); $i++) {
                if (isset($changed_data[$keys_to_be_updated[$i]])) {
                    $data_to_update[$keys_to_be_updated[$i]] = $changed_data[$keys_to_be_updated[$i]];
                    $diff_in_data_to_save[$keys_to_be_updated[$i]] = $diff_in_data[$keys_to_be_updated[$i]];
                }
            }
            $logData = array('subject_id' => $request->mcat_id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_mcat',
                'description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)), 'data_now' => urldecode(http_build_query($changed_data))
            );
            //dd($logData);
            saveQueryLog($logData);
            $updateCat = MCategory::Where('mcat_id', $request->mcat_id)->update($changed_data);
            
            if ($request->hasFile('mcat_image')) {                
                    $image = $request->file('mcat_image');
                    $ser_img = time() . $image->getClientOriginalName();
                    $ser_img = preg_replace("/[^\.\-\_a-zA-Z0-9]/", "", $ser_img);
                    $destinationPath = public_path('/upload/product/');
                    $valImage = validateImage($image->getClientOriginalExtension());
                    if ($valImage) {
//                        $image_resize1 = Image::make($image->getRealPath());
//                        $image_resize1->resize(300, 300);
//                        $image_resize1->save(public_path('/upload/product/th/' . $ser_img));

//                        $image_resize2 = Image::make($image->getRealPath());
//                        $image_resize2->resize(250, 250);
//                        $image_resize2->save(public_path('/upload/product/thm/' . $ser_img));
                        $image->move($destinationPath, $ser_img);
                        copy($destinationPath . $ser_img, public_path('/upload/mcat/thm/') . $ser_img);
                        copy($destinationPath . $ser_img, public_path('/upload/product/th/') . $ser_img);
                    } else if ($image->getClientOriginalExtension() == 'svg') {
                        $image->move($destinationPath, $ser_img);
                        copy($destinationPath . $ser_img, public_path('/upload/mcat/thm/') . $ser_img);
                        copy($destinationPath . $ser_img, public_path('/upload/mcat/th/') . $ser_img);
                    } else {
                        return redirect()->back()->withErrors(['message', 'file format is not image']);
                    }
                    $image_update = array('mcat_image' => $ser_img);
                    MCategory::where('mcat_id', $request->mcat_id)->update($image_update);
                }
            
            if ($updateCat) {
                return redirect('admin/view-mcategory')->with('message', 'Master Category successfully updated');
            } else {
                return redirect()->back()->with('message', 'Error while updating category');
            }
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function DeleteMCategory($id) {
        $data = MCategory::where('mcat_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_mcat',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())), 'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_mcat')->where('mcat_id', base64_decode($id))->delete();
        if ($status) {
            return redirect('admin/view-mcategory')->with('message', 'category successfully deleted');
        } else {
            return redirect()->back()->with('message', 'error while deleting category');
        }
    }

    public function GetMCategoryData(Request $request) {
        $cat = MCategory::Where('mcat_id', base64_decode($request->id))->first();
        $data = array(
            'mcat_id' => $cat['mcat_id'],
            'mcat_nm' => $cat['mcat_nm'],
            'mcat_image' => $cat['mcat_image'],
            'mcat_status' => $cat['mcat_status'],
        );
        echo json_encode($data);
    }

}
