<?php
include("class/config.php");
header("Cache-Control: no cache");
session_cache_limiter("private_no_expire");

if (preg_match("/.*Android.*/", $_SERVER['HTTP_USER_AGENT']) || preg_match("/.*iPhone.*/",
                $_SERVER['HTTP_USER_AGENT'])) {
    $plateform = 'mobile';
} else {
    $plateform = 'desktop';
}


$rc_num1 = '';
if (isset($_POST['rc_num']) && trim($_POST['rc_num']) != '') {
    $rc_num = $_POST['rc_num'];
    $rc_num1 = $_POST['rc_num'];
}

$sbypart = '';
if (isset($_POST['sbypart']) && trim($_POST['sbypart']) != '') {
    $sbypart = $_POST['sbypart'];
}

$rc_num2 = '';
if (isset($_GET['rc_num']) && trim($_GET['rc_num']) != '') {
    $rc_num = $_GET['rc_num'];
    $rc_num2 = $_GET['rc_num'];
}
$type = '';
if (isset($_GET['type']) && trim($_GET['type']) != '') {
    $type = $_GET['type'];
}

$roll_product = '';
if (isset($_POST['roll_product']) && trim($_POST['roll_product'] != '')) {
    $roll_product = $_POST['roll_product'];
    $prVal = splitIdAndText($_POST['roll_product']);
    $prId = $prVal['id'];
    $prText = $prVal['text'];
}
$roll_make = '';
if (isset($_POST['roll_make']) && trim($_POST['roll_make'] != '')) {
    $roll_make = $_POST['roll_make'];
    $mkVal = splitIdAndText($_POST['roll_make']);
    $mkId = $mkVal['id'];
    $mkText = $mkVal['text'];
}
$roll_model = '';
if (isset($_POST['roll_model']) && trim($_POST['roll_model'] != '')) {
    $roll_model = $_POST['roll_model'];
    $modVal = splitIdAndText($_POST['roll_model']);
    $modId = $modVal['id'];
    $modText = $modVal['text'];
}
$roll_year = '';
if (isset($_POST['roll_year']) && trim($_POST['roll_year']) != '') {
    $roll_year = $_POST['roll_year'];
    $yrVal = splitIdAndText($_POST['roll_year']);
    $yrId = $yrVal['id'];
    $yrText = $yrVal['text'];
}

$roll_exact_ccm = '';
if (isset($_POST['roll_exact_ccm']) && trim($_POST['roll_exact_ccm']) !== '') {
    $roll_exact_ccm = $_POST['roll_exact_ccm'];
    $ccmVal = splitIdAndText($_POST['roll_exact_ccm']);
    $ccmId = $ccmVal['id'];
    $ccmText = $ccmVal['text'];
}
$roll_engine_code = '';
if (isset($_POST['roll_engine_code']) && trim($_POST['roll_engine_code']) != '') {
    $roll_engine_code = $_POST['roll_engine_code'];
    $ecVal = splitIdAndText($_POST['roll_engine_code']);
    $ecId = $ecVal['id'];
    $ecText = $ecVal['text'];
}



$checkarray = array($rc_num1, $sbypart, $rc_num2, $type, $roll_product, $roll_make,
    $roll_model, $roll_year, $roll_exact_ccm, $roll_engine_code);

if (!array_filter($checkarray)) {
    echo "<script>location.href='listing.php';</script>";
}
$countPro = 0;
if (isset($_SESSION['cpr1']) && $_SESSION['cpr1'] != '') {
    $countPro++;
}
if (isset($_SESSION['cpr2']) && $_SESSION['cpr2'] != '') {
    $countPro++;
}
if (isset($_SESSION['cpr3']) && $_SESSION['cpr3'] != '') {
    $countPro++;
}

?>

<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php include("inc-head.php"); ?>
    </head>

    <body class="producDe prodsearchheight serchPrhit">
        <?php include("inc-header.php"); ?>
        <section class="clearfix cataloGue">
            <?php /* ?> <?php
              if (isset($_SESSION['u_id']) && $_SESSION['u_id'] != '') {
              include("inc-afterlogin-userdetails.php");
              }
              ?><?php */ ?>
            <!--<article class="clearfix aos-item bestChoice" data-aos='fade-up'>
                <div class="container mob-pad">
                    <div id="cataloGue" class="position-relative text-center subHead prlogin"> <img src="images/login-page-products.jpg"  alt="banner" class="img-fluid w-100">
                        <div class="position-absolute text-left pl-5">
                            <h2 class="text-white electri">
                                <hr class="mb-2">
                                BEST CHOICE<br>
                                FOR SPARE PARTS </h2>
                        </div>
                    </div>
                </div>
            </article>-->
            <?php include 'search-module.php'; ?>
            <?php
            
            $pro = 0;
            $sp = 0;
            if (isset($_SESSION['u_id']) && $_SESSION['u_id'] != '') {
                $u_id = $_SESSION['u_id'];
            } else {
                $u_id = 0;
            }

            if (checkIssetNotEmpty($roll_product) && checkIssetNotEmpty($roll_make)
                    && checkIssetNotEmpty($roll_model) && checkIssetNotEmpty($roll_year)) {



                $productSql = "SELECT prod_id,prod_img1,prod_nm,catid,prod_stock,prod_part_no,prod_volt,prod_out,prod_regu,prod_pull_type,prod_fan,prod_teeth,
prod_trans,prod_rot,prod_dim,prod_add_inf,prod_overview,prod_dim,position,gr,car_fits,fuel,external_teeth,internal_teeth,diameter,
height,abs_ring,Weight,Disc_Dia,Disc_Thick,Piston_Dia,Man,Pump_Type,Pressure,Pully_Ribs,Total_Length,Pin,Fitting_position,No_of_Holes,
Bolt_Hole_Circle_Dia,Inner_Dia,Outer_Dia,Teeth_wheel_side,Teeth_Diff_Side,prod_status,Min_Th,Max_Th,Centre_Dia,PCD,Disc_Type,Width,F_R,prod_status FROM rollco_ms_product WHERE catid='" . $prId . "' AND makeid='" . $mkId . "' AND modelid='" . $modId . "' AND proyrid='" . $yrId . "' ";

                //debug($ids);die;
                if (checkIssetNotEmpty($roll_exact_ccm) && $roll_exact_ccm > 0) {

                    $ccmids = getCCMName($ccmId, $prId, $mkId, $modId, $yrId);

                    $ids = join("','", $ccmids);
                    $productSql .= " AND proccmid IN ('" . $ids . "') ";
                }

                if (checkIssetNotEmpty($roll_engine_code) && $roll_engine_code > 0) {

                    $ecids = getEngineCodeName($ecId, $prId, $mkId, $modId, $yrId);

                    $ecids_str = join("','", $ecids);

                    $productSql .= " AND engid IN ('" . $ecids_str . "') ";
                }

                $productSql .= " group by prod_part_no";

                $numrows = $sq->numsrow($productSql);
                if ($numrows > 0) {
                    $pro = 1;
                    $prData = $sq->fearr($productSql);
                    if ($numrows > 1) {
                        // header('Location: ' . $sitesurl. 'search-list-product.php?cat='.$prId.'&make='.$mkId.'&model='.$modId.'&yr'.$yrId.'&proccm='.$ccmId.'&eng='.$engid.'');exit;
                        ?>
                        <script>document.location.href = '<?php echo $sitesurl . 'search-list-product.php?cat=' . base64_encode($prId) . '&make=' . base64_encode($mkId) . '&model=' . base64_encode($modId) . '&yr=' . base64_encode($yrId) . '&proccm=' . base64_encode($ccmId) . '&eng=' . base64_encode($engid); ?>';</script>
                        <?php
                    }
                } else {
                    $snf_user = 'Guest';
                    if (checkIssetNotEmpty($_SESSION['u_id']) && $_SESSION['u_id']
                            != '') {
                        $snf_user = $_SESSION['firstName'] . ' ' . $_SESSION['lastName'] . ' ' . $_SESSION['com_emailAddress'] . ' ' . $_SESSION['customerID'];
                    }

//                    
                    $insertsnf = "INSERT INTO rollco_search_not_found SET snf_make='" . $mkId . "',snf_model='" . $modId . "',snf_yr='" . $yrId . "',snf_cc='" . $ccmId . "',snf_user='" . $snf_user . "',snf_text='none',snf_ec='" . $ecId . "',snf_browser='" . $_SERVER['HTTP_USER_AGENT'] . "',snf_platform='" . $plateform . "',snf_ip='" . $_SERVER['REMOTE_ADDR'] . "',created_at='" . $getdatetime . "'";
                    $sq->query($insertsnf);
                    echo "<script>alert('No product found!');window.history.back();</script>";
//                }
                }
            }

            if (checkIssetNotEmpty($sbypart) && $sbypart == 1) {
                $part_no = addslashes(trim($rc_num));
                $crefflag = 0;

//                echo $productSql = "SELECT pr.prod_id,pr.prod_img1,pr.prod_nm,pr.catid,pr.prod_stock,pr.prod_part_no,pr.prod_volt,pr.prod_out,pr.prod_regu,pr.prod_pull_type,pr.prod_fan,pr.prod_teeth,pr.
//prod_trans,pr.prod_rot,pr.prod_dim,pr.prod_add_inf,pr.prod_overview FROM rollco_ms_product as pr INNER JOIN  rollco_ms_crossref ON pr.prod_nm = rollco_ms_crossref.rc_num WHERE pr.prod_part_no='" . $part_no . "' OR rollco_ms_crossref.crossref_oem ='" . $part_no . "' LIMIT 1 ";
//                die;
                $snf_user = 'Guest';
                if (checkIssetNotEmpty($_SESSION['u_id']) && $_SESSION['u_id'] != '') {
                    $userData = getUserName($_SESSION['u_id']);
                    $snf_user = $_SESSION['firstName'] . ' ' . $_SESSION['lastName'] . ' ' . $_SESSION['com_emailAddress'] . ' ' . $_SESSION['customerID'];
                }
                
                $productSql = "SELECT pr.prod_id,pr.prod_img1,pr.prod_nm,pr.catid,pr.prod_stock,pr.prod_part_no,pr.prod_volt,pr.prod_out,pr.prod_regu,pr.prod_pull_type,pr.prod_fan,pr.prod_teeth,pr.
prod_trans,pr.prod_rot,pr.prod_dim,pr.prod_add_inf,pr.prod_overview,pr.ptype,pr.catid,pr.prod_dim,pr.position,pr.gr,pr.car_fits,pr.fuel,pr.external_teeth,pr.internal_teeth,pr.diameter,pr.
height,pr.abs_ring,pr.Weight,pr.Disc_Dia,pr.Disc_Thick,pr.Piston_Dia,pr.Man,pr.Pump_Type,pr.Pressure,pr.Pully_Ribs,pr.Total_Length,pr.Pin,pr.Fitting_position,pr.No_of_Holes,pr.
Bolt_Hole_Circle_Dia,pr.Inner_Dia,pr.Outer_Dia,Teeth_wheel_side,Teeth_Diff_Side,Min_Th,Max_Th,Centre_Dia,PCD,Disc_Type,Width,F_R,prod_status FROM rollco_ms_product as pr WHERE pr.prod_part_no='" . $part_no . "'  LIMIT 1";

                $numrows = $sq->numsrow($productSql);
                 
                if ($numrows > 0) {
                    $pro = 1;
                    $prData = $sq->fearr($productSql);
                    
                    $spareserSql = "SELECT prod_id FROM rollco_search_found WHERE prod_id='" . $prData['prod_id'] . "' AND user_id='" . $u_id . "'";
                    $numsrowspr = $sq->numsrow($spareserSql);
                    if ($numsrowspr == 0) {
                        $serchdatasql = "INSERT INTO rollco_search_found SET user_id='" . $u_id . "',prod_id='" . $prData['prod_id'] . "',spr_id='0',u_ip='" . $_SERVER['REMOTE_ADDR'] . "',user_info='" . $snf_user . "',user_browser='" . $_SERVER['HTTP_USER_AGENT'] . "',user_platform='" . $plateform . "',user_county='" . $userData['com_state'] . "',user_cntry='" . $userData['Country'] . "',user_city='" . $userData['com_city'] . "'";
                        $sq->query($serchdatasql);
                    }
                   
                } else {

                    $crrefSql = "SELECT rc_num FROM rollco_ms_crossref WHERE crossref_oem = '" . $part_no . "' GROUP BY rc_num";
                    $numrowscref = $sq->numsrow($crrefSql);

                    $crefArr = array();
                    $cref_str = '';
                    if ($numrowscref > 0) {

                        $cData = $sq->query($crrefSql);
                        while ($res = $sq->fetch($cData)) {
                            array_push($crefArr, $res['rc_num']);
                        }

                        //echo "<pre>";print_r($crefArr);die;
                        //$crefData = $sq->fearr($crrefSql);
                        $productSql = "SELECT pr.prod_id,pr.prod_img1,pr.prod_nm,pr.catid,pr.prod_stock,pr.prod_part_no,pr.prod_volt,pr.prod_out,pr.prod_regu,pr.prod_pull_type,pr.prod_fan,pr.prod_teeth,pr.prod_trans,pr.prod_rot,pr.prod_dim,pr.prod_add_inf,
						pr.prod_overview,pr.prod_dim,pr.position,pr.gr,pr.car_fits,pr.fuel,pr.external_teeth,pr.internal_teeth,pr.diameter,pr.
height,pr.abs_ring,pr.Weight,pr.Disc_Dia,pr.Disc_Thick,pr.Piston_Dia,pr.Man,pr.Pump_Type,pr.Pressure,pr.Pully_Ribs,pr.Total_Length,pr.Pin,pr.Fitting_position,pr.No_of_Holes,pr.
Bolt_Hole_Circle_Dia,pr.Inner_Dia,pr.Outer_Dia,pr.Teeth_wheel_side,pr.Teeth_Diff_Side,pr.prod_status,pr.prod_status,pr.Min_Th,pr.Max_Th,pr.Centre_Dia,pr.PCD,pr.Disc_Type,pr.Width,pr.F_R  FROM rollco_ms_product as pr WHERE ";

                        if (count($crefArr) == 1) {
                            $crefData = $sq->fearr($crrefSql);
                            $productSql .= " pr.prod_part_no='" . $crefData['rc_num'] . "'  LIMIT 1";
                        } else if (count($crefArr) > 1) {

                            $cref_str = join("','", $crefArr);

                            $productSql .= " pr.prod_part_no IN ('" . $cref_str . "') GROUP BY pr.prod_part_no";
                        }
                        $numrows = $sq->numsrow($productSql);
                        if ($numrows > 0) {
                            if ($numrows > 1) {
                                ?>
                                <script>window.location = "search-list-crossref.php?search-text=<?php echo $part_no; ?>";</script>
                                <?php
                            }
                            $pro = 1;
                            $prData = $sq->fearr($productSql);
                            $crefflag = 1;
                        }
                    }

                    $pr_status = 0;
                    if (isset($prData) && $prData['prod_status'] == 0) {
                        $pr_status = 0;
                    } else {
                        $pr_status = 1;
                    }

                    if (!$crefflag && $pr_status) {

                        $spareSql = "SELECT spare_id,spare_img1,spare_nm,spare_avail,spare_part_no,spare_desc,spare_add_inf FROM rollco_ms_spare WHERE spare_part_no='" . $part_no . "' AND spare_status= 1 LIMIT 1";
                        $numsrow1 = $sq->numsrow($spareSql);
                        if ($numsrow1 > 0) {
                            $sp = 1;
                            $spData = $sq->fearr($spareSql);
                            $spareserSql = "SELECT spr_id FROM rollco_search_found WHERE spr_id='" . $spData['spare_id'] . "'  AND user_id='" . $u_id . "'";
                            $numsrowspr = $sq->numsrow($spareserSql);
                            if ($numsrowspr == 0) {

                                $serchdatasql = "INSERT INTO rollco_search_found SET user_id='" . $u_id . "',prod_id='0',spr_id='" . $spData['spare_id'] . "',u_ip='" . $_SERVER['REMOTE_ADDR'] . "',user_info='" . $snf_user . "',user_browser='" . $_SERVER['HTTP_USER_AGENT'] . "',user_platform='" . $plateform . "',user_cntry='" . $userData['Country'] . "',user_county='" . $userData['com_state'] . "',user_city='" . $userData['com_city'] . "'";
                                $sq->query($serchdatasql);
                            }
                        } else {
                            ?>
                            <script>window.location = "search-list.php?search-text=<?php echo $part_no; ?>";</script>
                            <?php
                        }
                    }
                }
            }

            if (checkIssetNotEmpty($type) && $type == 'search') {

                $part_no = addslashes(trim($rc_num));
                $productSql = "SELECT prod_id,prod_img1,prod_nm,catid,prod_stock,prod_part_no,prod_volt,prod_out,prod_regu,prod_pull_type,prod_fan,prod_teeth,
prod_trans,prod_rot,prod_dim,prod_add_inf,prod_overview,prod_dim,position,gr,car_fits,fuel,external_teeth,internal_teeth,diameter,
height,abs_ring,Weight,Disc_Dia,Disc_Thick,Piston_Dia,Man,Pump_Type,Pressure,Pully_Ribs,Total_Length,Pin,Fitting_position,No_of_Holes,
Bolt_Hole_Circle_Dia,Inner_Dia,Outer_Dia,Teeth_wheel_side,Teeth_Diff_Side,prod_status,Min_Th,Max_Th,Centre_Dia,PCD,Disc_Type,Width,F_R FROM rollco_ms_product WHERE prod_part_no='" . $part_no . "'   LIMIT 1 ";
//        ECHO $productSql;
//DIE();
//            
                $numrows = $sq->numsrow($productSql);
                if ($numrows > 0) {
                    $pro = 1;
                    $prData = $sq->fearr($productSql);

                    $spareserSqllist = "SELECT prod_id FROM rollco_search_found WHERE prod_id='" . $prData['prod_id'] . "'";

                    $numserlist = $sq->numsrow($spareserSqllist);
                    if ($numserlist == 0) {

                        $serchdatasql = "INSERT INTO rollco_search_found SET user_id='" . $u_id . "',prod_id='" . $prData['prod_id'] . "',spr_id='0',u_ip='" . $_SERVER['REMOTE_ADDR'] . "'";

                        $sq->query($serchdatasql);
                    }
                }
            }

            ?>
            <?php if ($pro && $prData['prod_status']) { ?>
                <article class=" clearfix aos-item  faqOrdNews" data-aos='fade-up'>
                    <div class="container">
                        <div class="row pt-3 justify-content-end">
                            <div class="col-4 text-right addTocompar <?php if ($countPro
                    == 0) { ?> disableComp <?php } ?>">
                                <div class="btn btn-secondary comparButton " id="flip" <?php if ($countPro
                    == '0') echo 'style="display:none"'; ?> >COMPARE <span class="countComp">
    <?php if ($countPro > 0) { ?>
                                            (<?php echo $countPro; ?>)
                                        <?php } ?>
                                    </span></div>
                                <div id="panel">
                                    <p id="compProd1" class=" <?php
                                        if (!isset($_SESSION['cpr1']) && $_SESSION['cpr1']
                                                == '') {
                                            echo "displayNone";
                                        }
                                        ?>" data-prod_part ="<?php
                                    if (isset($_SESSION['cpr1']) && $_SESSION['cpr1']
                                            != '') {
                                        echo $_SESSION['cpr1'];
                                    }
                                    ?>" ><span class="compProd1">
                                       <?php
                                       if (isset($_SESSION['cpr1']) && $_SESSION['cpr1']
                                               != '') {
                                           echo $_SESSION['cpr1'];
                                       }
                                       ?>
                                        </span><span class="close cprod1" > X </span> </p>
                                    <p id="compProd2 " class="<?php
                                    if (!isset($_SESSION['cpr2']) && $_SESSION['cpr2']
                                            == '') {
                                        echo "displayNone";
                                    }
                                    ?>" data-prod_part ="<?php
                                       if (isset($_SESSION['cpr2']) && $_SESSION['cpr2']
                                               != '') {
                                           echo $_SESSION['cpr2'];
                                       }
                                       ?>"><span class="compProd2">
                                       <?php
                                       if (isset($_SESSION['cpr2']) && $_SESSION['cpr2']
                                               != '') {
                                           echo $_SESSION['cpr2'];
                                       }
                                       ?>
                                        </span><span class="close cprod2"> X </span> </p>
                                    <p id="compProd3 " class="<?php
                                       if (!isset($_SESSION['cpr3']) && $_SESSION['cpr3']
                                               == '') {
                                           echo "displayNone";
                                       }
                                       ?>" data-prod_part ="<?php
                                       if (isset($_SESSION['cpr3']) && $_SESSION['cpr3']
                                               != '') {
                                           echo $_SESSION['cpr3'];
                                       }
                                       ?>"><span class="compProd3">
    <?php
    if (isset($_SESSION['cpr3']) && $_SESSION['cpr3'] != '') {
        echo $_SESSION['cpr3'];
    }
    ?>
                                        </span><span class="close cprod3"> X </span> </p>

                                    <!--href="compare.php"--> 
                                    <div class="compare-btn">
                                        <a  href="compare.php" id="goToCompare" class="goToCompare <?php
    if ($countPro < 2) {
        echo "displayNone";
    }
    ?>" > COMPARE</a> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-3 justify-content-center">
                            <div class="col-md-10  mb-5">
                                <div class="row">
                                    <div class="col-lg-5 pt-3 pt-md-5">
                                        <input type="hidden" id="prod_id" value="<?php echo $prData['prod_id']; ?>">
                                        <input type="hidden" id="u_id" value="<?php echo $_SESSION['u_id']; ?>">
                                        <div id="slide_cont" class="bg-light border prod_image_div">
                                            <?php
                                            if (isset($prData['prod_img1']) && $prData['prod_img1']
                                                    != '') {
                                                ?>
                                                <img src="../upload/product/<?php echo $prData['prod_img1']; ?>" id="slideshow_image" data-magnify-src="../upload/product/<?php echo $prData['prod_img1']; ?>">
                                        <?php } else { ?>
                                                <img src="../upload/no-image.png" alt="" class="img-fluid"/>
                                            <?php
                                        }
                                        ?>
                                        </div>
                                        <input type="hidden" id="img_no" value="0">
    <?php
    if (isset($prData['prod_img1']) && $prData['prod_img1'] != '') {
        ?>
                                            <button id="product_image_left_button" class="btn btn-danger image-prev " data-currimg="prodimg_1" data-prev="1" data-next="0"> <img src="images/left-arrow.jpg"/></button>
                                            <button id="product_image_right_button" class="btn btn-danger image-next "  data-currimg="prodimg_1" data-prev="0" data-next="1"><img src="images/right-arrow.jpg"/></button>
    <?php } ?>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-sm-6">
                                        <div class="row pt-5">
                                            <div class="col-lg-10 col-md-11 col-sm-12 col-12  altern">
                                                <h3 class="text-uppercase text-black-50 d-inline-block"> <span class="d-block text-danger"><?php echo $prData['prod_nm']; ?></span> <?php echo getCatName($prData['catid']); ?>
                                                    <hr class="mb-2 ">
                                                </h3>
                                                <p class="pt-2 text-uppercase text-black-50 font-weight-normal">Availability:
                                                    <?php
                                                    if (isset($_SESSION['u_id'])
                                                            && $_SESSION['u_id']
                                                            != '') {
                                                        $priceSql = "SELECT grpro.pr_price,grp.gr_currency FROM rollco_ms_grproduct as grpro INNER JOIN rollco_ms_group as grp on grp.gr_id = grpro.gr_id  WHERE grpro.gr_id = '" . $_SESSION['g_id'] . "' AND grpro.part_nm='" . $prData['prod_part_no'] . "' LIMIT 1";
                                                        $numsrow = $sq->numsrow($priceSql);

                                                        if (($numsrow > 0 || $_SESSION['customerID']
                                                                == 'RC' || $_SESSION['customerID']
                                                                == 'TEMP') && $prData['prod_stock']
                                                                == 1) {
                                                            echo "IN STOCK";
                                                        } else if ($prData['prod_stock']
                                                                == 2) {
                                                            echo "LOW ON STOCK";
                                                            ?>
                                                            <strong> PLEASE CALL </strong>
                                                            <?php
                                                        } else {
                                                            echo "NOT IN  STOCK";
                                                        }
                                                    } else {
                                                        if ($prData['prod_stock']
                                                                == 1) {
                                                            echo "IN STOCK";
                                                        } else if ($prData['prod_stock']
                                                                == 2) {
                                                            echo "LOW ON STOCK";
                                                            ?>
                                                            <strong> PLEASE CALL </strong>
            <?php
        } else {
            echo "NOT IN  STOCK";
        }
    }
    ?>
                                                </p>
                                            </div>
                                            <div class="col-12 manuFact">
    <?php if (!isset($_SESSION['u_id'])) { ?>
                                                    <ul>
                                                        <li>
                                                            <p style="color:#ef4135 ;">Carriage Free only for UK ,for the Order value more than £150 . * 
                                                                <br/>
                                                                <a href="terms_and_conditions.php" target="_blank" style="color:#ef4135 ;">* Please read our terms and condition. </a> </p>
                                                        </li>

                                                        <li>
                                                            <p>Manufactured to the highest OE/OES quality standards </p>
                                                        </li>
                                                        <li>
                                                            <p>Two years warranty</p>
                                                        </li>
                                                        <li>
                                                            <p>100% end of line tested</p>
                                                        </li>
                                                        <li>
                                                            <p>All fitting accessories and fitting instructions included</p>
                                                        </li>
                                                    </ul>
                                                    <a href='login.php' class="btn butnBynow">BUY NOW</a> 
                                                    <!--                                                    <input type="submit"  class="btn butnBynow" value="BUY NOW">-->
                                            <?php } ?>
                                                <div class="btn  comparButton2 d-inline-block addToComp" data-prod_part="<?php echo $prData['prod_part_no']; ?>" >COMPARE</div>
                                                <span class="comp-msg"></span>
                                                <figure class="imSize sharThis">
                                                    <p>Share this product</p>
                                                    <a href="https://www.facebook.com/rollco1979/"  target="_blank"><img src="images/facebook.svg"> </a> <a href="https://twitter.com/rollingcomp" target="_blank"><img src="images/twitter.svg"></a> </figure>
                                            </div>
                                                       <?php
                                                       if (isset($_SESSION['u_id'])
                                                               && $_SESSION['u_id']
                                                               != '') {
                                                           $priceSql = "SELECT grpro.pr_price,grp.gr_currency FROM rollco_ms_grproduct as grpro INNER JOIN rollco_ms_group as grp on grp.gr_id = grpro.gr_id  WHERE grpro.gr_id = '" . $_SESSION['g_id'] . "' AND grpro.part_nm='" . $prData['prod_part_no'] . "' LIMIT 1";
                                                           $numsrow = $sq->numsrow($priceSql);
                                                           if ($numsrow > 0) {
                                                               $pData = $sq->fearr($priceSql);
                                                               $_SESSION['usr_curr']
                                                                       = getCurrSym($pData['gr_currency']);
                                                               ?>
                                                    <div class="col-12 pt-5">
                                                        <input type="hidden" id="prod_base_amnt" value="<?php
                                                    if ($_SESSION['cust_type'] == 3
                                                            && $pData['pr_price']
                                                            < 0)
                                                        echo '0';
                                                    else
                                                        echo $pData['pr_price'];
                                                    ?>">
                                                        <!--                                                        <h3 class="font-weight-600 text-danger"> <?php //echo getCurrSym($pData['gr_currency']);           ?><span id="prod_base_amnt"> <?php // echo $pData['pr_price'];           ?></span></h3>--> 
                                                    </div>
                                            <?php
                                        }
                                    }
                                    ?>
    <?php
    if ($prData['prod_stock'] == 0) {
        ?>
                                                <div class="col-12 pt-2"> 
                                                  <!--                                                <a href="#" class="mr-2"><img src="images/reload.svg" alt="" class="img-fluid" width="31"></a> --> 
                                                    <a href="enquire-now.php"><img src="images/email3.png" alt="" class="img-fluid"  width="31"></a> </div>
                                                            <?php } ?>
                                        </div>
                                    </div>
                                                            <?php
                                                            //echo $_SESSION['customerID'];
                                                            if (isset($_SESSION['u_id'])
                                                                    && $_SESSION['u_id']
                                                                    != '' && ($prData['prod_stock']
                                                                    == 1 || $prData['prod_stock']
                                                                    == 2)) {

                                                                $priceSql = "SELECT grpro.pr_price,grp.gr_currency FROM rollco_ms_grproduct as grpro INNER JOIN rollco_ms_group as grp on grp.gr_id = grpro.gr_id  WHERE grpro.gr_id = '" . $_SESSION['g_id'] . "' AND grpro.part_nm='" . $prData['prod_part_no'] . "' LIMIT 1";
                                                                $numsrow = $sq->numsrow($priceSql);

                                                                if ($numsrow > 0
                                                                        || $_SESSION['customerID']
                                                                        == 'RC' || $_SESSION['customerID']
                                                                        == 'TEMP') {
                                                                    $pData = $sq->fearr($priceSql);
                                                                    ?>
                                            <div class="col-xl-3 col-lg-3 col-sm-6 ml-auto faqOrdTot pt-5">
                                                <div class="row  bg-danger">
                                                    <div class="col-12 pt-4">

                                                        <p class="font18 text-white">Total: <strong class="font28 roll_prod_price"><?php echo getCurrSym($pData['gr_currency']); ?><span id="prod_amnt"> <?php
                                if ($_SESSION['customerID'] == 'RC' || $_SESSION['customerID']
                                        == 'TEMP')
                                    echo '0.00';
                                else
                                    echo $pData['pr_price'];
                                ?></span></strong> </p>
                                                    </div>
                                                    <div  class="qty col-12 pb-2">
                                                        <button type="button" id="sub" class="sub">-</button>
                                                        <input type="text" id="cart_quan_val" value="1" class="field" />
                                                        <button type="button" id="add" class="add">+</button>
                                                    </div>
                                                    <!--<div class="col-10">
                                                        <p class="font12 text-white">Item will Ship in Approx. 2-4
                                                            Business Days </p>
                                                    </div>-->
                                                    <div class="col-12 pt-5 pb-2"> <a class="font12 text-white" href="contact-us.php"> Looking for Greater Quantities? </a> </div>
                                                    <div class="col-10 pb-3 "> <a href="#" id="butAddTo" class="font14 butAddTo"> ADD TO CART > </a> </div>
                                                </div>
                                            </div>
                    <?php } else {
                        ?>
                                            <div class="col-xl-3 col-lg-3 col-sm-6 ml-auto faqOrdTot pt-5">
                                                <div class="row  bg-danger">
                                                    <div class="col-12 pt-4">
                                                        <p class="font18 text-white"><strong>Not in stock <a href="enquire-now.php"><img src="images/email3.png" alt="" class="img-fluid"  width="31"></a><br>
                                                                <br>
                                                                <br>
                                                                <br>
                                                                <br>
                                                                <br>
                                                                <br>
                                                                <br>
                                                                <br>
                                                            </strong> </p>
                                                    </div>
                                                </div>
                                            </div>
            <?php
        }
    }
    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                                        <?php
                                        $spareDetailsSql = "SELECT spare_oem FROM rollco_ms_spare WHERE spare_nm='" . $prData['prod_nm'] . "' AND spare_status = 1";
                                        $sprnumsrow = $sq->numsrow($spareDetailsSql);
                                        ?>
                <article class="clearfix padB200 aos-item faqOrdNews" data-aos='fade-up'>
                    <div class="container">
                        <div class="row  pt-3 justify-content-center mr-0 ml-0 navTabs">
                            <div class="col-lg-10  pt-3 pb-2  mb-4 border-top alt120 border-bottom border-danger">
                                <div class="row">
                                    <div class="col-12">
                                        <ul class="nav nav-tabs nav-justified " >
                                            <li class="nav-item   "> <a class="nav-link text-uppercase  active" data-toggle="tab" href="#productdetails">PRODUCT DETAILS</a> </li>
                                            <li class="nav-item "> <a class="nav-link text-uppercase " data-toggle="tab" href="#overView">overview</a> </li>
                                            <?php if (isset($_SESSION['u_id']) && $_SESSION['u_id'] != '') {?>
                                            <li class="nav-item "> <a class="nav-link text-uppercase" data-toggle="tab" href="#crossRefrence">CROSS - REFERENCES</a> </li>
                                            <?php }?>
                                            <li class="nav-item "> <a class="nav-link text-uppercase" data-toggle="tab" href="#applications">Applications</a> </li>
                                        <?php if ($sprnumsrow
                                                > 0) { ?>
                                                <li class="nav-item "> <a class="nav-link text-uppercase" data-toggle="tab" href="#sparedetails">Spare Details</a> </li>
                                        <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-10 pl-0 pr-0 "> 

                                <!-- Tab panes -->
                                <div class="tab-content ">
                                    <div id="productdetails" class="tab-pane  active  ">
                                                        <?php include('inc-prod-info.php'); ?>
                                    </div>
                                    <div id="overView" class="tab-pane fade  ">
                                        <div class="row">
                                            <div class="col-lg-12 overView"> <?php
                                                        if (isset($prData['prod_overview'])
                                                                && $prData['prod_overview']
                                                                != '') {
                                                            echo $prData['prod_overview'];
                                                        } else {
                                                            ?> <strong class=" text-center d-block">No data available. </strong><?php } ?></div>
                                        </div>
                                    </div>
                                                                                <?php if (isset($_SESSION['u_id']) && $_SESSION['u_id'] != '') {?>
                                    <div id="crossRefrence" class="tab-pane fade">
                                        <?php
                                        $crossrefSql = "SELECT crossref_make,crossref_oem FROM rollco_ms_crossref WHERE rc_num='" . $prData['prod_part_no'] . "' AND  crossref_status=1 ORDER BY crossref_make ASC";

                                        $numsrow1 = $sq->numsrow($crossrefSql);
                                        if ($numsrow1 > 0) {
                                            $crData = $sq->query($crossrefSql);
                                            ?>
                                            <div class="col-lg-12 croRefe">
                                                <div class="table-responsive">
                                                    <table class="table text-center table-bordered table-sm">
                                                        <thead class="thead-dark">
                                                            <tr>
                                                                <th align="center" class="w-50">MANUFACTURER</th>
                                                                <th align="center">OEM</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="bg-light">
        <?php
        while ($cres = $sq->fetch($crData)) {
            ?>
                                                                <tr>
                                                                    <td><?php echo $cres['crossref_make']; ?></td>
                                                                    <td><?php echo $cres['crossref_oem']; ?></td>
                                                                </tr>
        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                                    <?php } else { ?>
                                            <strong class="text-center d-block">No data available.</strong>
                                                    <?php } ?>
                                    </div>
                                                                                <?php } ?>
                                    <div id="applications" class="tab-pane fade">
                                        <div class="table-responsive">
                                            <table class="table text-center table-bordered table-sm">
                                                <?php
                                                $spareSql = "SELECT make_nm,model_nm,year,cc FROM rollco_ms_application WHERE part_no='" . $prData['prod_part_no'] . "' GROUP BY make_nm,model_nm,year ORDER BY make_nm ASC,model_nm ASC,year ASC";
                                                $numsrow2 = $sq->numsrow($spareSql);
                                                if ($numsrow2 > 0) {
                                                    ?>
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>Make</th>
                                                            <th>Model</th>
                                                            <th>CC</th>
                                                            <th>Year</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-light">
                                                        <?php
                                                        $spData = $sq->query($spareSql);
                                                        while ($rs1 = $sq->fetch($spData)) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $rs1['make_nm']; ?></td>
                                                                <td><?php echo $rs1['model_nm']; ?></td>
                                                                <td><?php echo $rs1['cc']; ?></td>
                                                                <td><?php echo $rs1['year']; ?></td>
                                                            </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                    </tbody>    
                                                    <?php
                                                } else {
                                                    ?>
                                                    <tbody class="bg-light"><strong class="text-center d-block">No data available.</strong>
                                                    </tbody>
    <?php } ?>
                                            </table>
                                        </div>
                                    </div>


    <?php if ($sprnumsrow > 0) { ?>
                                        <div id="sparedetails" class="tab-pane fade">
                                            <div class="table-responsive">
                                                <table class="table text-center table-bordered table-sm">

                                                    <thead class="thead-dark">
        <?php /* ?>    <tr>
          <th>OEM</th>
          </tr> <?php */ ?>
                                                    </thead>
                                                    <tbody class="bg-light"><strong class="text-center d-block">No data available.</strong>
                                                    </tbody>
                                        <?php /* ?>   <tbody class="bg-light">
                                          <?php
                                          $spdetails = $sq->query($spareDetailsSql);
                                          while ($spresult = $sq->fetch($spdetails)) {
                                          ?>
                                          <tr>
                                          <td><?php echo $spresult['spare_oem']; ?></td>
                                          </tr>
                                          <?php
                                          }
                                          ?>
                                          </tbody>    <?php */ ?>

                                                </table>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center ml-0 mr-0">
                            <div class="col-lg-10 text-center pt-4">
                                <p class="mb-2 font14 text-danger">RECENTLY VIEWED</p>
                            </div>
                            <div class="col-lg-10 col-md-12 col-sm-12 col-12 pl-5 pt-2 bg-light mb-4 border-top alt120">
                                <div class="row">
                                                <?php
                                                $productSql = "SELECT prod_id FROM rollco_search_found WHERE sf_id != (SELECT MAX(sf_id) FROM rollco_search_found)";
                                                if (isset($_SESSION['u_id']) && $_SESSION['u_id']
                                                        > 0) {
                                                    $productSql .= " AND user_id>0 AND user_id=" . $_SESSION['u_id'] . "";
                                                } else {
                                                    $productSql .= " AND u_ip= '" . $_SERVER['REMOTE_ADDR'] . "' AND user_browser='" . $_SERVER['HTTP_USER_AGENT'] . "' AND user_platform='" . $plateform . "'";
                                                }
                                                $productSql .= "  ORDER BY prod_id  DESC limit 0,5";
                                                $numpr = $sq->numsrow($productSql);
                                                if ($numpr > 0) {
                                                    $mdata = $sq->query($productSql);
                                                    while ($mrs = $sq->fetch($mdata)) {

                                                        if ($mrs['prod_id'] > 0) {
                                                            $prSql = "SELECT prod_id,prod_nm,catid FROM rollco_ms_product where prod_id='" . $mrs['prod_id'] . "' and prod_status=1 ";

                                                            $numpr = $sq->numsrow($prSql);
                                                            if ($numpr > 0) {
                                                                $prdata = $sq->fearr($prSql);
                                                                $procatSql = "SELECT cat_nm FROM  rollco_ms_cat where cat_id='" . $prdata['catid'] . "'";
                                                                $numprcat = $sq->numsrow($procatSql);
                                                                if ($numprcat > 0) {
                                                                    $catdata = $sq->fearr($procatSql);
                                                                }
                                                            }
                                                            ?>
                                                <div class="col">
                                                    <a href="product-detail.php?rc_num=<?php echo $prdata['prod_nm']; ?>&type=search" class="active" ><h2 class="text-danger alt20">
                <?php
                if (isset($prdata['prod_nm']) && $prdata['prod_nm'] != '') {
                    echo $prdata['prod_nm'];
                }
                ?>
                                                        </h2></a>
                                                    <p>
                <?php
                if (isset($catdata['cat_nm']) && $catdata['cat_nm'] != '') {
                    echo $catdata['cat_nm'];
                }
                ?>
                                                    </p>
                                                </div>
                <?php
            }
        }
    } else {
        ?>
                                        <strong class="text-center col-md-12">No recently view products. </strong>
        <?php
    }
    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center ml-0 mr-0">
                            <div class="col-lg-10 bg-warning pl-5 pr-5 pt-3 pb-4 mb-4">
                                <div class="row justify-content-center">
                                    <div class="col-lg-10 col-md-10 col-sm-12 col-12 pl-0 pr-0">
                                        <div class="row justify-content-between ">
                                            <div class="col-sm-12 col-12 col-lg-4 text-center">
                                                <h4 class="text-white font14 font-weight-bold">FAQ'S</h4>
                                                <div class=" bg-white p-2"> <a href="support.php?faq">
                                                        <p class="m-0 font14 text-danger"> QUOTES<br>
                                                            SHIPPING COST<br>
                                                            TECH SUPPORT</p>
                                                    </a> </div>
                                            </div>
                                            <div class="col-sm-12 col-12 col-lg-4 text-center">
                                                <h4 class="text-white font14 font-weight-bold">ORDER</h4>
                                                <div class=" bg-white p-2">
                                                    <p class="font14 text-danger mb-2 ">CONTACT US</p>
                                                    <p class="m-0 font14 text-danger"> +44 1268 271035</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-12 col-lg-4 text-center clearfix">
                                                <h4 class="text-white font14 font-weight-bold">NEWSLETTERS</h4>
                                                <h5 class="text-white font12 font-weight-bold newsmessg"></h5>
                                                <div class=" bg-white p-2 clearfix">
                                                    <p class="mb-2 font8 text-danger">SUBSCRIBE TO OUR NEWS AND GET LATEST DISCOUNTS!</p>
                                                    <form name="newsletterform" id="newsletterform" method="post" >
                                                        <div class="input-field">
                                                            <input type="email" name="newsletter" id="newsletter" class="bg-light" placeholder="">
                                                            <input id="sbtnSubmit" class="bntc bg-danger border-danger newsletterbutton" type="submit" name="submit" value="SUBSCRIBE">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
    <?php
} else if ($pr_status == 0) {
    echo "<script>alert('No product found!');window.history.back();</script>";
} else if ($sp) {
    include 'spare-detail.php';
}
?>
        </section>

        <!-- The Modal --> 

        <!-- The Modal -->
        <div class="modal " id="mySparDeat">
            <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content"> 

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h3 class="modal-title">Spare Details</h3>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="sparemodalajax"> 
                        <!-- Modal body --> 

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>


        </script>
<?php include("inc-footer.php"); ?>
<!--<script src="Zoomple-master/zoomple.js" type="text/javascript"></script>--> 
        <script src="magnify/js/jquery.magnify.js" type="text/javascript"></script> 
        <script>


            //            $('.zoomple').zoomple({ 
            //		    blankURL : 'images/loader.svg',
            //                    bgColor : '#90D5D9',
            //                    loaderURL : 'images/loader.svg',
            //                    offset : {x:-250,y:-250},
            //                    zoomWidth : 300,  
            //                    zoomHeight : 300,
            //                    roundedCorners : true
            //		});


            $('#newsletterform').validate({// initialize the plugin
                rules: {
                    'newsletter': {
                        required: true,
                        email: true,
                    },

                },
            });

            $('#newsletterform').on('submit', function (e) {
                if ($("#newsletterform").valid()) {
                    e.preventDefault();
                    $('.newsmessg').html('');
                    $.ajax({
                        type: 'post',
                        url: "ajax/addnewsletter.php",
                        data: $('#newsletterform').serialize(),
                        success: function (data) {
                            $('.loading').hide();
                            var data = JSON.parse(data);
                            if (data.status > 0) {
                                $('.newsmessg').html(data.data);
                                $('.newsmessg').delay(5000).fadeOut('slow');
                            }
                            if (data.status == '1') {
                                $('#newsletter').val('');
                            }
                        }
                    });
                }
            });

            $(document).ready(function () {
                $('.compare-btn').show();
                $('#slideshow_image').magnify({

                    // URI of the large image
                    'src': '',

                    // fade in/out speed
                    'speed': 100,

                    // timeout for mobile
                    'timeout': -1,

                    // Vertical touch point offset. Set this to something like 90 if you want to avoid your finger getting in the way of the magnifying lens on smartphones and tablets.
                    'touchBottomOffset': 0,

                    // Width of the main image
                    'finalWidth': null,

                    // Height of the main image
                    'finalHeight': null,

                    // Width of the image displayed inside the magnifying lens
                    'magnifiedWidth': 600,

                    // Height of the image displayed inside the magnifying lens
                    'magnifiedHeight': 600,

                    // Set this to true to keep the edge of the image within the magnifying lens
                    'limitBounds': false,

                    // Custom event to fire when you tap on the mobile close button. 
                    // Set this to 'click' or 'touchend' if it's conflicting with another event handler. 
                    // This option is only applicable when the mobile plugin (jquery.magnify-mobile.js) is used.
                    'mobileCloseEvent': 'touchstart',

                    // callbacl
                    'afterLoad': function () {}

                });
                $("#flip").click(function () {
                    $("#panel").slideToggle("slow");
                });
                $(document).on("click", '.addToComp', function () {
                    $(".comparButton").show();
                    $.ajax({
                        type: 'post',
                        url: "ajax/addToCompare.php",
                        data: {'prod_part': $(this).data('prod_part')},
                        success: function (data) {
                            $('.loading').hide();
                            var data = JSON.parse(data);
                            if (data.success == 1) {
                                $('.addTocompar').removeClass('displayNone');
                                $('.comp-msg').html('<p>Product added for compare</p>');
                                $('.comp-msg').show();
                                setTimeout(function () {
                                    $('.comp-msg').fadeOut('fast');
                                }, 4000);
                                var counttext = 0;
                                if ($('.countComp').text().trim() != '') {
                                    counttext = $('.countComp').text().replace('(', '');
                                    counttext = parseInt(counttext.replace(')', ''));
                                } else {
                                    counttext = 0;
                                }
                                counttext = counttext + 1;


                                $('.countComp').html('(' + counttext + ')');
                                if (data.prod_no == 1) {
                                    $('.compProd1').text(data.prod_part);
                                    $('.compProd1').fadeIn();
                                    $('#compProd1').removeClass('displayNone');
                                } else if (data.prod_no == 2) {
                                    $('.compProd2').text(data.prod_part);
                                    $('.compProd2').fadeIn();
                                    $('#compProd2').removeClass('displayNone');
                                } else if (data.prod_no == 3) {
                                    $('.compProd3').text(data.prod_part);
                                    $('.compProd3').fadeIn();
                                    $('#compProd3').removeClass('displayNone');
                                }

                                if (counttext >= 2) {
                                    console.log('if');
                                    $('.goToCompare').removeClass('displayNone');
                                    $('.compare-btn').show();
                                } else {
                                    console.log('else');
                                    $('.compare-btn').hide();
                                }
//                                window.setTimeout(function () {
//                                    location.reload()
//                                }, 3000)
                                show_compare();
                            } else if (data.success == 2) {
                                $('.comp-msg').html('<p>No product added for compare</p>');
                                $('.comp-msg').show();
                                setTimeout(function () {
                                    $('.comp-msg').fadeOut('fast');
                                }, 4000);
                                show_compare();
                            } else if (data.success == 3) {
                                $('.comp-msg').html('<p>Product already added for compare</p>');
                                $('.comp-msg').show();
                                setTimeout(function () {
                                    $('.comp-msg').fadeOut('fast');
                                }, 4000);
                            } else if (data.success == 4) {
                                $('.comp-msg').html('<p>You can add only 3 products for compare.</p>');
                                $('.comp-msg').show();
                                setTimeout(function () {
                                    $('.comp-msg').fadeOut('fast');
                                }, 4000);
                            }


                            $(".addTocompar").removeClass('disableComp');
                        }
                    });
                });





            });

            //
            function show_compare() {
                $.ajax({
                    type: 'get',
                    url: "ajax/show_compare.php",
                    success: function (data) {
                        $("#panel").html(data);
                    }
                });
            }

            $(document).on("click", '.close', function () {
                $("#panel").slideUp();
                var part = $(this).parents('p').data('prod_part');
                $.ajax({
                    type: 'post',
                    url: "ajax/removeFromCompare.php",
                    data: {'prod_part': part},
                    success: function (data) {
                        $('.loading').hide();
                        var data = JSON.parse(data);
                        if (data.success == 1) {
                            console.log(data);
                            if (data.proCount === 0) {
                                $('.countComp').html('');
                            } else {
                                $('.countComp').html('(' + data.proCount + ')');
                            }

                            if (data.proCount >= 2) {
                                $('.compare-btn').show();
                            } else {
                                $('.compare-btn').hide();
                            }

                            $('.cprod' + data.prod_no).parents('p').fadeOut();
                            if (data.proCount == 0) {
                                $('.addTocompar').addClass('displayNone');
                            } else {
                                show_compare();
                            }

//                            window.setTimeout(function () {
//                                location.reload()
//                            }, 3000)
                        } else if (data.success == 2) {
                            $('.comp-msg').html('<p>Product not removed</p>');
                        }
                    }
                });
                //                $(this).parents('p').fadeOut();
            });

            // Write all the names of images in slideshow
            var images = [];
<?php if ($pro) { ?>
                var page = "product";
                $.ajax({
                    type: 'post',
                    url: "ajax/returnAllProdImages.php",
                    data: {'prod_id': $('#prod_id').val()},
                    success: function (data) {
                        $('.loading').hide();
                        var data = JSON.parse(data);
                        if (data.success == 1) {
                            $(data.imageArr).each(function (i, item) {
                                images.push(item.prod_img1);
                                images.push(item.prod_img2);
                                images.push(item.prod_img3);
                                images.push(item.prod_img4);
                                images.push(item.prod_img5);
                                images.push(item.prod_img6);
                                images.push(item.prod_img7);
                                images.push(item.prod_img8);
                            })
                        }
                    }
                });
<?php } else if ($sp) { ?>
                var page = "spare";
                $.ajax({
                    type: 'post',
                    url: "ajax/returnAllSpareImages.php",
                    data: {'spr_id': $('#prod_id').val()},
                    success: function (data) {
                        $('.loading').hide();
                        var data = JSON.parse(data);
                        if (data.success == 1) {
                            $(data.imageArr).each(function (i, item) {
                                images.push(item.spare_img1);
                                images.push(item.spare_img2);
                                images.push(item.spare_img3);
                                images.push(item.spare_img4);
                                images.push(item.spare_img5);
                                images.push(item.spare_img6);
                                images.push(item.spare_img7);
                                images.push(item.spare_img8);
                            })
                        }
                    }
                });
<?php } ?>
            $(document).ready(function () {
                $("#product_image_left_button").click(function () {
                    prev();
                });
                $("#product_image_right_button").click(function () {
                    next();
                });
            });



            function prev()
            {
                $('#slideshow_image').hide();
                var prev_val = document.getElementById("img_no").value;
                var prev_val = Number(prev_val) - 1;
                if (prev_val <= -1)
                {
                    prev_val = images.length - 1;
                }
                $('#slideshow_image').attr('src', '../upload/' + page + '/' + images[prev_val]);
                $('#slideshow_image').attr('data-magnify-src', '../upload/' + page + '/' + images[prev_val]);
                $('#slideshow_image').parents().find('.magnify-lens').css("background-image", "url(../upload/" + page + "/" + images[prev_val] + ")");
                document.getElementById("img_no").value = prev_val;

                $('#slideshow_image').show();
            }

            function next()
            {
                $('#slideshow_image').hide();
                var next_val = document.getElementById("img_no").value;
                var next_val = Number(next_val) + 1;
                if (next_val >= images.length)
                {
                    next_val = 0;
                }
                $('#slideshow_image').attr('src', '../upload/' + page + '/' + images[next_val]);
                $('#slideshow_image').attr('data-magnify-src', '../upload/' + page + '/' + images[next_val]);
                $('#slideshow_image').parents().find('.magnify-lens').css("background-image", "url(../upload/" + page + "/" + images[next_val] + ")");
                document.getElementById("img_no").value = next_val;
                $('#slideshow_image').show();
            }
        </script> 
        <script>
            $('.vehicLook input').focus(function () {
                $('.bntc').addClass('red');
            }).blur(function () {
                $('.bntc').removeClass('red');

            });


        </script>
    </body>
</html>
