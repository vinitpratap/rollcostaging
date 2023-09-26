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
if (isset($_POST['changeApt']) && $_POST['changeApt'] == 1) {
    $apt_details = trim(addslashes($_POST['apt_details']));
    $action_taken = '';
    if (isset($_POST['action_taken']))
        $action_taken = trim(addslashes($_POST['action_taken']));
    $ss_insertid = addslashes($_POST['ss_id']);
    $user_insertid = addslashes($_POST['user_id']);
    $temp_user_id = addslashes($_POST['temp_user_id']);
    $AcCode = '';
    if ($temp_user_id > 0) {
        $tm_sql = "select customerID from rollco_ms_tmpusers where u_id = '" . $temp_user_id . "'";
        $tm_res = $sq->fearr($tm_sql);
        if (isset($tm_res['customerID']))
            $AcCode = $tm_res['customerID'];
    } else {
        $AcCode = getCustActid($user_insertid);
    }
    $other_text = '';
    if (isset($_POST['other_text']) && $_POST['other_text'] != '') {
        $other_text = addslashes($_POST['other_text']);
    }

    if (!isset($ss_insertid) || $ss_insertid == '') {
        $ss_insertid = 0;
    }

    if ($apt_details != '' || $action_taken != '') {
        $insertAptSql = "INSERT INTO rollco_ms_sales_appointment SET sa_apt_details='" . $apt_details . "',sa_ss_id='" . $ss_insertid . "',other_text='" . $other_text . "',AcCode='" . $AcCode . "',SalesPersonName='" . $_SESSION['firstName'] . "',CreatedBy='" . $_SESSION['firstName'] . "'";
        $sq->query($insertAptSql);
        if ($user_insertid > 0) {
            if (count($_POST['custCat']) > 0) {
                $deleteCatSql = "DELETE FROM rollco_user_to_category_tag WHERE u_id='" . $user_insertid . "'";
                $sq->query($deleteCatSql);

                for ($i = 0; $i < count($_POST['custCat']); $i++) {
                    $insertCatSql = "INSERT INTO rollco_user_to_category_tag SET u_id='" . $user_insertid . "',cat_id='" . $_POST['custCat'][$i] . "'";
                    $sta = $sq->query($insertCatSql);
                }
                if ($sta) {
                    $status = 1;
                    $messg = 'Appointment details successfully submitted.';
                }
            }else{
				$status = 1;
                $messg = 'Appointment details successfully submitted.';
			} 
			/*else {
                $status = 2;
                $messg = 'Customer category can not be unchecked.';
            }*/
        } else {
            $status = 1;
            $messg = 'Appointment details successfully submitted.';
        }
    } else {
        $status = 2;
        $messg = 'Please write something in appointment details or action.';
    }
    echo json_encode(array('data' => $messg, 'status' => $status));
}