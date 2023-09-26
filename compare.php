<?php
include 'class/config.php';

if (!isset($_SESSION['cpr1']) && $_SESSION['cpr1'] == '' && !isset($_SESSION['cpr2'])
        && $_SESSION['cpr2'] == '') {
    header("Location: index.php");
}

$pr1Sql = "SELECT prod_img1,prod_desc,prod_volt,prod_out,prod_regu,prod_pull_type,prod_fan,prod_teeth,prod_trans,prod_rot,prod_dim,prod_add_inf,ptype FROM rollco_ms_product WHERE prod_part_no = '" . $_SESSION['cpr1'] . "'";

$pr1nums = $sq->numsrow($pr1Sql);

if ($pr1nums > 0) {
    $pr1Data = $sq->fearr($pr1Sql);

    $pr1prod_img1 = $pr1Data['prod_img1'] != '' ? $pr1Data['prod_img1'] : 'no-image.png';
    $pr1prod_desc = $pr1Data['ptype'] != '' ? $pr1Data['ptype'] : 'No Info';
    $pr1prod_volt = $pr1Data['prod_volt'] != '' ? $pr1Data['prod_volt'] : 'No Info';
    $pr1prod_out = $pr1Data['prod_out'] != '' ? $pr1Data['prod_out'] : 'No Info';
    $pr1prod_regu = $pr1Data['prod_regu'] != '' ? $pr1Data['prod_regu'] : 'No Info';
    $pr1prod_pull_type = $pr1Data['prod_pull_type'] != '' ? $pr1Data['prod_pull_type']
                : 'No Info';
    $pr1prod_fan = $pr1Data['prod_fan'] != '' ? $pr1Data['prod_fan'] : 'No Info';
    $pr1prod_teeth = $pr1Data['prod_teeth'] != '' ? $pr1Data['prod_teeth'] : 'No Info';
    $pr1prod_rot = $pr1Data['prod_rot'] != '' ? $pr1Data['prod_rot'] : 'No Info';
    $pr1prod_dim = $pr1Data['prod_dim'] != '' ? $pr1Data['prod_dim'] : 'No Info';
    $pr1prod_trans = $pr1Data['prod_trans'] != '' ? $pr1Data['prod_trans'] : 'No Info';
    $pr1prod_add_inf = $pr1Data['prod_add_inf'] != '' ? $pr1Data['prod_add_inf']
                : 'No Info';
}

$pr2Sql = "SELECT prod_img1,prod_desc,prod_volt,prod_out,prod_regu,prod_pull_type,prod_fan,prod_teeth,prod_trans,prod_rot,prod_dim,prod_add_inf,ptype FROM rollco_ms_product WHERE prod_part_no = '" . $_SESSION['cpr2'] . "'";

$pr2nums = $sq->numsrow($pr2Sql);

if ($pr2nums > 0) {
    $pr2Data = $sq->fearr($pr2Sql);

    $pr2prod_img1 = $pr2Data['prod_img1'] != '' ? $pr2Data['prod_img1'] : 'no-image.png';
    $pr2prod_desc = $pr2Data['ptype'] != '' ? $pr2Data['ptype'] : 'No Info';
    $pr2prod_volt = $pr2Data['prod_volt'] != '' ? $pr2Data['prod_volt'] : 'No Info';
    $pr2prod_out = $pr2Data['prod_out'] != '' ? $pr2Data['prod_out'] : 'No Info';
    $pr2prod_regu = $pr2Data['prod_regu'] != '' ? $pr2Data['prod_regu'] : 'No Info';
    $pr2prod_pull_type = $pr2Data['prod_pull_type'] != '' ? $pr2Data['prod_pull_type']
                : 'No Info';
    $pr2prod_fan = $pr2Data['prod_fan'] != '' ? $pr2Data['prod_fan'] : 'No Info';
    $pr2prod_teeth = $pr2Data['prod_teeth'] != '' ? $pr2Data['prod_teeth'] : 'No Info';
    $pr2prod_rot = $pr2Data['prod_rot'] != '' ? $pr2Data['prod_rot'] : 'No Info';
    $pr2prod_dim = $pr2Data['prod_dim'] != '' ? $pr2Data['prod_dim'] : 'No Info';
    $pr2prod_trans = $pr2Data['prod_trans'] != '' ? $pr2Data['prod_trans'] : 'No Info';
    $pr2prod_add_inf = $pr2Data['prod_add_inf'] != '' ? $pr2Data['prod_add_inf']
                : 'No Info';
}

if (isset($_SESSION['cpr3']) && $_SESSION['cpr3'] != '') {
    $pr3Sql = "SELECT prod_img1,prod_desc,prod_volt,prod_out,prod_regu,prod_pull_type,prod_fan,prod_teeth,prod_trans,prod_rot,prod_dim,prod_add_inf,ptype FROM rollco_ms_product WHERE prod_part_no = '" . $_SESSION['cpr3'] . "'";

    $pr3nums = $sq->numsrow($pr3Sql);

    if ($pr3nums > 0) {
        $pr3Data = $sq->fearr($pr3Sql);

        $pr3prod_img1 = $pr3Data['prod_img1'] != '' ? $pr3Data['prod_img1'] : 'no-image.png';
        $pr3prod_desc = $pr3Data['ptype'] != '' ? $pr3Data['ptype'] : 'No Info';
        $pr3prod_volt = $pr3Data['prod_volt'] != '' ? $pr3Data['prod_volt'] : 'No Info';
        $pr3prod_out = $pr3Data['prod_out'] != '' ? $pr3Data['prod_out'] : 'No Info';
        $pr3prod_regu = $pr3Data['prod_regu'] != '' ? $pr3Data['prod_regu'] : 'No Info';
        $pr3prod_pull_type = $pr3Data['prod_pull_type'] != '' ? $pr3Data['prod_pull_type']
                    : 'No Info';
        $pr3prod_fan = $pr3Data['prod_fan'] != '' ? $pr3Data['prod_fan'] : 'No Info';
        $pr3prod_teeth = $pr3Data['prod_teeth'] != '' ? $pr3Data['prod_teeth'] : 'No Info';
        $pr3prod_rot = $pr3Data['prod_rot'] != '' ? $pr3Data['prod_rot'] : 'No Info';
        $pr3prod_dim = $pr3Data['prod_dim'] != '' ? $pr3Data['prod_dim'] : 'No Info';
        $pr3prod_trans = $pr3Data['prod_trans'] != '' ? $pr3Data['prod_trans'] : 'No Info';
        $pr3prod_add_inf = $pr3Data['prod_add_inf'] != '' ? $pr3Data['prod_add_inf']
                    : 'No Info';
    }
}
?>
<!doctype html>
<html>
    <head>
        <?php include("inc-head.php"); ?>
    </head> 

    <body>
        <?php include("inc-header.php"); ?>
        <section class="clearfix cataloGue">
            <?php /* ?> <?php
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
            <article class="clearfix padB200 aos-item faqOrdNews comparRes" data-aos='fade-up'>
                <div class="container">
                    <div class="row  pt-3 justify-content-center mr-0 ml-0 navTabs">
                        <div class="col-lg-10  pt-3 pb-2  mb-4 border-top alt120 border-bottom border-danger">
                            <h2 class="text-danger comparRes">COMPARE</h2>
                        </div>
                        <div class="col-lg-10 pl-0 pr-0 ">


                            <table class="table text-center table-bordered table-sm table-responsive-lg ">
                                <tr>
                                    <td><table width="100%" border="0"  >
                                            <tr>
                                                <td class="align-middle pt-pb tdWidth" >Product Images </td>
                                            </tr>
                                            <tr>
                                                <td>Product Name</td>
                                            </tr>
                                            <tr>
                                                <td>Description</td>
                                            </tr>
                                            <tr>
                                                <td>Voltage</td>
                                            </tr>
                                            <tr>
                                                <td>Output</td>
                                            </tr>

                                            <tr>
                                                <td>Regulator</td>
                                            </tr>

                                            <tr>
                                                <td>Pulley Type</td>
                                            </tr>

                                            <tr>
                                                <td>Fan</td>
                                            </tr>

                                            <tr>
                                                <td>Teeth</td>
                                            </tr>

                                            <tr>
                                                <td>Transmission</td>
                                            </tr>

                                            <tr>
                                                <td>Rotation</td>
                                            </tr>

                                            <tr>
                                                <td>Dimension</td>
                                            </tr>

                                            <tr>
                                                <td>Add Info.</td>
                                            </tr>

                                            <tr class="removeBut">
                                                <td class="rmHighet" >&nbsp;  </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <?php
                                    if (isset($_SESSION['cpr1']) && $_SESSION['cpr1']
                                            != '') {
                                        ?>
                                        <td id="mydiv1" ><table width="100%" border="0">
                                                <tr>
                                                    <td ><a href="product-detail.php?rc_num=<?php echo $_SESSION['cpr1'] ?>&type=search" ><img style="height: 132px;width: 176px;"src="../upload/product/<?php echo $pr1prod_img1; ?>"> </a></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $_SESSION['cpr1']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr1prod_desc; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr1prod_volt; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr1prod_out; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr1prod_regu; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr1prod_pull_type; ?></td>
                                                </tr>

                                                <tr>
                                                    <td><?php echo $pr1prod_fan; ?></td>
                                                </tr>

                                                <tr>
                                                    <td><?php echo $pr1prod_teeth; ?></td>
                                                </tr>

                                                <tr>
                                                    <td><?php echo $pr1prod_trans; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr1prod_rot; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr1prod_dim; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr1prod_add_inf; ?></td>
                                                </tr>
                                                <tr class="removeBut">
                                                    <td ><button class="btn btnRemov" data-prodname="<?php echo $_SESSION['cpr1']; ?>" onclick="hide('mydiv1');">REMOVE </button>
                                                    </td>
                                                </tr>
                                            </table></td>
                                    <?php } ?>
                                    <?php
                                    if (isset($_SESSION['cpr2']) && $_SESSION['cpr2']
                                            != '') {
                                        ?>
                                        <td id="mydiv2"><table width="100%" border="0">
                                                <tr>
                                                    <td ><a href="product-detail.php?rc_num=<?php echo $_SESSION['cpr2'] ?>&type=search" ><img style="height: 132px;width: 176px;"src="../upload/product/<?php echo $pr2prod_img1; ?>"> </a></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $_SESSION['cpr2']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr2prod_desc; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr2prod_volt; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr2prod_out; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr2prod_regu; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr2prod_pull_type; ?></td>
                                                </tr>

                                                <tr>
                                                    <td><?php echo $pr2prod_fan; ?></td>
                                                </tr>

                                                <tr>
                                                    <td><?php echo $pr2prod_teeth; ?></td>
                                                </tr>

                                                <tr>
                                                    <td><?php echo $pr2prod_trans; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr2prod_rot; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr2prod_dim; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr2prod_add_inf; ?></td>
                                                </tr>
                                                <tr class="removeBut">
                                                    <td > <button class="btn btnRemov" data-prodname="<?php echo $_SESSION['cpr2']; ?>" onclick="hide('mydiv2')" >REMOVE </button></td>
                                                </tr>

                                            </table></td>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (isset($_SESSION['cpr3']) && $_SESSION['cpr3']
                                            != '') {
                                        ?>
                                        <td id="mydiv3"><table width="100%" border="0">
                                                <tr>
                                                    <td ><a href="product-detail.php?rc_num=<?php echo $_SESSION['cpr3'] ?>&type=search" ><img style="height: 132px;width: 176px;"src="../upload/product/<?php echo $pr3prod_img1; ?>"> </a></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $_SESSION['cpr3']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr3prod_desc; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr3prod_volt; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr3prod_out; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr3prod_regu; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr3prod_pull_type; ?></td>
                                                </tr>

                                                <tr>
                                                    <td><?php echo $pr3prod_fan; ?></td>
                                                </tr>

                                                <tr>
                                                    <td><?php echo $pr3prod_teeth; ?></td>
                                                </tr>

                                                <tr>
                                                    <td><?php echo $pr3prod_trans; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr3prod_rot; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr3prod_dim; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $pr3prod_add_inf; ?></td>
                                                </tr>
                                                <tr class="removeBut">
                                                    <td > <button class="btn btnRemov" data-prodname="<?php echo $_SESSION['cpr3']; ?>" onclick="hide('mydiv3')">REMOVE </button> </td>
                                                </tr>
                                            </table></td>
                                    <?php } ?>
                                </tr>
                            </table>
                        </div>

                    </div>
                    <div class="row justify-content-center ml-0 mr-0">
                        <div class="col-lg-10 text-center pt-4 border-top">
                            <p class="mb-2 font14 text-danger"></p>
                        </div>
                        <div class="col-lg-10 col-md-12 col-sm-12 col-12 pl-5 pt-2 bg-light mb-4 border-top alt120">

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

    </section>
    <?php include("inc-footer.php"); ?>
    <script type="text/javascript">

        var divcnt = 0;
        $(document).ready(function () {
            if ($('#mydiv1').is(":visible")) {
                divcnt++;
            }
            if ($('#mydiv2').is(":visible")) {
                divcnt++;
            }
            if ($('#mydiv3').is(":visible")) {
                divcnt++;
            }
        });

        function hide(target) {
            //if (divcnt >= 3) {
            document.getElementById(target).style.display = 'none';
            /*divcnt--;
             if (divcnt <= 2) {
             $('.removeBut').hide();
             $('.removeBut').css('color', '#d3d3d3');
             }
             */
        }
        //header
        function sticky_relocate() {
            var window_top = $(window).scrollTop();
            var div_top = $('#stickyHeader').offset().top;
            if (window_top > div_top) {
                $(".topHeader").addClass('stick');
                //$('#stickyHeader').height($('#stick').outerHeight());
            } else {
                $('.topHeader').removeClass('stick');
                $('#stickyHeader').height(0);

            }
        }

        $(function () {
            $(window).scroll(sticky_relocate);
            sticky_relocate();
        });

        $(".js-offcanvas-left").hiraku({
            btn: ".js-offcanvas-btn-left",
            fixedHeader: ".js-fixed-header",
            direction: "left"
        });



        $('#bannerSlider').owlCarousel({
            margin: 0,
            nav: false,
            loop: true,
            dots: true,
            items: 1,
            autoplay: true,

        })

        /*------- wow animation -------*/
        $(document).ready(function () {

            wow = new WOW(
                    {
                        animateClass: 'animated',
                        offset: 100,
                        callback: function (box) {
                            console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
                        }
                    }
            );
            wow.init();

            AOS.init({
                easing: 'ease-out-back',
                duration: 1000
            });

        });
        /*------- wow animation -------*/

        /*------- wow animation -------*/
        $('.add').click(function () {
            $(this).prev().val(+$(this).prev().val() + 1);
        });
        $('.sub').click(function () {
            if ($(this).next().val() > 1)
                $(this).next().val(+$(this).next().val() - 1);
        });
    </script> 
    <script src="https://www.google.com/recaptcha/api.js" async defer></script> 
    <script>
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

        $(document).on("click", '.btnRemov', function () {
            $("#panel").slideUp();
            var part = $(this).data('prodname');
            $.ajax({
                type: 'post',
                url: "ajax/removeFromCompare.php",
                data: {'prod_part': part},
                success: function (data) {
                    $('.loading').hide();
                    var data = JSON.parse(data);
                    if (data.success == 1) {
                        console.log(data);
                        $(this).hide();
                        if(data.proCount == 0){
                            location.reload();
                        }
                    }
                }
            });
            //                $(this).parents('p').fadeOut();
        });

    </script>
</body>
</html>
