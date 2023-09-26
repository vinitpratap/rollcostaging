<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Modal\Enquiry;
use Illuminate\Http\Request;
use Auth;
Use DB;

class EnquiryExport implements FromCollection, WithHeadings {

    use Exportable;

    protected $search;

    public function __construct(Request $request, Enquiry $detail) {

        if (!empty($request->search)) {
            $this->search = $request->search;
        }
        //dd($request->all());
       
    }

    public function collection() {

        $date = '';
        $from = '';
        $to = '';

        $query = DB::table('rollco_enquirenow')
                ->select('name', 'email', 'mobile', 'comments', 'cust_ip','user_cntry','user_county','user_city','user_info','user_browser','user_platform', 'created_at');

       
        if (!empty($this->search)) {
            $ser = $this->search;
            
            $query = $query->where(function($query) use ($ser) {
                $query->where('name', 'LIKE', '%' . $ser . '%');
                $query->orWhere('email', 'LIKE', '%' . $ser . '%');
                $query->orWhere('mobile', 'LIKE', '%' . $ser . '%');
            });            
            
        }

        $reqData = $query->orderBy('created_at', 'DESC')
                ->get();

        return $reqData;
    }

    public function headings(): array {
        return [
            "Name", "Email", "Mobile", "Comments", "IP","Country","County","City","User Info","Browser","Platform", "Date"
        ];
    }

}

?>