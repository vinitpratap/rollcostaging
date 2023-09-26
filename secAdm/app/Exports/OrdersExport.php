<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Modal\Contact;
use Illuminate\Http\Request;
use Auth;
Use DB;

class OrdersExport implements FromCollection, WithHeadings {

    use Exportable;

    protected $search;
    protected $search_user;
    protected $ord_status;
    protected $dates;

    public function __construct(Request $request, Contact $detail) {

        if (!empty($request->search)) {
            $this->search = $request->search;
        }
        if (!empty($request->search_user)) {
            $this->search_user = $request->search_user;
        }
        if (!empty($request->ord_status)) {
            $this->ord_status = $request->ord_status;
        }

        if (!empty($request->daterange)) {
            $this->dates = $request->daterange;
        }
    }

    public function collection() {

        $date = '';
        $from = '';
        $to = '';

        $query = DB::table('rollco_ms_order AS ord')
                ->select('ord.order_no', 'ord.order_date','ord.totalprice', 'ord.Qty',
                        'users.companyName','users.com_emailAddress','users.com_zipCode', 'ord.remarks','ord.order_instruction'
                         );



        /*$query = $query->join('rollco_ms_order_details as ord_de',
                'ord.order_id', '=', 'ord_de.order_id');*/
        $query = $query->join('rollco_ms_users as users', 'users.u_id', '=',
                'ord.user_id');
        /*$query = $query->leftjoin('rollco_ms_product as prod', 'prod.prod_id', '=',
                'ord_de.prod_id');
        $query = $query->leftjoin('rollco_ms_spare as spare', 'spare.spare_id', '=',
                'ord_de.spr_id');*/


        if (!empty($this->dates)) {
            $date = explode('and', $this->dates);
            $from = date("Y-m-d H:i:s", strtotime($date[0]));
            $to = date("Y-m-d H:i:s", strtotime($date[1]));
        }

        if (!empty($from) && !empty($to)) {

            $query = $query->whereDate('order_date', '>=', $from)->whereDate('order_date', '<=', $to);
        }

        if (!empty($this->search)) {
            $search = $this->search;
            $query = $query->where('order_no', 'LIKE', '%' . $search . '%');
        }


        if (!empty($this->search_user)) {
            $ser = $this->search_user;
            $query = $query->where(function($query) use ($ser) {
                $query->where('users.com_emailAddress', 'LIKE', '%' . $ser . '%');
                $query->orWhere('users.firstName', 'LIKE', '%' . $ser . '%');
                $query->orWhere('users.firstName', 'LIKE', '%' . $ser . '%');
                $query->orWhere('users.companyName', 'LIKE', '%' . $ser . '%');
            });
        }

        if ($this->ord_status !='') {
            $query = $query->where('order_status', '=', $this->ord_status);
        }

        $reqData = $query->orderBy('ord.created_at', 'DESC')
                ->get();

		//dd($reqData);
        return $reqData;
    }

    public function headings(): array {
        return [
            "Order Number","Order Date", "Price","Total Quantity","Company Name","Email","Post code","Comment","Special Instruction"
        ];
    }

}

?>