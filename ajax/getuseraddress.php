<?php
include '../class/config.php';
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!IS_AJAX) {die('Access not allowed');}
$u_id= $_SESSION['u_id'];
$messg='';
$status='';
$makeArr = array();
if ($u_id > 0) {
    $msql = "select streetAddress1,streetAddress2,com_city,com_state, com_zipCode FROM rollco_ms_users WHERE u_id='" . $u_id . "' LIMIT 1";
    $numsrow = $sq->numsrow($msql);
    if ($numsrow > 0) {
        if ($numsrow > 0) {
            $data = $sq->query($msql);
            while ($rs = $sq->fetch($data)) {
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
