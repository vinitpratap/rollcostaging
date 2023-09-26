<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use App\Modal\Popup;
use Intervention\Image\ImageManagerStatic as Image;

class PopupController extends Controller {
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
    public function AddNewPopups(Request $request) {

        $data = [];
        $validation = Validator::make($request->all(), [
                    'p_title' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('p_title'));
        }
        $name = $request->p_title;
        $status = Popup::where(function($query) use($name) {
                    $query->Where('p_title', $name);
                })
                ->first();

        if ($status) {
            return redirect()->back()->withErrors(['message', 'Popup already exists']);
        } else {
			$cb_image = '';
			if ($request->hasFile('p_image')) {
				$image = $request->file('p_image');
				$cb_image = time()  . '.' . $image->getClientOriginalExtension();
	//            $name = time() . str_replace(' ', '_', $request->n_title) . '.' . $image->getClientOriginalExtension();
				$destinationPath = public_path('/upload/popup/');
				$valImage = validateImage($image->getClientOriginalExtension());
				if ($valImage) {

					$image_resize1 = Image::make($image->getRealPath());
					$image_resize1->resize(640, 500);
					$image_resize1->save(public_path('/upload/popup/' . $cb_image));

					$image_resize2 = Image::make($image->getRealPath());
					$image_resize2->resize(633, 256);
					$image_resize2->save(public_path('/upload/popup/th/' . $cb_image));

					$image_resize3 = Image::make($image->getRealPath());
					$image_resize3->resize(200, 200);
					$image_resize3->save(public_path('/upload/popup/thm/' . $cb_image));

	//                $image->move($destinationPath, $n_img);
				} else {
					return redirect()->back()->withErrors(['message', 'Uploaded file is not a valid image. Only JPG, PNG and GIF files are allowed.']);
				}
			}
		
            $name = '';

            $dataToSave = array('p_title' => $request->p_title,
                'p_content' => $request->p_content,
				'p_image' => $cb_image == '' ? '' : $cb_image,
				'p_status' => $request->p_status,
            );
            $id = Popup::create($dataToSave)->id;
            $logData = array('subject_id' => $id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_popup',
                'description' => 'insert', 'data_prev' => '', 'data_now' => urldecode(http_build_query($request->all()))
            );
            saveQueryLog($logData);
            if ($id) {
                return redirect()->back()->with('message', 'Popup successfully created');
            } else {
                return redirect()->back()->with('message', 'Error while creating the Popup');
            }
        }
    }

    /*

     * View list 
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function Popups() {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $locationData = Popup::orderBy('p_id', 'ASC')->get();
            return view('admin.popup.manage-popup', array('data' => $locationData));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit data
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function EditPopups(Request $request) {

        $validation = Validator::make($request->all(), [
                    'p_title' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('p_title'));
        }
        $name = $request->p_title;
        $status = Popup::where(function($query) use($name) {
                    $query->Where('p_title', $name);
                })
				 ->where('p_id', '!=', $request->p_id)
                ->first();

        if ($status) {
            return redirect()->back()->withErrors(['message', 'Popup already exists']);
        } else {
			
			$cb_image = '';
			if ($request->hasFile('p_image')) {
				$image = $request->file('p_image');
				$cb_image = time() . '.' . $image->getClientOriginalExtension();
	//            $name = time() . str_replace(' ', '_', $request->n_title) . '.' . $image->getClientOriginalExtension();
				$destinationPath = public_path('/upload/popup/');
//				dd($destinationPath);
				$valImage = validateImage($image->getClientOriginalExtension());

				if ($valImage) {

					$image_resize1 = Image::make($image->getRealPath());
					$image_resize1->resize(640, 500);
					$image_resize1->save(public_path('/upload/popup/' . $cb_image));

					$image_resize2 = Image::make($image->getRealPath());
					$image_resize2->resize(633, 256);
					$image_resize2->save(public_path('/upload/popup/th/' . $cb_image));

					$image_resize3 = Image::make($image->getRealPath());
					$image_resize3->resize(200, 200);
					$image_resize3->save(public_path('/upload/popup/thm/' . $cb_image));

	//                $image->move($destinationPath, $n_img);
				} else {
					return redirect()->back()->withErrors(['message', 'Uploaded file is not a valid image. Only JPG, PNG and GIF files are allowed.']);
				}
			}
			
            $name = '';
            $data = Popup::where('p_id', $request->p_id)->first();

            $data_to_update = array();
            $changed_data = array('p_title' => $request->p_title,
                'p_content' => $request->p_content,
				'p_image' => $cb_image == '' ? $data->p_image : $cb_image,
				'p_status' => $request->p_status,
            );
            $diff_in_data_to_save = array();
            $diff_in_data = array_diff_assoc($data->getOriginal(), $changed_data);

            $keys_to_be_updated = array_keys($diff_in_data);

            for ($i = 0; $i < count($keys_to_be_updated); $i++) {
                if (isset($changed_data[$keys_to_be_updated[$i]])) {
                    $data_to_update[$keys_to_be_updated[$i]] = $changed_data[$keys_to_be_updated[$i]];
                    $diff_in_data_to_save[$keys_to_be_updated[$i]] = $diff_in_data[$keys_to_be_updated[$i]];
                }
            }
            $logData = array('subject_id' => $request->p_id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_popup',
                'description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)), 'data_now' => urldecode(http_build_query($changed_data))
            );
            saveQueryLog($logData);

            $updateLocation = Popup::where('p_id', $request->p_id)->update($changed_data);

            if ($updateLocation) {
                return redirect()->back()->with('message', 'Popup successfully updated');
            } else {
                return redirect()->back()->with('message', 'Error while updating the Popup');
            }
        }
    }

    /*

     * Edit data
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function DeletePopup($id) {
        $data = Popup::where('p_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_popup',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())), 'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_popup')->where('p_id', base64_decode($id))->delete();
        if ($status) {
            return redirect()->back()->with('message', 'Popup successfully deleted');
        } else {
            return redirect()->back()->with('message', 'Error while deleting the Popup');
        }
    }

    public function GetPopupData(Request $request) {
        $cat = Popup::Where('p_id', base64_decode($request->id))->first();

        echo json_encode($cat);
    }

}
