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
$yrid = test_input($_POST["yrid"]);
$ccmArr = array();
if ($catid > 0) {
    $msql = "select proccm_id,UPPER(proccm_inf) as proccm_inf FROM rollco_ms_proccm WHERE proccm_status=1 AND catid='" . $catid . "' AND makeid='".$makeid."' AND modelid='".$modelid."' AND proyrid='".$yrid."' group by proccm_inf order by  proccm_inf  asc";
    $numsrow = $sq->numsrow($msql);
    if ($numsrow > 0) {
        if ($numsrow > 0) {
            $data = $sq->query($msql);
            while ($rs = $sq->fetch($data)) {
                $rs = mb_convert_encoding($rs, 'UTF-8', 'UTF-8');//new line by ajit
                $ccmArr[] = $rs;
            }
        }
        $status = 1;
    } else {
        $status = 2;
    }
} else {
    $status = 0;
}

echo json_encode(array('data'=>$ccmArr,'status'=>$status));

