<?php include("class/config.php"); ?>
<!doctype html>
<html>
    <head>
        <?php include("inc-head.php"); ?>
    </head>

    <body class="creatAcount">
        <?php include("inc-header.php"); ?>
        <section class="clearfix cataloGue">
            <article class="clearfix  aos-item fastEasy" data-aos='fade-up'>
                <div class="container mob-pad">
                    <div class="row m-0">
                        <div id="cataloGue" class="position-relative text-center w-100">
                            <div class="col-12 p-0"> <img src="images/create-account.jpg"  alt="create account" class="img-fluid w-100"> </div>
                            <div class="position-absolute col-lg-10 p-5 top-0">
                                <h1 class="text-white text-left pl-5 font28">FAST, EASY ORDERING STARTS HERE<br>

                                    <strong>Complete our one-time registration<br>
                                        process for fast ordering and checkout.</strong> </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
            <article class="clearfix padB200  creatAccouText aos-item" data-aos='fade-up'>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-md-12 pt-4 pb-5">
                            <form method="post" action="save_account.php" id="rollco_reg_form" enctype="multipart/form-data">
                                <input type="hidden" value="1" name="fsubmit">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="h1  font-weight-normal pb-2 color-58595b">Create an Account</h2>
                                        <p class="creatTExt"></p>
										<p class="creatTExt pb-3" style="font-size: 20px !important; ">THANK YOU</p>
                                        <p class="creatTExt pb-3" style="font-size: 20px !important; "> For your valuable time and information. We will process your form thru our Finance department and get in touch with you soon. </p>
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>    
            </article></section>



        <?php include("inc-footer.php"); ?>

       




    </body>
</html>