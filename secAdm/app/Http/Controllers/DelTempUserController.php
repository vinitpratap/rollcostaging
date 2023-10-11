<?php

namespace App\Http\Controllers;

ini_set('max_execution_time', '0');

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Mail;
use Illuminate\Support\Facades\Input;
use App\Modal\Admin;
use App\Modal\DelTempUser;
use App\Modal\Usercategory;
use App\Modal\Currency;
use App\Modal\Group;
use App\Modal\SalesCategory;
use App\Modal\UserCategoryTag;
use App\Exports\DelCustomerExport;

class DelTempUserController
        extends Controller {
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
    /*

     * View customers 
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function DelTempUsers(Request $request) {

        $page_val = 50;
        $pagination_arr = array(50, 100);
        if (Auth::guard('admin')->user()->admin_role == 1) {

            $query = DelTempUser::query();

            if (!empty($request->search)) {
                $search = $request->search;

                $query = $query->where(function ($query) use ($search) {
                    //$query->where('firstName', 'LIKE', '%' . $search . '%');
                    //$query->orWhere('lastName', 'LIKE', '%' . $search . '%');
                    $query->orwhere('companyName', 'LIKE', '%' . $search . '%');
                    $query->orWhere('com_emailAddress', 'LIKE', '%' . $search . '%');
                    $query->orWhere('com_Telephone', 'LIKE', '%' . $search . '%');
                    $query->orWhere('com_city', 'LIKE', '%' . $search . '%');
                    $query->orWhere('com_zipCode', 'LIKE', '%' . $search . '%');
                });
            }

            if (!empty($request->data_entries)) {
                $page_val = $request->data_entries;
            }

            $pageData = $query->orderby('created_at', 'ASC')
                    ->paginate($page_val)
                    ->withPath('?search=' . $request->search . '&data_entries=' . $page_val);
            $catData = Usercategory::orderBy('cust_cat_nme', 'ASC')->get();
            $custCatData = SalesCategory::select('scat_nm', 'sc_id')->orderBy('scat_nm', 'ASC')->get();
            $currData = Currency::orderBy('curr_name', 'ASC')->get();
            $grpData = Group::orderBy('gr_nm', 'ASC')->get();
            return view('admin.customer.view-deltempusers',
                    array('data' => $pageData, 'catData' => $catData, 'currency' => $currData,
                        'groupData' => $grpData, 'data_entries' => $page_val, 'pagination_arr' => $pagination_arr, 'custCatData' => $custCatData));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function EditCustomer(Request $request) {

//        if (isset($request->custCat) && count($request->custCat) > 0) {
//            for ($i = 0; $i < count($request->custCat); $i++) {
//                $custcatData = UserCategoryTag::where('u_id', $request->u_id)->where('cat_id', $request->custCat[$i])->where('uct_status', 1)->first();
//                if ($custcatData) {
//                    UserCategoryTag::where('u_id', $request->u_id)->where('cat_id', $request->custCat[$i])->update(array('u_id' => $request->u_id, 'cat_id' => $request->custCat[$i], 'uct_status' => 1));
//                } else {
//                    $custcatStatus = UserCategoryTag::where('u_id', $request->u_id)->where('cat_id', $request->custCat[$i])->first();
//                    if ($custcatStatus) {
//                        UserCategoryTag::where('u_id', $request->u_id)->where('cat_id', $request->custCat[$i])->update(array('uct_status' => 0));
//                    } else {
//                        UserCategoryTag::create(array('u_id' => $request->u_id, 'cat_id' => $request->custCat[$i], 'uct_status' => 1));
//                    }
//                }
//            }
//        }


        $users = Customer::where('u_id', $request->u_id)->first();

        $changed_data = $request->all();

        $diff_in_data = array_diff_assoc($request->all(), $users->getOriginal());

        $keys_to_be_updated = array_keys($diff_in_data);

        $data_to_update = [];
        $diff_in_data_to_save = [];
        for ($i = 0; $i < count($keys_to_be_updated); $i++) {
            if (isset($changed_data[$keys_to_be_updated[$i]])) {
                $data_to_update[$keys_to_be_updated[$i]] = $changed_data[$keys_to_be_updated[$i]];
                $diff_in_data_to_save[$keys_to_be_updated[$i]] = $diff_in_data[$keys_to_be_updated[$i]];
            }
        }

        $logData = array('subject_id' => $request->u_id, 'user_id' => Auth::id(),
            'table_used' => 'rollco_ms_users',
            'description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)),
            'data_now' => urldecode(http_build_query($data_to_update))
        );

        //dd($diff_in_data);
        saveQueryLog($logData);
        unset($diff_in_data['_token']);
        unset($diff_in_data['custCat']);

        $updateUser = Customer::where('u_id', $request->u_id)->update($diff_in_data);

        /* -------------------update user status to new agency------------------------ */
        updatestatus($request->u_id);
        /* -------------------update user status to new agency end-------------------- */

        if ($updateUser) {
            return redirect()->back()->with('message',
                            'customer successfully updated');
        } else {
            return redirect()->back()->with('message',
                            'error while updating customer');
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function DeleteDelTempUser($id) {
        $users = DelTempUser::where('u_id', '=', base64_decode($id))->first();

        //dd($users->toArray());
        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(),
            'table_used' => 'rollco_ms_tmpusers_deleted',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($users->toArray())),
            'data_now' => ''
        );

        saveQueryLog($logData);

        $status = DB::table('rollco_ms_tmpusers_deleted')->where('u_id', base64_decode($id))->delete();
        if ($status) {
            return redirect()->back()->with('message',
                            'customer successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'error while deleting customer');
        }
    }

    public function RestoreDelTempUserData(Request $request) {
        $users = DelTempUser::Where('u_id', base64_decode($request->id))->first();

        $usersArr = $users->toArray();


        $checkUser = DB::table('rollco_ms_tmpusers')
                        ->select('u_id')->Where('u_id', base64_decode($request->id))->first();
        if ($checkUser) {
            
        } else {
            DB::table('rollco_ms_tmpusers')->insert($usersArr);
            DB::table('rollco_ms_tmpusers_deletelog')->insert(array('cust_id' => $usersArr['u_id'], 'res_datetime' => date('Y-m-d H:i:s'), 'res_by' => Auth::id(), 'res_ip' => $_SERVER['REMOTE_ADDR']));
            DB::table('rollco_ms_tmpusers_deleted')->where('u_id', base64_decode($request->id))->delete();
        }
        echo json_encode(array('status' => 1));
    }

    public function exportToExcelDelTempUser() {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . date('Y-m-d-H-i-s') . "-deletedtempcust.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $query = DB::table('rollco_ms_tmpusers_deleted')
                ->select('firstName', 'lastName', 'com_zipCode', 'com_city', 'customerID', 'created_at'); //'mscode.MsCode', 'mscode.V8Key'

        if (!empty($request->search)) {
            $search = $request->search;

            $query = $query->where(function ($query) use ($search) {
                $query->where('firstName', 'LIKE', '%' . $search . '%');
                $query->orWhere('lastName', 'LIKE', '%' . $search . '%');
                $query->orWhere('com_city', 'LIKE', '%' . $search . '%');
                $query->orWhere('com_zipCode', 'LIKE', '%' . $search . '%');
                $query->orWhere('customerID', 'LIKE', '%' . $search . '%');
            });
        }

        $reqData = $query->orderBy('firstName', 'ASC')
                ->get();
        //dd($reqData);



        $columns = array("Company Name", "Post Code", " County/ Town", "Sales Person", "Temp Account Code", "Created Date", "Email ID", "Group", " Account Code");

        $callback = function () use ($reqData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($reqData as $review) {
                $uname = '';
                $query1 = DB::table('rollco_salescal as sales')
                        ->select('users.firstName as uname')
                        ->where('sales.post_code', $review->com_zipCode);
                $query1 = $query1->join('rollco_ms_users as users', 'users.u_id', '=',
                        'sales.sec_id');

                $query1 = $query1->where('sales.full_name', 'LIKE', '%' . $review->firstName . ' ' . $review->lastName . '%');
                $resData1 = $query1->first();

                if (($resData1) && $resData1->uname != '') {
                    $uname = $resData1->uname;
                } else {
                    $uname = 'Unknown';
                }
                //dd($resData1);
                fputcsv($file, array($review->firstName . ' ' . $review->lastName,
                    $review->com_zipCode,
                    $review->com_city,
                    $uname,
                    $review->customerID,
                    $review->created_at, '', '', ''));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

}
