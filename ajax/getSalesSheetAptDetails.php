<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include '../class/config.php';
include '../class/commonFunc.php';
 define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!IS_AJAX) {die('Access not allowed');}
$user_id = test_input($_POST['user_id']);
$temp_user_id = test_input($_POST['temp_user_id']);
$sarray = [];
$html = '';
$AcCode = '';
if ($user_id > 0 || $temp_user_id>0) {
    if($user_id > 0){
         $AcCode=getCustActid($user_id);
    $user_catsql = "SELECT sc.scat_nm FROM rollco_user_to_category_tag as tag INNER JOIN  rollco_ms_salescat as sc ON sc.sc_id = tag.cat_id WHERE tag.u_id = '".$user_id."'";
    
    $user_catnum = $sq->numsrow($user_catsql);
    if($user_catnum > 0){
        $user_catdata = $sq->query($user_catsql);
        while($user_catres = $sq->fetch($user_catdata)){
            array_push($sarray,$user_catres['scat_nm']);
        }
    }
    }
    else if($temp_user_id>0){
        $tm_sql="select customerID from rollco_ms_tmpusers where u_id = '".$temp_user_id."'";
        $tm_res=$sq->fearr($tm_sql);
        if(isset($tm_res['customerID'])) $AcCode=$tm_res['customerID'];        
    }

    
    if($AcCode != ''){
           $aptDetailsSql = "SELECT sa_apt_details,SalesPersonName,sa_apt_action,other_text,created_at FROM rollco_ms_sales_appointment WHERE AcCode='" .$AcCode. "'";
    $apt_num = $sq->numsrow($aptDetailsSql);
    if ($apt_num > 0) {
        $apt_data = $sq->query($aptDetailsSql);
        while ($apt_res = $sq->fetch($apt_data)) {
//            if(isset($apt_res['other_text']) && $apt_res['other_text'] != ''){
//                 array_push($sarray,$apt_res['other_text']);
//            }
            $html .= '<tr class="pointer">
                            <td>' . utf8_encode($apt_res['sa_apt_details']) . '</td>
                            <td>' . utf8_encode($apt_res['SalesPersonName']). '</td>
                            <td>' . $apt_res['created_at'] . '</td>
                        </tr>';
        }
        echo json_encode(array('status' => 1, 'data' => $html)); exit;
    }else{
         echo json_encode(array('status' => 0,'data'=>'No appointment details available'));  exit;
    }

    }else{
        echo json_encode(array('status' => 0,'data'=>'No appointment details available'));  exit;
    }
}else{
    echo json_encode(array('status' => 0,'data'=>'No appointment details available'));  exit;
}
