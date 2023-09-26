<?php
namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CrossReference extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_crossref';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rc_num','crossref_make','crossref_oem', 'crossref_status'
    ];


}
