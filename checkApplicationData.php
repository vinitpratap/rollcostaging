<?php 
set_time_limit(0);
include("class/config.php"); 

$checkSql = "SELECT  part_no FROM rollco_ms_application WHERE part_no != '' GROUP BY part_no  ";
	
$checkNum = $sq->numsrow($checkSql);
$data1 = "";
$cnt = 0;
if($checkNum > 0){
	$data = $sq->query($checkSql);
	while ($rs = $sq->fetch($data)) {
		$updateSql = "UPDATE rollco_ms_product SET appl_avl = 1  WHERE prod_nm  = '".$rs['part_no']."'";
		$sq->query($updateSql);
		$cnt++;
	}
	
}

if($cnt>0){
	echo $cnt ." Products Updated"; 
}else{
	echo "NO  Product Updated";
}

?>