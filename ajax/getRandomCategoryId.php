<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include '../class/config.php';
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!IS_AJAX) {die('Access not allowed');}
//echo "<pre>";print_r($_POST);die;
$makeArr = array();
    $msql = "SELECT cat_id,cat_nm FROM rollco_ms_cat where cat_status > 0 order by RAND() LIMIT 1 ";
    $numsrow = $sq->numsrow($msql);
    if ($numsrow > 0) {
        if ($numsrow > 0) {
            $data = $sq->query($msql);
            while ($rs = $sq->fetch($data)) {
                $makeArr[] = $rs;
            }
        }
        $status = 1;
    } else {
        $status = 2;
    }


echo json_encode(array('data'=>$makeArr,'status'=>$status));

