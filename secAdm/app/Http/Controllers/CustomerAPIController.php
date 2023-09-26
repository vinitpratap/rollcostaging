<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modal\Customer;
use Illuminate\Support\Facades\Auth;
use Validator;

class CustomerAPIController extends Controller {

    public $successStatus = 200;

    public function __construct() {
       // $this->middleware('auth:api');
    }

    /**
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function login() {
        
        dd(Auth::guard('web')->check(['cust_email' => request('email'), 'cust_pwd' => request('password')]));
        if (Auth::guard('web')->check(['cust_email' => request('email'), 'cust_pwd' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    /**
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required|email',
                    'password' => 'required',
                    'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;
        return response()->json(['success' => $success], $this->successStatus);
    }

    /**
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function details() {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

}
