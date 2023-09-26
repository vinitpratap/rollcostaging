<?php
include 'class/config.php';

if (!isset($_SESSION['u_id'])) {
    header("Location: index.php");
    exit;
}
if (isset($_SESSION['cust_type']) && $_SESSION['cust_type'] == 3) {
    
} else {
    header("Location: index.php");
    exit;
}

$u_id = $_SESSION['u_id'];
$checkuser_sql = "SELECT u_id,chooseOption,firstName,lastName,com_Telephone,com_Fax,com_emailAddress,streetAddress1,streetAddress2,com_city,com_state,com_zipCode FROM rollco_ms_users WHERE u_id = '" . $u_id . "' AND user_status = 2";
$numsrow = $sq->numsrow($checkuser_sql);
if ($numsrow > 0) {
    $userdata = $sq->fearr($checkuser_sql);
}
?>
<!doctype html>
<html>
    <head>
        <?php include("inc-head.php"); ?>
    </head>

    <body class="myAccountDetail" >
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


            <article class="pb-5 mt-5 mb-5 acctDetails creatAccouText calendr ">
                <div class="container pb-5 ">                    
                    <div class="row pb-5 justify-content-center">
                        <div class="col-lg-10 pb-5 accountInfo">
                            <ul class="nav nav-tabs nav-justified" id="myTab">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#newcalendar"><?php
                                        if (isset($_GET['action']) && $_GET['action'] == 'edit')
                                            echo 'Edit';
                                        else
                                            echo 'New';
                                        ?> calendar</a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#appointments">View appointments</a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#salesreport">Sales Report</a> </li>
                            </ul>
                            <?php
                            $err = '';
                            $cform_id = 'calendar_form';
                            if (isset($_GET['action']) && $_GET['action'] == 'edit') {
                                $cal_sql = "select * from rollco_salesCal where sec_id = '" . $_SESSION['u_id'] . "' and sc_status = 1 and sc_id = " . $_GET['sc_id'];
                                $cal_res = $sq->fearr($cal_sql);
                                if (isset($cal_res['sc_id']) && $cal_res['sc_id'] > 0) {
                                    $cform_id = 'calendar_editform';
                                } else {
                                    echo "<script>location.href='calendars.php';</script>";
                                    exit;
                                }
                            }
                            ?>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane container active" id="newcalendar">
                                    <form method="post" id="<?php echo $cform_id ?>" >
                                        <div class="sucess-msg successcalendar text-center pb-4 font-weight-bold"></div>
                                        <div class="row">
                                            <div class="col-md-4 col-12 pb-4">
                                                <label for="AC_Name">AC Name</label>
                                                <?php
                                                if (isset($cal_res['full_name']) && $cal_res['full_name'] != '') {
                                                    ?>
                                                    <input type="text" name="ACName"  class="form-control" id="ACName" value="<?php if (isset($cal_res['full_name'])) echo $cal_res['full_name'] ?>" <?php if (isset($cal_res['full_name'])) echo 'disabled="disabled"'; ?> >
                                                    <input type="hidden" name="sc_id" id="sc_id" value="<?php if (isset($cal_res['sc_id'])) echo $cal_res['sc_id'] ?>" >
                                                    <?php
                                                } else {
                                                    ?>
                                                    <select class="form-control" name="AC_Name" id="AC_Name">
                                                        <option value="">Select</option>
                                                        <?php
                                                        $usql = "select u_id,firstName,lastName,com_zipCode,companyName from rollco_ms_users where cust_type = 1 and user_status = 2 order by firstName asc ";
                                                        $udata = $sq->query($usql);
                                                        while ($ures = $sq->fetch($udata)) {
                                                            $optionname = trim($ures['companyName']);
                                                            if ($ures['com_zipCode'] != '')
                                                                $optionname .= '(' . $ures['com_zipCode'] . ')';
                                                            ?>
                                                            <option value="<?php echo $ures['u_id'] ?>"><?php echo $optionname ?></option>
                                                            <?php
                                                        }
                                                        ?>                                                    
                                                    </select>
                                                    <?php
                                                }
                                                ?>


                                            </div>
                                            <div class="col-md-4 col-12 pb-4">
                                                <label for="Post_Code">Post Code</label>
                                                <input type="text" name="Post_Code"  class="form-control" id="Post_Code" value="<?php if (isset($cal_res['post_code'])) echo $cal_res['post_code'] ?>" <?php if (isset($cal_res['post_code'])) echo 'disabled="disabled"'; ?> >
                                            </div>
                                            <div class="col-md-4 col-12 pb-4">
                                                <label for="county">County/ Town</label>
                                                <input type="text" name="county" class="form-control" id="county" value="<?php if (isset($cal_res['sc_country'])) echo $cal_res['sc_country'] ?>" <?php if (isset($cal_res['sc_country'])) echo 'disabled="disabled"'; ?> >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 col-12 pb-4">
                                                <label for="app_date">Date</label>
                                                <input type="text" name="app_date" class="form-control" id="app_date" value="<?php if (isset($cal_res['sc_date'])) echo $cal_res['sc_date'] ?>" />
                                            </div>
                                            <div class="col-md-4 col-12 pb-4">
                                                <label for="app_stime">Start Time</label>
                                                <input type="text" name="app_stime" class="form-control" id="app_stime"  value="<?php if (isset($cal_res['sc_stime'])) echo $cal_res['sc_stime'] ?>" onclick="$('#app_etime').val('')" onblur="rset_timeto();"  >
                                            </div>
                                            <div class="col-md-4 col-12 pb-4">
                                                <label for="app_etime">End Time</label>
                                                <input type="text" name="app_etime" class="form-control" id="app_etime" value="<?php if (isset($cal_res['sc_etime'])) echo $cal_res['sc_etime'] ?>" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 pb-3">
                                                <label for="app_remarks">Remarks</label>
                                                <input type="text" name="app_remarks" class="form-control" id="app_remarks"  value="<?php if (isset($cal_res['sc_remarks'])) echo stripslashes($cal_res['sc_remarks']) ?>" >
                                            </div>
                                        </div>

                                        <div class="row ">
                                            <div class="col-md-3 col-12 pb-4">
                                                <input type="submit" class="btn chanAddres chng w-100" name="submit" value="Submit" >
                                            </div>
                                        </div>

                                    </form>
                                </div>

                                <!--<address>-->

                                <div class="tab-pane container fade" id="appointments">     

                                    <form method="post" id="appointment_form" >
                                        <div class="sucess-msg successappointment text-center pb-4 font-weight-bold"></div>
                                        <div class="partner-style" id="show_partner">
                                            <div class="row">
                                                <div class="col-md-7 col-12 pb-2">
                                                    <p class="formHead">Appointment Details</p>
                                                </div>
                                            </div>

                                            <div class="row viewAppointment ">
                                                <div class="col-lg-12">

                                                    <table class="border">
                                                        <tbody><tr >
                                                                <th  >Ac Code</th>
                                                                <th  >Ac Name</th>
                                                                <th >Date</th>
                                                                <th >Post Code</th>
                                                                <th  >County/Town</th>
                                                                <th  >Start Time</th>
                                                                <th  >End Time</th>
                                                                <th  >Remarks</th>
                                                                <th  >Edit</th>
                                                                <th  >Delete</th>
                                                                <th >Status</th>
                                                            </tr>

                                                            <?php
                                                            $applist_sql = "select * from rollco_salesCal where sec_id = '" . $_SESSION['u_id'] . "' and sc_status = 1 order by sc_date asc";
                                                            $applist_num = $sq->numsrow($applist_sql);
//$applist_num=0;
                                                            if ($applist_num > 0) {
                                                                $applist_data = $sq->query($applist_sql);
                                                                while ($applist_res = $sq->fetch($applist_data)) {
                                                                    $gsql = "select g.gr_nm from rollco_ms_group g,rollco_ms_users u where g.gr_id = u.g_id and u.u_id = " . $applist_res['u_id'];
                                                                    $gres = $sq->fearr($gsql);
//$applist_res['sc_status']=2;
                                                                    ?>
                                                                    <tr id="rm_<?php echo $applist_res['sc_id'] ?>">
                                                                        <td >
                                                                            <a class="link" href="<?php echo $siteurl ?>sales-front-sheet.php?sales=<?php echo base64_encode($applist_res['u_id']); ?>"><?php if (isset($gres['gr_nm'])) echo $gres['gr_nm'] ?></a> 
                                                                        </td>
                                                                        <td><?php
                                                                            if (isset($applist_res['full_name']))
                                                                                echo $applist_res['full_name'];
                                                                            if (isset($applist_res['post_code']) && $applist_res['post_code'] != '')
                                                                                echo '(' . $applist_res['post_code'] . ')';
                                                                            ?></td>
                                                                        <td><?php if (isset($applist_res['sc_date']) && $applist_res['sc_date'] != '') echo date('d-m-Y', strtotime($applist_res['sc_date'])); ?></td>
                                                                        <td><?php if (isset($applist_res['post_code'])) echo $applist_res['post_code']; ?></td>
                                                                        <td><?php if (isset($applist_res['sc_country'])) echo $applist_res['sc_country']; ?></td>
                                                                        <td ><?php if (isset($applist_res['sc_stime']) && $applist_res['sc_stime'] != '') echo date('h:i A', strtotime(date('y-m-d') . ' ' . $applist_res['sc_stime'])); ?></td>
                                                                        <td ><?php if (isset($applist_res['sc_etime']) && $applist_res['sc_etime'] != '') echo date('h:i A', strtotime(date('y-m-d') . ' ' . $applist_res['sc_etime'])); ?></td>
                                                                        <td ><?php if (isset($applist_res['sc_remarks'])) echo stripslashes($applist_res['sc_remarks']); ?></td>
                                                                        <td ><?php if (isset($applist_res['sc_status']) && $applist_res['sc_status'] != 2) { ?><a class="link" href="?action=edit&sc_id=<?php echo $applist_res['sc_id'] ?>">Edit</a><?php
                                                                            } else {
                                                                                echo '-';
                                                                            }
                                                                            ?></td>
                                                                        <td ><?php if (isset($applist_res['sc_status']) && $applist_res['sc_status'] != 2) { ?><a class="link" href="javascript:void();" onclick="del_appointment('<?php echo $applist_res['sc_id'] ?>');">Delete</a><?php
                                                                            } else {
                                                                                echo '-';
                                                                            }
                                                                            ?></td>
                                                                        <td ><?php if (isset($applist_res['sc_status']) && $applist_res['sc_status'] != 2) { ?><a class="link" href="javascript:void();" onclick="close_appointment('<?php echo $applist_res['sc_id'] ?>');">Close</a><?php } ?></td>
                                                                    </tr>
                                                                    <?php
//$applist_res['sc_id']
                                                                }
                                                            } else {
                                                                ?>
                                                                <tr>
                                                                    <td colspan="11" class="text-center">Appointment not found.</td>
                                                                </tr>
                                                                <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <?php
                                    $user_id = '';
                                    if (isset($_GET['sales']) && $_GET['sales'] != '') {
                                        $user_id = base64_decode($_GET['sales']);

                                        $act_no = '';
                                        $post_code = '';
                                        $uemail = '';
                                        $uphone = '';
                                        $buying_grp = '';
                                        $uacnt_date = '';
                                        $uname = '';

                                        $prevtoprevyr = date('Y') - 3;
                                        $prevyr = date('Y') - 2;
                                        $curryr = date('Y') - 1;

                                        $usql = "SELECT g_id,firstName,lastName,com_zipCode,com_emailAddress,com_Telephone,buying_group,regisdate FROM rollco_ms_users WHERE user_status=2 AND cust_type !=3 AND u_id='" . $user_id . "' LIMIT 1";

                                        $user_num = $sq->numsrow($usql);
//$applist_num=0;
                                        if ($user_num > 0) {
                                            $user_data = $sq->query($usql);
                                            while ($user_res = $sq->fetch($user_data)) {
                                                $uname = $user_res['firstName'] . ' ' . $user_res['lastName'];
                                                $act_no = $user_res['g_id'];
                                                $post_code = $user_res['com_zipCode'];
                                                $uemail = $user_res['com_emailAddress'];
                                                $uphone = $user_res['com_Telephone'];
                                                $buying_grp = $user_res['buying_group'];
                                                $uacnt_date = $user_res['regisdate'];
                                            }
                                        }
                                        $roll_last_year_turnover = $roll_share_per = $gross_qty = $gross_faulty = $gross_faulty_per = $gross_return_stock = $faulty_cat_qty = $faulty_cat_nff = $faulty_cat_transit_damage = $faulty_cat_contanimated = $roll_curr_outstanding = $roll_consgnmt_qty = $roll_overdue_outstanding = $roll_consgnmt_value = $roll_sor_extended = $roll_last_visit = $ss_id = 0;
                                        $roll_last_stock_cdate = '';
                                        $sheetSql = "SELECT ss_id,roll_last_year_turnover,roll_share_per,gross_qty,gross_faulty,gross_faulty_per,gross_return_stock,faulty_cat_qty,faulty_cat_nff,faulty_cat_transit_damage,
faulty_cat_contanimated,roll_curr_outstanding,roll_consgnmt_qty,roll_overdue_outstanding,roll_consgnmt_value,roll_last_stock_cdate,roll_sor_extended,
roll_last_visit FROM rollco_ms_sales_sheet WHERE user_id = '" . $user_id . "'";

                                        $sheet_num = $sq->numsrow($sheetSql);

                                        if ($sheet_num > 0) {
                                            $sheet_data = $sq->query($sheetSql);
                                            while ($sheet_res = $sq->fetch($sheet_data)) {
                                                $roll_last_year_turnover = $sheet_res['roll_last_year_turnover'];
                                                $roll_share_per = $sheet_res['roll_share_per'];
                                                $gross_qty = $sheet_res['gross_qty'];
                                                $gross_faulty = $sheet_res['gross_faulty'];
                                                $gross_faulty_per = $sheet_res['gross_faulty_per'];
                                                $gross_return_stock = $sheet_res['gross_return_stock'];
                                                $faulty_cat_qty = $sheet_res['faulty_cat_qty'];
                                                $faulty_cat_nff = $sheet_res['faulty_cat_nff'];
                                                $faulty_cat_transit_damage = $sheet_res['faulty_cat_transit_damage'];
                                                $faulty_cat_contanimated = $sheet_res['faulty_cat_contanimated'];
                                                $roll_curr_outstanding = $sheet_res['roll_curr_outstanding'];
                                                $roll_consgnmt_qty = $sheet_res['roll_consgnmt_qty'];
                                                $roll_overdue_outstanding = $sheet_res['roll_overdue_outstanding'];
                                                $roll_consgnmt_value = $sheet_res['roll_consgnmt_value'];
                                                $roll_sor_extended = $sheet_res['roll_sor_extended'];
                                                $roll_last_visit = $sheet_res['roll_last_visit'];
                                                $roll_last_stock_cdate = $sheet_res['roll_last_stock_cdate'];
                                                $ss_id = $sheet_res['ss_id'];
                                            }
                                        }
                                        if ($ss_id > 0) {
                                            $scatSql = "SELECT ssv_scat_id,ssv_scat_name,ssv_scat_year,ssv_scat_value,ssv_scat_qty,ssv_scat_faulty,ssv_scat_faulty_per WHERE ssv_ss_id = '" . $ss_id . "' AND (ssv_scat_year = '" . $prevtoprevyr . "' OR ssv_scat_year='" . $prevyr . "' OR ssv_scat_year='" . $curryr . "')";
                                            $scat_num = $sq->numsrow($scatSql);
                                            if ($scat_num > 0) {
                                                $scat_data = $sq->query($scatSql);
                                                while ($scat_res = $sq->fetch($scatSql)) {
                                                    
                                                }
                                            }
                                        }
                                        ?>
                                        <article class="clearfix rollcoPartsf " >
                                            <div class="container">
                                                <div class="row  pt-5">
                                                    <div class="col-md-4 mb-3 padRig">
                                                        <label>Customer Name </label>
                                                        <h6 class="font-weight-600"><?php echo ucfirst($uname); ?></h6>
                                                    </div> 

                                                </div>
                                                <div class="row mt-4 sscustcat">
                                                    <div class="col-md-4 mb-3 padRig">
                                                        <label>Account No</label>
                                                        <?php
                                                        $gsql = "select g.gr_nm from rollco_ms_group g,rollco_ms_users u where g.gr_id = u.g_id and u.u_id = " . $user_id;
                                                        $gres = $sq->fearr($gsql);
                                                        ?>
                                                        <h6 class="font-weight-600"><?php if (isset($gres['gr_nm'])) echo $gres['gr_nm']; ?></h6>
                                                    </div>
                                                    <div class="col-md-4 mb-3 padRig">
                                                        <label>Post Code</label>
                                                        <h6 class="font-weight-600"><?php echo $post_code; ?></h6>
                                                    </div>
                                                    <div class="col-md-4 mb-3 padRig">
                                                        <label>Email</label>
                                                        <h6 class="font-weight-600"><?php echo $uemail; ?></h6>
                                                    </div>
                                                </div>
                                                <div class="row mt-4 sscustcat">
                                                    <div class="col-md-4 mb-3 padRig">
                                                        <label>Phone No</label>
                                                        <h6 class="font-weight-600"><?php echo $uphone; ?></h6>
                                                    </div>
                                                    <div class="col-md-4 mb-3 padRig">
                                                        <label>Buying Group</label>
                                                        <h6 class="font-weight-600"><?php echo $buying_grp; ?></h6>
                                                    </div>
                                                    <div class="col-md-4 mb-3 padRig">
                                                        <label>Account opened date</label>
                                                        <h6 class="font-weight-600"><?php echo $uacnt_date; ?></h6>
                                                    </div>
                                                </div>
                                                <div class="row  pt-4"> 
                                                    <div class="table-responsive col-12">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <th><span id="label5">Rotating Turnover Last Year</span></th>
                                                                    <td><span><?php
                                                                            if (isset($roll_last_year_turnover))
                                                                                echo $roll_last_year_turnover;
                                                                            else
                                                                                echo 0;
                                                                            ?></span></td>
                                                                    <th colspan="2" ><span >ROLLING SHARE %</span></th>
                                                                    <td><span><?php
                                                                            if (isset($roll_share_per))
                                                                                echo $roll_share_per;
                                                                            else
                                                                                echo 0;
                                                                            ?></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th ><span id="label222">OTHER DETAILS</span></th>
                                                                    <td>&nbsp;</td>
                                                                    <td colspan="2">&nbsp;</td>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <th><span id="label20">SPEND INFO</span></th>
                                                                    <td><span id="Label21"><?php echo $prevtoprevyr; ?></span></td>
                                                                    <th colspan="2"><span id="Label22"><?php echo $prevyr; ?></span></th>
                                                                    <td><span id="Label23"><?php echo $curryr; ?></span></td>
                                                                </tr>
                                                                <?php
                                                                $scatArr = [];
                                                                $cnt = 0;
                                                                if ($ss_id > 0) {
                                                                    $scatSql = "SELECT ssv_scat_id,ssv_scat_name,ssv_scat_year,ssv_scat_value,ssv_scat_qty,ssv_scat_faulty,ssv_scat_faulty_per FROM rollco_ms_scat_sales_val WHERE ssv_ss_id = '" . $ss_id . "' AND (ssv_scat_year = '" . (date('Y') - 3) . "' OR ssv_scat_year='" . (date('Y') - 2) . "' OR ssv_scat_year='" . (date('Y') - 1) . "')";
                                                                    $scat_num = $sq->numsrow($scatSql);
                                                                    if ($scat_num > 0) {
                                                                        $scat_data = $sq->query($scatSql);
                                                                        while ($scat_res = $sq->fetch($scat_data)) {
                                                                            $scatArr[$scat_res['ssv_scat_year']][$scat_res['ssv_scat_id']] = array('ssv_scat_name' => $scat_res['ssv_scat_name'],
                                                                                'ssv_scat_value' => $scat_res['ssv_scat_value'],
                                                                                'ssv_scat_qty' => $scat_res['ssv_scat_qty'],
                                                                                'ssv_scat_faulty' => $scat_res['ssv_scat_faulty'],
                                                                                'ssv_scat_faulty_per' => $scat_res['ssv_scat_faulty_per']);
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                                <?php
                                                                $totCnt = 0;
                                                                $totArr = [];
                                                                $scatgetSql = "SELECT cat_id FROM rollco_user_to_category_tag WHERE u_id = '" . $user_id . "'";
                                                                $scatget_num = $sq->numsrow($scatgetSql);

                                                                if ($scatget_num > 0) {
                                                                    $scatget_data = $sq->query($scatgetSql);
                                                                    while ($scatget_res = $sq->fetch($scatget_data)) {
                                                                        ?>
                                                                        <tr>
                                                                            <th ><span id="label7"><?php echo $scatArr[$curryr][$scatget_res['cat_id']]['ssv_scat_name']; ?>- QTY </span></th>
                                                                            <td><span id="lblUnitsQty2015"><?php
                                                                                    if (isset($scatArr[$prevtoprevyr][$scatget_res['cat_id']]['ssv_scat_qty']))
                                                                                        echo $scatArr[$prevtoprevyr][$scatget_res['cat_id']]['ssv_scat_qty'];
                                                                                    else
                                                                                        echo 0;
                                                                                    ?></span></td>
                                                                            <td colspan="2"><span id="lblUnitsQty2016"><?php
                                                                                    if (isset($scatArr[$prevyr][$scatget_res['cat_id']]['ssv_scat_qty']))
                                                                                        echo $scatArr[$prevyr][$scatget_res['cat_id']]['ssv_scat_qty'];
                                                                                    else
                                                                                        echo 0;
                                                                                    ?></span></td>
                                                                            <td><span><?php
                                                                                    if (isset($scatArr[$curryr][$scatget_res['cat_id']]['ssv_scat_qty']))
                                                                                        echo $scatArr[$curryr][$scatget_res['cat_id']]['ssv_scat_qty'];
                                                                                    else
                                                                                        echo 0;
                                                                                    ?></span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th ><span id="label12"><?php echo $scatArr[$curryr][$scatget_res['cat_id']]['ssv_scat_name']; ?>- VALUE</span></th>
                                                                            <td><span id="lblUnitsValue2015"><?php
                                                                                    if (isset($scatArr[$prevtoprevyr][$scatget_res['cat_id']]['ssv_scat_value']))
                                                                                        echo $scatArr[$prevtoprevyr][$scatget_res['cat_id']]['ssv_scat_value'];
                                                                                    else
                                                                                        echo 0;
                                                                                    ?></span></td>
                                                                            <td colspan="2"><span id="lblUnitsValue2016"><?php
                                                                                    if (isset($scatArr[$prevyr][$scatget_res['cat_id']]['ssv_scat_value']))
                                                                                        echo $scatArr[$prevyr][$scatget_res['cat_id']]['ssv_scat_value'];
                                                                                    else
                                                                                        echo 0;
                                                                                    ?></span></td>
                                                                            <td><span><?php
                                                                                    if (isset($scatArr[$curryr][$scatget_res['cat_id']]['ssv_scat_value']))
                                                                                        echo $scatArr[$curryr][$scatget_res['cat_id']]['ssv_scat_value'];
                                                                                    else
                                                                                        echo 0;
                                                                                    ?></span></td>
                                                                        </tr>
                                                                        <?php
                                                                        $totArr[$curryr] = 0;
                                                                        $totArr[$prevyr] = 0;
                                                                        $totArr[$prevtoprevyr] = 0;
                                                                        if (isset($scatArr[$curryr][$scatget_res['cat_id']]['ssv_scat_value'])) {
                                                                            $totArr[$curryr] = $totArr[$curryr] + $scatArr[$curryr][$scatget_res['cat_id']]['ssv_scat_value'];
                                                                        } else {
                                                                            $totArr[$curryr] = 0;
                                                                        }
                                                                        if (isset($scatArr[$prevyr][$scatget_res['cat_id']]['ssv_scat_value'])) {
                                                                            $totArr[$prevyr] = $totArr[$prevyr] + $scatArr[$prevyr][$scatget_res['cat_id']]['ssv_scat_value'];
                                                                        } else {
                                                                            $totArr[$prevyr] = 0;
                                                                        }
                                                                        if (isset($scatArr[$prevtoprevyr][$scatget_res['cat_id']]['ssv_scat_value'])) {
                                                                            $totArr[$prevtoprevyr] = $totArr[$prevtoprevyr] + $scatArr[$prevtoprevyr][$scatget_res['cat_id']]['ssv_scat_value'];
                                                                        } else {
                                                                            $totArr[$prevtoprevyr] = 0;
                                                                        }
                                                                        if (isset($scatArr[$curryr][$scatget_res['cat_id']]['ssv_scat_value']))
                                                                            $cnt = $cnt + $totArr[$prevtoprevyr] + $totArr[$prevyr] + $totArr[$curryr];
                                                                    }
                                                                }
                                                                ?>


                                                                <tr>
                                                                    <th><span id="label24">TOTAL SPEND</span></th>
                                                                    <td><span id="lblSpendTotal2015"><?php
                                                                            if (isset($totArr[$prevtoprevyr])) {
                                                                                echo $totArr[$prevtoprevyr];
                                                                            } else {
                                                                                echo 0;
                                                                            }
                                                                            ?></span></td>
                                                                    <td colspan="2"><span id="lblSpendTotal2016"><?php
                                                                            if (isset($totArr[$prevyr])) {
                                                                                echo $totArr[$prevyr];
                                                                            } else {
                                                                                echo 0;
                                                                            }
                                                                            ?></span></td>
                                                                    <td><span id="lblSpendTotal2017"><?php
                                                                            if (isset($totArr[$curryr])) {
                                                                                echo $totArr[$curryr];
                                                                            } else {
                                                                                echo 0;
                                                                            }
                                                                            ?></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th ><span id="label37">Gross Sale Qty</span></th>
                                                                    <td><span><?php echo $gross_qty; ?></span></td>
                                                                    <th colspan="2" ><span id="Label38">Faulty</span></th>
                                                                    <td><span><?php echo $gross_faulty; ?></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th ><span id="label39">Return to stock</span></th>
                                                                    <td><span><?php echo $gross_return_stock; ?></span></td>
                                                                    <th colspan="2" ><span id="Label40">Faulty %</span></th>
                                                                    <td><span><?php echo $gross_faulty_per; ?></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th ><span id="label41">Faulty Category</span></th>
                                                                    <th><span id="Label42">Faulty</span></th>
                                                                    <th><span id="Label43">NFF</span></th>
                                                                    <th><span id="Label44">Transit Damage</span></th>
                                                                    <th><span id="Label45">Contaminated</span></th>
                                                                </tr>
                                                                <tr>
                                                                    <th ><span id="label46">QTY</span></th>
                                                                    <td><span><?php echo $faulty_cat_qty; ?></span></td>
                                                                    <td><span><?php echo $faulty_cat_nff; ?></span></td>
                                                                    <td><span><?php echo $faulty_cat_transit_damage; ?></span></td>
                                                                    <td><span><?php echo $faulty_cat_contanimated; ?></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th ><span id="label28">Current Outstanding</span></th>
                                                                    <td><span><?php echo $roll_curr_outstanding; ?></span></td>
                                                                    <th colspan="2" ><span id="Label30">S/R or Congnmnt Qty</span></th>
                                                                    <td><span><?php echo $roll_consgnmt_qty; ?></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th ><span id="label29">Over Due Outstanding If any</span></th>
                                                                    <td><span><?php echo $roll_overdue_outstanding; ?></span></td>
                                                                    <th colspan="2" ><span id="Label31">S/R or Congnmnt Value</span></th>
                                                                    <td><span><?php echo $roll_consgnmt_value; ?></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th ><span id="label32">Last stock cleanse date</span></th>
                                                                    <td><span><?php echo $roll_last_stock_cdate; ?></span></td>
                                                                    <th colspan="2" ><span id="Label34">SOR / EXTENDED (if any)</span></th>
                                                                    <td><span><?php echo $roll_sor_extended; ?></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th><span id="Label36">Last Visit Done By</span></th>
                                                                    <td ><span><?php echo $roll_last_visit; ?></span></td>
                                                                    <td>&nbsp;</td>
                                                                    <td>&nbsp;</td>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">&nbsp;</td>
                                                                    <td colspan="3">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">&nbsp;</td>
                                                                    <td colspan="3">&nbsp;</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                </div>
                                <!--<password>-->

                                <div class="tab-pane container fade" id="salesreport">
                                    <form method="post" id="changepassword_form" >
                                        <div class="sucess-msg successappointment2 text-center pb-4 font-weight-bold"></div>
                                        <div class="row">
                                            <div class="col-md-6 col-12 pb-3">
                                                <label for="oldpassword"> Old Password</label>
                                                <input type="password" maxlength="15" name="oldpassword" id="oldpassword" class="form-control" placeholder="Old Password" autocomplete="nope">
                                                <div class="error-msg oldpassworderror"></div>

                                                <span toggle="#oldpassword" class="togglePassword text-danger font14 ">Show</span> </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-12 pb-3">
                                                <label for="password">Password</label>
                                                <input type="password" maxlength="15" name="password" id="password" class="form-control" placeholder="password" autocomplete="nope">
                                                <span toggle="#password" class="togglePassword text-danger font14 ">Show</span> </div>
                                            <div class="col-md-6 col-12 ">
                                                <label for="confirmPassword">Confirm Password</label>
                                                <input type="password" maxlength="15" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Confirm Password"  autocomplete="nope">
                                                <span toggle="#confirmPassword" class="togglePassword text-danger font14">Show</span> </div>
                                        </div>
                                        <div class="row ">
                                            <div class="col-md-3 col-12 pb-4">
                                                <input type="submit" class="btn chanAddres chng w-100" name="change_password" value="Change password" >
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </section>
        <?php include("inc-footer.php"); ?>
        <script src="js/bootstrap-daterangepicker/daterangepicker.js"></script> 
        <link href="css/jquery.datetimepicker.css" type="text/css" rel="stylesheet" />
        <script src="js/jquery.datetimepicker.min.js"></script>
        <script type="text/javascript">
<?php
if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    ?>

    <?php
} else {
    ?>
                                                                                $(document).ready(function () {
                                                                                    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
                                                                                        localStorage.setItem('activeTab', $(e.target).attr('href'));
                                                                                    });
                                                                                    var activeTab = localStorage.getItem('activeTab');
                                                                                    if (activeTab) {
                                                                                        $('#myTab a[href="' + activeTab + '"]').tab('show');
                                                                                    }
                                                                                });
    <?php
}
?>


                                                                            $(document).ready(function () {
                                                                                $('#app_date').daterangepicker({
                                                                                    autoUpdateInput: false,
                                                                                    singleDatePicker: true,
                                                                                    singleClasses: "picker_1",
                                                                                    locale: {
                                                                                        format: "YYYY-MM-DD",
                                                                                    }
                                                                                });
                                                                                $('#app_date').on('apply.daterangepicker', function (ev, picker) {
                                                                                    $(this).val(picker.startDate.format('YYYY-MM-DD'));
                                                                                });
                                                                                $('#app_stime').datetimepicker({datepicker: false, format: 'H:i', step: 5});
                                                                                //$('#app_etime').datetimepicker({datepicker:false,format:'h:i a', step:10});

                                                                            });

                                                                            function rset_timeto() {
                                                                                var min_time = $('#app_stime').val();
                                                                                min_time = parseInt(min_time.replace(":", ""));
                                                                                var new_min = min_time = min_time + 5;
                                                                                var res = String(new_min)
                                                                                if (res.length == 3)
                                                                                {
                                                                                    res = '0' + res;
                                                                                }
                                                                                var s = res;
                                                                                var a = new Array();
                                                                                var i = 2;
                                                                                do {
                                                                                    a.push(s.substring(0, i));
                                                                                } while ((s = s.substring(i, s.length)) != "");
                                                                                min_time = a[0] + ':' + a[1];
                                                                                $('#app_etime').val(min_time);
                                                                                $('#app_etime').datetimepicker({datepicker: false, format: 'H:i', minTime: min_time, defaultTime: min_time, step: 5});
                                                                            }
        </script> 



        <script>
            function del_appointment(del_id) {
                if (confirm('Are you sure want to delete.')) {
                    if (del_id > 0) {
                        var data = {"sc_id": del_id, "sec_id":<?php echo $_SESSION['u_id'] ?>};
                        $.ajax({
                            type: 'post',
                            url: "ajax/del_appointment.php",
                            data: data,
                            success: function (data) {
                                var html = '';
                                var data = JSON.parse(data);
                                if (data.status == 1) {
                                    $('.successappointment').addClass('text-success').show().html(data.data);
                                    $('.successappointment').delay(5000).fadeOut('slow');
                                    $("#rm_" + del_id).remove();
                                } else {
                                    $('.successappointment').addClass('text-danger').html(data.data);
                                }
                            }
                        });
                        return false;
                    }
                }
            }

            function close_appointment(sc_id) {
                if (confirm('Are you sure want to close.')) {
                    if (sc_id > 0) {
                        var data = {"sc_id": sc_id, "sec_id":<?php echo $_SESSION['u_id'] ?>};
                        $.ajax({
                            type: 'post',
                            url: "ajax/close_appointment.php",
                            data: data,
                            success: function (data) {
                                var html = '';
                                var data = JSON.parse(data);
                                if (data.status == 1) {
                                    $('.successappointment').addClass('text-success').show().html(data.data);
                                    $('.successappointment').delay(5000).fadeOut('slow');
                                    $("#rm_" + sc_id).remove();
                                } else {
                                    $('.successappointment').addClass('text-danger').html(data.data);
                                }
                            }
                        });
                        return false;
                    }
                }
            }

            $(document).ready(function () {
                $("#AC_Name").change(function () {
                    //            alert($(this).val()) ;
                    if ($(this).val() > 0) {
                        var data = {"AC_Name": $(this).val()};
                        $.ajax({
                            type: 'post',
                            url: "ajax/getAC_Name.php",
                            data: data,
                            success: function (data) {
                                var html = '';
                                var data = JSON.parse(data);
                                if (data.status == 1) {
                                    $('#Post_Code').val(data.zipCode).attr("readonly", true);
                                    $('#county').val(data.city).attr("readonly", true);
                                } else {
                                    $('#Post_Code').val('');
                                    $('#county').val('');
                                }
                            }
                        });

                    } else {
                        $("#Post_Code").val('');
                        $("#county").val('');
                    }
                    return false;
                });
            });
            jQuery.validator.addClassRules("required", {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            });
            jQuery.validator.addMethod("alphanumeric", function (value, element) {
                return this.optional(element) || /^[\w]+$/i.test(value);
            }, "Letters and numbers only please");

            jQuery.validator.addMethod("alphabetsAndSpacesOnly", function (value, element) {
                return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
            }, "Only Letters");

            jQuery.validator.addMethod("alphabetsAndSpacesnumbOnly", function (value, element) {
                return this.optional(element) || /^[\w\s]+$/.test(value);
            }, "Only Letters");

            $('#changepassword_form').validate({// initialize the plugin
                rules: {
                    oldpassword: {
                        required: true,
                        minlength: 6,
                        alphanumeric: true
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        alphanumeric: true
                    },
                    confirmPassword: {
                        required: true,
                        minlength: 6,
                        alphanumeric: true,
                        equalTo: "#password"
                    },
                },
            });
            $('#calendar_form').validate({// initialize the plugin
                rules: {
                    'AC_Name': {
                        required: true
                    },
                    'app_date': {
                        required: true,
                    },
                    'app_stime': {
                        required: true,
                    },
                    'app_etime': {
                        required: true,
                    },
                },
            });
            $('#calendar_editform').validate({// initialize the plugin
                rules: {
                    'AC_Name': {
                        required: true
                    },
                    'app_date': {
                        required: true,
                    },
                    'app_stime': {
                        required: true,
                    },
                    'app_etime': {
                        required: true,
                    },
                },
            });
            $('#changeaddress_form').validate({// initialize the plugin
                rules: {
                    'addresstype1[]': {
                        alphabetsAndSpacesOnly: true,
                        required: true

                    },
                    'streetAddress1[]': {
                        required: true,
                        alphabetsAndSpacesnumbOnly: true
                    },
                    'streetAddress2[]': {
                        required: true,
                        alphabetsAndSpacesnumbOnly: true
                    },
                    'com_city[]': {
                        alphabetsAndSpacesOnly: true,
                        required: true,
                    },
                    'com_state[]': {
                        alphabetsAndSpacesOnly: true,
                        required: true
                    },
                    'com_zipCode[]': {
                        required: true,
                        alphanumeric: true
                    },
                },
            });

            $(document).ready(function () {
                $(".togglePassword").click(function () {
                    $(this).toggleClass("eyeIcon eyeSlash");
                    var input = $($(this).attr("toggle"));
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                });
            });

            $(function () {

                $('#changepassword_form').on('submit', function (e) {
                    if ($("#changepassword_form").valid()) {
                        e.preventDefault();
                        $('.oldpassworderror').html('');
                        $('.successpass').html('');
                        $.ajax({
                            type: 'post',
                            url: "ajax/getchangepassword.php",
                            data: $('#changepassword_form').serialize(),
                            success: function (data) {
                                var html = '';
                                var data = JSON.parse(data);
                                if (data.status == 1) {
                                    $('.oldpassworderror').html('');
                                    $('.successpass').html(data.data);
                                    $('.successpass').delay(5000).fadeOut('slow');
                                    $('#changepassword_form').trigger("reset");
                                }
                                if (data.status == 2) {
                                    $('.successpass').html('');
                                    $('.oldpassworderror').html(data.data);
                                    $('.oldpassworderror').delay(5000).fadeOut('slow');
                                }
                            }
                        });
                    }
                });
            });


            $(function () {
                $('#calendar_form').on('submit', function (e) {
                    if ($("#calendar_form").valid()) {
                        e.preventDefault();
                        $('.successcalendar').html();
                        $.ajax({
                            type: 'post',
                            url: "ajax/calendar_form.php",
                            data: $('#calendar_form').serialize(),
                            success: function (data) {
                                var html = '';
                                var data = JSON.parse(data);
                                if (data.status == 1) {
                                    $('.successcalendar').addClass('text-success').show().html(data.data);
                                    $('.successcalendar').delay(5000).fadeOut('slow');
                                    $('#calendar_form').trigger("reset");

                                } else {
                                    $('.successcalendar').addClass('text-danger').show().html(data.data);
                                    $('.successcalendar').delay(5000).fadeOut('slow');
                                }
                            }
                        });
                    }
                    return false;
                });
            });

            $(function () {
                $('#calendar_editform').on('submit', function (e) {
                    if ($("#calendar_editform").valid()) {
                        e.preventDefault();
                        $('.successcalendar').html();
                        //                        alert('edit');
                        //                    return false;
                        $.ajax({
                            type: 'post',
                            url: "ajax/calendar_editform.php",
                            data: $('#calendar_editform').serialize(),
                            success: function (data) {
                                var html = '';
                                var data = JSON.parse(data);
                                if (data.status == 1) {
                                    $('.successcalendar').addClass('text-success').show().html(data.data);
                                    $('.successcalendar').delay(5000).fadeOut('slow');
                                    setTimeout(function () {
                                        window.location = 'calendars.php';
                                    }, 3000);


                                } else {
                                    $('.successcalendar').addClass('text-danger').show().html(data.data);
                                    $('.successcalendar').delay(5000).fadeOut('slow');
                                }
                            }
                        });
                    }
                    return false;
                });
            });

            addaddress();
            function addaddress() {
                $('#otheraddress').html('');
                $.ajax({
                    type: 'get',
                    url: "ajax/getuserotheraddress.php",
                    data: {data: '1'},
                    success: function (data) {
                        var html = '';
                        var data = JSON.parse(data);
                        if (data.status == 1) {
                            $.each(data.data, function (index, item) {
                                html += '<div class="row "><div class="col-md-7 col-12 pb-2"><p class="formHead">Other Address ' + (index + 1) + '</p></div><div class="col-lg-12"><div class="row"><div class="col-md-4 col-12 pb-3"><label for="myBusiness">Address Type </label><input type="text" name="addresstype1[]" class="form-control" id="addresstype1" value="' + item.addresstypeother + '"></div></div><div class="row"><div class="col-md-6 col-12 pb-4"><label for="streetAddress1">Street Address 1</label> <input type="text" name="streetAddress1[]" class="form-control" id="streetAddress1" value="' + item.streetAddress1other + '"> </div><div class="col-md-6 col-12 pb-4"><label for="streetAddress2">Street Address 2 </label> <input type="text" name="streetAddress2[]" class="form-control" id="streetAddress2" value="' + item.streetAddress2other + '"></div></div><div class="row"><div class="col-md-4 col-12 pb-4"><label for="city">City</label><input type="text" name="com_city[]"  class="form-control" id="com_city" value="' + item.com_cityother + '"></div><div class="col-md-4 col-12 pb-4"><label for="state">State</label><input type="text" name="com_state[]" class="form-control" id="com_state" value="' + item.com_stateother + '"></div> <div class="col-md-4 col-12 pb-4"><label for="zipCode">Zip Code</label><input type="text" name="com_zipCode[]" class="form-control" id="com_zipCode" value="' + item.com_zipCodeother + '"></div></div></div></div>';
                            });
                            $('#otheraddress').html(html);
                            $('.successaddress').html(data.data);
                            $('#changeaddress_form').trigger("reset");
                        }
                        if (data.status == 2) {
                            $('.successaddress').html(data.data);
                        }
                    }
                });
            }

            function addRow() {
                document.querySelector('#content').insertAdjacentHTML('afterbegin', '<div class="row newclass"><div class="col-lg-12"><div class="row"><div class="col-md-4 col-12 pb-3"><label for="myBusiness">Address Type </label><input type="text" name="addresstype1[]" class="form-control" id="addresstype1" placeholder="Home, Office, etc" ></div> </div><div class="row"><div class="col-md-6 col-12 pb-4"><label for="streetAddress1">Street Address 1</label><input type="text" name="streetAddress1[]" class="form-control" id="streetAddress1" placeholder="House No."></div><div class="col-md-6 col-12 pb-4"><label for="streetAddress2">Street Address 2 </label><input type="text" name="streetAddress2[]" class="form-control" id="streetAddress2" placeholder="Street / Locality/ Building Name"></div></div><div class="row"><div class="col-md-4 col-12 pb-4"><label for="city">City</label><input type="text" name="com_city[]" class="form-control" id="com_city" placeholder="City"></div><div class="col-md-4 col-12 pb-4"><label for="state">State</label><input type="text" name="com_state[]" class="form-control" id="com_state" placeholder="State"></div><div class="col-md-4 col-12 pb-4"><label for="zipCode">Zip Code</label><input type="text" name="com_zipCode[]" class="form-control" id="com_zipCode" placeholder="Zip Code"></div></div></div><p onclick="removeRow(this)" class="text-right w-100 d-block pr-3 pl-3 remPoint"><a>- Remove</a></p></div>');
            }

            function removeRow(input) {
                input.parentNode.remove()
            }


        </script>
    </body>
</html>
