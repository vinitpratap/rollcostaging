<?php
include("class/config.php");
$_SESSION['mstart'] = time();

$DelCnt = 0;
$userArr = ['a1motorspares@hotmail.co.uk','karendunlop34@yahoo.co.uk'];


for($i=0;$i<count($userArr);$i++){
    $checkUserSql = "DELETE FROM rollco_ms_users WHERE com_emailAddress='".$userArr[$i]."' and cust_type = 1";
    $sq->query($checkUserSql);
    $DelCnt++;
}

echo $DelCnt. " records deleted";


