<?php

include '../class/config.php';
include '../class/commonFunc.php';
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!IS_AJAX) {die('Access not allowed');}
$u_id = test_input($_POST['user_id']);
$temp_id = test_input($_POST['temp_id']);

$messg = '';
$AcCode = '';
$status = '';
if ($u_id > 0 || $temp_id > 0) {
    if($u_id>0){
        $AcCode=getCustActid($u_id);
    }
    else if($temp_id>0){
        $tm_sql="select customerID from rollco_ms_tmpusers where u_id = '".$temp_id."'";
        $tm_res=$sq->fearr($tm_sql);
        if(isset($tm_res['customerID'])) $AcCode=$tm_res['customerID'];        
    }
    /* ------------------inset into log------------------------ */
    $ss_id=0;
    $msql = "select sa_id FROM rollco_ms_sales_appointment WHERE AcCode = '" . $AcCode . "' ";
    $mres = $sq->fearr($msql);
    
    if(isset($mres) && count($mres) > 0){
        $status = 1;
        $messg = '';
    }else{
        $status = 0;
        $messg = 'Please fill the action points first before closing appointment';
    }
    
//    if($mres[''])
}
echo json_encode(array('data' => $messg, 'status' => $status));
