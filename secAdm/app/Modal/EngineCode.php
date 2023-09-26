<?php
namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class EngineCode extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_engcode';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'catid',  'makeid','modelid','proyrid','proccmid','engcode_inf','engcode_status'
    ];


}
