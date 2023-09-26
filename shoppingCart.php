<?php
include 'class/config.php';
if (!isset($_SESSION['u_id'])) {
    header("Location: index.php");
}

$cardetails_sql = "SELECT cart.cart_id,cart.prod_id,cart.u_id,cart.prod_qty,cart.remarks,prd.prod_part_no as itemno,prd.prod_desc as description,prd.prod_price  as price FROM rollco_ms_cart as cart,rollco_ms_product as prd WHERE cart.prod_id=prd.prod_id and cart.prod_id > 0 and cart.u_id='" . $_SESSION['u_id'] . "'";

$numsrprodcart = $sq->numsrow($cardetails_sql);

$cartdata1 = $sq->query($cardetails_sql);

$cardetailsspr_sql = "SELECT cart.cart_id,cart.prod_id,cart.spr_id,cart.u_id,cart.prod_qty,cart.remarks,spr.spare_part_no as itemno,spr.spare_desc as description,spr.spare_price as price FROM rollco_ms_cart as cart,rollco_ms_spare as spr WHERE cart.spr_id=spr.spare_id and cart.spr_id > 0 and cart.u_id='" . $_SESSION['u_id'] . "'";
$numsrsprcart = $sq->numsrow($cardetailsspr_sql);
$cartdataspr1 = $sq->query($cardetailsspr_sql);
?>
<!doctype html>
<html>
    <head>
        <?php include("inc-head.php"); ?>
    </head>

    <body>
        <?php include("inc-header.php"); ?>
        <section class="clearfix cataloGue">
            <?php /* ?> <?php
              if (isset($_SESSION['u_id']) && $_SESSION['u_id'] != '') {
              include("inc-afterlogin-userdetails.php");
              }
              ?><?php */ ?>
            <article class="clearfix aos-item bestChoice" data-aos='fade-up'>
                <div class="container">
                    <div id="cataloGue" class="position-relative text-center subHead prlogin"> <img src="images/login-page-products.jpg"  alt="banner" class="img-fluid w-100">
                        <div class="position-absolute text-left pl-5">
                            <h2 class="text-white electri">
                                <hr class="mb-2">
                                SHOPPING CART<br>
                                Order Information </h2>
                        </div>
                    </div>
                </div>
            </article>

            <article class=" pt-5 padB200 shopCart mb-5 ">
                <div class="container mb-5">
                    <div class="row  justify-content-center">

                        <div class="col-lg-10 camTabl">
                            <form method="post" id="plcord">
                                <input type="hidden" name="userAddRadValue" id="userAddRadValue" value="0">
                                <div class="table-responsive">
                                    <table class="table  table-bordered nobrd">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Item Code</th>
                                                <th>Product Description</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Total Price</th>
                                                <th>Delete</th>
                                                <th>Comment</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-light">
                                            <?php
                                            if ($numsrprodcart > 0) {
                                                $nn = 1;
                                                while ($rs = $sq->fetch($cartdata1)) {
                                                    $getpage = "?ex=h";
                                                    ?>
                                                    <tr>
                                                        <td><input type="hidden" class="fromPlan" readonly name="itemcode[]" value="<?php echo $rs['itemno'] ?>"><?php echo $rs['itemno'] ?>

                                                            <input type="hidden" class="fromPlan" readonly name="cart_id[]" value="<?php echo $rs['cart_id'] ?>">
                                                            <input type="hidden" class="fromPlan" readonly name="prod_id[]" value="<?php echo $rs['prod_id'] ?>">                                                <input type="hidden" class="fromPlan" readonly name="spr_id[]" value="<?php echo '0' ?>">
                                                        </td>


                                                        <td><input type="hidden" class="fromPlan" readonly name="prd_description[]" value="<?php
                                                            if (strlen($rs['description']) > 0)
                                                                echo $rs['description'];
                                                            else
                                                                echo "No info";
                                                            ?>"><?php echo $rs['description'] ?></td>
                                                        <td class="base-price"> <?php
                                                            $priceSql = "SELECT grpro.pr_price,grp.gr_currency FROM rollco_ms_grproduct as grpro INNER JOIN rollco_ms_group as grp on grp.gr_id = grpro.gr_id  WHERE grpro.gr_id = '" . $_SESSION['g_id'] . "' AND grpro.part_nm='" . $rs['itemno'] . "' LIMIT 1";
                                                            $numsrow = $sq->numsrow($priceSql);
                                                            if ($numsrow > 0) {
                                                                $pData = $sq->fearr($priceSql);
                                                            }
                                                            ?>
                                                            <input type="hidden" class="fromPlan" readonly name="prd_price[]" value="<?php echo $pData['pr_price'] ?>"><?php echo $pData['pr_price'] ?>

                                                        </td>

                                                        <td class="qty" >
                                                            <button type="button" id="sub" class="sub cartSub" data-baseprice="<?php echo $pData['pr_price']; ?>" data-prodid="<?php echo $rs['prod_id'] ?>" data-cartid="<?php echo $rs['cart_id'] ?>">-</button>
                                                            <input type="text" id="1" name="prod_qty[]" value="<?php echo $rs['prod_qty'] ?>" class="field shopcart_quan_val" readonly/>
                                                            <button type="button" id="add" class="add cartAdd" data-baseprice="<?php echo $pData['pr_price']; ?>" data-prodid="<?php echo $rs['prod_id'] ?>" data-cartid="<?php echo $rs['cart_id'] ?>">+</button>
                                                        </td>
                                                        <td class="tot-price"><?php
                                                            // echo sprintf("%.2f",$rs['prod_qty']* $pData['pr_price']);
                                                            echo round($rs['prod_qty'] * $pData['pr_price'], 2);
                                                            ?> </td>


                                                        <td class="deletecur" onClick="deleteitem('<?php echo $rs["cart_id"]; ?>');"><a  class="butDel"> <img src="images/delete.svg" alt="Delete"></a></td>
                                                        <td>  <input type="text" name="remarks[]" class="form-control" value="<?php echo $rs['remarks'] ?>">
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $nn++;
                                                }
                                            }
                                            if ($numsrsprcart > 0) {
                                                $nn1 = 1;
                                                while ($rs1 = $sq->fetch($cartdataspr1)) {
                                                    $getpage = "?ex=h";
                                                    ?>
                                                    <tr>
                                                        <td><input type="hidden" class="fromPlan" readonly name="itemcode[]" value="<?php echo $rs1['itemno'] ?>"><?php echo $rs1['itemno'] ?>
                                                            <input type="hidden" class="fromPlan" readonly name="cart_id[]" value="<?php echo $rs1['cart_id'] ?>">                                                                                   <input type="hidden" class="fromPlan" readonly name="prod_id[]" value="<?php echo '0'; ?>">                                               <input type="hidden" class="fromPlan" readonly name="spr_id[]" value="<?php echo $rs1['spr_id'] ?>">

                                                        </td>


                                                        <td><input type="hidden" class="fromPlan" readonly name="prd_description[]" value="<?php
                                                            if (strlen($rs1['description']) > 0)
                                                                echo $rs1['description'];
                                                            else
                                                                echo "No info";
                                                            ?>"><?php echo $rs1['description'] ?></td>
                                                        <td>


                                                            <?php
                                                            $priceSql = "SELECT grpro.pr_price,grp.gr_currency FROM rollco_ms_grproduct as grpro INNER JOIN rollco_ms_group as grp on grp.gr_id = grpro.gr_id  WHERE grpro.gr_id = '" . $_SESSION['g_id'] . "' AND grpro.part_nm='" . $rs1['itemno'] . "' LIMIT 1";
                                                            $numsrow = $sq->numsrow($priceSql);
                                                            if ($numsrow > 0) {
                                                                $pData = $sq->fearr($priceSql);
                                                            }
                                                            ?>
                                                            <input type="hidden" class="fromPlan" readonly name="prd_price[]" value="<?php echo $pData['pr_price'] ?>"><?php echo $pData['pr_price']; ?>

                                                        </td>

                                                        <td class="qty">
                                                            <button type="button" id="sub" class="sub cartSub" data-baseprice="<?php echo $pData['pr_price']; ?>" data-prodid="<?php echo $rs1['prod_id']; ?>">-</button>
                                                            <input type="text" id="shopcart_quan_val"  name="prod_qty[]" value="<?php echo $rs1['prod_qty'] ?>" class="field shopcart_quan_val" readonly/>
                                                            <button type="button" id="add" class="add cartAdd" data-baseprice="<?php echo $pData['pr_price']; ?>" data-prodid="<?php echo $rs1['prod_id']; ?>">+</button>
                                                        </td>
                                                        <td class="tot-price"><?php
                                                            echo sprintf("%.2f",
                                                                    $rs1['prod_qty'] * $pData['pr_price']);
                                                            ?></td>

                                                        <td class="deletecur" onClick="deleteitem('<?php echo $rs1["cart_id"]; ?>');"><a  class="butDel"> <img src="images/delete.svg" alt="Delete"></a></td>
                                                        <td>  <input type="text" name="remarks[]" class="form-control" value="<?php echo $rs1['remarks'] ?>">
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $nn1++;
                                                }
                                            }

                                            if ($numsrsprcart == 0 && $numsrprodcart == 0) {
                                                ?>
                                                <tr >
                                                    <td colspan="7" style="text-align: center;">You have no items in your Shopping Cart.</td></tr>
                                                <?php
                                            }

                                            if ($numsrsprcart > 0 && $numsrprodcart > 0) {
                                                ?>
                                                <tr>
    <!--                                                 <td colspan="7" class="text-right  bg-white pr-0">  <strong class="font20">Total Price      £0.00</strong></td>-->
                                                    <td colspan="5" class="text-right prodSpec bg-white pr-0 border-right-0">
                                                        <span class="cart-msg" style="color: #ef4135 !important;"> *Please note - Order received till 4pm will come for same day dispatch. All orders post this time will be dispatched next day.</span>
                                                    </td>

                                                    <td class="text-right prodSpec bg-white pr-3 " colspan="7"> <strong class="font20">Total Price      <?php echo getCurrSym($pData['gr_currency']); ?> <input type="hidden" name="gr_currency" class="form-control" value="<?php echo getCurrSym($pData['gr_currency']); ?>"> <span id="total_price"></span> </strong></td>

                                                </tr>
                                            <?php }
                                            ?>

                                        <td class="text-right prodSpec bg-white pr-0 " colspan="7">
                                            <?php if ($numsrsprcart > 0 || $numsrprodcart > 0) { ?>
                                                <div class="row w-100">
                                                    <div align="left" class="col-6" >
                                                        <strong>Select Address</strong>
                                                        <div class="addressList" style="margin:0px;padding:0px;white-space: break-spaces;">

                                                        </div>
                                                        <div class="otheraddressList" style="margin:0px;padding:0px;white-space: break-spaces;">

                                                        </div>
                                                        <table style="margin:0px;padding:0px;border-color:white;" >
                                                            <tr>
                                                                <td style="border:0px; color:#ef4135 ;" class="pr-0">Carriage Free only for UK ,for the Order value more than £150 . *<br>
                                                                    Excludes Ireland, Scottish Islands & Highland and other channel Islands.
                                                                    <br/>
                                                                    * Please read our <a href="https://www.rollingcomponents.com/terms_and_conditions.php" class="text-danger" target="_blank" download>Terms and Conditions</a>.
                                                                </td>
                                                            </tr>

                                                        </table>
                                                        

                                                    </div>



                                                    <div align="right" class="col-6"  >
                                                        <table style="margin:0px;padding:0px;border-color:white;" >
                                                            <tr>

                                                                <td style="border:0px;" class="pr-0"><strong  >Special Instructions </strong>
                                                                    </br>
                                                                    <span  >*For change in delivery address or to list your PO number, please use this <br/> area.</span></br>
                                                                    <textarea class="form-control spclInstr mt-2" name="order_instruction"></textarea>
                                                                </td>
                                                            </tr>

                                                        </table>

                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <input type="button" name="BtnAddToCArdCountinew" value="Continue Shopping" id="BtnAddToCArdCountinew"  onclick="location.href = 'listing.php';" class="btn mr-3">
                                            <?php if ($numsrsprcart > 0 || $numsrprodcart > 0) { ?>
                                        <!--                                            <input type="button" name="PlaceHolder1$Button1" value="Place Order" id="PlaceHolder1"  onclick="location.href = 'thankyou.php';" class="btn">-->
                                                <input type="button" name="PlaceHolder1$Button1" value="Place Order" id="PlaceHolder1"  onclick="placeorder()" class="btn">
                                            </td>
                                        <?php } ?>

                                        </tbody>
                                    </table>


                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
        </section>

        <?php include("inc-footer.php"); ?>

        <script>
            $(document).ready(function () {

                getaddress();
                getotheraddress();
            })


            function deleteitem(itemid) {
                var item_id = itemid;
                var session_id = <?php echo $_SESSION['u_id']; ?>;
                $('.successpass').html('');
                if (confirm('Are You sure you want to delete this item')) {
                    $.ajax({
                        type: 'post',
                        url: "ajax/deleteitem.php",
                        data: {'itemid': item_id, 'session_id': session_id},
                        success: function (data) {
                            var html = '';
                            var data = JSON.parse(data);
                            if (data.status == 1) {
                                $('.successpass').html(data.data);
                                setInterval(function () {
                                    location.reload();
                                }, 1000);
                            }
                            if (data.status == 2) {
                                $('.successpass').html(data.data);
                                setInterval(function () {
                                    location.reload();
                                }, 1000);
                            }
                        }
                    });
                }
            }

             function placeorder() {
                if (confirm("Are you sure want to place your order !!")) {
                    $('#PlaceHolder1').val('Please wait..');
                    $('#PlaceHolder1').prop('disabled', true);
                    $.ajax({
                        type: 'post',
                        url: "ajax/placeorder.php",
                        data: $('#plcord').serialize(),
                        success: function (data) {
                            var html = '';
                            var data = JSON.parse(data);
                            if (data.status == 1) {
                                window.location = data.data;
                            }
                            if (data.status == 2) {
                                $('#PlaceHolder1').val('Place Order');
                                $('#PlaceHolder1').prop('disabled', false);
                                alert(data.data);
                            }
                        }
                    });
                }
            }

            function getotheraddress() {

                $.ajax({
                    type: 'get',
                    url: "ajax/getuserotheraddress.php",
                    data: {data: '1'}
                    ,
                    success: function (data) {
                        var html = '';
                        var data = JSON.parse(data);
                        if (data.status == 1) {
                            $.each(data.data, function (index, item) {
                                html += '<label><input type="radio" class="userRadAddress" name="optradio"  value="'+item.id +'">  ';
                                html += item.streetAddress1other + ',';
                                html += item.streetAddress2other + ',' + item.com_cityother + ',';
                                html += item.com_stateother + ',' + item.com_zipCodeother + '</label>';
                                html += '</div><br/>';
                            });

                            $('.otheraddressList').html(html);
                        }
                        if (data.status == 2)
                        {
                            $('.otheraddressList').hide();
                        }

                    }
                });
            }

            function getaddress() {

                $.ajax({
                    type: 'get',
                    url: "ajax/getuseraddress.php",
                    data: {data: '1'}
                    ,
                    success: function (data) {
                        var html = '';
                        var data = JSON.parse(data);
                        if (data.status == 1) {
                            $.each(data.data, function (index, item) {
                                html += '<label><input type="radio" class="userRadAddress" name="optradio"  value="0" checked>  ';
                                if (item.streetAddress1) {
                                    html += item.streetAddress1 + ',';
                                }
                                if (item.streetAddress2) {
                                    html += item.streetAddress2 + ',';
                                }
                                if (item.com_city) {
                                    html += item.com_city + ',';
                                }
                                if (item.com_state) {
                                    html += item.com_state + ',';
                                }
                                if (item.com_zipCode) {
                                    html += item.com_zipCode ;
                                }
                                html += '</label>';
                                html += '</div>';
                            });

                            $('.addressList').html(html);
                        }
                        if (data.status == 2)
                        {
                            $('.addressList').hide();
                        }

                    }
                });
            }
            
            $(document).on('click','.userRadAddress',function(){
                $('#userAddRadValue').val($(this).val());
            });


        </script>

    </body>
</html>
