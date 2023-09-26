<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Currency extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_currency';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'curr_name','curr_status','curr_info'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
   

}
