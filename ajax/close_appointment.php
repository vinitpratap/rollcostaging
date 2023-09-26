<?php
include '../class/config.php';
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!IS_AJAX) {die('Access not allowed');}
$u_id= $_SESSION['u_id'];

$sc_id=$_POST['sc_id'];
$messg='';
$status='';
if ($u_id > 0 && $sc_id>0) {
/*------------------inset into log------------------------*/
$msql = "select sc_id,u_id,full_name,post_code,sc_country,sc_date,sc_stime,sc_etime,sc_remarks,cdate,sec_id,sc_status FROM rollco_salescal WHERE sc_id = '".$sc_id."' ";
$mres=$sq->fearr($msql);
$log_action='Close';
$AC_Name=$mres['u_id'];
$fullname=$mres['full_name'];
$zipCode=$mres['post_code'];
$city=$mres['sc_country'];
$app_date=$mres['sc_date'];
$app_stime=$mres['sc_stime'];
$app_etime=$mres['sc_etime'];
$app_remarks=addslashes($mres['sc_remarks']);
$log_sql="insert into rollco_salescallog set 
sc_id='".$sc_id."',
u_id='".$AC_Name."',
full_name='".$fullname."',
post_code='".$zipCode."',
sc_country='".$city."',
sc_date='".$app_date."',
sc_stime='".$app_stime."',
sc_etime='".$app_etime."',
sc_remarks='". $app_remarks."',
cdate='".$getdatetime."',
ipaddress='".$_SERVER['REMOTE_ADDR']."',
sec_id='".$_SESSION['u_id']."',
sc_status=2,
log_action='".$log_action."',
log_date='".$getdatetime."',
log_secid='".$_SESSION['u_id']."'";
$sq->query($log_sql);
/*------------------inset into log end------------------------*/

$sql="update rollco_salescal set sc_status = 2 where sc_id='".$sc_id."' and sec_id = '".$u_id."' and sc_status != 2";
$numval=$sq->query($sql);
 if ($numval > 0) {
   $status = 1;
   $messg = "Appointment closed successfully";
    }else {
        $status = 2;
        $messg = "Some Error Occour.";
    }
} else {
    $status = 0;
     $messg = "";
}
echo json_encode(array('data'=>$messg,'status'=>$status));
