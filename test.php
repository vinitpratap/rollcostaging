<?php
include("class/config.php");
function getCurrSym($cid) {
    $sq = new ajquery;
    $catData = "SELECT curr_name FROM rollco_ms_currency WHERE curr_id='" . $cid . "' LIMIT 1";
    $numsrow = $sq->numsrow($catData);
    if ($numsrow > 0) {
        $data = $sq->fearr($catData);
        return $data['curr_name'];
    }
}

echo '<br>';
echo '<br>';
echo getCurrSym(1);
echo '<br>';
echo getCurrSym(2);
echo '<br>';
echo getCurrSym(3);
echo '<br>';
echo getCurrSym(4);
echo '<br>';

?>