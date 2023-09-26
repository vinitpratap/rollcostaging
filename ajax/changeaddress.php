<?php
include '../class/config.php';
$u_id= $_SESSION['u_id'];
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!IS_AJAX) {die('Access not allowed');}
$messg='';
$status='';


if(isset($_POST['addresstype1']) && $_POST['addresstype1']!=''){
if (count($_POST['addresstype1']) > 0) {
$msql = "select * FROM rollco_ms_other_adrs WHERE user_id='" . $u_id . "' order by id asc";
$numsrow = $sq->numsrow($msql);
if ($numsrow > 0) {
$msql = "delete from rollco_ms_other_adrs WHERE user_id='" . $u_id . "' ";      $sq->query($msql);
}
    
for ($i = 0; $i < count($_POST['addresstype1']); $i++) {
    if($_POST['addresstype1'][$i]!=''){
$dataInsertPartner = array('addresstypeother' => $_POST['addresstype1'][$i],
                    'streetAddress1other' => $_POST['streetAddress1'][$i],
                    'streetAddress2other' => $_POST['streetAddress2'][$i],
                    'com_cityother' => $_POST['com_city'][$i],
                    'com_stateother' => $_POST['com_state'][$i],
                    'com_zipCodeother' => $_POST['com_zipCode'][$i],
                    'user_id' => $u_id,
                );
            $insertsql = "insert into rollco_ms_other_adrs SET ";
            foreach ($dataInsertPartner as $key => $value) {
                $insertsql .= "" . $key . "='" . $value . "',";
            }
            $insertsql = rtrim($insertsql, ',');
            $sq->query($insertsql);
        }
}
        $status = 1;
$messg="Address added successfully.";
 }else{
       $status = 2;
$messg="Please Add Address.";
 }
}
echo json_encode(array('data'=>$messg,'status'=>$status));

