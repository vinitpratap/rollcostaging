<article class=" clearfix aos-item  faqOrdNews pt-5" data-aos='fade-up'>
    <div class="container">
        <div class="row pt-3 justify-content-center">
            <div class="col-md-10  mb-5">
                <div class="row">
                    <div class="col-lg-5 pt-5" id="slider">
                        <input type="hidden" id="prod_id" value="<?php echo $spData['spare_id']; ?>">
                        <input type="hidden" id="u_id" value="<?php echo $_SESSION['u_id']; ?>">
                        <div id="slide_cont" class="bg-light border prod_image_div">  
                                            <?php
                                                if (isset($spData['spare_img1']) && $spData['spare_img1']
                                                        != '') {
                                                    ?>  
                                           
<img src="../upload/spare/<?php echo $spData['spare_img1'];?>" id="slideshow_image" data-magnify-src="../upload/spare/<?php echo $spData['spare_img1'];?>"> 
                                             <?php } else { ?>
                                            <img src="../upload/no-image.png" alt="" class="img-fluid"/>
                                             <?php
                                                }
                                                
                                                    ?>
                                              
                                        </div>
                                         <input type="hidden" id="img_no" value="0">
                                                                                    <?php
                                                if (isset($spData['spare_img1']) && $spData['spare_img1']
                                                        != '') {
                                                    ?>
                                         <button id="product_image_left_button" class="btn btn-danger image-prev mt-2 " data-currimg="prodimg_1" data-prev="1" data-next="0"><img src="images/left-arr.svg"/></button>
                                         <button id="product_image_right_button" class="btn btn-danger image-next mt-2"  data-currimg="prodimg_1" data-prev="0" data-next="1"><img src="images/right-arr.svg"/></button>
                                           <?php } ?>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-sm-6">
                        <div class="row pt-5">
                            <div class="col-12 altern">
                                <h3 class="text-uppercase text-black-50"> <span class="d-block text-danger"><?php echo $spData['spare_nm']; ?></span> 
                                    <hr class="mb-2 ">
                                </h3>
                                <p class="pt-2 text-uppercase text-black-50 font-weight-normal">Availability: <?php
                                    if ($spData['spare_avail'] == 1)
                                            echo "In Stock";
                                    else echo "Out of Stock";
                                    ?></p>
                            </div>
                            <?php
                            if (isset($_SESSION['u_id']) && $_SESSION['u_id'] != '') {
                                $priceSql = "SELECT grpro.pr_price,grp.gr_currency FROM rollco_ms_grproduct as grpro INNER JOIN rollco_ms_group as grp on grp.gr_id = grpro.gr_id  WHERE grpro.gr_id = '" . $_SESSION['g_id'] . "' AND grpro.part_nm='" . $spData['spare_part_no'] . "' LIMIT 1";
                                $numsrow = $sq->numsrow($priceSql);
                                if ($numsrow > 0) {
                                    $pData = $sq->fearr($priceSql);
                                    ?>
                                    <div class="col-12 pt-5">
                                        <h3 class="font-weight-600 text-danger"> <?php echo getCurrSym($pData['gr_currency']); ?> <span id="sp_base_amnt"><?php echo $pData['pr_price']; ?></span></h3>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            <?php if ($spData['spare_avail']
                                    != 1) {
                                ?>
                                <div class="col-12 pt-2"> 
    <!--                                <a href="#" class="mr-2"><img src="images/reload.svg" alt="" class="img-fluid" width="31"></a>-->
                                    <a href="enquire-now.php"><img src="images/email3.png" alt="" class="img-fluid"  width="31"></a> 

                                </div>
<?php } ?>
                        </div>
                    </div>

                    <?php
                    if (isset($_SESSION['u_id']) && $_SESSION['u_id'] != '' && $spData['spare_avail']
                            == 1) {

                        $priceSql = "SELECT grpro.pr_price,grp.gr_currency FROM rollco_ms_grproduct as grpro INNER JOIN rollco_ms_group as grp on grp.gr_id = grpro.gr_id  WHERE grpro.gr_id = '" . $_SESSION['g_id'] . "' AND grpro.part_nm='" . $spData['spare_part_no'] . "' LIMIT 1";
                        $numsrow = $sq->numsrow($priceSql);
                        if ($numsrow > 0 || $_SESSION['customerID'] == 'Temp') {
                            $pData = $sq->fearr($priceSql);
                            $_SESSION['usr_curr'] = getCurrSym($pData['gr_currency']);
                            ?>
                            <div class="col-xl-3 col-lg-3 col-sm-6 ml-auto faqOrdTot pt-5">
                                <div class="row  bg-danger">
                                    <div class="col-12 pt-4">
                                        <p class="font18 text-white">Total: <strong class="font28 roll_prod_price"><?php echo getCurrSym($pData['gr_currency']); ?><span id="sp_amnt"> <?php if( $_SESSION['customerID'] == 'Temp') echo '0.00'; else echo $pData['pr_price']; ?></span></strong> </p> 
                                    </div>
                                    <div  class="qty col-12 pb-4">
                                        <button type="button" id="spsub" class="sub">-</button>
                                        <input type="text" id="spcart_quan_val" value="1" class="field" />
                                        <button type="button" id="spadd" class="add">+</button>
                                    </div>
                                    <div class="col-10">
                                        <p class="font12 text-white">Item will Ship in Approx. 2-4
                                            Business Days </p>
                                    </div>
                                    <div class="col-12 pt-5">
                                        <p class="font12 text-white"> Looking for Greater Quantities? </p>
                                    </div>
                                    <div class="col-10 pb-3"> <a href="#" id="spbutAddTo" class="font14 butAddTo "> ADD TO CART > </a> </div>
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
<article class="clearfix padB200 aos-item faqOrdNews" data-aos='fade-up'>
    <div class="container">
        <div class="row  pt-3 justify-content-center mr-0 ml-0 navTabs">
            <div class="col-lg-10  pt-3 pb-2  mb-4 border-top alt120 border-bottom border-danger">
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs nav-justified " >
                            <li class="nav-item   "> <a class="nav-link text-uppercase active" data-toggle="tab" href="#productdetails">SPARE DETAILS</a> </li>
                            <li class="nav-item "> <a class="nav-link text-uppercase" data-toggle="tab" href="#oeNumbers">Servicing Numbers</a> </li>
                            <li class="nav-item "> <a class="nav-link text-uppercase" data-toggle="tab" href="#Component_OEM_Numbers">Component OEM Numbers</a> </li>
                        </ul>
                    </div>


                </div>
            </div>


            <div class="col-lg-10 pl-0 pr-0 ">

                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="productdetails" class="tab-pane  active">
                        <table class="table text-center table-bordered table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="w-50">INFORMATION</th>
                                    <th>DATA</th>
                                </tr>
                            </thead>
                            <tbody class="bg-light">
                                <tr>
                                    <td>Description</td>
                                    <td><?php echo $spData['spare_desc']; ?></td>
                                </tr>
<?php if (isset($spData['spare_part_no'])) { ?>
                                    <tr>
                                        <td>Part number</td>
                                        <td><?php echo $spData['spare_part_no']; ?></td>
                                    </tr>
<?php } ?>
<?php if (isset($spData['spare_add_inf'])) { ?>
                                    <tr>
                                        <td>Additional Info</td>
                                        <td><?php echo $spData['spare_add_inf']; ?></td>
                                    </tr>
<?php } ?>  
                            </tbody>
                        </table>

                    </div>
                    <div id="oeNumbers" class="tab-pane fade">
                        <div class="row">
                            <div class="col-lg-4 croRefe">
                                <?php /*?><h3>Servicing Numbers</h3><?php */?>
                                <div class="table-responsive">
                                    <table class="table text-center table-bordered table-sm">
<?php 
$spareSql = "SELECT ss.srvs_num FROM rollco_ms_spare AS s INNER JOIN rollco_ms_spearservice as ss ON ss.spare_num = s.spare_part_no INNER JOIN rollco_ms_product as p ON p.prod_part_no = ss.srvs_num WHERE s.spare_id='" . $spData['spare_id'] . "' GROUP BY ss.srvs_num ";
$numsrow2 = $sq->numsrow($spareSql);
if ($numsrow2 > 0) {
?>
                                        <thead class="thead-dark">
                                            <tr>
                                                <th align="center" class="w-50">Servicing Numbers</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-light">
                                            <?php
                                                $spData1 = $sq->query($spareSql);
                                                while ($rs1 = $sq->fetch($spData1)) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $rs1['srvs_num']; ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                                ?>
                                                    </tbody>
                                                    <?php 
                                            }else {
                                                    ?>
                                                            <tbody class="bg-light"><strong class="text-center d-block">No data available.</strong>
                                                    
                                        </tbody>
<?php } ?>                                        
                                        
                                    </table>
                                </div>
                            </div>

                        </div>   


                    </div>

                    <div id="Component_OEM_Numbers" class="tab-pane fade">
                        <div class="row">
                            <div class="col-lg-4 croRefe">
                                <?php /*?><h3>Component OEM Numbers</h3><?php */?>
                                <div class="table-responsive">
                                    <table class="table text-center table-bordered table-sm">
                                        
<?php 
$spareSql1 = "SELECT so.oem_num FROM rollco_ms_spare AS s INNER JOIN rollco_ms_spearoem as so ON so.spare_num = s.spare_part_no WHERE s.spare_id='" . $spData['spare_id'] . "' ";
$numsrow3 = $sq->numsrow($spareSql1);
if ($numsrow3 > 0) {
?>                                        
                                        <thead class="thead-dark">
                                            <tr>
                                                <th align="center" class="w-50">Component OEM Numbers</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $spData1 = $sq->query($spareSql1);
                                                while ($soem = $sq->fetch($spData1)) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $soem['oem_num']; ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                   </tbody> 
                                                    <?php 
                                            }else {
                                                    ?>
                                                            <tbody><strong class="text-center d-block">No data available.</strong>
                                        </tbody>
                                                    <?php } ?>
                                    </table>
                                </div>
                            </div>

                        </div>   


                    </div>

                </div>
            </div>
        </div>
        <div class="row justify-content-center ml-0 mr-0">
            <div class="col-lg-10 text-center pt-4">
                <p class="mb-2 font14 text-danger">RECENTLY VIEWED </p>
            </div>
            <div class="col-lg-10 col-md-12 col-sm-12 col-12 pl-5 pt-2 bg-light mb-4 border-top alt120">
                                <div class="row">
                                    <?php
                                    $productSql = "SELECT prod_id FROM rollco_search_found WHERE sf_id != (SELECT MAX(sf_id) FROM rollco_search_found) ORDER BY prod_id  DESC limit 0,5";
                                    $numpr = $sq->numsrow($productSql);
                                    if ($numpr > 0) {
                                        $mdata = $sq->query($productSql);
                                        while ($mrs = $sq->fetch($mdata)) {

                                            if ($mrs['prod_id'] > 0) {
                                                $prSql = "SELECT prod_id,prod_nm,catid FROM rollco_ms_product where prod_id='" . $mrs['prod_id'] . "'";
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
                                                    <h2 class="text-danger alt20">
                                                        <?php
                                                        if (isset($prdata['prod_nm']) && $prdata['prod_nm'] != '') {
                                                            echo $prdata['prod_nm'];
                                                        }
                                                        ?>
                                                    </h2>
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
                                    }
                                    ?>
                                </div>
                            </div>
        </div>


        <div class="row justify-content-center ml-0 mr-0">
            <div class="col-lg-10 bg-warning pl-5 pr-5 pt-3 pb-4 mb-4">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-md-12 col-sm-12  pl-0 pr-0">
                        <div class="row justify-content-between ">
                            <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                                <h4 class="text-white font14 font-weight-bold">FAQ'S</h4>
                                <div class=" bg-white p-2">
                                    <p class="m-0 font14 text-danger"> QUOTES<br>
                                        SHIPPING COST<br>
                                        TECH SUPPORT</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                                <h4 class="text-white font14 font-weight-bold">ORDER</h4>
                                <div class=" bg-white p-2">
                                    <p class="font14 text-danger mb-2 ">CONTACT US</p>
                                    <p class="m-0 font14 text-danger"> +44 1268 271035</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 text-center clearfix">
                                <h4 class="text-white font14 font-weight-bold">NEWSLETTERS</h4>
                                <div class=" bg-white p-2 clearfix">
                                    <p class="mb-2 font8 text-danger">SUBSCRIBE TO OUR NEWS AND GET LATEST DISCOUNTS!</p>
                                    <form name="newsletterform" id="newsletterform" method="post" >
                                    <div class="input-field">
                                        <input type="email" name="email_id" id="email_id" class="bg-light" placeholder="">
                                        <input id="sbtnSubmit" class="bntc bg-danger border-danger" type="submit" name="submit" value="SUBSCRIBE">
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


