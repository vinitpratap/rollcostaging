<?php
include("class/config.php");
require 'send_maill.php';
if (isset($_POST['fsub']) && $_POST['fsub'] == 1) {

    $username = stripslashes(trim($_POST['user_name']));
    $emailid = stripslashes(trim($_POST['email_id']));
    $mobile_no = stripslashes(trim($_POST['mobile_no']));
    $comments = stripslashes(trim($_POST['comments']));


    $insertSql = "INSERT INTO rollco_contactus SET name='" . $username . "',email='" . $emailid . "',comments='" . $comments . "',cust_ip='" . $_SERVER['REMOTE_ADDR'] . "',mobile='" . $mobile_no . "'";

    $status = $sq->query($insertSql);



    if ($status) {
        $subject = "Rolling Components : Contact us";
        $usr_headers = 'MIME-Version: 1.0' . "\r\n";
        $usr_headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $usr_headers .= 'From:Rollco<info@rollingcomponents.com>' . "\r\n";
//        ob_start();
//        require("mailer/forget-password.php");
//        $body = ob_get_contents();
//        ob_end_clean();
// message
//        $message = $body;
        $message = "<br><br>
Name: " . $username . "<br>
Email: " . $emailid . "<br>
Mobile: " . $mobile_no . "<br>
Comments: " . $comments . "<br>
";

        $message2 = "Thank you for contacting us. We will get back to you shortly.";

// Additional headers

        if ($_SERVER['HTTP_HOST'] != 'localhost') {
            mail('info@rollingcomponents.com', $subject, $message, $usr_headers);
            mail($emailid, $subject, $message2, $usr_headers);
//                $TO_EMAIL = $userData['com_emailAddress'];
//
//                $from = new SendGrid\Email(null, $FROM_EMAIL);
//                $to = new SendGrid\Email(null, $TO_EMAIL);
//
//                $content = new SendGrid\Content("text/html", $message);
//                $mail = new SendGrid\Mail($from, $subject, $to, $content);
//                $sg = new \SendGrid($API_KEY);
//                $response = $sg->client->mail()->send()->post($mail);
        }
        echo "<script>alert('Query Successfully received.');window.location='index.php';</script>";
    }
}
?>

<!doctype html>
<html>
    <head>
        <?php include("inc-head.php"); ?>
        <link rel="stylesheet" href="css/christmas-theme.css<?php echo $cssvers;?>">
    </head>

    <body>
        <?php include("inc-header-chirstmas.php"); ?>

        <section class="clearfix">
            <article class="clearfix">
                <div class="container-fluid p-0">
                    <div id="bannerSlider" class="owl-carousel owl-theme" >
                        <div class="item position-relative"> <img src="images/banner.jpg"  alt="banner">
                            <div class="position-absolute">
                                <h2> THE WIDEST RANGE OF SPARE PARTS 
                                    <hr> </h2>
                                <div class="clearfix"></div>
                                <h2> YOU COULD EVER IMAGINE. 
                                    <hr>
                                </h2>
                                <div class="clearfix"></div>
                                <span> PROUD TO HAVE BEEN TRUSTED FOR OVER 40 YEARS</span> </div>
                        </div>
                        <div class="item position-relative"> <img src="images/banner1.jpg"  alt="banner">
                            <div class="position-absolute">
                                <h2> high quality, low cost aftermarket
                                    <hr> </h2>
                                <div class="clearfix"></div>
                                <h2> products at your fingertips.
                                    <hr>
                                </h2>
                                
                                <div class="clearfix"></div>
                                <span> PROUD TO HAVE BEEN TRUSTED FOR OVER 40 YEARS</span> </div>
                        </div>
                        
                        
                        <div class="item position-relative"> <img src="images/banner2.jpg"  alt="banner">
                            <div class="position-absolute">
                                <h2>The genuine alternative.
                                    <hr> </h2>
                                <div class="clearfix"></div>
                                <h2>It’s what we do best! 
                                    <hr>
                                </h2>
                                
                                <div class="clearfix"></div>
                                <span> PROUD TO HAVE BEEN TRUSTED FOR OVER 40 YEARS</span> </div>
                        </div>
                        <div class="item position-relative"> <img src="images/banner3.jpg"  alt="banner">
                            <div class="position-absolute">
                                <h2>High quality, low cost
                                    <hr> </h2>
                                <div class="clearfix"></div>
                                <h2> is what we do best 
                                    <hr>
                                </h2>
                                
                                <div class="clearfix"></div>
                                <span> PROUD TO HAVE BEEN TRUSTED FOR OVER 40 YEARS</span> </div>
                                
                                
                        </div>
                    </div>
                </div>
            </article>
            <article class="clearfix bg-danger rollcoPart">
                <div class="container">
                    <div class="row justify-content-center ">
                        <div class="col-12 col-lg-6 col-sm-10 col-md-8 p-40 text-center">
                            <h1 class="text-white">ROLLCO PARTSFINDER</h1>
                           
                            <p class=" font20 text-white onlintext">  <a  href="listing.php" > ONLINE CATALOGUE <i class="d-inline-block pl-2"> <img src="images/arrow.png" class="img-fluid"   alt=""></i></a> </p> 
                            <form action="product-detail.php" class="vehicLook" method="post">
                                <div class="input-field">

                                    <input type="text" name="rc_num" id="rc_num" placeholder="Enter Keyword/Part Number" autocomplete="off" required>
                                    <input type="hidden" name="sbypart" value="1">
                                    <input id="sbtnSubmit" class="bntc" type="submit" name="submit" value="SEARCH" >
                                    <p class="ac" id="status-message"></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
            <article class="clearfix welcomeTo pt-5 pb-5 aos-item" data-aos='fade-up'>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class=" col-xl-9 col-lg-10 col-md-12 text-center position-relative">
                        <div class="fortYear position-absolute">
                        
                         </div>
                            <h2 class="text-danger"> WELCOME TO ROLLING COMPONENTS</h2>
                            <h3 class="text-black-50 pb-3 mb-0">PROUDLY OFFERING AFTERMARKET AUTO PARTS SINCE 1979</h3>
                             <img src="images/fourty-years-logo.png" class="pb-4 imsize"  >
                            
                            
                            
                            <p class=" font15 pl-2  mb-3 ">Based in United Kingdom, we are leaders in the field of distribution of auto parts.</p>

                          <p class=" font15 pl-2 text-left  mb-3"> we are known in the aftermarket as specialists for rotating electrics. We have been supplying component parts to the rebuilders and due to less demand of a remanufactured / repaired parts, became a main player for complete brand new genuine alternative rotating products i.e. alternators and starter motors.
Steadily but surely we have been introducing other new product lines that meet the same strict quality criteria preserved just like in our main product group. This is so that we can give our customers a better experience and peace of mind knowing they can buy from a truly reliable source, on-time, every-time, consistently.</p>
<p class="font15 pl-2 mb-3"> We preserve at all times, in order to give our customers a better attractive service</p>
<p class="mb-1 font15 pl-2  mb-3 ">Our core focus is on delivering quality products at competitive prices on time, every time!</p> 
                            <p class="mb-3 font15"><strong>ROLLCO,</strong> has vigorously pursued a history of continuous success and today it represents an innovative and evolving company.</p>          <p class="mb-3 font15">We are a benchmark in the automotive industry for manufacturers and resellers, for the organizational virtues, cutting-edge logistics,</p>
                            <p class="mb-3 font15">prestigious brand distribution, the partnerships with automotive networks, and smart technical and marketing services for its dealers.</p>



                        </div>
                    </div>
                </div>
            </article>
            <article class="clearfix rollcoBest pt-5 pb-5 aos-item" data-aos='fade-up'>
                <div class="container">
                    <div class="row pt-3">
                        <div class="col-12 text-center pt-5 pt-md-0">
                            <h2 class="text-danger pb-1"> ROLLCO</h2>
                            <h3 class="text-black-50">YOUR BEST CHOICE FOR SPARE PARTS</h3>
                            <span class="d-block p-4 arrowdown"><img src="images/rollco-icon.svg" alt=""></span> </div>
                    </div>

                    <div class="row pt-lg-5 pt-md-3 d-flex rollCol justify-content-between">
                        <div class="col-md-6 col-lg-5 col-sm-12   rollCoLe">
                            <h4 class="text-danger mb-20"><i class="pr-3"><img src="images/can-rely.svg" alt="THE BRAND YOU CAN RELY ON"></i> THE BRAND YOU CAN RELY ON</h4>
                            <p class="font13 mb-2"> Trust isn’t asked for,but earned through the execution of meaningful actions. With a convincing range of
                                products, continuous precision and reliable service, Rollco has been serving its customers for more than
                                40 years as a reliable, durable and precise aftermarket specialist.</p>

                            <p class="font13 mb-5"> Rollco offers assured reliability anytime, anywhere. It stands as one of the world’s leading partners in
                                the Independent Aftermarket. It also tends to provide customized aftermarket solutions to protect, clean,
                                restore and personalize the customer’s vehicle. The brand is renowned for providing more than 30,000
                                vehicle parts in OE matching quality and covering all European passenger cars. </p>


                        </div>
                        <div class="col-md-6 col-lg-5 col-sm-12 rollCoLe"> 

                            <h4 class="text-danger pb-3"><i class="pr-30"><img src="images/precision.png" alt="PRECISION TO PERFECTION" class="img-fluid"></i> PRECISION TO PERFECTION</h4>

                            <p class="font13 mb-2"> Rollco stands for products which meet the highest production quality, durability and precise fitment
                                requirements. To achieve this, various quality management departments work in unison.</p>
                            <p class="font13 mb-2">Prior to the inclusion of any new spare part in the range, detailed preliminary sample tests are carried
                                out in the modern equipped test laboratory as to match the parameters of quality.</p>
                            <p class="font13 mb-5">A batch testing is conducted on the final product before actually being put into the market.</p>
                        </div>
                        <div class="col-md-6 col-lg-5 col-sm-12 rollCoRi">
                            <h4 class="text-danger pb-3"><i class="pr-41"><img src="images/innovation.svg" alt=" HEADLINE ON INNOVATION"></i>INSPIRATION TO INNOVATION </h4>

                            <p class="font13 mb-2"> We like to accept challenges when it comes to innovation. Our Research and Development team is
                                at par and ahead when it comes to product development. Development is always made considering
                                the existing needs and demand of the current market. Innovation is the path to progress.</p>
                            <p class="font13 mb-5">
                                We also assist our customers by providing cost effective product and keeping the quality intact , as
                                compared to OE. </p>
                        </div>


                        <div class="col-md-6 col-lg-5 col-sm-12 rollCoLe">
                            <h4 class="text-danger pb-3"><i class="pr-3"><img src="images/headline.svg" alt="HEADLINE ON TECHNICAL SUPPORT" class="img-fluid"></i>THRIVING TOWARDS TECHNICALITIES</h4>
                            <p class="font13 mb-2"> Technical support and customer services are the key services that lead to customer satisfaction.</p>
                            <p class="font13 mb-5">Rolling Components’ technical support team listens to the symptoms and tries to recreate and resolve
                                the issue in the best way possible. We use online and the print media to assist our customers on all
                                kinds of technical support they require.</p>

                        </div>
                    </div>
                    
                    <div class="row   d-flex rollCol justify-content-md-center text-md-center">
                        <div class="col-md-12 col-lg-6 col-sm-12   rollCoLe">
                            <h4 class="text-danger mb-20"><i class="pr-3"><img src="images/our-beliefs.svg" alt="OUR BELIEFS"></i>OUR BELIEFS</h4>
                            <p class="font13 mb-2">  Rollco products are the genuine alternative to expensive OE equivalent but at a fraction of the cost.</p>

                            <p class="font13 mb-2">At rolling components we truly believe the end user has the right to chose whether he wants a brand new OE part, Rebuilt/Repaired OE part (in most cases, surcharges are applied) or brand new alternative part where no surcharge is applied as we do not require the non working part to be returned, keeping the transaction clean and tidy without the headache of not knowing if you will get your surcharges back.</p>
                                
                               

<p class="font13 mb-5"> If you don’t mind throwing money away then yes go for the expensive alternative but why not save a little and get equivalent quality parts at exceptional prices.</p> 


                        </div>
                        
                        


                        
                    </div>
                    
                    
                </div>
            </article>
            
            <article class="clearfix pt-5 pb-5 aos-item accRedi" data-aos='fade-up'>
                <div class="container">
                    <div class="row pt-3">
                        <div class="col-12 text-center">
                            <h2 class="text-black-50 pb-2">ACCREDITATIONS AND AFFILIATIONS FORM AN <span class="text-danger font-weight-bold">EXCELLENT NETWORK!</span></h2>
                            <h3 class="text-black-50 pb-2">We have developed relationships, logistics, and services to give the best to our dealers.</h3>
                            <img src="images/excellent-network.jpg" alt="no images" class=" pt-lg-5 pb-lg-5 pt-sm-3 pb-sm-3 img-fluid">
                        </div>
                    </div>
                </div>
            </article>


            <article class="someRollco  mbr-parallax-background   clearfix">
                <div class="container padB228 padT151">
                    <div class="row ">
                        <div class="col-12 text-center">
                            <h2 class="text-white  font-italic  ">Some facts of Rollco</h2>
                        </div>
                    </div>
                    
                    <div class="row ml-0 mr-0 pt-3 justify-content-between row-flex pb-4 mbrSection aos-item" data-aos='fade-up'>
                        <div class="col-md-3 col-lg-2 text-center p-45 ">
                            <div class="p-2 bg-danger "> <span class=" pt-2 d-block"><img src="images/hm-ic-1.svg" class="img-fluid" alt="WAREHOUSE"> </span>
                                <h2 class="pt-2 numscroller display-4 text-white font-weight-500" data-slno='1' data-min='0' data-max='1' data-delay='1' data-increment="1">0 </h2>
                                <p class="font14 mb-1"> WAREHOUSE<br>
                                    FACILIITIES</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2  text-center p-45">
                            <div class=" p-2 bg-danger"> <span class="pt-2 d-block"><img src="images/hm-ic-2.svg" class="img-fluid" alt="PRODUCTS IN"> </span>
                                <h2 class=" pt-2 numscroller display-4 text-white font-weight-500" data-slno='2' data-min='0' data-max='250000' data-delay='12000' data-increment="12000">0 </h2>
                                <p class="font14 mb-1">PRODUCTS IN<br>
                                    CATALOGUE</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2  text-center p-45">
                            <div class=" p-2 bg-danger"> <span class=" pt-2 d-block"><img src="images/hm-ic-3.svg" class="img-fluid" alt="DELIVERIES"> </span>
                                <h2 class=" pt-2  numscroller display-4 text-white font-weight-500" data-slno='3' data-min='0' data-max='35000' data-delay='15000' data-increment="15000">0</h2>
                                <p class="font14 mb-1"> DELIVERIES<br>
                                    PER YEAR</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2  text-center p-45">
                            <div class=" p-2 bg-danger"> <span class="pt-2 d-block"><img src="images/hm-ic-4.svg" class="img-fluid" alt="SQUARED METERS"> </span>
                                <h2 class=" pt-2 numscroller display-4 text-white font-weight-500" data-slno='4' data-min='0' data-max='80000' data-delay='20000' data-increment="20000">0</h2>
                                <p class="font14 mb-1">SQUARE  FOOT<br>
                                    DEDICATED STORAGE</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row justify-content-center callAnsw ">
                    <div class="col-lg-9 col-md-12">
                    <div class="row mr-0 ml-0  pt-3 justify-content-between row-flex pb-4 mbrSection aos-item" data-aos='fade-up'>
                        <div class="col-md-3 col-lg-2 text-center p-45 ">
                            <div class="p-2 bg-danger ">  
                               <span class="pt-2 d-block"><img src="images/hm-ic-5.svg" class="img-fluid" alt="SQUARED METERS"> </span>
                                <p class="font14 mb-1"> <strong>Pick rate: 100%</strong>
  we mostly fulfil 100% of customers requirements</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2  text-center p-45">
                            <div class=" p-2 bg-danger">
                            <span class="pt-2 d-block"><img src="images/hm-ic-6.svg" class="img-fluid" alt="SQUARED METERS"> </span>
                                
                                <p class="font14 mb-1"><strong>Calls answered</strong> 
                                    average time to answer calls is 0.6 secs </p>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2  text-center p-45">
                            <div class=" p-2 bg-danger"> 
                              <span class="pt-2 d-block"><img src="images/hm-ic-7.svg" class="img-fluid" alt="SQUARED METERS"> </span>
                                <p class="font14 mb-1"> <strong>Next day A.M.</strong>
free delivery UK mainland (see T&C) </p>
                            </div>
                        </div>
                        
                    </div>
                    </div>
                    
                </div>
                </div>
            </article>
            <article class=" pt-4 pb-4 bg-dark clearfix aos-item" data-aos='fade-up'>
                <div class="container pb-4 pt-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-md-12 col-sm-12 text-center">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/m4grhMimEso" allowfullscreen></iframe>
                                
                               
                            </div>
                        </div>
                    </div>
                </div>
            </article>
            <article class="bgContact  mbr-parallax-background clearfix">
                <div class="mbrContArea pt-4 padB200">
                    <div class="container ">
                        <div class="row pt-5 ">
                            <div class="col-12 text-center">
                                <h2 class="text-white pb-2">CONTACT US   <hr></h2>

                            </div>
                        </div>
                        <div class="row pt-3 justify-content-center   pl-4 pr-4">
                            <div class="col-md-10 col-lg-6 col-sm-12 col-12">
                                <div class="row pt-4 justify-content-center text-center  d-flex soilWork"> <a href="https://www.facebook.com/rollco1979/" class="col-3 font18 text-white" target="_blank"><i class="pr-1"><img src="images/facebook-b.svg" alt="Facebook"></i> Facebook</a> 
                                    <a href="https://twitter.com/rollingcomp" class="col-3 font18 text-white" target="_blank"><i class="pr-1"><img src="images/twitter-b.svg" alt="Twitter"></i> Twitter</a>
                                    <a href="#" class="col-3 font18 text-white" target="_blank"><i class="pr-1"><img src="images/linkedin-b.svg" alt="Linkedin"></i> Linkedin</a> <a href="https://www.youtube.com/channel/UCKOi7APb9LtAFX_pFFs0yMA/" class="col-3 font18 text-white" target="_blank"><i class="pr-1"><img src="images/youtube.svg" alt="Youtube"></i>Youtube</a> </div>
                            </div>
                        </div>

                        <div class="row  justify-content-center text-center">
                            <div class="col-md-10 col-lg-6 col-sm-12 col-12">
                                <div class="row pt-4 justify-content-center">
                                    <div class="col-lg-5 col-md-5 col-sm-12"> 
                                        <a href="#" class="font16 text-white"><i class="pr-2"><img src="images/call2.svg" alt="Facebook"></i> +44 1268 271035</a>
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-12">  
                                        <a href="mailto:info@rollingcomponents.com" class="col-6 font16 text-white"><i class="pr-2"><img src="images/email2.svg" alt="Linkedin"></i> info@rollingcomponents.com</a>
                                    </div> </div>
                            </div>
                        </div>


                        <div class="row pt-5 pb-5 justify-content-center">
                            <div class="col-md-10 col-lg-6 col-sm-12">
                                <form method="post" id="contact_us_form">
                                    <div class="row  pb-5">
                                        <input type="hidden" name="fsub" value="1">
                                        <div class="col-sm-4 pb-4 pr-md-4">
                                            <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Name*" required>
                                        </div>
                                        <div class="col-sm-4 pb-4 pl-md-4">
                                            <input type="email" name="email_id" id="email_id" class="form-control" placeholder="Email*" required>
                                        </div>
                                        <div class="col-sm-4 pb-4 pl-md-4">
                                            <input type="tel" name="mobile_no" id="mobile_no" class="form-control" placeholder="Mobile*" onkeyup="if (/\D/g.test(this.value))
                                                        this.value = this.value.replace(/\D/g, '')" required>
                                        </div>
                                        <div class="col-12 pb-4">
                                            <textarea type="text" cols="2" rows="4" name="comments" class="form-control" id="comments" placeholder="Comments" ></textarea>
                                        </div>
                                        <!--<div class="col-sm-6 pb-3">
                                          <div class="g-recaptcha" data-sitekey="6Ld2sf4SAAAAAKSgzs0Q13IZhY02Pyo31S2jgOB5"></div>
                                        </div>-->
                                        <div class="col-sm-12 pb-3  align-self-center">
                                            <input type="submit" name="submit" value="SEND" class="form-control submit">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </section>
        <div id="myModal" class="modal fade loggedPopup">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header pt-5"></div>
                    <div class="modal-body text-center">
                        <h4>You are now logged in as <?php echo strtoupper($_SESSION['firstName']); ?></h4>
                    </div>
                    <div class="modal-footer pb-4 pt-4"><button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-toggle="modal" data-target="#exampleModalCenter">OK</button></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModalCenter" >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header pt-5"></div>      
                    <div class="modal-body text-center">
                        <h4> Welcome to Rolling Components Limited.</h4>
                    </div>
                    <div class="modal-footer pb-5"></div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <?php include("inc-footer.php"); ?>
        <script src="js/parallax.js"></script>
        <script src="js/parallax.min.js"></script>
        <?php if (isset($_SESSION['u_id']) && $_SESSION['loginmodal'] == 1) { ?>
            <script>
                                                $("#myModal").modal('show');
            </script>
            <?php
            $_SESSION['loginmodal'] = 0;
        }
        ?>
        <script>

            $(document).ready(function () {
<?php if (!isset($_SESSION['u_id'])) { ?>
                    $("#exampleModalCenter").modal('show');
                    //$("#myModal").modal('show');
                    setTimeout(function () {
                        $('#exampleModalCenter').modal('hide')
                    }, 4000);
<?php } else if ($_SESSION['loginmodal'] == 0) { ?>

                    if ($('#myModal').is(':visible') == false) {
                        $("#exampleModalCenter").modal('show');
                        //$("#myModal").modal('show');
                        setTimeout(function () {
                            $('#exampleModalCenter').modal('hide')
                        }, 4000);
                    } 
<?php } ?>
            })

            jQuery.validator.addClassRules("required", {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            });
            jQuery.validator.addMethod("alphanumeric", function (value, element) {
                return this.optional(element) || /^[\w]+$/i.test(value);
            }, "Letters and numbers only please");
            $('#contact_us_form').validate({// initialize the plugin
                rules: {
                    firstName: {
                        user_name: true,
                        alphanumeric: true
                    },
                    email_id: {
                        required: true,
                        email: true,
                    },
                    mobile_no: {
                        required: true,
                    },

                },
            });


        </script>
        
         <script>
        $('.vehicLook input').focus(function () {
    $('.bntc').addClass('yello1');
}).blur(function () {
    $('.bntc').removeClass('yello1');
	
});


</script>
    </body>
</html>