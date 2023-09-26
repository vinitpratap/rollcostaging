<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SalesSheetAppointment extends Authenticatable {

    use Notifiable;

    protected $table = 'rollco_ms_sales_appointment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sa_ss_id', 'sa_apt_details', 'sa_apt_action','AcCode','SalesPersonName','CreatedBy','other_text'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
}
