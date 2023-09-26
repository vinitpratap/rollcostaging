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
  <article class="pb-5 mb-5 acctDetails creatAccouText ">
    <div class="container pb-5 ">
      <div class="row justify-content-center">
        <div class="col-9  pb-3">
          <h2 class="text-danger"> Vehicle lookup </h2>
        </div>
      </div>
      <div class="row pb-5 justify-content-center">
        <div class="col-lg-9 pb-5">
          <form>
          <div class="row pb-2 mb-5 justify-content-between">
                <div class="col-md-4  col-12 pb-4 pt-4">
                    <p>Vehicle lookup</p>                  
                  </div>
                  <div class="col-md-8 col-12 pb-4 ">
                    <label for="Enterproduct">Enter Product Code</label>
                    <input type="text" name="Enterproduct"  class="form-control" id="Enterproduct" placeholder="Enter Product Code" >
                  </div>
                  <div class="col-12"><hr class="boderColor" ></div>
                </div>
                
            <div class="row justify-content-between">
              <div class="col-lg-4 col-md-6 col-sm-12">
                
                <div class="row">
                  <div class="col-md-12 col-12 erroMas">
                    <p> Product Not Found !!!!!!!!! </p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-12 pb-4">
                    <label for="product">Product:</label>
                    <select class="form-control" id="product" >
                      <option selected="selected" value="Select Product">Select Product</option>
                      <option value="Alternator">Alternator</option>
                      <option value="Starter Motor">Starter Motor</option>
                      <option value="Air Flow Meter">Air Flow Meter</option>
                      <option value="EGR Valve">EGR Valve</option>
                      <option value="Ignition coil">Ignition coil</option>
                      <option value="Brake Calliper">Brake Calliper</option>
                      <option value="Steering Pump">Steering Pump</option>
                      <option value="CV Joint">CV Joint</option>
                      <option value="Drive Shaft">Drive Shaft</option>
                    </select>
                  </div>
                  <div class="col-md-12 col-12 pb-4">
                    <label for="make">Make:</label>
                    <select class="form-control" id="Make" >
                      <option selected="selected" value="0"> Select Make </option>
                      <option value="ALFA ROMEO">ALFA ROMEO</option>
                      <option value="AUDI">AUDI</option>
                      <option value="BMW">BMW</option>
                      <option value="CITROËN">CITROËN</option>
                      <option value="FIAT">FIAT</option>
                      <option value="FORD">FORD</option>
                      <option value="HONDA">HONDA</option>
                      <option value="HYUNDAI">HYUNDAI</option>
                      <option value="JAGUAR">JAGUAR</option>
                      <option value="KIA">KIA</option>
                      <option value="LANDROVER">LANDROVER</option>
                      <option value="MAZDA">MAZDA</option>
                      <option value="MERCEDES-BENZ">MERCEDES-BENZ</option>
                      <option value="MINI">MINI</option>
                      <option value="NISSAN">NISSAN</option>
                      <option value="OPEL">OPEL</option>
                      <option value="PEUGEOT">PEUGEOT</option>
                      <option value="RENAULT">RENAULT</option>
                      <option value="ROVER">ROVER</option>
                      <option value="SAAB">SAAB</option>
                      <option value="SEAT">SEAT</option>
                      <option value="SKODA">SKODA</option>
                      <option value="SUBARU">SUBARU</option>
                      <option value="TOYOTA">TOYOTA</option>
                      <option value="VAUXHALL">VAUXHALL</option>
                      <option value="VOLKSWAGEN">VOLKSWAGEN</option>
                      <option value="VOLVO">VOLVO</option>
                    </select>
                  </div>
                  <div class="col-md-12 col-12 pb-4">
                    <label for="model">Model:</label>
                    <select class="form-control" id="model" >
                      <option selected="selected" value="Select Model">Select Model </option>
                      <option value="ALFA ROMEO MITO (955_)1.4">ALFA ROMEO MITO (955_)1.4</option>
                      <option value="ALFA ROMEO MITO (955_)1.4 (955AXB1B)">ALFA ROMEO MITO (955_)1.4 (955AXB1B)</option>
                    </select>
                  </div>
                  <div class="col-md-12 col-12 pb-4">
                    <label for="year">Year:</label>
                    <select class="form-control" id="year" >
                      <option selected="selected" value="Select Year">Select Year</option>
                      <option value="2011- On">2011- On</option>
                    </select>
                  </div>
                  <div class="col-md-12 col-12 pb-4">
                    <label for="exactCcm">Exact CCM:</label>
                    <select class="form-control" id="exactCcm" >
                      <option selected="selected" value="Select CC">Select CC</option>
                      <option value="1368CCM">1368CCM</option>
                    </select>
                  </div>
                  <div class="col-md-12 col-12 pb-4">
                    <label for="engineCode">Select Engine Code</label>
                    <select class="form-control" id="engineCode" >
                      <option value="Select Engine Code">Select Engine Code</option>
                      <option value="    -"> -</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-lg-8 col-md-6 col-sm-12">
              <div class="row">
                <div class="col-md-12 col-12 pb-4">
                   <label for="product">Product:</label>
                   <select class="form-control" id="product" >
                   <option value="Select Product">Select Product</option>
				<option  value="Alternator">Alternator</option>
				<option value="Starter Motor">Starter Motor</option>
				<option value="Air Flow Meter">Air Flow Meter</option>
				<option value="EGR Valve">EGR Valve</option>
				<option value="Ignition coil">Ignition coil</option>
				<option value="Brake Calliper">Brake Calliper</option>
				<option value="Steering Pump">Steering Pump</option>
				<option value="CV Joint">CV Joint</option>
				<option value="Drive Shaft">Drive Shaft</option>
                    </select>
                  </div>
                  
                  <div class="col-md-12 col-12 pb-4">
                    <label for="product">Enter your reg no</label>
                     <input type="text" name="Enterproduct"  class="form-control enterYouReg" id="Enterproduct" placeholder="Enter Product Code" >
                  </div>                  
                 
                  
                  <div class="col-md-12">
                  
   <div class="table-responsive">
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

  
     <div class="table-responsive">
  <table class="table table-striped table-bordered">
    
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
     
    </div>
    </div>
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
    
    
    
    </form>

        </div>
      </div>
    </div>
    
  </article>
</section>
<?php include("inc-footer.php");  ?>
</body>
</html>