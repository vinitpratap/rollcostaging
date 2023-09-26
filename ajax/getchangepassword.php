<?php

include '../class/config.php';
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!IS_AJAX) {die('Access not allowed');}
$oldpassword = test_input($_POST["oldpassword"]);
$password = test_input($_POST["password"]);
$messg = '';
$status = '';
if (isset($oldpassword) && $oldpassword != '') {
    $sql = "select password from rollco_ms_users where u_id='" . $_SESSION["u_id"] . "' and password='" . md5($oldpassword) . "'";
    $nums = $sq->numsrow($sql);
    if ($nums > 0) {
        if ($password != "") {
            $sql = "update rollco_ms_users set password='" . md5($password) . "' where u_id='" . $_SESSION["u_id"] . "'";
            $sq->query($sql);
            $status = 1;
            $messg = "password changed successfully.";
        }
    } else {
        $status = 2;
        $messg = "Entered old password was wrong.";
    }
}
echo json_encode(array('data' => $messg, 'status' => $status));

