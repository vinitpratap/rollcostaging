<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\Modal\Newsletter;
use App\Exports\NewsLetterExport;

class NewsletterController extends Controller {
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

    /*

     * View customers 
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function Newsletters() {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $data = [];
            $newsletterData = Newsletter::orderBy('created_at', 'ASC')->get();

            return view('admin.CMS.newsletter', array('data' => $newsletterData));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function DeleteNewsletter($id) {
        $data = Newsletter::where('nl_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(),
            'table_used' => 'rollco_ms_newsletter',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())),
            'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_newsletter')->where('nl_id',
                        base64_decode($id))->delete();
        if ($status) {
            return redirect()->back()->with('message',
                            'newsletter successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'error while deleting newsletter');
        }
    }

    public function exportToExcelNewsLtr() {
        $exporter = app()->makeWith(NewsLetterExport::class);
        return $exporter->download(date('Y-m-d-H-i-s') . '-newsletter.xlsx');
    }

}
