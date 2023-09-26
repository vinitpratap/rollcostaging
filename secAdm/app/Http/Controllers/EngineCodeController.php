<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use App\Modal\Category;

use App\Modal\EngineCode;
use Intervention\Image\ImageManagerStatic as Image;

class EngineCodeController extends Controller {
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
    public function AddNewEngineCode(Request $request) {
//dd($request->all());
        $validation = Validator::make($request->all(), [
                    'catid' => 'required',
                    'makeid' => 'required',
                    'modelid' => 'required',
                    'proyrid' => 'required',
                    'proccmid' => 'required',
                    'engcode_inf' => 'required',
                    'engcode_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('modelid', 'catid', 'engcode_status', 'makeid'));
        }

        $status = EngineCode::Where('modelid', $request->modelid)
                ->Where('catid', $request->catid)
                ->Where('makeid', $request->makeid)
                ->Where('engcode_inf', $request->engcode_inf)
                ->Where('proyrid', $request->proyrid)
                ->Where('proccmid', $request->proccmid)
                ->first();

        if ($status) {
            return redirect()->back()->withErrors(['message', 'Engine Code already exists']);
        } else {

            $dataToSave = array('modelid' => $request->modelid,
                'proccmid' => $request->proccmid,
                'catid' => $request->catid,
                'makeid' => $request->makeid,
                'engcode_inf' => $request->engcode_inf,
                'proyrid' => $request->proyrid,
                'engcode_status' => $request->engcode_status,
            );

            $id = EngineCode::create($dataToSave)->id;
            $logData = array('subject_id' => $id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_engcode',
                'description' => 'insert', 'data_prev' => '', 'data_now' => urldecode(http_build_query($request->all()))
            );
            saveQueryLog($logData);
            if ($id) {
                return redirect()->back()->with('message', 'Engine Code successfully created');
            } else {
                return redirect()->back()->with('message', 'Error while creating engine Code');
            }
        }
    }

    /*

     * View list 
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function EngineCodes(Request $request) {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            
        $query = EngineCode::query();
        
        if (!empty($request->search)) {
            $search = $request->search;

            $query = $query->where(function($query) use ($search) {
                $query->where('engcode_inf', 'LIKE', '%' . $search . '%');
//                $query->orWhere('spare_nm', 'LIKE', '%' . $search . '%');
//                $query->orWhere('spare_make', 'LIKE', '%' . $search . '%');
            });
        }
            
        $pageData = $query->orderby('created_at', 'DESC')
                ->paginate(10)
                ->withPath('?search=' . $request->search);
        
        
            $categoryData = Category::orderBy('cat_nm', 'ASC')->get();
//            $data = EngineCode::orderBy('created_at', 'DESC')->get();
            return view('admin.product.manage-enginecode', array('data' => $pageData, 'category' => $categoryData));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit data
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function EditEngineCode(Request $request) {

       // dd($request->all());
        $validation = Validator::make($request->all(), [
                    'catid' => 'required',
                    'makeid' => 'required',
                    'modelid' => 'required',
                    'proyrid' => 'required',
                    'proccmid' => 'required',
                    'engcode_inf' => 'required',
                    'engcode_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('modelid', 'catid', 'engcode_status', 'makeid'));
        }

            $data = EngineCode::where('engcode_id', $request->engcode_id)->first();

            $changed_data = array('modelid' => $request->modelid,
                'proccmid' => $request->proccmid,
                'catid' => $request->catid,
                'makeid' => $request->makeid,
                'engcode_inf' => $request->engcode_inf,
                'proyrid' => $request->proyrid,
                'engcode_status' => $request->engcode_status,
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
            $logData = array('subject_id' => $request->engcode_id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_engcode',
                'description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)), 'data_now' => urldecode(http_build_query($data_to_update))
            );
            saveQueryLog($logData);
            $updateSubCat = EngineCode::where('engcode_id', $request->engcode_id)->update($changed_data);
            if ($updateSubCat) {
                return redirect('admin/manage-engcode')->with('message', 'Engine Code successfully updated');
            } else {
                return redirect()->back()->with('message', 'Error while updating engine Code');
            }
//        }
    }

    /*

     * Edit data
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function DeleteEngineCode($id) {
        $data = EngineCode::where('engcode_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_engcode',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())), 'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_engcode')->where('engcode_id', base64_decode($id))->delete();
        if ($status) {
            return redirect('admin/manage-engcode')->with('message', 'Engine Code  successfully deleted');
        } else {
            return redirect()->back()->with('message', 'Error while deleting engine Code ');
        }
    }

    public function GetEngineCodeData(Request $request) {

        $cat = EngineCode::Where('engcode_id', base64_decode($request->id))->first();
         //dd($cat);
        $data = array(
            'id' => $cat['engcode_id'],
            'category_id' => $cat['catid'],
            'make_id' => $cat['makeid'],
            'model_id' => $cat['modelid'],
            'proyr_id' => $cat['proyrid'],
            'proccm_id' => $cat['proccmid'],
            'engcode_inf' => $cat['engcode_inf'],
            'status' => $cat['engcode_status'],
        );
        echo json_encode($data);
    }
    public function GetEngineCodeDataByCCM(Request $request) {

        // dd($request->all());
        $data = [];
        $cat = EngineCode::Where('proccmid', $request->id)->get();

        foreach ($cat as $key => $value) {
            $data[] = array(
                'id' => $value['engcode_id'],
                'name' => $value['engcode_inf'],
            );
        }

        echo json_encode($data);
    }


}
