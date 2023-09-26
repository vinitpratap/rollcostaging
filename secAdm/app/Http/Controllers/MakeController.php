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
use Intervention\Image\ImageManagerStatic as Image;

class MakeController extends Controller {
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
    public function AddNewMake(Request $request) {

        $validation = Validator::make($request->all(), [
                    'make_nm' => 'required',
                    'catid' => 'required',
                    'make_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('make_nm', 'catid','make_status'));
        }

        $name = $request->make_nm;
        $status = Make::Where('make_nm', $request->make_nm)
                ->first();

        if ($status) {
            return redirect()->back()->withErrors(['message', 'Make name already exists']);
        } else {
            
            $dataToSave = array('make_nm' => $request->make_nm,
                'make_status' => $request->make_status,
                'catid' => $request->catid,
            );
            $id = Make::create($dataToSave)->id;
            $logData = array('subject_id' => $id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_make',
                'description' => 'insert', 'data_prev' => '', 'data_now' => urldecode(http_build_query($request->all()))
            );
            saveQueryLog($logData);
            if ($id) {
                return redirect()->back()->with('message', 'Make successfully created');
            } else {
                return redirect()->back()->with('message', 'Error while creating make');
            }
        }
    }

    /*

     * View list 
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function Make() {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $categoryData = Category::orderBy('cat_nm', 'ASC')->get();
            $data = Make::with('getcategory')->orderBy('created_at', 'DESC')->get();
            return view('admin.make.view-make', array('data' => $data, 'category' => $categoryData));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit data
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function EditMake(Request $request) {

        //dd($request->all());
        //dd($request->file('make_img'), $request->file('make_img')->getMimeType());
        $validation = Validator::make($request->all(), [
                    'make_nm' => 'required',
                    'catid' => 'required',
                    'make_status' => 'required',
        ]);

        //dd($validation->fails());
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('make_nm', 'catid','make_status'));
        }

        $name = $request->make_nm;

        $status = Make::where('make_nm', $name)
                ->Where('make_id', '!=', $request->make_id)
                ->first();


        if ($status) {
            return redirect()->back()->withErrors(['message', 'Make name already exists']);
        } else {
            $data = Make::where('make_id', $request->make_id)->first();
            
            $changed_data = array('make_nm' => $request->make_nm,
                'make_status' => $request->make_status,
                'catid' => $request->catid,
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
            $logData = array('subject_id' => $request->make_id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_make',
                'description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)), 'data_now' => urldecode(http_build_query($data_to_update))
            );
            saveQueryLog($logData);
            $updateSubCat = Make::where('make_id', $request->make_id)->update($changed_data);
            if ($updateSubCat) {
                return redirect('admin/view-make')->with('message', 'Make successfully updated');
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

    public function DeleteMake($id) {
        $data = Make::where('make_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_make',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())), 'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_make')->where('make_id', base64_decode($id))->delete();
        if ($status) {
            return redirect('admin/view-make')->with('message', 'Make successfully deleted');
        } else {
            return redirect()->back()->with('message', 'Error while deleting make');
        }
    }

    public function GetMakeData(Request $request) {
        $cat = Make::with('getcategory')->Where('make_id', base64_decode($request->id))->first();
        // dd($cat);
        $data = array(
            'id' => $cat['make_id'],
            'name' => $cat['make_nm'],
            'category_id' => $cat['catid'],
            'status' => $cat['make_status'],
        );
        echo json_encode($data);
    }

    public function GetMakeDataByCategory(Request $request) {

        // dd($request->all());
        $cat = Make::Where('catid', $request->id)->where('make_status', 1)->get();

        foreach ($cat as $key => $value) {
            $data[] = array(
                'id' => $value['make_id'],
                'name' => $value['make_nm'],
                'category_id' => $value['catid'],
                'status' => $value['make_status'],
            );
        }

        echo json_encode($data);
    }

}
