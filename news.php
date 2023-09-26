<?php include("class/config.php"); ?>
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
                        <div class="position-absolute text-left pl-5 support-head">
                            <h2 class="text-white electri">
                                <hr class="mb-2">News</h2>
                        </div>
                    </div>
                </div>
            </article>


            <article class="pb-5 mt-5 mb-5 acctDetails creatAccouText ">
                <div class="container pb-5 ">
                    <div class="row pb-5 justify-content-center">
                        <div class="col-lg-10 pb-5 accountInfo">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="javascript:void()">News</a> </li>
                            </ul>
                            <div class="tab-content newsPage">
                                <div class="tab-pane active" id="technical">
                                    <div class="row mb-4 technical">
                                        <div class="col-lg-12">
                                            <ul>

                                                <?php
                                                $newsSql = "SELECT news_text FROM rollco_ms_news ORDER BY created_at ASC";
                                                $newsData = $sq->query($newsSql);
                                                while ($newsRes = $sq->fetch($newsData)) {
                                                    ?>
                                                 <li><?php echo $newsRes['news_text'];?></li>
                                                    <?php
                                                }
                                                ?>

                                            </ul>

                                        </div>




                                    </div>
                                </div>




                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </section>
        <?php include("inc-footer.php"); ?>
        <script type="text/javascript">
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