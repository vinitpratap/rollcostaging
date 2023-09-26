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
$makeArr = array();
if ($catid > 0) {
    $msql = "select UPPER(make_nm) as make_nm,make_id FROM rollco_ms_make WHERE make_status=1 AND catid='" . $catid . "' order by make_nm asc ";
    $numsrow = $sq->numsrow($msql);
    if ($numsrow > 0) {
        if ($numsrow > 0) {
            $data = $sq->query($msql);
            while ($rs = $sq->fetch($data)) {
                $rs = mb_convert_encoding($rs, 'UTF-8', 'UTF-8');//new line by ajit
                $makeArr[] = $rs;
            }
        }
        $status = 1;
    } else {
        $status = 2;
    }
} else {
    $status = 0;
}

echo json_encode(array('data'=>$makeArr,'status'=>$status));

