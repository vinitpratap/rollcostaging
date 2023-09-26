<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Location extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_loc';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'loc_nm',  'loc_code','loc_status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
