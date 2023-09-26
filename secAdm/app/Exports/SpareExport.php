<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use Auth;
Use DB;

class SpareExport implements FromCollection, WithHeadings {

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

        $query = DB::table('rollco_ms_spare')
                ->select('spare_part_no', 'spare_make', 'spare_oem', 'spare_cargo','spare_status');


        if (!empty($request->search)) {
            $search = $request->search;

            $query = $query->where(function($query) use ($search) {
                $query->where('spare_part_no', 'LIKE', '%' . $search . '%');
                $query->orWhere('spare_make', 'LIKE', '%' . $search . '%');
                $query->orWhere('spare_oem', 'LIKE', '%' . $search . '%');
                $query->orWhere('spare_cargo', 'LIKE', '%' . $search . '%');
                $query->orWhere('spare_status', 'LIKE', '%' . $search . '%');
            });
        }


        $reqData = $query->orderBy('created_at', 'DESC')
                ->get();

        return $reqData;
    }

    public function headings(): array {
        return [
            "ROLLCO", "MANUFACTURER", "OEM", "CARGO","STATUS"
        ];
    }

}

?>