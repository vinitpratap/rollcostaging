<?php
include '../class/config.php';
$AC_Name = test_input($_POST["AC_Name"]);
$messg='';
$status='';
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!IS_AJAX) {die('Access not allowed');}
if(isset($AC_Name) && $AC_Name>0){  
$sql="select u_id,firstName,lastName,com_city,com_state,com_zipCode from rollco_ms_users where cust_type = 1  and companyName !='' and u_id = '".$AC_Name."'";
$nums=$sq->numsrow($sql);
if ($nums > 0)
{
$res=$sq->fearr($sql);

$fullname=trim($res['firstName'].' '.$res['lastName']);
$city=trim($res['com_city']);
$state=trim($res['com_state']);
$zipCode=trim($res['com_zipCode']);
if(trim($res['com_zipCode'])=='') {
$zipCode=trim($res['com_city']);
$city=trim($res['com_state']);
}
    
$status = 1;
}
else {
$status = 2;
}
}
echo json_encode(array('fullname'=>$fullname,'zipCode'=>$zipCode,'city'=>$city,'status'=>$status));

