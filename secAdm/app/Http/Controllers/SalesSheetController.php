<?php

namespace App\Http\Controllers;

ini_set('max_execution_time', '0');

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\Modal\SalesSheet;
use App\Modal\Customer;
use App\Modal\SalesCategory;
use App\Modal\SalesSheetCategoryValue;
use App\Modal\SalesSheetAppointment;
use App\Modal\UserCategoryTag;
use App\Modal\SalesCal;
use App\Modal\SalesCalLog;
use App\Modal\TempUser;
use App\Exports\ReportExport;
use App\Exports\SalesLogExport;
use Illuminate\Support\Facades\Input;
use App\Exports\CalenderCustomerExport;

class SalesSheetController extends Controller {
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
    public function AddNewSalesSheet(Request $request) {
        //  dd($request->all());
//        $validation = Validator::make($request->all(), [
//                    'roll_curr_outstanding' => 'required',
//                    'roll_consgnmt_qty' => 'required',
//                    'roll_consgnmt_value' => 'required',
//                    'roll_sor_extended' => 'required',
//        ]);
//        if ($validation->fails()) {
//            return redirect()->back()->withErrors($validation)->withInput($request->only('roll_last_year_turnover', 'roll_share_per'));
//        }

        if (isset($request->ss_id)) {
            $dataMain = array("roll_last_year_turnover" => $request->roll_last_year_turnover,
                "roll_share_per" => $request->roll_share_per,
                "gross_qty" => $request->gross_qty,
                "gross_faulty" => $request->gross_faulty,
                "gross_return_stock" => $request->gross_return_stock,
                "gross_faulty_per" => $request->gross_faulty_per,
                "faulty_cat_qty" => $request->faulty_cat_qty,
                "faulty_cat_nff" => $request->faulty_cat_nff,
                "faulty_cat_transit_damage" => $request->faulty_cat_transit_damage,
                "faulty_cat_contanimated" => $request->faulty_cat_contanimated,
                "roll_curr_outstanding" => $request->roll_curr_outstanding,
                "roll_consgnmt_qty" => $request->roll_consgnmt_qty,
                "roll_overdue_outstanding" => $request->roll_overdue_outstanding,
                "roll_consgnmt_value" => $request->roll_consgnmt_value,
                "roll_last_stock_cdate" => $request->roll_last_stock_cdate,
                "roll_sor_extended" => $request->roll_sor_extended,
                "roll_last_visit" => $request->roll_last_visit,
                "user_id" => $request->user_id,
                "user_email" => $request->user_email
            );

            SalesSheet::where('ss_id', $request->ss_id)->update($dataMain);

            $userCatData = UserCategoryTag::where('u_id', ($request->user_id))->get();

            $curryr = date("Y");
            foreach ($userCatData as $key => $value) {
                $ssv_scat_value = $value->cat_id . '_val_' . $curryr;
                $ssv_scat_qty = $value->cat_id . '_Qty_' . $curryr;
                $ssv_scat_faulty = $value->cat_id . '_fQty_' . $curryr;
                $ssv_scat_faulty_per = $value->cat_id . '_fQtyPer_' . $curryr;

                $checkdataScat = SalesSheetCategoryValue::select('ssv_scat_id')
                                ->where('ssv_scat_id', $value->cat_id)
                                ->where('ssv_ss_id', $request->ss_id)
                                ->where('ssv_scat_year', $curryr)->first();
                if ($checkdataScat) {

                    $dataScat = array(
                        'ssv_scat_value' => $request->$ssv_scat_value,
                        'ssv_scat_qty' => $request->$ssv_scat_qty,
                        'ssv_scat_faulty' => $request->$ssv_scat_faulty,
                        'ssv_scat_faulty_per' => $request->$ssv_scat_faulty_per,
                    );
//                    
//                    echo $value->cat_id;
//                    echo  $request->ss_id;
                    $status = SalesSheetCategoryValue::where('ssv_scat_id', $value->cat_id)
                                    ->where('ssv_ss_id', $request->ss_id)
                                    ->where('ssv_scat_year', $curryr)->update($dataScat);
//                    dd($status);
                } else {
                    $dataScat = array('ssv_scat_year' => $curryr,
                        'ssv_scat_name' => getSalesCategoryName($value->cat_id),
                        'ssv_scat_id' => $value->cat_id,
                        'ssv_scat_value' => $request->$ssv_scat_value,
                        'ssv_scat_qty' => $request->$ssv_scat_qty,
                        'ssv_scat_faulty' => $request->$ssv_scat_faulty,
                        'ssv_scat_faulty_per' => $request->$ssv_scat_faulty_per,
                        'ssv_ss_id' => $request->ss_id,
                    );

                    $status = SalesSheetCategoryValue::create($dataScat);
                }
            }
//            if (isset($request->apt_details_discussed) || isset($request->apt_details_action)) {
//                SalesSheetAppointment::create(array('sa_ss_id' => $request->ss_id, 'sa_apt_details' => $request->apt_details_discussed, 'sa_apt_action' => $request->apt_details_action));
//            }
            if ($status) {
                return redirect('admin/manage-salessheet')->with('message', 'SalesSheet successfully updated');
            } else {
                return redirect()->back()->with('message', 'Error while updating SalesSheet ');
            }
        } else {
            $dataMain = array("roll_last_year_turnover" => $request->roll_last_year_turnover,
                "roll_share_per" => $request->roll_share_per,
                "gross_qty" => $request->gross_qty,
                "gross_faulty" => $request->gross_faulty,
                "gross_return_stock" => $request->gross_return_stock,
                "gross_faulty_per" => $request->gross_faulty_per,
                "faulty_cat_qty" => $request->faulty_cat_qty,
                "faulty_cat_nff" => $request->faulty_cat_nff,
                "faulty_cat_transit_damage" => $request->faulty_cat_transit_damage,
                "faulty_cat_contanimated" => $request->faulty_cat_contanimated,
                "roll_curr_outstanding" => $request->roll_curr_outstanding,
                "roll_consgnmt_qty" => $request->roll_consgnmt_qty,
                "roll_overdue_outstanding" => $request->roll_overdue_outstanding,
                "roll_consgnmt_value" => $request->roll_consgnmt_value,
                "roll_last_stock_cdate" => $request->roll_last_stock_cdate,
                "roll_sor_extended" => $request->roll_sor_extended,
                "roll_last_visit" => $request->roll_last_visit,
                "user_id" => $request->user_id,
                "user_email" => $request->user_email
            );

            $id = SalesSheet::insertGetId($dataMain);

            //dd($id);
            $userCatData = UserCategoryTag::where('u_id', ($request->user_id))->get();
            $curryr = date("Y");
            foreach ($userCatData as $key => $value) {
                $ssv_scat_value = $value->cat_id . '_val_' . $curryr;
                $ssv_scat_qty = $value->cat_id . '_Qty_' . $curryr;
                $ssv_scat_faulty = $value->cat_id . '_fQty_' . $curryr;
                $ssv_scat_faulty_per = $value->cat_id . '_fQtyPer_' . $curryr;
                $dataScat = array('ssv_scat_year' => $curryr,
                    'ssv_scat_name' => getSalesCategoryName($value->cat_id),
                    'ssv_scat_id' => $value->cat_id,
                    'ssv_scat_value' => $request->$ssv_scat_value,
                    'ssv_scat_qty' => $request->$ssv_scat_qty,
                    'ssv_scat_faulty' => $request->$ssv_scat_faulty,
                    'ssv_scat_faulty_per' => $request->$ssv_scat_faulty_per,
                    'ssv_ss_id' => $id,
                );
                //dd($dataScat);
                SalesSheetCategoryValue::create($dataScat);
            }

//            if (isset($request->apt_details_discussed) || isset($request->apt_details_action)) {
//                SalesSheetAppointment::create(array('sa_ss_id' => $id, 'sa_apt_details' => $request->apt_details_discussed, 'sa_apt_action' => $request->apt_details_action));
//            }
            if ($id) {
                return redirect('admin/manage-salessheet')->with('message', 'SalesSheet successfully created');
            } else {
                return redirect()->back()->with('message', 'Error while saving SalesSheet ');
            }
        }
    }

    public function AddNewSalesSheetCat(Request $request) {
        $validation = Validator::make($request->all(), [
                    'user_id' => 'required',
                    'custCat' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('user_id', 'custCat'));
        }

        if (isset($request->custCat) && count($request->custCat) > 0) {
            UserCategoryTag::where('u_id', $request->user_id)->delete();
            for ($i = 0; $i < count($request->custCat); $i++) {
                $status = UserCategoryTag::create(array('u_id' => $request->user_id, 'cat_id' => $request->custCat[$i]));
            }
        }

        if ($status) {
            return redirect()->back()->with('message', 'SalesSheet Category tagging successfully created');
        } else {
            return redirect()->back()->with('message', 'Error while tagging SalesSheet category');
        }
    }

    /*

     * View customers 
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function SalesTagging() {
        if (Auth::guard('admin')->user()->admin_role == 1 || Auth::guard('admin')->user()->admin_role == 2) {

            $cdata = Customer::select('u_id', 'firstName', 'lastName', 'companyName', 'com_zipCode')
                            ->where(function($query) {
                                // $query->Where('user_status', 2);
                                //->orWhere('user_status', 4);
                            })
                            ->where('cust_type', 1)
                            ->where('companyName', '!=', '')
                            // ->where('user_status', '=', '2')
                            //->where('lastName', '!=', '')
                            ->orderBy('companyName', 'ASc')->get();
            $custCatData = SalesCategory::select('scat_nm', 'sc_id')->orderBy('scat_nm', 'ASC')->get();
//            $data = SalesSheet::orderBy('created_at', 'DESC')->get();
            return view('admin.sales.view-salessheet-tagging', array('cdata' => $cdata, 'custCatData' => $custCatData));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function SalesSheets() {
        if (Auth::guard('admin')->user()->admin_role == 1 || Auth::guard('admin')->user()->admin_role == 2) {
            $useridArr = [];
            $ssData = UserCategoryTag::select('u_id')->groupby('u_id')->get();
            if ($ssData) {
                foreach ($ssData as $key => $value) {
                    array_push($useridArr, $value->u_id);
                }
                $cdata = Customer::select('u_id', 'firstName', 'lastName', 'companyName', 'com_zipCode')
                                ->where(function($query) {
                                    // $query->Where('user_status', 2);
                                    // ->orWhere('user_status', 4);
                                })
                                ->where('cust_type', 1)
                                ->where('companyName', '!=', '')
                                //->where('lastName', '!=', '')
                                ->whereIn('u_id', $useridArr)
                                ->orderBy('companyName', 'ASc')->get();
                $custCatData = SalesCategory::select('scat_nm', 'sc_id')->orderBy('scat_nm', 'ASC')->get();
                $tempData = TempUser::get();
                return view('admin.sales.view-salessheet', array('cdata' => $cdata, 'custCatData' => $custCatData, 'tempData' => $tempData));
            } else {
                return redirect('admin/manage-salessheet-tagging')->with('message', 'Please Tag customer to categories');
            }
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function SalesSheetsLogs(Request $request) {
        if (Auth::guard('admin')->user()->admin_role == 1 || Auth::guard('admin')->user()->admin_role == 2) {

//            dd($request->all()); 
            $userData = Customer::select('u_id', 'firstName', 'lastName', 'com_zipCode', 'companyName')
                    // ->where('user_status', 2)
                    ->where('cust_type', '!=', 3)
                    ->where('companyName', '!=', '')
                    ->whereNotNull('companyName')
                    ->orderby('companyName', 'ASC')
                    ->get();
            $tempData = TempUser::get();
            $salesData = Customer::select('u_id', 'firstName', 'lastName', 'companyName', 'com_zipCode', 'com_emailAddress')
                            ->where('cust_type', 3)
                            ->where('companyName', '!=', '')
                            ->orderby('firstName', 'ASC')->get();

            $query = SalesCalLog::query();

            if (!empty($request->su_id)) {
                $query = $query->where('sec_id', $request->su_id);
            }

            if (!empty($request->u_id)) {
                //dd($request->u_id);
                $usr_id = explode('_', $request->u_id);
                if (count($usr_id) > 1) {
                    $query = $query->where('temp_id', $usr_id[1]);
                } else {
                    $query = $query->where('u_id', $request->u_id);
                }
            }
            if (!empty($request->sc_status)) {
                $query = $query->where('sc_status', $request->sc_status);
            }

            if (!empty($request->req_date_range)) {
                $dates = explode('and', $request->req_date_range);
                $from = date("Y-m-d H:i:s", strtotime($dates[0]));
                $to = date("Y-m-d H:i:s", strtotime($dates[1]));
            }

            if (!empty($from) && !empty($to)) {

                $query = $query->whereDate('sc_date', '>=', $from)->whereDate('sc_date', '<=', $to);
            }

            $query = $query->where('full_name', '!=', '');

            $pageData = $query->orderby('sc_date', 'DESC')
                    ->paginate(20)
                    ->withPath('?su_id=' . $request->su_id . '&u_id=' . $request->u_id . '&req_date_range=' . $request->req_date_range . '&sc_status=' . $request->sc_status);


            return view('admin.sales.view-saleslogs',
                    array('data' => $pageData, 'userData' => $userData, 'salesData' => $salesData, 'tempData' => $tempData));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function EditSalesSheet(Request $request) {
//dd($request->all());
        $validation = Validator::make($request->all(), [
                    'scat_nm' => 'required',
                    'scat_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('scat_nm', 'scat_status'));
        }
        $name = $request->scat_nm;

        $status = SalesSheet::where('scat_nm', $name)
                ->where('sc_id', '!=', $request->sc_id)
                ->first();
        if ($status) {
            return redirect()->back()->withErrors(['message', 'SalesSheet already exists']);
        } else {
            $data = SalesSheet::Where('sc_id', $request->sc_id)->first();
            //dd($data);

            $changed_data = array('scat_nm' => $request->scat_nm,
                'scat_status' => $request->scat_status
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
            $logData = array('subject_id' => $request->sc_id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_salescat',
                'description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)), 'data_now' => urldecode(http_build_query($changed_data))
            );
            //dd($logData);
            saveQueryLog($logData);
            $updateCat = SalesSheet::Where('sc_id', $request->sc_id)->update($changed_data);
            if ($updateCat) {
                return redirect()->back()->with('message', 'SalesSheet successfully updated');
            } else {
                return redirect()->back()->with('message', 'Error while updating category');
            }
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function DeleteSalesSheet($id) {
        $data = SalesSheet::where('sc_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_salescat',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())), 'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_salescat')->where('sc_id', base64_decode($id))->delete();
        if ($status) {
            return redirect()->back()->with('message', 'sales category successfully deleted');
        } else {
            return redirect()->back()->with('message', 'error while deleting category');
        }
    }

    public function GetSalesSheetData(Request $request) {
        $method = $request->method();

        if ($request->isMethod('post')) {
            $prevtoprevyr = date('Y') - 2;
            $prevyr = date('Y') - 1;
            $curryr = date('Y');

            $scatvalArr = [];
            $cntYrArr = [];
            $cntYrArr[$prevtoprevyr] = $cntYrArr[$prevyr] = $cntYrArr[$curryr] = 0;
            $userCatData = UserCategoryTag::where('u_id', ($request->user_id))->get();

            $userData = Customer::select('g_id', 'firstName', 'lastName', 'com_zipCode', 'com_emailAddress', 'com_Telephone', 'buying_group', 'regisdate', 'companyName', 'customerID')
                            //->where('user_status', 2)
                            ->where('cust_type', '!=', 3)
                            ->where('u_id', ($request->user_id))->first();

            $lastVisit = [];
//        dd($request->user_id);
            if (($request->user_id)) {
                $lastVisit = SalesCal::where('u_id', $request->user_id)->where('sc_status', 2)->orderby('sc_date', 'desc')->orderby('sc_stime', 'desc')->first();
            }
//        dd(getActCodeUser($request->user_id));
            $sheetData = SalesSheet::with('getSalesCategoryValue', 'getSalesAppointmentInfo')->where('user_id', $request->user_id)->first();
            $cnt = [];
            if (isset($sheetData['getSalesCategoryValue'])) {
                foreach ($sheetData['getSalesCategoryValue'] as $key => $value) {
                    //$cnt += $value->ssv_scat_value;
                    if ($value->ssv_scat_year == $curryr) {
                        $cntYrArr[$curryr] += $value->ssv_scat_value;
                    }
                    if ($value->ssv_scat_year == $prevyr) {
                        $cntYrArr[$prevyr] += $value->ssv_scat_value;
                    }
                    if ($value->ssv_scat_year == $prevtoprevyr) {
                        $cntYrArr[$prevtoprevyr] += $value->ssv_scat_value;
                    }

//                $cnt[$value->ssv_scat_year] += $value->ssv_scat_value;
                    $scatvalArr[$value->ssv_scat_year][$value->ssv_scat_id] = array('ssv_scat_name' => $value->ssv_scat_name,
                        'ssv_scat_value' => $value->ssv_scat_value,
                        'ssv_scat_qty' => $value->ssv_scat_qty,
                        'ssv_scat_faulty' => $value->ssv_scat_faulty,
                        'ssv_scat_faulty_per' => $value->ssv_scat_faulty_per,
                            //'ssv_tot_val' => $cnt
                    );
                }
            }
//dd($scatvalArr);
            $allCatData = SalesCategory::select('scat_nm', 'sc_id')->orderBy('scat_nm', 'ASC')->get();

            return view('admin.sales.view-salessheetdata', array('userCatData' => $userCatData, 'allCatData' => $allCatData, 'userData' => $userData, 'sheetData' => $sheetData, 'user_id' => $request->user_id, 'scatvalArr' => $scatvalArr, 'cntYrArr' => $cntYrArr, 'lastVisitArr' => $lastVisit));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function GetSalesSheetCatData(Request $request) {
        $userCatData = UserCategoryTag::where('u_id', ($request->id))->get();

        $userData = Customer::select('g_id', 'com_zipCode', 'com_emailAddress', 'com_Telephone', 'buying_group', 'regisdate')
                        ->where(function($query) {
                            //$query->Where('user_status', 2);
                            //->orWhere('user_status', 4);
                        })
                        ->where('cust_type', '!=', 3)
                        ->where('u_id', ($request->id))->first();

        $sheetData = SalesSheet::with('getSalesCategoryValue', 'getSalesAppointmentInfo')->where('user_id', $request->id)->get();

//        $userData[0]['g_id'] = getGroupName($userData[0]['g_id']);
        echo json_encode(array('userCatData' => $userCatData, 'userData' => $userData));
    }

    public function GetSalesSheetAppointmentData(Request $request) {
        DB::enableQueryLog(); // Enable query log

        $catArr = [];
        $u_id = $request->u_id;

        $query = DB::table('rollco_user_to_category_tag AS tag')
                ->select('sc.scat_nm');

        $query = $query->join('rollco_ms_salescat as sc',
                'sc.sc_id', '=', 'tag.cat_id');

        $query = $query->where('tag.u_id', $u_id);

        $catData = $query->get();

        if ($catData) {
            foreach ($catData as $key => $value) {
                array_push($catArr, $value->scat_nm);
            }
        }
//        dd(DB::getQueryLog()); // Show results of log

        $data = SalesSheetAppointment::where('AcCode', getCustActid($u_id))
                        ->orderby('created_at', 'desc')->get();


        $html = '';
        foreach ($data as $key1 => $value1) {
            if (isset($value1->other_text) && $value1->other_text != '') {
                array_push($catArr, $value1->other_text);
            }
            $html .= '<tr class="pointer">
                            <td>' . $value1->sa_apt_details . '</td>

                            <td>' . $value1->SalesPersonName . '</td>
                            <td>' . $value1->created_at . '</td>
                        </tr>';
        }
        if (count($data) > 0) {
            echo json_encode(array('success' => 1, 'html' => $html));
        } else {
            echo json_encode(array('success' => 0));
        }
    }

    public function GetSalesReportData(Request $request) {

        if (Auth::guard('admin')->user()->admin_role == 1 || Auth::guard('admin')->user()->admin_role == 2) {

//            dd($request->all());
            $userData = Customer::select('u_id', 'firstName', 'lastName', 'com_zipCode', 'companyName')
                            //->where('user_status', 2)
                            ->where('cust_type', '!=', 3)->orderby('companyName', 'ASC')->get();
            $salesData = Customer::select('u_id', 'firstName', 'lastName', 'com_zipCode', 'companyName')
                            ->where('cust_type', 3)
                            ->where('companyName', '!=', '')
                            ->orderby('firstName', 'ASC')->get();

            $query = SalesCal::query();

            if (!empty($request->su_id)) {
                $query = $query->where('sec_id', $request->su_id);
            }


            if (!empty($request->u_id)) {
                $usr_id = explode('_', $request->u_id);
                if (count($usr_id) > 1) {
                    $query = $query->where('temp_id', $usr_id[1]);
                } else {
                    $query = $query->where('u_id', $request->u_id);
                }
            }
            if (!empty($request->sc_status)) {
                $query = $query->where('sc_status', $request->sc_status);
            }

            if (!empty($request->req_date_range)) {
                $dates = explode('and', $request->req_date_range);
                $from = date("Y-m-d H:i:s", strtotime($dates[0]));
                $to = date("Y-m-d H:i:s", strtotime($dates[1]));
            }

            if (!empty($from) && !empty($to)) {

                $query = $query->whereDate('sc_date', '>=', $from)->whereDate('sc_date', '<=', $to);
            }

            $tempData = TempUser::get();
            $query = $query->where('full_name', '!=', '');

            $pageData = $query->orderby('sc_date', 'DESC')
                    ->paginate(20)
                    ->withPath('?su_id=' . $request->su_id . '&u_id=' . $request->u_id . '&req_date_range=' . $request->req_date_range . '&sc_status=' . $request->sc_status);

            return view('admin.sales.view-salesreport',
                    array('data' => $pageData, 'userData' => $userData, 'salesData' => $salesData, 'tempData' => $tempData));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function exportToExcelReort(Request $request) {
        $exporter = app()->makeWith(ReportExport::class);
        return $exporter->download(date('Y-m-d-H-i-s') . '-report.xlsx');
    }

    public function exportToExcelSalesLog(Request $request) {
        $exporter = app()->makeWith(SalesLogExport::class);
        return $exporter->download(date('Y-m-d-H-i-s') . '-saleslog.xlsx');
    }

    public function exportSalesUserNotAvailable(Request $request) {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . date('Y-m-d-H-i-s') . "-salesusernotavailable.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $query = DB::table('rollco_salescal')
                ->select('full_name', 'post_code', 'sc_country', 'sc_remarks', 'sc_date', 'sc_stime', 'sc_etime'
                )//'mscode.MsCode', 'mscode.V8Key'
                ->whereNotIn('u_id', function($q) {
            $q->select('u_id')->from('rollco_ms_users');
        });

        $query = $query->groupBy('full_name');
        $reqData = $query->orderBy('full_name', 'ASC')
                ->get();


        $columns = array("Name", "Post Code", "County", "Remarks", "Date", "Start Time", "End Time");


        $callback = function() use ($reqData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            //dd($reqData);

            foreach ($reqData as $review) {
                fputcsv($file, array($review->full_name, $review->post_code, $review->sc_country, $review->sc_remarks, $review->sc_date, $review->sc_stime, $review->sc_etime));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function exportSalesUserBlock(Request $request) {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . date('Y-m-d-H-i-s') . "-salesusernotavailable.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $query = DB::table('rollco_salescal')
                ->select('full_name', 'post_code', 'sc_country', 'sc_remarks', 'sc_date', 'sc_stime', 'sc_etime'
                )//'mscode.MsCode', 'mscode.V8Key'
                ->whereNotIn('u_id', function($q) {
            $q->select('u_id')->from('rollco_ms_users')->where('user_status', '!=', 2);
        });

        $query = $query->groupBy('full_name');
        $reqData = $query->orderBy('full_name', 'ASC')
                ->get();


        $columns = array("Name", "Post Code", "County", "Remarks", "Date", "Start Time", "End Time");


        $callback = function() use ($reqData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            //dd($reqData);

            foreach ($reqData as $review) {
                fputcsv($file, array($review->full_name, $review->post_code, $review->sc_country, $review->sc_remarks, $review->sc_date, $review->sc_stime, $review->sc_etime));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function exportSalesLog(Request $request) {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . date('Y-m-d-H-i-s') . "-saleslog.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $query = DB::table('rollco_ms_sales_appointment')
                ->select('AcCode', 'SalesPersonName', 'CreatedBy', 'sa_apt_details', 'created_at'
        );
        $query = $query->where('AcCode', '!=', '');
        $query = $query->where('SalesPersonName', '!=', '');
        $reqData = $query->orderBy('AcCode', 'ASC')
                ->get();


        $columns = array("Account Code", "Sales Person Name", "Created By", "Remarks", "Date");


        $callback = function() use ($reqData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            //dd($reqData);

            foreach ($reqData as $review) {
                fputcsv($file, array($review->AcCode, $review->SalesPersonName, $review->CreatedBy, $review->sa_apt_details, $review->created_at));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function UploadSalesSheet(Request $request) {
        if (Auth::guard('admin')->user()->admin_role == 1) {

            if (Input::hasFile('sheet_file')) {
                $file = Input::file('sheet_file');
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
                    if (count($productArr) > 0) {
                        
                    } else {
                        return redirect()->back()->withErrors(['message', 'Uploaded file is empty']);
                    }
//                 dd($productArr);
                    for ($i = 0; $i < count($productArr); $i++) {

                        //dd($productArr);
                        $prdata = [];
                        $ACCOUNTNO = '';
                        $BEARINGHUBKITQTY = '';
                        $BEARINGHUBKITVALUE = '';
                        $CALIPERQTY = '';
                        $CALIPERVALUE = '';
                        $CVJOINTQTY = '';
                        $CVJOINTVALUE = '';
                        $DRIVESHAFTQTY = '';
                        $DRIVESHAFTVALUE = '';
                        $EMSQTY = '';
                        $EMSVALUE = '';
                        $STEERINGPUMPQTY = '';
                        $STEERINGPUMPVALUE = '';
                        $SPARESQTY = '';
                        $SPARESVALUE = '';
                        $ROTATINGVALUE = '';

                        $u_id = 0;
                        $com_emailAddress = '';
                        $com_zipCode = '';

                        if (isset($productArr[$i]['ACCOUNTNO']))
                            $ACCOUNTNO = trim($productArr[$i]['ACCOUNTNO']);
                        if (isset($productArr[$i]['BEARINGHUBKITQTY']))
                            $BEARINGHUBKITQTY = trim($productArr[$i]['BEARINGHUBKITQTY']);
                        if (isset($productArr[$i]['BEARINGHUBKITVALUE']))
                            $BEARINGHUBKITVALUE = trim($productArr[$i]['BEARINGHUBKITVALUE']);
                        if (isset($productArr[$i]['CALIPERQTY']))
                            $CALIPERQTY = trim($productArr[$i]['CALIPERQTY']);
                        if (isset($productArr[$i]['CALIPERVALUE']))
                            $CALIPERVALUE = trim($productArr[$i]['CALIPERVALUE']);
                        if (isset($productArr[$i]['CVJOINTQTY']))
                            $CVJOINTQTY = trim($productArr[$i]['CVJOINTQTY']);
                        if (isset($productArr[$i]['CVJOINTVALUE']))
                            $CVJOINTVALUE = trim($productArr[$i]['CVJOINTVALUE']);
                        if (isset($productArr[$i]['DRIVESHAFTQTY']))
                            $DRIVESHAFTQTY = trim($productArr[$i]['DRIVESHAFTQTY']);
                        if (isset($productArr[$i]['DRIVESHAFTVALUE']))
                            $DRIVESHAFTVALUE = trim($productArr[$i]['DRIVESHAFTVALUE']);
                        if (isset($productArr[$i]['EMSQTY']))
                            $EMSQTY = trim($productArr[$i]['EMSQTY']);
                        if (isset($productArr[$i]['EMSVALUE']))
                            $EMSVALUE = trim($productArr[$i]['EMSVALUE']);
                        if (isset($productArr[$i]['STEERINGPUMPQTY']))
                            $STEERINGPUMPQTY = trim($productArr[$i]['STEERINGPUMPQTY']);
                        if (isset($productArr[$i]['STEERINGPUMPVALUE']))
                            $STEERINGPUMPVALUE = trim($productArr[$i]['STEERINGPUMPVALUE']);
                        if (isset($productArr[$i]['SPARESQTY']))
                            $SPARESQTY = trim($productArr[$i]['SPARESQTY']);
                        if (isset($productArr[$i]['SPARESVALUE']))
                            $SPARESVALUE = trim($productArr[$i]['SPARESVALUE']);
                        if (isset($productArr[$i]['ROTATINGQTY']))
                            $ROTATINGQTY = trim($productArr[$i]['ROTATINGQTY']);
                        if (isset($productArr[$i]['ROTATINGVALUE']))
                            $ROTATINGVALUE = trim($productArr[$i]['ROTATINGVALUE']);

                        $ssv_ss_id = 0;

                        if ($ACCOUNTNO != '') {
                            $u_res = DB::table('rollco_ms_users')->select('u_id', 'com_emailAddress', 'com_zipCode')
                                    ->where('customerID', $ACCOUNTNO)
                                    ->where('user_status', 2)
                                    ->where('cust_type', '!=', 3)
                                    ->first();
                            //dd($u_res->u_id);
                            if (isset($u_res->u_id) && $u_res->u_id > 0) {
                                $u_id = $u_res->u_id;
                                $com_emailAddress = $u_res->com_emailAddress;
                                $com_zipCode = $u_res->com_zipCode;
                            }
                            if ($u_id > 0) {
                                $check_sql = DB::table('rollco_ms_sales_sheet')->select('AcCode', 'ss_id')
                                        ->where('AcCode', $ACCOUNTNO)
                                        ->first();
                                if ($check_sql) {
                                    $ssv_ss_id = $check_sql->ss_id;
                                    for ($i = 0; $i < 8; $i++) {
                                        if ($i == 0) {
                                            DB::table('rollco_ms_scat_sales_val')
                                                    ->where('ssv_scat_year', $request->ss_year)
                                                    ->where('ssv_scat_id', 11)
                                                    ->where('ssv_ss_id', $ssv_ss_id)
                                                    ->delete();
                                            DB::table('rollco_ms_scat_sales_val')->insert(array('ssv_scat_id' => 11, 'ssv_scat_name' => 'BEARING HUB & KIT', 'ssv_scat_year' => $request->ss_year, 'ssv_scat_value' => $BEARINGHUBKITVALUE, 'ssv_scat_qty' => $BEARINGHUBKITQTY, 'ssv_ss_id' => $ssv_ss_id));
                                        }
                                        if ($i == 1) {
                                            DB::table('rollco_ms_scat_sales_val')
                                                    ->where('ssv_scat_year', $request->ss_year)
                                                    ->where('ssv_scat_id', 6)
                                                    ->where('ssv_ss_id', $ssv_ss_id)
                                                    ->delete();
                                            DB::table('rollco_ms_scat_sales_val')->insert(array('ssv_scat_id' => 6, 'ssv_scat_name' => 'CALIPER', 'ssv_scat_year' => $request->ss_year, 'ssv_scat_value' => $CALIPERVALUE, 'ssv_scat_qty' => $CALIPERQTY, 'ssv_ss_id' => $ssv_ss_id));
                                        }
                                        if ($i == 2) {
                                            DB::table('rollco_ms_scat_sales_val')
                                                    ->where('ssv_scat_year', $request->ss_year)
                                                    ->where('ssv_scat_id', 8)
                                                    ->where('ssv_ss_id', $ssv_ss_id)
                                                    ->delete();
                                            DB::table('rollco_ms_scat_sales_val')->insert(array('ssv_scat_id' => 8, 'ssv_scat_name' => 'CV JOINT', 'ssv_scat_year' => $request->ss_year, 'ssv_scat_value' => $CVJOINTVALUE, 'ssv_scat_qty' => $CVJOINTQTY, 'ssv_ss_id' => $ssv_ss_id));
                                        }
                                        if ($i == 3) {
                                            DB::table('rollco_ms_scat_sales_val')
                                                    ->where('ssv_scat_year', $request->ss_year)
                                                    ->where('ssv_scat_id', 10)
                                                    ->where('ssv_ss_id', $ssv_ss_id)
                                                    ->delete();
                                            DB::table('rollco_ms_scat_sales_val')->insert(array('ssv_scat_id' => 10, 'ssv_scat_name' => 'DRIVE SHAFT', 'ssv_scat_year' => $request->ss_year, 'ssv_scat_value' => $DRIVESHAFTVALUE, 'ssv_scat_qty' => $DRIVESHAFTQTY, 'ssv_ss_id' => $ssv_ss_id));
                                        }
                                        if ($i == 4) {
                                            DB::table('rollco_ms_scat_sales_val')
                                                    ->where('ssv_scat_year', $request->ss_year)
                                                    ->where('ssv_scat_id', 5)
                                                    ->where('ssv_ss_id', $ssv_ss_id)
                                                    ->delete();
                                            DB::table('rollco_ms_scat_sales_val')->insert(array('ssv_scat_id' => 5, 'ssv_scat_name' => 'EMS', 'ssv_scat_year' => $request->ss_year, 'ssv_scat_value' => $EMSVALUE, 'ssv_scat_qty' => $EMSQTY, 'ssv_ss_id' => $ssv_ss_id));
                                        }
                                        if ($i == 5) {
                                            DB::table('rollco_ms_scat_sales_val')
                                                    ->where('ssv_scat_year', $request->ss_year)
                                                    ->where('ssv_scat_id', 9)
                                                    ->where('ssv_ss_id', $ssv_ss_id)
                                                    ->delete();
                                            DB::table('rollco_ms_scat_sales_val')->insert(array('ssv_scat_id' => 9, 'ssv_scat_name' => 'STEERING PUMP', 'ssv_scat_year' => $request->ss_year, 'ssv_scat_value' => $STEERINGPUMPVALUE, 'ssv_scat_qty' => $STEERINGPUMPQTY, 'ssv_ss_id' => $ssv_ss_id));
                                        }
                                        if ($i == 6) {
                                            DB::table('rollco_ms_scat_sales_val')
                                                    ->where('ssv_scat_year', $request->ss_year)
                                                    ->where('ssv_scat_id', 4)
                                                    ->where('ssv_ss_id', $ssv_ss_id)
                                                    ->delete();
                                            DB::table('rollco_ms_scat_sales_val')->insert(array('ssv_scat_id' => 4, 'ssv_scat_name' => 'SPARES', 'ssv_scat_year' => $request->ss_year, 'ssv_scat_value' => $SPARESVALUE, 'ssv_scat_qty' => $SPARESQTY, 'ssv_ss_id' => $ssv_ss_id));
                                        }
                                        if ($i == 7) {
                                            DB::table('rollco_ms_scat_sales_val')
                                                    ->where('ssv_scat_year', $request->ss_year)
                                                    ->where('ssv_scat_id', 7)
                                                    ->where('ssv_ss_id', $ssv_ss_id)
                                                    ->delete();
                                            DB::table('rollco_ms_scat_sales_val')->insert(array('ssv_scat_id' => 7, 'ssv_scat_name' => 'ROTATING', 'ssv_scat_year' => $request->ss_year, 'ssv_scat_value' => $ROTATINGVALUE, 'ssv_scat_qty' => $ROTATINGQTY, 'ssv_ss_id' => $ssv_ss_id));
                                        }
                                    }
                                } else {
                                    $insertArr = ['user_id' => $u_id, 'user_email' => $com_emailAddress, 'user_postcode' => $com_zipCode, 'AcCode' => $ACCOUNTNO];
                                    $id = DB::table('rollco_ms_sales_sheet')->insertGetId($insertArr);
                                    $ssv_ss_id = $id;
                                    for ($i = 0; $i < 8; $i++) {
                                        if ($i == 0) {
                                            DB::table('rollco_ms_scat_sales_val')->insert(array('ssv_scat_id' => 11, 'ssv_scat_name' => 'BEARING HUB & KIT', 'ssv_scat_year' => $request->ss_year, 'ssv_scat_value' => $BEARINGHUBKITVALUE, 'ssv_scat_qty' => $BEARINGHUBKITQTY, 'ssv_ss_id' => $ssv_ss_id));
                                        }
                                        if ($i == 1) {
                                            DB::table('rollco_ms_scat_sales_val')->insert(array('ssv_scat_id' => 6, 'ssv_scat_name' => 'CALIPER', 'ssv_scat_year' => $request->ss_year, 'ssv_scat_value' => $CALIPERVALUE, 'ssv_scat_qty' => $CALIPERQTY, 'ssv_ss_id' => $ssv_ss_id));
                                        }
                                        if ($i == 2) {
                                            DB::table('rollco_ms_scat_sales_val')->insert(array('ssv_scat_id' => 8, 'ssv_scat_name' => 'CV JOINT', 'ssv_scat_year' => $request->ss_year, 'ssv_scat_value' => $CVJOINTVALUE, 'ssv_scat_qty' => $CVJOINTQTY, 'ssv_ss_id' => $ssv_ss_id));
                                        }
                                        if ($i == 3) {
                                            DB::table('rollco_ms_scat_sales_val')->insert(array('ssv_scat_id' => 10, 'ssv_scat_name' => 'DRIVE SHAFT', 'ssv_scat_year' => $request->ss_year, 'ssv_scat_value' => $DRIVESHAFTVALUE, 'ssv_scat_qty' => $DRIVESHAFTQTY, 'ssv_ss_id' => $ssv_ss_id));
                                        }
                                        if ($i == 4) {
                                            DB::table('rollco_ms_scat_sales_val')->insert(array('ssv_scat_id' => 5, 'ssv_scat_name' => 'EMS', 'ssv_scat_year' => $request->ss_year, 'ssv_scat_value' => $EMSVALUE, 'ssv_scat_qty' => $EMSQTY, 'ssv_ss_id' => $ssv_ss_id));
                                        }
                                        if ($i == 5) {
                                            DB::table('rollco_ms_scat_sales_val')->insert(array('ssv_scat_id' => 9, 'ssv_scat_name' => 'STEERING PUMP', 'ssv_scat_year' => $request->ss_year, 'ssv_scat_value' => $STEERINGPUMPVALUE, 'ssv_scat_qty' => $STEERINGPUMPQTY, 'ssv_ss_id' => $ssv_ss_id));
                                        }
                                        if ($i == 6) {
                                            DB::table('rollco_ms_scat_sales_val')->insert(array('ssv_scat_id' => 4, 'ssv_scat_name' => 'SPARES', 'ssv_scat_year' => $request->ss_year, 'ssv_scat_value' => $SPARESVALUE, 'ssv_scat_qty' => $SPARESQTY, 'ssv_ss_id' => $ssv_ss_id));
                                        }
                                        if ($i == 7) {
                                            DB::table('rollco_ms_scat_sales_val')->insert(array('ssv_scat_id' => 7, 'ssv_scat_name' => 'ROTATING', 'ssv_scat_year' => $request->ss_year, 'ssv_scat_value' => $ROTATINGVALUE, 'ssv_scat_qty' => $ROTATINGQTY, 'ssv_ss_id' => $ssv_ss_id));
                                        }
                                    }
                                }
                            } else {
                                return redirect()->back()->withErrors(['message', 'Required fields are empty']);
                            }
                        } else {
                            return redirect()->back()->withErrors(['message', 'Required fields are empty']);
                        }
                    }

                    return redirect()->back()->with('message',
                                    'Sales sheet successfully uploaded.');
                } else {
                    return redirect()->back()->withErrors(['message', 'file format is not csv']);
                }
            }
            return view('admin.product.uploadsalessheet');
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

    public function exportCalenderUsers() {
        $exporter = app()->makeWith(CalenderCustomerExport::class);
        return $exporter->download(date('Y-m-d-H-i-s') . '-calender_customer.xlsx');
    }

}
