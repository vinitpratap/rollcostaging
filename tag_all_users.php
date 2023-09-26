<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include("class/config.php");

$cnt = 0;
$scal_sql = "SELECT sc_id FROM rollco_ms_salescat WHERE scat_status = 1 ";

$scat_num = $sq->numsrow($scal_sql);


$user_sql = "SELECT u_id  FROM rollco_ms_users WHERE cust_type !=3 AND user_status = 2 ";
$user_num = $sq->numsrow($user_sql);
if ($user_num > 0) {
    $user_data = $sq->query($user_sql);
    while ($user_res = $sq->fetch($user_data)) {
        //$check_tagsql = "SELECT u_id FROM rollco_user_to_category_tag WHERE u_id='" . $user_res['u_id'] . "'";
        //$check_tagnum = $sq->numsrow($check_tagsql);
        // if ($check_tagnum > 0) {
        //$del_tagsql = "DELETE FROM rollco_user_to_category_tag WHERE u_id='" . $user_res['u_id'] . "'";
        //$sq->query($del_tagsql);
        // } else {
        $scat_data = $sq->query($scal_sql);
        while ($scat_res = $sq->fetch($scat_data)) {
            $check_tagsql = "SELECT u_id FROM rollco_user_to_category_tag WHERE u_id='" . $user_res['u_id'] . "' AND cat_id='" . $scat_res['sc_id'] . "'";

            $check_tagnum = $sq->numsrow($check_tagsql);
            if ($check_tagnum > 0) {
                
            } else {
                $ins_scattagsql = "INSERT INTO rollco_user_to_category_tag SET u_id='" . $user_res['u_id'] . "' , cat_id='" . $scat_res['sc_id'] . "'";
                $sq->query($ins_scattagsql);
                $cnt++;
            }
        }
        //}
    }
}



echo "Total " . $cnt . " records inserted";
