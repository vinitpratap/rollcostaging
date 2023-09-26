<?php
include '../class/config.php';
$u_id= $_POST['session_id'];
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!IS_AJAX) {die('Access not allowed');}
$itemid=$_POST['itemid'];
$messg='';
$status='';
$makeArr = array();
if ($u_id > 0 && $itemid!='') {
$sql="delete from rollco_ms_cart where cart_id=".$itemid." AND u_id='".$u_id."'";
$numval=$sq->query($sql);
 if ($numval > 0) {
   $status = 1;
   $messg = "Item Deleted Successfully";
    }else {
        $status = 2;
        $messg = "Some Error Occour.";
    }
} else {
    $status = 0;
     $messg = "";
}
echo json_encode(array('data'=>$messg,'status'=>$status));
