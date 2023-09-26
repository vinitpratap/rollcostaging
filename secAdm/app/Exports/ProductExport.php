<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use Auth;
Use DB;

class ProductExport implements FromCollection, WithHeadings {

    use Exportable;

    protected $search;

    public function __construct(Request $request) {

        if (!empty($request->search)) {
            $this->search = $request->search;
        }
        //dd($request->all());
       
    }

    public function collection() {

        
        $query = DB::table('rollco_ms_product as prod')
                    ->select('cat.cat_nm','make.make_nm','model.model_nm','proyr.proyr_from','proyr.proyr_to','proccm.proccm_inf','engcode.engcode_inf','prod.prod_part_no','mscode.MsCode','mscode.V8Key');

            $query = $query->join('rollco_ms_cat as cat',
                    'cat.cat_id', '=', 'prod.catid');
            $query = $query->join('rollco_ms_make as make',
                    'make.make_id', '=', 'prod.makeid');
            $query = $query->join('rollco_ms_model as model',
                    'model.model_id', '=', 'prod.modelid');
            $query = $query->leftjoin('rollco_ms_proyr as proyr',
                    'proyr.proyr_id', '=', 'prod.proyrid');
            $query = $query->leftjoin('rollco_ms_proccm as proccm',
                    'proccm.proccm_id', '=', 'prod.proccmid');
            $query = $query->leftjoin('rollco_ms_engcode as engcode',
                    'engcode.engcode_id', '=', 'prod.engid');
            $query = $query->leftjoin('rollco_ms_mscode as mscode',
                    'mscode.part_no', '=', 'prod.prod_part_no');

//
            if (!empty($this->search)) {
                $search = $this->search;

                $query = $query->where(function($query) use ($search) {
                    $query->where('prod.prod_part_no', 'LIKE', '%' . $search . '%');
                });
            }
            

        $reqData = $query->orderBy('prod.created_at', 'DESC')
                ->get();

        return $reqData;
    }

    public function headings(): array {
        return [
            "Category", "Make", "Model", "Year From","Year To", "CCM", "Engine Code","Product",'Mscode','V8Key'
        ];
    }

}

?>