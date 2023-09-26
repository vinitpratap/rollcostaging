<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Announcement extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_announcement';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'announcement_text','announcement_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
   

}
