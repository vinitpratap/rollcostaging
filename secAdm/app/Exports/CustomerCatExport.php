<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Modal\Contact;
use Illuminate\Http\Request;
use Auth;
Use DB;

class CustomerCatExport implements FromCollection, WithHeadings {

    use Exportable;

    protected $search;

    public function __construct(Request $request, Contact $detail) {

        if (!empty($request->search)) {
            $this->search = $request->search;
        }
        //dd($request->all());
       
    }

    public function collection() {

        $date = '';
        $from = '';
        $to = '';

        $query = DB::table('rollco_cust_cat')
                ->select('cust_cat_nme', 'cust_cat_info');

       


        $reqData = $query->orderBy('cust_cat_nme', 'ASC')
                ->get();

 
        return $reqData;
    }

    public function headings(): array {
        return [
            "Category Name", "Category info"
        ];
    }

}

?>