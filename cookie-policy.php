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
            <hr class="mb-2">Cookie Policy</h2>
        </div>
      </div>
    </div>
  </article>
  
  
  <article class="pb-5 mt-5 mb-5 acctDetails creatAccouText ">
    <div class="container pb-5 ">
       <div class="row pb-5 justify-content-center">
        <div class="col-lg-10 pb-5 accountInfo">
          <ul class="nav nav-tabs">
            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="javascript:void()">Cookie Policy</a> </li>
            </ul>
          <div class="tab-content newsPage">
            <div class="tab-pane active" id="technical">
              <div class="row mb-4 technical">
              <div class="col-lg-12">
              
         <p>    A cookie is a small file which asks permission to be placed on your computer's hard drive. Once you agree, the file is added and the cookie helps analyze web traffic or lets you know when you visit a particular site. Cookies allow web applications to respond to you as an individual. The web application can tailor its operations to your needs, likes and dislikes by gathering and remembering information about your preferences.</p>
<p>We use traffic log cookies to identify which pages are being used. This helps us analyze data about web page traffic and improve our website in order to tailor it to customer needs. We only use this information for statistical analysis purposes and then the data is removed from the system.
Overall, cookies help us provide you with a better website, by enabling us to monitor which pages you find useful and which you do not. A cookie in no way gives us access to your computer or any information about you, other than the data you choose to share with us.</p>
<p>You can choose to accept or decline cookies. Most web browsers automatically accept cookies, but you can usually modify your browser setting to decline cookies if you prefer. This may prevent you from taking full advantage of the website.</p>

              
              
             
              
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