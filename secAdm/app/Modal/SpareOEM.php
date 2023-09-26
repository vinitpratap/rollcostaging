<?php
namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SpareOEM extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_spearoem';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['spare_num','oem_num'];
}
