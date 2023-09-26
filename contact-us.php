<?php
include("class/config.php");
require 'send_maill.php';
if (isset($_POST['fsub']) && $_POST['fsub'] == 1) {

    $username = stripslashes(trim($_POST['user_name']));
    $emailid = stripslashes(trim($_POST['email_id']));
    $mobile_no = stripslashes(trim($_POST['mobile_no']));
    $comments = stripslashes(trim($_POST['comments']));


    $insertSql = "INSERT INTO rollco_contactus SET name='" . $username . "',email='" . $emailid . "',comments='" . $comments . "',cust_ip='" . $_SERVER['REMOTE_ADDR'] . "',mobile='".$mobile_no."'";

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
    </head>

    <body>
        <?php include("inc-header.php"); ?>
        <section class="clearfix cataloGue">
            <article class="bgContact mbr-parallax-background clearfix mbr-added" data-parallax-id="00026747443649585145" style="background-position: 50% 0px;">
                <div class="mbrContArea pt-4">
                    <div class="container ">
                        <div class="row pt-5 ">
                            <div class="col-12 text-center">
                                <h2 class="text-white pb-2">CONTACT US   <hr></h2>

                            </div>
                        </div>
                        <div class="row pt-3 justify-content-center  pl-4 pr-4">
                            <div class="col-md-10 col-lg-6 col-sm-12 col-12">
                                <div class="row pt-4 justify-content-center text-center d-flex soilWork"> <a href="https://www.facebook.com/rollco1979/" class="col-3 font18 text-white" target="_blank"><i class="pr-1"><img src="images/facebook-b.svg" alt="Facebook"></i> Facebook</a> 
                                    <a href="https://twitter.com/rollingcomp" class="col-3 font18 text-white" target="_blank"><i class="pr-1"><img src="images/twitter-b.svg" alt="Twitter"></i> Twitter</a>
                                     <a href="https://www.youtube.com/channel/UCKOi7APb9LtAFX_pFFs0yMA/" class="col-3 font18 text-white" target="_blank"><i class="pr-1"><img src="images/youtube.svg" alt="Youtube"></i>Youtube</a> </div>
                            </div>
                        </div>

                        <div class="row  justify-content-center text-center">
                            <div class="col-md-10 col-lg-6 col-sm-12 col-12">
                                <div class="row pt-4 justify-content-center">
                                    <div class="col-md-4 col-sm-6 col-lg-5"> 
                                        <a href="tel:441268271035" class="font16 text-white"><i class="pr-2"><img src="images/call2.svg" alt="Facebook"></i> +44 1268 271035</a>
                                    </div>
                                    <div class="col-lg-7 col-md-8 col-sm-6 col-sm-6">  
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
                                            <input type="tel" name="mobile_no" id="mobile_no" class="form-control" placeholder="Mobile*" onkeyup="if (/\D/g.test(this.value))this.value = this.value.replace(/\D/g, '')" required>
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

            <article class="clearfix pb-5">
                <div class="contact-flood ">

                    <?php /* ?>   <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d619.7082890803807!2d0.4855563792788365!3d51.58962114872801!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sIlford%20Trading%20Estate%2C%20Paycocke%20Rd%2C%20Basildon%20SS14%203DR%2C%20UK!5e0!3m2!1sen!2sin!4v1571402679231!5m2!1sen!2sin"  class="w-100 h-100 mi-500" frameborder="0" style="border:0;" allowfullscreen=""></iframe><?php */ ?>

                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2478.8574687337054!2d0.4843481161303238!3d51.58917557964862!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47d8c40f9c7c3a7b%3A0x1911ef7d7bcb46cc!2sRolling%20Components!5e0!3m2!1sen!2sin!4v1576073338037!5m2!1sen!2sin" class="w-100 h-100 mi-500" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                    
                    
                    
                   

                </div>
            </article>
        </section>



        <?php include("inc-footer.php"); ?>

        <script>
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
    </body>
</html>