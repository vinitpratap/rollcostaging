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
if (isset($_POST['spr_id'])) {
    $imageArr = array();
    $imageSql = "SELECT spare_img1,spare_img2,spare_img3,spare_img4,spare_img5,spare_img6,spare_img7,spare_img8 FROM rollco_ms_spare WHERE spare_id='" . $_POST['spr_id'] . "' LIMIT 1";
    
     $numsrow = $sq->numsrow($imageSql);

    if ($numsrow > 0) {
        $imageData = $sq->fearr($imageSql);
        $imageArr = array(
            "spare_img1"=>($imageData['spare_img1'] !='' && !is_null($imageData['spare_img1'])) ? $imageData['spare_img1'] : 'no-image.png',
            "spare_img2"=>($imageData['spare_img2'] !='' && !is_null($imageData['spare_img2'])) ? $imageData['spare_img2'] : 'no-image.png',
            "spare_img3"=>($imageData['spare_img3'] !='' && !is_null($imageData['spare_img3'])) ? $imageData['spare_img3'] : 'no-image.png',
            "spare_img4"=>($imageData['spare_img4'] !='' && !is_null($imageData['spare_img4'])) ? $imageData['spare_img4'] : 'no-image.png',
            "spare_img5"=>($imageData['spare_img5'] !='' && !is_null($imageData['spare_img5'])) ? $imageData['spare_img5'] : 'no-image.png',
            "spare_img6"=>($imageData['spare_img6'] !='' && !is_null($imageData['spare_img6'])) ? $imageData['spare_img6'] : 'no-image.png',
            "spare_img7"=>($imageData['spare_img7'] !='' && !is_null($imageData['spare_img7'])) ? $imageData['spare_img7'] : 'no-image.png',
            "spare_img8"=>($imageData['spare_img8'] !='' && !is_null($imageData['spare_img8'])) ? $imageData['spare_img8'] : 'no-image.png',
            
        );

        echo json_encode(array("success" => 1, "imageArr"=>$imageArr));exit;
    }
    
}