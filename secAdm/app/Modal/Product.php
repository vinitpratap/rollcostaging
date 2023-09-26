<?php
namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Product extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_product';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mcatid', 'catid', 'makeid','modelid','proyrid','prod_nm','prod_part_no','prod_desc','prod_volt','prod_out',
		'prod_regu','prod_pull_type','prod_fan','prod_stock','prod_add_inf','prod_teeth','prod_trans','prod_rot','prod_dim',
		'prod_status','proccmid','engid','prod_price','is_latest', 'ptype', 'position', 'gr', 'car_fits', 'fuel', 
		'external_teeth', 'internal_teeth', 'diameter', 'height', 'abs_ring', 'mscode', 'comment','cylinders',
		'prod_overview','prod_img1','prod_img2','prod_img3','prod_img4','prod_img5','prod_img6','prod_img7',
		'prod_img8','prod_qty','prod_statusdesc','Weight','Disc_Dia','Disc_Thick','Piston_Dia','Man','Pump_Type',
		'Pressure','Pully_Ribs','Total_Length','Pin','Fitting_position','No_of_Holes','Bolt_Hole_Circle_Dia','Inner_Dia',
		'Outer_Dia','Teeth_wheel_side','Teeth_Diff_Side'
    ];

}
