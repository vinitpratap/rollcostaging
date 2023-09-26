<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\Modal\Exb;

class ExbController extends Controller {
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AddNewExb(Request $request) {

        $validation = Validator::make($request->all(), [
                    'exb_nm' => 'required',
                    'exb_inf' => 'required',
                    'exb_date' => 'required',
                    'exb_place' => 'required',
                    'exb_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('exb_nm', 'exb_inf', 'exb_date', 'exb_place', 'exb_status'));
        }

        $status = Exb::where('exb_date', $request->exb_date)
                ->where('exb_place', $request->exb_place)
                ->first();

        if ($status) {
            return redirect()->back()->withErrors(['message', 'Exhibition already exists']);
        } else {

            $dataToInsert = array('exb_nm' => $request->exb_nm,
                'exb_inf' => $request->exb_inf,
                'exb_date' => date('Y-m-d H:i:s', strtotime($request->exb_date)),
                'exb_place' => $request->exb_place,
                'exb_status' => $request->exb_status,
            );
            // dd($dataToInsert);
            $id = Exb::create($dataToInsert)->id;
            $logData = array('subject_id' => $id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_exb',
                'description' => 'insert', 'data_prev' => '', 'data_now' => urldecode(http_build_query($request->all()))
            );
            saveQueryLog($logData);
            if ($id) {
                if ($request->hasFile('exb_img')) {
                    $image = $request->file('exb_img');
                    $ser_img = time() . $image->getClientOriginalName();
                    $destinationPath = public_path('/upload/exhibition/');
                    $valImage = validateImage($image->getClientOriginalExtension());
                    if ($valImage) {
                        $image_resize1 = Image::make($image->getRealPath());
                        $image_resize1->resize(300, 300);
                        $image_resize1->save(public_path('/upload/exhibition/th/' . $ser_img));

                        $image_resize2 = Image::make($image->getRealPath());
                        $image_resize2->resize(250, 250);
                        $image_resize2->save(public_path('/upload/exhibition/thm/' . $ser_img));
                        $image->move($destinationPath, $ser_img);
                    } else if ($image->getClientOriginalExtension() == 'svg') {
                        $image->move($destinationPath, $ser_img);
                        copy($destinationPath . $ser_img, public_path('/upload/exhibition/thm/') . $ser_img);
                        copy($destinationPath . $ser_img, public_path('/upload/exhibition/th/') . $ser_img);
                    } else {
                        return redirect()->back()->withErrors(['message', 'file format is not image']);
                    }
                    $image_update = array('exb_img' => $ser_img);
                    Exb::where('exb_id', $id)->update($image_update);
                }

                return redirect()->back()->with('message', 'Exhibition successfully created');
            } else {
                return redirect()->back()->with('message', 'Error while creating exhibition');
            }
        }
    }

    /*

     * View customers 
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function Exbs() {
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $data = Exb::orderBy('created_at', 'ASC')->get();
            return view('admin.exb.manage-exb', array('data' => $data));
        } else {
            return redirect('admin/dashboard')->with('message', 'Not Allowed');
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function EditExb(Request $request) {

       // dd($request->all());
        $validation = Validator::make($request->all(), [
                    'exb_nm' => 'required',
                    'exb_inf' => 'required',
                    'exb_date' => 'required',
                    'exb_place' => 'required',
                    'exb_status' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput($request->only('exb_nm', 'exb_inf', 'exb_date', 'exb_place', 'exb_status'));
        }



        $status = Exb::where('exb_date', $request->exb_date)
                ->where('exb_place', $request->exb_place)
                ->where('exb_id', '!=', $request->exb_id)
                ->first();
        if ($status) {
            return redirect()->back()->withErrors(['message', 'Exhibition already exists']);
        } else {
            $data = Exb::Where('exb_id', $request->exb_id)->first();
            //dd($data);

            $changed_data = array('exb_nm' => $request->exb_nm,
                'exb_inf' => $request->exb_inf,
                'exb_date' => date('Y-m-d H:i:s', strtotime($request->exb_date)),
                'exb_place' => $request->exb_place,
                'exb_status' => $request->exb_status,
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
            $logData = array('subject_id' => $request->exb_id, 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_exb', 'description' => 'update', 'data_prev' => urldecode(http_build_query($diff_in_data_to_save)), 'data_now' => urldecode(http_build_query($changed_data))
            );
            //dd($logData);
            $diff_in_data_to_save = array();
            $data_to_update = array();
            $ser_img = '';
            if ($request->hasFile('exb_img')) {
                $image = $request->file('exb_img');
                $ser_img = time() . $image->getClientOriginalName();
                $destinationPath = public_path('/upload/exhibition/');
                $valImage = validateImage($image->getClientOriginalExtension());
                if ($valImage) {
                    $image_resize1 = Image::make($image->getRealPath());
                    $image_resize1->resize(300, 300);
                    $image_resize1->save(public_path('/upload/exhibition/th/' . $ser_img));

                    $image_resize2 = Image::make($image->getRealPath());
                    $image_resize2->resize(250, 250);
                    $image_resize2->save(public_path('/upload/exhibition/thm/' . $ser_img));
                    $image->move($destinationPath, $ser_img);
                } else if ($image->getClientOriginalExtension() == 'svg') {
                    $image->move($destinationPath, $ser_img);
                    copy($destinationPath . $ser_img, public_path('/upload/exhibition/thm/') . $ser_img);
                    copy($destinationPath . $ser_img, public_path('/upload/exhibition/th/') . $ser_img);
                } else {
                    return redirect()->back()->withErrors(['message', 'file format is not image']);
                }
                $image_update = array('exb_img' => $ser_img == '' ? $data['exb_img'] : $ser_img);
                Exb::where('exb_id', $request->exb_id)->update($image_update);
            }
            saveQueryLog($logData);
            $updateCat = Exb::Where('exb_id', $request->exb_id)->update($changed_data);
            if ($updateCat) {
                return redirect('admin/view-exb')->with('message', 'Exhibition successfully updated');
            } else {
                return redirect()->back()->with('message', 'Error while updating exhibition');
            }
        }
    }

    /*

     * Edit customers
     * Sanjit Bhardwaj
     * 10-01-2018
     */

    public function DeleteExb($id) {

        $data = Exb::where('exb_id', '=', base64_decode($id))->first();

        $logData = array('subject_id' => base64_decode($id), 'user_id' => Auth::id(), 'table_used' => 'rollco_ms_exb',
            'description' => 'delete', 'data_prev' => urldecode(http_build_query($data->toArray())), 'data_now' => ''
        );

        saveQueryLog($logData);
        $status = DB::table('rollco_ms_exb')->where('exb_id', base64_decode($id))->delete();
        if ($status) {
            return redirect('admin/view-exb')->with('message', 'Exhibition successfully deleted');
        } else {
            return redirect()->back()->with('message', 'Error while deleting exhibition');
        }
    }

    public function GetExbData(Request $request) {
        $cat = Exb::Where('exb_id', base64_decode($request->id))->first();
        $cat->exb_date = date("d-m-Y", strtotime($cat->exb_date));
        echo json_encode($cat);
    }

}
