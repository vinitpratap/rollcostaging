<?php

include 'class/config.php';
include 'send_maill.php';

//debug($_FILES);die;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (check_input($_GET['token']) == true) {

    $id = trim(my_simple_crypt($_GET['token'], 'd'));


    $checksql1 = "select u_id,companyName,com_emailAddress,com_Telephone,pl_password FROM rollco_ms_users WHERE u_id='" . $id . "' LIMIT 1";
    $numsrow1 = $sq->numsrow($checksql1);

    if ($numsrow1 > 0) {

        $udata = $sq->fearr($checksql1);

        $updateSql = "UPDATE rollco_ms_users SET c_verified = 1 WHERE u_id='" . $id . "' LIMIT 1";
        $sq->query($updateSql);

        $fname = $udata['companyName'];
        ob_start();
        require("mailer/welcome.php");
//        require("mailer/email_verification.php");

        $body = ob_get_contents();
        ob_end_clean();

        $subject = "Welcome to Rolling Components";
        $message = $body;
        $TO_EMAIL = $emailid;


        $subject1 = 'Rollco - User Registration';
        $message1 = "<br><br>
Company Name: " . $udata['companyName'] . "<br>
Email: " . $udata['com_emailAddress'] . "<br>
Password: " . $udata['pl_password'] . "<br>
Date: " . $getsysdate . "<br>
IP: " . $_SERVER['REMOTE_ADDR'] . "<br>
";

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

            $to1 = new SendGrid\Email(null, 'info@rollingcomponents.com');
            $content1 = new SendGrid\Content("text/html", $message1);
            $mail1 = new SendGrid\Mail($fromEml, $subject1, $to1, $content1);
            $sg1 = new \SendGrid($API_KEY);
            $response1 = $sg->client->mail()->send()->post($mail1);
            if ($response1->statusCode() == 202) {
                
            } else {
                echo 'issue with sending email on ' . $TO_EMAIL;
            }

            // mail($_POST['com_emailAddress'], $subject, $message, $usr_headers);
            // mail('info@rollingcomponents.com', $subject1, $message1, $usr_headers);
        } else {
            echo $udata['com_emailAddress'], $subject, $message, $usr_headers;
            echo 'ajit@studiobrahma.in', $subject1, $message1, $usr_headers;
            die;
        }
        header('Location: ' . $siteurl . '/thankyoureg.php');
        exit;
    } else {
        header('Location: ' . $siteurl . '/create-account.php?success=2');
        exit;
    }
} else {
    header('Location: ' . $siteurl . '/create-account.php?success=2');
    exit;
}
?>

