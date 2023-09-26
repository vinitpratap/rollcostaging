<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../class/config.php';
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!IS_AJAX) {die('Access not allowed');}
$countPro = 0;
$prod =0;
if (isset($_POST['prod_part'])) {
    $part = $_POST['prod_part'];
    $flag = 0;
    $pr1F = 0;
    $pr2F = 0;
    $pr3F = 0;
    

    if (isset($_SESSION['cpr1']) && $_SESSION['cpr1'] == $part) {
        unset($_SESSION['cpr1']);
        $flag = 1;
        $pr1F = 1;
    }
    if (isset($_SESSION['cpr2']) && $_SESSION['cpr2'] == $part) {
        unset($_SESSION['cpr2']);
        $flag = 1;
        $pr2F = 1;
    }
    if (isset($_SESSION['cpr3']) && $_SESSION['cpr3'] == $part) {
        unset($_SESSION['cpr3']);
        $flag = 1;
        $pr3F = 1;
    }



    if (isset($_SESSION['cpr1']) && $_SESSION['cpr1'] != '') {
        $countPro++;
    }
    if (isset($_SESSION['cpr2']) && $_SESSION['cpr2'] != '') {
        $countPro++;
    }
    if (isset($_SESSION['cpr3']) && $_SESSION['cpr3'] != '') {
        $countPro++;
    }

    if (isset($flag)) {
        if(isset($pr1F)){
            $prod = 1;
        }else if(isset($pr2F)){
            $prod = 2;
        }else if(isset($pr3F)){
            $prod = 3;
        }
        $_SESSION['countPro'] = $countPro;
        echo json_encode(array("success" => 1, "proCount" => $countPro,"prod_no"=>$prod));
        exit;
    } else {
        $_SESSION['countPro'] = $countPro;
        echo json_encode(array("success" => 2, "proCount" => $countPro));
        exit;
    }
}