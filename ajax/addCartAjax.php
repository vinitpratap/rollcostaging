<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include '../class/config.php';
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!IS_AJAX) {die('Access not allowed');}

$u_id = test_input($_POST["u_id"]);
$prod_id = test_input($_POST["prod_id"]);
$prod_qty = test_input($_POST["prod_qty"]);
$sp_check = test_input($_POST["sp_check"]);
if ($sp_check) {
    $checkCartSql = "SELECT cart_id FROM rollco_ms_cart WHERE spr_id='" . $prod_id . "' AND u_id='" . $u_id . "' ";

    $numsrow = $sq->numsrow($checkCartSql);

    if ($numsrow > 0) {
        $status = 0;
    } else {
        $cartSql = "INSERT INTO rollco_ms_cart SET spr_id='" . $prod_id . "',u_id='" . $u_id . "',prod_qty='" . $prod_qty . "',u_ip='" . $_SERVER['REMOTE_ADDR'] . "'";

        $status = $sq->query($cartSql);
    }
} else {
    $checkCartSql = "SELECT cart_id FROM rollco_ms_cart WHERE prod_id='" . $prod_id . "' AND u_id='" . $u_id . "' ";

    $numsrow = $sq->numsrow($checkCartSql);

    if ($numsrow > 0) {
        $status = 0;
    } else {
        $cartSql = "INSERT INTO rollco_ms_cart SET prod_id='" . $prod_id . "',u_id='" . $u_id . "',prod_qty='" . $prod_qty . "',u_ip='" . $_SERVER['REMOTE_ADDR'] . "'";

        $status = $sq->query($cartSql);
    }
}


echo json_encode(array('status' => $status));

