<?php

include '../class/config.php';
require '../send_maill.php';
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!IS_AJAX) {die('Access not allowed');}
$u_id = $_SESSION['u_id'];

$sc_id = $_POST['sc_id'];
$messg = '';
$status = '';
if ($u_id > 0 && $sc_id > 0) {

    /* ------------------inset into log------------------------ */
    $msql = "select sc_id,u_id,full_name,post_code,sc_country,sc_date,sc_stime,sc_etime,sc_remarks,cdate,sec_id,sc_status,temp_id FROM rollco_salescal WHERE sc_id = '" . $sc_id . "' ";
    $mres = $sq->fearr($msql);

    $log_action = 'Delete';
    $AC_Name = $mres['u_id'];
    $fullname = $mres['full_name'];
    $zipCode = $mres['post_code'];
    $city = $mres['sc_country'];
    $app_date = $mres['sc_date'];
    $app_stime = $mres['sc_stime'];
    $app_etime = $mres['sc_etime'];

    $temp_id = $mres['temp_id'];

    $del_res = stripslashes(trim($_POST['del_res']));
    $app_remarks = addslashes($mres['sc_remarks']);
    $log_sql = "insert into rollco_salescallog set 
sc_id='" . $sc_id . "',
u_id='" . $AC_Name . "',
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
reason_delete='" . $del_res . "',
log_action='" . $log_action . "',
log_date='" . $getdatetime . "',
log_secid='" . $_SESSION['u_id'] . "'";
    $sq->query($log_sql);
    /* ------------------inset into log end------------------------ */

    if ($temp_id > 0) {
        $sql1 = "delete from rollco_ms_tmpusers where u_id='" . $temp_id . "'";
        $sq->query($sql1);
    }
    $sql = "delete from rollco_salescal where sc_id='" . $sc_id . "' and sec_id = '" . $u_id . "' and sc_status != 2";
    $numval = $sq->query($sql);
    if ($numval > 0) {
        $com_emailAddress = $_SESSION['com_emailAddress'];

        $usr_subject = 'Rollco: Calendar deleted';
        ob_start();
        require("../mailer/calendar_delete.php");
        $body = ob_get_contents();
        ob_end_clean();
        $user_message = $body;

        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            echo $com_emailAddress, $usr_subject, $user_message, $usr_headers;
            die;
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
            if ($response->statusCode() == 202) {
                
            } else {
                // echo 'issue with sending email on ' . $com_emailAddress;
            }

            // mail($com_emailAddress, $usr_subject, $user_message, $usr_headers);
            //mail('ajit@studiobrahma.in', $usr_subject, $user_message, $usr_headers);
        }
        $status = 1;
        $messg = "Appointment Deleted Successfully";
    } else {
        $status = 2;
        $messg = "Some Error Occour.";
    }
} else {
    $status = 0;
    $messg = "";
}
echo json_encode(array('data' => $messg, 'status' => $status));
