<?php include 'class/config.php';
if(!isset($_SESSION['u_id'])){
    header("Location: index.php");
}
if(isset($_GET['order_id']) && $_GET['order_id']==''){
    header("Location: my-recent-order.php");
}
$u_id=$_SESSION['u_id'];
$orderstatus='';
$checkuser_sql = "SELECT u_id,chooseOption,firstName,lastName,com_Telephone,com_Fax,com_emailAddress,streetAddress1,streetAddress2,com_city,com_state,com_zipCode FROM rollco_ms_users WHERE u_id = '" .$u_id. "' AND user_status = 2";
$numsrow = $sq->numsrow($checkuser_sql);
if ($numsrow > 0) {
$userdata = $sq->fearr($checkuser_sql);        
}

$orderdetails_sql = "SELECT ord.order_id,ord.order_no,ord.order_status,ord.order_date,ord.totalprice,ord.price_sign,ord.Qty,ord.Shipped_date FROM  rollco_ms_order as ord  WHERE  ord.user_id = '" .$u_id . "' and ord.order_id='".$_GET['order_id']."'";
$numsroword = $sq->numsrow($orderdetails_sql);
if ($numsroword > 0) {
$orderdata = $sq->fearr($orderdetails_sql);   

$orderdetailpro_sql = "SELECT prd.prod_desc as description,prd.prod_part_no as itemno,dtl.prod_price as price,dtl.prod_qty,dtl.prod_price as productprice,dtl.created_at,dtl.comments FROM rollco_ms_order_details as dtl,rollco_ms_product as prd  WHERE dtl.order_id='".$orderdata['order_id']."' and dtl.prod_id=prd.prod_id and dtl.user_id = '" .$u_id . "' and dtl.prod_id > 0";
$numprod = $sq->numsrow($orderdetailpro_sql);
$ordeproduct =$sq->query($orderdetailpro_sql); 
 
$orderspr_sql = "SELECT spr.spare_desc as description,spr.spare_part_no as itemno,spr.spare_price as price,dtl.prod_qty,dtl.prod_price as productprice,dtl.created_at,dtl.comments FROM rollco_ms_order_details as dtl,rollco_ms_spare as spr  WHERE dtl.order_id='".$orderdata['order_id']."' and dtl.spr_id=spr.spare_id and dtl.user_id = '" .$u_id . "' and dtl.spr_id > 0";  
 $numspr = $sq->numsrow($orderspr_sql);
$orderspr =$sq->query($orderspr_sql); 
}else{

   header("Location: my-recent-order.php");  
}



?>
<!doctype html>
<html>
<head>
<?php include("inc-head.php");  ?>
</head>

<body class="vehicLookup">
<?php include("inc-header.php");  ?>
<section class="clearfix cataloGue">
 <?php /*?> <?php
            if (isset($_SESSION['u_id']) && $_SESSION['u_id'] != '') {
                include("inc-afterlogin-userdetails.php");
            }
            ?><?php */?>
  <article class="clearfix aos-item bestChoice" data-aos='fade-up'>
    <div class="container">
      <div id="cataloGue" class="position-relative text-center subHead prlogin"> <img src="images/login-page-products.jpg"  alt="banner" class="img-fluid w-100">
        <div class="position-absolute text-left pl-5">
          <h2 class="text-white electri">
            <hr class="mb-2">
            BEST CHOICE<br>
            FOR SPARE PARTS </h2>
        </div>
      </div>
    </div>
  </article>
 
  <article class="pb-5 pt-5 mb-5 acctDetails  myOrdDet">
    <div class="container pb-5 ">

      <div class="row justify-content-center">
      <div class="col-lg-10 pb-5 accountInfo">
        <ul class="nav nav-tabs">
          <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#vehiclelookup">My Order Details</a> </li>
          <a href="<?php echo $siteurl?>my-recent-order.php" class="pull-right ml-auto btn-sm btn-success saveButton mt-0"> Back</a>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="vehiclelookup">
            <div class="row pb-5 justify-content-center">
              <div class="col-lg-12 pb-5">
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                   <div class="table-responsive table-responsive-lg table-responsive-xl ">
                      <table class="table  w-100 table-bordered">
                        <thead class="thead-dark">
                          <tr>
                            <th>Delivery Address</th>
                            <th>Contact Info</th>
                             <th>Order Number</th>
                              <th>Order Date & Time</th>
                               <th>Order Status</th>

                          </tr>
                        </thead>
                        <tbody class="bg-light">
                          <tr>
                            <td><?php if(isset($userdata['firstName']) && $userdata['firstName']!='' ) echo $userdata['firstName'];?>  <?php if(isset($userdata['lastName']) && $userdata['lastName']!='' ) echo $userdata['lastName'];?><br>

<?php if(isset($userdata['streetAddress1']) && $userdata['streetAddress1']!='' ) echo $userdata['streetAddress1'];?> <?php if(isset($userdata['streetAddress2']) && $userdata['streetAddress2']!='' ) echo ',' .$userdata['streetAddress2'];?> <?php if(isset($userdata['com_city']) && $userdata['com_city']!='' ) echo ',' .$userdata['com_city'];?> <?php if(isset($userdata['com_state']) && $userdata['com_state']!='' ) echo',' .$userdata['com_state'];?> <?php if(isset($userdata['com_zipCode']) && $userdata['com_zipCode']!='' ) echo ',Pin - ' .$userdata['com_zipCode'];?> <br>
</td>
                            <td><?php if(isset($userdata['com_Telephone']) && $userdata['com_Telephone']!='' ) echo $userdata['com_Telephone'];?><br>
<?php if(isset($userdata['com_emailAddress']) && $userdata['com_emailAddress']!='' ) echo $userdata['com_emailAddress'];?></td>
                          
                            <td><?php if(isset($orderdata['order_no']) && $orderdata['order_no']!='' ) echo $orderdata['order_no'];?></td>
                            <td><?php if(isset($orderdata['order_date']) && $orderdata['order_date']!='0000-00-00 00:00:00' ){
                            $order_date= strtotime($orderdata['order_date']); echo date('d M, Y' ,$order_date); echo '<br>'; echo date('h:m a' ,$order_date); }?>
                           
                           
</td>
                          <td><?php if(isset($orderdata['order_status']) && $orderdata['order_status']!='' ) {
 if($orderdata['order_status']=='0'){
                  $orderstatus='Open';
              }elseif ($orderdata['order_status']=='1') {
                     $orderstatus='Processing';                  
              }elseif ($orderdata['order_status']=='2') {
                       $orderstatus='Pending';                
                }elseif ($orderdata['order_status']=='3') {
                        $orderstatus='Hold';               
                }elseif ($orderdata['order_status']=='4') {
                           $orderstatus='Complete';            
                           } elseif ($orderdata['order_status']=='5'){
                                   $orderstatus='Closed';    
                                  }elseif ($orderdata['order_status']=='6'){
                                       $orderstatus='Canceled';     
                                  }else{
                                      $orderstatus='';      
                                  }            
                              echo $orderstatus; echo '<br>';
                          } ?> 
        <?php if(isset($orderdata['Shipped_date']) && $orderdata['Shipped_date']!='0000-00-00 00:00:00' ) {$Shipped_date= strtotime($orderdata['Shipped_date']);
           echo date('d M, Y' ,$Shipped_date);
        }?>                   
                              </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="table-responsive-md  table-responsive-lg table-responsive-xl" >
                      <table class="table  imgTabl">
                        <thead class="thead-dark">
                          <tr>
                            <th>Item Code </th>
                            <th>Product Description</th>
                            <th>Qty</th>
                            <th>Total Price</th>
                            <th>Comment</th>
                          </tr>
                        </thead>
                        <tbody class="bg-light">
                          
                           <?php
   if($numprod >0){                   
$nn=1;
while($rs=$sq->fetch($ordeproduct))
{
?> 
                            <tr>
                           <td><?php echo $rs['itemno']?></td>
                            <td><?php echo $rs['description']?></td>
                            <td><?php echo $rs['prod_qty']?></td>
                            <td><?php echo sprintf("%.2f", $rs['productprice'])?></td>
                            <td><?php echo $rs['comments']?></td>
                             </tr>
      <?php
$nn++;
}
   }
?>   
                              <?php
   if($numspr >0){                   
$nn=1;
while($rs1=$sq->fetch($orderspr))
{
?> 
                            <tr>
                           <td><?php echo $rs1['itemno']?></td>
                            <td><?php echo $rs1['description']?></td>
                            <td><?php echo $rs1['prod_qty']?></td>
                            <td><?php echo sprintf("%.2f", $rs1['productprice'])?></td>
                            <td><?php echo $rs1['comments']?></td>
                             </tr>
      <?php
$nn++;
}
   }
?>                         
                          
                             <tr>
                           <td colspan="5" class="text-right bg-white"><strong class="font20">Total Price <?php if(isset($orderdata['totalprice']) && $orderdata['totalprice']!='' ){ echo $orderdata['price_sign'].' '.sprintf("%.2f",$orderdata['totalprice']);
                           }else{ echo '£ 0.00';}?>   </strong></td>
                            
                             </tr>
                        </tbody>
                      </table>
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
</section>
<?php include("inc-footer.php");  ?>
</body>
</html>
