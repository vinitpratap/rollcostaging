<?php
include 'class/config.php';
include 'send_maill.php';
$temp_upload_path = $cpath . "upload/companydoc/";


//debug($_FILES);die;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$refr = $_SERVER['HTTP_REFERER'];

if (strstr($refr, $siteurl)) {
    if (check_input($_POST['chooseOption']) == true && check_input($_POST['companyName']) == true && check_input($_POST['companyRegAdd1']) == true && check_input($_POST['companyRegZip']) == true && filter_var($_POST['com_emailAddress'],
                    FILTER_VALIDATE_EMAIL) && trim($_POST['password']) == trim($_POST['confirmPassword']) && check_input($_POST['termsConditions']) == true) {

        $emailid = trim($_POST['com_emailAddress']);
        $compzip = trim($_POST['companyRegZip']);
        $compname = trim($_POST['companyName']);
        $companyRegAdd1 = trim($_POST['companyRegAdd1']);

        $emailid = test_input($emailid);
        $compzip = test_input($compzip);
        $compname = test_input($compname);
        $companyRegAdd1 = test_input($companyRegAdd1);

        if (str_word_count($companyRegAdd1) == 1) {
            header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=0');
            exit;
        }
        $checksql1 = "select u_id FROM rollco_ms_users WHERE com_emailAddress='" . $emailid . "' LIMIT 1";
        $numsrow1 = $sq->numsrow($checksql1);

        if ($numsrow > 0) {

            header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=4');
            exit;
        }



        $checksql = "select u_id FROM rollco_ms_users WHERE companyName='" . $compname . "' AND companyRegZip='" . $compzip . "'   LIMIT 1";
        $numsrow = $sq->numsrow($checksql);

        if ($numsrow > 0) {

            header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=4');
            exit;
        } else {

            $companyAttachedDoc = '';
            if (isset($_FILES['companyAttachedDoc']['name']) && $_FILES['companyAttachedDoc']['name'] != '') {
                list($file, $u_error) = upload('companyAttachedDoc', $temp_upload_path, 'pdf');
                if (strlen($u_error) > 0) {
                    ?>	
                    <script>location.href = '<?php echo $_SERVER['HTTP_REFERER'] . '?success=3'; ?>';</script>
                    <?php
                    exit;
                } else {
                    $companyAttachedDoc = $file;
                }
            }
            $role = '';
            $other = '';
            $ofr_flag = 0;
            $email_flag = 0;
            if (test_input($_POST['role']) != 'check_other') {
                $role = $_POST['role'];
            } else {
                $role = 'Other';
                $other = test_input($_POST['other']);
            }
            if (test_input($_POST['participatingCarriers']) == 'on') {
                $email_flag = 1;
            }

            if (test_input($_POST['offerRollco']) == 'on') {
                $ofr_flag = 1;
            }

            $dataToInsert = array('chooseOption' => test_input($_POST['chooseOption']),
                'firstName' => test_input($_POST['firstName']),
                'lastName' => test_input($_POST['lastName']),
                'streetAddress1' => test_input($_POST['companyRegAdd1']),
                'streetAddress2' => test_input($_POST['companyRegAdd2']),
                'com_city' => test_input($_POST['companyRegCity']),
                'com_state' => test_input($_POST['companyRegState']),
                'com_zipCode' => test_input($_POST['companyRegZip']),
                'com_Telephone' => test_input($_POST['com_Telephone']),
                'com_Fax' => test_input($_POST['com_Fax']),
                'com_emailAddress' => test_input($_POST['com_emailAddress']),
                'password' => md5(test_input($_POST['password'])),
                'pl_password' => (test_input($_POST['password'])),
                'companyName' => test_input($_POST['companyName']),
                'companyWebsite' => test_input($_POST['companyWebsite']),
                'companyRegistrationNumber' => test_input($_POST['companyRegistrationNumber']),
                'companyVatNumber' => test_input($_POST['companyVatNumber']),
                'companyAge' => test_input($_POST['companyAge']),
                'companyRegAdd1' => test_input($_POST['companyRegAdd1']),
                'companyRegAdd2' => test_input($_POST['companyRegAdd2']),
                'companyRegCity' => test_input($_POST['companyRegCity']),
                'companyRegState' => test_input($_POST['companyRegState']),
                'companyRegZip' => test_input($_POST['companyRegZip']),
                'companyInvAdd1' => test_input($_POST['companyInvAdd1']),
                'companyInvAdd2' => test_input($_POST['companyInvAdd2']),
                'companyInvCity' => test_input($_POST['companyInvCity']),
                'companyInvState' => test_input($_POST['companyInvState']),
                'companyInvZip' => test_input($_POST['companyInvZip']),
                'companyAccountPerName' => test_input($_POST['companyAccountPerName']),
                'companyAccountPerEmail' => test_input($_POST['companyAccountPerEmail']),
                'companyAccountPerMobile' => test_input($_POST['companyAccountPerMobile']),
                'companyAccountPerDepartment' => test_input($_POST['companyAccountPerDepartment']),
                'companyturnover' => test_input($_POST['companyturnover']),
                'companyBranches' => test_input($_POST['companyBranches']),
                'companyBranchesCount' => test_input($_POST['companyBranchesCount']),
                'companyBankName' => test_input($_POST['companyBankName']),
                'companyBankAddress' => test_input($_POST['companyBankAddress']),
                'companyBankPostCode' => test_input($_POST['companyBankPostCode']),
                'companyBankAccount' => test_input($_POST['companyBankAccount']),
                'companyContactNumber' => test_input($_POST['companyContactNumber']),
                'companySortCode' => test_input($_POST['companySortCode']),
                'companyAttachedDoc' => test_input($companyAttachedDoc),
                'role' => $role,
                'other' => $other,
                'email_flag' => $email_flag,
                'ofr_flag' => $ofr_flag,
                'IPAddress' => $_SERVER['REMOTE_ADDR'],
            );
            $insertsql = "insert into rollco_ms_users SET ";
            foreach ($dataToInsert as $key => $value) {
                $insertsql .= "" . $key . "='" . $value . "',";
            }
            $insertsql = rtrim($insertsql, ',');

            $result = $sq->query($insertsql);

            $insertid = $sq->insertid();

            if (count($_POST['companyPartnerName']) > 0) {
                for ($i = 0; $i < count($_POST['companyPartnerName']); $i++) {
                    $dataInsertPartner = array('companyPartnerName' => $_POST['companyPartnerName'][$i],
                        'companyPartnerAdd1' => $_POST['companyPartnerAdd1'][$i],
                        'companyPartnerAdd2' => $_POST['companyPartnerAdd2'][$i],
                        'companyPartnerCity' => $_POST['companyPartnerCity'][$i],
                        'companyPartnerState' => $_POST['companyPartnerState'][$i],
                        'companyPartnerZip' => $_POST['companyPartnerZip'][$i],
                        'comp_id' => $insertid,
                    );
                }
                $insertsql = "insert into rollco_ms_com_part SET ";
                foreach ($dataInsertPartner as $key => $value) {
                    $insertsql .= "" . $key . "='" . $value . "',";
                }
                $insertsql = rtrim($insertsql, ',');
                $sq->query($insertsql);
            }
            if (count($_POST['companyPrintName']) > 0) {
                for ($i = 0; $i < count($_POST['companyPrintName']); $i++) {
                    $dataInsertPrint = array('companyPrintName' => $_POST['companyPrintName'][$i],
                        'companyPosition' => $_POST['companyPosition'][$i],
                        'companyDate' => date('Y-m-d H:i:s',
                                strtotime($_POST['companyDate'][$i])),
                        'RollingRepresentative' => $_POST['RollingRepresentative'][$i],
                        'comp_id' => $insertid,
                    );
                    $insertsql = "insert into rollco_ms_position SET ";
                    foreach ($dataInsertPrint as $key => $value) {
                        $insertsql .= "" . $key . "='" . $value . "',";
                    }
                    $insertsql = rtrim($insertsql, ',');
                    $sq->query($insertsql);
                }
            }
            if ($insertid > 0) {

                /*---------------code for send info to new agency-----------------*/
                $curl = curl_init();
  curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://docs.rollingcomponents.com/api/newagency',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "name":"' . $compname . '",
    "clientid":"' . $insertid . '",
    "emailid":"' . $emailid . '",
    "status":"0"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));
$curl_response = curl_exec($curl);
curl_close($curl);

$response_arr = json_decode($curl_response, true);
$na_authentication_key = $response_arr['authentication key'];
$na_agency_id = $response_arr['agency id'];
$na_status = $response_arr['status'];

if (isset($response_arr['agency id']) && $response_arr['agency id'] > 0) {
    if (isset($na_agency_id) && $na_agency_id > 0 && $na_authentication_key != '') {
        /*------------------store new agency data in our database-----------------------*/
        $upd_sql = "UPDATE rollco_ms_users SET na_authentication_key = '" . $na_authentication_key . "', na_agency_id = '" . $na_agency_id . "' WHERE u_id = '" . $insertid . "'";
        $sq->query($upd_sql);
        /*------------------store new agency data in our database end-------------------*/
    /* comment on 250523
        $curl = curl_init();
      curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://docs.rollingcomponents.com/public/api/newregister',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
            "name":"' . $compname . '",
            "clientid":"' . $insertid . '",
            "emailid":"' . $emailid . '",
            "authentication_key":"' . $na_authentication_key . '",
            "is_admin":"0",
            "status":"0"
    }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ));
    
    $curl_response = curl_exec($curl);
    curl_close($curl);*/
    }

}



                /*---------------code for send info to new agency end-------------*/

                //$to = $_POST['com_emailAddress'];
                $fname = $compname;
                $token = my_simple_crypt($insertid, 'e');
                $vlink = $siteurl . 'verify_account.php?token=' . $token;

                ob_start();
//            require("mailer/welcome.php");
                require("mailer/email_verification.php");

                $body = ob_get_contents();
                ob_end_clean();

                $subject = "Welcome to Rolling Components";
                $message = $body;
                $TO_EMAIL = $emailid;


//            $subject1 = 'Rollco - User Registration';
//            $message1 = "<br><br>
//Company Name: " . $_POST['companyName'] . "<br>
//Email: " . $_POST['com_emailAddress'] . "<br>
//Phone: " . $_POST['com_Telephone'] . "<br>
//Password: " . $_POST['password'] . "<br>
//Date: " . $getsysdate . "<br>
//IP: " . $_SERVER['REMOTE_ADDR'] . "<br>
//";
// message
                if ($_SERVER['HTTP_HOST'] != 'localhost') {

                    $to = new SendGrid\Email(null, $TO_EMAIL);
                    $content = new SendGrid\Content("text/html", $message);
                    $mail = new SendGrid\Mail($fromEml, $subject, $to, $content);
                    $sg = new \SendGrid($API_KEY);
                    $response = $sg->client->mail()->send()->post($mail);
                    if ($response->statusCode() == 202) {
                        
                    } else {
                        echo 'issue with sending email on ' . $TO_EMAIL;
                    }
//
//                $to1 = new SendGrid\Email(null, 'info@rollingcomponents.com');
//                $content1 = new SendGrid\Content("text/html", $message1);
//                $mail1 = new SendGrid\Mail($fromEml, $subject1, $to1, $content1);
//                $sg1 = new \SendGrid($API_KEY);
//                $response1 = $sg->client->mail()->send()->post($mail1);
//                if ($response1->statusCode() == 202) {
//                    
//                } else {
//                    echo 'issue with sending email on ' . $TO_EMAIL;
//                }
                    // mail($_POST['com_emailAddress'], $subject, $message, $usr_headers);
                    // mail('info@rollingcomponents.com', $subject1, $message1, $usr_headers);
                } else {
                    echo $_POST['com_emailAddress'], $subject, $message, $usr_headers;
                    die;
                    //echo 'ajit@studiobrahma.in', $subject1, $message1, $usr_headers;  die;
                }
                header('Location: ' . $siteurl . '/thankyoureg.php');
                exit;
            } else {
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=0');
                exit;
            }
        }
    } else {
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=2');
        exit;
    }
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=2');
    exit;
}
?>

