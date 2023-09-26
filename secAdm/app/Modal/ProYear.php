<?php
namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ProYear extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_proyr';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'catid',  'makeid','modelid','proyr_from','proyr_to','proyr_status','current_flag'
    ];


}
