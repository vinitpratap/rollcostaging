<?php 
namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class GroupProduct extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_grproduct';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gr_id','part_nm','pr_price'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
    public function getGroup() {
        return $this->hasMany('App\Modal\Group','gr_id','gr_id');
    }
}
