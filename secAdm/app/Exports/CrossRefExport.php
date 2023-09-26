<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use Auth;
Use DB;

class CrossRefExport implements FromCollection, WithHeadings {

    use Exportable;

    protected $search;

    public function __construct(Request $request) {

        if (!empty($request->search)) {
            $this->search = $request->search;
        }
        //dd($request->all());
       
    }

    public function collection() {


        $query = DB::table('rollco_ms_crossref')
                ->select('rc_num', 'crossref_make', 'crossref_oem', 'crossref_status');


        if (!empty($this->search)) {
            $search = $this->search;

            $query = $query->where(function($query) use ($search) {
                $query->where('rc_num', 'LIKE', '%' . $search . '%');
                $query->orWhere('crossref_make', 'LIKE', '%' . $search . '%');
                $query->orWhere('crossref_oem', 'LIKE', '%' . $search . '%');
            });
        }


        $reqData = $query->orderBy('created_at', 'DESC')
                ->get();


        return $reqData;
    }

    public function headings(): array {
        return [
            "ROLLCO", "MANUFACTURER", "OEM", "STATUS"
        ];
    }

}

?>