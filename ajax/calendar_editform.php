<?php

include '../class/config.php';
require '../send_maill.php';
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!IS_AJAX) {die('Access not allowed');}
$u_id = $_SESSION['u_id'];
$status = '';
$messg = '';

$ACName = '';
if (isset($_POST['ACName']) && $_POST['ACName'] != '')
    $ACName = addslashes(trim($_POST['ACName']));
$sc_id = '';
if (isset($_POST['sc_id']) && $_POST['sc_id'] > 0)
    $sc_id = trim($_POST['sc_id']);
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


if ($sc_id > 0 && $app_date != '' && $app_stime != '' && $app_etime != '' && $app_etime > $app_stime) {

    $msql = "select sc_id,u_id,full_name,post_code,sc_date,sc_stime,sc_etime,sc_remarks,sc_country FROM rollco_salescal WHERE sc_id = '" . $sc_id . "' and sec_id='" . $_SESSION['u_id'] . "' and sc_status = 1 ";
    $numsrow = $sq->numsrow($msql);
    if ($numsrow > 0) {
        $mres = $sq->fearr($msql);

        $olddate = $mres['sc_date'];
        $oldzip = $mres['post_code'];
        $oldcity = $mres['sc_country'];
        $oldname = $mres['full_name'];
        $oldstime = $mres['sc_stime'];
        $oldetime = $mres['sc_etime'];
        $oldremarks = $mres['sc_remarks'];

        $ins_sql = "update rollco_salescal set 
sc_date='" . $app_date . "',
sc_stime='" . $app_stime . "',
sc_etime='" . $app_etime . "',
sc_remarks='" . $app_remarks . "',
mdate='" . $getdatetime . "'
where sc_id = '" . $sc_id . "' and sec_id='" . $_SESSION['u_id'] . "' and sc_status = 1";
        $sq->query($ins_sql);

        /* ------------------inset into log------------------------ */
        $log_action = 'Update';
        $sc_id = $mres['sc_id'];
        $AC_Name = $mres['u_id'];
        $fullname = $mres['full_name'];
        $zipCode = $mres['post_code'];
        $city = $mres['sc_country'];
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
log_action='" . $log_action . "',
log_date='" . $getdatetime . "',
log_secid='" . $_SESSION['u_id'] . "'";
        $sq->query($log_sql);
        /* ------------------inset into log end------------------------ */


        $com_emailAddress = $_SESSION['com_emailAddress'];

        $usr_subject = 'Rollco: Calendar Update';
        ob_start();
        require("../mailer/calendar_update.php");
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
                //echo 'issue with sending email on ' . $com_emailAddress;
            }

            // mail($com_emailAddress, $usr_subject, $user_message, $usr_headers);
            //mail('ajit@studiobrahma.in', $usr_subject, $user_message, $usr_headers);
        }

        $status = 1;
        $messg = 'Appointment updated successfully.';
    } else {
        $status = 3;
        $messg = 'Appointment has been closed.';
    }
} else {
    $status = 2;
    $messg = 'Data is not propper.';
}
echo json_encode(array('data' => $messg, 'status' => $status));

