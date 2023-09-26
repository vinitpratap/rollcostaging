<!DOCTYPE html>
<html>
<head>
	<title>Rollco mailer</title>
</head>
<style type="text/css">
table {border-collapse:collapse;}
body{ margin:0px; padding:0px;;font-family:Arial, sans-serif; }
</style>
<body>
<table  border="0" cellspacing="0" cellpadding="0" width="890" align="center">
	<tr>
		
<td style="padding:40px; background-color:#ffffff; margin:0px;">
<table  border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
<td style="font-size:18px; color:#4d4d4f;line-height:24px;font-family:Arial, sans-serif; padding:0px;"> <img src="http://rollingcomponents.com/mailer/images/logo.jpg?v=1.1">	</td>
</tr>
<tr>
<td style="font-size:18px; color:#4d4d4f;line-height:24px;font-family:Arial, sans-serif; padding:30px 0px;"> 	
Dear <?php if(isset($firstName) && $firstName!='' ) echo $firstName;?>  ,<br><br>
Thank you for placing the Order request. Your Order Number is #<?php echo $orderno?>, detailed below.</td>
</tr>
<tr>
<td style="font-size:18px; color:#ef4135;font-weight:600;text-transform:uppercase; line-height:24px;font-family:Arial, sans-serif; padding:15px 15px; border-bottom:1px solid #ef4135;border-top:5px solid #ef4135;"> 	
Order Details</td>
</tr>
<tr>
<td style="padding:15px 0px;">

<table  border="0" cellspacing="0" cellpadding="0" width="100%">
                       
                          <tr>
                            <th align="left" bgcolor="#343a40" style="font-size:14px;padding:10px;color:#ffffff; border-right:1px solid #454d55;font-family:Arial, sans-serif;">Delivery Address</th>
                            <th align="left" bgcolor="#343a40" style="font-size:14px;padding:10px;color:#ffffff; border-right:1px solid #454d55;font-family:Arial, sans-serif;">Contact Info</th>
                             <th align="left" bgcolor="#343a40" style="font-size:14px;padding:10px;color:#ffffff; border-right:1px solid #454d55;font-family:Arial, sans-serif;">Order Number</th>
                              <th align="left" bgcolor="#343a40" style="font-size:14px;padding:10px;color:#ffffff; border-right:1px solid #454d55;font-family:Arial, sans-serif;">Order Date & Time</th>
                                    <th align="left" bgcolor="#343a40" style="font-size:14px;padding:10px;color:#ffffff; border-right:1px solid #343a40;font-family:Arial, sans-serif;">Order Status</th>
                             

                          </tr>
                        
                          <tr>
                            <td valign="top" bgcolor="#e5e5e7" style="font-size:14px;padding:10px;color:#212529;border-right:1px solid #000000;border-bottom:1px solid #000000;font-family:Arial, sans-serif;"><?php if(isset($firstName) && $firstName!='' ) echo $firstName;?>  <br>

<?php if(isset($streetAddress1) && $streetAddress1!='' ) echo $streetAddress1;?> <?php if(isset($streetAddress2) && $streetAddress2!='' ) echo ',' .$streetAddress2;?> <?php if(isset($com_city) && $com_city!='' ) echo ',' .$com_city;?>  <br>
<?php if(isset($com_state) && $com_state!='' ) echo',' .$com_state;?> <?php if(isset($com_zipCode) && $com_zipCode!='' ) echo ',Pin - ' .$com_zipCode;?></td>
                             <td valign="top" bgcolor="#e5e5e7" style="font-size:14px;padding:10px;color:#212529;border-right:1px solid #000000;border-bottom:1px solid #000000;font-family:Arial, sans-serif;"><?php if(isset($com_Telephone) && $com_Telephone!='' ) echo $com_Telephone;?><br>
 <a href="mailto:<?php if(isset($com_emailAddress) &&$com_emailAddress!='' ) echo $com_emailAddress;?>" style=" color:#212529">
<?php if(isset($com_emailAddress) && $com_emailAddress!='' ) echo $com_emailAddress;?></a></td>
 <td valign="top" bgcolor="#e5e5e7" style="font-size:14px;padding:10px;color:#212529;border-right:1px solid #000000;border-bottom:1px solid #000000;font-family:Arial, sans-serif;"><?php echo $orderno?></td>
                            <td valign="top" bgcolor="#e5e5e7" style="font-size:14px;padding:10px;color:#212529;border-right:1px solid #000000;border-bottom:1px solid #000000;font-family:Arial, sans-serif;"><?php if(isset($orderdate) && $orderdate!='0000-00-00 00:00:00' ){
                            $order_date= strtotime($orderdate); echo date('d M, Y' ,$order_date); echo '<br>'; echo date('h:m a' ,$order_date); }?></td>
                        <td valign="top" bgcolor="#e5e5e7" style="font-size:14px;padding:10px;color:#212529;font-family:Arial, sans-serif;border-bottom:1px solid #000000;"><?php if(isset($orderstatus) && $orderstatus!='' ) {echo $orderstatus; echo '<br>';
                          } ?> </td>
                          
                          </tr>
                        </tbody>
                      </table>
                  </td>
</tr>


<tr>
<td>
<table  border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
                            <th align="left" bgcolor="#343a40" style="font-size:14px;padding:10px;color:#ffffff; border-right:1px solid #454d55;font-family:Arial, sans-serif;">Item Code </th>
                           <th align="left" bgcolor="#343a40" style="font-size:14px;padding:10px;color:#ffffff; border-right:1px solid #454d55;font-family:Arial, sans-serif;">Product Description</th>
                            <th align="left" bgcolor="#343a40" style="font-size:14px;padding:10px;color:#ffffff; border-right:1px solid #454d55;font-family:Arial, sans-serif;">Qty</th>
                           <th align="left" bgcolor="#343a40" style="font-size:14px;padding:10px;color:#ffffff; border-right:1px solid #454d55;font-family:Arial, sans-serif;">Total Price</th>
                                <th align="left" bgcolor="#343a40" style="font-size:14px;padding:10px;color:#ffffff; font-family:Arial, sans-serif;">Comment</th>
                          
                          </tr>
                       
                       
<?php 

$orderdetailpro_sql = "SELECT prd.prod_desc as description,prd.prod_part_no as itemno,dtl.prod_price as price,dtl.prod_qty,dtl.prod_price as productprice,dtl.created_at,dtl.comments FROM rollco_ms_order_details as dtl,rollco_ms_product as prd  WHERE dtl.order_id='".$order_id."' and dtl.prod_id=prd.prod_id and dtl.user_id = '" .$u_id . "' and dtl.prod_id > 0";
$numprod = $sq->numsrow($orderdetailpro_sql);
$ordeproduct =$sq->query($orderdetailpro_sql); 

$orderspr_sql = "SELECT spr.spare_desc as description,spr.spare_part_no as itemno,spr.spare_price as price,dtl.prod_qty,dtl.prod_price as productprice,dtl.created_at,dtl.comments FROM rollco_ms_order_details as dtl,rollco_ms_spare as spr  WHERE dtl.order_id='".$order_id."' and dtl.spr_id=spr.spare_id and dtl.user_id = '" .$u_id . "' and dtl.spr_id > 0";  
 $numspr = $sq->numsrow($orderspr_sql);
$orderspr =$sq->query($orderspr_sql)

?>                             
                            <?php
   if($numprod >0){                   
$nn=1;
while($rs=$sq->fetch($ordeproduct))
{
?> 
            <tr>
              <td valign="top" bgcolor="#e5e5e7" style="font-size:14px;padding:10px;color:#212529;border-right:1px solid #000000;border-bottom:1px solid #000000;font-family:Arial, sans-serif;"><?php echo $rs['itemno']?></td>
                            <td valign="top" bgcolor="#e5e5e7" style="font-size:14px;padding:10px;color:#212529;border-right:1px solid #000000;border-bottom:1px solid #000000;font-family:Arial, sans-serif;"><?php echo $rs['description']?> </td>
              <td valign="top" bgcolor="#e5e5e7" style="font-size:14px;padding:10px;color:#212529;border-right:1px solid #000000;border-bottom:1px solid #000000;font-family:Arial, sans-serif;"><?php echo $rs['prod_qty']?></td>
                           <td valign="top" bgcolor="#e5e5e7" style="font-size:14px;padding:10px;color:#212529;border-right:1px solid #000000;border-bottom:1px solid #000000;font-family:Arial, sans-serif;"><?php echo sprintf("%.2f", $rs['productprice'])?></td>
                              <td valign="top" bgcolor="#e5e5e7" style="font-size:14px;padding:10px;color:#212529;border-bottom:1px solid #000000;font-family:Arial, sans-serif;"><?php echo $rs['comments']?></td>
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
                              <td valign="top" bgcolor="#e5e5e7" style="font-size:14px;padding:10px;color:#212529;border-right:1px solid #000000;border-bottom:1px solid #000000;font-family:Arial, sans-serif;"><?php echo $rs1['itemno']?></td>
                               <td valign="top" bgcolor="#e5e5e7" style="font-size:14px;padding:10px;color:#212529;border-right:1px solid #000000;border-bottom:1px solid #000000;font-family:Arial, sans-serif;"><?php echo $rs1['description']?></td>
                               <td valign="top" bgcolor="#e5e5e7" style="font-size:14px;padding:10px;color:#212529;border-right:1px solid #000000;border-bottom:1px solid #000000;font-family:Arial, sans-serif;"><?php echo $rs1['prod_qty']?></td>
                              <td valign="top" bgcolor="#e5e5e7" style="font-size:14px;padding:10px;color:#212529;border-right:1px solid #000000;border-bottom:1px solid #000000;font-family:Arial, sans-serif;"><?php echo sprintf("%.2f", $rs1['productprice'])?></td>
                               <td valign="top" bgcolor="#e5e5e7" style="font-size:14px;padding:10px;color:#212529;border-bottom:1px solid #000000;font-family:Arial, sans-serif;"><?php echo $rs1['comments']?></td>
                             </tr>
                             
                             
      <?php
$nn++;
}
   }
?>                           
                             
                       
                             <tr>
                           <td colspan="5" bgcolor="#e5e5e7" style="font-size:20px; font-weight:600; padding:15px;color:#212529;border-bottom:1px solid #000000; text-align:right;">Total Price   <?php if(isset($allprice) && $allprice!='' ){ echo $pricesign.' '.sprintf("%.2f", $allprice);
                           }?></td>
                            
                             </tr>
                        </tbody>
                      </table>
</td>
</tr>
<tr>
	<td style="font-size:16px;padding:10px;color:#ef4135;font-weight:600; text-align:left; padding-top:25px; ">
	Special Instructions : <?php echo $order_instruction;?>
	</td>
</tr>
	<td style="font-size:16px;padding:10px;color:#212529;font-weight:600; text-align:center; padding-top:25px; ">
		Note : Please check and confirm if the delivery address is correct or you can call our telesales in case you need to change your delivery address . 
	</td>
</tr>
<tr>
	<td style="font-size:16px;padding:10px;color:#212529;font-weight:600; text-align:center; padding-top:25px; ">
		<a href="http://www.rollingcomponents.com" style="color:#ef4135"> http://www.rollingcomponents.com</a> |  <a href="mailto:support@rollingcomponents.co.uk" style="color:#ef4135">support@rollingcomponents.co.uk</a>

	 </td>

	</tr>
	<tr>
	<td style="font-size:14px;padding:10px;color:#343a40; text-align:center; ">
		Copyrights <?php echo date('Y')?> Rolling Components. All Rights Reserved.	 </td>

	</tr>
</table>
 </td>

	</tr>

	
</table>

</body>
</html>