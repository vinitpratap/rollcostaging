<?php
namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Application extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_application';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['make_nm', 'model_nm','eng_nm', 'year', 'cc','part_no','ap_status'];
}
