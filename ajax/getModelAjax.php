<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include '../class/config.php';
//define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
//if(!IS_AJAX) {die('Access not allowed');}
$catid = test_input($_POST["catid"]);
$makeid = test_input($_POST["makeid"]);
$modelArr = array();
if ($catid > 0) {
    $msql = "select UPPER(model_nm) as model_nm,model_id FROM rollco_ms_model WHERE model_status=1 AND catid='" . $catid . "' AND makeid='" . $makeid . "' order by model_nm asc";
    $numsrow = $sq->numsrow($msql);
    if ($numsrow > 0) {
        $data = $sq->query($msql);
        while ($rs = $sq->fetch($data)) {
           // echo "<pre>";print_r($rs);
            $rs = mb_convert_encoding($rs, 'UTF-8', 'UTF-8');//new line by ajit

            $modelArr[] = $rs;
        }
        $status = 1;
    } else {
        $status = 2;
    }
} else {
    $status = 0;
}

$json = json_encode(array('data' => $modelArr, 'status' => $status));

if ($json)
    echo $json;
else
    echo json_last_error_msg();