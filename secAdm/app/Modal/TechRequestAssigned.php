<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TechRequestAssigned extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_cust_req_tech_assign';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'req_id',  'tech_id','tech_name','tech_email','tech_mobile','assign_dte',
        'assign_by','is_accepted','accepted_datetime','wrkstrt_datetime','wrkclose_datetime','cust_otp','otp_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */



}
