<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Terms extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_terms_condition';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'term_text','term_title'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
