<?php
namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SpareService extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_spearservice';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['spare_num','srvs_num'];
    
    public function getSpare() {
        return $this->hasMany('App\Modal\Spare','spare_part_no','spare_num');
    }

}
