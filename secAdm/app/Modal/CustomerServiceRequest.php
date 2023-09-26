<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CustomerServiceRequest extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_cust_req_serv';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'req_id',  'serv_id','serv_nm','serv_code','serv_attr','serv_price',
        'serv_tax','serv_quan','serv_req_ordr_subttl','serv_req_ordr_tax_subttl','serv_catnm',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */



}
