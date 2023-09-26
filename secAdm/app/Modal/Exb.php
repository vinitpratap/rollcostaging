<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Exb extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_exb';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exb_nm','exb_inf','exb_date','exb_place','exb_status','exb_img'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
   

}
