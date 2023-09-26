<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use App\Modal\Category;
use App\Modal\ProYear;
use App\Modal\Product;
use App\Modal\ProCCM;
use Intervention\Image\ImageManagerStatic as Image;

class ProCCMController extends Controller {
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
    public function AddNewProCCM(Request $request) {
//dd($request->all());
        $validation = Validator::make($request->all(), [
                    'catid' => 'required',
                    'makeid' => 'required',
                    'modelid' => 'required',
                    'proyrid' => 'required',
                    'proccm_inf' => 'required',
                    'proccm_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('modelid', 'catid', 'proccm_status', 'makeid'));
        }

        $status = ProCCM::Where('modelid', $request->modelid)
                ->Where('catid', $request->catid)
                ->Where('makeid', $request->makeid)
                ->Where('proccm_inf', $request->proccm_inf)
                ->Where('proyrid', $request->proyrid)
                ->first();

        if ($status) {
            return redirect()->back()->withErrors(['message', 'Manufacturing CCM already exists']);
        } else {

            $dataToSave = array('modelid' => $request->modelid,
                'proccm_inf' => $request->proccm_inf,
                'catid' => $request->catid,
                'makeid' => $request->makeid,
                'proccm_inf' => $request->proccm_inf,
                'proyrid' => $request->proyrid,
            );

            $id = ProCCM::create($dataToSave)->id;
            $logData = array('subject_id' => $id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_proccm',
                'description' => 'insert', 'data_prev' => '', 'data_now' => urldecode(http_build_query($request->all()))
            );
            saveQueryLog($logData);
            if ($id) {
                return redirect()->back()->with('message', 'Manufacturing CCM successfully created');
            } else {
                return redirect()->back()->with('message', 'Error while creating manufacturing CCM');
            }
        }
    }

    /*

     * View list 
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function ProCCMs(Request $request) {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            
        $query = ProCCM::query();
        
        if (!empty($request->search)) {
            $search = $request->search;

            $query = $query->where(function($query) use ($search) {
                $query->where('proccm_inf', 'LIKE', '%' . $search . '%');
//                $query->orWhere('spare_nm', 'LIKE', '%' . $search . '%');
//                $query->orWhere('spare_make', 'LIKE', '%' . $search . '%');
            });
        }
            
        $pageData = $query->orderby('created_at', 'DESC')
                ->paginate(10)
                ->withPath('?search=' . $request->search);
            
            $categoryData = Category::orderBy('cat_nm', 'ASC')->get();
 //           $data = ProCCM::orderBy('created_at', 'DESC')->get();
            return view('admin.product.manage-ccm', array('data' => $pageData, 'category' => $categoryData));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit data
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function EditProCCM(Request $request) {

        // dd($request->all());
        $validation = Validator::make($request->all(), [
                    'catid' => 'required',
                    'makeid' => 'required',
                    'modelid' => 'required',
                    'proyrid' => 'required',
                    'proccm_inf' => 'required',
                    'proccm_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('modelid', 'catid', 'proccm_status', 'makeid'));
        }

        $data = ProCCM::where('proccm_id', $request->proccm_id)->first();

        $changed_data = array('modelid' => $request->modelid,
            'proccm_inf' => $request->proccm_inf,
            'catid' => $request->catid,
            'makeid' => $request->makeid,
            'proccm_inf' => $request->proccm_inf,
            'proyrid' => $request->proyrid,
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
        $logData = array('subject_id' => $request->proccm_id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_proccm',
            'description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)), 'data_now' => urldecode(http_build_query($data_to_update))
        );
        saveQueryLog($logData);
        $updateSubCat = ProCCM::where('proccm_id', $request->proccm_id)->update($changed_data);
        if ($updateSubCat) {
            return redirect('admin/manage-proccm')->with('message', 'Manufacturing CCM successfully updated');
        } else {
            return redirect()->back()->with('message', 'Error while updating manufacturing CCM');
        }
//        }
    }

    /*

     * Edit data
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function DeleteProCCM($id) {
        $data = ProCCM::where('proccm_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_proccm',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())), 'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_proccm')->where('proccm_id', base64_decode($id))->delete();
        if ($status) {
            return redirect('admin/manage-proccm')->with('message', 'Manufacturing CCM successfully deleted');
        } else {
            return redirect()->back()->with('message', 'Error while deleting manufacturing CCM');
        }
    }

    public function GetProCCMData(Request $request) {

        $cat = ProCCM::Where('proccm_id', base64_decode($request->id))->first();
        //dd($cat);
        $data = array(
            'id' => $cat['proccm_id'],
            'category_id' => $cat['catid'],
            'make_id' => $cat['makeid'],
            'model_id' => $cat['modelid'],
            'proyr_id' => $cat['proyrid'],
            'proccm_inf' => $cat['proccm_inf'],
            'status' => $cat['proccm_status'],
        );
        echo json_encode($data);
    }

    public function GetProCCMDataByYear(Request $request) {

        // dd($request->all());
        $data = [];
        $cat = ProCCM::Where('proyrid', $request->id)->where('proccm_status', 1)->get();

        foreach ($cat as $key => $value) {
            $data[] = array(
                'id' => $value['proccm_id'],
                'name' => $value['proccm_inf'],
            );
        }

        echo json_encode($data);
    }

}
