<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\Modal\Terms;

class TermsController extends Controller {
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
    public function AddNewTerms(Request $request) {

        $validation = Validator::make($request->all(), [
                    'term_title' => 'required',
					'term_text' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('term_text','term_title'));
        }


		DB::table('rollco_terms_condition')->delete();

		$id = Terms::create($request->all())->id;
		$logData = array('subject_id' => $id, 'user_id' => Auth::id(), 'table_used' => 'rollco_terms_condition',
			'description' => 'insert', 'data_prev' => '', 'data_now' => urldecode(http_build_query($request->all()))
		);
		saveQueryLog($logData);
		if ($id) {
			return redirect()->back()->with('message', 'Terms & Condition successfully created');
		} else {
			return redirect()->back()->with('message', 'Error while creating Terms & Condition');
		}

    }

    /*

     * View customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function Terms() {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $data = Terms::orderBy('created_at', 'ASC')->get();
            return view('admin.terms-conditions.manage-terms-conditions', array('data' => $data));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function EditTerms(Request $request) {

       $validation = Validator::make($request->all(), [
                    'term_title' => 'required',
					'term_text' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('term_text','term_title'));
        }


        $status = Terms::where('term_text',$request->term_text)
				->where('term_title',$request->term_title)
                ->where('id', '!=', $request->id)
                ->first();
        if ($status) {
            return redirect()->back()->withErrors(['message', 'Terms & Condition  already exists']);
        } else {
            $data = Terms::Where('id', $request->id)->first();
            //dd($data);

            $changed_data = array('term_title'=>$request->term_title,'term_text'=>$request->term_text);

            $diff_in_data = array_diff_assoc($data->getOriginal(), $changed_data);
            $diff_in_data_to_save = array();
            $keys_to_be_updated = array_keys($diff_in_data);

            for ($i = 0; $i < count($keys_to_be_updated); $i++) {
                if (isset($changed_data[$keys_to_be_updated[$i]])) {
                    $data_to_update[$keys_to_be_updated[$i]] = $changed_data[$keys_to_be_updated[$i]];
                    $diff_in_data_to_save[$keys_to_be_updated[$i]] = $diff_in_data[$keys_to_be_updated[$i]];
                }
            }
            $logData = array('subject_id' => $request->id, 'user_id' => Auth::id(), 'table_used' => 'rollco_terms_condition','description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)), 'data_now' => urldecode(http_build_query($changed_data))
            );
            //dd($logData);
            saveQueryLog($logData);
            $updateCat = Terms::Where('id', $request->id)->update($changed_data);
            if ($updateCat) {
                return redirect()->back()->with('message', 'Terms & Condition successfully updated');
            } else {
                return redirect()->back()->with('message', 'Error while updating Terms & Condition');
            }
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function DeleteTerms($id) {

        $data = Terms::where('id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(), 'table_used' => 'rollco_terms_condition',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())), 'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_terms_condition')->where('id', base64_decode($id))->delete();
        if ($status) {
            return redirect()->back()->with('message', 'Terms & Condition successfully deleted');
        } else {
            return redirect()->back()->with('message', 'Error while deleting Terms & Condition');
        }
    }

    public function GetTermsData (Request $request) {
        $cat = Terms::Where('id', base64_decode($request->id))->first();

        echo json_encode($cat);
    }

}
