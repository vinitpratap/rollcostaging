<?php
namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Spare extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_spare';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'spare_nm','spare_part_no','spare_cargo','spare_oem','spare_desc','spare_avail','spare_add_inf','spare_img1','spare_img2','spare_img3','spare_img4','spare_img5','spare_img6','spare_img7','spare_img8','spare_status','spare_price','spare_make'
    ];


}
