<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SalesSheetCategoryValue extends Authenticatable {

    use Notifiable;

    protected $table = 'rollco_ms_scat_sales_val';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ssv_scat_id', 'ssv_scat_name', 'ssv_scat_year', 'ssv_scat_value', 'ssv_scat_qty', 'ssv_scat_faulty', 'ssv_scat_faulty_per','ssv_ss_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
}
