<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Ads extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_app_ads';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ads_url','ads_title','ads_img','ads_status','ads_ordering','all_cat'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
