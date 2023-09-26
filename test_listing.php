<?php include("class/config.php"); ?>
<!doctype html>
<html>
    <head>
        <?php include("inc-head.php"); ?>
    </head>

    <body>
        <?php include("inc-header.php"); ?>
        <section class="clearfix cataloGue">
            <article class="clearfix aos-item" data-aos='fade-up'>
                <div class="container mob-pad">
                    <div id="cataloGue" class="position-relative text-center subHead"> <img src="images/catalogue.jpg"  alt="banner" class="img-fluid w-100">
                        <div class="position-absolute">
                            <h2>ROLLCO AS YOUR <hr>        
                            </h2>
                            <div class="clearfix"></div>
                            <h2>  FIRST CHOICE
                                <hr>  
                            </h2>
                        </div>
                    </div>
                </div>
            </article>
            <?php include 'test_search-module.php'; ?>
            <article class=" pt-5 clearfix padB200 aos-item findMain listmb" data-aos='fade-up'>
                <div class="container ">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-12 text-center">
                            <p class="font16 mb-4">Rollco offers more than 30,000 different replacement parts for over 70 listed vehicle manufacturers . It provides
                                tailored aftermarket solutions to protect, clean, restore and personalize its customer’s vehicles. With high quality
                                products, customized marketing solutions and a customer focused team, ROLLCO gives you the tools, products
                                and the support you need to drive your aftermarket performance.</p>
                            <p class="font16 mb-5"> ROLLCO is in a process of continuous development. This includes the scheduled expansion of the existing product,
                                lining up to the full-range provider as well as the short-term implementation of new program lines.</p>
                        </div>
                    </div></div>
                    
                   <div class="container mob-pad"> 
                    <div class="row justify-content-center ml-0 mr-0 mb-0 mb-md-5 findYour">
                        <div class="col-12 pl-5 pr-5 pt-5 bg-light pb-3 pb-md-0">
                            <h2 class="text-danger font-weight-normal pb-4 text-center">FIND YOUR WAY TO OUR PRODUCTS</h2>

                            <div class="row justify-content-center  findRow">
                                <div class="col-xl-10 col-md-11 col-sm-12 col-12">
                                    <div class="row justify-content-center ml-0 mr-0">

                                        <?php
                                        $mcatsql = "SELECT mcat_id,mcat_nm,mcat_image FROM rollco_ms_mcat WHERE mcat_status = 1 order by morder asc ";
                                        $mnumrow = $sq->numsrow($mcatsql);

                                        if ($mnumrow > 0) {
                                            $mdata = $sq->query($mcatsql);

                                            while ($mrs = $sq->fetch($mdata)) {
                                                ?>
                                                <div class="col-lg-4 col-sm-6 col-12 findCol pb-5">
                                                    <div class="row bg-white d-flex m-0 border-bottom pt-2 pb-2 m-auto">
                                                        <div class="d-flex align-items-start flex-column  mt-3  subHead ourProduct electRoll  w-100">
  <div class="imgTop"> <img src="../upload/mcat/<?php echo $mrs['mcat_image']; ?>" alt="<?php echo $mrs['mcat_nm']; ?>" class="imgDetails topTuch" > </div>
  <div class="col mb-auto">
  <h6><?php echo strtoupper($mrs['mcat_nm']); ?></h6>
  </div>
  <?php
                                                            $catSql = "SELECT cat_nm,cat_id FROM rollco_ms_cat WHERE mcatid='" . $mrs['mcat_id'] . "' LIMIT 3";
                                                            $ctnums = $sq->numsrow($catSql);
                                                            ?>
  <div class="electLink ">
    <?php
                                                            if ($ctnums > 0) {
                                                                $ctData = $sq->query($catSql);
                                                                while ($rscat = $sq->fetch($ctData)) {
                                                                    ?>
    <div class="col-lg-12 "> <a href="product-review-page.php?mcat=<?php echo $mrs['mcat_id'];?>&cat=<?php echo $rscat['cat_id']; ?>"> <?php echo $rscat['cat_nm']; ?> </a> </div>
    <?php }
        }else {  ?>
    <div class="col-lg-12"> <a href="#" class="noLink"> NO SPARE <span class="d-block"> PARTS available </span> </a> </div>
    <?php } ?>
  </div>
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
                    </div>

                </div>
            </article>
<?php include("inc-footer.php"); ?>