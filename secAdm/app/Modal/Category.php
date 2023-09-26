<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Category extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_cat';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
//        'cat_nm',  'cat_code','cat_status','cat_img','cat_banr_img','cat_cls_nm','cat_ad','cat_ad_status','cat_ad_url'
        'mcatid', 'cat_nm', 'cat_detail', 'cat_catlog', 'cat_image', 'cat_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function getMCategory(){
        return $this->hasOne('App\Modal\MCategory','mcat_id','mcatid');
    }
    
    public function getSubCategories() {
        return $this->hasMany('App\Modal\SubCategory','catid','cat_id');
    }

}
