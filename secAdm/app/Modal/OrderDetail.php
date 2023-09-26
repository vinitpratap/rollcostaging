<?php 
namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class OrderDetail extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_order_details';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
//        'cat_nm',  'cat_code','cat_status','cat_img','cat_banr_img','cat_cls_nm','cat_ad','cat_ad_status','cat_ad_url'
        'order_id', 'prod_id', 'user_id', 'prod_price', 'prod_qty', 'comments'
    ];


}
