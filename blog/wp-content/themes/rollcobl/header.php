<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
    <link href="<?php echo get_template_directory_uri(); ?>/incd/css/blog.css" type="text/css" rel="stylesheet" />
    <script src="<?php echo get_template_directory_uri(); ?>/incd/js/filename.js" type="text/javascript"></script>
</head>

<body <?php body_class(); ?>>

<?php include("incd/inc_bloghead.php");  ?>

<div id="stickyHeader"></div>
<div class="topHeader">
    <?php /*?><header class="clearfix topSol">
        <div class="container clearfix">
            <div class="row solIcon ">
                <div class=" col-lg-6 col-md-8 col-sm-9 col-7 solLef align-self-center pr-0">
                    <a href="tel:441268271035" class="pr-3 destopHide"> +44 1268 271035 </a> <a href="tel:441268271035" class="pr-3 mobilShow">Call </a>      
                    <a href="mailto:info@rollingcomponents.com" class="destopHide email"> info@rollingcomponents.com</a> <a href="mailto:info@rollingcomponents.com" class="mobilShow email">Email</a>  </div>
                <div class=" col-lg-6 col-md-4 col-sm-3 col-5 pl-0 solRig text-right align-self-center"> 
					<a class="bntc new-range-btn mr-1" style="text-decoration: none;" href="https://www.rollingcomponents.com/listing.php#new_to_range">New to Range</a>
					<a href="https://www.facebook.com/rollco1979/" class="mr-2" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/incd/images/facebook.svg" alt="facebook"/></a> <a href="https://twitter.com/rollingcomp" class="mr-2" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/incd/images/twitter.svg" alt="twitter"/></a> <a href="https://www.instagram.com/rollco01/" class="mr-2" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/incd/images/instagram.svg" alt="Instagram"/></a> <a href="https://www.youtube.com/channel/UCKOi7APb9LtAFX_pFFs0yMA/" class="" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/incd/images/youtube2.svg" alt="linkedin"/></a> </div>
            </div>
        </div>
    </header><?php */?>

	<header class="clearfix topSol">
    <div class="container clearfix">
      <div class="row solIcon ">
        <div class=" col-lg-6 col-md-8 col-sm-8 col-5 solLef align-self-center pr-0"> <a href="tel:441268271035" class="pr-3 destopHide"> +44 1268 271035 </a> <a href="tel:441268271035" class="pr-3 mobilShow">Call </a> <a href="mailto:info@rollingcomponents.com" class="destopHide email"> info@rollingcomponents.com</a> <a href="mailto:info@rollingcomponents.com" class="mobilShow email">Email</a> </div>
        <div class=" col-lg-6 col-md-4 col-sm-4 col-7 pl-0 solRig text-right align-self-center"> 
			<a class="bntc new-range-btn mr-1" style="text-decoration: none;" href="https://www.rollingcomponents.com/listing.php#new_to_range">New to Range</a> 
			<a href="https://www.facebook.com/rollingcomponents.rollco" class="mr-2" target="_blank"><img src="https://www.rollingcomponents.com/images/facebook.png" alt="facebook"/></a> 
			<a href="https://twitter.com/rollingcomp" class="mr-2" target="_blank"><img src="https://www.rollingcomponents.com/images/twitter.png" alt="twitter"/></a> <a href="https://instagram.com/rollingcomponents" class="mr-2" target="_blank"><img src="https://www.rollingcomponents.com/images/instagram.png" alt="Instagram"/></a>   
			<a href="https://www.linkedin.com/company/rollingcomponents/" class="mr-2" target="_blank"><img src="https://www.rollingcomponents.com/images/linkedin.png" alt="Linkedin"/></a>  
		</div>
      </div>
	  
    </div>
  
  </header>
    <?php /*?><nav class="navabarAll nav align-self-center navbar-expand-lg" >
        <div class="container">
            <div class="row ">
                <div class="logo col-5 col-lg-3 col-sm-4 col-md-3  ">
                    <div class="navbar-header ">
                        <button type="button" class="navbar-toggle navbar-toggle-left collapsed js-offcanvas-btn-left " > <span class="sr-only">Toggle navigation</span> </button>
                    </div>
                    <a href="http://rollco.studiobrahma.in/index.php"><img src="<?php echo get_template_directory_uri(); ?>/incd/images/logo.svg" class="img-fluid" alt=""/></a></div>
                <div class="ml-auto col-lg-9 col-md-9 col-sm-8 col-7 d-flex align-self-center ">
                    <div class="mt-20 ml-auto">
                        <ul class="js-offcanvas-left">
                            <li ><a href="http://rollco.studiobrahma.in/about-us.php" class="mobilShow">HOME</a> </li>
                            <li ><a href="about-us.php" >ABOUT US</a> </li>
                            <li ><a href="http://rollco.studiobrahma.in/listing.php">CATALOGUE</a> </li>
                            <li ><a href="http://rollco.studiobrahma.in/support.php">SUPPORT</a> </li>
                            <li ><a href="http://rollco.studiobrahma.in/news.php">NEWS</a> </li>
 <li > <a href="http://rollco.studiobrahma.in/blog/" class="active">BLOG</a> </li>
                            <li > <a href="http://rollco.studiobrahma.in/contact-us.php">CONTACT US</a> </li>
                        </ul>
                    </div>
                    <div class="align-self-center  d-flex  logSearc">

                        <div class="dropdown">
                            <?php
                            if (isset($_SESSION['u_id']) && $_SESSION['u_id'] != '') {
                                ?>
                                <a class="btn  logOut " href="http://rollco.studiobrahma.in/logout.php">LOGOUT </a> 
                            <?php } else { ?>
                                <a class="btn  logIn " href="http://rollco.studiobrahma.in/login.php">SIGNUP / LOGIN</a> 
<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav><?php */?>
	<nav class="navabarAll nav align-self-center navbar-expand-lg" >
		<div class="container">
		  <div class="row ">
			<div class="logo col-5 col-lg-3 col-sm-4 col-md-3  ">
			  <div class="navbar-header ">
				<button type="button" class="navbar-toggle navbar-toggle-left collapsed js-offcanvas-btn-left " > <span class="sr-only">Toggle navigation</span> </button>
			  </div>
			  <a href="https://www.rollingcomponents.com/"><img src="https://www.rollingcomponents.com/images/logo.svg" class="img-fluid" alt="Rolling Component Logo Automotive Parts Manufacturing Company"/></a></div>
			<div class="ml-auto col-lg-9 col-md-9 col-sm-8 col-7  align-self-center ">
			  <div class="row">
				<div class="ml-auto act d-flex col-auto">
				  <ul class="js-offcanvas-left mb-0 align-self-center">
										  <li ><a href="https://www.rollingcomponents.com/" class=" mobilShow">HOME</a> </li>
					<li ><a href="https://www.rollingcomponents.com/about-us.php" class="">ABOUT US</a> </li>
					<li ><a href="https://www.rollingcomponents.com/listing.php" class="">CATALOGUE</a> </li>
					<li ><a href="https://www.rollingcomponents.com/support.php" class="">SUPPORT</a> </li>
					<li ><a href="https://www.rollingcomponents.com/news.php" class="">NEWS</a> </li>
					<li > <a href="#" class="">BLOG</a> </li>
					<li > <a href="https://www.rollingcomponents.com/contact-us.php" class="">CONTACT US</a> </li>
							</ul>

				  <div class="dropdown ">
									<a class="btn  logIn "  href="https://www.rollingcomponents.com/login.php">SIGNUP / LOGIN</a>
								  </div>
				</div>
			  </div>
					  </div>
		  </div>
		</div>
  </nav>
</div>
<?php wp_body_open(); ?>
<div id="content" class="site-content">
<div id="page" class="site">
	<div class="site-inner">
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentysixteen' ); ?></a>

		<!-- .site-header -->

