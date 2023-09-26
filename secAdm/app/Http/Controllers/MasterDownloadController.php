<?php

namespace App\Http\Controllers;

ini_set('max_execution_time', '0');

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Auth;
use DB;
use App\Modal\MCategory;
use App\Modal\Category;
use App\Modal\Product;
use App\Modal\Make;
use App\Modal\Model;
use App\Modal\ProYear;
use App\Modal\ProCCM;
use App\Modal\EngineCode;
use App\Modal\Application;
use App\Modal\Mscode;
use Intervention\Image\ImageManagerStatic as Image;
use App\Exports\ProductExport;
use App\Exports\ApplicationExport;
use Zipper;
use File;
use Response;

class MasterDownloadController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//     protected $redirectTo = '/dashboard';



    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function MasterDownload() {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            return view('admin.masterdownload.masterdownload');
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    public function exportToExcelMsCode(Request $request) {

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . date('Y-m-d-H-i-s') . "-mscode.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $query = DB::table('rollco_ms_mscode as mscode')
                ->select('mscode.part_no', 'mscode.V8Key'); //'mscode.MsCode', 'mscode.V8Key'



        $query = $query->groupby('part_no');
        $query = $query->groupby('V8Key');
        $reqData = $query->orderBy('mscode.part_no', 'ASC')
                ->get();
        //debug($reqData[0]);
        $columns = array("Part Number", "V8Key");

        $callback = function() use ($reqData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            //dd($reqData);

            foreach ($reqData as $review) {

                fputcsv($file, array($review->part_no, $review->V8Key));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
        //return Response::stream($callback, 200, $headers);
    }

    public function exportToCSVProductMaster(Request $request) {

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . date('Y-m-d-H-i-s') . "-products.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $query = DB::table('rollco_ms_product as prod')
                ->select('prod.mcatid', 'prod.catid', 'prod.makeid', 'prod.modelid', 'prod.proyrid',
                'prod.proccmid', 'prod.engid', 'prod.prod_part_no', 'prod.fuel', 'prod.cylinders', 'prod.prod_trans'
        ); //'mscode.MsCode', 'mscode.V8Key'



        $reqData = $query->orderBy('prod.created_at', 'DESC')
                ->get();

        $columns = array("CATEGORY", "SUB_CATEGORY", "ROLLCO_PART", "MAKE", "MODEL", "YEAR", "FUEL", "CCM",
            "CYLINDERS", "TRANSMISSION", "ENGINE");


        $callback = function() use ($reqData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            //dd($reqData);

            foreach ($reqData as $review) {
                fputcsv($file, array(
                    getMCatName($review->mcatid),
                    getCatName($review->catid),
                    $review->prod_part_no,
                    getMakeName($review->makeid),
                    getModelName($review->modelid),
                    getProYear($review->proyrid),
                    $review->fuel,
                    getProCCM($review->proccmid),
                    $review->cylinders,
                    $review->prod_trans,
                    getEngineCode($review->engid)
                ));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function exportToCSVProductDetailsMaster(Request $request) {

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . date('Y-m-d-H-i-s') . "-productdetails.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $query = DB::table('rollco_ms_product')
                ->select('mcatid', 'catid', 'prod_part_no', 'prod_stock', 'ptype', 'position', 'prod_volt',
                'prod_out', 'prod_pull_type', 'prod_regu', 'prod_fan', 'prod_teeth', 'gr', 'prod_trans', 'prod_rot',
                'car_fits', 'fuel', 'prod_add_inf', 'external_teeth', 'internal_teeth', 'prod_dim', 'height', 'abs_ring',
                'Weight', 'Disc_Dia', 'Disc_Thick', 'Piston_Dia', 'Man', 'Pump_Type', 'Pressure', 'Pully_Ribs', 'Total_Length',
                'Pin', 'Fitting_position', 'No_of_Holes', 'Bolt_Hole_Circle_Dia', 'Inner_Dia', 'Outer_Dia', 'Teeth_wheel_side',
                'Teeth_Diff_Side'
        ); //'mscode.MsCode', 'mscode.V8Key'



        $reqData = $query->groupBy('prod_part_no')->orderBy('prod_part_no', 'ASC')
                ->get();

        $columns = array("Category", "Sub_Category", "Rollco_Part", "Availability", "TYPE", "POSITION", "Volts", "Output",
            "Pulley", "REGulator", "Fan", "Teeth", "GR", "Transmission", "Rotation", "CAR_FITS", "FUEL", "INFORMATION",
            "External_Teeth", "Internal_Teeth", "Diameter", "Height", "ABS_ring", "Weight", "Disc_Dia", "Disc_Thick", "Piston_Dia",
            "Man", "Pump_Type", "Pressure", "Pully_Ribs", "Total_Length", "Pin", "Fitting_position", "No_of_Holes", "Bolt_Hole_Circle_Dia",
            "Inner_Dia", "Outer_Dia", "Teeth_wheel_side", "Teeth_Diff_Side");


        $callback = function() use ($reqData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($reqData as $review) {
                fputcsv($file, array(getMCatName($review->mcatid), getCatName($review->catid), $review->prod_part_no,
                    $review->prod_stock,
                    $review->ptype, $review->position, $review->prod_volt, $review->prod_out, $review->prod_pull_type,
                    $review->prod_regu, $review->prod_fan, $review->prod_teeth, $review->gr, $review->prod_trans,
                    $review->prod_rot, $review->car_fits, $review->fuel, $review->prod_add_inf, $review->external_teeth,
                    $review->internal_teeth, $review->prod_dim, $review->height, $review->abs_ring, $review->Weight,
                    $review->Disc_Dia, $review->Disc_Thick, $review->Piston_Dia, $review->Man, $review->Pump_Type,
                    $review->Pressure, $review->Pully_Ribs, $review->Total_Length, $review->Pin, $review->Fitting_position,
                    $review->No_of_Holes, $review->Bolt_Hole_Circle_Dia, $review->Inner_Dia, $review->Outer_Dia, $review->Teeth_wheel_side,
                    $review->Teeth_Diff_Side
                ));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function exportToCSVProductStockMaster(Request $request) {

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . date('Y-m-d-H-i-s') . "-productstock.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $query = DB::table('rollco_ms_product')
                ->select('prod_part_no', 'prod_stock'
        ); //'mscode.MsCode', 'mscode.V8Key'

        $reqData = $query->groupBy('prod_part_no')->orderBy('prod_part_no', 'ASC')
                ->get();

        $columns = array("part_no", "stock_info");


        $callback = function() use ($reqData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            //dd($reqData);

            foreach ($reqData as $review) {
                $prod_stock = '';
                $v8key = '';
                if ($review->prod_stock == 1) {
                    $prod_stock = 'EXSTOCK';
                } else if ($review->prod_stock == 2) {
                    $prod_stock = 'LOW ON STOCK';
                } else if ($review->prod_stock == 0) {
                    $prod_stock = 'NO STOCK';
                }
                fputcsv($file, array($review->prod_part_no, $prod_stock));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function exportToCSVProductStatusMaster(Request $request) {

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . date('Y-m-d-H-i-s') . "-productstatus.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $query = DB::table('rollco_ms_product')
                ->select('prod_part_no', 'prod_status'
        ); //'mscode.MsCode', 'mscode.V8Key'

        $reqData = $query->groupBy('prod_part_no')->orderBy('prod_part_no', 'ASC')
                ->get();

        $columns = array("part_no", "status");


        $callback = function() use ($reqData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            //dd($reqData);

            foreach ($reqData as $review) {
                $prod_status = '';
                if ($review->prod_status == 1) {
                    $prod_status = 'ENABLE';
                } else if ($review->prod_status == 0) {
                    $prod_status = 'DISABLE';
                }
                fputcsv($file, array($review->prod_part_no, $prod_status));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function exportToCSVCrossrefMaster(Request $request) {

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . date('Y-m-d-H-i-s') . "-crossref.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $query = DB::table('rollco_ms_crossref')
                ->select('rc_num', 'crossref_make', 'crossref_oem', 'crossref_status'
        ); //'mscode.MsCode', 'mscode.V8Key'

        $reqData = $query->orderBy('rc_num', 'ASC')
                ->get();

        $columns = array("ROLLCO", "MANUFACTURER", "OEM", "STATUS");


        $callback = function() use ($reqData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            //dd($reqData);

            foreach ($reqData as $review) {
                fputcsv($file, array($review->rc_num, $review->crossref_make, $review->crossref_oem, $review->crossref_status));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function exportToCSVApplicationMaster(Request $request) {

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . date('Y-m-d-H-i-s') . "-application.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $query = DB::table('rollco_ms_application')
                ->select('make_nm', 'model_nm', 'year', 'cc', 'part_no'
        ); //'mscode.MsCode', 'mscode.V8Key'

        $reqData = $query->orderBy('part_no', 'ASC')
                ->get();

        $columns = array("MAKE", "MODEL", "YEAR", "CC", "RCnumber");


        $callback = function() use ($reqData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            //dd($reqData);

            foreach ($reqData as $review) {
                fputcsv($file, array($review->make_nm, $review->model_nm, $review->year, $review->cc, $review->part_no));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function exportToCSVSpareMaster(Request $request) {

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . date('Y-m-d-H-i-s') . "-spare.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $query = DB::table('rollco_ms_spare')
                ->select('spare_nm', 'spare_make', 'spare_oem', 'spare_cargo', 'spare_status'
        ); //'mscode.MsCode', 'mscode.V8Key'

        $reqData = $query->orderBy('spare_nm', 'ASC')
                ->get();

        $columns = array("ROLLCO", "MANUFACTURER", "OEM", "CARGO", "STATUS");


        $callback = function() use ($reqData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            //dd($reqData);

            foreach ($reqData as $review) {
                fputcsv($file, array($review->spare_nm, $review->spare_make, $review->spare_oem, $review->spare_cargo, $review->spare_status));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function exportToCSVSpareServiceMaster(Request $request) {

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . date('Y-m-d-H-i-s') . "-spareservice.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $query = DB::table('rollco_ms_spearservice')
                ->select('spare_num', 'srvs_num'
        ); //'mscode.MsCode', 'mscode.V8Key'

        $reqData = $query->orderBy('spare_num', 'ASC')
                ->get();
        //dd($reqData);

        $columns = array("SpearCode", "ServicingUnits");


        $callback = function() use ($reqData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            //dd($reqData);

            foreach ($reqData as $review) {
                fputcsv($file, array($review->spare_num, $review->srvs_num));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function exportToCSVSpareOEMMaster(Request $request) {

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . date('Y-m-d-H-i-s') . "-spareoem.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $query = DB::table('rollco_ms_spearoem')
                ->select('spare_num', 'oem_num'
        ); //'mscode.MsCode', 'mscode.V8Key'

        $reqData = $query->orderBy('spare_num', 'ASC')
                ->get();
        //dd($reqData);

        $columns = array("SpearCode", "ReplacingOEM");


        $callback = function() use ($reqData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            //dd($reqData);

            foreach ($reqData as $review) {
                fputcsv($file, array($review->spare_num, $review->oem_num));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function exportToCSVGroupMaster(Request $request) {

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . date('Y-m-d-H-i-s') . "-groupprice.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $query = DB::table('rollco_ms_grproduct as grppro')
                ->select('grp.gr_nm', 'curr.curr_id', 'grppro.part_nm', 'grppro.pr_price');


        $query = $query->join('rollco_ms_group as grp',
                'grp.gr_id', '=', 'grppro.gr_id');
        $query = $query->join('rollco_ms_currency as curr',
                'curr.curr_id', '=', 'grp.gr_currency');


        $reqData = $query->orderBy('grp.gr_nm', 'ASC')
                ->get();

        $columns = array("GroupName", "Currency", "PartName", "Price");


        $callback = function() use ($reqData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            //dd($reqData);

            foreach ($reqData as $review) {
                $curr_name = '';

                if ($review->curr_id == '2')
                    $curr_name = 'USD';
                else if ($review->curr_id == '3')
                    $curr_name = 'GBP';
                else if ($review->curr_id == '4')
                    $curr_name = 'EURO';

                fputcsv($file, array($review->gr_nm, $curr_name, $review->part_nm, $review->pr_price));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

}
