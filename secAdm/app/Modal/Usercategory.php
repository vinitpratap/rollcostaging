<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usercategory extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_cust_cat';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cust_cat_nme','cust_cat_status','cust_cat_info'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
   

}
