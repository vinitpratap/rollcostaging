<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SalesCal extends Authenticatable {

    use Notifiable;

    protected $table = 'rollco_salescal';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'u_id', 'temp_id','full_name', 'post_code', 'sc_country', 'sc_date', 'sc_stime', 'sc_etime', 'sc_remarks', 'cdate','ipaddress','mdate','sec_id','sc_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
}
