<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Modal\Contact;
use Illuminate\Http\Request;
use Auth;
Use DB;

class ReportExport implements FromCollection, WithHeadings {

    use Exportable;

    protected $su_id;
    protected $u_id;
    protected $sc_status;
    protected $dates;

    public function __construct(Request $request, Contact $detail) {

        if (!empty($request->su_id)) {
            $this->su_id = $request->su_id;
        }
        if (!empty($request->u_id)) {
            $this->u_id = $request->u_id;
        }
        if (!empty($request->sc_status)) {
            $this->sc_status = $request->sc_status;
        }

        if (!empty($request->daterange)) {
            $this->dates = $request->daterange;
        }
    }

    public function collection() {

        $date = '';
        $from = '';
        $to = '';

        $query = DB::table('rollco_salescal')
                ->select('cdate', 'full_name', 'u_id', 'post_code', 'sc_country', 'sc_stime', 'sc_etime', 'sc_remarks', 'sc_status', 'sec_id');


        if (!empty($this->dates)) {
            $date = explode('and', $this->dates);
            $from = date("Y-m-d H:i:s", strtotime($date[0]));
            $to = date("Y-m-d H:i:s", strtotime($date[1]));
        }

        if (!empty($from) && !empty($to)) {

            $query = $query->whereDate('order_date', '>=', $from)->whereDate('order_date', '<=', $to);
        }

        if (!empty($this->su_id)) {
            $query = $query->where('sec_id', $this->su_id);
        }


        if (!empty($this->u_id)) {
            $usr_id = explode('_', $this->u_id);
            if (count($usr_id) > 1) {
                $query = $query->where('temp_id', $usr_id[1]);
            } else {
                $query = $query->where('u_id', $this->u_id);
            }
        }
        if (!empty($this->sc_status)) {
            $query = $query->where('sc_status', $this->sc_status);
        }

        $reqData = $query->orderBy('cdate', 'DESC')
                ->get();

        foreach ($reqData as $key => $value) {
            switch ($value->sc_status) {
                case 1 : $value->sc_status = 'Open';
                    break;
                case 2 : $value->sc_status = 'Closed';
                    break;
            }

            $value->sec_id = getUserName($value->sec_id);
            $value->u_id = getCustActid($value->u_id);
            $value->cdate = date("d/m/Y", strtotime($value->cdate));
        }

        return $reqData;
    }

    public function headings(): array {
        return [
            "Date", "Name", "Account Code", "Post Code", "County/Town", "Start Time", "End Time", "Remarks", "Status", "Sales Person"
        ];
    }

}

?>