<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use Auth;
Use DB;

class GroupExport implements FromCollection, WithHeadings {

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

        $query = DB::table('rollco_ms_grproduct as grppro')
                ->select('grp.gr_nm','curr.curr_name','grppro.part_nm', 'grppro.pr_price');


        $query = $query->join('rollco_ms_group as grp',
                'grp.gr_id', '=', 'grppro.gr_id');
        $query = $query->join('rollco_ms_currency as curr',
                'curr.curr_id', '=', 'grp.gr_currency');

        if (!empty($this->search)) {
            $search = $this->search;

            $query = $query->where(function($query) use ($search) {
                $query->where('grp.gr_nm', 'LIKE', '%' . $search . '%');
            });
        }

        
        $reqData = $query->orderBy('grp.gr_nm', 'ASC')
                ->get();
        //dd($reqData);
        return $reqData;
    }

    public function headings(): array {
        return [
            "Group Name", "Currency", "Part", "Price"
        ];
    }

}

?>