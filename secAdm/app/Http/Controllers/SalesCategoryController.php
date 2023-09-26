<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\Modal\SalesCategory;


class SalesCategoryController extends Controller {
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
    public function AddNewSalesCategory(Request $request) {
        $data = [];
        $validation = Validator::make($request->all(), [
                    'scat_nm' => 'required',
                    'scat_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only( 'scat_nm', 'scat_status'));
        }

        $name = $request->scat_nm;

        $status = SalesCategory::where('scat_nm', $name)
                ->first();

        if ($status) {
            return redirect()->back()->withErrors(['message', 'SalesCategory already exists']);
        } else {


            $dataToSave = array('scat_nm' => $request->scat_nm,'scat_status' => $request->scat_status,
            );
            $id = SalesCategory::create($dataToSave)->id;
            $logData = array('subject_id' => $id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_salescat',
                'description' => 'insert', 'data_prev' => '', 'data_now' => urldecode(http_build_query($dataToSave))
            );
            saveQueryLog($logData);
            if ($id) {
                
                return redirect()->back()->with('message', 'SalesCategory successfully created');
            } else {
                return redirect()->back()->with('message', 'Error while creating category');
            }
        }

    }

    /*

     * View customers 
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function SalesCategories() {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $data = SalesCategory::orderBy('created_at', 'DESC')->get();
            return view('admin.sales.view-salescategories', array('data' => $data));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function EditSalesCategory(Request $request) {
//dd($request->all());
        $validation = Validator::make($request->all(), [
                    'scat_nm' => 'required',
                    'scat_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only( 'scat_nm', 'scat_status'));
        }
        $name = $request->scat_nm;

        $status = SalesCategory::where('scat_nm', $name)
                ->where('sc_id', '!=', $request->sc_id)
                ->first();
        if ($status) {
            return redirect()->back()->withErrors(['message', 'SalesCategory already exists']);
        } else {
            $data = SalesCategory::Where('sc_id', $request->sc_id)->first();
            //dd($data);
            
            $changed_data = array('scat_nm' => $request->scat_nm,
                'scat_status' => $request->scat_status
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
            $logData = array('subject_id' => $request->sc_id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_salescat',
                'description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)), 'data_now' => urldecode(http_build_query($changed_data))
            );
            //dd($logData);
            saveQueryLog($logData);
            $updateCat = SalesCategory::Where('sc_id', $request->sc_id)->update($changed_data);
            if ($updateCat) {
                return redirect()->back()->with('message', 'SalesCategory successfully updated');
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

    public function DeleteSalesCategory($id) {
        $data = SalesCategory::where('sc_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_salescat',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())), 'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_salescat')->where('sc_id', base64_decode($id))->delete();
        if ($status) {
            return redirect()->back()->with('message', 'sales category successfully deleted');
        } else {
            return redirect()->back()->with('message', 'error while deleting category');
        }
    }

    public function GetSalesCategoryData(Request $request) {
        $cat = SalesCategory::Where('sc_id', base64_decode($request->id))->first();
        echo json_encode($cat);
    }
    
}
