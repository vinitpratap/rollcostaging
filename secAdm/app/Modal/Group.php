<?php 
namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Group extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_group';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
//        'cat_nm',  'cat_code','cat_status','cat_img','cat_banr_img','cat_cls_nm','cat_ad','cat_ad_status','cat_ad_url'
        'gr_nm', 'gr_currency', 'gr_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
    public function getCurrency() {
        return $this->hasMany('App\Modal\Currency','curr_id','gr_currency');
    }

}
