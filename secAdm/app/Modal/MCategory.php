<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MCategory extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_mcat';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mcat_nm', 'mcat_image', 'mcat_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
    public function getSubCategories() {
        return $this->hasMany('App\Modal\SubCategory','catid','cat_id');
    }

}
