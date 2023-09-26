<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\Modal\Contact;
use App\Modal\Enquiry;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EnquiryExport;
use App\Exports\ContactExport;
use App\Exports\SNFExport;
use App\Exports\SNFExportAll;
use App\Exports\RSExport;

class ContactController extends Controller {
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
    public function Contacts(Request $request) {
        $page_val = 50;
        $pagination_arr = array(50, 100);

        if (Auth::guard('admin')->user()->admin_role == 1) {

            $query = Contact::query();

            if (!empty($request->search)) {
                $search = $request->search;

                $query = $query->where(function($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%');
                    $query->orWhere('email', 'LIKE', '%' . $search . '%');
                    $query->orWhere('mobile', 'LIKE', '%' . $search . '%');
                });
            }

            if (!empty($request->data_entries)) {
                $page_val = $request->data_entries;
            }
            $pageData = $query->orderby('created_at', 'DESC')
                    ->paginate($page_val)
                    ->withPath('?search=' . $request->search.'&data_entries='.$page_val);


            $data = [];
//            $data = Group::with('getCurrency')->orderBy('created_at', 'DESC')->get();
//            dd($data);
            return view('admin.contact.view-contacts',
                    array('data' => $pageData, 'data_entries' => $page_val, 'pagination_arr' => $pagination_arr));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function DeleteContact($id) {
        $data = Contact::where('id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(),
            'table_used' => 'rollco_contactus',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())),
            'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_contactus')->where('id', base64_decode($id))->delete();
        $status = true;
        if ($status) {
            return redirect('admin/view-contacts')->with('message',
                            'Contact successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'error while deleting group');
        }
    }

    public function DeleteContactAjax(Request $request) {
        $status = DB::table('rollco_contactus')->whereIn('id',
                        $request['ids'])->delete();
        if ($status) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function Enquiries(Request $request) {
        $page_val = 50;
        $pagination_arr = array(50, 100);
        if (Auth::guard('admin')->user()->admin_role == 1) {

            $query = Enquiry::query();

            if (!empty($request->search)) {
                $search = $request->search;

                $query = $query->where(function($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%');
                    $query->orWhere('email', 'LIKE', '%' . $search . '%');
                    $query->orWhere('mobile', 'LIKE', '%' . $search . '%');
                });
            }

            if (!empty($request->data_entries)) {
                $page_val = $request->data_entries;
            }

            $pageData = $query->orderby('created_at', 'DESC')
                    ->paginate($page_val)
                    ->withPath('?search=' . $request->search.'&data_entries='.$page_val);


            $data = [];
//            $data = Group::with('getCurrency')->orderBy('created_at', 'DESC')->get();
//            dd($data);
            return view('admin.contact.view-enquiry',
                    array('data' => $pageData, 'pagination_arr' => $pagination_arr));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function Deleteenquiry($id) {
        $data = Enquiry::where('id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(),
            'table_used' => 'rollco_enquirenow',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())),
            'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_enquirenow')->where('id', base64_decode($id))->delete();
        $status = true;
        if ($status) {
            return redirect('admin/view-enquiry')->with('message',
                            'Enquiry successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'error while deleting group');
        }
    }

    public function DeleteEnquiryAjax(Request $request) {
        $status = DB::table('rollco_enquirenow')->whereIn('id',
                        $request['ids'])->delete();
        if ($status) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function SearchNotFound(Request $request) {
        $page_val = 50;
        $pagination_arr = array(50, 100);
        if (Auth::guard('admin')->user()->admin_role == 1) {

//        $query = Enquiry::query();
            $query = DB::table('rollco_search_not_found');


            if (!empty($request->search)) {
                $search = $request->search;

                $query = $query->where(function($query) use ($search) {
                    $query->where('snf_make', 'LIKE', '%' . $search . '%');
                    $query->orWhere('snf_model', 'LIKE', '%' . $search . '%');
                    $query->orWhere('snf_yr', 'LIKE', '%' . $search . '%');
                    $query->orWhere('snf_cc', 'LIKE', '%' . $search . '%');
                    $query->orWhere('snf_user', 'LIKE', '%' . $search . '%');
                });
            }
            if (!empty($request->data_entries)) {
                $page_val = $request->data_entries;
            }
            $pageData = $query->orderby('created_at', 'DESC')
                    ->paginate($page_val)
                    ->withPath('?search=' . $request->search.'&data_entries='.$page_val);


            $data = [];
//            $data = Group::with('getCurrency')->orderBy('created_at', 'DESC')->get();
//            dd($data);
            return view('admin.contact.view-search-not-found',
                    array('data' => $pageData, 'data_entries' => $page_val, 'pagination_arr' => $pagination_arr));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function DeleteSearchNotFound($id) {
        $status = DB::table('rollco_search_not_found')->where('snf_id',
                        base64_decode($id))->delete();
        $status = true;
        if ($status) {
            return redirect('admin/view-search-not-found')->with('message',
                            'Search Not Found
 successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'error while deleting group');
        }
    }

    public function DeleteSearchNotFoundAjax(Request $request) {
        $status = DB::table('rollco_search_not_found')->whereIn('snf_id',
                        $request['ids'])->delete();
        if ($status) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function SearchRecent(Request $request) {
        $page_val = 50;
        $pagination_arr = array(50, 100);
        if (Auth::guard('admin')->user()->admin_role == 1) {

//        $query = Enquiry::query();
            $query = DB::table('rollco_search_found as sr')
                    ->select('usr.firstName', 'usr.lastName',
                    'usr.com_emailAddress', 'usr.com_Telephone', 'prod.prod_nm',
                    'prod.prod_part_no', 'spr.spare_nm', 'spr.spare_part_no',
                    'sr.created_at', 'sr.u_ip', 'sr.sf_id');

            $query = $query->join('rollco_ms_users as usr', 'usr.u_id', '=',
                    'sr.user_id');
            $query = $query->leftjoin('rollco_ms_product as prod',
                    'prod.prod_id', '=', 'sr.prod_id');
            $query = $query->leftjoin('rollco_ms_spare as spr', 'spr.spare_id',
                    '=', 'sr.spr_id');


            if (!empty($request->search)) {
                $search = $request->search;

                $query = $query->where(function($query) use ($search) {
                    $query->where('usr.firstName', 'LIKE', '%' . $search . '%');
                    $query->orWhere('usr.lastName', 'LIKE', '%' . $search . '%');
                    $query->orWhere('usr.com_emailAddress', 'LIKE',
                            '%' . $search . '%');
                    $query->orWhere('usr.com_Telephone', 'LIKE',
                            '%' . $search . '%');
                    $query->orWhere('prod.prod_nm', 'LIKE', '%' . $search . '%');
                    $query->orWhere('prod.prod_part_no', 'LIKE',
                            '%' . $search . '%');
                    $query->orWhere('spr.spare_nm', 'LIKE', '%' . $search . '%');
                    $query->orWhere('spr.spare_part_no', 'LIKE',
                            '%' . $search . '%');
                });
            }

            if (!empty($request->data_entries)) {
                $page_val = $request->data_entries;
            }

            $pageData = $query->orderby('sr.created_at', 'DESC')
                    ->paginate($page_val)
					->withPath('?search=' . $request->search.'&data_entries='.$page_val);

            //dd($pageData);
            $data = [];
//            $data = Group::with('getCurrency')->orderBy('created_at', 'DESC')->get();
//            dd($data);
            return view('admin.contact.view-recent-viewed',
                    array('data' => $pageData, 'data_entries' => $page_val, 'pagination_arr' => $pagination_arr));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function DeleteSearchRecent($id) {
        $status = DB::table('rollco_search_found')->where('sf_id',
                        base64_decode($id))->delete();
        $status = true;
        if ($status) {
            return redirect()->back()->with('message',
                            'Recent Search 
 successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'error while deleting recent');
        }
    }

    public function DeleteSearchRecentAjax(Request $request) {
        $status = DB::table('rollco_search_found')->whereIn('sf_id',
                        $request['ids'])->delete();
        if ($status) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function exportToExcelRequest() {
        $exporter = app()->makeWith(EnquiryExport::class);
        return $exporter->download(date('Y-m-d-H-i-s') . '-enquiry.xlsx');
    }

    public function exportToExcelContact() {
        $exporter = app()->makeWith(ContactExport::class);
        return $exporter->download(date('Y-m-d-H-i-s') . '-contact.xlsx');
    }

    public function exportToExcelSNF() {
        $exporter = app()->makeWith(SNFExport::class);
        return $exporter->download(date('Y-m-d-H-i-s') . '-search-not-found.xlsx');
    }
    
    public function exportToExcelSNFAll() {
        $exporter = app()->makeWith(SNFExportAll::class);
        return $exporter->download(date('Y-m-d-H-i-s') . '-search-not-found-all.xlsx');
    }

    public function exportToExcelRP() {
        $exporter = app()->makeWith(RSExport::class);
        return $exporter->download(date('Y-m-d-H-i-s') . '-search-recent.xlsx');
    }

}
