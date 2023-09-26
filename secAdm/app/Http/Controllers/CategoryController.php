<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Auth;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\Modal\Category;
use App\Modal\MCategory;

class CategoryController extends Controller {
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
    public function AddNewCategory(Request $request) {

        //dd($request->all());
        $uniqer = substr(md5(uniqid(rand(), 1)), 0, 6);
        if (Input::hasFile('cat_brochure')) {

            $file = Input::file('cat_brochure');
            if ($file->getClientOriginalExtension() == 'pdf') {
                $name = $file->getClientOriginalName();
                $name = str_replace(" ", "-", $name);
                $name = preg_replace("/[^a-zA-Z0-9-.]+/", "", $name);
                $uniqer = substr(md5(uniqid(rand(), 1)), 0, 6);
                $name = $uniqer . '-' . $name;
                $name = substr($name, 0, 100);

                $path = public_path('/upload/catalogues');
                // Moves file to folder on server
                $file->move($path, $name);

                $file_update = array('cat_brochure' => $name);
                Category::where('cat_id', $request->catid)->update($file_update);
            } else {
                return redirect()->back()->withErrors(['message', 'file format is not pdf']);
            }

            return redirect()->back()->with('message',
                            'Catalogue successfully uploaded');
        } else {
            return redirect()->back()->with('message',
                            'Error while uploading Catalogue ');
        }
    }

    /*

     * View customers 
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function Categories(Request $request) {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $data = [];
            $host = $request->getSchemeAndHttpHost();
            $mcategoryData = MCategory::orderBy('mcat_nm', 'ASC')->get();
            $data = Category::with('getMCategory')->orderBy('created_at', 'DESC')->get();
            return view('admin.category.view-categories', array('data' => $data, 'host' => $host, 'mcategory' => $mcategoryData));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function EditCategory(Request $request) {

        $validation = Validator::make($request->all(), [
                    'catid' => 'required',
                    'cat_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('catid', 'cat_status'));
        }

        $uniqer = substr(md5(uniqid(rand(), 1)), 0, 6);
        if (Input::hasFile('cat_brochure')) {

            $file = Input::file('cat_brochure');
            if ($file->getClientOriginalExtension() == 'pdf') {
                $name = $file->getClientOriginalName();
                $name = str_replace(" ", "-", $name);
                $name = preg_replace("/[^a-zA-Z0-9-.]+/", "", $name);
                $uniqer = substr(md5(uniqid(rand(), 1)), 0, 6);
                $name = $uniqer . '-' . $name;
                $name = substr($name, 0, 100);

                $path = public_path('/upload/catalogues');
                // Moves file to folder on server
                $file->move($path, $name);

                $file_update = array('cat_brochure' => $name, 'cat_status' => $request->cat_status);
                Category::where('cat_id', $request->catid)->update($file_update);
            } else {
                return redirect()->back()->withErrors(['message', 'file format is not pdf']);
            }

            return redirect()->back()->with('message',
                            'Catalogue successfully uploaded');
        } else {
            $file_update = array('cat_status' => $request->cat_status);
            Category::where('cat_id', $request->catid)->update($file_update);
        }
        return redirect()->back()->with('message',
                        'Catalogue successfully uploaded');
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function DeleteCategory($id) {
        $data = Category::where('cat_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_cat',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())), 'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_cat')->where('cat_id', base64_decode($id))->delete();
        if ($status) {
            return redirect('admin/view-category')->with('message', 'category successfully deleted');
        } else {
            return redirect()->back()->with('message', 'error while deleting category');
        }
    }

    public function GetCategoryData(Request $request) {
        $cat = Category::Where('cat_id', base64_decode($request->id))->first();
        $data = array(
            'catid' => $cat['cat_id'],
            'cat_brochure' => $cat['cat_brochure'],
            'cat_status' => $cat['cat_status'],
        );
        echo json_encode($data);
    }

    public function GetCategoryDataByMCategory(Request $request) {

        // dd($request->all());
        $data = [];
        $cat = Category::Where('mcatid', $request->id)->get();

        foreach ($cat as $key => $value) {
            $data[] = array(
                'id' => $value['cat_id'],
                'name' => $value['cat_nm'],
            );
        }

        echo json_encode($data);
    }

}
