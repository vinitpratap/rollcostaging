<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\Modal\Announcement;

class AnnouncementController extends Controller {
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
    public function AddNewAnnouncement(Request $request) {

        $validation = Validator::make($request->all(), [
                    'announcement_text' => 'required',
                    'announcement_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('announcement_text', 'announcement_status'));
        }


        $status = Announcement::where('announcement_text', $request->announcement_text)
                ->first();

        if ($status) {
            return redirect()->back()->withErrors(['message', 'Announcement already exists']);
        } else {

            $dataToInsert = array('announcement_text' => $request->announcement_text,
                'announcement_status' => $request->announcement_status
            );
            $id = Announcement::create($dataToInsert)->id;
            $logData = array('subject_id' => $id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_announcement',
                'description' => 'insert', 'data_prev' => '', 'data_now' => urldecode(http_build_query($request->all()))
            );
            saveQueryLog($logData);
            if ($id) {
                return redirect()->back()->with('message', 'Announcement successfully created');
            } else {
                return redirect()->back()->with('message', 'Error while creating announcement');
            }
        }
    }

    /*

     * View customers 
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function Announcements() {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $data = Announcement::orderBy('created_at', 'ASC')->get();
            return view('admin.announcement.manage-announcement', array('data' => $data));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function EditAnnouncement(Request $request) {

        $validation = Validator::make($request->all(), [
                    'announcement_text' => 'required',
                    'announcement_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('announcement_text', 'announcement_status'));
        }


        $status = Announcement::where('announcement_text', $request->announcement_text)
                ->where('announcement_id', '!=', $request->announcement_id)
                ->first();
        if ($status) {
            return redirect()->back()->withErrors(['message', 'Announcement already exists']);
        } else {
            $data = Announcement::Where('announcement_id', $request->announcement_id)->first();
            //dd($data);

            $changed_data = array('announcement_text' => $request->announcement_text,
                'announcement_status' => $request->announcement_status
            );

            $diff_in_data = array_diff_assoc($data->getOriginal(), $changed_data);
            $diff_in_data_to_save = array();
            $keys_to_be_updated = array_keys($diff_in_data);

            for ($i = 0; $i < count($keys_to_be_updated); $i++) {
                if (isset($changed_data[$keys_to_be_updated[$i]])) {
                    $data_to_update[$keys_to_be_updated[$i]] = $changed_data[$keys_to_be_updated[$i]];
                    $diff_in_data_to_save[$keys_to_be_updated[$i]] = $diff_in_data[$keys_to_be_updated[$i]];
                }
            }
            $logData = array('subject_id' => $request->announcement_id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_announcement', 'description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)), 'data_now' => urldecode(http_build_query($changed_data))
            );
            //dd($logData);
            saveQueryLog($logData);
            $updateCat = Announcement::Where('announcement_id', $request->announcement_id)->update($changed_data);
            if ($updateCat) {
                return redirect('admin/view-announcement')->with('message', 'Announcement successfully updated');
            } else {
                return redirect()->back()->with('message', 'Error while updating announcement');
            }
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function DeleteAnnouncement($id) {

        $data = Announcement::where('announcement_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_announcement',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())), 'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_announcement')->where('announcement_id', base64_decode($id))->delete();
        if ($status) {
            return redirect('admin/view-announcement')->with('message', 'Announcement successfully deleted');
        } else {
            return redirect()->back()->with('message', 'Error while deleting announcement');
        }
    }

    public function GetAnnouncementData(Request $request) {
        $cat = Announcement::Where('announcement_id', base64_decode($request->id))->first();

        echo json_encode($cat);
    }

}
