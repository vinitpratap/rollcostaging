<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use Auth;
Use DB;

class RSExport implements FromCollection, WithHeadings {

    use Exportable;

    protected $search;

    public function __construct(Request $request) {

        if (!empty($request->search)) {
            $this->search = $request->search;
        }
        //dd($request->all());
       
    }

    public function collection() {

        $query = DB::table('rollco_search_found as sr')
		->select('prod.prod_part_no', DB::raw('count(sr.prod_id) AS user_count'))
		->groupby('sr.prod_id')->where('sr.prod_id' ,'!=','0');
        //$query = DB::table('rollco_search_found as sr')
          //          ->select('usr.firstName','usr.lastName','usr.com_emailAddress','usr.com_Telephone','prod.prod_part_no','spr.spare_part_no','sr.u_ip','sr.user_cntry','sr.user_county','sr.user_city','sr.user_info','sr.user_browser','sr.user_platform','sr.created_at');

            $query = $query->join('rollco_ms_users as usr',
                    'usr.u_id', '=', 'sr.user_id');
            $query = $query->leftjoin('rollco_ms_product as prod',
                    'prod.prod_id', '=', 'sr.prod_id');
            $query = $query->leftjoin('rollco_ms_spare as spr',
                    'spr.spare_id', '=', 'sr.spr_id');


            if (!empty($this->search)) {
                $search = $this->search;

                $query = $query->where(function($query) use ($search) {
                    $query->where('usr.firstName', 'LIKE', '%' . $search . '%');
                    $query->orWhere('usr.lastName', 'LIKE', '%' . $search . '%');
                    $query->orWhere('usr.com_emailAddress', 'LIKE', '%' . $search . '%');
                    $query->orWhere('usr.com_Telephone', 'LIKE', '%' . $search . '%');
                    $query->orWhere('prod.prod_nm', 'LIKE', '%' . $search . '%');
                    $query->orWhere('prod.prod_part_no', 'LIKE', '%' . $search . '%');
                    $query->orWhere('spr.spare_nm', 'LIKE', '%' . $search . '%');
                    $query->orWhere('spr.spare_part_no', 'LIKE', '%' . $search . '%');
                });
            }
            

        //$reqData = $query->orderBy('created_at', 'DESC')
          //      ->get();
		$reqData = $query->orderby(DB::raw('user_count'), 'desc')->take(50)->get();
		
		//dd($reqData);

        return $reqData;
    }

    public function headings(): array {
        return [
            //"First Name", "Last Name", "Email", "Mobile", "Product", "Spare","IP","Country","County","City","User Info","Browser","Platform", "Date"
			"Product","Count"
        ];
    }

}

?>