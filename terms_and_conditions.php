<?php include("class/config.php");  ?>
<!doctype html>
<html>
<head>
<?php include("inc-head.php");  ?>
</head>

<body class="" >
<?php include("inc-header.php");  ?>
<?php 
				  $privacySql = "SELECT term_title,term_text  FROM rollco_terms_condition LIMIT 1"; 
				  $data = $sq->fearr($privacySql);
				  
			  ?>
<section class="clearfix cataloGue">
 
   <article class="clearfix aos-item bestChoice" data-aos='fade-up'>
    <div class="container">
      <div id="cataloGue" class="position-relative text-center subHead prlogin"> <img src="images/login-page-products.jpg"  alt="banner" class="img-fluid w-100">
        <div class="position-absolute text-left pl-5">
          <h2 class="text-white electri">
            <hr class="mb-2"><?php 
			
			if(isset($data['term_title']) && $data['term_title']){
					  echo $data['term_title'];
				  }
			?></h2>
        </div>
      </div>
    </div>
  </article>
  
  
  <article class="pb-5 mt-5 mb-5 acctDetails creatAccouText ">
    <div class="container pb-5 ">
       <div class="row pb-5 justify-content-center">
        <div class="col-lg-10 pb-5 accountInfo">
          <ul class="nav nav-tabs">
            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="javascript:void()"><?php 
			
			if(isset($data['term_title']) && $data['term_title']){
					  echo $data['term_title'];
				  }
			?></a> </li>
			    </ul>
			<div class="tab-content newsPage privacyPolcy">
<div class="tab-pane active" id="technical">
<div class="row mb-4 technical">
<div class="col-lg-12 dynamicText">
			<?php 
			
			if(isset($data['term_text']) && $data['term_text']){
					  echo utf8_encode ($data['term_text']);
				  }
			?>
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