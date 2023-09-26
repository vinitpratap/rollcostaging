<?php
include '../class/config.php';
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!IS_AJAX) {die('Access not allowed');}
$messg='';
$status='';

if(isset($_POST['newsletter']) && $_POST['newsletter']!=''){
    
$sql="select email from rollco_ms_newsletter where email='". $_POST['newsletter']."'";
$nums=$sq->numsrow($sql);
if ($nums ==0)
{    
 $newsSql = "INSERT INTO rollco_ms_newsletter SET email='" . $_POST['newsletter'] . "',ip_add='" . $_SERVER['REMOTE_ADDR'] . "'";

$status = $sq->query($newsSql);

$insertedid=$sq->insertid();
if($insertedid>0){
   $status = 1;
$messg="Request Submited successfully."; 
}   else{
     $status = 2;
$messg="Please Add Email id.";
} 
}else{
   $status = 2;
$messg="You have already subscribed with us.";  
}
}else{
     $status = 2;
$messg="Please Add Email id.";
}
echo json_encode(array('data'=>$messg,'status'=>$status));
