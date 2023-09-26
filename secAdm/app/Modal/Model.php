<?php
namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Model extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_model';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
//        'subcat_nm',  'subcat_code','subcat_status','catid','subcat_img','subcat_banr_img',
        'catid',  'makeid','model_nm','model_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
    public function getCategory(){
        return $this->hasOne('App\Modal\Category','cat_id','catid');
    }

}
