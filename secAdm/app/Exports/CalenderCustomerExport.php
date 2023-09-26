<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Modal\Contact;
use Illuminate\Http\Request;
use Auth;
Use DB;

class CalenderCustomerExport implements FromCollection, WithHeadings {

    use Exportable;

    protected $search;
    protected $status;

    public function __construct(Request $request, Contact $detail) {

        if (!empty($request->search)) {
            $this->search = $request->search;
        }
        if (!empty($request->status)) {
            $this->status = $request->status;
        }
        //dd($request->all());
    }

    public function collection() {

        $date = '';
        $from = '';
        $to = '';

        $query = DB::table('rollco_ms_users')
                ->select('u_id','customerID', 'g_id', 'firstName', 'lastName', 'streetAddress1', 'streetAddress2', 'com_city', 'com_state', 'com_zipCode', 'com_Telephone', 'com_Fax', 'com_emailAddress', 'role', 'companyName', 'companyWebsite', 'companyRegistrationNumber', 'companyVatNumber', 'companyAge', 'companyRegAdd1', 'companyRegAdd2', 'companyRegCity', 'companyRegState', 'companyRegZip', 'companyInvAdd1', 'companyInvAdd2', 'companyInvCity', 'companyInvState', 'companyInvZip', 'companyAccountPerName', 'companyAccountPerEmail', 'companyAccountPerMobile', 'companyAccountPerDepartment', 'companyturnover', 'companyBranchesCount', 'companyBankName', 'companyBankAddress', 'companyBankPostCode', 'companyBankAccount', 'companyContactNumber', 'companySortCode', 'user_status', 'regisdate', 'cal_show', 'created_at', 'updated_at', 'IPAddress');

        $query = $query->where('cust_type', '=', 1);
        $query = $query->where('companyName', '!=', '');
        $query = $query->where('cal_show', '=', 1);

        $reqData = $query->orderBy('companyName', 'ASC')
                ->get();

        $u_id = 0;
        foreach ($reqData as $key => $value) {
            switch ($value->user_status) {
                case 1:
                    $value->user_status = 'pending';
                    break;
                case 2:
                    $value->user_status = 'approve';
                    break;
                case 0:
                    $value->user_status = 'blocked';
                    break;
            }
            $value->firstName = $value->companyName;
            $value->g_id = getGroupName($value->g_id);
            if (isset($value->customerID) && $value->customerID != '') {
                $u_id = getUid($value->customerID);
                $value->updated_at = CheckUserOrder($u_id);
            }
        }


        return $reqData;
    }

    public function headings(): array {
        return [
            "Customer ID", "Account Code", "Group Code", "First Name", "Last Name", "Add1", "Add2", "City", "State", "ZIP", "Telephone", "Fax", "Email", "Role", "Company Name", "Website", "Reg Number", "VAT no", "Company age", "Reg Add1", "Reg Add2", "REg city", "Reg State", "Reg ZIP", "Invoice Add1", "Invoice Add2", "Invoice city", "Invoice state", "Invoice ZIP", "Account Person name", "Account email", "Account mobile", "Account department name", "Turnover", "Branches", "Bank name", "Bank address", "Bank post code", "Bank Account no", "Contact number", "Sort code", "User status", "Registration Date", 'Calendar Show', "Created at", "Order", "IP Address"
        ];
    }

}

?>