<?php

include("../class/config.php");
include("../class/commonFunc.php");
if (!isset($_SESSION["u_id"]))
    echo "<script>location.href='../index.php';</script>";

$date = date('d-m-Y');
//Search Cases
$user_name = '';
$suser_name = '';
$r_status = '';
$from_date = '';
$to_date = '';

if (isset($_GET['user_name']) && $_GET['user_name'] != '') {
    $user_name = $_GET['user_name'];
}

if (isset($_GET['sales_name']) && $_GET['sales_name'] != '') {
    $suser_name = $_GET['sales_name'];
}

if (isset($_GET['r_status']) && $_GET['r_status'] != '') {
    $r_status = $_GET['r_status'];
}

if (isset($_GET['search_from_date']) && $_GET['search_from_date'] != '') {
    $from_date = $_GET['search_from_date'];
}

if (isset($_GET['search_to_date']) && $_GET['search_to_date'] != '') {
    $to_date = $_GET['search_to_date'];
};
//Search Cases
// include the Excel class

include (dirname(__FILE__) . "/class-excel.php");
$mArr = array();

$applist_sql = "select * from rollco_salesCal where sec_id = '" . $_SESSION['u_id'] . "'  ";
if ($user_name != '') {
    $applist_sql .= " AND u_id='" . $user_name . "'";
}
if ($suser_name != '') {
    $applist_sql .= " AND sec_id='" . $suser_name . "'";
}
if ($r_status != '') {
    $applist_sql .= " AND sc_status='" . $r_status . "'";
}

if (($from_date != "") && ($to_date != "")) {
    $applist_sql .= " and date(sc_date) between  '" . $from_date . "' and '" . $to_date . "'";
}




$numsDoc = $sq->numsrow($applist_sql);
$doctype = "";
$zoompath = "";
$applist_sql .= " order by sc_date asc";
if ($numsDoc > 0) {
    $query = $sq->query($applist_sql);
    while ($applist_res = $sq->fetch($query)) { //Loop

        if ($applist_res["sc_status"] == 1)
            $Status = 'Open';
        else
            $Status = 'Closed';
$userdetails = getUserName($applist_res['sec_id']);
//Date 
        $mArr[] = array(date('d-m-Y', strtotime($applist_res['sc_date'])), $applist_res['full_name'], $applist_res['post_code'], date('h:i A', strtotime(date('y-m-d') . ' ' . $applist_res['sc_stime'])), date('h:i A', strtotime(date('y-m-d') . ' ' . $applist_res['sc_etime'])), $applist_res['sc_remarks'], $Status,$userdetails['firstName'] . ' ' . $userdetails['lastName']);
    } //Loop
}
// Generating DATA End Here
$excHead = array(
    1 => array("Date", "Name", "Account Code", "Start Time", "End Time", "Remarks", "Status", "Sales Person")
);
// Generating Excel file
$xls = new Excel_XML('UTF-8', false, 'Rollco Report'); //    new Excel_XML;
$xls->addArray($excHead);
$xls->addArray($mArr);
$xls->generateXML("rollco_report_$date");
?>