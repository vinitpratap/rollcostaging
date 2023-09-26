<?php

use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

Route::any('login', 'CustomerAPIController@login');
Route::post('register', 'CustomerAPIController@register');
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('details', 'CustomerAPIController@details');
});
