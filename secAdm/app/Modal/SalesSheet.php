<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SalesSheet extends Authenticatable {

    use Notifiable;

    protected $table = 'rollco_ms_sales_sheet';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'user_email', 'roll_last_year_turnover', 'roll_share_per', 'gross_qty', 'gross_faulty', 'gross_faulty_per', 'gross_return_stock', 'faulty_cat_qty', 'faulty_cat_nff', 'faulty_cat_transit_damage', 'faulty_cat_contanimated', 'roll_curr_outstanding', 'roll_consgnmt_qty', 'roll_overdue_outstanding', 'roll_consgnmt_value', 'roll_last_stock_cdate', 'roll_sor_extended', 'roll_last_visit'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function getSalesCategoryValue() {
        return $this->hasMany('App\Modal\SalesSheetCategoryValue', 'ssv_ss_id', 'ss_id');
    }
    
    public function getSalesAppointmentInfo() {
        return $this->hasMany('App\Modal\SalesSheetAppointment', 'sa_ss_id', 'ss_id');
    }

}
