<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Modal\CustomerRequest;
use Illuminate\Http\Request;
Use DB;

class CollectionExportnotAccept implements FromCollection, WithHeadings {

    use Exportable;

    protected $detail;
    protected $status;
    protected $search;
    protected $cat_nm;
    protected $service;
    protected $dates;

    public function __construct(Request $request, CustomerRequest $detail, $status) {

        //dd($request->all());
        $type = 0;
        if (!empty($request->daterange)) {
            $this->dates = $request->daterange;
            //$this->$fromdate = date("Y-m-d H:i:s", strtotime($dates[0]));
            //$this->$todate = date("Y-m-d H:i:s", strtotime($dates[1]));
        }
        if (!empty($request->cid)) {
            $this->cat_nm = getCatName($request->cid);
        }

        if (!empty($request->service)) {
            $this->service = $request->service;
        }


        if (!empty($request->search)) {
            $this->search = $request->search;
        }
dd($status);
         switch ($status) {
             
            case 'notaccept': $type = [2];
                break;
            default :
                break;
        }
        $this->detail = $detail;
        $this->status = $type;
    }

    public function collection() {
        $status = $this->status;
        $date = '';
        $from = '';
        $to = '';

        $query = DB::table('ehs_ms_cust_req AS custReq')
                ->select('custReq.req_code', 'custReq.req_date', 'custReq.req_dte_pref', 'custReq.req_timeslot_pref', 'custReq.cust_loc', 'reqServ.serv_catnm', 'reqServ.serv_nm', 'reqServ.serv_code', 'custReq.cust_nm', 'custReq.cust_code', 'custReq.cust_mob', 'custReq.cust_email', 'custReq.cust_serviceadd1', 'custReq.cust_serviceadd2', 'custReq.cust_loc_landmark', 'custReq.req_usr_fbck', 'custReq.req_trans_mode', 'custReq.req_ordr_amnt', 'custReq.req_trans_id', 'custReq.req_trans_status', 'custReq.req_trans_date', 'reqServ.serv_attr', 'reqServ.serv_price', 'reqServ.serv_tax', 'reqServ.serv_quan', 'reqTech.tech_name', 'reqTech.tech_email', 'reqTech.tech_mobile', 'reqTech.assign_dte', 'custReq.req_status', 'custReq.req_close_date', 'custReq.req_user_fback_date', 'custReq.req_overall_rting', 'custReq.req_overall_tech_rting', 'custReq.req_usr_fbck');



        
        $query = $query->join('ehs_cust_req_serv as reqServ', 'reqServ.req_id', '=', 'custReq.id')
                ->leftJoin('ehs_cust_req_tech_assign as reqTech', 'reqTech.req_id', '=', 'custReq.id')
                ->WhereIn('custReq.req_status', $status)
                ->Where('reqTech.is_accepted', 1);

        if (!empty($this->dates)) {
            $date = explode('and', $this->dates);
            $from = date("Y-m-d H:i:s", strtotime($date[0]));
            $to = date("Y-m-d H:i:s", strtotime($date[1]));
        }
        if (!empty($this->cat_nm)) {
            $query = $query->where('reqServ.serv_catnm', $this->cat_nm);
        }

        if (!empty($this->service)) {
            $query = $query->where('reqServ.serv_id', '=', $this->service);
        }

        if (!empty($from) && !empty($to)) {

            $query = $query->whereDate('custReq.req_dte_pref', '>=', $from)->whereDate('custReq.req_dte_pref', '<=', $to);
        }

        if (!empty($this->search)) {
            $ser = $this->search;
            $query = $query->where(function($query) use ($ser) {
                $query->where('custReq.req_code', 'LIKE', '%' . $ser . '%');
                $query->orWhere('custReq.cust_nm', 'LIKE', '%' . $ser . '%');
                $query->orWhere('custReq.cust_email', 'LIKE', '%' . $ser . '%');
                $query->orWhere('custReq.cust_mob', 'LIKE', '%' . $ser . '%');
            });
        }
        
        $reqData = $query->orderBy('custReq.created_at', 'DESC')
                ->get();
        //dd($reqData);
//        $reqData = DB::table('ehs_ms_cust_req AS custReq')
//                ->select('custReq.req_code', 'custReq.req_date', 'custReq.req_dte_pref', 'custReq.req_timeslot_pref', 'custReq.cust_loc', 'reqServ.serv_catnm', 'reqServ.serv_nm', 'reqServ.serv_code', 'custReq.cust_nm', 'custReq.cust_code', 'custReq.cust_mob', 'custReq.cust_email', 'custReq.cust_serviceadd1', 'custReq.cust_serviceadd2', 'custReq.cust_loc_landmark', 'custReq.req_usr_fbck', 'custReq.req_trans_mode', 'custReq.req_ordr_amnt', 'custReq.req_trans_id', 'custReq.req_trans_status', 'custReq.req_trans_date', 'reqServ.serv_attr', 'reqServ.serv_price', 'reqServ.serv_tax', 'reqServ.serv_quan', 'reqTech.tech_name', 'reqTech.tech_email', 'reqTech.tech_mobile', 'reqTech.assign_dte', 'custReq.req_status', 'custReq.req_close_date', 'custReq.req_user_fback_date', 'custReq.req_overall_rting', 'custReq.req_overall_tech_rting', 'custReq.req_usr_fbck')
//                ->join('ehs_cust_req_serv as reqServ', 'reqServ.req_id', '=', 'custReq.id')
//                ->leftJoin('ehs_cust_req_tech_assign as reqTech', 'reqTech.req_id', '=', 'custReq.id')
//                ->WhereIn('custReq.req_status', $status)
//                ->orderBy('custReq.created_at', 'DESC')
//                ->get();
        // dd($reqData);
        $stname = '';
        $tname = '';
        foreach ($reqData as $key => $value){
            switch ($value->req_status) {
                case 1:
                    $value->req_status = 'Pending';
                    break;
                case 2:
                    $value->req_status = 'Technician Assigned';

                    break;
                case 3:
                    $value->req_status = 'Work Started';

                    break;
                case 4:
                    $value->req_status = 'Closed';

                    break;
                case 5:
                    $value->req_status = 'Feedback Completed';

                    break;
                case 6:
                    $value->req_status = 'Cancelled';

                    break;
            }
            $value->req_dte_pref = date("jS M Y", strtotime($value->req_dte_pref)) . " " . $value->req_timeslot_pref;

            unset($value->req_timeslot_pref);
            if ($value->req_trans_mode == 1) {
                $value->req_trans_mode = "Credit/Debit/Net Banking";
            } else {
                $value->req_trans_mode = "Cash On Delivery";
            }

        }

        return $reqData;
    }

    public function headings(): array {
        return [
            "Request ID", "Created Date", "Visit Date & Time", "Service Location", "Service Category", "Service Name", "Service CODE", "Customer Name", "Customer CODE", "Customer Mobile", "Customer  Email", "Service Address 1", "Service Address 2", "Land Mark", "Customer's Remarks", "Payment Mode", "Order Amount", "Transaction ID", "Transaction Status", "Transaction Date", "Unit", "Base Price", "Service Tax", "Quantity", "Technician Name", "Technician Email", "Technician Mobile", "Technician Assigned Date", "Request Status", "Request Closed Date", "Feedback Date", "Service Request Rating", "Technician Rating", "Feedback"
        ];
    }

}

?>