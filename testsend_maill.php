<?php 
require 'smtp/vendor/autoload.php';
$FROM_EMAIL = 'info@rollingcomponents.com';
$API_KEY='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';//removed old one on 10thmarchSG.U1_ivg9QT-mAQsj1B5awNA.vcehWuL1vdd9KWzlYNdAWKIVzFhLbB9mb-G88GmRMXA
$fromEml = new SendGrid\Email(null, $FROM_EMAIL);
$subject = "Testing rollco email";
$htmlContent = 'Welcome to Rollco';
$TO_EMAIL = 'ajit@studiobrahma.in';
    $to = new SendGrid\Email(null,$TO_EMAIL);
    $content = new SendGrid\Content("text/html",$htmlContent);
    $mail = new SendGrid\Mail($fromEml, $subject, $to, $content);
//for multiple email sending
//$email2 = new SendGrid\Email(null, "new email ids.");
//$mail->personalization[0]->addTo($email2);
//for multiple email sending
		
    $sg = new \SendGrid($API_KEY);
    $response = $sg->client->mail()->send()->post($mail);
	
	print_r($response);
    if ($response->statusCode() == 202) {
    } else {
     echo 'issue with sending email on '.$TO_EMAIL;
    }
	
?>