<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include '../class/config.php';
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!IS_AJAX) {die('Access not allowed');}
$searchText = test_input($_POST["searchText"]);

$serSql = "SELECT prod_part_no FROM rollco_ms_product WHERE prod_part_no like '" . $searchText . "%' AND prod_status=1 GROUP BY prod_part_no order by prod_part_no asc limit 5 ";
//$serSql = "SELECT prod_part_no FROM rollco_ms_product WHERE MATCH(prod_part_no) AGAINST ('+".$searchText."*' IN BOOLEAN MODE) AND prod_status=1 GROUP BY prod_part_no order by prod_part_no asc limit 5  ";
$numsrow = $sq->numsrow($serSql);
$html = '';
if ($numsrow > 0) {
    $sData = $sq->query($serSql);
    while ($serRes = $sq->fetch($sData)) {
        $html .= "<li value=" . $serRes['prod_part_no'] . ">" . $serRes['prod_part_no'] . "</li>";
    }
    $status = 1;
} else {
    
    $serSql1 = "SELECT rc_num FROM rollco_ms_crossref WHERE MATCH(crossref_oem) AGAINST ('+".$searchText."*' IN BOOLEAN MODE) AND crossref_status=1 GROUP BY rc_num order by rc_num asc limit 5 ";
    $numsrow = $sq->numsrow($serSql1);
    $html = '';
    if ($numsrow > 0) {
        $sData = $sq->query($serSql1);
        while ($serRes = $sq->fetch($sData)) {
            $html .= "<li value=" . $serRes['rc_num'] . ">" . $serRes['rc_num'] . "</li>";
        }
        $status = 1;
    } else {
        $status = 0;
    }
}

echo json_encode(array('data' => $html, 'status' => $status));



