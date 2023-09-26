<?php

include '../class/config.php';
require '../send_maill.php';
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if (!IS_AJAX) {
    die('Access not allowed');
}
$u_id = $_SESSION['u_id'];
$status = '';
$messg = '';

//echo "<pre>";print_r($_POST);die;
/*
  AC_Name	820
  app_date	2020-02-13
  app_etime	18:00
  app_remarks	test+d
  app_stime	17:50
  county	City
  Post_Code	C101
 * 
 * 
  Array ( [AC_Name] => 820 [Post_Code] => C101 [county] => City [app_date] => 2020-02-13 [app_stime] => 17:50 [app_etime] => 18:00 [app_remarks] => test d )
 * 
 * 
 *  */

$temp_id = 0;
$AC_Name = '';
if (isset($_POST['AC_Name']) && $_POST['AC_Name'] != '')
    $AC_Name = addslashes(trim($_POST['AC_Name']));
$AC_Name_new = '';
if (isset($_POST['AC_Name_new']) && $_POST['AC_Name_new'] != '')
    $AC_Name_new = addslashes(trim($_POST['AC_Name_new']));
$Post_Code = '';
if (isset($_POST['Post_Code']) && $_POST['Post_Code'] != '')
    $Post_Code = addslashes(trim($_POST['Post_Code']));
$county = '';
if (isset($_POST['county']) && $_POST['county'] != '')
    $county = addslashes(trim($_POST['county']));
$app_date = '';
if (isset($_POST['app_date']) && $_POST['app_date'] != '')
    $app_date = trim($_POST['app_date']);
$app_stime = '';
if (isset($_POST['app_stime']) && $_POST['app_stime'] != '')
    $app_stime = trim($_POST['app_stime']);
$app_etime = '';
if (isset($_POST['app_etime']) && $_POST['app_etime'] != '')
    $app_etime = trim($_POST['app_etime']);
$app_remarks = '';
if (isset($_POST['app_remarks']) && $_POST['app_remarks'] != '')
    $app_remarks = addslashes(trim($_POST['app_remarks']));


if ($AC_Name != '' && $app_date != '' && $app_stime != '' && $app_etime != '' && $app_etime > $app_stime) {

    $msql = "select sc_id FROM rollco_salescal WHERE u_id = '" . $AC_Name . "' and full_name = '" . $AC_Name_new . "' and sc_date = '" . $app_date . "' and  sc_stime='" . $app_stime . "' and sec_id='" . $_SESSION['u_id'] . "'";
    $numsrow = $sq->numsrow($msql);
    if ($numsrow == 0) {

        if (strtotime($app_date) >= strtotime($getsysdate)) {
            
        } else {
            $status = 2;
            $messg = 'Please enter the correct date.';
        }
        if ($AC_Name === 'new') {
            $AC_Name = 0;
            $fullname = trim($AC_Name_new);
            $zipCode = trim($Post_Code);
            $city = trim($county);

            $name_arr = explode(' ', $fullname, 2);
            $fname = $name_arr[0];
            $lname = '';
            if (isset($name_arr[1]))
                $lname = $name_arr[1];

//$uc_sql="select u_id from rollco_ms_users where com_zipCode = '".$zipCode."' and 
//( firstName = '".$fullname."' or lastName = '".$fullname."' or concat(concat(`firstName`,' ',`lastName`)) = '".$fullname."' )";

            $uc_sql = "select u_id from rollco_ms_users where com_zipCode = '" . $zipCode . "' and companyName='" . $fullname . "'";

            $uc_num = $sq->numsrow($uc_sql);
            if ($uc_num > 0) {
                $status = 4;
                $messg = 'Company already exists. Please select Company first.';
                echo json_encode(array('data' => $messg, 'status' => $status));
                exit;
            }

            $ins_sql = "insert into rollco_ms_tmpusers set 
firstName='" . $fullname . "',
com_zipCode='" . $zipCode . "',
com_city='" . $city . "',
IPAddress='" . $_SERVER['REMOTE_ADDR'] . "',
created_at='" . $getdatetime . "'";
            $sq->query($ins_sql);
            $temp_id = $sq->insertid();
            $tmp_customerID = 'Temp-' . $temp_id;
            $upd_sql = "update rollco_ms_tmpusers set customerID = '" . $tmp_customerID . "' where u_id = '" . $temp_id . "'";
            $sq->query($upd_sql);
        } else {
            $sql = "select u_id,firstName,lastName,com_city,com_state,com_zipCode,companyName from rollco_ms_users where cust_type = 1 and (user_status = 2 or user_status=4 or user_status=0) and companyName!='' and u_id = '" . $AC_Name . "'";
            $res = $sq->fearr($sql);

            $fullname = trim($res['companyName']);
            $city = trim($res['com_city']);
            $state = trim($res['com_state']);
            $zipCode = trim($res['com_zipCode']);
            if (trim($res['com_zipCode']) == '') {
                $zipCode = trim($res['com_city']);
                $city = trim($res['com_state']);
            }
        }

        if ($temp_id > 0 || $AC_Name > 0) {
            $ins_sql = "insert into rollco_salescal set 
u_id='" . $AC_Name . "',
temp_id='" . $temp_id . "',
full_name='" . $fullname . "',
post_code='" . $zipCode . "',
sc_country='" . $city . "',
sc_date='" . $app_date . "',
sc_stime='" . $app_stime . "',
sc_etime='" . $app_etime . "',
sc_remarks='" . $app_remarks . "',
cdate='" . $getdatetime . "',
ipaddress='" . $_SERVER['REMOTE_ADDR'] . "',
sec_id='" . $_SESSION['u_id'] . "',
sc_status=1";
            $sq->query($ins_sql);
            $insert_id = $sq->insertid();
        } else {
            $status = 2;
            $messg = 'Data is not inserted.';
        }

        /* ------------------inset into log------------------------ */

        if ($insert_id > 0) {
            $log_action = 'Insert';
            $sc_id = $insert_id;
            $log_sql = "insert into rollco_salescallog set 
sc_id='" . $sc_id . "',
u_id='" . $AC_Name . "',
temp_id='" . $temp_id . "',
full_name='" . $fullname . "',
post_code='" . $zipCode . "',
sc_country='" . $city . "',
sc_date='" . $app_date . "',
sc_stime='" . $app_stime . "',
sc_etime='" . $app_etime . "',
sc_remarks='" . $app_remarks . "',
cdate='" . $getdatetime . "',
ipaddress='" . $_SERVER['REMOTE_ADDR'] . "',
sec_id='" . $_SESSION['u_id'] . "',
sc_status=1,
log_action='" . $log_action . "',
log_date='" . $getdatetime . "',
log_secid='" . $_SESSION['u_id'] . "'";
            $sq->query($log_sql);
            /* ------------------inset into log end------------------------ */

            $status = 1;
            $messg = '<p> Appointment created successfully. </p><a href="#" class=" btn btn-dark save-tag-calendar">Back</a>
                                        <a href="#" class="btn btn-danger save-tag-appointment">View Appointment</a>';

            $_SESSION['new_apt'] = 1;

            $com_emailAddress = $_SESSION['com_emailAddress'];

            $usr_subject = 'Rollco: Calendar Details';
            ob_start();
            require("../mailer/calendar_create.php");
            $body = ob_get_contents();
            ob_end_clean();
            $user_message = $body;

            if ($_SERVER['HTTP_HOST'] == 'localhost') {
                // echo $com_emailAddress, $usr_subject, $user_message, $usr_headers;die;
            } else {
                $to = new SendGrid\Email(null, 'sales-i@rollingcomponents.com');
                $content = new SendGrid\Content("text/html", $user_message);
                $mail = new SendGrid\Mail($fromEml, $usr_subject, $to, $content);
                //for multiple email sending   bev@rollingcomponents.com & sue@rollingcomponents.com
                $email2 = new SendGrid\Email(null, $com_emailAddress);
                $mail->personalization[0]->addCc($email2);
                /* $email3 = new SendGrid\Email(null, "debbie@rollingcomponents.com");
                  $mail->personalization[0]->addBcc($email3);
                  $email4 = new SendGrid\Email(null, "bev@rollingcomponents.com");
                  $mail->personalization[0]->addBcc($email4);
                  $email5 = new SendGrid\Email(null, "sue@rollingcomponents.com");
                  $mail->personalization[0]->addBcc($email5); */
//for multiple email sending
                $sg = new \SendGrid($API_KEY);
                $response = $sg->client->mail()->send()->post($mail);
                // echo "<pre>";print_r($response);die;
                if ($response->statusCode() == 202) {
                    
                }
//                else {
//                    echo 'issue with sending email on ' . $com_emailAddress;
//                }

                // mail($com_emailAddress, $usr_subject, $user_message, $usr_headers);
                //mail('ajit@studiobrahma.in', $usr_subject, $user_message, $usr_headers);
            }
        } else {
            $status = 2;
            $messg = 'Error occur while creating the booking.';
        }
    } else {
        $status = 3;
        $messg = 'Appointment already exists.';
    }
} else {
    $status = 2;
    $messg = 'Please enter the correct information.';
}
echo json_encode(array('data' => $messg, 'status' => $status));

