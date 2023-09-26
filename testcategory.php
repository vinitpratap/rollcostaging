
<?php 

include("class/config.php"); 
$sql = "UPDATE  rollco_ms_mcat SET mcat_status=0 WHERE mcat_id=8";

$data = $sq->query($sql);

?>
