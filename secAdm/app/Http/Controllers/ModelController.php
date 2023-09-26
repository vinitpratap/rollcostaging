<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use App\Modal\Category;
use App\Modal\Make;
use App\Modal\Model;
use Intervention\Image\ImageManagerStatic as Image;

class ModelController extends Controller {
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
    public function AddNewModel(Request $request) {

        //dd($request->all());
        $validation = Validator::make($request->all(), [
                    'model_nm' => 'required',
                    'catid' => 'required',
                    'makeid' => 'required',
                    'model_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('model_nm', 'catid','model_status','makeid'));
        }

        $name = $request->model_nm;
        $status = Model::Where('model_nm', $request->model_nm)
                ->Where('catid',$request->catid)
                ->Where('makeid',$request->makeid)
                ->first();

        if ($status) {
            return redirect()->back()->withErrors(['message', 'Model already exists']);
        } else {
            
            $dataToSave = array('model_nm' => $request->model_nm,
                'model_status' => $request->model_status,
                'catid' => $request->catid,
                'makeid' => $request->makeid,
            );
            $id = Model::create($dataToSave)->id;
            $logData = array('subject_id' => $id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_model',
                'description' => 'insert', 'data_prev' => '', 'data_now' => urldecode(http_build_query($request->all()))
            );
            saveQueryLog($logData);
            if ($id) {
                return redirect()->back()->with('message', 'Model successfully created');
            } else {
                return redirect()->back()->with('message', 'Error while creating Model');
            }
        }
    }

    /*

     * View list 
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function Models() {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $categoryData = Category::orderBy('cat_nm', 'ASC')->get();
            $data = Model::orderBy('created_at', 'DESC')->get();
            return view('admin.model.view-model', array('data' => $data, 'category' => $categoryData));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit data
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function EditModel(Request $request) {

        $validation = Validator::make($request->all(), [
                    'model_nm' => 'required',
                    'catid' => 'required',
                    'makeid' => 'required',
                    'model_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('model_nm', 'catid','model_status','makeid'));
        }

        $name = $request->model_nm;
        $catid = $request->catid;
        $makeid = $request->makeid;

        $status = Model::where(function($query) use($name, $catid, $makeid) {
                    $query ->Where('catid', $catid)
                    ->Where('makeid', $makeid)
                    ->Where('model_nm', $name);
                })
                ->where('model_id', '!=', $request->model_id)
                ->first();

        if ($status) {
            return redirect()->back()->withErrors(['message', 'Model name already exists']);
        } else {
            $data = Model::where('model_id', $request->model_id)->first();
            
            $changed_data = array('model_nm' => $request->model_nm,
                'model_status' => $request->model_status,
                'catid' => $request->catid,
                'makeid' => $request->makeid,
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
            $logData = array('subject_id' => $request->model_id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_model',
                'description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)), 'data_now' => urldecode(http_build_query($data_to_update))
            );
            saveQueryLog($logData);
            $updateSubCat = Model::where('model_id', $request->model_id)->update($changed_data);
            if ($updateSubCat) {
                return redirect('admin/view-model')->with('message', 'Model successfully updated');
            } else {
                return redirect()->back()->with('message', 'Error while updating make');
            }
        }
    }

    /*

     * Edit data
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function DeleteModel($id) {
        $data = Model::where('model_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_model',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())), 'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_model')->where('model_id', base64_decode($id))->delete();
        if ($status) {
            return redirect('admin/view-model')->with('message', 'Model successfully deleted');
        } else {
            return redirect()->back()->with('message', 'Error while deleting model');
        }
    }

    public function GetModelData(Request $request) {
        $cat = Model::Where('model_id', base64_decode($request->id))->first();
        // dd($cat);
        $data = array(
            'id' => $cat['model_id'],
            'name' => $cat['model_nm'],
            'category_id' => $cat['catid'],
            'make_id' => $cat['makeid'],
            'status' => $cat['model_status'],
        );
        echo json_encode($data);
    }

    public function GetMakeDataByCategory(Request $request) {

        // dd($request->all());
        $data = [];
        $cat = Make::Where('catid', $request->id)->get();

        foreach ($cat as $key => $value) {
            $data[] = array(
                'id' => $value['make_id'],
                'name' => $value['make_nm'],
            );
        }

        echo json_encode($data);
    }
    
    public function GetModelDataByMake(Request $request) {

        // dd($request->all());
        $data = [];
        $cat = Model::Where('makeid', $request->id)->get();

        foreach ($cat as $key => $value) {
            $data[] = array(
                'id' => $value['model_id'],
                'name' => $value['model_nm'],
            );
        }

        echo json_encode($data);
    }

}
