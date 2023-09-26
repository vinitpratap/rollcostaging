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

    <body class="myRecentOrder searchListTop">
            <?php include("inc-header.php"); ?>
        <section class="clearfix cataloGue">
            <?php
            $prArr = array();
            if ($_GET['cat'] == '' || strlen($_GET['cat']) < 1) {
                header('Location: ' . $sitesurl .'listing.php');
            } else {
				$cat = base64_decode($_GET['cat']);
                $make = base64_decode($_GET['make']);
				$model = base64_decode($_GET['model']);
				$yr = base64_decode($_GET['yr']);
				$proccm = base64_decode($_GET['proccm']);
				$eng = base64_decode($_GET['eng']);
                $productSql = "SELECT prod_id,prod_img1,prod_nm,catid,prod_stock,prod_part_no,prod_volt,prod_out,prod_regu,prod_pull_type,prod_fan,prod_teeth,
prod_trans,prod_rot,prod_dim,prod_add_inf,prod_overview,ptype FROM rollco_ms_product WHERE catid='" . $cat . "' AND makeid='" . $make . "' AND modelid='" . $model . "' AND proyrid='" . $yr . "' ";


				

                if (checkIssetNotEmpty($proccm) && $proccm > 0) {
					$ccmids = getCCMName($proccm,$cat,$make,$model,$yr);
				
					$ids = join("','",$ccmids); 
                     $productSql .= " AND proccmid IN ('" . $ids . "') ";
                }


                if (checkIssetNotEmpty($eng) && $eng > 0) {
                    $productSql .= " AND engid='" . $eng . "' ";
                }

                $productSql .= " AND  prod_status=1 group by prod_part_no";
                
                $numrows = $sq->numsrow($productSql);

            }
            ?>


            <article class="pb-5 mb-5 myAccount serchList">
                <div class="container pb-5">
				
                    <div class="row">
                        <div class="col-12 pt-5   pb-3"> <h2 class="text-danger">
                                SEARCH RESULTS  </h2></div> </div>
						
                    <div class="row pb-3">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 pb-5">
                            <div class="table-responsive-md">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <?php if ($numrows > 0) { ?><tr>
                                                <th >Rollco</th>
                                                <th >Product Description</th>
                                                <th>Additional Information </th>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </thead>
                                    <?php if ($numrows > 0) { ?>
                                        <tbody>
                                            <?php
                                            $data = $sq->query($productSql);


                                            while ($rs = $sq->fetch($data)) {
                                                ?>
                                                <tr>

                                                    <td><a href="product-detail.php?rc_num=<?php echo $rs['prod_part_no']; ?>&type=search" class="active" > <?php echo $rs['prod_nm']; ?> </a></td>
                                                    <td><?php
                                        if (strlen($rs['ptype']) > 1)
                                            echo $rs['ptype'];
                                        else
                                            echo "NO INFO";
                                                ?></td>
                                                    <td><?php
                                                if (strlen($rs['prod_add_inf']) > 1)
                                                    echo $rs['prod_add_inf'];
                                                else
                                                    echo "NO INFO";
                                                ?></td>
                                                </tr>

                                            <?php }
                                            ?>

                                        </tbody>
                                    <?php
                                    } else {
                                        $snf_user = 'Guest';
                                        if (isset($_SESSION['u_id']) && $_SESSION['u_id'] != '') {
                                            $snf_user = $_SESSION['firstName'] . ' ' . $_SESSION['lastName'] . ' ' . $_SESSION['com_emailAddress'];
                                        }
                                        $sql1 = "SELECT snf_text FROM rollco_search_not_found where snf_text ='" . $_GET['search-text'] . "' and  snf_user='" . $snf_user . "'";
                                        $reccount1 = $sq->numsrow($sql1);
                                        if ($reccount1 == 0) {
                                            $insertsnf = "INSERT INTO rollco_search_not_found SET snf_make='0',snf_model='0',snf_yr='0',snf_cc='0',snf_user='" . $snf_user . "',snf_text='" . $_GET['search-text'] . "',snf_ec='0',snf_browser='" . $_SERVER['HTTP_USER_AGENT'] . "',snf_platform='" . $plateform . "',snf_ip='" . $_SERVER['REMOTE_ADDR'] . "',created_at='" . $getdatetime . "'";
                                            $sq->query($insertsnf);
                                        }
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td colspan="3"  style="text-align: center"> 
                                                    <span class="minHight">No product found  <a href="listing.php" >Back</a></span>

                                                </td>
                                            </tr>
                                        </tbody>
                                    <?php } ?>
                                </table>
								<a href="<?php echo $siteurl?>listing.php" class="pull-left ml-auto btn-sm btn-success saveButton mt-0"> Back</a>
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