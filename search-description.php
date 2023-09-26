<?php include("config.php");  ?>
<!doctype html>
<html>
<head>
<?php include("inc-head.php");  ?>
</head>

<body>
<?php include("inc-header.php");  ?>
<section class="clearfix cataloGue">
  <article class="clearfix cataloTop aos-item" data-aos='fade-up'>
    <div class="container">
      <div class="row">
        <div class="col-12 text-right pt-3">
          <p class="text-danger font14 mb-0"> WELCOME CHRIS</p>
          <ul class="posLogNav d-flex float-right">
            <li class="align-self-center"><a href="account-details.php" class="text-uppercase">MY ACCOUNT</a> </li>
            <li class="align-self-center"><a href="my-recent-order.php" class="text-uppercase">My WISHLIST</a> </li>
            <li class="myCart"><a href="#" class="text-uppercase"> MY CART<span>ITEM: $ 0.00</span></a></li>
          </ul>
        </div>
      </div>
    </div>
  </article>
  <article class=" clearfix  aos-item faqOrdNews searDesc" data-aos='fade-up'>
    <div class="container">
      <div class="row">
        <div class="col-md-5" id="slider">
          <div id="myCarousel" class="carousel slide"> 
            <!-- main slider carousel items -->
            <div class="carousel-inner bg-light">
              <div class="active item carousel-item" data-slide-number="0"> <img src="images/search-description/slider-image.jpg" class="img-fluid w-100"> </div>
              <div class="item carousel-item" data-slide-number="1"> <img src="images/search-description/slider-image1.jpg" class="img-fluid w-100"> </div>
              <div class="item carousel-item" data-slide-number="2"> <img src="images/search-description/slider-image2.jpg" class="img-fluid w-100"> </div>
              <div class="item carousel-item" data-slide-number="3"> <img src="images/search-description/slider-image3.jpg" class="img-fluid w-100"> </div>
              <a class="carousel-control left pt-3" href="#myCarousel" data-slide="prev"><i class="fa fa-chevron-left"></i></a> <a class="carousel-control right pt-3" href="#myCarousel" data-slide="next"><i class="fa fa-chevron-right"></i></a> </div>
            <!-- main slider carousel nav controls -->
            
            <ul class="carousel-indicators list-inline">
              <li class="list-inline-item active" data-slide-to="0" data-target="#myCarousel"> <a id="carousel-selector-0" class="selected" > <img src="images/search-description/slider-image.jpg" class="img-fluid w-100"> </a> </li>
              <li class="list-inline-item" data-slide-to="1" data-target="#myCarousel"> <a id="carousel-selector-1" > <img src="images/search-description/slider-image1.jpg" class="img-fluid w-100"> </a> </li>
              <li class="list-inline-item" data-slide-to="2" data-target="#myCarousel"> <a id="carousel-selector-2" > <img src="images/search-description/slider-image2.jpg" class="img-fluid w-100"> </a> </li>
              <li class="list-inline-item" data-slide-to="3" data-target="#myCarousel"> <a id="carousel-selector-3" > <img src="images/search-description/slider-image3.jpg" class="img-fluid w-100"> </a> </li>
            </ul>
          </div>
        </div>
        <div class="col-lg-5 col-md-6 ml-md-auto prodSpec">
         
          <div class="table-responsive">
            <table class="table table-borderless">
            <tr>
            <th colspan="2" class="font-weight-500 font18"> Product Specifications </th>
            </tr>
              <tr>
                <td class="w-50">Part Number</td>
                <td>ALT100</td>
              </tr>
              <tr>
                <td>Description:</td>
                <td>Lucas A127</td>
              </tr>
              <tr>
                <td>Voltage:</td>
                <td>12V</td>
              </tr>
              <tr>
                <td>Output:</td>
                <td>75A</td>
              </tr>
              <tr>
                <td>Regulator:</td>
                <td>Internal</td>
              </tr>
              <tr>
                <td>Pulley Type:</td>
                <td>PVR4</td>
              </tr>
              <tr>
                <td>Fan:</td>
                <td>EF</td>
              </tr>
              <tr>
                <td>Price:</td>
                <td>0.00</td>
              </tr>
              <tr>
                <td>Availability:</td>
                <td>In Stock</td>
              </tr>
              <tr>
                <td>Add Info.</td>
                <td>Pump has to be fitted with Rollco supplies without pump</td>
              </tr>
              <tr>
                <td colspan="2" class="text-right">
                <form method="get" action="shoppingCart.php">
                <input type="button" name="ctl00$ContentPlaceHolder1$BtnApplication" value="Applications" id="ContentPlaceHolder1_BtnApplication" class="btnGrey " data-toggle="modal" data-target="#myBtnAppl">
                  <input type="submit" name="BTNAddCArd" value="Add To Cart" id="BTNAddCArd" class="btn">
                  <input type="submit" name="BtnView" value="View Basket" id="BtnView" class="btn"> 
                  </form>
                  
                  </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </article>
  <article class=" pt-5 padB200">
    <div class="container">
      <div class="row">
        <div class="col-md-4 croRefe camTabl">
        <h3>CROSS - REFERENCES</h3>
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead class="thead-light">
                <tr>
                  <th align="center" class="w-50">MANUFACTURER</th>
                  <th align="center">OEM</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>El stock</td>
                  <td>282501WP</td>
                </tr>
                <tr>
                  <td>El stock</td>
                  <td>282514WP</td>
                </tr>
                <tr>
                  <td>El stock</td>
                  <td>282781WP</td>
                </tr>
                <tr>
                  <td>El stock</td>
                  <td>283503</td>
                </tr>
                <tr>
                  <td>El stock</td>
                  <td>283503WP</td>
                </tr>
                <tr>
                  <td>Elstock</td>
                  <td>28-2501WP</td>
                </tr>
                <tr>
                  <td>Elstock</td>
                  <td>28-2514WP</td>
                </tr>
                <tr>
                  <td>Elstock</td>
                  <td>28-2781WP</td>
                </tr>
                <tr>
                  <td>Elstock</td>
                  <td>28-3503</td>
                </tr>
                <tr>
                  <td>Elstock</td>
                  <td>28-3503WP</td>
                </tr>
                <tr>
                  <td>Ford</td>
                  <td>924F10K359AB</td>
                </tr>
                <tr>
                  <td>Ford</td>
                  <td>924F-10K359-AB</td>
                </tr>
                <tr>
                  <td>Ford</td>
                  <td>954F10K359AB</td>
                </tr>
                <tr>
                  <td>Ford</td>
                  <td>954F-10K359-AB</td>
                </tr>
                <tr>
                  <td>Ford</td>
                  <td>954F-1OK359-AB</td>
                </tr>
                <tr>
                  <td>Ford</td>
                  <td>V94GB10K359AC</td>
                </tr>
                <tr>
                  <td>Ford</td>
                  <td>954F1OK359AB</td>
                </tr>
                <tr>
                  <td>FORD</td>
                  <td>924F10300AB</td>
                </tr>
                <tr>
                  <td>FORD</td>
                  <td>954F10300AA</td>
                </tr>
                <tr>
                  <td>FORD</td>
                  <td>954F-10300-AA</td>
                </tr>
                <tr>
                  <td>Hella</td>
                  <td>8EL730016-001</td>
                </tr>
                <tr>
                  <td>Hella</td>
                  <td>8EL730017-001</td>
                </tr>
                <tr>
                  <td>Hella</td>
                  <td>8EL730016001</td>
                </tr>
                <tr>
                  <td>Hella</td>
                  <td>8EL730017001</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>24374</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>24374BWP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>24374WP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022394</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022394A</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022394AWP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022394B</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022394BWP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022394D</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022394DWP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022394E</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022394EWP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022394WP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022396AWP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022425AWP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022425BWP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022425WP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022429AWP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022429WP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022495</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022495A</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022495AWP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022495B</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022495BWP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022495D</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022495DWP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022495E</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022495EWP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022495WP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022537WP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022547WP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022555WP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022557WP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022558WP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022564AWP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022564WP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022565WP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022575WP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022588WP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022610WP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022615WP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022689</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022689A</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022689AWP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022689WP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022708WP</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>LRA01613</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>LRA01729</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>LRA02738</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>LRA1613</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>LRA1729</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>LRA2738</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>LRB00160</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>LRB00161</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>LRB160</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>LRB161</td>
                </tr>
                <tr>
                  <td>Lucas</td>
                  <td>54022575</td>
                </tr>
                <tr>
                  <td>LUCAS</td>
                  <td>24293</td>
                </tr>
                <tr>
                  <td>Valeo</td>
                  <td>436755</td>
                </tr>
                <tr>
                  <td>Valeo</td>
                  <td>437390</td>
                </tr>
                <tr>
                  <td>Valeo</td>
                  <td>437787</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-8 unBrer camTabl">
        <h3>UNIT BREAKUP</h3>
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead class="thead-light">
                <tr>
                  <th class="text-center">Rollco</th>
                  <th class="text-center">Part name</th>
                  <th class="text-center">OEM</th>
                  <th class="text-center">Cargo</th>
                  <th class="text-center">Make</th>
                  <th class="text-center">Price</th>
                  <th class="text-center">Add To Cart</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><a href="javascript:"  data-toggle="modal" data-target="#mySparDeat">AR1948</a></td>
                  <td>Bearing Seal</td>
                  <td>60601038</td>
                  <td>132319</td>
                  <td>Lucas</td>
                  <td>0.00</td>
                  <td><label class="checkbox">
                                        <input type="checkbox" />
                                        <span class="primary"></span>
                                    </label></td>
                </tr>
                <tr><td><a href="javascript:"  data-toggle="modal" data-target="#mySparDeat2">AR1949</a></td>
                  <td>Shaft Nut</td>
                  <td>54134696</td>
                  <td>135049</td>
                  <td>Lucas</td>
                  <td>0.00</td>  <td><label class="checkbox">
                                        <input type="checkbox" />
                                        <span class="primary"></span>
                                    </label></td>
                </tr>
                <tr><td><a href="javascript:"  data-toggle="modal" data-target="#myModal">AR1951</a></td>
                  <td>Shaft Spring Washer</td>
                  <td></td>
                  <td></td>
                  <td>Lucas</td>
                  <td>0.00</td>  <td><label class="checkbox">
                                        <input type="checkbox" />
                                        <span class="primary"></span>
                                    </label></td>
                </tr>
                <tr><td><a href="javascript:"  data-toggle="modal" data-target="#myModal">AR1954</a></td>
                  <td>Thru Bolt</td>
                  <td></td>
                  <td></td>
                  <td>Lucas</td>
                  <td>0.00</td>  <td><label class="checkbox">
                                        <input type="checkbox" />
                                        <span class="primary"></span>
                                    </label></td>
                </tr>
                <tr><td><a href="javascript:"  data-toggle="modal" data-target="#myModal">AR1957</a></td>
                  <td>Plastic Guard &quot;New&quot; Fits AR1963</td>
                  <td>54208486</td>
                  <td>135597</td>
                  <td>Lucas</td>
                  <td>0.00</td>  <td><label class="checkbox">
                                        <input type="checkbox" />
                                        <span class="primary"></span>
                                    </label></td>
                </tr>
                <tr><td><a href="javascript:"  data-toggle="modal" data-target="#myModal">AR1963</a></td>
                  <td>Term Plug Block With Lead</td>
                  <td>54208568</td>
                  <td>135543</td>
                  <td>Lucas</td>
                  <td>0.00</td>  <td><label class="checkbox">
                                        <input type="checkbox" />
                                        <span class="primary"></span>
                                    </label></td>
                </tr>
                <tr><td><a href="javascript:"  data-toggle="modal" data-target="#myModal">AR1966</a></td>
                  <td>SRE Bracket Bush</td>
                  <td>54207056</td>
                  <td>136461</td>
                  <td>Lucas</td>
                  <td>0.00</td>  <td><label class="checkbox">
                                        <input type="checkbox" />
                                        <span class="primary"></span>
                                    </label></td>
                </tr>
                <tr><td><a href="javascript:"  data-toggle="modal" data-target="#myModal">AR1981</a></td>
                  <td>DE Spacer 5.5mm</td>
                  <td></td>
                  <td></td>
                  <td>Lucas</td>
                  <td>0.00</td>  <td><label class="checkbox">
                                        <input type="checkbox" />
                                        <span class="primary"></span>
                                    </label></td>
                </tr>
                <tr><td><a href="javascript:"  data-toggle="modal" data-target="#myModal">AR1982</a></td>
                  <td>DE Spacer Plate</td>
                  <td></td>
                  <td></td>
                  <td>Lucas</td>
                  <td>0.00</td>  <td><label class="checkbox">
                                        <input type="checkbox" />
                                        <span class="primary"></span>
                                    </label></td>
                </tr>
                <tr><td><a href="javascript:"  data-toggle="modal" data-target="#myModal">AR2018</a></td>
                  <td>Protective Plastic Sleeve</td>
                  <td></td>
                  <td></td>
                  <td>Lucas</td>
                  <td>0.00</td>  <td><label class="checkbox">
                                        <input type="checkbox" />
                                        <span class="primary"></span>
                                    </label></td>
                </tr>
                <tr>
                  <td><a href="javascript:">BA4008</a></td>
                  <td>SRE Bracket</td>
                  <td>054206343010</td>
                  <td>134667</td>
                  <td>Lucas</td>
                  <td>0.00</td>  <td><label class="checkbox">
                                        <input type="checkbox" />
                                        <span class="primary"></span>
                                    </label></td>
                </tr>
                <tr>
                  <td><a href="javascript:">BA4009</a></td>
                  <td>DE Bracket</td>
                  <td>054205171010</td>
                  <td>135184</td>
                  <td>Lucas</td>
                  <td>0.00</td>  <td><label class="checkbox">
                                        <input type="checkbox" />
                                        <span class="primary"></span>
                                    </label></td>
                </tr>
                <tr>
                  <td><a href="javascript:">BE6203</a></td>
                  <td>DE Bearing</td>
                  <td></td>
                  <td>140088</td>
                  <td>Lucas</td>
                  <td>0.00</td>  <td><label class="checkbox">
                                        <input type="checkbox" />
                                        <span class="primary"></span>
                                    </label></td>
                </tr>
                <tr>
                  <td><a href="javascript:">BEA127A</a></td>
                  <td>Needle Bearing</td>
                  <td>9433301</td>
                  <td>140240</td>
                  <td>Lucas</td>
                  <td>0.00</td>  <td><label class="checkbox">
                                        <input type="checkbox" />
                                        <span class="primary"></span>
                                    </label></td>
                </tr>
                <tr>
                  <td><a href="javascript:">PL8894</a></td>
                  <td>Pulley</td>
                  <td></td>
                  <td></td>
                  <td>Lucas</td>
                  <td>0.00</td>  <td><label class="checkbox">
                                        <input type="checkbox" />
                                        <span class="primary"></span>
                                    </label></td>
                </tr>
                <tr>
                  <td><a href="javascript:">RC1204</a></td>
                  <td>Rectifier</td>
                  <td>000084456010</td>
                  <td>132718</td>
                  <td>Lucas</td>
                  <td>0.00</td>  <td><label class="checkbox">
                                        <input type="checkbox" />
                                        <span class="primary"></span>
                                    </label></td>
                </tr>
                <tr>
                  <td><a href="javascript:">RG1152</a></td>
                  <td>Regulator</td>
                  <td>37703</td>
                  <td>131277</td>
                  <td>Lucas</td>
                  <td>0.00</td>  <td><label class="checkbox">
                                        <input type="checkbox" />
                                        <span class="primary"></span>
                                    </label></td>
                </tr>
                <tr>
                  <td><a href="javascript:">RO8518</a></td>
                  <td>Rotor</td>
                  <td>54206600</td>
                  <td>133845</td>
                  <td>Lucas</td>
                  <td>0.00</td>  <td><label class="checkbox">
                                        <input type="checkbox" />
                                        <span class="primary"></span>
                                    </label></td>
                </tr>
                <tr>
                  <td><a href="javascript">SR1486</a></td>
                  <td>Slip Ring</td>
                  <td></td>
                  <td>132642</td>
                  <td>Lucas</td>
                  <td>0.00</td>  <td><label class="checkbox">
                                        <input type="checkbox" />
                                        <span class="primary"></span>
                                    </label></td>
                </tr>
                <tr>
                  <td><a href="javascript:">ST4643</a></td>
                  <td>Stator</td>
                  <td>054206164010</td>
                  <td>133694</td>
                  <td>Lucas</td>
                  <td>0.00</td>  <td><label class="checkbox">
                                        <input type="checkbox" />
                                        <span class="primary"></span>
                                    </label> 
                                    
                                    
                                    </td>
                </tr>
                <tr>
                  <td colspan="7" class="text-right p-2">   <a href="shoppingCart.php" class="AddCart">Add To Cart</a></td>
                  
                  </tr>
             
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </article>
 </section>
<!-- The Modal -->
 <div class="modal " id="myBtnAppl">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h3 class="modal-title">Application Details</h3>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         <div class="table-responsive">
            <table class="table table-striped table-bordered nb-4">
              <thead class="thead-light">
               <tr>
    <th>Make</th>
    <th>Model</th>
    <th>CC</th>
    <th>Year</th>
  </tr>
              </thead>
              <tbody>
        
  <tr>
    <td>FORD</td>
    <td>TRANSIT IV 2.5 D / T.. / 4AB 4BA 4CA</td>
    <td>2496Ccm</td>
    <td>1991-1994</td>
  </tr>
  <tr>
    <td>FORD</td>
    <td>TRANSIT V 2.5 D / E.. / 4FA 4FB 4FC</td>
    <td>2496Ccm</td>
    <td>1994-1998</td>
  </tr>
  </tbody>
</table>
<table class="table table-striped table-bordered nb-4">
              <thead class="thead-light">
               <tr>
    <th>Make</th>
    <th>Model</th>
    <th>CC</th>
    <th>Year</th>
  </tr>
              </thead>
              <tbody>
        
  <tr>
    <td>FORD</td>
    <td>TRANSIT IV 2.5 D / T.. / 4AB 4BA 4CA</td>
    <td>2496Ccm</td>
    <td>1991-1994</td>
  </tr>
  <tr>
    <td>FORD</td>
    <td>TRANSIT V 2.5 D / E.. / 4FA 4FB 4FC</td>
    <td>2496Ccm</td>
    <td>1994-1998</td>
  </tr>
   <tr>
    <td>FORD</td>
    <td>TRANSIT IV 2.5 D / T.. / 4AB 4BA 4CA</td>
    <td>2496Ccm</td>
    <td>1991-1994</td>
  </tr>
  <tr>
    <td>FORD</td>
    <td>TRANSIT V 2.5 D / E.. / 4FA 4FB 4FC</td>
    <td>2496Ccm</td>
    <td>1994-1998</td>
  </tr>
  </tbody>
</table>
</div>
        
        
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  



<!-- The Modal -->
 <div class="modal " id="mySparDeat">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h3 class="modal-title">Spare Deatils</h3>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
       <div class="w-100 d-block mb-4"> <img id="ContentPlaceHolder1_ImageSpair" src="images/search-description/AR1948.jpg" align="absmiddle" class="img-fluid"></div>
        
        
        
         <div class="table-responsive d-inline-flex">
           <table class="table table-striped table-bordered nb-4 w-50">
              <thead class="thead-light">
               <tr>
    <th>Servicing_Numbers</th>
  </tr>
              </thead>
              <tbody>
  <tr>
    <td>ALT100</td>
  </tr>
  <tr>
    <td>ALT106</td>
  </tr>
  <tr>
    <td>ALT108</td>
  </tr>
  <tr>
    <td>ALT201</td>
  </tr>
  <tr>
    <td>ALT210</td>
  </tbody>
</table>
 <table class="table table-striped table-bordered nb-4 w-50">
              <thead class="thead-light">
               <tr>
    <th>Component_OEM_Numbers</th>
  </tr>
              </thead>
              <tbody>
  <tr>
    <td>60601038</td>
  </tr>
  <tr>
    <td>EC3947</td>
  </tr>
  
  </tbody>
</table> 
</div>
        
        
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  



<!-- The Modal -->
 <div class="modal " id="mySparDeat2">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h3 class="modal-title">Spare Deatils</h3>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
       <div class="w-100 d-block mb-4"> <img id="ContentPlaceHolder1_ImageSpair" src="images/search-description/AR1949.jpg" align="absmiddle" class="img-fluid"></div>
        
        
        
         <div class="table-responsive d-inline-flex">
           <table class="table table-striped table-bordered nb-4 w-50">
              <thead class="thead-light">
               <tr>
    <th>Servicing_Numbers</th>
  </tr>
              </thead>
              <tbody>
   <tr>
    <td>ALT100</td>
  </tr>
  <tr>
    <td>ALT101</td>
  </tr>
  <tr>
    <td>ALT104</td>
  </tr>
  <tr>
    <td>ALT105</td>
  </tr>
  <tr>
    <td>ALT106</td>
  </tr>
  <tr>
    <td>ALT107</td>
  </tr>
  <tr>
    <td>ALT108</td>
  </tr>
  <tr>
    <td>ALT109</td>
  </tr>
  <tr>
    <td>ALT110</td>
  </tr>
  <tr>
    <td>ALT111</td>
  </tr>
  <tr>
    <td>ALT116</td>
  </tr>
  <tr>
    <td>ALT137</td>
  </tr>
  <tr>
    <td>ALT138</td>
  </tr>
  <tr>
    <td>ALT141</td>
  </tr>
  <tr>
    <td>ALT142</td>
  </tr>
  <tr>
    <td>ALT143</td>
  </tr>
  <tr>
    <td>ALT144</td>
  </tr>
  <tr>
    <td>ALT145</td>
  </tr>
  <tr>
    <td>ALT147</td>
  </tr>
  <tr>
    <td>ALT148</td>
  </tr>
  <tr>
    <td>ALT150</td>
  </tr>
  <tr>
    <td>ALT151</td>
  </tr>
  <tr>
    <td>ALT152</td>
  </tr>
  <tr>
    <td>ALT159</td>
  </tr>
  <tr>
    <td>ALT160</td>
  </tr>
  <tr>
    <td>ALT163</td>
  </tr>
  <tr>
    <td>ALT201</td>
  </tr>
  <tr>
    <td>ALT210</td>
  </tr>
  <tr>
    <td>ALT215</td>
  </tr>
  <tr>
    <td>ALT300</td>
  </tr>
  <tr>
    <td>ALT314</td>
  </tr>
  <tr>
    <td>ALT315</td>
  </tr>
  <tr>
    <td>ALT317</td>
  </tr>
  <tr>
    <td>ALT318</td>
  </tr>
  <tr>
    <td>ALT324</td>
  </tr>
  <tr>
    <td>ALT325</td>
  </tr>
  <tr>
    <td>ALT326</td>
  </tr>
  <tr>
    <td>ALT339</td>
  </tr>
  </tbody>
</table>
 <table class="table table-striped table-bordered nb-4 w-50">
              <thead class="thead-light">
               <tr>
    <th>Component_OEM_Numbers</th>
  </tr>
              </thead>
              <tbody>
  <tr>
    <td>54134696</td>
  </tr>
  <tr>
    <td>ASP0001</td>
  </tr>
  <tr>
    <td>EC3945</td>
  </tr>
  </tbody>
</table> 
</div>
        
        
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>

<?php include("inc-footer.php");  ?>
</body>
</html>