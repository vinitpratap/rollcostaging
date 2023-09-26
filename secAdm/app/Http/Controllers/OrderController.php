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
use App\Modal\Order;
use App\Modal\OrderDetail;
use App\Modal\Customer;
use App\Exports\OrdersExport;
use App\Exports\OrdersExportUnit;

class OrderController extends Controller {
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
    public function Orders(Request $request) {

	//dd($request->all());
        $page_val = 50;
        $pagination_arr = array(50, 100);
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $query = Order::query();

            if (!empty($request->get('search'))) {
                $search = $request->get('search');
                $query = $query->where('order_no', 'LIKE', '%' . $search . '%');
            }

            if (!empty($request->req_date_range)) {
                $dates = explode('and', $request->req_date_range);
                $from = date("Y-m-d H:i:s", strtotime($dates[0]));
                $to = date("Y-m-d H:i:s", strtotime($dates[1]));
            }

            if (!empty($request->data_entries)) {
                $page_val = $request->data_entries;
            }

            if (!empty($request->get('search_user'))) {
                $search_user = $request->get('search_user');
                $query = $query->whereHas('getUserDetails',
                        function ($query) use ($search_user) {
                    $query->where('firstName', 'LIKE', '%' . $search_user . '%');
                    $query->orWhere('lastName', 'LIKE', '%' . $search_user . '%');
                    $query->orWhere('com_emailAddress', 'LIKE',
                            '%' . $search_user . '%'); 
                });
            }
            
             if (!empty($from) && !empty($to)) {

            $query = $query->whereDate('order_date', '>=', $from)->whereDate('order_date', '<=', $to);
        }

            if ($request->ord_status !='') {
                $query = $query->where('order_status', '=', $request->ord_status);
            }

            
            $query = $query->with('getUserDetails');
            $pageData = $query->orderby('order_date', 'DESC')
                    ->paginate($page_val)
                    ->withPath('?search=' . $request->search . '&ord_status=' . $request->ord_status . '&search_user=' . $request->search_user.'&data_entries='.$page_val);

            //$data = Order::with('getUserDetails')->orderBy('order_date', 'DESC')->get();
            return view('admin.order.view-orders', array('data' => $pageData, 'data_entries' => $page_val, 'pagination_arr' => $pagination_arr));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function OrderDetail($id) {
        $id = base64_decode($id);
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $data = [];
            $data = Order::with('getOrderDetails')->where('order_id', $id)->orderBy('order_date',
                            'DESC')->get();
//            dd($data);
            return view('admin.order.view-order-details', array('data' => $data));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function EditOrder(Request $request) {
        $validation = Validator::make($request->all(),
                        [
                            'order_id' => 'required',
                            'order_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('order_id',
                                    'order_status'));
        }

        $status = Order::where('order_id', $request->order_id)
                ->first();
        if ($status) {
            $data = Order::Where('order_id', $request->order_id)->first();
            $changed_data = array('order_status' => $request->order_status
            );
            $logData = array('subject_id' => $request->order_id, 'user_id' => Auth::id(),
                'table_used' => 'rollco_ms_order', 'description' => 'update', 'data_prev' => $status['order_status'],
                'data_now' => $request->order_status
            );
            saveQueryLog($logData);
            $updateCat = Order::Where('order_id', $request->order_id)->update($changed_data);
            if ($updateCat) {
                return redirect('admin/view-order-details/' . base64_encode($request->order_id))->with('message',
                                'Order successfully updated');
            } else {
                return redirect()->back()->with('message',
                                'Error while updating Order');
            }
        } else {
            return redirect()->back()->withErrors(['message', 'Order not exists']);
        }
    }

    /*
     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function DeleteOrder($id) {
        $data = Order::where('order_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(),
            'table_used' => 'rollco_ms_order', 'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())),
            'data_now' => ''
        );
        saveQueryLog($logData);
        $status = DB::table('rollco_ms_order')->where('order_id',
                        base64_decode($id))->delete();
        DB::table('rollco_ms_order_details')->where('order_id',
                base64_decode($id))->delete();
        if ($status) {
            return redirect('admin/view-orders')->with('message',
                            'order successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'error while deleting Order');
        }
    }

    public function exportToExcelOrders() {
        $exporter = app()->makeWith(OrdersExport::class);
        return $exporter->download(date('Y-m-d-H-i-s') . '-orders.xlsx');
    }
	
	public function exportToExcelOrderUnitWise() {
        $exporter = app()->makeWith(OrdersExportUnit::class);
        return $exporter->download(date('Y-m-d-H-i-s') . '-ordersunitwise.xlsx');
    }
    
     public function filterRequest(Request $request) {

        $cancelReqCnt = 0;
        $closedReqCnt = 0;
        $closedreq = DB::select('select year(created_at) as year,monthname(created_at) AS monthname, month(created_at) as month, count(order_id) as total_count from rollco_ms_order where order_status = 5 AND   (created_at BETWEEN "' . $request->start_date . '" AND "' . $request->end_date . '") group by year(created_at), month(created_at)');

        $cancelreq = DB::select('select year(created_at) as year,monthname(created_at) AS monthname, month(created_at) as month, count(order_id) as total_count from rollco_ms_order where order_status = 6 AND   (created_at BETWEEN "' . $request->start_date . '" AND "' . $request->end_date . '") group by year(created_at), month(created_at)');

        $data['closedReqArr'] = json_encode(($closedreq));
        $data['cancelReqArr'] = json_encode(($cancelreq));
        $closedreqArr = [];
        $cancelreqArr = [];
        foreach ($closedreq as $key => $value){
            //$closedreqArr[$value->year][$value->month] = $value->total_count;
            array_push($closedreqArr, $value->total_count);
            $closedReqCnt += $value->total_count;
        }

        foreach ($cancelreq as $key => $value){
            //$cancelreqArr[$value->year][$value->month] = $value->total_count;
            array_push($cancelreqArr, $value->total_count);
            $cancelReqCnt += $value->total_count;
        }
        $ts1 = strtotime($request->start_date);
        $ts2 = strtotime($request->end_date);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $diff = (($year2 - $year1) * 12) + ($month2 - $month1) + 1;


        $data['closedReqArr'] = json_encode((array_pad($closedreqArr, $diff, 0)));
        $data['cancelReqArr'] = json_encode((array_pad($cancelreqArr, $diff, 0)));
        $data['cancelReqCnt'] = $cancelReqCnt;
        $data['closedReqCnt'] = $closedReqCnt;
        $data['monthRange'] = json_encode(array(date("F", strtotime($request->start_date)), date("F", strtotime($request->end_date))));
        $data['monthDiff'] = $diff;
        echo json_encode($data);
    }
    

//
}
