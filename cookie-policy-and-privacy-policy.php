<?php include("class/config.php");  ?>
<!doctype html>
<html>
<head>
<?php include("inc-head.php");  ?>
</head>

<body class="" >
<?php include("inc-header.php");  ?>
<section class="clearfix cataloGue">
 
   <article class="clearfix aos-item bestChoice" data-aos='fade-up'>
    <div class="container">
      <div id="cataloGue" class="position-relative text-center subHead prlogin"> <img src="images/login-page-products.jpg"  alt="banner" class="img-fluid w-100">
        <div class="position-absolute text-left pl-5">
          <h2 class="text-white electri">
            <hr class="mb-2">Cookie Policy & Privacy Policy </h2>
        </div>
      </div>
    </div>
  </article>
  
  
  <article class="pb-5 mt-5 mb-5 acctDetails creatAccouText ">
    <div class="container pb-5 ">
       <div class="row pb-5 justify-content-center">
        <div class="col-lg-10 pb-5 accountInfo">
          <ul class="nav nav-tabs">
            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="javascript:void()">COOKIES AND BENEFIT TO YOU</a> </li>
            </ul>
          <div class="tab-content newsPage privacyPolcy">
            <div class="tab-pane active" id="technical">
              <div class="row mb-4 technical">
              <div class="col-lg-12">
              
         <p class="mb-4">    Our website uses cookies, as almost all websites do, to help provide you with the best experience we can. Cookies are small text files that are placed on your computer or mobile phone when you browse websites</p>
         
<p class="mb-2"><strong>Cookies help us:</strong></p>
<ul class="mb-1">
<li><p> Make our website work better as you'd expect </p></li>
<li><p> Save you having to login every time you visit the site</p></li>
<li><p> Remember your settings during and between visits</p></li>
<li><p> Improve the speed/security of the site</p></li>
<li><p> Personalise our site to you to help you get what you need faster</p></li>
<li><p> Continuously improve our website for you</p></li>
<li><p> Make our marketing more efficient (ultimately helping us to offer the service we do at the price we do)</p></li>

</ul>


<p class="mb-2"><strong> We do not use cookies:</strong></p>
<p class="mb-2"  >Collect any personally identifiable information {without your express permission}</p>
<p class="mb-2">Collect any sensitive information {without your express permission}</p>
<p class="mb-2">Pass data to advertising networks</p>
<p class="mb-2">Pass personally identifiable data to third parties</p>
<p class="mb-2">Pay sales commissions</p>
<p class="mb-4">You can learn more about all the cookies we use below</p>
<p class="mb-2 "><strong>Granting us permission to use cookies </strong></p>
<p class="mb-4">If the settings on your software that you are using to view this website (your browser) are adjusted to accept cookies we take this, and your continued use of our website, to mean that you are fine with this. Should you wish to remove or not use cookies from our site you can learn how to do this below, however doing so will likely mean that our site will not work as you would expect.</p>
<p class="mb-2"><strong>Website function cookies & our own cookies</strong></p>
<p class="mb-2">We use cookies to make our website work including:</p>

<ul class="mb-1">
<li><p> Making our shopping basket and checkout work</p></li>
<li><p> Determining if you are logged in or not</p></li>
<li><p> Remembering your search settings</p></li>
<li><p> Tailoring content to your needs</p></li>

</ul>
<p class="mb-4"> There is no way to prevent these cookies being set other than to not use our site. </p>
<p class="mb-2"><strong>Anonymous visitor statistics cookies</strong></p>
<p class="mb-4">We use cookies to compile visitor statistics such as how many people have visited our website, what type of technology they are using (e.g. Mac or Windows which helps to identify when our site isn't working as it should for particular technologies), how long they spend on the site, what page they look at etc. This helps us to continuously improve our website. These so called analytics programs also tell us if , on an anonymous basis, how people reached this site (e.g. from a search engine) and whether they have been here before helping us to put more money into developing our services for you instead of marketing spend.</p>

<p class="mb-2"><strong>Cookies off</strong></p>
<p>You can usually switch cookies off by adjusting your browser settings to stop it from accepting cookies (Learn how here). Doing so however will likely limit the functionality of our's and a large proportion of the world's websites as cookies are a standard part of most modern websites. It may be that you concern around cookies relate to so called "spyware". Rather than switching off cookies in your browser you may find that anti-spyware software achieves the same objective by automatically deleting cookies considered to be invasive.</p>



              
              </div>
          



            </div>
          </div>

            
            
                  
          </div>
        </div>
      </div>
    </div>
  </article>
</section>
<?php include("inc-footer.php");  ?>
<script type="text/javascript">
  $(document).ready(function(){
//FAQ  
$('.hide').hide();
$('.faqRow a').click(function(){
$(this).parent('li').toggleClass('show').siblings().removeClass('show');
$(this).next('.hide').slideToggle('fast').closest('li').siblings().not(this).find('.hide').slideUp();
    });
$('.faqRow a').first().parent('li').addClass('show').find('.hide').show();    
    });

</script>
 
 

</body>
</html>