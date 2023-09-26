<?php
namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ProCCM extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_proccm';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'catid',  'makeid','modelid','proyrid','proccm_inf','proccm_status'
    ];


}
