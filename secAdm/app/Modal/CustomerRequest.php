<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CustomerRequest extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_cust_req';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'req_code',  'req_date','req_ordr_amnt','req_dte_pref','req_timeslot_pref','req_usr_remarks',
        'req_tech_remarks','req_status','req_is_cancelled','req_cancl_by_type','req_cancl_by_id',
        'req_cancl_dte','req_parent','cust_id','cust_nm','cust_email','cust_code','cust_loc','cust_serviceadd1',
        'cust_serviceadd2','cust_pin','cust_ip','req_overall_rting','req_overall_tech_rting','req_usr_fbck',
        'req_trans_id','req_trans_status','req_trans_msg','req_trans_date','req_trans_mode','req_trans_bank_nm'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    
    function serviceInfo(){
        return $this->hasOne('App\Modal\CustomerServiceRequest', 'req_id', 'id');
    }
    
    
     function techInfo(){
        return $this->hasOne('App\Modal\TechRequestAssigned', 'req_id', 'id');
    }
    

}
