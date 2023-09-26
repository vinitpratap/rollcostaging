<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require 'send_maill.php';

$usr_subject = "Test Email";
$com_emailAddress = "sanjit.bhardwaj@studiobrahma.in";
$user_message = "hello , this is test email";

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    echo $com_emailAddress, $usr_subject, $user_message, $usr_headers;
    die;
} else {
    $to = new SendGrid\Email(null, $com_emailAddress);
    $content = new SendGrid\Content("text/html", $user_message);
    $mail = new SendGrid\Mail($fromEml, $usr_subject, $to, $content);
    //for multiple email sending   bev@rollingcomponents.com & sue@rollingcomponents.com
    $email2 = new SendGrid\Email(null, "ajit@studiobrahma.in");
    $mail->personalization[0]->addBcc($email2);
    $email3 = new SendGrid\Email(null, "anand@studiobrahma.in");
    $mail->personalization[0]->addBcc($email3);
    $email4 = new SendGrid\Email(null, "vinit@studiobrahma.in");
    $mail->personalization[0]->addBcc($email4);
//for multiple email sending
    $sg = new \SendGrid($API_KEY);
    $response = $sg->client->mail()->send()->post($mail);
    if ($response->statusCode() == 202) {
        echo "Mail successfully sent.";
    } else {
        echo 'issue with sending email on ' . $com_emailAddress;
    }

    // mail($com_emailAddress, $usr_subject, $user_message, $usr_headers);
    //mail('ajit@studiobrahma.in', $usr_subject, $user_message, $usr_headers);
}