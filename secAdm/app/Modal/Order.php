<?php 
namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Order extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_order';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
//        'cat_nm',  'cat_code','cat_status','cat_img','cat_banr_img','cat_cls_nm','cat_ad','cat_ad_status','cat_ad_url'
        'order_no', 'user_id', 'totalprice', 'Qty', 'order_status', 'remarks'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
    public function getUserDetails() {
        return $this->hasMany('App\Modal\Customer','u_id','user_id');
    }

    public function getOrderDetails() {
        return $this->hasMany('App\Modal\OrderDetail','order_id','order_id');
    }

}
