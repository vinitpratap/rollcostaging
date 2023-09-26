<?php

namespace App\Http\Controllers;
ini_set('max_execution_time', '0');
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use App\Modal\Product;
use App\Modal\Customer;
use App\Modal\CrossReference;
use Excel;
use Intervention\Image\ImageManagerStatic as Image;
use App\Exports\CrossRefExport;
use Response;

class CrossReferenceController extends Controller {
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

    /*     * $category
     * Where to redirect users after login.
     *
     * @var string
     */

//     protected $redirectTo = '/dashboard';



    public function __construct() {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AddNewCrossRef(Request $request) {
        $validation = Validator::make($request->all(),
                        [
                            'crossref_file' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('prodid',
                                    'crossref_file'));
        }

        if (Input::hasFile('crossref_file')) {
            $file = Input::file('crossref_file');

            if ($file->getClientOriginalExtension() == 'csv') {
				
                $name = $file->getClientOriginalName();
				
				$name = preg_replace("/[^\.\-\_a-zA-Z0-9]/", "", $name);
				//Not really uniqe - but for all practical reasons, it is
				$uniqer = substr(md5(uniqid(rand(), 1)), 0, 6);
				$name = $uniqer . '_' . $name; //Get Unique Name				

                $path = public_path('/upload/csv');

                // Moves file to folder on server
                $file->move($path, $name);

                $file1 = public_path('/upload/csv/' . $name);

                $productArr = csvToArray($file1);
				if(count($productArr) >0){
							
						}else{
							return redirect()->back()->withErrors(['message', 'Uploaded file is empty']);
				}
                // dd($productArr);
                $data = [];
                for ($i = 0; $i < count($productArr); $i ++) {
                    $RCNumber = '';
                    $MANUFACTURER = '';
                    $OEM = '';
                    $STATUS = '';
//dd($productArr);                    

                    if (isset($productArr[$i]['RCNumber']))
                            $RCNumber = trim(utf8_encode($productArr[$i]['RCNumber']));
                    if (isset($productArr[$i]['MANUFACTURER']))
                            $MANUFACTURER = trim(utf8_encode($productArr[$i]['MANUFACTURER']));
                    if (isset($productArr[$i]['OEM']))
                            $OEM = trim(utf8_encode($productArr[$i]['OEM']));
                    if (isset($productArr[$i]['STATUS']))
                            $STATUS = trim(utf8_encode($productArr[$i]['STATUS']));
					
					if($STATUS == "ENABLE"){
						$STATUS = 1;
					}elseif($STATUS == "DISABLE"){
						$STATUS = 0;
					}
					
					$RCNumber = remove_accents($RCNumber);
					$MANUFACTURER = remove_accents($MANUFACTURER);
					$OEM = remove_accents($OEM);

                    if ($RCNumber != '' && $MANUFACTURER != '' && $OEM != '') {
                        $data = ['rc_num' => $RCNumber, 'crossref_make' => $MANUFACTURER,
                            'crossref_oem' => $OEM, 'crossref_status' => $STATUS];


                        $prstatus = CrossReference::where('rc_num', $RCNumber)
                                ->where('crossref_make', $MANUFACTURER)
                                ->where('crossref_oem', $OEM)
                                ->first();
                        if ($prstatus) {
                            $updatedata = ['crossref_status' => $STATUS];
							CrossReference::where('rc_num', $RCNumber)
                                ->where('crossref_make', $MANUFACTURER)
                                ->where('crossref_oem', $OEM)
								->update($updatedata);
                        } else {
                            $id = CrossReference::create($data);
                        }
                    }else{
						return redirect()->back()->withErrors(['message', 'Required fields are empty']);
					}
                }
            } else {
                return redirect()->back()->withErrors(['message', 'file format is not csv']);
            }

            return redirect()->back()->with('message',
                            'Cross reference successfully created');
        } else {
            return redirect()->back()->with('message',
                            'Error while creating cross reference');
        }
    }

    /*

     * View list 
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function CrossRefs(Request $request) {
        $page_val = 50;
        $pagination_arr = array(50, 100);
        if (Auth::guard('admin')->user()->admin_role == 1) {

            $custData = Customer::where('companyName', '!=', '')
                    ->where('cust_type', 1)
                    ->where('g_id','!=', 0)
                    ->orderby('companyName', 'ASC')
                    ->get();
            $query = CrossReference::query();

            if (!empty($request->search)) {
                $search = $request->search;

                $query = $query->where(function($query) use ($search) {
                    $query->where('crossref_make', 'LIKE', '%' . $search . '%');
                    $query->orWhere('crossref_oem', 'LIKE', '%' . $search . '%');
                    $query->orWhere('rc_num', 'LIKE', '%' . $search . '%');
                });
            }

            if (!empty($request->data_entries)) {
                $page_val = $request->data_entries;
            }
            $pageData = $query->orderby('rc_num', 'ASC')
                    ->paginate($page_val)
                    ->withPath('?search=' . $request->search . '&data_entries=' . $page_val);

            return view('admin.product.manage-crossreference',
                    array('data' => $pageData, 'data_entries' => $page_val, 'custData' => $custData,
                        'pagination_arr' => $pagination_arr));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit data
     * Sanjit Bhardwaj
     * 11-01-2018
     */

    public function DeleteCrossRef($id) {
        $data = CrossReference::where('crossref_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(),
            'table_used' => 'rollco_ms_crossref',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())),
            'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_crossref')->where('crossref_id',
                        base64_decode($id))->delete();
        if ($status) {
            return redirect()->back()->with('message',
                            'Cross reference successfully deleted');
        } else {
            return redirect()->back()->with('message',
                            'Error while deleting cross reference');
        }
    }

    public function DeleteCrossRefAjax(Request $request) {
        
        $status = DB::table('rollco_ms_crossref')->whereIn('crossref_id',
                        $request['ids'])->delete();
        if ($status) {
            echo 1;
        } else {
            echo 0;
        }
    }
    
    public function ChangeStatusCrossRefAjax(Request $request) {
        $flag = 0;
        for ($i = 0; $i < count($request->ids); $i++) {
            $checkstatus = CrossReference::select('crossref_status')->Where('crossref_id', $request->ids[$i])->first();
            //dd($checkstatus['crossref_status']);
            if ($checkstatus['crossref_status'] == 1) {
                $status = CrossReference::where('crossref_id', $request->ids[$i])->update(array('crossref_status' => 0));
                if ($status) {
                    $flag = 1;
                }
            } else if ($checkstatus['crossref_status'] == 0) {
                $status = CrossReference::where('crossref_id', $request->ids[$i])->update(array('crossref_status' => 1));
                if ($status) {
                    $flag = 1;
                }
            }
        }

        if ($flag) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function GetCrossRefData(Request $request) {
        $cat = CrossReference::Where('crossref_id', base64_decode($request->id))->first();
        echo json_encode($cat);
    }

    public function EditCrossRef(Request $request) {

        $validation = Validator::make($request->all(),
                        [
                            'crossref_id' => 'required',
                            'rc_num' => 'required',
                            'crossref_make' => 'required',
                            'crossref_oem' => 'required'
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('crossref_id',
                                    'rc_num', 'crossref_make', 'crossref_oem'));
        }
        $name = $request->cat_nm;

        $status = CrossReference::where('rc_num', $request->rc_num)
                ->where('crossref_make', $request->crossref_make)
                ->where('crossref_oem', $request->crossref_oem)
                ->where('crossref_id', '!=', $request->crossref_id)
                ->first();
        if ($status) {
            return redirect()->back()->withErrors(['message', 'Cross references already exists']);
        } else {
            $data = CrossReference::Where('crossref_id', $request->crossref_id)->first();
            //dd($data);

            $changed_data = array('rc_num' => $request->rc_num, 'crossref_make' => $request->crossref_make,
                'crossref_oem' => $request->crossref_oem, 'crossref_status' => $request->crossref_status
            );

            $diff_in_data = array_diff_assoc($data->getOriginal(), $changed_data);
            $diff_in_data_to_save = array();
            $keys_to_be_updated = array_keys($diff_in_data);

            for ($i = 0; $i < count($keys_to_be_updated); $i++) {
                if (isset($changed_data[$keys_to_be_updated[$i]])) {
                    $data_to_update[$keys_to_be_updated[$i]] = $changed_data[$keys_to_be_updated[$i]];
                    $diff_in_data_to_save[$keys_to_be_updated[$i]] = $diff_in_data[$keys_to_be_updated[$i]];
                }
            }
            $logData = array('subject_id' => $request->crossref_id, 'user_id' => Auth::id(),
                'table_used' => 'rollco_ms_crossref',
                'description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)),
                'data_now' => urldecode(http_build_query($changed_data))
            );
            //dd($logData);
            saveQueryLog($logData);
            $updateCat = CrossReference::Where('crossref_id',
                            $request->crossref_id)->update($changed_data);

            if ($updateCat) {
                return redirect()->back()->with('message',
                                'Cross references
 successfully updated');
            } else {
                return redirect()->back()->with('message',
                                'Error while updating Cross references');
            }
        }
    }

    /*function exportToExcelCrossRef() {
        $exporter = app()->makeWith(CrossRefExport::class);
        return $exporter->download(date('Y-m-d-H-i-s') . '-product.xlsx');
    }*/
	
	
	function exportToExcelCrossRef(Request $request) {
        /* $headers = array(
          "Content-type" => "text/csv",
          "Content-Disposition" => "attachment; filename=" . date('Y-m-d-H-i-s') . "-productcrossref.csv",
          "Pragma" => "no-cache",
          "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
          "Expires" => "0"
          ); */

        $query = DB::table('rollco_ms_crossref')
                ->select('rc_num', 'crossref_make', 'crossref_oem', 'crossref_status');


        if (!empty($request->search)) {
            $search = $request->search;

            $query = $query->where(function($query) use ($search) {
                $query->where('rc_num', 'LIKE', '%' . $search . '%');
                $query->orWhere('crossref_make', 'LIKE', '%' . $search . '%');
                $query->orWhere('crossref_oem', 'LIKE', '%' . $search . '%');
            });
        }

        $reqData = $query->orderBy('created_at', 'DESC')
                ->get();

        $content = "RCNumber \t MANUFACTURER \t  OEM \t STATUS \n";
        foreach ($reqData as $key => $value) {
            if ($value->crossref_status == 1) {
                $value->crossref_status = 'ENABLE';
            } else {
                $value->crossref_status = 'DISABLE';
            }
            $content .= $value->rc_num;
            $content .= "\t";
            $content .= $value->crossref_make;
            $content .= "\t";
            $content .= $value->crossref_oem;
            $content .= "\t";
            $content .= $value->crossref_status;
            $content .= "\n";
        }

        //dd($content);

        $fileName = date('Y-m-d-H-i-s') . "-productcrossref.txt";

        $headers = [
            'Content-type' => 'text/plain',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        // make a response, with the content, a 200 response code and the headers
        //return response()->stream($content, 200, $headers);
        return Response::make($content, 200, $headers);
        //debug($reqData[0]);
        /* $columns = array("RCNumber", "MANUFACTURER", "OEM", "STATUS");

          $callback = function() use ($reqData, $columns) {
          $file = fopen('php://output', 'w');
          fputcsv($file, $columns);
          //dd($reqData);

          foreach ($reqData as $review) {
          if ($review->crossref_status == 1) {
          $review->crossref_status = 'ENABLE';
          } else {
          $review->crossref_status = 'DISABLE';
          }
          fputcsv($file, array($review->rc_num, $review->crossref_make, $review->crossref_oem, $review->crossref_status));
          }
          fclose($file);
          };
          return response()->stream($callback, 200, $headers); */
    }
    
    
    function exportToExcelCrossRefCust(Request $request) {
        //dd($request->all());
         $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . date('Y-m-d-H-i-s') . "-productcrossrefcust.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $comp_arr = explode('_', $request->comp_name);
        $query = DB::table('rollco_ms_crossref')
                ->select('rc_num', 'crossref_make', 'crossref_oem', 'crossref_status');
        

        if (!empty($request->search)) {
            $search = $request->search;

            $query = $query->where(function($query) use ($search) {
                $query->where('rc_num', 'LIKE', '%' . $search . '%');
                $query->orWhere('crossref_make', 'LIKE', '%' . $search . '%');
                $query->orWhere('crossref_oem', 'LIKE', '%' . $search . '%');
            });
        }

        $reqData = $query->orderBy('created_at', 'DESC')
                ->get();

        $price = getGroupPrice($comp_arr[0],$request->search);
        $columns = array("RCNumber", "MANUFACTURER", "OEM", "STATUS","Company","Group","Price");
        $cname = '';
        $gname = '';
        $price = '';
        $callback = function() use ($reqData, $columns,$comp_arr) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            //dd($reqData);

            foreach ($reqData as $review) {
                if ($review->crossref_status == 1) {
                    $review->crossref_status = 'ENABLE';
                } else {
                    $review->crossref_status = 'DISABLE';
                }
                $cname = getUserName($comp_arr[1]);
                $gname = getGroupName($comp_arr[0]);
                $price = getGroupPrice($comp_arr[0],$review->rc_num);
                fputcsv($file, array($review->rc_num, $review->crossref_make, $review->crossref_oem, $review->crossref_status,$cname,$gname,$price));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

	function exportToCsvCrossRef(Request $request) {
        $headers = array(
          "Content-type" => "text/csv",
          "Content-Disposition" => "attachment; filename=" . date('Y-m-d-H-i-s') . "-productcrossref.csv",
          "Pragma" => "no-cache",
          "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
          "Expires" => "0"
          ); 

        $query = DB::table('rollco_ms_crossref')
                ->select('rc_num', 'crossref_make', 'crossref_oem', 'crossref_status');


        if (!empty($request->search)) {
            $search = $request->search;

            $query = $query->where(function($query) use ($search) {
                $query->where('rc_num', 'LIKE', '%' . $search . '%');
                $query->orWhere('crossref_make', 'LIKE', '%' . $search . '%');
                $query->orWhere('crossref_oem', 'LIKE', '%' . $search . '%');
            });
        }

        $reqData = $query->orderBy('created_at', 'DESC')
                ->get();

        //debug($reqData[0]);
        $columns = array("RCNumber", "MANUFACTURER", "OEM", "STATUS");

          $callback = function() use ($reqData, $columns) {
          $file = fopen('php://output', 'w');
          fputcsv($file, $columns);
          //dd($reqData);

          foreach ($reqData as $review) {
          if ($review->crossref_status == 1) {
          $review->crossref_status = 'ENABLE';
          } else {
          $review->crossref_status = 'DISABLE';
          }
          fputcsv($file, array($review->rc_num, $review->crossref_make, $review->crossref_oem, $review->crossref_status));
          }
          fclose($file);
          };
          return response()->stream($callback, 200, $headers);
    }
	
	
	public function ChangeStatusCrossRefData() {
        if (Auth::guard('admin')->user()->admin_role == 1) {

            if (Input::hasFile('crefstatus_file')) {
                $file = Input::file('crefstatus_file');
                if ($file->getClientOriginalExtension() == 'csv') {
                    $name = $file->getClientOriginalName();

                    $name = preg_replace("/[^\.\-\_a-zA-Z0-9]/", "", $name);
                    //Not really uniqe - but for all practical reasons, it is
                    $uniqer = substr(md5(uniqid(rand(), 1)), 0, 6);
                    $name = $uniqer . '_' . $name; //Get Unique Name
//                $path = public_path('/upload/csv');
                    $path = public_path('/upload/product-entity');

                    // Moves file to folder on server
                    $file->move($path, $name);

                    $file1 = public_path('/upload/product-entity/' . $name);

                    $productArr = csvToArray($file1);

                 //dd($productArr);
				 
                    for ($i = 0; $i < count($productArr); $i++) {
                        $prdata = [];

                        $ProductName = '';
                        $Status = '';
                        if (isset($productArr[$i]['ProductName']))
                            $ProductName = trim($productArr[$i]['ProductName']);
                        if (isset($productArr[$i]['Status']))
                            $Status = trim($productArr[$i]['Status']);
						
						
						$ProductName = remove_accents($ProductName);
						
						if($Status == "ENABLE"){
							$Status = 1;
						}else if($Status == "DISABLE"){
							$Status = 0;
						}
                        if ($ProductName != '' && $Status != '') {
                            $prstatus = CrossReference::where('rc_num', $ProductName)
                                    ->update(array('crossref_status'=>$Status));
                        }
                    }

                    return redirect()->back()->with('message',
                                    'Croossref status
successfully changed.');
                } else {
                    return redirect()->back()->withErrors(['message', 'file format is not csv']);
                }
            } else {
                return view('admin.product.uploadcrossrefstatus');
            }
            return view('admin.product.uploadcrossrefstatus');
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

}
