<?php
namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Catalogue extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_catalogues';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cat_title','cat_filename','fly_detail','cat_thnail'
    ];


}
