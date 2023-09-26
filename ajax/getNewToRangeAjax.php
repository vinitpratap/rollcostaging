<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include '../class/config.php';
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!IS_AJAX) {die('Access not allowed');}
$catid = test_input($_POST["cat_id"]);

$msql1 = "SELECT cat_id,cat_nm FROM rollco_ms_cat where cat_id ='".$catid."' LIMIT 1 ";
$catArr = $sq->fearr($msql1);

$makeArr = array();
$html = '';
if ($catid > 0) {
    $msql = "SELECT prod_part_no,prod_img1 FROM rollco_ms_product where prod_id > 0 AND is_latest = 1 
	AND catid='".$catid."' AND prod_img1 !='' AND prod_img1 IS NOT NULL AND prod_status=1  GROUP BY prod_part_no ORDER BY created_at DESC LIMIT 8 ";
    $numsrow = $sq->numsrow($msql);
    if ($numsrow > 0) {
            $data = $sq->query($msql);
            while ($rs = $sq->fetch($data)) {
                $html .= '<div class="col-lg-3 col-md-3 col-sm-3 col-6 mb-4">';
				$html .= '<a style="color:#000000; !impoortant" href="product-detail.php?rc_num='.$rs['prod_part_no'].'&type=search">';
				$html .= '<div class="border-danger border w-100 text-center">'; 
					if (file_exists($cpath . 'upload/product/' . $rs['prod_img1'])) {
						$html .= '<img src="'. $siteurl .'upload/product/'.$rs['prod_img1'].'" class="img-fluid" alt="'.$rs['prod_part_no'].'">';
					}else{
						$html .= '<img src="'. $siteurl .'upload/no-image.png" class="img-fluid" alt="FOR THE VS BRAND">';
					}
				
				$html .= '</div>';
				$html .= '<div align="center" id="cat_name_ajax">'.$catArr['cat_nm'].'</div>';
				$html .= '<div align="center">'.$rs['prod_part_no'].'</div>';
				$html .= '</a>';
				$html .= '</div>';
        }
        $status = 1;
    } else {
		$html .='<h2 class="text-danger font-weight-normal pb-4 text-center">NO NEW TO RANGE PRODUCT FOUND</h2>';
        $status = 2;
    }
} else {
    $status = 0;
}

echo json_encode(array('data'=>$html,'status'=>$status));

