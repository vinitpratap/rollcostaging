<?php
namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mscode extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_mscode';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
//        'subcat_nm',  'subcat_code','subcat_status','catid','subcat_img','subcat_banr_img',
        'part_no',  'MsCode','V8Key'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    

}
