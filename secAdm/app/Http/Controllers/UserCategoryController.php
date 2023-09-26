<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\Modal\Usercategory;
use App\Exports\CustomerCatExport;

class UserCategoryController extends Controller {
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
    public function AddNewUserCategory(Request $request) {

        $validation = Validator::make($request->all(),
                        [
                    'cust_cat_nme' => 'required',
                    'cust_cat_info' => 'required',
                    'cust_cat_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('cust_cat_nme',
                                    'cust_cat_status'));
        }

        $name = $request->cust_cat_nme;

        $status = Usercategory::where('cust_cat_nme', $name)
                ->first();

        if ($status) {
            return redirect()->back()->withErrors(['message', 'category name already exists']);
        } else {

            $id = Usercategory::create($request->all())->id;
            $logData = array('subject_id' => $id, 'user_id' => Auth::id(), 'table_used' => 'rollco_cust_cat',
                'description' => 'insert', 'data_prev' => '', 'data_now' => urldecode(http_build_query($request->all()))
            );
            saveQueryLog($logData);
            if ($id) {
                return redirect()->back()->with('message',
                                'User category successfully created');
            } else {
                return redirect()->back()->with('message',
                                'Error while creating user category');
            }
        }
    }

    /*

     * View customers 
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function UserCategories() {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $data = [];
            $data = Usercategory::orderBy('cust_cat_id', 'ASC')->get();
            return view('admin.customer.view-customer-category',
                    array('data' => $data));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function EditUserCategory(Request $request) {

        $validation = Validator::make($request->all(),
                        [
                    'cust_cat_nme' => 'required',
                    'cust_cat_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('cust_cat_nme',
                                    'cust_cat_status'));
        }

        $name = $request->cust_cat_nme;

        $status = Usercategory::where('cust_cat_nme', $request->cust_cat_nme)
                ->where('cust_cat_id', '!=', $request->cust_cat_id)
                ->first();
        if ($status) {
            return redirect()->back()->withErrors(['message', 'User category already exists']);
        } else {
            $data = Usercategory::Where('cust_cat_id', $request->cust_cat_id)->first();
            //dd($data);

            $changed_data = array('cust_cat_nme' => $request->cust_cat_nme,
                'cust_cat_status' => $request->cust_cat_status,
                'cust_cat_info' => $request->cust_cat_info
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
            $logData = array('subject_id' => $request->cust_cat_id, 'user_id' => Auth::id(),
                'table_used' => 'rollco_cust_cat',
                'description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)),
                'data_now' => urldecode(http_build_query($changed_data))
            );
            //dd($logData);
            saveQueryLog($logData);
            $updateCat = Usercategory::Where('cust_cat_id',
                            $request->cust_cat_id)->update($changed_data);
            if ($updateCat) {
                return redirect('admin/view-usercategory')->with('message',
                                'User category successfully updated');
            } else {
                return redirect()->back()->with('message',
                                'Error while updating user category');
            }
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function DeleteUserCategory($id) {

        $data = Usercategory::where('cust_cat_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(),
            'table_used' => 'rollco_cust_cat',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())),
            'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_cust_cat')->where('cust_cat_id',
                        base64_decode($id))->delete();
        if ($status) {
            return redirect('admin/view-usercategory')->with('message',
                            'User category successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'Error while deleting user category');
        }
    }

    public function GetUserCategoryData(Request $request) {
        $cat = Usercategory::Where('cust_cat_id', base64_decode($request->id))->first();
        $data = array(
            'cust_cat_id' => $cat['cust_cat_id'],
            'cust_cat_nme' => $cat['cust_cat_nme'],
            'cust_cat_info' => $cat['cust_cat_info'],
            'cust_cat_status' => $cat['cust_cat_status'],
        );
        echo json_encode($data);
    }

    public function exportToExcelCustomerCat() {
        $exporter = app()->makeWith(CustomerCatExport::class);
        return $exporter->download(date('Y-m-d-H-i-s') . '-customercategory.xlsx');
    }

}
