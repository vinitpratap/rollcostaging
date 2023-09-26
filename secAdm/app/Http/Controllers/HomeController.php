<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use App\Modal\Visitor;
use App\Exports\CollectionExport;
use App\Exports\CollectionExportAll;

class HomeController extends Controller {
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

     * View list 
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function Visitors(Request $request) {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $query = Visitor::query();
            if (!empty($request->search)) {
                $search = $request->search;
                $query = $query->where(function($query) use ($search) {
                    $query->where('ip_add', 'LIKE', '%' . $search . '%');
                });
            }
            $data = $query->orderby('created_at', 'DESC')
                    ->paginate(10)
                    ->withPath('?search=' . $request->search);
            return view('admin.home.manage-visitor', array('data' => $data));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*
      /*

     * Edit data
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function DeleteVisitor($id) {
        $data = Spare::where('spare_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(), 'table_used' => 'rollco_visitors',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())), 'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_visitors')->where('id', base64_decode($id))->delete();
        if ($status) {
            return redirect()->back()->with('message', 'IP address successfully deleted');
        } else {
            return redirect()->back()->with('message', 'Error while deleting IP address');
        }
    }

    public function SearchNotFoundLists(Request $request) {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $query = DB::table('rollco_search_not_found');

            if (!empty($request->req_date_range)) {
                $dates = explode('and', $request->req_date_range);
                $from = date("Y-m-d H:i:s", strtotime($dates[0]));
                $to = date("Y-m-d H:i:s", strtotime($dates[1]));
            }

            if (!empty($from) && !empty($to)) {

                $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
            }
           
            $data = $query->orderby('created_at', 'DESC')
                    ->paginate(10)
                    ->withPath('?search=' . $request->search);
            return view('admin.home.manage-search-product-not-found', array('data' => $data));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    
    
    public function exportToExcelRequest($status) {
        $exporter = app()->makeWith(CollectionExport::class, compact('status'));
        return $exporter->download(date('Y-m-d-H-i-s').'-Customers_Service_Request.xlsx');
    }
    /*
      /*

     * Edit data
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function DeleteSearchNotFound($id) {
        $data = DB::table('rollco_search_not_found')->where('snf_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(), 'table_used' => 'rollco_search_not_found',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data)), 'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_search_not_found')->where('snf_id', base64_decode($id))->delete();
        if ($status) {
            return redirect()->back()->with('message', 'Search Data successfully deleted');
        } else {
            return redirect()->back()->with('message', 'Error while deleting Search Data');
        }
    }

}
