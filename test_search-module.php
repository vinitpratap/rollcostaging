<?php
//print_r($ecId);
////print_r($_REQUEST);
//if (isset($_POST['roll_product'])) {
//    $prVal = splitIdAndText($_POST['roll_product']);
//    $prId = $prVal['id'];
//    $prText = $prVal['text'];
//}
//
//if (isset($_POST['roll_make'])) {
//    $mkVal = splitIdAndText($_POST['roll_make']);
//    $mkId = $mkVal['id'];
//    $mkText = $mkVal['text'];
//}
//
//if (isset($_POST['roll_model'])) {
//    $modVal = splitIdAndText($_POST['roll_model']);
//    $modId = $modVal['id'];
//    $modText = $modVal['text'];
//}
//
//if (isset($_POST['roll_year'])) {
//    $yrVal = splitIdAndText($_POST['roll_year']);
//    $yrId = $yrVal['id'];
//    $yrText = $yrVal['text'];
//}
//
//
//
//if (isset($_POST['roll_exact_ccm']) && trim($_POST['roll_exact_ccm'])!='') {
//    $ccmVal = splitIdAndText($_POST['roll_exact_ccm']);
//    $ccmId = $ccmVal['id'];
//    $ccmText = $ccmVal['text'];
//}
//
//if (isset($_POST['roll_engine_code']) && trim($_POST['roll_engine_code']) !='') {
//    $ecVal = splitIdAndText($_POST['roll_engine_code']);
//    $ecId = $ecVal['id'];
//    $ecText = $ecVal['text'];
//}


$class = '';
if (isset($_SESSION['u_id']) && $_SESSION['u_id'] != '') {
    $class = '';
} else {
    $class = 'active';
}

//$productSql = "select ";
?>
<div id="stickyHeader1"></div>
<article class="clearfix rollcoPartsf topHeader1" >
    <div class="container mob-pad">
        <div class="bg-dark prodheight pt-4 pb-4">
            <div class="row justify-content-center mr-0 ml-0">
                <div class="col-lg-10 pl-0 col-md-12 col-sm-12 col-12">
                    <div class="row justify-content-center mr-0 ml-0">
                        <div class="col-lg-4 pl-0 col-sm-12 col-md-4 col-12 rollcoPartLe">
                            <h1 class="text-danger h2"> ROLLCO PARTSFINDER</h1>
                            <h2 class="pt-5 h3 font-weight-normal text-white"> FIND THE 
                                RIGHT PART <strong class="d-block">FOR YOUR VEHICLE</strong></h2>
                        </div>
                        <div class="col-lg-8 pr-0  col-sm-12  col-md-8 col-12  mt-5 rollcoPartRi  ">
                            <ul class="nav nav-tabs d-flex bg-light" id="myTab1">
                                <li class="nav-item col-3 p-0 text-center active"> <a class="nav-link active keyword-part" data-toggle="tab" href="#keyword-part" >OEM SEARCH</a> </li>                               

                                <li class="nav-item col-4 p-0 text-center"> <a class="nav-link vehicle-lookup" data-toggle="tab" href="#vehicle-lookup" >VEHICLE SEARCH</a> </li>
                                <li class="nav-item  col-5 p-0 text-center"> <a class="nav-link search-by-car " data-toggle="tab" href="#search-by-car" >CAR REGISTRATION SEARCH </a> </li>



                            </ul>
                            <div class="tab-content pt-4">
                                <?php
                                if (isset($_SESSION['u_id']) && $_SESSION['u_id'] != '') {
                                    ?>
                                    <div id="search-by-car" class="tab-pane ">
                                        <?php /* ?> <p class="font12 text-white">Search by registration number.</p><?php */ ?>
                                        <div class="row">
                                            <div class="col-md-12 col-12 input-field ">
                                                <form action="test_vehicle-lookup-search.php" class="vehicLook" method="post">
                                                    <label for="select_product" class="text-left">PRODUCT*</label>
                                                    <select class="form-control mb-3" id="select_product" required name="cat_id"  >

                                                        <option value="">Select Product </option>
                                                        <?php
                                                        $psql = "SELECT cat_id,cat_nm FROM rollco_ms_cat WHERE cat_status=1 order by cat_nm asc";
                                                        $numsrow = $sq->numsrow($psql);


                                                        if ($numsrow > 0) {
                                                            $data = $sq->query($psql);

                                                            while ($rs = $sq->fetch($data)) {
                                                                ?>
                                                                <option value="<?php echo $rs['cat_id']; ?>"> <?php echo strtoupper($rs['cat_nm']); ?> </option> 
                                                            <?php }
                                                        } ?>


                                                    </select>
                                                    <img src="images/gb.jpg" /> <input type="text" name="car_number" class="bgcange" id="car_number" placeholder="Enter Your Reg No" autocomplete="off" required value="<?php if (isset($_POST['car_number']) && $_POST['car_number'] != '') {
                                                        echo $_POST['car_number'];
                                                    } ?>">

                                                    <input id="sbtnSubmit" class="bntc bg-danger border-danger" type="submit" name="submit" value="SEARCH">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
<?php } else { ?>
                                    <div id="search-by-car" class="tab-pane ">
                                        <p class="font12 text-red login-first-text">You have to Login first,to continue with Search by Vehicle Registration Number.</p>
                                    </div>
<?php } ?>
                                <div id="vehicle-lookup" class="tab-pane ">
                                    <div id="myDiv">
                                        <img id="loading-image" src="images/loader.svg" style="display:none;"/>
                                    </div>
                                    <form action="product-detail.php" class="vehicLook" method="post">
                                        <input type="hidden" name="roll_product" id="roll_product_val" value=" <?php if (isset($_POST['roll_product'])) echo $_POST['roll_product']; ?> ">
                                        <input type="hidden" name="roll_make" id="roll_make_val" value=" <?php if (isset($_POST['roll_make'])) echo $_POST['roll_make']; ?> ">
                                        <input type="hidden" name="roll_model" id="roll_model_val" value=" <?php if (isset($_POST['roll_model'])) echo $_POST['roll_model']; ?> ">
                                        <input type="hidden" name="roll_year" id="roll_year_val" value=" <?php if (isset($_POST['roll_year'])) echo $_POST['roll_year']; ?> ">
                                        <input type="hidden" name="roll_exact_ccm" id="roll_exact_ccm_val" value=" <?php if (isset($_POST['roll_exact_ccm'])) echo $_POST['roll_exact_ccm']; ?> ">
                                        <input type="hidden" name="roll_engine_code" id="roll_engine_code_val" value=" <?php if (isset($_POST['roll_engine_code'])) echo $_POST['roll_engine_code']; ?> ">
                                        <div  class="row">
                                            <div class="col-md-3 col-12 pb-3">
                                                <label for="product">PRODUCT*</label>
                                                <select class="form-control" id="roll_product" required>
                                                    <option value="">Select</option>
                                                    <?php
                                                    $psql = "SELECT cat_id,cat_nm FROM rollco_ms_cat WHERE cat_status=1 order by cat_nm asc";
                                                    $numsrow = $sq->numsrow($psql);


                                                    if ($numsrow > 0) {
                                                        $data = $sq->query($psql);

                                                        while ($rs = $sq->fetch($data)) {
                                                            ?>

                                                            <option value="<?php echo $rs['cat_id']; ?>" <?php
                                                                    if (isset($prId) && $prId == $rs['cat_id'])
                                                                        echo 'selected';
                                                                    ?>><?php echo $rs['cat_nm']; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-12 pb-3">
                                                <label for="make">MAKE*</label>
                                                <select class="form-control" id="roll_make" required>
                                                    <?php
                                                    if (isset($mkId) && $mkId > 0) {
                                                        ?>

                                                        <option value="<?php echo $mkId ?>"><?php echo $mkText; ?></option>
                                                    <?php } else { ?>
                                                        <option>Select</option>
<?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-12 pb-3">
                                                <label for="model">MODEL*</label>
                                                <select class="form-control" id="roll_model" required>
                                                    <?php
                                                    if (isset($modId) && $modId > 0) {
                                                        ?>

                                                        <option value="<?php echo $modId ?>"><?php echo $modText; ?></option>
                                                    <?php } else { ?>
                                                        <option>Select</option>
<?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-12 pb-3">
                                                <label for="year" class="text">YEAR*</label>
                                                <select class="form-control" id="roll_year" required>
                                                    <?php
                                                    if (isset($yrId) && $yrId > 0) {
                                                        ?>

                                                        <option value="<?php echo $yrId ?>"><?php echo $yrText; ?></option>
                                                    <?php } else { ?>
                                                        <option>Select</option>
<?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div  class="row">
                                            <div class="col-md-3 col-12 pb-3">
                                                <label for="exact-ccm">EXACT CCM</label>
                                                <select class="form-control" id="roll_exact_ccm" >
                                                    <?php
                                                    if (isset($ccmId) && $ccmId > 0) {
                                                        ?>

                                                        <option value="<?php echo $ccmId ?>"><?php echo $ccmText; ?></option>
                                                    <?php } else { ?>
                                                        <option>Select</option>
<?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-12 pb-3">
                                                <label for="engine-code">ENGINE CODE</label>
                                                <select class="form-control" id="roll_engine_code">
                                                    <?php
                                                    if (isset($ecId) && $ecId > 0) {
                                                        ?>

                                                        <option value="<?php echo $ecId ?>"><?php echo $ecText; ?></option>
                                                    <?php } else { ?>
                                                        <option>Select</option>
<?php } ?>

                                                </select>
                                            </div>
                                            <div class="col-md-3 col-12 pb-3 ml-auto  float-right">
                                                <label for="product">&nbsp;</label>
                                                <input id="sbtnSubmit" class="bg-danger border-danger form-control text-white" type="submit" name="submit" value="SEARCH">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="keyword-part" class="tab-pane active">
                                    <div class="row">
                                        <p class="font12 text-white" style="margin-left: 20px;">If you know the specific keyword or part number you'd like to order, you may enter it here.</p>
                                        <div class="col-md-12 col-12 input-field">
                                            <form action="product-detail.php" class="vehicLook" method="post">
                                                <input type="text" name="rc_num" id="rc_num" placeholder="Enter Keyword/Part Number" autocomplete="off" required>
                                                <input type="hidden" name="sbypart" value="1">

                                                <input id="sbtnSubmit" class="bntc bg-danger border-danger mt-0" type="submit" name="submit" value="SEARCH">
                                            </form>
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




