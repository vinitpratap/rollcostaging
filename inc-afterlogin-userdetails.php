<?php

$REQUESTURI = explode('/', $_SERVER['REQUEST_URI']);
$cpage = end($REQUESTURI);

$cardetails_sql = "SELECT cart.cart_id,cart.prod_id,cart.u_id,cart.prod_qty,cart.remarks,prd.prod_part_no as itemno,prd.prod_desc as description,prd.prod_price  as price FROM rollco_ms_cart as cart,rollco_ms_product as prd WHERE cart.prod_id=prd.prod_id and cart.prod_id > 0";

$numsrprodcart = $sq->numsrow($cardetails_sql);
$cartdata = $sq->query($cardetails_sql);

$cardetailsspr_sql = "SELECT cart.cart_id,cart.prod_id,cart.u_id,cart.prod_qty,cart.remarks,spr.spare_part_no as itemno,spr.spare_desc as description,spr.spare_price as price FROM rollco_ms_cart as cart,rollco_ms_spare as spr WHERE cart.spr_id=spr.spare_id and cart.spr_id > 0";
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


<article class="clearfix cataloTop aos-item" data-aos='fade-up'>
    <div class="container">
        <div class="row">
            <div class="col-12 text-right pt-3">
                <p class="text-danger font14 mb-0"> WELCOME <?php echo strtoupper($_SESSION['firstName']); ?></p>
                <ul class="posLogNav d-flex float-right">
                    <li class="align-self-center"><a href="account-details.php" class="<?php if ($cpage == 'index.php') echo 'active'; ?>">MY ACCOUNT</a> </li>
                    <li class="align-self-center" ><a href="my-recent-order.php" class="text-uppercase <?php if ($cpage == 'index.php') echo 'active'; ?>">MY ORDER </a> </li>
<!--                    <li class="align-self-center"><a href="my-recent-order.php" class="text-uppercase">My WISHLIST</a> </li>-->
                    <li class="myCart"><a href="shoppingCart.php" class="<?php if ($cpage == 'index.php') echo 'active'; ?>"> MY CART<span>ITEM: <?php if(isset($pData)) { if (isset($_SESSION['usr_curr'])) {
    echo $_SESSION['usr_curr'];
} else {
    echo getCurrSym($pData['gr_currency']);
                    } echo number_format((float) $sum, 2, '.', ''); } ?> </span></a></li>
                </ul>
            </div>
        </div>
    </div>
</article>
