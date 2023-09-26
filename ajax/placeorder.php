<?php

include '../class/config.php';
require '../send_maill.php';
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!IS_AJAX) {die('Access not allowed');}
$messg = '';
$status = '';

function generatenumber($digits = 10) {
    $i = 0; //counter
    $numb = ""; //our default pin is blank.
    while ($i < $digits) {
        //generate a random number between 0 and 9.
        $numb .= mt_rand(0, 9);
        $i++;
    }
    return $numb;
}

$u_id = $_SESSION['u_id'];

if (count($_POST['itemcode']) > 0) {
    for ($i = 0; $i < count($_POST['prd_price']); $i++) {
        $tot_price[] = $_POST['prod_qty'][$i] * $_POST['prd_price'][$i];
    }
    $tot_price;
    $allprice = array_sum($tot_price);
    $allQty = array_sum($_POST['prod_qty']);
    $pricesign = $_POST['gr_currency'];
    $addr_id = $_POST['optradio'];
    $orderno = generatenumber();
    $order_instruction = $_POST['order_instruction'];
    $orderSql = "INSERT INTO rollco_ms_order SET order_no='" . $orderno . "',user_id='" . $u_id . "',
		totalprice='" . $allprice . "',Qty='" . $allQty . "',order_status='0',order_instruction='" . addslashes(trim($order_instruction)) . "',
		price_sign='" . (trim($pricesign)) . "',u_ip='" . $_SERVER['REMOTE_ADDR'] . "',order_date='" . $getdatetime . "',addr_id='" . $addr_id . "'";

    $status = $sq->query($orderSql);

    $insertedid = $sq->insertid();


    if ($insertedid != '') {
        for ($i = 0; $i < count($_POST['itemcode']); $i++) {
            if ($_POST['itemcode'][$i] != '') {
                $dataInsertPartner = array('order_id' => $insertedid,
                    'prod_id' => $_POST['prod_id'][$i],
                    'spr_id' => $_POST['spr_id'][$i],
                    'user_id' => $u_id,
                    'prod_price' => $tot_price[$i],
                    'prod_qty' => $_POST['prod_qty'][$i],
                    'comments' => addslashes(trim($_POST['remarks'][$i])),
                );
                $insertsql = "insert into rollco_ms_order_details SET ";
                foreach ($dataInsertPartner as $key => $value) {
                    $insertsql .= "" . $key . "='" . $value . "',";
                }
                $insertsql = rtrim($insertsql, ',');
                $sq->query($insertsql);
            }
        }

        $checkuser_sql = "SELECT firstName,lastName,com_Telephone,com_emailAddress,streetAddress1,streetAddress2,com_city,com_state,com_zipCode,companyName FROM rollco_ms_users WHERE u_id = '" . $u_id . "' AND user_status = 2";

        $userdata = $sq->fearr($checkuser_sql);
        $firstName = $userdata['companyName'];
//$lastName=$userdata['lastName'];
        $com_Telephone = $userdata['com_Telephone'];
        $com_emailAddress = $userdata['com_emailAddress'];
        if ($addr_id == 0) {
            $streetAddress1 = $userdata['streetAddress1'];
            $streetAddress2 = $userdata['streetAddress2'];
            $com_city = $userdata['com_city'];
            $com_state = $userdata['com_state'];
            $com_zipCode = $userdata['com_zipCode'];
        } else {
            $checkuser_sql2 = "select id,addresstypeother,streetAddress1other,streetAddress2other,com_cityother, com_stateother,com_zipCodeother FROM rollco_ms_other_adrs WHERE user_id='" . $u_id . "' AND  id='" . $addr_id . "' order by id asc";
            $addrdata = $sq->fearr($checkuser_sql2);
            $streetAddress1 = $addrdata['streetAddress1other'];
            $streetAddress2 = $addrdata['streetAddress2other'];
            $com_city = $addrdata['com_cityother'];
            $com_state = $addrdata['com_stateother'];
            $com_zipCode = $addrdata['com_zipCodeother'];
        }

        $orderstatus = 'Processing';

        $orderdetails_sql = "SELECT ord.order_id,ord.order_no,ord.order_status,ord.order_date,ord.totalprice,ord.Qty,ord.Shipped_date,ord.order_instruction FROM  rollco_ms_order as ord  WHERE  ord.user_id = '" . $u_id . "' and ord.order_id='" . $insertedid . "'";

        $orderdata = $sq->fearr($orderdetails_sql);
        $orderdate = $orderdata['order_date'];
        $order_instruction = $orderdata['order_instruction'] != '' ? $orderdata['order_instruction'] : 'None';
        $order_id = $insertedid;

        $usr_subject = 'Rollco: Order confirmation';
        ob_start();
        require("../mailer/order_mailer.php");
        $body = ob_get_contents();
        ob_end_clean();
        $user_message = $body;

        if ($_SERVER['HTTP_HOST'] == 'localhost') {
           // echo $com_emailAddress, $usr_subject, $user_message, $usr_headers;
            //die;
        } else {
            $to1 = new SendGrid\Email(null, 'orderrollco@gmail.com');//
            $content1 = new SendGrid\Content("text/html", $user_message);
            $mail1 = new SendGrid\Mail($fromEml, $usr_subject, $to1, $content1);
            $sg1 = new \SendGrid($API_KEY);
            $response1 = $sg1->client->mail()->send()->post($mail1);
			
         $to2 = new SendGrid\Email(null, 'info@rollingcomponents.com');
            $content2 = new SendGrid\Content("text/html", $user_message);
            $mail2 = new SendGrid\Mail($fromEml, $usr_subject, $to2, $content2);
            $sg2 = new \SendGrid($API_KEY);
            $response2 = $sg2->client->mail()->send()->post($mail2);

            $to = new SendGrid\Email(null, $com_emailAddress);
            $content = new SendGrid\Content("text/html", $user_message);
            $mail = new SendGrid\Mail($fromEml, $usr_subject, $to, $content);
            //for multiple email sending   bev@rollingcomponents.com & sue@rollingcomponents.com
            $email3 = new SendGrid\Email(null, "debbie@rollingcomponents.co.uk");
            $mail->personalization[0]->addBcc($email3);
            $email4 = new SendGrid\Email(null, "bev@rollingcomponents.co.uk");
            $mail->personalization[0]->addBcc($email4);
            $email5 = new SendGrid\Email(null, "sue@rollingcomponents.com");
            $mail->personalization[0]->addBcc($email5);
            $email6 = new SendGrid\Email(null, "info@rollingcomponents.co.uk");
            $mail->personalization[0]->addBcc($email6);
			$email7 = new SendGrid\Email(null, "debbie@rollingcomponents.com");
            $mail->personalization[0]->addBcc($email7);
			  $email8 = new SendGrid\Email(null, "bev@rollingcomponents.com");
            $mail->personalization[0]->addBcc($email8);
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
        for ($i = 0; $i < count($_POST['cart_id']); $i++) {

            $deletetsql = "delete from rollco_ms_cart where cart_id='" . $_POST['cart_id'][$i] . "' ";
            $sq->query($deletetsql);
        }
    }
    $_SESSION['rol_order_no'] = $orderno;
    $status = 1;
    $messg = $sitesurl . "thankyou.php";
} else {
    $status = 2;
    $messg = "Some Error Occour to place your Order.";
}

echo json_encode(array('data' => $messg, 'status' => $status));
