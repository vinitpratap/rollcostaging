<?php include("config.php");  ?>
<!doctype html>
<html>
<head>
 <?php include("inc-head.php");  ?>
</head>

<body>
<?php include("inc-header.php");  ?>
<section class="clearfix cataloGue">
  <article class="clearfix aos-item" data-aos='fade-up'>
    <div class="container">
      <div id="cataloGue" class="position-relative text-center subHead"> <img src="images/catalogue.jpg"  alt="banner" class="img-fluid w-100">
        <div class="position-absolute">
          <h2>ROLLCO AS YOUR <hr>        
          </h2>
          <div class="clearfix"></div>
          <h2>  FIRST CHOICE
           <hr>  
          </h2>
        </div>
      </div>
    </div>
  </article>
  <article class="clearfix rollcoPartsf " >
    <div class="container">
      <div class="bg-dark pt-4 pb-4">
        <div class="row justify-content-center mr-0 ml-0">
        <div class="col-lg-8 col-md-12 col-sm-12 col-12">
        <div class="row justify-content-center mr-0 ml-0">
          <div class="col-lg-3 pl-0 col-sm-3 col-md-3 col-12 rollcoPartLe">
            <h1 class="text-danger h2"> ROLLCO
              PARTSFINDER</h1>
            <h2 class="pt-5 h3 font-weight-normal text-white"> FIND THE <br>
              RIGHT PART <strong class="d-block">FOR YOUR<br>
              VEHICLE</strong></h2>
          </div>
          <div class="col-lg-9 pr-0  col-sm-9  col-md-9 col-12 pt-4 mt-5 rollcoPartRi  ">
            <ul class="nav nav-tabs d-flex bg-light">
               <li class="nav-item col-4 p-0 text-center"> <a class="nav-link" data-toggle="tab" href="#keyword-part">OEM SEARCH</a> </li>
             
              <li class="nav-item col-4 p-0 text-center"> <a class="nav-link " data-toggle="tab" href="#vehicle-lookup">VEHICLE SEARCH</a> </li>
               <li class="nav-item  col-4 p-0 text-center"> <a class="nav-link active" data-toggle="tab" href="#search-by-car">CAR REGISTRATION SEARCH   </a> </li>
           
            </ul>
            <div class="tab-content pt-4">
              <div id="search-by-car" class="tab-pane active ">
                <p class="font12 text-white">If you know the specific keyword or part number you'd like to order, you may enter it here.</p>
                <div class="row">
                  <div class="col-md-9 col-8 input-field">
                    <form action="./product-review-page.php" class="vehicLook">
                      <input type="email" name="email_id" id="email_id" placeholder="Enter Keyword/Part Number">
                      <input id="sbtnSubmit" class="bntc bg-danger border-danger" type="submit" name="submit" value="SEARCH">
                    </form>
                  </div>
                </div>
              </div>
              <div id="vehicle-lookup" class="tab-pane  ">
                <form action="login-page-products.php" class="vehicLook">
                  <div  class="row">
                    <div class="col-md-3 col-6 pb-3">
                      <label for="product">PRODUCT*</label>
                      <select class="form-control" id="product">
                        <option>product</option>
                      </select>
                    </div>
                    <div class="col-md-3 col-6 pb-3">
                      <label for="make">MAKE*</label>
                      <select class="form-control" id="make">
                        <option>make</option>
                      </select>
                    </div>
                    <div class="col-md-3 col-6 pb-3">
                      <label for="model">MODEL*</label>
                      <select class="form-control" id="model">
                        <option>model</option>
                      </select>
                    </div>
                    <div class="col-md-3 col-6 pb-3">
                      <label for="year" class=" text">YEAR*</label>
                      <select class="form-control" id="year">
                        <option>year</option>
                      </select>
                    </div>
                  </div>
                  <div  class="row">
                    <div class="col-md-3 col-6 pb-3">
                      <label for="exact-ccm">EXACT CCM</label>
                      <select class="form-control" id="exact-ccm">
                        <option>exact ccm</option>
                      </select>
                    </div>
                    <div class="col-md-3 col-6 pb-3">
                      <label for="engine-code">ENGINE CODE</label>
                      <select class="form-control" id="engine-code">
                        <option>engine code</option>
                      </select>
                    </div>
                    <div class="col-md-3 col-6 pb-3 ml-auto  float-right">
                      <label for="product">&nbsp;</label>
                      <input id="sbtnSubmit" class="bg-danger border-danger form-control text-white" type="submit" name="submit" value="SEARCH">
                    </div>
                  </div>
                </form>
              </div>
              <div id="keyword-part" class="tab-pane fade">
               <div class="row">
                  <div class="col-md-12 col-12 input-field">
                    <form action="./product-review-page.php" class="vehicLook">
                      <input type="email" name="email_id" id="email_id" placeholder="Enter Keyword/Part Number">
                      <input id="sbtnSubmit" class="bntc bg-danger border-danger" type="submit" name="submit" value="SEARCH">
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
      </div>
    </div>
    
  </article>
  <article class=" pt-5 clearfix padB200 aos-item findMain" data-aos='fade-up'>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-12 text-center">
          <p class="font16 mb-5">Rollco offers more than 30,000 different replacement parts for over 70 listed vehicle manufacturers . It provides
tailored aftermarket solutions to protect, clean, restore and personalize its customer’s vehicles. With high quality
products, customized marketing solutions and a customer focused team, ROLLCO gives you the tools, products
and the support you need to drive your aftermarket performance.</p>
          <p class="font16 mb-5"> ROLLCO is in a process of continuous development. This includes the scheduled expansion of the existing product,
lining up to the full-range provider as well as the short-term implementation of new program lines.</p>
        </div>
      </div>
      <div class="row justify-content-center ml-0 mr-0 mb-5 findYour">
        <div class="col-12 pl-5 pr-5 pt-5 bg-light text-center">
          <h2 class="text-danger font-weight-normal pb-4">FIND YOUR WAY TO OUR PRODUCTS</h2>
          
          <div class="row justify-content-center  findRow">
          <div class="col-9">
          <div class="row justify-content-center ml-0 mr-0">
            <div class="col-lg-4 col-sm-6 col-12 findCol pb-5">
              <div class="row bg-white d-flex m-0 border-bottom pt-2 pb-2">
                <div class="col-6 position-relative subHead">
                  <div class=" position-absolute text-left pl-3">
                    <h6>ELECTRICAL</h6>
                    <a href="#" class=" shopNow">SHOP NOW <i class="d-inline-block pl-1"> <img src="images/our-products/shop-now.png" alt="SHOP NOW "></i></a> </div>
                </div>
                <div class="col-lg-6 col-5 pr-0"> <img src="images/our-products/electrical.jpg" class="img-fluid" alt="ELECTRICAL"></div>
              </div>
            </div>
             <div class="col-lg-4 col-sm-6 col-12 findCol pb-5">
             <div class="row bg-white d-flex m-0 border-bottom pt-2 pb-2 ml-0 mr-0">
                <div class="col-6 position-relative subHead">
                  <div class=" position-absolute text-left pl-3">
                    <h6>ENGINE MANAGEMENT</h6>
                    <a href="#" class=" shopNow">SHOP NOW <i class="d-inline-block pl-1"> <img src="images/our-products/shop-now.png" alt="SHOP NOW "></i></a> </div>
                </div>
                <div class="col-lg-6 col-6 pr-0"> <img src="images/our-products/engine-management.jpg" class="img-fluid" alt="ENGINE MANAGEMENT"></div>
              </div>
            </div>
             <div class="col-lg-4 col-sm-6 col-12 findCol pb-5">
             <div class="row bg-white d-flex m-0 border-bottom pt-2 pb-2">
                <div class="col-6 position-relative subHead">
                  <div class=" position-absolute text-left pl-3">
                    <h6>BRAKE</h6>
                    <a href="#" class=" shopNow">SHOP NOW <i class="d-inline-block pl-1"> <img src="images/our-products/shop-now.png" alt="SHOP NOW "></i></a> </div>
                </div>
                <div class="col-lg-6 col-6 pr-0"> <img src="images/our-products/brake.jpg" class="img-fluid" alt="BRAKE"></div>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 findCol pb-5">
             <div class="row bg-white d-flex m-0 border-bottom pt-2 pb-2">
                <div class="col-6 position-relative subHead">
                  <div class=" position-absolute text-left pl-3">
                    <h6>STEERING & SUSPENSION</h6>
                    <a href="#" class=" shopNow">SHOP NOW <i class="d-inline-block pl-1"> <img src="images/our-products/shop-now.png" alt="SHOP NOW "></i></a> </div>
                </div>
                <div class="col-lg-6 col-6 pr-0"> <img src="images/our-products/steering-suspension.jpg" class="img-fluid" alt="STEERING & SUSPENSION"></div>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 findCol pb-5">
             <div class="row bg-white d-flex m-0 border-bottom pt-2 pb-2">
                <div class="col-6 position-relative subHead">
                  <div class=" position-absolute text-left pl-3">
                    <h6>TRANSMISSION</h6>
                    <a href="#" class=" shopNow">SHOP NOW <i class="d-inline-block pl-1"> <img src="images/our-products/shop-now.png" alt="SHOP NOW "></i></a> </div>
                </div>
                <div class="col-lg-6 col-6 pr-0"> <img src="images/our-products/transmission.jpg" class="img-fluid" alt="TRANSMISSION"></div>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 findCol pb-5">
             <div class="row bg-white d-flex m-0 border-bottom pt-2 pb-2">
                <div class="col-6 position-relative subHead">
                  <div class=" position-absolute text-left pl-3">
                    <h6>COOLING & HEATING</h6>
                    <a href="#" class=" shopNow">SHOP NOW <i class="d-inline-block pl-1"> <img src="images/our-products/shop-now.png" alt="SHOP NOW "></i></a> </div>
                </div>
                <div class="col-lg-6 col-6 pr-0"> <img src="images/our-products/cooling-heating.jpg" class="img-fluid" alt="COOLING & HEATING<"></div>
              </div>
            </div>
            
             <div class="col-lg-4 col-sm-6 col-12 findCol pb-5">
             <div class="row bg-white d-flex m-0 border-bottom pt-2 pb-2">
                <div class="col-6 position-relative subHead">
                  <div class=" position-absolute text-left pl-3">
                    <h6>TURBOS</h6>
                    <a href="#" class=" shopNow">SHOP NOW <i class="d-inline-block pl-1"> <img src="images/our-products/shop-now.png" alt="SHOP NOW "></i></a> </div>
                </div>
                <div class="col-lg-6 col-6 pr-0"> <img src="images/our-products/turbos.jpg" class="img-fluid" alt="TURBOS"></div>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 findCol pb-5">
             <div class="row bg-white d-flex m-0 border-bottom pt-2 pb-2">
                <div class="col-6 position-relative subHead">
                  <div class=" position-absolute text-left pl-3">
                    <h6>SPARE
PARTS</h6>
                    <a href="#" class=" shopNow">SHOP NOW <i class="d-inline-block pl-1"> <img src="images/our-products/shop-now.png" alt="SHOP NOW "></i></a> </div>
                </div>
                <div class="col-lg-6 col-6 pr-0"> <img src="images/our-products/spare-parts.jpg" class="img-fluid" alt="SPARE PARTS"></div>
              </div>
            </div>
            </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </article>
     <?php include("inc-footer.php");  ?>