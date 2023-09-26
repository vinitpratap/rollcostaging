<?php include 'class/config.php';
if(!isset($_SESSION['u_id'])){
    header("Location: index.php");
}

if(!isset($_SESSION['rol_order_no'])){
      header("Location: shoppingCart.php");
}


?>
<!doctype html>
<html>
    <head>
        <?php include("inc-head.php"); ?>
    </head>

    <body class="myRecentOrder searchListTop">
        <?php include("inc-header.php"); ?>
        <section class="clearfix cataloGue mt-5">

            <article class="clearfix aos-item bestChoice" data-aos='fade-up'>
                <div class="container pt-5">
                    <div id="cataloGue" class="position-relative text-center subHead prlogin thankYou pt-5 pb-5">
                        <div class=" text-left pl-5 pt-5 pb-5">
                            <h2 class="text-white electri">
                                <hr class="mb-2">
                                Thankyou<br>
                                Your Order Number is - <?php if(isset($_SESSION['rol_order_no']) && $_SESSION['rol_order_no']!=''){
    echo $_SESSION['rol_order_no'];
}
?> </h2>
                        </div>
                    </div>
                </div>
            </article>



            <article class="pb-5 mb-5 pt-5 ">
                <div class="container ">
                    <div class="row ">
                        <div class="col-12 thankyou text-center    pb-3">

                        </div> </div>


                </div>
            </article>
        </section>
        <?php unset($_SESSION['rol_order_no'])?>
        <?php include("inc-footer.php"); ?>
    </body>
</html>