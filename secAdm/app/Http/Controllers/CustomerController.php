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
use App\Modal\Usercategory;
use App\Modal\Currency;
use App\Modal\Group;
use App\Modal\SalesCategory;
use App\Modal\UserCategoryTag;
use App\Exports\CustomerExport;

class CustomerController
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
    public function AddNewCustomer(Request $request) {

        //dd($request->all());
        $prefix = "RS";
        $validation = Validator::make($request->all(),
                        [
                            'cust_email' => 'required|email',
                            'cust_mobile' => 'required|numeric',
                            'cust_comp' => 'required',
                            'cust_city' => 'required',
                            'cust_prov' => 'required',
                            'cust_zip' => 'required',
                            'cust_country' => 'required',
                            'cust_contact' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('cust_email',
                                    'cust_mobile', 'cust_comp', 'cust_city',
                                    'cust_prov', 'cust_zip', 'cust_country',
                                    'cust_contact'));
        }
        $users = Customer::Where('cust_email', $request->cust_mobile)->first();

        if ($users) {
            return redirect()->back()->withErrors(['message', 'User email already exists Please use different email']);
        } else {

//            debug($request->all());
            $dataToInsert = array('cust_nme' => $request->cust_nme,
                'cust_nme' => $request->cust_nme,
                'custcatid' => $request->custcatid,
                'cust_email' => $request->cust_email,
                'cust_comp' => $request->cust_comp,
                'cust_service_add1' => $request->cust_service_add1,
                'cust_service_add2' => $request->cust_service_add2,
                'cust_city' => $request->cust_city,
                'cust_prov' => $request->cust_prov,
                'cust_zip' => $request->cust_zip,
                'cust_country' => $request->cust_country,
                'cust_contact' => $request->cust_contact,
                'cust_mobile' => $request->cust_mobile,
                'custcurr' => $request->custcurr,
                'cust_status' => $request->cust_status,
            );
            // dd($dataToInsert);
            $id = Customer::create($dataToInsert)->id;
            $custPwd = rand_pass(6);

            $data = array('custName' => $request->cust_nme, 'mobileNumber' => $request->cust_mobile,
                'password' => $custPwd, 'siteurl' => 'https://www.rollingcomponents.com/');

            if ($_SERVER['HTTP_HOST'] != 'localhost') {
                $retval = Mail::send('admin.emails.user_new_registration',
                                $data,
                                function ($message) use ($request) {

                                    $message->from('noreply@rollingcomponents.com',
                                            'Rolling Components');
                                    $message->to($request->cust_email);
                                    $message->subject('New Customer Registration');
                                });
            }

            $idTosave = 1000 + $id;
            $dataTosave = array('cust_code' => $prefix . date("y") . $idTosave, 'cust_pwd' => md5($custPwd));

            $logData = array('subject_id' => $id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_cust',
                'description' => 'insert', 'data_prev' => '', 'data_now' => urldecode(http_build_query($request->all()))
            );

            saveQueryLog($logData);
            if ($id) {
                Customer::where('cust_id', $id)->update($dataTosave);
                return redirect()->back()->with('message',
                                'customer successfully created');
            } else {
                return redirect()->back()->with('message',
                                'error while creating customer');
            }
        }
    }

    /*

     * View customers 
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function Customers(Request $request, $type, $id) {

        $page_val = 50;
        $pagination_arr = array(50, 100);
        if (Auth::guard('admin')->user()->admin_role == 1) {

            $query = Customer::query();

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
            switch ($type) {
                case 'approve':
                    //$query = $query->where('user_status', '=', '2');
                    $query = $query->where(function ($query) {
                        $query->where('user_status', '=', '2');
                        $query->orwhere('user_status', '=', '4');
                    });
                    break;
                case 'pending':
                    $query = $query->where('user_status', '=', '1');
                    $query = $query->where('c_verified', '=', '1');
                    break;
                case 'blocked':
                    $query = $query->where('user_status', '=', '0');
                    break;
                case 'unverified':
                    $query = $query->where('user_status', '=', '1');
                    $query = $query->where('c_verified', '=', '0');
                    break;
                default :
                    break;
            }
            $query = $query->where('companyName', '!=', '');
            $pageData = $query->orderby('companyName', 'ASC')
                    ->paginate($page_val)
                    ->withPath('?search=' . $request->search . '&data_entries=' . $page_val);
            $catData = Usercategory::orderBy('cust_cat_nme', 'ASC')->get();
            $custCatData = SalesCategory::select('scat_nm', 'sc_id')->orderBy('scat_nm', 'ASC')->get();
            $currData = Currency::orderBy('curr_name', 'ASC')->get();
            $grpData = Group::orderBy('gr_nm', 'ASC')->get();
            return view('admin.customer.view-customers',
                    array('data' => $pageData, 'catData' => $catData, 'currency' => $currData,
                        'groupData' => $grpData, 'case' => $type, 'data_entries' => $page_val, 'pagination_arr' => $pagination_arr, 'custCatData' => $custCatData));
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

    public function DeleteCustomer($id) {
        $users = Customer::where('u_id', '=', base64_decode($id))->first();

        //dd($users->toArray());

        $del_user = $users->toArray();
        $del_user['del_datetime'] = date('Y-m-d H:i:s');
        $del_user['del_by'] = Auth::id();
        $del_user['del_ip'] = $_SERVER['REMOTE_ADDR'];

        DB::table('rollco_ms_users_deleted')->insert($del_user);

        //dd($users->toArray());
        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(),
            'table_used' => 'rollco_ms_cust',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($users->toArray())),
            'data_now' => ''
        );

        saveQueryLog($logData);

        /* -------------------update user status to new agency------------------------ */
        $emailid = $users->com_emailAddress;
        $na_authentication_key = $users->na_authentication_key;
        deletestatus($emailid, $na_authentication_key);
        /* -------------------update user status to new agency end-------------------- */

        DB::table('rollco_ms_users_deletelog')->insert(array('cust_id' => $del_user['u_id'], 'cust_email' => $del_user['com_emailAddress'], 'del_datetime' => date('Y-m-d H:i:s'), 'del_by' => Auth::id(), 'del_ip' => $_SERVER['REMOTE_ADDR']));
        $status = DB::table('rollco_ms_users')->where('u_id', base64_decode($id))->delete();
        if ($status) {
            return redirect()->back()->with('message',
                            'customer successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'error while deleting customer');
        }
    }

    public function GetCustomerData(Request $request) {
        $users = Customer::Where('u_id', base64_decode($request->id))->first();
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

    public function resendPasswordCustomer(Request $request) {
        //dd($request->all());
        $userid = base64_decode($request->ids);
        $newpwd = generatePIN(6);

        $custDetails = Customer::where('u_id', $userid)->first();
        $updateUser = Customer::where('u_id', $userid)->update(array('password' => md5($newpwd)));
        if ($updateUser) {
            $data = array('fname' => $custDetails['companyName'], 'changedPwd' => $newpwd, 'email' => $custDetails['com_emailAddress']);
            if ($_SERVER['HTTP_HOST'] != 'localhost') {
                $retval = Mail::send('admin.emails.resend-password', $data, function ($message) use ($data) {

                            $message->from('info@rollingcomponents.com',
                                    'Rolling Components');
                            $message->to($data['email'])->cc('info@rollingcomponents.com');
                            $message->subject('Rollco: Reset Password');
                        });
                echo json_encode(array("pwd" => $newpwd, 'status' => 1));
                exit();
            } else {
                echo json_encode(array("pwd" => $newpwd, 'status' => 1));
                exit();
            }
        } else {
            echo json_encode(array('status' => 0));
            exit();
        }
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


                        $username = remove_accents($username);
                        $email = remove_accents($email);
                        $pwd = remove_accents($pwd);
                        $GroupCode = remove_accents($GroupCode);
                        $CompanyName = remove_accents($CompanyName);
                        $Country = remove_accents($Country);
                        $CurrencyName = remove_accents($CurrencyName);
                        $regisdate = remove_accents($regisdate);
                        $status = remove_accents($status);
                        $IPAddress = remove_accents($IPAddress);

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

    public function DeleteCustomerAjax(Request $request) {

        $status = DB::table('rollco_ms_users')->whereIn('u_id',
                        $request['ids'])->delete();
        if ($status) {
            echo 1;
        } else {
            echo 0;
        }
    }

}
