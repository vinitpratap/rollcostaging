<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Hash;
use App\Modal\Admin;
use App\Modal\Customer;
use Mail;

class SubAdminController extends Controller {
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
    public function ChangePassword(Request $request) {
        if ($request->submit == 1) {
            $validation = Validator::make($request->all(), [
                        'old_password' => 'required|min:6',
                        'new_password' => 'required|min:6',
                        'cnf_password' => 'required|min:6',
                            //'confirm_password'  => 'required|min:6',          
            ]);
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput($request->only('old_password'));
            }
            $user = Admin::Where('id', Auth::guard('admin')->user()->id)->first();
            if ($request->new_password == $request->cnf_password) {
                if (Hash::check($request->old_password, $user->password)) {

                    $hashed = Hash::make($request->new_password);
                    $user->password = $hashed;
                    $user->save();
                    return redirect()->back()->with('message', 'Password changed successfully.');
                } else {
                    return redirect()->back()->withErrors(['Your current password is wrong.'])->withInput($request->only('old_password'));
                }
            } else {
                return redirect()->back()->withErrors(['Your confirm password is wrong.'])->withInput($request->only('old_password'));
            }
        }
        return view('admin.change-password');
    }

    public function SubAdminAvailability() {
        $data = Customer::select('u_id', 'firstName', 'lastName', 'com_emailAddress', 'com_Telephone', 'created_at', 'user_status')->where('cust_type', 3)->orderBy('created_at', 'DESC')->get();

        return view('admin.subadmin.subAdmin-availability', array('data' => $data));
    }

    public function AddNewSubAdmin(Request $request) {

        $prefix = 'SALES';
        $validation = Validator::make($request->all(), [
                    'user_name' => 'required',
                    'email' => 'required|email',
                    //'mobile' => 'required|min:10',
                    'status' => 'required'
        ]);


        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('user_name', 'email', 'mobile', 'center_id', 'status'));
        }

        $mobile = $request->mobile;
        $email = $request->email;
//        $query = Admin::query();
//        $query = $query->where(function($query) use ($mobile, $email) {
//            $query->orWhere('email', $email);
//            $query->orWhere('mobile', $mobile);
//        });
//
//        $status = $query->first();


        $query = Customer::query();
        $query = $query->where(function($query) use ($mobile, $email) {
            $query->orWhere('com_emailAddress', $email);
           // $query->orWhere('com_Telephone', $mobile);
        });
		$query = $query->where('cust_type', 3);
        $status1 = $query->first();
		
		
		$query1 = Customer::query();
        $query1 = $query1->where(function($query1) use ($mobile, $email) {
            $query1->orWhere('com_emailAddress', $email);
           // $query->orWhere('com_Telephone', $mobile);
        });
		$query1 = $query1->where('cust_type', 1);
        $status2 = $query1->first();
		
		if ($status2) {
            return redirect()->back()->withErrors(['message', 'Email id  already exists as customer. Please use a different Email id']);
        }
		
		

        if ($status1) {
            return redirect()->back()->withErrors(['message', 'Email id  already exists . Please use a different Email id']);
        } else {

//            $dataToSave = array('user_name' => $request->user_name,
//                'email' => $request->email,
//                'mobile' => $request->mobile,
//                'status' => $request->status,
//                'admin_role' => 2
//            );
//            $id = Admin::create($dataToSave)->id;

            $subadminPwd = '123456';

            $nameArr = explode(' ', $request->user_name);
            $fname = '';
            $lname = '';

            if (isset($nameArr[0]) && $nameArr[0] != '') {
                $fname = $nameArr[0];
            }
            if (isset($nameArr[1]) && $nameArr[1] != '') {
                $lname = $nameArr[1];
            }
            $access = 0;
            if ($request->report_access) {
                $access = 1;
            }
            $dataToSave1 = array('firstName' => $fname,
                'lastName' => $lname,
				'companyName'=>$request->user_name,
                'com_emailAddress' => $request->email,
                'password' => md5($subadminPwd),
                'com_Telephone' => $request->mobile,
                'user_status' => $request->status,
                'report_access' => $access,
                'cust_type' => 3
            );
            $id = Customer::create($dataToSave1)->id;

//            $idTosave = 1000 + $id;
//
//            $dataToUpdate = array('code' => $prefix . date("y") . $idTosave, 'password' => bcrypt($subadminPwd));

            $logData = array('subject_id' => $id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_users',
                'description' => 'insert', 'data_prev' => '', 'data_now' => urldecode(http_build_query($request->all()))
            );
            saveQueryLog($logData);
            if ($id) {
//                Admin::where('id', $id)->where('admin_role', 2)->update($dataToUpdate);

                return redirect()->back()->with('message', 'Sales Person successfully created');
            } else {
                return redirect()->back()->with('message', 'Error while creating new sales person');
            }
        }
    }

    public function EditSubAdmin(Request $request) {

        $validation = Validator::make($request->all(), [
                    'user_name' => 'required',
                    'email' => 'required|email',
                    //'mobile' => 'required|min:10',
                    'status' => 'required'
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('user_name', 'email', 'mobile', 'loc', 'status'));
        }
//DB::enableQueryLog(); 
        $query = DB::table('rollco_ms_users')
                ->select('u_id');
        $query = $query->Where('u_id', '!=', $request->id);
        $email = $request->email;
        $mobile = $request->mobile;
        $query = $query->where(function($query) use ($mobile, $email) {
            $query->Where('com_emailAddress', $email);
            //$query->orWhere('com_Telephone', $mobile);
        });
        $query = $query->where('cust_type',3);
        $status = $query->get();
//        dd(DB::getQueryLog());
        $statusv = count($status);
        if (($statusv > 0)) {
            return redirect()->back()->withErrors(['message', 'Mobile/Email id already exists. Please use a different Mobile Number/Email id']);
        } else {

            $data = Customer::Where('u_id', $request->id)->where('cust_type', 3)->first();


            $changed_data = $request->all();


            $diff_in_data = array_diff_assoc($data->getOriginal(), $changed_data);

            $keys_to_be_updated = array_keys($diff_in_data);

            $data_to_update = [];
            $diff_in_data_to_save = [];
            for ($i = 0; $i < count($keys_to_be_updated); $i++) {
                if (isset($changed_data[$keys_to_be_updated[$i]])) {

                    $data_to_update[$keys_to_be_updated[$i]] = $changed_data[$keys_to_be_updated[$i]];
                    $diff_in_data_to_save[$keys_to_be_updated[$i]] = $diff_in_data[$keys_to_be_updated[$i]];
                }
            }


            $logData = array('subject_id' => $request->id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_users',
                'description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)), 'data_now' => urldecode(http_build_query($data_to_update))
            );

            //dd($logData);
            saveQueryLog($logData);
            // dd($data_to_update);

            unset($changed_data['_token']);
            $nameArr = explode(' ', $request->user_name);
            $fname = '';
            $lname = '';

            if (isset($nameArr[0]) && $nameArr[0] != '') {
                $fname = $nameArr[0];
            }
            if (isset($nameArr[1]) && $nameArr[1] != '') {
                $lname = $nameArr[1];
            }
            $access = 0;
            if ($request->report_access) {
                $access = 1;
            }

            $dataToUpdate = array('firstName' => $fname,
                'lastName' => $lname,
				'companyName'=>$request->user_name,
                'com_emailAddress' => $request->email,
                'com_Telephone' => $request->mobile,
                'user_status' => $request->status,
                'report_access' => $access,
                'cust_type' => 3
            );

            $updateUser = Customer::Where('u_id', $request->id)->update($dataToUpdate);

            if ($updateUser) {

                return redirect()->back()->with('message', 'Sales Person updated successfully.');
            } else {
                return redirect()->back()->with('message', 'Error while updating sales person');
            }
        }
    }

    public function GetSubAdminData(Request $request) {
        $subadm = Customer::where('u_id', base64_decode($request->id))
                ->where('cust_type', 3)
                ->orderBy('created_at', 'DESC')
                ->first();

        $data = array(
            'id' => $subadm['u_id'],
            'name' => $subadm['firstName'] . ' ' . $subadm['lastName'],
            'email' => $subadm['com_emailAddress'],
            'mobile' => $subadm['com_Telephone'],
            'report_access' => $subadm['report_access'],
            'status' => $subadm['user_status'],
        );
        echo json_encode($data);
    }

    public function DeleteSubAdmin($id) {
        $data = Customer::where('u_id', '=', base64_decode($id))->where('cust_type', 3)->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_users',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())), 'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_users')->where('u_id', base64_decode($id))->where('cust_type', 3)->delete();
        if ($status) {
            return redirect()->back()->with('message', 'Sales person deleted successfully');
        } else {
            return redirect()->back()->with('message', 'Error while deleting sales person');
        }
    }

}
