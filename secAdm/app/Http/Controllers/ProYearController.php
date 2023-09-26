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
use App\Modal\ProYear;
use Intervention\Image\ImageManagerStatic as Image;

class ProYearController extends Controller {
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
    public function AddNewProYear(Request $request) {
//dd($request->all());
        $validation = Validator::make($request->all(), [
                    'proyr_from' => 'required',
                    'catid' => 'required',
                    'makeid' => 'required',
                    'modelid' => 'required',
                    'proyr_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('modelid', 'catid', 'proyr_status', 'makeid'));
        }

        $status = ProYear::Where('modelid', $request->modelid)
                ->Where('catid', $request->catid)
                ->Where('makeid', $request->makeid)
                ->Where('proyr_from', $request->proyr_from)
                ->first();

        if ($status) {
            return redirect()->back()->withErrors(['message', 'Manufacturing year already exists']);
        } else {
            if ($request->yearRadio == 'current') {
                $request->proyr_to = '';
            }
            $dataToSave = array('modelid' => $request->modelid,
                'proyr_status' => $request->proyr_status,
                'catid' => $request->catid,
                'makeid' => $request->makeid,
                'proyr_from' => $request->proyr_from,
                'proyr_to' => $request->proyr_to,
            );

            $id = ProYear::create($dataToSave)->id;
            $logData = array('subject_id' => $id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_proyr',
                'description' => 'insert', 'data_prev' => '', 'data_now' => urldecode(http_build_query($request->all()))
            );
            saveQueryLog($logData);
            if ($id) {
                return redirect()->back()->with('message', 'Manufacturing year successfully created');
            } else {
                return redirect()->back()->with('message', 'Error while creating manufacturing year');
            }
        }
    }

    /*

     * View list 
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function ProYears(Request $request) {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            
        $query = ProYear::query();
        
        if (!empty($request->search)) {
            $search = $request->search;

            $query = $query->where(function($query) use ($search) {
                $query->where('proyr_from', 'LIKE', '%' . $search . '%');
                $query->orWhere('proyr_to', 'LIKE', '%' . $search . '%');
//                $query->orWhere('spare_make', 'LIKE', '%' . $search . '%');
            });
        }
            
        $pageData = $query->orderby('created_at', 'DESC')
                ->paginate(10)
                ->withPath('?search=' . $request->search);
            
            $categoryData = Category::orderBy('cat_nm', 'ASC')->get();
//            $data = ProYear::orderBy('created_at', 'DESC')->get();
            return view('admin.proyear.manage-proyear', array('data' => $pageData, 'category' => $categoryData));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit data
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function EditProYear(Request $request) {

        $validation = Validator::make($request->all(), [
                    'proyr_from' => 'required',
                    'catid' => 'required',
                    'makeid' => 'required',
                    'modelid' => 'required',
                    'proyr_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('modelid', 'catid', 'proyr_status', 'makeid'));
        }


        $modelid = $request->modelid;
        $catid = $request->catid;
        $makeid = $request->makeid;
        $proyr_from = $request->proyr_from;

//        $status = ProYear::where(function($query) use($modelid, $catid, $makeid,$proyr_from) {
//                    $query ->Where('catid', $catid)
//                    ->Where('makeid', $makeid)
//                    ->Where('modelid', $modelid)
//                    ->Where('proyr_from', $proyr_from);
//                })
//                ->where('proyr_id', '!=', $request->proyr_id)
//                ->first();
//                
//
//        if ($status) {
//            return redirect()->back()->withErrors(['message', 'Manufacturing year already exists']);
//        } else {
            $data = ProYear::where('proyr_id', $request->proyr_id)->first();

            $changed_data = array('modelid' => $request->modelid,
                'proyr_status' => $request->proyr_status,
                'catid' => $request->catid,
                'makeid' => $request->makeid,
                'proyr_from' => $request->proyr_from,
                'proyr_to' => $request->proyr_to,
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
            $logData = array('subject_id' => $request->proyr_id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_proyr',
                'description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)), 'data_now' => urldecode(http_build_query($data_to_update))
            );
            saveQueryLog($logData);
            $updateSubCat = ProYear::where('proyr_id', $request->proyr_id)->update($changed_data);
            if ($updateSubCat) {
                return redirect('admin/view-proyr')->with('message', 'Manufacturing year successfully updated');
            } else {
                return redirect()->back()->with('message', 'Error while updating manufacturing year');
            }
//        }
    }

    /*

     * Edit data
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function DeleteProYear($id) {
        $data = ProYear::where('proyr_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_proyr',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())), 'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_proyr')->where('proyr_id', base64_decode($id))->delete();
        if ($status) {
            return redirect('admin/manage-proyr')->with('message', 'Manufacturing year successfully deleted');
        } else {
            return redirect()->back()->with('message', 'Error while deleting manufacturing year');
        }
    }

    public function GetProYearData(Request $request) {
        $cat = ProYear::Where('proyr_id', base64_decode($request->id))->first();
        // dd($cat);
        $data = array(
            'id' => $cat['proyr_id'],
            'category_id' => $cat['catid'],
            'make_id' => $cat['makeid'],
            'model_id' => $cat['modelid'],
            'proyr_from' => $cat['proyr_from'],
            'proyr_to' => $cat['proyr_to'],
            'status' => $cat['proyr_status'],
        );
        echo json_encode($data);
    }

    public function GetProYearDataByModel(Request $request) {

        // dd($request->all());
        $data = [];
        $cat = ProYear::Where('modelid', $request->id)->where('proyr_status', 1)->get();

        foreach ($cat as $key => $value) {
            $data[] = array(
                'id' => $value['proyr_id'],
                'yr_from' => $value['proyr_from'],
                'yr_to' => $value['proyr_to'],
				'current_flag'=>$value['current_flag']
            );
        }

        echo json_encode($data);
    }

}
