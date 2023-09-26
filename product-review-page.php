<?php include("class/config.php"); ?>
<!doctype html>
<html>
    <head>
        <?php include("inc-head.php"); ?>
    </head>

    <body>
        <?php include("inc-header.php"); ?>

        <?php
        if (isset($_GET['mcat']) && isset($_GET['cat'])) {
            $mcatId = stripslashes(trim($_GET['mcat']));
            $catId = stripslashes(trim($_GET['cat']));
            $mcatDetails = getMcatDetails($mcatId);
            if (!$mcatDetails)
                echo "<script>alert('No Information found!');window.history.back();</script>";

            $catDetails = getCatDetails($catId);
            if (!$catDetails)
                echo "<script>alert('No Information found!');window.history.back();</script>";
        } else {
            ?>
        <?php } ?>
        <section class="clearfix cataloGue">
            <article class="clearfix aos-item electheare" data-aos='fade-up'>
                <div class="container mob-pad">
                    <div id="cataloGue" class="position-relative text-center subHead"> <img src="../upload/mcat/<?php echo $catDetails['cat_image']; ?>"  alt="category-banner" class="img-fluid w-100">
                        <div class="position-absolute text-left pl-5">
                            <h2 class="text-danger pt-3 "><?php echo $mcatDetails['mcat_nm']; ?> 
                                <hr>
                            </h2>
                            <span class="d-block pb-4 font12 text-white pl-3"><?php echo $catDetails['cat_nm']; ?> </span>

                            <div class="clearfix"></div>
                            <h2 class="pt-5 alwa"><?php echo $catDetails['cat_headinglines']; ?></h2>
                        </div>
                    </div>
                </div>
            </article>
            <?php include 'search-module.php'; ?>
            <article class=" pt-5 clearfix padB200 aos-item rollco-alternator" data-aos='fade-up'>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-8 ">
                            <h3 class="text-danger font18">ROLLCO <?php echo $catDetails['cat_nm']; ?>  – SIMPLY DON'T FAIL.</h3>
                            <p class="font16 mb-4"> <?php echo $catDetails['cat_detail']; ?> </p>


                        </div>


                    </div>
                </div>    
                <div class="container mob-pad overflow-hidden">
                    <div class="row justify-content-center  mb-5 mt-3">
                        <div class="col-12 col-lg-11 ">
                            <div class="row justify-content-center bg-light ml-0 mr-0 d-flex ">
                                <div class="col-lg-8 col-md-8 col-sm-8 col-12 align-self-center subcat_detls">
                                    <?php echo stripslashes($catDetails['cat_catlog']); ?>

                                </div>
                                <div class="col-12 col-lg-4 col-md-4 col-sm-4 text-right pr-0"> <img src="../upload/mcat/<?php echo $catDetails['cat_simage']; ?>"class="prd_grimg img-fluid" alt="<?php echo $catDetails['cat_nm']; ?>"></div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="container mob-pad overflow-hidden">
                    <div class="row justify-content-center ml-0 mr-0 mt-5 mb-0 downlCent">
                        <div class="col-lg-8  col-md-10 col-sm-12">
                            <div class="row justify-content-center">
                                <?php
//                                    $data = $sq->query($prodSql);
//                                    while ($rs = $sq->fetch($data)) {
//                            
                                ?>
                                <div class="col-lg-4 col-md-4 col-sm-6  pt-4 text-center  ">
                                    <span class="d-block pb-3">
<?php
$ctbrnm=trim($catDetails['cat_brochure']);
if (isset($ctbrnm) && $ctbrnm!='') $fullURLs='../upload/catalogues/'.$ctbrnm;
else $fullURLs='#';
?>                                    
                                    <a <?php if($fullURLs!='#') echo 'target="_blank"';?> href="<?php echo $fullURLs; ?>" <?php /*?>download<?php */?>><img src="../upload/mcat/<?php echo $catDetails['cat_bimg']; ?>" class="img-fluid" alt=""></a></span>

                                    <h6 class="text-danger font16 pb-2"> <?php echo $rs['cat_title']; ?></h6>
                                    <p class="font16">Here you will find all the information<br>
                                        about <?php echo $catDetails['cat_nm']; ?>S range.</p>

                                </div>

                                <?php
//                                    }
                                ?>
                            </div>
                        </div>

                    </div>


                    <?php
                    $prodSql = "SELECT prod_part_no,prod_img1 FROM rollco_ms_product where prod_id > 0 AND mcatid='" . $mcatId . "' AND catid='" . $catId . "' AND prod_img1 !='' AND prod_img1 IS NOT NULL GROUP BY prod_part_no ORDER BY created_at desc LIMIT 4 ";
                    $numrows = $sq->numsrow($prodSql);

                    if ($numrows > 0) {
                        ?>
                    </div>
                    <div class="container">
                        <div class="row  my-style justify-content-center mb-0 mb-md-2 pt-5">
                            <div class="col-lg-8 col-md-10 col-sm-12">
                                <div class="row justify-content-center">
                                    <?php
                                    $data = $sq->query($prodSql);
                                    while ($rs = $sq->fetch($data)) {
                                        if (isset($rs['prod_img1']) && $rs['prod_img1'] != '') {
                                            ?>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-6 mb-4">
                                                <a  href="product-detail.php?rc_num=<?php echo $rs['prod_part_no']; ?>&type=search" >
                                                    <div class="border-danger border w-100 text-center"> 
                                                        <?php
                                                        if (isset($rs['prod_img1'])) {
                                                            if (file_exists($cpath . 'upload/product/' . $rs['prod_img1'])) {
                                                                ?>
                                                                <img src="../upload/product/<?php echo $rs['prod_img1']; ?>" class="img-fluid" alt="<?php echo $rs['prod_part_no'] ?>"></div>
                                                        <?php } else { ?>
                                                            <img src="../upload/no-image.png" class="img-fluid" alt="FOR THE VS BRAND"></div>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
<div align="center"><?php echo $rs['prod_part_no'] ?></div>

                                                </a>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                </div></div>
                        <?php } ?>
                    </div>


                </div>



                </div>

                </div>
            </article>
            <?php include("inc-footer.php"); ?>

    </body>
</html>