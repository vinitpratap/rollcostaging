<?php include("config.php");  ?>
<!doctype html>
<html>
<head>
<?php include("inc-head.php");  ?>
</head>

<body class="myAccountDetail vehicLookup" >
<?php include("inc-header.php");  ?>
<section class="clearfix cataloGue">
  <article class="clearfix cataloTop aos-item" data-aos='fade-up'>
    <div class="container">
      <div class="row">
        <div class="col-12 text-right pt-3">
          <p class="text-danger font14 mb-0"> WELCOME CHRIS</p>
          <ul class="posLogNav d-flex float-right">
            <li class="align-self-center"><a href="account-details.php" class="text-uppercase ">MY ACCOUNT</a> </li>
            <li class="align-self-center"><a href="my-recent-order.php"  class="text-uppercase" >MY Order</a> </li>
            <li class="align-self-center"><a href="#" class="text-uppercase">My WISHLIST</a> </li>
            <li class="myCart"><a href="#"> MY CART<span>ITEM: $ 0.00</span></a></li>
          </ul>
        </div>
      </div>
    </div>
  </article>
  <article class="pb-5 mb-5 acctDetails  ">
    <div class="container pb-5 ">
      <div class="row justify-content-center">
        <div class="col-12  pb-3">
          <h2 class="text-danger"> Vehicle lookup </h2>
        </div>
      </div>
      <div class="row pb-5 justify-content-center">
        <div class="col-lg-12 pb-5">
                       <div class="row">
                  <div class="col-md-12 col-lg-12">
                  
   <div class="table-responsive table-responsive-lg table-responsive-xl">
  <table class="table table-striped w-100 table-bordered">
   
    <tr>
      <td >Part No. </td>
      <td >Add Information</td>
     
    </tr>
    
    <tr>
      <td >ALT558CP </td>
      <td >Please refer TECHNICAL BULLETIN no. TB005</td>
     
    </tr>
 
  
    
    </table>
    </div>
    
      
  <div class="vehName pb-2 pt-3"><strong>VEHICLE DETAILS</strong></div>   
     <div class="table-responsive table-responsive-lg table-responsive-xl ">
  <table class="table table-striped w-100 table-bordered">
    
    <tr>
     
      <td>MAKE</td>
      <td>KIA</td>
    
      
    </tr>
    
    <tr>
     
      <td>MODEL</td>
      <td>SPORTAGE XE CRDI (MK2 FL (FL))</td>

      
    </tr>
    <tr>
     
      <td>YEAR</td>
      <td>2010</td>

      
    </tr>
    <tr>
     
      <td>ENGINE SIZE</td>
      <td>2</td>

      
    </tr>
    
    </table>
    </div>
     
    
  
    
    
    
    <div class="table-responsive-md table-responsive-lg table-responsive-xl">
  <table class="table table-striped  table-bordered imgTabl">
    
    <tr>
     
      <td>Part Name</td>
      <td>Part Name</td>
      <td>Part No.</td>
      <td>Description</td>
      <td>Voltage</td>
      <td>Output</td>
      <td>Availability</td>
      <td>Price</td>
      <td>Add Info</td>
      <td>Qty</td>
      <td>Cart</td>
      
     
      
    </tr>
    
    
    <tr>
     
      <td> <img src="images/ALT558CP-F.jpg"></td>
      <td> <img src="images/TB-005.jpg"></td>
      
      <td>ALT558CP</td>
      <td>Hyundai, With<br>
      Vaccum Pump</td>
      <td>12V</td>
      <td>120A</td>
      
      <td>In Stock</td>
      <td></td>
      <td>Please refer<br>
 TECHNICAL BULLETIN<br>
 no. TB005</td>
      <td><div class="qty">
                  <button type="button" id="sub" class="sub">-</button>
                  <input type="text" id="1" value="1" class="field">
                  <button type="button" id="add" class="add">+</button>
                </div></td>
      
      <td> <a href="javascript:void()"> <img src="images/my-cart.svg" class=" img-fluid pt-2"> </a></td>
      
     
      
    </tr>
    </table>
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
</body>
</html>