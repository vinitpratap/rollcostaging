<?php
include("class/config.php");
require 'send_maill.php';
$msg = '';
if (isset($_POST['fsub']) && $_POST['fsub'] == 1) {
    $emailid = stripslashes(trim($_POST['usr_email']));
    $checksql = "select u_id,firstName,lastName,com_emailAddress,companyName from rollco_ms_users WHERE com_emailAddress = '" . $emailid . "' LIMIT 1";

    $numsrow = $sq->numsrow($checksql);

    if ($numsrow > 0) {
        $userData = $sq->fearr($checksql);
        $fname = $userData['companyName'];

        $changedPwd = generatePIN(6);

        $updateUserSql = "UPDATE rollco_ms_users SET password='" . md5($changedPwd) . "' WHERE com_emailAddress = '" . $emailid . "' LIMIT 1";

        $status = $sq->query($updateUserSql);


        if ($status) {
            $subject = "Rolling Components :  Forget Password";

            ob_start();
            require("mailer/forget-password.php");
            $body = ob_get_contents();
            ob_end_clean();

// message
            $message = $body;

// Additional headers

            if ($_SERVER['HTTP_HOST'] != 'localhost') {
                //mail($userData['com_emailAddress'], $subject, $message, $usr_headers);
                $to = new SendGrid\Email(null, $userData['com_emailAddress']);
                $content = new SendGrid\Content("text/html", $message);
                $mail = new SendGrid\Mail($fromEml, $subject, $to, $content);
				$email2 = new SendGrid\Email(null, "info@rollingcomponents.com");
				$mail->personalization[0]->addBcc($email2);
                $sg = new \SendGrid($API_KEY);
                $response = $sg->client->mail()->send()->post($mail);
                if ($response->statusCode() == 202) {
                    
                } else {
                    echo 'issue with sending email on ' . $userData['com_emailAddress'];
                }
            }
            $msg = "Your password has been sent to your registered email id";
        }
    } else {
        $msg = "You are not registered with us.";
    }
}
?>


<!doctype html>
<html>
    <head>
        <?php include("inc-head.php"); ?>
    </head>

    <body class="" >
        <?php include("inc-header.php"); ?>
        <section class="clearfix cataloGue">

            <article class="clearfix aos-item bestChoice" data-aos='fade-up'>
                <div class="container mob-pad">
                    <div id="cataloGue" class="position-relative text-center subHead prlogin"> <img src="images/login-page-products.jpg"  alt="banner" class="img-fluid w-100">
                        <div class="position-absolute text-left pl-5">
                            <h2 class="text-white electri"><hr class="mb-2">Forgot Password</h2>
                        </div>
                    </div>
                </div>
            </article>


            <article class="pb-5 mt-5 mb-5 acctDetails creatAccouText forgetPossword ">
                <div class="container pb-5 ">
                    <div class="row pb-5 justify-content-center">
                        <div class="col-lg-10 pb-5 accountInfo">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="javascript:void()">Forgot Password</a> </li>
                            </ul>
                            <div class="tab-content newsPage">
                                <div class="tab-pane active" id="technical">

                                    <?php if (strlen($msg) > 0) {
                                        echo $msg;
                                    } ?>
                                    <form method="post" id="forgetPwdForm">
                                        <input type="hidden" value="1" name="fsub">
                                        <div class="row">
                                            <div class="col-md-5 col-12 ">
                                                <label for="oldpassword">Please enter your registered email id. </label>
                                                <input type="email"  name="usr_email" id="usr_email" class="form-control" placeholder="Email" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="row ">
                                            <div class="col-md-2 col-12 pb-4">
                                                <input type="submit" class="btn chanAddres w-100" value="Submit">
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </section>
<?php include("inc-footer.php"); ?>
        <script type="text/javascript">
            jQuery.validator.addMethod("noSpace", function (value, element) {
                return value.indexOf(" ") < 0 && value != "";
            }, "This field is required.");
            $('#forgetPwdForm').validate({// initialize the plugin
                rules: {
                    usr_email: {
                        required: true,
                        email: true,
                        noSpace: true
                    },
                },
                messages: {
                    email: "Please enter valid email",
                },
            });
            $(document).ready(function () {
                //FAQ  
                $('.hide').hide();
                $('.faqRow a').click(function () {
                    $(this).parent('li').toggleClass('show').siblings().removeClass('show');
                    $(this).next('.hide').slideToggle('fast').closest('li').siblings().not(this).find('.hide').slideUp();
                });
                $('.faqRow a').first().parent('li').addClass('show').find('.hide').show();
            });

        </script>



    </body>
</html>