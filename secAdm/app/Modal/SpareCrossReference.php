<?php
namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SpareCrossReference extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_sparecrossref';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'spareid','serv_no','comp_oem_no'
    ];


}
