<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include '../class/config.php';
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!IS_AJAX) {die('Access not allowed');}
$countPro = 0;
if (isset($_POST['prod_id'])) {
    $imageArr = array();
    $imageSql = "SELECT prod_img1,prod_img2,prod_img3,prod_img4,prod_img5,prod_img6,prod_img7,prod_img8 FROM rollco_ms_product WHERE prod_id='" . $_POST['prod_id'] . "' LIMIT 1";
    
     $numsrow = $sq->numsrow($imageSql);

    if ($numsrow > 0) {
        $imageData = $sq->fearr($imageSql);
        $imageArr = array(
            "prod_img1"=>($imageData['prod_img1'] !='' && !is_null($imageData['prod_img1'])) ? $imageData['prod_img1'] : 'no-image.png',
            "prod_img2"=>($imageData['prod_img2'] !='' && !is_null($imageData['prod_img2'])) ? $imageData['prod_img2'] : 'no-image.png',
            "prod_img3"=>($imageData['prod_img3'] !='' && !is_null($imageData['prod_img3'])) ? $imageData['prod_img3'] : 'no-image.png',
            "prod_img4"=>($imageData['prod_img4'] !='' && !is_null($imageData['prod_img4'])) ? $imageData['prod_img4'] : 'no-image.png',
            "prod_img5"=>($imageData['prod_img5'] !='' && !is_null($imageData['prod_img5'])) ? $imageData['prod_img5'] : 'no-image.png',
            "prod_img6"=>($imageData['prod_img6'] !='' && !is_null($imageData['prod_img6'])) ? $imageData['prod_img6'] : 'no-image.png',
            "prod_img7"=>($imageData['prod_img7'] !='' && !is_null($imageData['prod_img7'])) ? $imageData['prod_img7'] : 'no-image.png',
            "prod_img8"=>($imageData['prod_img8'] !='' && !is_null($imageData['prod_img8'])) ? $imageData['prod_img8'] : 'no-image.png',
            
        );
        
        echo json_encode(array("success" => 1, "imageArr"=>$imageArr));exit;
    }
    
}