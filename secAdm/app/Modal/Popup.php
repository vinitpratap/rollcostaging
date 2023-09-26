<?php
namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Popup extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_popup';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'p_title', 'p_content', 'p_image','p_status'
    ];

}
