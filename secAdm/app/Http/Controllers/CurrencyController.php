<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\Modal\Currency;

class CurrencyController extends Controller {
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
    public function AddNewCurrency(Request $request) {
        
        $validation = Validator::make($request->all(), [
                    'curr_name' => 'required',
                    'curr_info' => 'required',
                    'curr_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('curr_name', 'curr_status'));
        }

        $name = $request->curr_name;

        $status = Currency::where('curr_name',$name)
                ->first();

        if ($status) {
            return redirect()->back()->withErrors(['message', 'Currency already exists']);
        } else {

            $id = Currency::create($request->all())->id;
            $logData = array('subject_id' => $id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_currency',
                'description' => 'insert', 'data_prev' => '', 'data_now' => urldecode(http_build_query($request->all()))
            );
            saveQueryLog($logData);
            if ($id) {
                return redirect()->back()->with('message', 'Currency successfully created');
            } else {
                return redirect()->back()->with('message', 'Error while creating currency');
            }
        }

    }

    /*

     * View customers 
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function Currencies() {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $data = Currency::orderBy('curr_name', 'ASC')->get();
            return view('admin.currency.view-currency', array('data' => $data));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function EditCurrency(Request $request) {

        $validation = Validator::make($request->all(), [
                    'curr_name' => 'required',
                    'curr_info' => 'required',
                    'curr_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('curr_name', 'curr_status'));
        }

        $name = $request->curr_name;

        $status = Currency::where('curr_name',$request->curr_name)
                ->where('curr_id', '!=', $request->curr_id)
                ->first();
        if ($status) {
            return redirect()->back()->withErrors(['message', 'Currency already exists']);
        } else {
            $data = Currency::Where('curr_id', $request->curr_id)->first();
            //dd($data);
            
            $changed_data = array('curr_name'=>$request->curr_name,
                                   'curr_info'=>$request->curr_info,
                                   'curr_status'=>$request->curr_status
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
            $logData = array('subject_id' => $request->curr_id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_currency','description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)), 'data_now' => urldecode(http_build_query($changed_data))
            );
            //dd($logData);
            saveQueryLog($logData);
            $updateCat = Currency::Where('curr_id', $request->curr_id)->update($changed_data);
            if ($updateCat) {
                return redirect('admin/view-currency')->with('message', 'Currency successfully updated');
            } else {
                return redirect()->back()->with('message', 'Error while updating currency');
            }
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function DeleteCurrency($id) {

        $data = Currency::where('curr_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_currency',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())), 'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_currency')->where('curr_id', base64_decode($id))->delete();
        if ($status) {
            return redirect('admin/view-currency')->with('message', 'Currency successfully deleted');
        } else {
            return redirect()->back()->with('message', 'Error while deleting news');
        }
    }

    public function GetCurrencyData(Request $request) {
        $cat = Currency::Where('curr_id', base64_decode($request->id))->first();
        $data = array(
            'curr_id' => $cat['curr_id'],
            'curr_name' => $cat['curr_name'],
            'curr_info' => $cat['curr_info'],
            'curr_status' => $cat['curr_status'],
        );
        echo json_encode($data);
    }

}
