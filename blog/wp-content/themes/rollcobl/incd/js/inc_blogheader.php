
<div id="stickyHeader"></div>
<div class="topHeader">
    <header class="clearfix topSol">
        <div class="container clearfix">
            <div class="row solIcon ">
                <div class=" col-lg-6 col-md-8 col-sm-9 col-7 solLef align-self-center pr-0">
                    <a href="tel:441268271035" class="pr-3 destopHide"> +44 1268 271035 </a> <a href="tel:441268271035" class="pr-3 mobilShow">Call </a>      
                    <a href="mailto:info@rollingcomponents.com" class="destopHide email"> info@rollingcomponents.com</a> <a href="mailto:info@rollingcomponents.com" class="mobilShow email">Email</a>  </div>
                <div class=" col-lg-6 col-md-4 col-sm-3 col-5 pl-0 solRig text-right align-self-center"> <a href="https://www.facebook.com/rollco1979/" class="mr-2" target="_blank"><img src="images/facebook.svg" alt="facebook"/></a> <a href="https://twitter.com/rollingcomp" class="mr-2" target="_blank"><img src="images/twitter.svg" alt="twitter"/></a> <a href="https://www.instagram.com/rollco01/" class="mr-2" target="_blank"><img src="images/instagram.svg" alt="Instagram"/></a> <a href="https://www.youtube.com/channel/UCKOi7APb9LtAFX_pFFs0yMA/" class="" target="_blank"><img src="images/youtube2.svg" alt="linkedin"/></a> </div>
            </div>
        </div>
    </header>

    <nav class="navabarAll nav align-self-center navbar-expand-lg" >
        <div class="container">
            <div class="row ">
                <div class="logo col-5 col-lg-3 col-sm-4 col-md-3  ">
                    <div class="navbar-header ">
                        <button type="button" class="navbar-toggle navbar-toggle-left collapsed js-offcanvas-btn-left " > <span class="sr-only">Toggle navigation</span> </button>
                    </div>
                    <a href="index.php"><img src="images/logo.svg" class="img-fluid" alt=""/></a></div>
                <div class="ml-auto col-lg-9 col-md-9 col-sm-8 col-7 d-flex align-self-center ">
                    <div class="mt-20 ml-auto">
                        <ul class="js-offcanvas-left">
                            <li ><a href="index.php" class="<?php if ($cpage == 'index.php') echo 'active'; ?> mobilShow">HOME</a> </li>
                            <li ><a href="about-us.php" class="<?php if ($cpage
        == 'about-us.php') echo 'active'; ?>">ABOUT US</a> </li>
                            <li ><a href="listing.php" class="<?php if ($cpage == 'listing.php') echo 'active'; ?>">CATALOGUE</a> </li>
                            <li ><a href="support.php" class="<?php if ($cpage == 'support.php') echo 'active'; ?>">SUPPORT</a> </li>
                            <li ><a href="news.php" class="<?php if ($cpage == 'news.php') echo 'active'; ?>">NEWS</a> </li>

                            <li > <a href="contact-us.php" class="<?php if ($cpage
        == 'contact-us.php') echo 'active'; ?>">CONTACT US</a> </li>
                        </ul>
                    </div>
                    <div class="align-self-center  d-flex  logSearc">

                        <div class="dropdown">
                            <?php
                            if (isset($_SESSION['u_id']) && $_SESSION['u_id'] != '') {
                                ?>
                                <a class="btn  logOut " href="logout.php">LOGOUT </a> 
                            <?php } else { ?>
                                <a class="btn  logIn " href="login.php">SIGNUP / LOGIN</a> 
<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>