<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SalesCalLog extends Authenticatable {

    use Notifiable;

    protected $table = 'rollco_salescallog';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sc_id', 'u_id', 'temp_id', 'full_name', 'post_code', 'sc_country', 'sc_date', 'sc_stime', 'sc_etime', 'sc_remarks', 'cdate', 'ipaddress', 'sec_id', 'sc_status', 'log_action', 'reason_delete', 'log_date', 'log_secid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
}
