<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include '../class/config.php';
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!IS_AJAX) {die('Access not allowed');}
$catid = test_input($_POST["catid"]);
$makeid = test_input($_POST["makeid"]);
$modelid = test_input($_POST["modelid"]);
$yearArr = array();
if ($catid > 0) {
    $msql = "select proyr_id,proyr_from,proyr_to,current_flag FROM rollco_ms_proyr WHERE proyr_status=1 AND catid='" . $catid . "' AND makeid='".$makeid."' AND modelid='".$modelid."' order by  proyr_from  asc";
    $numsrow = $sq->numsrow($msql);
    if ($numsrow > 0) {
        if ($numsrow > 0) {
            $data = $sq->query($msql);
            while ($rs = $sq->fetch($data)) {
                $rs = mb_convert_encoding($rs, 'UTF-8', 'UTF-8');//new line by ajit
                $yearArr[] = $rs;
            }
        }
        $status = 1;
    } else {
        $status = 2;
    }
} else {
    $status = 0;
}

echo json_encode(array('data'=>$yearArr,'status'=>$status));

