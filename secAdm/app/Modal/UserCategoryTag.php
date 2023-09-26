<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserCategoryTag extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_user_to_category_tag';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'u_id','cat_id' 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
