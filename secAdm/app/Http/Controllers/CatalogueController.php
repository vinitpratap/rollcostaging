<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use App\Modal\Catalogue;
use Excel;
use Intervention\Image\ImageManagerStatic as Image;

class CatalogueController extends Controller {
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
    public function UploadCatalogue(Request $request) {

        $validation = Validator::make($request->all(),
                        [
                            'cat_title' => 'required',
                            'fly_detail' => 'required',
                            'cat_thnail' => 'required',
                            'cat_filename' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('cat_title',
                                    'cat_filename', 'fly_detail', 'cat_thnail'));
        }

        if (Input::hasFile('cat_filename') && Input::hasFile('cat_thnail')) {

            $image = $request->file('cat_thnail');
            $thnail_img = $image->getClientOriginalName();
            $destinationPath = public_path('/upload/catalogues/');
            $valImage = validateImage($image->getClientOriginalExtension());

            $file = Input::file('cat_filename');
            if ($file->getClientOriginalExtension() == 'pdf' && $valImage) {
                $name = $file->getClientOriginalName();
                $path = public_path('/upload/catalogues');
                // Moves file to folder on server
                $file->move($path, $name);
                $image->move($destinationPath, $thnail_img);
                $data = array('cat_title' => $request->cat_title, 'cat_filename' => $name,
                    'fly_detail' => $request->fly_detail, 'cat_thnail' => $thnail_img);
                $id = Catalogue::create($data);
            } else {
                return redirect()->back()->withErrors(['message', 'file format is not pdf']);
            }

            return redirect()->back()->with('message',
                            'Catalogue successfully uploaded');
        } else {
            return redirect()->back()->with('message',
                            'Error while uploading Catalogue');
        }
    }

    /*

     * View list 
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function Catalogues(Request $request) {
        $page_val = 50;
        $pagination_arr = array(50, 100);
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $host = $request->getSchemeAndHttpHost();
            $query = Catalogue::query();

            if (!empty($request->search)) {
                $search = $request->search;

                $query = $query->where(function($query) use ($search) {
                    $query->where('cat_title', 'LIKE', '%' . $search . '%');
                });
            }
            if (!empty($request->data_entries)) {
                $page_val = $request->data_entries;
            }
            $pageData = $query->orderby('created_at', 'DESC')
                    ->paginate($page_val)
                    ->withPath('?search=' . $request->search.'&data_entries='.$page_val);
            return view('admin.CMS.manage-catalogue',
                    array('data' => $pageData, 'host' => $host, 'data_entries' => $page_val,
                        'pagination_arr' => $pagination_arr));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit data
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function EditCatalogue(Request $request) {

        $validation = Validator::make($request->all(),
                        [
                            'cat_title' => 'required',
                            'fly_detail' => 'required'
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('cat_title',
                                    'cat_filename', 'fly_detail'));
        }

        $updateSubCat = 0;
        $status = Catalogue::where('id', '!=', $request->id)
                ->where('cat_title', $request->cat_title)
                ->first();

        if ($status) {
            return redirect()->back()->withErrors(['message', 'Flyre already exists']);
        } else {
            $data = Catalogue::where('id', $request->id)->first();

            $changed_data = array('cat_title' => $request->cat_title, 'fly_detail' => $request->fly_detail,
                'updated_at' => date('Y-m-d H:i:s'));

            $diff_in_data = array_diff_assoc($data->getOriginal(), $changed_data);

            $keys_to_be_updated = array_keys($diff_in_data);
            $diff_in_data_to_save = array();
            $data_to_update = array();
            $cat_filename = '';
            $thnail_img = '';
            if (Input::hasFile('cat_filename')) {
                $file = Input::file('cat_filename');
                if ($file->getClientOriginalExtension() == 'pdf') {
                    $cat_filename = $file->getClientOriginalName();
                    $path = public_path('/upload/catalogues');

                    // Moves file to folder on server
                    $file->move($path, $cat_filename);
                } else {
                    return redirect()->back()->withErrors(['message', 'file format is not pdf']);
                }
            }



            if (Input::hasFile('cat_thnail')) {

                $image = $request->file('cat_thnail');
                $thnail_img = $image->getClientOriginalName();
                $destinationPath = public_path('/upload/catalogues/');
                $valImage = validateImage($image->getClientOriginalExtension());
                if ($valImage) {
                    $image->move($destinationPath, $thnail_img);
//                    $updateSubCat = Catalogue::where('id', $request->id)->update(array(
//                        'cat_thnail' => $thnail_img));
                } else {
                    return redirect()->back()->withErrors(['message', 'file format is not jpeg/png']);
                }
            }

            for ($i = 0; $i < count($keys_to_be_updated); $i++) {
                if (isset($changed_data[$keys_to_be_updated[$i]])) {
                    $data_to_update[$keys_to_be_updated[$i]] = $changed_data[$keys_to_be_updated[$i]];
                    $diff_in_data_to_save[$keys_to_be_updated[$i]] = $diff_in_data[$keys_to_be_updated[$i]];
                }
            }
            $logData = array('subject_id' => $request->id, 'user_id' => Auth::id(),
                'table_used' => 'rollco_ms_catalogues',
                'description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)),
                'data_now' => urldecode(http_build_query($data_to_update))
            );
            saveQueryLog($logData);


            if ($cat_filename == '') {
                $updateSubCat = Catalogue::where('id', $request->id)->update($changed_data);
            } else if ($thnail_img == '') {
                $updateSubCat = Catalogue::where('id', $request->id)->update($changed_data);
            } else {
                $changed_data = array('cat_title' => $request->cat_title, 'cat_filename' => $cat_filename,
                    'fly_detail' => $request->fly_detail, 'updated_at' => date('Y-m-d H:i:s'),
                    'cat_thnail' => $thnail_img);
                $updateSubCat = Catalogue::where('id', $request->id)->update($changed_data);
            }
            if ($updateSubCat) {
                return redirect()->back()->with('message',
                                'Flyer  successfully updated');
            } else {
                return redirect()->back()->with('message',
                                'Error while updating flyer');
            }
        }
    }

    public function getCatalogueData(Request $request) {

        $cat = Catalogue::Where('id', base64_decode($request->id))->first();
        echo json_encode($cat);
    }

    public function DeleteCatalogue($id) {
        $data = Catalogue::where('id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(),
            'table_used' => 'rollco_ms_catalogues',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())),
            'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_catalogues')->where('id',
                        base64_decode($id))->delete();
        if ($status) {
            return redirect()->back()->with('message',
                            'Catalogue successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'Error while deleting catalogue');
        }
    }

}
