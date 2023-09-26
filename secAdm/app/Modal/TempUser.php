<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TempUser extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_tmpusers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName','lastName','com_city','com_zipCode','customerID'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
