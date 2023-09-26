<?php

namespace App\Modal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class DelUser extends Authenticatable
{
    use Notifiable;
    protected $table = 'rollco_ms_users_deleted';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'chooseOption', 'firstName', 'lastName', 'streetAddress1', 'streetAddress2', 'com_city', 'com_state', 'com_zipCode', 'com_Telephone', 'com_Fax', 'com_emailAddress', 'password', 'role', 'other', 'companyName', 'companyWebsite', 'companyRegistrationNumber', 'companyVatNumber', 'companyAge', 'companyAttachedDoc', 'companyRegAdd1', 'companyRegAdd2', 'companyRegCity', 'companyRegState', 'companyRegZip', 'companyInvAdd1', 'companyInvAdd2', 'companyInvCity', 'companyInvState', 'companyInvZip', 'companyAccountPerName', 'companyAccountPerEmail', 'companyAccountPerMobile', 'companyAccountPerDepartment', 'companyturnover', 'companyBranches', 'companyBranchesCount', 'companyBankName', 'companyBankAddress', 'companyBankPostCode', 'companyBankAccount', 'companyContactNumber', 'companySortCode', 'user_status', 'email_flag', 'ofr_flag', 'regisdate','g_id', 'CurrencyName', 'Country', 'IPAddress','cust_type','report_access','cal_show','c_verified'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
