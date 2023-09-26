<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\Modal\News;

class NewsController extends Controller {
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
    public function AddNewNews(Request $request) {
        //dd($request->all());
        $validation = Validator::make($request->all(), [
                    'news_text' => 'required',
                    'news_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('news_text', 'news_status'));
        }


        $status = News::where('news_text',$request->news_text)
                ->first();

        if ($status) {
            return redirect()->back()->withErrors(['message', 'News already exists']);
        } else {

            $id = News::create($request->all())->id;
            $logData = array('subject_id' => $id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_news',
                'description' => 'insert', 'data_prev' => '', 'data_now' => urldecode(http_build_query($request->all()))
            );
            saveQueryLog($logData);
            if ($id) {
                return redirect()->back()->with('message', 'News successfully created');
            } else {
                return redirect()->back()->with('message', 'Error while creating news');
            }
        }

    }

    /*

     * View customers 
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function News() {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $data = News::orderBy('created_at', 'ASC')->get();
            return view('admin.news.manage-news', array('data' => $data));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function EditNews(Request $request) {

        $validation = Validator::make($request->all(), [
                    'news_text' => 'required',
                    'news_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('news_text', 'news_status'));
        }


        $status = News::where('news_text',$request->news_text)
                ->where('news_id', '!=', $request->news_id)
                ->first();
        if ($status) {
            return redirect()->back()->withErrors(['message', 'News already exists']);
        } else {
            $data = News::Where('news_id', $request->news_id)->first();
            //dd($data);
            
            $changed_data = array('news_text'=>$request->news_text,
                                   'news_status'=>$request->news_status
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
            $logData = array('subject_id' => $request->news_id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_news','description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)), 'data_now' => urldecode(http_build_query($changed_data))
            );
            //dd($logData);
            saveQueryLog($logData);
            $updateCat = News::Where('news_id', $request->news_id)->update($changed_data);
            if ($updateCat) {
                return redirect('admin/view-news')->with('message', 'News successfully updated');
            } else {
                return redirect()->back()->with('message', 'Error while updating news');
            }
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function DeleteNews($id) {

        $data = News::where('news_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_news',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())), 'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_news')->where('news_id', base64_decode($id))->delete();
        if ($status) {
            return redirect('admin/view-news')->with('message', 'News successfully deleted');
        } else {
            return redirect()->back()->with('message', 'Error while deleting news');
        }
    }

    public function GetNewsData(Request $request) {
        $cat = News::Where('news_id', base64_decode($request->id))->first();
        $data = array(
            'news_id' => $cat['news_id'],
            'news_text' => $cat['news_text'],
            'news_status' => $cat['news_status'],
        );
        echo json_encode($data);
    }

}
