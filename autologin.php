<?php
include 'class/config.php';

if(isset( $_SESSION['u_id']) &&  $_SESSION['u_id'] !=''){
    header("Location: index.php");
}
$err = 0;
$emailErr = $pwdErr = "";
$nrmlErr = "";
$email = $pwd = '';
if (isset($_GET['email']) && $_GET['email'] != '' && isset($_GET['token']) && $_GET['token'] != '') {
   
   $token = 'rollinglogin';
   
   $tokenfromadmin = base64_decode(trim($_GET['token']));
   $email = $_GET['email'];
   
   
    if ($tokenfromadmin == $token) {
        $check_sql = "SELECT u_id,com_emailAddress,firstName,lastName,com_Telephone,g_id,cust_type,report_access,customerID FROM rollco_ms_users WHERE com_emailAddress = '" . $email . "'  AND user_status = 2 LIMIT 1";
        $numsrow = $sq->numsrow($check_sql);
        if ($numsrow > 0) {
            $userdata = $sq->fearr($check_sql);
            $_SESSION['u_id'] = $userdata['u_id'];
            $_SESSION['com_emailAddress'] = $userdata['com_emailAddress'];
            $_SESSION['firstName'] = $userdata['firstName'];
            $_SESSION['lastName'] = $userdata['lastName'];
            $_SESSION['com_Telephone'] = $userdata['com_Telephone']; 
            $_SESSION['g_id'] = $userdata['g_id'];
            $_SESSION['cust_type'] = $userdata['cust_type'];
            $_SESSION['report_access'] = $userdata['report_access'];
            $_SESSION['customerID'] = $userdata['customerID'];
            echo "<script>window.location='index.php';</script>";
        } else {
            $check_sql = "SELECT u_id,com_emailAddress,firstName,lastName,com_Telephone FROM rollco_ms_users WHERE com_emailAddress = '" . $email . "'  AND user_status = 0 LIMIT 1";
            $numsrow = $sq->numsrow($check_sql);
            if ($numsrow > 0) {
                $nrmlErr = "Your account is in verification...Please wait";
            } else {
                $nrmlErr = "The username or password you entered is incorrect";
            }
        }
    }else{
	echo "Email/token not matched";die;
}
}else{
	echo "Email/token not matched";die;
}
?>

