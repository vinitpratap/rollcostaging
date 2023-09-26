<?php 
set_time_limit(0);
include("class/config.php"); 

$checkSql = "SELECT prod_img1,prod_img2,prod_img3,prod_img4,prod_img5,prod_img6,prod_img7,prod_img8,prod_nm FROM rollco_ms_product 
 WHERE image_check=0 GROUP BY prod_nm ";
	
$checkNum = $sq->numsrow($checkSql);
$data1 = "";
$cnt = 0;
if($checkNum > 0){
	$data = $sq->query($checkSql);
	while ($rs = $sq->fetch($data)) {
		if($rs['prod_img1'] !='' && $rs['prod_img2'] !=''){
			$updateSql = "UPDATE rollco_ms_product SET ";
			for($i=1;$i<=8;$i++){
				$updateSql .="prod_img".$i."='".$rs['prod_img'.$i]."' ,";
			}
			//$updateSql  = ltrim(',',$updateSql);
			$updateSql .= " image_check=1 WHERE prod_nm='".$rs['prod_nm']."' ";
			$status = $sq->query($updateSql);
			$cnt++;
		}
	}
}
if($cnt>0){
	echo $cnt ." Product Images Updated"; 
}else{
	echo "NO  Product Images Updated";
}

?>