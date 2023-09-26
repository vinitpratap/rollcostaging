<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include '../class/config.php';
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!IS_AJAX) {die('Access not allowed');}

$prodid = test_input($_POST["prodid"]);
$cartid = test_input($_POST["cartid"]);
$cartquant = test_input($_POST["cartquant"]);


    $checkCartSql = "SELECT cart_id FROM rollco_ms_cart WHERE prod_id='" . $prodid . "' AND cart_id='" . $cartid . "' ";

    $numsrow = $sq->numsrow($checkCartSql);

    if ($numsrow > 0) {
		if($cartquant>0){
			$updateSql = "UPDATE rollco_ms_cart SET prod_qty='".$cartquant."' WHERE  cart_id='" . $cartid . "' AND prod_id='" . $prodid . "'";
			$status = $sq->query($updateSql);
		}
       
    } else {
       $status = 0;
    }



echo json_encode(array('status' => $status));

