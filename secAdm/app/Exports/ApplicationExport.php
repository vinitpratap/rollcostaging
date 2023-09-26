<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use Auth;
Use DB;

class ApplicationExport implements FromCollection, WithHeadings {

    use Exportable;

    protected $search;

    public function __construct(Request $request) {

        if (!empty($request->search)) {
            $this->search = $request->search;
        }
        //dd($request->all());
       
    }

    public function collection() {

        $date = '';
        $from = '';
        $to = '';

        $query = DB::table('rollco_ms_application')
                ->select('make_nm', 'model_nm', 'year', 'cc','part_no');


        if (!empty($this->search)) {
            $search = $this->search;
           
            $query = $query->where(function($query) use ($search) {
                $query->where('make_nm', 'LIKE', '%' . $search . '%');
                $query->orWhere('model_nm', 'LIKE', '%' . $search . '%');
                $query->orWhere('year', 'LIKE', '%' . $search . '%');
                $query->orWhere('cc', 'LIKE', '%' . $search . '%');
                $query->orWhere('part_no', 'LIKE', '%' . $search . '%');
            });
        }


        $reqData = $query->orderBy('created_at', 'DESC')
                ->get();

        return $reqData;
    }

    public function headings(): array {
        return [
            "MAKE", "MODEL", "YEAR", "CC","RCnumber"
        ];
    }

}

?>