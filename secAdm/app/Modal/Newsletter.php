<?php
namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Newsletter extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_newsletter';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'ip_add', 'created_at'
    ];

}
