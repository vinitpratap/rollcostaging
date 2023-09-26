<article class="contMenu rollcoBest">
    <div class="contImg">
        <img src="<?php echo $siteurl ?>images/cor-grey.svg" alt="Arrow" class="w-100">
    </div>
    <div class="contMenuBg pb-5">
        <div class="contentBg">
            <div class="container ">
                <div class="row pt-5 justify-content-center ">
                    <div class="col-12 col-lg-7 col-sm-12 col-md-10 ">
                        <div class="row justify-content-center">
                            <div class="col-sm-4 pt-0 pb-0 pr-5">
                                <h4 class="text-white">CONTACTS</h4>
                                <div class="row  pt-3 contRow justify-content-between">
                                    <ul>
                                        <li class="call mb-2"> <a href="tel:441268271035"> +44 1268 271035</a></li>
                                        <li class="email  mb-2"> <a href="mailto:info@rollingcomponents.com"> info@rollingcomponents.com</a></li>
                                        <li class="locin pb-4"> <a href="https://www.google.com/maps/dir//51.5900993,0.4866891/@51.590099,0.486689,16z?hl=en" target="_blank">Ilford Trading Estate, 22-25 Paycocke Rd, Basildon SS14 3DR, UK</a> </li>
                                        <li class="cookie pl-0 border-top pt-2 pb-2"> <a href="<?php echo $siteurl ?>cookie-policy-and-privacy-policy.php"> COOKIE POLICY & PRIVACY POLICY  </a></li>
                                        <li class="priva pl-0 border-top pt-2"></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-5 pt-0 pb-0 pl-sm-4">
                                <h4 class="text-white pl-sm-4 distbu ">DISTRIBUTED BRANDS </h4>
                                <div class="row  pt-3 contRow pr-sm-4 m-0 pl-sm-4 ">
                                    <div class="pl-0 pr-0 col-12 text-sm-center vslogo"><img src="<?php echo $siteurl ?>images/vs-logo-footer.jpg" alt="VS Go Further" width="150" ></div>
                                </div>
                            </div>
                            <div class="col-sm-3  pt-0 pb-0 float-right text-sm-right d-none d-sm-block">
                                <h4 class="text-white">MENU</h4>
                                <ul class="pt-3 contMen  ">
                                    <li class="d-block"><a href="<?php echo $siteurl ?>about-us.php">About us </a> </li>
                                    <li class="d-block"><a href="<?php echo $siteurl ?>listing.php">Catalogue </a> </li>
                                    <li class="d-block"><a href="<?php echo $siteurl ?>support.php">Support </a> </li>
                                    <li class="d-block"><a href="<?php echo $siteurl ?>news.php">News </a> </li>
                                    <li class="d-block"><a href="<?php echo $siteurl?>blog/">Blog </a> </li>
                                    <li class="d-block"><a href="<?php echo $siteurl ?>contact-us.php">Contact us </a> </li>
                                    <li class="d-block"><a  href="mailto:utkarsh@rollingcomponents.com?Subject=Career with Rolling Components: Apply Now">Career</a> </li>
                                    <li class="d-block"><a href="<?php echo $siteurl ?>sitemap.php">Site map</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center  privbran text-center  "><div class="col-12 col-lg-7 col-sm-12 col-md-10">
                        <h4 class="text-white distbu pb-3 ">AFFILIATIONS</h4>
                        <a href="void:main(0)"><img src="<?php echo $siteurl ?>images/logo_smt_autocad.jpg" alt="Rollco MMI Certified Data" /></a> <a href="void:main(0)"><img src="<?php echo $siteurl ?>images/bsl-logo.jpg" alt="BSI ISO 9001:2008 Certified" /></a>  </div></div>
            </div>
        </div>
    </div>
</div>
</article>
<footer class="clearfix yellow"></footer>
<script src="<?php echo $siteurl ?>js/jquery.min.js" type="text/javascript"></script> 
<script src="<?php echo $siteurl ?>js/wow.js"></script> 
<script src="<?php echo $siteurl ?>js/aos.js"></script> 
<script src="<?php echo $siteurl ?>js/popper.min.js"></script> 
<script src="<?php echo $siteurl ?>js/numscroller-1.0.js" type="text/javascript"></script> 
<script src="<?php echo $siteurl ?>js/bootstrap.min.js" type="text/javascript"></script> 
<script src="<?php echo $siteurl ?>js/owlslider/carousel.min.js"></script> 
<script src="<?php echo $siteurl ?>js/nav.js" type="text/javascript"></script>
<script src="<?php echo $siteurl ?>js/searchajax.js?v=1.3"></script> 
<script src="<?php echo $siteurl ?>js/jquery.validate.js"></script> 
<script src="<?php echo $siteurl ?>js/moment.js"></script> 
<script src="<?php echo $siteurl ?>css/bootstrap-daterangepicker/daterangepicker.js"></script> 
<?php /* ?><script src="<?php echo $siteurl?>js/nav.js"></script> <?php */ ?>



<script type="text/javascript">
//header
    function sticky_relocate() {
        var window_top = $(window).scrollTop();
        var header_yuksekligi = $('.topHeader').outerHeight();
        var div_top = $('#stickyHeader').offset().top;
        if (window_top > div_top) {
            $(".topHeader").addClass('stick');
            //$('#stickyHeader').height($('#stick').outerHeight());
        } else {
            $('.topHeader').removeClass('stick');
            $('#stickyHeader').height(0);
        }


        if (window_top > header_yuksekligi) {
            $('.top').addClass('stick');
        } else {
            $('.topHeader').removeClass('stick');
        }
    }

    $(function () {
        $(window).scroll(sticky_relocate);
        sticky_relocate();
    });


   
	function sticky_relocate2() {
    var window_top = $(window).scrollTop();
    var div_top = $('#stickyHeader1').offset().top;
    if (window_top > div_top) {
		$(".topHeader1").addClass('stick1');
		$('#stickyHeader1').height($('.stick1').outerHeight());
	    } else {
        $('.topHeader1').removeClass('stick1');
        $('#stickyHeader1').height(0);
		
	
    }
}

$(function() {
	var url = window.location.href;
	//console.log(url);
    if (url.includes("product-detail")) {
        $(window).scroll(sticky_relocate2);
		sticky_relocate2();
    }
    
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
        autoplayTimeout: 7000,

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

<script>
// search tab ajax
    $(document).ready(function () {
        $('.rollcoPartsf .nav-item').click(function (event) {
            $('.rollcoPartsf .active').removeClass('active');
            $(this).addClass('active');
            event.preventDefault();
        });
        $('.loading').hide();
        $("form").submit(function () {
            if ($(this).valid()) {
                $('.loading').show();//go ahead
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        var activeTab = '';
        $(document).on('click', '.search-by-car', function () {
            activeTab = '#search-by-car';
            localStorage.setItem('activeTab1', '#search-by-car');
            //location.reload();
        });
        $(document).on('click', '.vehicle-lookup', function () {
            activeTab = '#vehicle-lookup';
            localStorage.setItem('activeTab1', '#vehicle-lookup');
            //location.reload();
        });
        $(document).on('click', '.keyword-part', function () {
            activeTab = '#keyword-part';
            localStorage.setItem('activeTab1', '#keyword-part');
            //location.reload();
        });
        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
            localStorage.setItem('activeTab1', $(e.target).attr('href'));
        });


        activeTab = localStorage.getItem('activeTab1');

        if (activeTab) {
            //$('.keyword-part').removeClass('active');
            $('#myTab1 a[href="' + activeTab + '"]').tab('show');
        }

        var url = window.location.href;
        if (url.includes("product-detail")) {
            $('html, body').animate({
                scrollTop: $(".rollcoPartRi").offset().top
            }, 2000);
        }
    });
</script>

<script>
    $(document).ready(function () {

        $("#rc_num").keyup(function () {
            var search = $(this).val();
            console.log(search);
            if (search) {

                $.ajax({
                    url: 'ajax/getProductSearchResults.php',
                    type: 'post',
                    data: {searchText: search},
                    dataType: 'json',
                    success: function (response) {
                        
                        $(".resList").empty();
                        console.log(response);
                        if(response.status == 1){
                             $(".resList").append(response.data);
                        }
                        // binding click event to li
                        $(".resList li").bind("click", function () {
                            setText(this);
                        });

                    }
                });
            }else{
                $(".resList").html('');
            }

        });

    });

// Set Text to search box and get details
    function setText(element) {

        var value = $(element).text();

        $("#rc_num").val(value);
        $(".resList").empty();
    }
</script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>