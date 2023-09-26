<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Services extends Authenticatable {

    use Notifiable;

    protected $table = 'rollco_ms_services';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ser_nm', 'ser_code', 'catid', 'subcatid', 'ser_attr', 'ser_price', 'ser_tax', 'ser_status','ser_img','ser_banr_img','ser_details','min_order','min_ordr_chrg','ser_base_price','ser_cgst_rate','ser_cgst_amt','ser_sgst_rate','ser_sgst_amt'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function getCategory() {
        return $this->hasOne('App\Modal\Category', 'cat_id', 'catid');
    }

    public function timeslots() {
        return $this->hasMany('App\Modal\TimeSlotsToServiceMap', 'service_id', 'ser_id');
    }

    public function locations() {
        return $this->hasMany('App\Modal\LocationToServiceMap', 'service_id', 'ser_id');
    }

}
