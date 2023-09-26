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
use App\Modal\Spare;
use App\Modal\SpareCrossReference;
use Excel;
use Intervention\Image\ImageManagerStatic as Image;

class SpareCrossReferenceController extends Controller {
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

    /*     * $category
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
    public function AddNewSpareCrossRef(Request $request) {
        
       // dd($request->all());
        $validation = Validator::make($request->all(), [
                    'spareid' => 'required',
                    'crossref_file' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only( 'spareid', 'crossref_file'));
        }

        if (Input::hasFile('crossref_file')) {
            $file = Input::file('crossref_file');
            if ($file->getClientOriginalExtension() == 'csv') {
                $name = $file->getClientOriginalName();

				$name = preg_replace("/[^\.\-\_a-zA-Z0-9]/", "", $name);
				//Not really uniqe - but for all practical reasons, it is
				$uniqer = substr(md5(uniqid(rand(), 1)), 0, 6);
				$name = $uniqer . '_' . $name; //Get Unique Name
                $path = public_path('/upload/csv');

                // Moves file to folder on server
                $file->move($path, $name);

                $file1 = public_path('/upload/csv/' . $name);

                $customerArr = csvToArray($file1);

                // dd($customerArr);
                $data = [];
                for ($i = 0; $i < count($customerArr); $i ++){
                    $data = ['spareid' => $request->spareid, 'serv_no' => $customerArr[$i]['Servicing number'], 'comp_oem_no' => $customerArr[$i]['OEM']];
                    $id = SpareCrossReference::create($data);
                }
            } else {
                 return redirect()->back()->withErrors(['message', 'file format is not csv']);
            }

            return redirect()->back()->with('message', 'Spare Cross reference successfully created');
        } else {
            return redirect()->back()->with('message', 'Error while creating spare cross reference');
        }
    }

    /*

     * View list 
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function SpareCrossRefs() {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $prodData = Spare::orderBy('spare_nm', 'ASC')->get();
            $data = SpareCrossReference::orderBy('spareid', 'ASC')->get();
            return view('admin.product.manage-sparecrossreference', array('data' => $data, 'spare' => $prodData));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit data
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function DeleteSpareCrossRef($id) {
        $data = SpareCrossReference::where('scref_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_sparecrossref',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())), 'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_sparecrossref')->where('scref_id', base64_decode($id))->delete();
        if ($status) {
            return redirect('admin/manage-sparecrossref')->with('message', 'Spare cross reference successfully deleted');
        } else {
            return redirect()->back()->with('message', 'Error while deleting spare cross reference');
        }
    }
    
    
    public function DeleteSpareCrossRefAjax(Request $request){
       $status =  DB::table('rollco_ms_sparecrossref')->whereIn('scref_id', $request['ids'])->delete(); 
        if ($status) {
           echo 1;
        } else {
            echo 0;
        }
    }

    public function GetSpareCrossRefData(Request $request) {
        $cat = Spare::Where('spare_id', base64_decode($request->id))->first();
        echo json_encode($cat);
    }

}
