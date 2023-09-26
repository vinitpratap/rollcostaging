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
            <hr class="mb-2">PRIVACY POLICY </h2>
        </div>
      </div>
    </div>
  </article>
  
  
  <article class="pb-5 mt-5 mb-5 acctDetails creatAccouText ">
    <div class="container pb-5 ">
       <div class="row pb-5 justify-content-center">
        <div class="col-lg-10 pb-5 accountInfo">
          <ul class="nav nav-tabs">
            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="javascript:void()">PRIVACY POLICY </a> </li>
            </ul>
          <div class="tab-content privacyPolcy">
            <div class="tab-pane active" id="technical">
              <div class="row mb-4 technical">
              <div class="col-lg-12">
              
        <p> This privacy policy sets out how Rolling Components uses and protects any information that you give Rolling Components when you use this website.
Rolling Components is committed to ensuring that your privacy is protected. Should we ask you to provide certain information by which you can be identified when using this website, then you can be assured that it will only be used in accordance with this privacy statement.</p>
<p class="mb-4">Rolling Components may change this policy from time to time by updating this page. You should check this page from time to time to ensure that you are happy with any changes. This policy is effective from 01st January 2019.</p>
<p class="mb-2"><strong>What we collect</strong></p>
<p class="mb-2"><strong>We may collect the following information:</strong></p>
    <ul class="mb-1">
	<li><p>Name and job title</p></li>
	<li><p>Contact information including email address</p></li>
	<li><p>Demographic information such as postcode, preferences and interests</p></li>
  <li> <p>Other information relevant to customer surveys and/or offers</p></li>
  </ul>
<p><strong>What we do with the information we gather</strong></p>
<p class="mb-2">We require this information to understand your needs and provide you with a better service, and in particular for the following reasons:</p>
<ul class="mb-1">
<li><p>Internal record keeping.</p></li>
<li><p>We may use the information to improve our products and services.</p></li>
</ul>
<p class="mb-4">We may periodically send promotional emails about new products, special offers or other information which we think you may find interesting using the email address which you have provided. From time to time, we may also use your information to contact you for market research purposes. We may contact you by email, phone, fax or mail. We may use the information to customize the website according to your interests.</p>

<p class="mb-2"><strong>Security</strong></p>
<p  class="mb-4">We are committed to ensuring that your information is secure. In order to prevent unauthorized access or disclosure, we have put in place suitable physical, electronic and managerial procedures to safeguard and secure the information we collect online.</p>

<p class="mb-2"><strong>How we use cookies</strong></p>
<p>A cookie is a small file which asks permission to be placed on your computer's hard drive. Once you agree, the file is added and the cookie helps analyze web traffic or lets you know when you visit a particular site. Cookies allow web applications to respond to you as an individual. The web application can tailor its operations to your needs, likes and dislikes by gathering and remembering information about your preferences.</p>

<p>We use traffic log cookies to identify which pages are being used. This helps us analyze data about web page traffic and improve our website in order to tailor it to customer needs. We only use this information for statistical analysis purposes and then the data is removed from the system.</p>
<p>Overall, cookies help us provide you with a better website, by enabling us to monitor which pages you find useful and which you do not. A cookie in no way gives us access to your computer or any information about you, other than the data you choose to share with us.</p>

<p class="mb-4">You can choose to accept or decline cookies. Most web browsers automatically accept cookies, but you can usually modify your browser setting to decline cookies if you prefer. This may prevent you from taking full advantage of the website.</p>

<p class="mb-2"><strong>Links to other websites</strong></p>

<p class="mb-4">Our website may contain links to other websites of interest. However, once you have used these links to leave our site, you should note that we do not have any control over that other website. Therefore, we cannot be responsible for the protection and privacy of any information which you provide whilst visiting such sites and such sites are not governed by this privacy statement. You should exercise caution and look at the privacy statement applicable to the website in question.</p>
<p class="mb-2"> <strong>Controlling your personal information</strong> </p> 
<p class="mb-2" >You may choose to restrict the collection or use of your personal information in the following ways:</p>
<ul>
<li>
<p>whenever you are asked to fill in a form on the website, look for the box that you can click to indicate that you do not want the information to be used by anybody for direct marketing purposes</p> </li>
<li><p>if you have previously agreed to us using your personal information for direct marketing purposes, you may change your mind at any time by writing to or emailing us at info@rollingcomponents.com.</p></li>
<p>We will not sell, distribute or lease your personal information to third parties unless we have your permission or are required by law to do so. We may use your personal information to send you promotional information about third parties which we think you may find interesting if you tell us that you wish this to happen.</p>
<p>You may request details of personal information which we hold about you under the Data Protection Act 1998. A small fee may charge if applicable. If you would like a copy of the information held on you please write to info@rollingcomponents.com.</p>
<p>If you believe that any information we are holding on you is incorrect or incomplete, please write to or email us as soon as possible, at the above address. We will promptly correct any information found to be incorrect.</p>


              
              
             
              
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