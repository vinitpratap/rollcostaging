<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use Auth;
Use DB;

class SNFExport implements FromCollection, WithHeadings {

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

		$query = DB::table('rollco_search_not_found')->select('snf_text', DB::raw('count(snf_text) AS user_count'))->groupby('snf_text')->where('snf_text' ,'!=','none');
		//dd($data);
        //$query = DB::table('rollco_search_not_found')
                //->select('snf_user', 'snf_make', 'snf_model', 'snf_yr', 'snf_cc', 'snf_ec', 'snf_ec','snf_ip','snf_text','snf_browser','snf_platform', 'created_at');


        if (!empty($request->search)) {
            $search = $request->search;

            $query = $query->where(function($query) use ($search) {
                $query->where('snf_make', 'LIKE', '%' . $search . '%');
                $query->orWhere('snf_model', 'LIKE', '%' . $search . '%');
                $query->orWhere('snf_yr', 'LIKE', '%' . $search . '%');
                $query->orWhere('snf_cc', 'LIKE', '%' . $search . '%');
                $query->orWhere('snf_user', 'LIKE', '%' . $search . '%');
                $query->orWhere('snf_text', 'LIKE', '%' . $search . '%');
                $query->orWhere('snf_ip', 'LIKE', '%' . $search . '%');
                $query->orWhere('snf_browser', 'LIKE', '%' . $search . '%');
                $query->orWhere('snf_platform', 'LIKE', '%' . $search . '%');
            });
        }


        $reqData = $query->orderby(DB::raw('user_count'), 'desc')->take(50)->get();

        /*foreach($reqData as $key=>$value){
            $value->snf_make = getMakeName($value->snf_make);
            $value->snf_model = getModelName($value->snf_model);
            $value->snf_yr = getProYear($value->snf_yr);
            $value->snf_cc = getProCCM($value->snf_cc);
            $value->snf_ec = getEngineCode($value->snf_ec);
        }*/
		//dd($reqData);
        return $reqData;
    }

    public function headings(): array {
        return [
            //"Name", "Make", "Model", "Year", "CCM", "Engine","IP","Search Text","Browser","Platform", "Date"
            "Keyword","Count"
        ];
    }

}

?>