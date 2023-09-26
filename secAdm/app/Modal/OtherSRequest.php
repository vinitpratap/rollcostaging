<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class OtherSRequest extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_other_req';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cust_nm',  'cust_email ','cust_phone','cust_loc','cust_remarks'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
