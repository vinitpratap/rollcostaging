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
use App\Modal\Customer;
use App\Modal\TempUser;
use App\Modal\Usercategory;
use App\Modal\Currency;
use App\Modal\Group;
use App\Modal\SalesCategory;
use App\Modal\UserCategoryTag;
use App\Exports\CustomerExport;

class TempUserController
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

    /*

     * View customers 
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function Tempusers(Request $request) {

        $page_val = 50;
        $pagination_arr = array(50, 100);
        if (Auth::guard('admin')->user()->admin_role == 1) {

            $query = TempUser::query();

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

            if (!empty($request->data_entries)) {
                $page_val = $request->data_entries;
            }

            $pageData = $query->orderby('created_at', 'DESC')
                    ->paginate($page_val)
                    ->withPath('?search=' . $request->search . '&data_entries=' . $page_val);
            $catData = Usercategory::orderBy('cust_cat_nme', 'ASC')->get();
            $custCatData = SalesCategory::select('scat_nm', 'sc_id')->orderBy('scat_nm', 'ASC')->get();
            $currData = Currency::orderBy('curr_name', 'ASC')->get();
            $grpData = Group::orderBy('gr_nm', 'ASC')->get();
            return view('admin.customer.view-tempcustomers',
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

    public function EditTempuser(Request $request) {

        $dataToInsert = array('firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'role' => $request->role,
            'com_emailAddress' => $request->com_emailAddress,
            'streetAddress1' => $request->streetAddress1,
            'streetAddress2' => $request->streetAddress2,
            'com_city' => $request->com_city,
            'com_state' => $request->com_state,
            'com_zipCode' => $request->com_zipCode,
            'com_Telephone' => $request->com_Telephone,
            'com_Fax' => $request->com_Fax,
            'companyName' => $request->companyName,
            'companyWebsite' => $request->companyWebsite,
            'companyRegistrationNumber' => $request->companyRegistrationNumber,
            'companyVatNumber' => $request->companyVatNumber,
            'companyRegAdd1' => $request->companyRegAdd1,
            'companyRegAdd2' => $request->companyRegAdd2,
            'companyRegCity' => $request->companyRegCity,
            'companyRegState' => $request->companyRegState,
            'companyRegZip' => $request->companyRegZip,
            'companyInvAdd1' => $request->companyInvAdd1,
            'companyInvAdd2' => $request->companyInvAdd2,
            'companyInvCity' => $request->companyInvCity,
            'companyInvState' => $request->companyInvState,
            'companyInvZip' => $request->companyInvZip,
            'companyAccountPerName' => $request->companyAccountPerName,
            'companyAccountPerEmail' => $request->companyAccountPerEmail,
            'companyAccountPerMobile' => $request->companyAccountPerMobile,
            'companyAccountPerDepartment' => $request->companyAccountPerDepartment,
            'companyBankName' => $request->companyBankName,
            'companyBankAddress' => $request->companyBankAddress,
            'companyBankPostCode' => $request->companyBankPostCode,
            'companyBankAccount' => $request->companyBankAccount,
            'companyContactNumber' => $request->companyContactNumber,
            'companySortCode' => $request->companySortCode,
            'g_id' => $request->g_id,
            'customerID' => $request->accnt_code,
            'user_status' => $request->user_status,
            'password' => md5('123456'),
        );

        $phone = $request->com_Telephone;
        $email = $request->com_emailAddress;
        $zip = $request->com_zipCode;

        $query = Customer::query();

        $query = $query->where('com_emailAddress', $email);
        //$query = $query->where('lastName', $request->lastName);
//        $query = $query->where(function($query) use ($phone,$email,$zip) {
//            //$query->orWhere('com_Telephone', $phone);
//			$query->orWhere('com_emailAddress', $email);
//			$query->orWhere('com_zipCode', $email,$zip);
//        });

        $st = $query->first();

        //dd($st);

        if ($st) {
            return redirect()->back()->with('message',
                            'the customer already exist ');
        }

        $u_id = $request->u_id;

        $users = TempUser::where('u_id', '=', ($u_id))->first();

        $logData = array('subject_id' => base64_decode($u_id), 'user_id' => Auth::id(),
            'table_used' => 'rollco_ms_tmpusers',
            'description' => 'approve', 'data_prev' => urldecode(http_build_query($users->toArray())),
            'data_now' => ''
        );

        saveQueryLog($logData);

        $checkUser = Customer::select('u_id')->where('com_emailAddress', $dataToInsert['com_emailAddress'])->first();

        if ($checkUser) {
            return redirect()->back()->withErrors(['message', 'User already exist']);
        }
//        dd($dataToInsert);
        //unset($dataToInsert['_token']);
        //unset($dataToInsert['u_id']);


        $id = Customer::insertGetId($dataToInsert);
        $name = $dataToInsert['companyName'];
        $com_zipCode = $dataToInsert['com_zipCode'];

        DB::table('rollco_salescal')->where('full_name', $name)->where('post_code', $com_zipCode)->update(array("u_id" => $id, "temp_id" => 0));

        DB::table('rollco_salescallog')->where('full_name', $name)->where('post_code', $com_zipCode)->update(array("u_id" => $id, "temp_id" => 0));

        $status = DB::table('rollco_ms_tmpusers')->where('firstName', $request->companyName)->where('com_zipCode', $request->com_zipCode)->delete();

        if ($status) {
            return redirect('admin/view-tempuser')->with('message',
                            'temp customer successfully approved');
        } else {
            return redirect()->back()->withErrors(['message', 'error while approving temp customer']);
        }
    }

    public function GetTempuserData1(Request $request, $id) {
        $page_val = 50;
        $pagination_arr = array(50, 100);
        if (Auth::guard('admin')->user()->admin_role == 1) {

            $query = TempUser::query();

            if (!empty($request->search)) {
                $search = $request->search;

                $query = $query->where(function ($query) use ($search) {
                    $query->where('firstName', 'LIKE', '%' . $search . '%');
                    $query->orWhere('lastName', 'LIKE', '%' . $search . '%');
                    $query->orWhere('com_city', 'LIKE', '%' . $search . '%');
                    $query->orWhere('com_zipCode', 'LIKE', '%' . $search . '%');
                    $query->orWhere('customerID', 'LIKE', '%' . $search . '%');
                    $query->orWhere('companyName', 'LIKE', '%' . $search . '%');
                });
            }

            if (!empty($request->data_entries)) {
                $page_val = $request->data_entries;
            }

            $pageData = $query->orderby('created_at', 'DESC')
                    ->paginate($page_val)
                    ->withPath('?search=' . $request->search . '&data_entries=' . $page_val);
            $catData = Usercategory::orderBy('cust_cat_nme', 'ASC')->get();
            $custCatData = SalesCategory::select('scat_nm', 'sc_id')->orderBy('scat_nm', 'ASC')->get();
            $currData = Currency::orderBy('curr_name', 'ASC')->get();
            $grpData = Group::orderBy('gr_nm', 'ASC')->get();
            $users = TempUser::Where('u_id', base64_decode($id))->first();

            return view('admin.customer.view-tempcustomers',
                    array('data' => $pageData, 'catData' => $catData, 'currency' => $currData,
                        'groupData' => $grpData, 'data_entries' => $page_val, 'pagination_arr' => $pagination_arr, 'custCatData' => $custCatData, 'tempData' => $users));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function DeleteTempuser($id) {
        $users = TempUser::where('u_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(),
            'table_used' => 'rollco_ms_tmpusers',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($users->toArray())),
            'data_now' => ''
        );

        saveQueryLog($logData);

        $status = DB::table('rollco_ms_tmpusers')->where('u_id', base64_decode($id))->delete();
        if ($status) {
            return redirect()->back()->with('message',
                            'temp customer successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'error while deleting temp customer');
        }
    }

    public function GetTempuserData(Request $request) {
        $users = TempUser::Where('u_id', base64_decode($request->id))->first();
        $userCatData = UserCategoryTag::where('u_id', base64_decode($request->id))->get();

        echo json_encode(array('users' => $users, 'userCatData' => $userCatData));
    }

    function SearchCustomer(Request $request) {

        if ($request->get('query')) {
            $query = DB::table('rollco_ms_cust')
                    ->select('cust_id', 'cust_nme');
            $ser = $request->get('query');
            $query = $query->where(function ($query) use ($ser) {
                $query->where('cust_nme', 'LIKE', '%' . $ser . '%');
                $query->orWhere('cust_mobile', 'LIKE', '%' . $ser . '%');
                $query->orWhere('cust_email', 'LIKE', '%' . $ser . '%');
            });
            $data = $query->get();
            if (count($data) > 0) {
                $output = '<ul class="dropdown-menu usrlist" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $output .= '
       <li class="userlist" id="' . base64_encode($row->cust_id) . '"><a href="#" >' . $row->cust_nme . '</a></li>
       ';
                }
                $output .= '</ul>';
                echo $output;
            } else {
                echo "No Customers Found";
            }
        }
    }

    public function exportToExcelCustomer() {
        $exporter = app()->makeWith(CustomerExport::class);
        return $exporter->download(date('Y-m-d-H-i-s') . '-customer.xlsx');
    }

    public function UploadUser(Request $request) {
        if (Auth::guard('admin')->user()->admin_role == 1) {


            if (Input::hasFile('user_file')) {
                $file = Input::file('user_file');
                if ($file->getClientOriginalExtension() == 'csv') {
                    $name = $file->getClientOriginalName();

                    $name = preg_replace("/[^\.\-\_a-zA-Z0-9]/", "", $name);
                    //Not really uniqe - but for all practical reasons, it is
                    $uniqer = substr(md5(uniqid(rand(), 1)), 0, 6);
                    $name = $uniqer . '_' . $name; //Get Unique Name
//                $path = public_path('/upload/csv');
                    $path = public_path('/upload/product-entity');
                    // Moves file to folder on server
                    $file->move($path, $name);
                    $file1 = public_path('/upload/product-entity/' . $name);
                    $productArr = csvToArray($file1);
//                 dd($productArr);

                    for ($i = 0; $i < count($productArr); $i++) {

                        $prdata = [];
                        $username = '';
                        $email = '';
                        $pwd = '';
                        $GroupCode = '';
                        $CompanyName = '';
                        $Country = '';
                        $CurrencyName = '';
                        $regisdate = '';
                        $status = '';
                        $IPAddress = '';
                        if (isset($productArr[$i]['username']))
                            $username = trim($productArr[$i]['username']);
                        if (isset($productArr[$i]['email']))
                            $email = trim($productArr[$i]['email']);
                        if (isset($productArr[$i]['pwd']))
                            $pwd = trim($productArr[$i]['pwd']);
                        if (isset($productArr[$i]['GroupCode']))
                            $GroupCode = trim($productArr[$i]['GroupCode']);
                        if (isset($productArr[$i]['CompanyName']))
                            $CompanyName = trim($productArr[$i]['CompanyName']);
                        if (isset($productArr[$i]['Country']))
                            $Country = trim($productArr[$i]['Country']);
                        if (isset($productArr[$i]['CurrencyName']))
                            $CurrencyName = trim($productArr[$i]['CurrencyName']);
                        if (isset($productArr[$i]['regisdate']))
                            $regisdate = trim($productArr[$i]['regisdate']);
                        if (isset($productArr[$i]['status']))
                            $status = trim($productArr[$i]['status']);
                        if (isset($productArr[$i]['IPAddress']))
                            $IPAddress = trim($productArr[$i]['IPAddress']);


                        $grpid = Group::select('gr_id')->where('gr_nm', $GroupCode)->first();
                        if ($grpid) {

                            if ($email != '') {
                                $prstatus = Customer::select('u_id')->where('firstName', $username)->where('com_emailAddress', $email)->first();
                                $prdata = ['firstName' => $username, 'com_emailAddress' => $email, 'password' => md5($pwd), 'g_id' => $grpid['gr_id'], 'companyName' => $CompanyName, 'Country' => $Country, 'CurrencyName' => $CurrencyName, 'regisdate' => date('Y-m-d', strtotime($regisdate)), 'IPAddress' => $IPAddress, 'user_status' => $status];
                                if ($prstatus) {
                                    
                                } else {
//                    var_dump($data);

                                    $prid = Customer::create($prdata);
                                }
                            }
                        } elseif ($status == 0) {

                            if ($email != '') {
                                $prstatus = Customer::select('u_id')->where('firstName', $username)->where('com_emailAddress', $email)->first();
                                $prdata = ['firstName' => $username, 'com_emailAddress' => $email, 'password' => md5($pwd), 'g_id' => 0, 'companyName' => $CompanyName, 'Country' => $Country, 'CurrencyName' => $CurrencyName, 'regisdate' => date('Y-m-d', strtotime($regisdate)), 'IPAddress' => $IPAddress, 'user_status' => $status];

                                if ($prstatus) {
                                    
                                } else {
//                    var_dump($data);

                                    $prid = Customer::create($prdata);
                                }
                            }
                        } else {

                            return redirect()->back()->withErrors(['message', 'Group not found -> ' . $GroupCode]);
                        }
                    }


                    return redirect()->back()->with('message',
                                    'User successfully uploaded.');
                } else {
                    return redirect()->back()->withErrors(['message', 'file format is not csv']);
                }
            }
            return view('admin.customer.upload-user');
//            else {
//                $makeData = Make::orderBy('make_nm', 'ASC')->get();
//                $data = Spare::orderBy('created_at', 'DESC')->get();
//                return view('admin.product.uploadspare',
//                        array('data' => $data, 'make' => $makeData));
//            }
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function exportToCSVTempCust(Request $request) {

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . date('Y-m-d-H-i-s') . "-tempcust.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $query = DB::table('rollco_ms_tmpusers')
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
        //return Response::stream($callback, 200, $headers);
    }

}
