<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include("class/config.php");

$cnt = 0;


$checkSalesBlankSql = "SELECT u_id FROM rollco_salescal WHERE full_name='' AND post_code='' AND sc_country = '' ";

$userBlanknum = $sq->numsrow($checkSalesBlankSql);

if ($userBlanknum > 0) {
    $sales_blankdata = $sq->query($checkSalesBlankSql);
    while ($salesblank_res = $sq->fetch($sales_blankdata)) {
        $user_sql = "SELECT companyName,com_zipCode,com_city  FROM rollco_ms_users WHERE u_id ='" . $salesblank_res['u_id'] . "' AND user_status = 2 ";
        $user_num = $sq->numsrow($user_sql);
        if ($user_num > 0) {
            $user_data = $sq->query($user_sql);
            while ($user_res = $sq->fetch($user_data)) {
                $updateBlankSales = "UPDATE rollco_salescal SET full_name='".$user_res['companyName']."',post_code='".$user_res['com_zipCode']."',sc_country='".$user_res['com_city']."' WHERE u_id='".$salesblank_res['u_id']."' ";
                $sq->query($updateBlankSales);
                $cnt++;
            }
        }
    }

}




    echo "Total " . $cnt . " records updated";
    