<?php
include("class/config.php");

if (preg_match("/.*Android.*/", $_SERVER['HTTP_USER_AGENT']) || preg_match("/.*iPhone.*/", $_SERVER['HTTP_USER_AGENT'])) {
    $plateform = 'mobile';
} else {
    $plateform = 'desktop';
}


?>

<!doctype html>
<html>
    <head>
        <?php include("inc-head.php"); ?>
    </head>

    <body class="vehicLookup ">
        <?php include("inc-header.php"); ?>
        <section class="clearfix cataloGue">
            <?php /* ?><?php
              if (isset($_SESSION['u_id']) && $_SESSION['u_id'] != '') {
              include("inc-afterlogin-userdetails.php");
              }
              ?><?php */ ?>
            <article class="clearfix aos-item bestChoice" data-aos='fade-up'>
                <div class="container">
                    <div id="cataloGue" class="position-relative text-center subHead prlogin"> <img src="images/login-page-products.jpg"  alt="banner" class="img-fluid w-100">
                        <div class="position-absolute text-left pl-5">
                            <h2 class="text-white electri">
                                <hr class="mb-2">
                                BEST CHOICE<br>
                                FOR SPARE PARTS </h2>
                        </div>
                    </div>
                </div>
            </article>
            <?php include 'search-module.php'; ?>


            <?php
            if (isset($_POST['car_number']) && $_POST['car_number'] != '') {
                $car_no = trim($_POST['car_number']);
                $cat_id = trim($_POST['cat_id']);

                $mamData = getMAMdata($car_no);
				//echo "<pre>";print_r($mamData);die;
//                $mamData = array('vrm' => 'YT14YDL', 'make' => 'VOLKSWAGEN', 'model' => 'GOLF SE TDI BLUEMOTION TECHNOLOGY DSG (MK7 (A7) (5G))',
//                    'year' => '2014', 'esize' => '1598', 'mscode' => '17704100000145',
//                    'MMIv8Key' => '130198');
                if ($mamData) {
                    $makeid = getMakeid($mamData['make']);
                    $modelid = getModelid($mamData['model']);
                    $yrid = getYearid($mamData['year']);

                    $mamid = $mamData['mscode'];
                    $MMIv8Key = $mamData['MMIv8Key'];
                    $productSql = "SELECT pro.prod_id,pro.prod_part_no,pro.prod_desc,pro.prod_trans,pro.prod_nm,pro.prod_img1,pro.prod_part_no,pro.prod_volt,pro.prod_out,pro.prod_stock,pro.prod_add_inf,pro.ptype FROM rollco_ms_product as pro INNER JOIN rollco_ms_mscode as ms ON pro.prod_part_no = ms.part_no WHERE  ms.V8Key='" . $MMIv8Key . "' ";
                    if($cat_id !=0){
                        $productSql .= " AND pro.catid='" . $cat_id . "' ";
                    }
                    
                    
                    $productSql .= " AND pro.prod_status = 1 GROUP BY pro.prod_part_no";
                    //$productSql .= " LIMIT 1";

                    $numrows = $sq->numsrow($productSql);
                    if ($numrows > 0) {
                        $prData = $sq->query($productSql);
                        $prData1 = $sq->query($productSql);
                        // $prData = $sq->fearr($productSql);
                    } else {
                        $snf_user = 'Guest';
                        if (isset($_SESSION['u_id']) && $_SESSION['u_id'] != '') {
                            $snf_user = $_SESSION['firstName'] . ' ' . $_SESSION['lastName'] . ' ' . $_SESSION['com_emailAddress'];
                        }
                        $sql1 = "SELECT snf_id FROM rollco_search_not_found where snf_make='" . $mkId . "' and snf_model='" . $modId . "' and snf_yr='" . $yrId . "' and snf_cc='" . $ccmId . "' and snf_user='" . $snf_user . "' and snf_text='none' and snf_ec='" . $ecId . "' and snf_user='" . $snf_user . "'";
                        $reccount1 = $sq->numsrow($sql1);
                        if ($reccount1 == 0) {
                            $insertsnf = "INSERT INTO rollco_search_not_found SET snf_make='" . $mkId . "',snf_model='" . $modId . "',snf_yr='" . $yrId . "',snf_cc='" . $ccmId . "',snf_user='" . $snf_user . "',snf_text='none',snf_ec='" . $ecId . "',snf_browser='" . $_SERVER['HTTP_USER_AGENT'] . "',snf_platform='" . $plateform . "',snf_ip='" . $_SERVER['REMOTE_ADDR'] . "',created_at='" . $getdatetime . "'";
                            $sq->query($insertsnf);

                            echo "<script>alert('4041: No products found!');location.href='listing.php';</script>";
                        } else {
                            echo "<script>alert('4042: No products found!');location.href='listing.php';</script>";
                        }
                    }
                } else {
                    echo "<script>alert('4043: No products found!');location.href='listing.php';</script>";
                }
            }else{
				echo "<script>location.href='listing.php';</script>";
			}
            ?>
            <article class="pb-5 pt-5 mb-5 acctDetails  ">
                <div class="container pb-5 ">

                    <div class="row justify-content-center">
                        <div class="col-lg-10 pb-5 accountInfo">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#vehiclelookup">Vehicle lookup</a> </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="vehiclelookup">
                                    <div class="row pb-5 justify-content-center">
                                        <div class="col-lg-12 pb-5">
                                            <div class="row">
                                                <div class="col-md-12 col-lg-12">
                                                    <div class="table-responsive table-responsive-lg table-responsive-xl">
                                                        <table class="table  w-100 table-bordered">
                                                            <thead class="thead-dark">
                                                                <tr>
                                                                    <th >Part No. </th>
                                                                    <th >Add Information</th>

                                                                </tr>
                                                            </thead>
                                                            <input type="hidden" id="u_id" value="<?php echo $_SESSION['u_id'] ?>">
                                                            <tbody class="bg-light">
                                                                <?php
                                                                while ($rs = $sq->fetch($prData)) {
                                                                    ?>
                                                                    <tr>


                                                                <input type="hidden" id="prod_id" value="<?php echo $rs['prod_id']; ?>">
                                                                <td ><?php echo $rs['prod_part_no']; ?> </td>
                                                                <td ><?php echo $rs['ptype']; ?></td>

                                                                </tr>

                                                            <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>


                                                    <div class="vehName pb-2 pt-3"><strong>VEHICLE DETAILS</strong></div>   
                                                    <div class="table-responsive table-responsive-lg table-responsive-xl ">
                                                        <table class="table  w-100 table-bordered">
                                                            <thead class="thead-dark">

                                                                <tr>

                                                                    <th>MAKE</th>
                                                                    <th><?php echo $mamData['make']; ?></th>


                                                                </tr>
                                                            </thead>
                                                            <tbody class="bg-light">
                                                                <tr>

                                                                    <td>MODEL</td>
                                                                    <td><?php echo $mamData['model']; ?></td>


                                                                </tr>
                                                                <tr>

                                                                    <td>YEAR</td>
                                                                    <td><?php echo $mamData['year']; ?></td>


                                                                </tr>
                                                                <tr>

                                                                    <td>ENGINE SIZE</td>
                                                                    <td><?php echo $mamData['esize']; ?></td>


                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>






                                                    <div class="table-responsive-md table-responsive-lg table-responsive-xl">
                                                        <table class="table   imgTabl">
                                                            <thead class="thead-dark">

                                                                <tr>

                                                                    <th>Part No.</th>
                                                                    <th>Part Image</th>
                                                                    
                                                                    <th>Description</th>
                                                                    <th>Voltage</th>
																	<th>Transmission</th>
                                                                    <th>Output</th>
                                                                    <th>Availability</th>
                                                                    <th>Price</th>
                                                                    <th>Add Info</th>
                                                                    <th>Qty</th>
                                                                    <th>Cart</th>



                                                                </tr>
                                                            </thead>
                                                            <tbody class="bg-light">
                                                                <?php
                                                                while ($rs1 = $sq->fetch($prData1)) {

                                                                   
                                                                    $priceSql = "SELECT grpro.pr_price,grp.gr_currency FROM rollco_ms_grproduct as grpro INNER JOIN rollco_ms_group as grp on grp.gr_id = grpro.gr_id  WHERE  grpro.part_nm='" . $rs1['prod_part_no'] . "' ";
                                                                    
                                                                     if (isset($_SESSION['cust_type']) && $_SESSION['cust_type'] == 3) {
                                                                        $priceSql .= " LIMIT 1";
                                                                    } else {
                                                                        $priceSql .= " AND grpro.gr_id = '" . $_SESSION['g_id'] . "' LIMIT 1";
                                                                    }
                                                                     
                                                                    $numsrow = $sq->numsrow($priceSql);
                                                                    if ($numsrow > 0 || $_SESSION['cust_type'] == 3) {
                                                                        $pData = $sq->fearr($priceSql);
                                                                        ?>
                                                                        <tr>

                                                                            <td><a href="product-detail.php?rc_num=<?php echo $rs1['prod_part_no']; ?>&type=search" class="active" > <?php echo $rs1['prod_part_no']; ?> </a></td>
                                                                            <td> <img src="../upload/product/<?php echo $rs1['prod_img1']; ?>"></td>

                                                                            
                                                                            <td><?php echo $rs1['ptype']; ?></td>
                                                                            <td><?php echo $rs1['prod_volt']; ?></td>
																			 <td><?php echo $rs1['prod_trans']; ?></td>
                                                                            <td><?php echo $rs1['prod_out']; ?></td>

                                                                            <td><?php
                                                                if ($rs1['prod_stock'] == 1)
                                                                    echo "In Stock";
                                                                else
                                                                    echo "Out of Stock";
                                                                        ?></td>
                                                                            <td><?php
                                                                                echo getCurrSym($pData['gr_currency']);
                                                                                if (isset($_SESSION['cust_type']) && $_SESSION['cust_type'] == 3) {
                                                                                 echo "<span id='vprod_amnt'>0.00</span>";   
                                                                                }else{
                                                                                    echo "<span id='vprod_amnt'>" . $pData['pr_price'] . "</span>";
                                                                                }
                                                                                
                                                                                echo "<input type='hidden' id='vprod_base_amnt' value='" . $pData['pr_price'] . "'>";
                                                                                ?>

                                                                            </td>
                                                                            <td><?php echo $rs1['prod_add_inf']; ?></td>
        <?php
        if ($rs1['prod_stock'] == 1) {
            ?>
                                                                                <td>
                                                                                    <div class="qty" style="width:100px;">
                                                                                        <button type="button" id="sub" class="sub vcartAdd">-</button>
                                                                                        <input type="text" id="1" value="1" class="field shopcart_quan_val">
                                                                                        <button type="button" id="add" class="add vcartSub">+</button>
                                                                                    </div>
                                                                                </td>

                                                                                <td class="cartImg"> <a href="javascript:void()" data-prod_id="<?php echo $rs1['prod_id']; ?>" class="vaddCart"> <img src="images/my-cart.svg" class=" img-fluid pt-2" > </a>
                                                                                </td>
        <?php } ?>



                                                                        </tr>
    <?php }
}
?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </article>
        </section>


        <?php include("inc-footer.php"); ?>
    </body>
</html>