<?php
$REQUESTURI = explode('/', $_SERVER['REQUEST_URI']);
$cpage = end($REQUESTURI);

$incuser_sql = "SELECT com_emailAddress,na_authentication_key FROM rollco_ms_users WHERE u_id = '" . $_SESSION['u_id'] . "' AND user_status = 2";
$incnumsrow = $sq->numsrow($incuser_sql);
if ($incnumsrow > 0) {
    $inc_userdata = $sq->fearr($incuser_sql);
}

$cardetails_sql = "SELECT cart.cart_id,cart.prod_id,cart.u_id,cart.prod_qty,cart.remarks,prd.prod_part_no as itemno,prd.prod_desc as description,prd.prod_price  as price FROM rollco_ms_cart as cart,rollco_ms_product as prd WHERE cart.prod_id=prd.prod_id and cart.prod_id > 0 and cart.u_id='".$_SESSION['u_id']."'";

$numsrprodcart = $sq->numsrow($cardetails_sql);
$cartdata = $sq->query($cardetails_sql);

$cardetailsspr_sql = "SELECT cart.cart_id,cart.prod_id,cart.u_id,cart.prod_qty,cart.remarks,spr.spare_part_no as itemno,spr.spare_desc as description,spr.spare_price as price FROM rollco_ms_cart as cart,rollco_ms_spare as spr WHERE cart.spr_id=spr.spare_id and cart.spr_id > 0 and cart.u_id='".$_SESSION['u_id']."'";
$numsrsprcart = $sq->numsrow($cardetailsspr_sql);
$cartdataspr = $sq->query($cardetailsspr_sql);

$sum = 0.00;
if ( $numsrprodcart > 0) {
    while ($rs = $sq->fetch($cartdata)) {
        $priceSql = "SELECT grpro.pr_price,grp.gr_currency FROM rollco_ms_grproduct as grpro INNER JOIN rollco_ms_group as grp on grp.gr_id = grpro.gr_id  WHERE grpro.gr_id = '" . $_SESSION['g_id'] . "' AND grpro.part_nm='" . $rs['itemno'] . "' LIMIT 1";
        $numsrow = $sq->numsrow($priceSql);
        if ($numsrow > 0) {
            $pData = $sq->fearr($priceSql);
        }
        $sum += $rs['prod_qty'] * $pData['pr_price'];
    }
}
if ($numsrsprcart > 0) {
    while ($rs = $sq->fetch($cartdataspr)) {
        $priceSql = "SELECT grpro.pr_price,grp.gr_currency FROM rollco_ms_grproduct as grpro INNER JOIN rollco_ms_group as grp on grp.gr_id = grpro.gr_id  WHERE grpro.gr_id = '" . $_SESSION['g_id'] . "' AND grpro.part_nm='" . $rs['itemno'] . "' LIMIT 1";
        $numsrow = $sq->numsrow($priceSql);
        if ($numsrow > 0) {
            $pData = $sq->fearr($priceSql);
        }
        $sum += $rs['prod_qty'] * $pData['pr_price'];
    }
}
?>




        <div class="row  cataloTop">
            <div class="col-lg-12">
                <ul class="posLogNav d-flex float-right mb-0">
                <li class="align-self-center mobHide">  <p class="text-danger font14 mb-0"> WELCOME <?php echo strtoupper($usercomp['companyName']); ?>, </p> </li>
                    <li class="align-self-center  active acountImg"><a href="account-details.php" class="<?php if ($cpage == 'account-details.php') echo 'active'; ?>"><span>MY ACCOUNT</span></a> </li>
<?php
if(isset($_SESSION['cust_type']) && $_SESSION['cust_type']==3){
?>
<li class="align-self-center mobHide" ><a href="calendars.php" class="text-uppercase <?php if (strstr($cpage,'calendars') ) echo 'active'; ?>">Calendar</a> </li>
<?php
}
?>
                    <li class="align-self-center mobHide" ><a href="my-recent-order.php" class="text-uppercase <?php if ($cpage == 'my-recent-order.php') echo 'active'; ?>">MY ORDERS  </a> </li>

<?php 
if (isset($inc_userdata['na_authentication_key']) && $inc_userdata['na_authentication_key'] != '') {
    //$inc_naurl = 'https://docs.rollingcomponents.com/public/api/newagency?authentication_key=' . $inc_userdata['na_authentication_key'] . '&emailid='.$inc_userdata['com_emailAddress'];
    $inc_naurl = 'https://docs.rollingcomponents.com/api/loginurl?authentication_key=' . $inc_userdata['na_authentication_key'] . '&emailid='.$inc_userdata['com_emailAddress'];
    ?>
    <li class="align-self-center mobHide" ><a href="<?php echo $inc_naurl?>" target="_blank" class="text-uppercase">Download Document</a> </li>
    <?php 
}
?>


<!--                    <li class="align-self-center"><a href="my-recent-order.php" class="text-uppercase">My WISHLIST</a> </li>-->
                    <li class="myCart "><a href="shoppingCart.php" class="<?php if ($cpage == 'shoppingCart.php') echo 'active'; ?>"> <?php if ($numsrsprcart > 0) { ?><sup class="sup"><?php  echo $numsrsprcart; ?> </sup> <?php } ?><div class="mobHide"> MY CART<span>ITEM: <?php if(isset($pData)) { if (isset($_SESSION['usr_curr'])) {
    echo $_SESSION['usr_curr'];
} else {
    echo getCurrSym($pData['gr_currency']);
                    } echo number_format((float) $sum, 2, '.', ''); } ?> </span> </div></a></li>
                </ul>
            </div>
        </div>
