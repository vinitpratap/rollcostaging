<?php
include("class/config.php");

if (preg_match("/.*Android.*/", $_SERVER['HTTP_USER_AGENT']) || preg_match("/.*iPhone.*/", $_SERVER['HTTP_USER_AGENT'])) {
    $plateform = 'mobile';
} else {
    $plateform = 'desktop';
}
?>
<!doctype html>
<html>
    <head>
<?php include("inc-head.php"); ?>
    </head>

    <body class="myRecentOrder searchListTop">
            <?php include("inc-header.php"); ?>
        <section class="clearfix cataloGue">
            <?php
            $prArr = array();
            if ($_GET['search-text'] == '' || strlen($_GET['search-text']) < 3) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else {
                if (isset($_GET['pageno'])) {
                    $pageno = $_GET['pageno'];
                } else {
                    $pageno = 1;
                }
                $no_of_records_per_page = 20;
                $offset = ($pageno - 1) * $no_of_records_per_page;
                $search_name = $_GET['search-text'];
                $sql = "SELECT prod_part_no,prod_desc,ptype,prod_add_inf,prod_nm FROM rollco_ms_product where prod_id > 0 ";
                if ($search_name != "") {
                    $sql .= " and (prod_nm LIKE '%" . $search_name . "%' || prod_part_no LIKE '%" . $search_name . "%' || prod_desc LIKE '%" . $search_name . "%' )  ";
                }
                
                $sql .= " AND  prod_status=1 group by prod_nm order by prod_nm  asc  ";
                
                $numrows = $sq->numsrow($sql);

                $sql .= " LIMIT $offset, $no_of_records_per_page";
            }
            ?>


            <article class="pb-5 mb-5 myAccount serchList">
                <div class="container pb-5">
                    <div class="row">
                        <div class="col-12 pt-5   pb-3"> <h2 class="text-danger">
                                SEARCH RESULTS  </h2></div> </div>
                    <div class="row pb-3">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 pb-5">
                            <div class="table-responsive-md">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <?php if ($numrows > 0) { ?><tr>
                                                <th >Rollco</th>
                                                <th >Product Description</th>
                                                <th>Additional Information </th>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </thead>
                                    <?php if ($numrows > 0) { ?>
                                        <tbody>
                                            <?php
                                            $data = $sq->query($sql);


                                            while ($rs = $sq->fetch($data)) {
                                                ?>
                                                <tr>

                                                    <td><a href="product-detail.php?rc_num=<?php echo $rs['prod_part_no']; ?>&type=search" class="active" > <?php echo $rs['prod_nm']; ?> </a></td>
                                                    <td><?php
                                        if (strlen($rs['ptype']) > 1)
                                            echo $rs['ptype'];
                                        else
                                            echo "NO INFO";
                                                ?></td>
                                                    <td><?php
                                                if (strlen($rs['prod_add_inf']) > 1)
                                                    echo $rs['prod_add_inf'];
                                                else
                                                    echo "NO INFO";
                                                ?></td>
                                                </tr>

                                            <?php }
                                            ?>

                                        </tbody>
                                    <?php
                                    } else {
                                        $snf_user = 'Guest';
                                        if (isset($_SESSION['u_id']) && $_SESSION['u_id'] != '') {
                                            $snf_user = $_SESSION['firstName'] . ' ' . $_SESSION['lastName'] . ' ' . $_SESSION['com_emailAddress'];
                                        }
                                        $sql1 = "SELECT snf_text FROM rollco_search_not_found where snf_text ='" . $_GET['search-text'] . "' and  snf_user='" . $snf_user . "'";
                                        $reccount1 = $sq->numsrow($sql1);
                                        if ($reccount1 == 0) {
                                            $insertsnf = "INSERT INTO rollco_search_not_found SET snf_make='0',snf_model='0',snf_yr='0',snf_cc='0',snf_user='" . $snf_user . "',snf_text='" . $_GET['search-text'] . "',snf_ec='0',snf_browser='" . $_SERVER['HTTP_USER_AGENT'] . "',snf_platform='" . $plateform . "',snf_ip='" . $_SERVER['REMOTE_ADDR'] . "',created_at='" . $getdatetime . "'";
                                            $sq->query($insertsnf);
                                        }
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td colspan="3"  style="text-align: center"> 
                                                    <span class="minHight">No product found  <a href="listing.php" >Back</a></span>

                                                </td>
                                            </tr>
                                        </tbody>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>

                    <?php
                    if ($numrows > 0) {
                        $sql = "SELECT COUNT(prod_id) FROM rollco_ms_product where prod_id > 0 ";
                        if ($search_name != "") {
                            $sql .= " and (prod_nm LIKE '%" . $search_name . "%' || prod_part_no LIKE '%" . $search_name . "%' || prod_desc LIKE '%" . $search_name . "%' )  ";
                        }
                        
                         $sql .= " AND  prod_status=1 group by prod_nm order by prod_nm  asc  ";
                        //echo $sql;
                        $rs_result = $sq->query($sql);
                        $row = $sq->numsrow($sql);
						
						//debug($rs_result);
                        //$row = mysql_fetch_row($rs_result);
                        $total_rows = $row; //$row[0];
						
                        $total_pages = ceil($total_rows / $no_of_records_per_page);
                        $next_page = $pageno + 1;
                        $previous_page = $pageno - 1;
                        $second_last = $total_pages - 1;
                        ?>
                        <div class="row pb-5">
                            <div  class="col-lg-12">
                                <div aria-label="Page navigation ">
                                    <ul class="pagination justify-content-end">
                                        <li <?php
                                        if ($pageno <= 1) {
                                            echo "class='disabled'";
                                        }
                                        ?>>
                                            <a class='page-link' <?php
                                            if ($pageno > 1) {
                                                echo "href='?pageno=$previous_page&search-text=$search_name'";
                                            }
                                            ?>>Previous</a>
                                        </li>

                                        <?php
                                        if ($total_pages <= 10) {
                                            for ($counter = 1; $counter <= $total_pages; $counter++) {
                                                if ($counter == $pageno) {
                                                    echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                                } else {
                                                    echo "<li  class='page-item'><a class='page-link' href='?pageno=$counter&search-text=$search_name'>$counter</a></li>";
                                                }
                                            }
                                        } elseif ($total_pages > 10) {

                                            if ($pageno <= 4) {
                                                for ($counter = 1; $counter < 8; $counter++) {
                                                    if ($counter == $pageno) {
                                                        echo "<li class=' page-item active'><a class='page-link'>$counter</a></li>";
                                                    } else {
                                                        echo "<li class='active'><a class='page-link' href='?pageno=$counter&search-text=$search_name'>$counter</a></li>";
                                                    }
                                                }
                                                echo "<li class=' page-item '><a class='page-link'>...</a></li>";
                                                echo "<li class=' page-item '><a class='page-link' href='?pageno=$second_last&search-text=$search_name'>$second_last</a></li>";
                                                echo "<li class=' page-item '><a class='page-link' href='?pageno=$total_pages&search-text=$search_name'>$total_pages</a></li>";
                                            } elseif ($pageno > 4 && $pageno < $total_pages - 4) {
                                                echo "<li class=' page-item '><a class='page-link' href='?pageno=1&search-text=$search_name'>1</a></li>";
                                                echo "<li class=' page-item '><a class='page-link' href='?pageno=2&search-text=$search_name'>2</a></li>";
                                                echo "<li class=' page-item '><a class='page-link'>...</a></li>";
                                                for ($counter = $pageno - $adjacents; $counter <= $pageno + $adjacents; $counter++) {
                                                    if ($counter == $pageno) {
                                                        echo "<li class=' page-item active'><a class='page-link'>$counter</a></li>";
                                                    } else {
                                                        echo "<li class=' page-item '><a class='page-link' href='?pageno=$counter&search-text=$search_name'>$counter</a></li>";
                                                    }
                                                }
                                                echo "<li  class=' page-item '><a class='page-link'>...</a></li>";
                                                echo "<li  class=' page-item '><a class='page-link' href='?pageno=$second_last&search-text=$search_name'>$second_last</a></li>";
                                                echo "<li  class=' page-item '><a class='page-link' href='?pageno=$total_pages&search-text=$search_name'>$total_pages</a></li>";
                                            } else {
                                                echo "<li  class=' page-item '><a class='page-link' href='?pageno=1&search-text=$search_name'>1</a></li>";
                                                echo "<li  class=' page-item '><a class='page-link' href='?pageno=2&search-text=$search_name'>2</a></li>";
                                                echo "<li  class=' page-item '><a class='page-link'>...</a></li>";

                                                for ($counter = $total_pages - 6; $counter <= $total_pages; $counter++) {
                                                    if ($counter == $pageno) {
                                                        echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                                    } else {
                                                        echo "<li class='page-item active'><a class='page-link' href='?pageno=$counter&search-text=$search_name'>$counter</a></li>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>

                                        <li <?php
                                        if ($pageno >= $total_pages) {
                                            echo "class='disabled'";
                                        }
                                        ?>>
                                            <a class='page-link' <?php
                                        if ($pageno < $total_pages) {
                                            echo "href='?pageno=$next_page&search-text=$search_name'";
                                        }
                                        ?>>Next</a>
                                        </li>
                                        <?php
                                            if ($pageno < $total_pages) {
                                                echo "<li class='page-item '><a class='page-link' href='?pageno=$total_pages&search-text=$search_name'>Last &rsaquo;&rsaquo;</a></li>";
                                            }
                                        }
                                        ?>
                                </ul>
                            </div>
                        </div>
                    </div>



                </div> 

                </div>
            </article> 
        </section>
<?php include("inc-footer.php"); ?>
    </body>
</html>