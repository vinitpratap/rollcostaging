<?php 
$g_link = false;
function GetMyConnection()
{
if ($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='192.168.1.117')
{
$host="localhost";
$user="root";
$pass="";
$db="rollco_v1";

}
else
{
$sitename='';
#$host="18.212.59.161";
$host="localhost";	
$user="studimky_rolcusr";
$pass="Sbra@#hma";
//$db="studimky_rollcodb";
$db="Rollco_Stag_Sep23_app";
}
global $g_link;
if( $g_link ) return $g_link;
$g_link = new mysqli($host,$user,$pass,$db);
return $g_link;
}
function CleanUpDB()
{
global $g_link;
if( $g_link != false )
mysqli_close($g_link);
$g_link = false;
}
 echo $g_link; 
?>