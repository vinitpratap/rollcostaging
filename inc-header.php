<?php
include 'class/commonFunc.php';
$REQUESTURI = explode('/', $_SERVER['REQUEST_URI']);
$cpage = end($REQUESTURI);
?>
<div id="stickyHeader"></div>
<div class="topHeader">
  <header class="clearfix topSol">
    <div class="container clearfix">
      <div class="row solIcon ">
        <div class=" col-lg-6 col-md-8 col-sm-8 col-5 solLef align-self-center pr-0"> <a href="tel:441268271035" class="pr-3 destopHide"> +44 1268 271035 </a> <a href="tel:441268271035" class="pr-3 mobilShow">Call </a> <a href="mailto:info@rollingcomponents.com" class="destopHide email"> info@rollingcomponents.com</a> <a href="mailto:info@rollingcomponents.com" class="mobilShow email">Email</a> </div>
        <div class=" col-lg-6 col-md-4 col-sm-4 col-7 pl-0 solRig text-right align-self-center"> <a class="bntc new-range-btn mr-1" style="text-decoration: none;" href="<?php echo $siteurl?>listing.php#new_to_range">New to Range</a> <a href="https://www.facebook.com/rollingcomponents.rollco" class="mr-2" target="_blank"><img src="<?php echo $siteurl?>images/facebook.png" alt="facebook"/></a> <a href="https://twitter.com/rollingcomp" class="mr-2" target="_blank"><img src="<?php echo $siteurl?>images/twitter.png" alt="twitter"/></a>  <a href="https://instagram.com/rollingcomponents" class="mr-2" target="_blank"><img src="<?php echo $siteurl?>images/instagram.png" alt="Instagram"/></a>   <a href="https://www.linkedin.com/company/rollingcomponents/" class="mr-2" target="_blank"><img src="<?php echo $siteurl?>images/linkedin.png" alt="Linkedin"/></a>  </div>
      </div>
	  
    </div>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-162163410-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-162163410-1');
</script>
   
  </header>
  <nav class="navabarAll nav align-self-center navbar-expand-lg" >
    <div class="container">
      <div class="row ">
        <div class="logo col-5 col-lg-3 col-sm-4 col-md-3  ">
          <div class="navbar-header ">
            <button type="button" class="navbar-toggle navbar-toggle-left collapsed js-offcanvas-btn-left " > <span class="sr-only">Toggle navigation</span> </button>
          </div>
          <a href="<?php echo $siteurl?>"><img src="<?php echo $siteurl?>images/logo.svg" class="img-fluid" alt="Rolling Component Logo Automotive Parts Manufacturing Company"/></a></div>
        <div class="ml-auto col-lg-9 col-md-9 col-sm-8 col-7  align-self-center ">
          <div class="row">
            <div class="ml-auto act d-flex col-auto">
              <ul class="js-offcanvas-left mb-0 align-self-center">
			  		  <?php
            if (isset($_SESSION['u_id']) && $_SESSION['u_id'] != '') {
				$udetails_sql = "SELECT companyName FROM rollco_ms_users WHERE u_id='".$_SESSION['u_id']."' LIMIT 1";
				$usercomp = $sq->fearr($udetails_sql);
				?>
			  <li> <a href="javascript:void();" class="mobshow">WELCOME <?php echo strtoupper($usercomp['companyName']); ?></a> </li>
			<?php } ?>
                <li ><a href="<?php echo $siteurl?>" class="<?php if ($cpage == 'index.php') echo 'active'; ?> mobilShow">HOME</a> </li>
                <li ><a href="<?php echo $siteurl?>about-us.php" class="<?php if ($cpage
        == 'about-us.php') echo 'active'; ?>">ABOUT US</a> </li>
                <li ><a href="<?php echo $siteurl?>listing.php" class="<?php if ($cpage == 'listing.php') echo 'active'; ?>">CATALOGUE</a> </li>
                <li ><a href="<?php echo $siteurl?>support.php" class="<?php if ($cpage == 'support.php') echo 'active'; ?>">SUPPORT</a> </li>
                <li ><a href="<?php echo $siteurl?>news.php" class="<?php if ($cpage == 'news.php') echo 'active'; ?>">NEWS</a> </li>
               <?php //echo $siteurl.'blog/'?> <li > <a href="<?php echo $siteurl?>blog/" class="<?php if ($cpage
        == 'blog/') echo 'active'; ?>">BLOG</a> </li>
                <li > <a href="<?php echo $siteurl?>contact-us.php" class="<?php if ($cpage
        == 'contact-us.php') echo 'active'; ?>">CONTACT US</a> </li>
		  <?php
            if (isset($_SESSION['u_id']) && $_SESSION['u_id'] != '') {
				?>
			
				<li> <a href="my-recent-order.php" class="mobshow">MY ORDERS </a> </li>       
        <?php 
        $incuser_sql = "SELECT com_emailAddress,na_authentication_key FROM rollco_ms_users WHERE u_id = '" . $_SESSION['u_id'] . "' AND user_status = 2";
        $incnumsrow = $sq->numsrow($incuser_sql);
        if ($incnumsrow > 0) {
            $inc_userdata = $sq->fearr($incuser_sql);
        }

if (isset($inc_userdata['na_authentication_key']) && $inc_userdata['na_authentication_key'] != '') {
//  $inc_naurl = 'https://docs.rollingcomponents.com/public/api/newagency?authentication_key=' . $inc_userdata['na_authentication_key'] . '&emailid='.$inc_userdata['com_emailAddress'];
  $inc_naurl = 'https://docs.rollingcomponents.com/api/loginurl?authentication_key=' . $inc_userdata['na_authentication_key'] . '&emailid='.$inc_userdata['com_emailAddress'];
  ?>
    <li><a href="<?php echo $inc_naurl?>" target="_blank" class="mobshow">Download Document</a></li>    
    <?php 
}
?>

				<li> <a href="logout.php" class="mobshow">LOGOUT</a> </li>
			<?php } ?>
              </ul>
      
              <div class="dropdown ">
                <?php
                            if (isset($_SESSION['u_id']) && $_SESSION['u_id'] != '') {
                                ?>
                <a class="btn  logOut mobHide" href="<?php echo $siteurl?>logout.php">LOGOUT </a>
                <?php } else { ?>
                <a class="btn  logIn "  href="<?php echo $siteurl?>login.php">SIGNUP / LOGIN</a>
                <?php } ?>
              </div>
            </div>
          </div>
          <?php
            if (isset($_SESSION['u_id']) && $_SESSION['u_id'] != '') {
                include("inc-afterlogin-userdetails2.php");
            }
            ?>
        </div>
      </div>
    </div>
  </nav>
</div>
<div class="loading" style="display: none;">Loading&#8230;</div>
