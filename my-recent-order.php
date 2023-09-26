<?php
include 'class/config.php';
if (!isset($_SESSION['u_id'])) {
    header("Location: index.php");
}
$u_id = $_SESSION['u_id'];
$checkuser_sql = "SELECT u_id,chooseOption,firstName,lastName,com_Telephone,com_Fax,com_emailAddress,streetAddress1,streetAddress2,com_city,com_state,com_zipCode FROM rollco_ms_users WHERE u_id = '" . $u_id . "' AND user_status = 2";
$numsrow = $sq->numsrow($checkuser_sql);
if ($numsrow > 0) {
    $userdata = $sq->fearr($checkuser_sql);
}
$top_paging = 1;
?>
<!doctype html>
<html>
    <head>
        <?php include("inc-head.php"); ?>
        <link href="js/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    </head>

    <body class="myRecentOrder">
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
                                BEST CHOICE<br>
                                FOR SPARE PARTS </h2>
                        </div>
                    </div>
                </div>
            </article>


            <article class="pb-5 mt-5 mb-5 myAccount">
                <div class="container pb-5">

                    <div class="row pb-3 justify-content-center" >
                        <div class="col-lg-10 pb-5 accountInfo">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#myRecentOrder">My recent orders</a> </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane container active" id="vehiclelookup">
                                    <div class="row search_by justify-content-between    ">
                                        <div class="form-group col-lg-6">
                                            <input type="text" placeholder="Search Name" name="search_name" id="search_name" class="form-control"  />
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <input autocomplete="off" type="text" placeholder="From Date" id="search_from_date" class="form-control " name="search_from_date"   />
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <input autocomplete="off" type="text" placeholder="To Date" id="search_to_date" class="form-control " name="search_to_date"  />
                                        </div>


                                        <div class="form-group col-lg-2">
                                            <input class="btn-sm btn-success saveButton" type="button" name="search_submit" id="search_submit" value="Search" />
                                        </div>


                                    </div>
                                    <div class="table-responsive-md">
                                        <table class="table  table-bordered">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th >Order Number </th>
                                                    <th >Qty</th>
                                                    <th >Total Price </th>
                                                    <th >Order Date</th>
                                                    <th>View</th>
                                                </tr>
                                            </thead>

                                            <?php if ($top_paging == 1) { ?>    
                                                <tbody class="bg-light" id="results"><!-- content will be loaded here -->

                                                </tbody>
                                            <?php } else { ?>
                                                <tbody class="bg-light">
                                                    <tr>
                                                        <td colspan="5">You have not placed any order.</td>
                                                    </tr>
                                                </tbody>
                                            <?php } ?>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pb-5" id="pagination">
                    </div>
                </div>
            </article>
        </section>
        <?php include("inc-footer.php"); ?>
        <script src="js/bootstrap-daterangepicker/daterangepicker.js"></script> 
        <script type="text/javascript">
            $(document).ready(function () {
                var sname  = '';
                var from_date = '';
                var to_date = '';
<?php if ($top_paging == 1) { ?>
                    getresult(0);
                    $('#search_submit').click(function () {
                        sname = $('#search_name').val();
                        from_date = $('#search_from_date').val();
                        to_date = $('#search_to_date').val();
                        getresult(0);
                    });
                    $("#pagination").on("click", ".pagingnav li a", function (e) {
                        e.preventDefault();
                        var page = $(this).attr("data-page");
                        getresult(page);
                    });
<?php } ?>
                function getresult(pageno) {
                    var page = pageno
                    $("#results").html('');
                    $("#pagination").html('');
                    $.ajax({
                        type: 'post',
                        url: "ajax/my_order_page.php",
                        data: {"page": page,"sname": sname,"from_date": from_date,"to_date": to_date, user_id:<?php echo $u_id; ?>},
                        dataType: "json",
                        success: function (data) {
                            if (data.datavalues.length > 0) {
                                $("#results").append(data.datavalues);
                                $("#pagination").append(data.pagination);
                            } else {
                                $("#results").append('<tr  style="text-align: center;"><td colspan="5">You have not placed any order. </td></tr>')
                            }
                        }
                        //        
                    });
                }
                ;
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function () {
                $('#search_from_date').daterangepicker({
                    autoUpdateInput: false,
                    singleDatePicker: true,
                    singleClasses: "picker_1",
                    locale: {
                        format: "YYYY-MM-DD",
                    }
                });
                $('#search_from_date').on('apply.daterangepicker', function (ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD'));

                    $('#search_to_date').daterangepicker({
                        autoUpdateInput: false,
                        singleDatePicker: true,
                        singleClasses: "picker_1",
                        locale: {
                            format: "YYYY-MM-DD",
                        }
                    });

                    $('#search_to_date').on('apply.daterangepicker', function (ev, picker) {
                        $(this).val(picker.startDate.format('YYYY-MM-DD'));
                    });
                });

            });
        </script> 

    </body>
</html>
