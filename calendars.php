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
$checkuser_sql = "SELECT u_id,chooseOption,firstName,lastName,com_Telephone,com_Fax,com_emailAddress,streetAddress1,streetAddress2,com_city,com_state,com_zipCode,report_access FROM rollco_ms_users WHERE u_id = '" . $u_id . "' AND user_status = 2";
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
                                <li class="nav-item"> <a class="nav-link " data-toggle="tab" href="#appointments">View appointments</a> </li>
                                <?php if (isset($userdata['report_access']) && $userdata['report_access'] == 1) { ?>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#salesreport">Sales Report</a> </li>
                                <?php } ?>
                            </ul>
                            <?php
                            $err = '';
                            $cform_id = 'calendar_form';
                            if (isset($_GET['action']) && $_GET['action'] == 'edit') {
                                $cal_sql = "select * from rollco_salescal where sec_id = '" . $_SESSION['u_id'] . "' and sc_status = 1 and sc_id = " . $_GET['sc_id'];
                                $cal_res = $sq->fearr($cal_sql);
                                if (isset($cal_res['sc_id']) && $cal_res['sc_id'] > 0) {
                                    $cform_id = 'calendar_editform';
                                } else {
                                    echo "<script>location.href='calendars.php';</script>";
                                    exit;
                                }
                            }
//                            if (isset($_GET['suc']) && $_GET['suc'] == '1') {
//                                unset($_SESSION['new_apt']);
//                                echo "<script>location.href='calendars.php';</script>";
//                                exit;
//                            }
                            ?>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane container active" id="newcalendar">
                                    <div class="sucess-msg successcalendar  text-center pb-4 font-weight-bold text-success font-30">

                                    </div>

                                    <form method="post" id="<?php echo $cform_id ?>" >

                                        <div class="row">

                                            <div class="col-md-4 col-12 pb-4">

                                                <label for="AC_Name">Company Name</label>
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
                                                        $usql = "select u_id,firstName,lastName,companyName,com_zipCode from rollco_ms_users where cust_type = 1  and companyName !='' and cal_show=1  and (user_status=2 OR user_status = 4 ) order by companyName asc ";
                                                        $udata = $sq->query($usql);
                                                        while ($ures = $sq->fetch($udata)) {
                                                            $optionname = trim($ures['companyName']);
                                                            if ($ures['com_zipCode'] != '')
                                                                $optionname .= '(' . $ures['com_zipCode'] . ')';
                                                            ?>
                                                            <option value="<?php echo $ures['u_id'] ?>"><?php echo $optionname ?></option>
                                                            <?php
                                                        }
                                                        ?>                                       <option value="new">New Customer</option>             
                                                    </select>

                                                    <input type="text" name="AC_Name_new" class="form-control" id="AC_Name_new" value="" style="display: none" />
                                                    <label id="AC_Name_new-error" class="error" for="AC_Name_new" style="display: none">This field is required.</label>
                                                    <?php
                                                }
                                                ?>


                                            </div>
                                            <div class="col-md-4 col-12 pb-4">
                                                <label for="Post_Code">Post Code</label>
                                                <input type="text" name="Post_Code"  class="form-control" id="Post_Code" value="<?php if (isset($cal_res['post_code'])) echo $cal_res['post_code'] ?>" <?php if (isset($cal_res['post_code'])) echo 'disabled="disabled"'; ?> >
                                                <label id="Post_Code-error" class="error" for="Post_Code" style="display: none">This field is required.</label>                                                                      </div>
                                            <div class="col-md-4 col-12 pb-4">
                                                <label for="county">County/ Town</label>
                                                <input type="text" name="county" class="form-control" id="county" value="<?php if (isset($cal_res['sc_country'])) echo $cal_res['sc_country'] ?>" <?php if (isset($cal_res['sc_country'])) echo 'disabled="disabled"'; ?> >
                                                <label id="county-error" class="error" for="county" style="display: none">This field is required.</label>                                                                      </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 col-12 pb-4">
                                                <label for="app_date">Date</label>
                                                <input type="text" name="app_date" class="form-control" id="app_date" value="<?php if (isset($cal_res['sc_date'])) echo $cal_res['sc_date'] ?>" readonly/>
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
                                            <div class="col-md-3 col-md-3 pb-4">
                                                <input type="submit" class="btn chanAddres chng w-100" name="submit" value="Submit" >

                                            </div>
                                            <div class="col-md-3 col-md-3 pb-4 backbtn" style="display:none;">

                                                <a href="<?php echo $siteurl ?>calendars.php" class="btn chanAddres chng w-100" > Back</a>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                                <!--<address>-->

                                <div class="tab-pane container" id="appointments">     

                                    <form method="post" id="appointment_form" >
                                        <div class="sucess-msg successappointment text-center pb-4 font-weight-bold"></div>
                                        <div class="partner-style" id="show_partner">

                                            <?php if (!isset($_GET['sales']) || $_GET['sales'] == '') { ?>
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
                                                                    <th  >Company Name</th>
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
                                                                $applist_sql = "select * from rollco_salescal where sec_id = '" . $_SESSION['u_id'] . "' and sc_status = 1 order by sc_date desc,sc_stime desc";
                                                                $applist_num = $sq->numsrow($applist_sql);
//$applist_num=0;
                                                                if ($applist_num > 0) {
                                                                    $applist_data = $sq->query($applist_sql);
                                                                    while ($applist_res = $sq->fetch($applist_data)) {
                                                                        $gres = array();
                                                                        $tres = array();

                                                                        if ($applist_res['u_id'] > 0) {
                                                                            $gsql = "SELECT customerID FROM rollco_ms_users WHERE u_id = " . $applist_res['u_id'];
                                                                            //$gsql = "select g.gr_nm from rollco_ms_group g,rollco_ms_users u where g.gr_id = u.g_id and u.u_id = " . $applist_res['u_id'];
                                                                            $gres = $sq->fearr($gsql);
                                                                        } else if ($applist_res['temp_id'] > 0) {
                                                                            $tsql = "select customerID from rollco_ms_tmpusers where u_id = " . $applist_res['temp_id'];
                                                                            $tres = $sq->fearr($tsql);
                                                                        }
//$applist_res['sc_status']=2;
                                                                        ?>
                                                                        <tr id="rm_<?php echo $applist_res['sc_id'] ?>">
                                                                            <td >
                                                                                <a class="link" href="<?php echo $siteurl ?>calendars.php?sales=<?php echo base64_encode($applist_res['sc_id']); ?>"><?php
                                                                                    if (isset($gres['customerID']))
                                                                                        echo $gres['customerID'];
                                                                                    else
                                                                                        echo $tres['customerID']
                                                                                        ?></a>
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
                                                                            <td ><?php if (isset($applist_res['sc_status']) && $applist_res['sc_status'] != 2) { ?><a class="link" href="javascript:void(0);" onclick="close_appointment('<?php echo $applist_res['sc_id'] ?>', '<?php echo $applist_res['u_id'] ?>', '<?php echo $applist_res['temp_id'] ?>');">Close</a><?php } ?></td>
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
                                            <?php } ?>
                                        </div>
                                    </form>
                                    <?php
                                    $user_id = '';
                                    $tempuser_id = '';
                                    $sc_date = '';
                                    $strt_time = '';
                                    $end_time = '';
                                    if (isset($_GET['sales']) && $_GET['sales'] != '') {

                                        $applist_sql = "select * from rollco_salescal where sec_id = '" . $_SESSION['u_id'] . "' and sc_status = 1 AND sc_id='" . base64_decode($_GET['sales']) . "' LIMIT 1";
                                        $applist_num = $sq->numsrow($applist_sql);
//$applist_num=0;
                                        if ($applist_num > 0) {
                                            $applist_data = $sq->query($applist_sql);
                                            while ($applist_res = $sq->fetch($applist_data)) {
                                                $user_id = $applist_res['u_id'];
                                                $tempuser_id = $applist_res['temp_id'];
                                                $sc_date = $applist_res['sc_date'];
                                                $strt_time = $applist_res['sc_stime'];
                                                $end_time = $applist_res['sc_etime'];
                                            }
                                        }

                                        $roll_Last_Visit_DoneBy = '';
                                        $roll_Last_Visit_Date = '';
                                        if ($user_id > 0) {
                                            $Lastapp_sql = "select sc.sc_date,sc.sc_stime,u.firstName,u.lastName from rollco_salescal sc,rollco_ms_users u where sc.u_id = '" . $user_id . "' and sc.sec_id = u.u_id and sc.sc_status = 2 order by sc.sc_date desc,sc.sc_stime desc LIMIT 1";
                                            $Lastapp_res = $sq->fearr($Lastapp_sql);
                                            $roll_Last_Visit_DoneBy = trim($Lastapp_res['firstName'] . ' ' . $Lastapp_res['lastName']);
                                            $roll_Last_Visit_Date = $Lastapp_res['sc_date'] . ' ' . $Lastapp_res['sc_stime'];
                                        }
                                        $act_no = '';
                                        $post_code = '';
                                        $uemail = '';
                                        $uphone = '';
                                        $buying_grp = '';
                                        $uacnt_date = '';
                                        $uname = '';
                                        $custID = '';
                                        $prevtoprevyr = date('Y') - 2;
                                        $prevyr = date('Y') - 1;
                                        $curryr = date('Y');
                                        $flag = 0;

                                       
                                        if ($user_id > 0) {
                                            $usql = "SELECT g_id,firstName,lastName,com_zipCode,com_emailAddress,com_Telephone,buying_group,regisdate,companyName FROM rollco_ms_users WHERE  cust_type !=3 AND u_id='" . $user_id . "' LIMIT 1";

                                            $user_num = $sq->numsrow($usql);
//$applist_num=0;
                                            if ($user_num > 0) {
                                                $flag = 1;
                                                $user_data = $sq->query($usql);
                                                while ($user_res = $sq->fetch($user_data)) {
                                                    $uname = $user_res['firstName'] . ' ' . $user_res['lastName'];
                                                    $act_no = $user_res['g_id'];
                                                    $post_code = $user_res['com_zipCode'];
                                                    $uemail = $user_res['com_emailAddress'];
                                                    $uphone = $user_res['com_Telephone'];
                                                    $buying_grp = $user_res['buying_group'];
                                                    $uacnt_date = $user_res['regisdate'];
                                                    $companyName = $user_res['companyName'];
                                                }
                                            }
                                        } else {
                                            $temp_sql = "select firstName,lastName,com_zipCode,created_at,customerID  FROM rollco_ms_tmpusers WHERE u_id='" . $tempuser_id . "' LIMIT 1";
                                            $temp_num = $sq->numsrow($temp_sql);
//$applist_num=0;
                                            if ($temp_num > 0) {
                                                $temp_data = $sq->query($temp_sql);
                                                while ($temp_res = $sq->fetch($temp_data)) {
                                                    $companyName = $temp_res['firstName'];
                                                    $post_code = $temp_res['com_zipCode'];
                                                    $uacnt_date = $temp_res['created_at'];
                                                    $custID = $temp_res['customerID'];
                                                }
                                            }
                                        }
                                        ?>
                                        <div class="row">
                                            <div class="col-md-10 col-10 pb-2">
                                                <p class="col"><span>Appointment Date: </span> <span class="formHead font-weight-600 "> <?php echo date('F jS, Y', strtotime($sc_date)); ?> between  <?php echo date('h:i a', strtotime($strt_time)) . ' to ' . date('h:i a', strtotime($end_time)); ?></span> </p>
                                            </div>
                                            <div class="col-md-2 col-2 ">
                                                <a class="btn  w-100 back-btn" href="<?php echo $siteurl ?>calendars.php">Back</a>
                                            </div>
                                        </div>

                                        <div class="container">

                                            <div class="row pt-1">
                                                <div class="col-md-4 ">
                                                    <label>Company Name </label>
                                                    <h6 class="font-weight-600"><?php echo ucfirst($companyName); ?></h6>
                                                </div> 
                                                <div class="col-md-4  ">
                                                    <label>Account No</label>
                                                    <?php
                                                    $gsql = "SELECT customerID FROM rollco_ms_users WHERE u_id = " . $user_id;
                                                    //$gsql = "select g.gr_nm from rollco_ms_group g,rollco_ms_users u where g.gr_id = u.g_id and u.u_id = " . $user_id;
                                                    $gres = $sq->fearr($gsql);
                                                    ?>
                                                    <h6 class="font-weight-600"><?php
                                                if (isset($gres['customerID'])) {
                                                    echo $gres['customerID'];
                                                } else {
                                                    echo $custID;
                                                }
                                                    ?></h6>
                                                </div>

                                            </div>
                                            <div class="row mt-4 sscustcat">

                                                <div class="col-md-4 ">
                                                    <label>Post Code</label>
                                                    <h6 class="font-weight-600"><?php echo $post_code; ?></h6>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <label>Email</label>
                                                    <h6 class="font-weight-600"><?php echo $uemail; ?></h6>
                                                </div>
                                            </div>
                                            <div class="row mt-4 sscustcat">
                                                <div class="col-md-4 ">
                                                    <label>Phone No</label>
                                                    <h6 class="font-weight-600"><?php echo $uphone; ?></h6>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <label>Buying Group</label>
                                                    <h6 class="font-weight-600"><?php echo $buying_grp; ?></h6>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <label>Account opened date</label>
                                                    <h6 class="font-weight-600"><?php echo $uacnt_date; ?></h6>
                                                </div>
                                            </div>
                                            <?php
                                            if ($flag) {
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
                                                ?>
                                                <div class="row "> 
                                                    <form method="post" id="apt_details" class="w-100">
                                                        <div class="table-responsive col-12">
                                                            <table class="table">
                                                                <tbody>
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
                                                                        $scatSql = "SELECT ssv_scat_id,ssv_scat_name,ssv_scat_year,ssv_scat_value,ssv_scat_qty,ssv_scat_faulty,ssv_scat_faulty_per FROM rollco_ms_scat_sales_val WHERE ssv_ss_id = '" . $ss_id . "' AND (ssv_scat_year = '" . (date('Y') - 2) . "' OR ssv_scat_year='" . (date('Y') - 1) . "' OR ssv_scat_year='" . (date('Y')) . "')";
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
                                                                                <th ><span id="label7"><?php echo getSalesCatName($scatget_res['cat_id']); ?>- QTY </span></th>
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
                                                                                <th ><span id="label12"><?php echo getSalesCatName($scatget_res['cat_id']); ?>- VALUE</span></th>
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
                                                                        <th ><span id="label28">Current Outstanding</span></th>
                                                                        <td><span><?php echo $roll_curr_outstanding; ?></span></td>
                                                                        <th colspan="2" ><span id="Label30">SOR / EXTENDED QTY</span></th>
                                                                        <td><span><?php echo $roll_consgnmt_qty; ?></span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th ><span id="label29">Over Due Outstanding If any</span></th>
                                                                        <td><span><?php echo $roll_overdue_outstanding; ?></span></td>
                                                                        <th colspan="2" ><span id="Label31">SOR / EXTENDED VALUE</span></th>
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
                                                                        <td ><span><?php echo $roll_Last_Visit_DoneBy; ?></span></td>
                                                                        <th><span id="Label36">Last Visit Date</span></th>
                                                                        <td ><span><?php echo $roll_Last_Visit_Date; ?></span></td>


                                                                    </tr>
                                                                    <tr>
                                                                        <th colspan="5"><label>MOM / Remarks</label></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="5">
                                                                            <textarea name="apt_details" class="form-control" id="apt_details" ></textarea>                                                                            

                                                                        </td>

                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                            <?php /*
                                                              <div class="row mt-4 sscustcat">

                                                              <?php
                                                              $salesCatArr = [];
                                                              $salesCatCheckSql = "SELECT cat_id FROM rollco_user_to_category_tag WHERE u_id = '" . $user_id . "' ";
                                                              $salescat_num = $sq->numsrow($salesCatCheckSql);
                                                              if ($salescat_num > 0) {
                                                              $salescat_data = $sq->query($salesCatCheckSql);
                                                              while ($salescat_res = $sq->fetch($salescat_data)) {
                                                              array_push($salesCatArr, $salescat_res['cat_id']);
                                                              }
                                                              }
                                                              //                                                                            debug($salesCatArr);
                                                              $salesSql = "SELECT sc_id,scat_nm FROM rollco_ms_salescat WHERE scat_status='1' AND view_flag = 1 ";
                                                              $sales_num = $sq->numsrow($salesSql);
                                                              if ($sales_num > 0) {
                                                              $sales_data = $sq->query($salesSql);
                                                              while ($sales_res = $sq->fetch($sales_data)) {
                                                              //                                                                                     echo in_array($sales_res['sc_id'], $salesCatArr) ;
                                                              ?>
                                                              <div class="col mb-3 align-self-center mt-4">
                                                              <div class="custom-control custom-checkbox col">
                                                              <input type="checkbox" name="custCat[]" class="custom-control-input all_flag" id="flag_<?php echo $sales_res['sc_id']; ?>" value="<?php echo $sales_res['sc_id']; ?>" <?php
                                                              if (in_array($sales_res['sc_id'], $salesCatArr)) {
                                                              echo 'checked';
                                                              }
                                                              ?>>
                                                              <label class="custom-control-label" for="flag_<?php echo $sales_res['sc_id']; ?>"><?php echo $sales_res['scat_nm']; ?></label>
                                                              </div>
                                                              </div>
                                                              <?php
                                                              }
                                                              }
                                                              ?>
                                                              <div class="col pr-0 mb-3 align-self-center mt-4 ">
                                                              <div class="custom-control custom-checkbox pr-0">
                                                              <input type="checkbox" name="flag_other" class="custom-control-input" id="flag_other" value="1">
                                                              <label class="custom-control-label" for="flag_other">Other</label>

                                                              </div>
                                                              </div>

                                                              <div class="col pl-0 mb-3 align-self-center mt-4 ">
                                                              <div class="custom-control custom-checkbox pl-0 valuText">


                                                              <input type="text" name="other_text" id="othertext" autocomplete="off" disabled>
                                                              </div>
                                                              </div>



                                                              </div> */
                                                            ?>
                                                            <input type="submit" class="btn chng w-100 chanAddres" name="submit" value="Submit">
                                                            <input type="button" class="btn chng w-100 chanAddres viewOldLogs" name="View Old Logs" value="View Old Logs">

                                                        </div>
                                                        <input type="hidden" name="changeApt" value="1">
                                                        <input type="hidden" name="user_id" id="user_id_apt" value="<?php echo $user_id; ?>">
                                                        <input type="hidden" name="ss_id" value="<?php if (isset($ss_id)) echo $ss_id; ?>">
                                                    </form>
                                                </div>
                                            <?php } else {
                                                ?>
                                                <div class="row "> 
                                                    <form method="post" id="apt_details" class="w-100">
                                                        <div class="table-responsive col-12">
                                                            <table class="table">
                                                                <tbody>

                                                                    <tr>
                                                                        <th colspan="5"><label>MOM / Remarks</label></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="5">
                                                                            <textarea name="apt_details" class="form-control" id="apt_details" ></textarea>                                                                            

                                                                        </td>

                                                                    </tr>

                                                                </tbody>
                                                            </table>
        <?php if ($user_id > 0) { ?>
                                                                <div class="row mt-4 sscustcat">

                                                                    <?php
                                                                    $salesCatArr = [];
                                                                    $salesCatCheckSql = "SELECT cat_id FROM rollco_user_to_category_tag WHERE u_id = '" . $user_id . "' ";
                                                                    $salescat_num = $sq->numsrow($salesCatCheckSql);
                                                                    if ($salescat_num > 0) {
                                                                        $salescat_data = $sq->query($salesCatCheckSql);
                                                                        while ($salescat_res = $sq->fetch($salescat_data)) {
                                                                            array_push($salesCatArr, $salescat_res['cat_id']);
                                                                        }
                                                                    }
//                                                                            debug($salesCatArr);
                                                                    $salesSql = "SELECT sc_id,scat_nm FROM rollco_ms_salescat WHERE scat_status='1' AND view_flag = 1 ";
                                                                    $sales_num = $sq->numsrow($salesSql);
                                                                    if ($sales_num > 0) {
                                                                        $sales_data = $sq->query($salesSql);
                                                                        while ($sales_res = $sq->fetch($sales_data)) {
//                                                                                     echo in_array($sales_res['sc_id'], $salesCatArr) ;
                                                                            ?>
                                                                            <div class="col mb-3 align-self-center mt-4">
                                                                                <div class="custom-control custom-checkbox col">
                                                                                    <input type="checkbox" name="custCat[]" class="custom-control-input all_flag" id="flag_<?php echo $sales_res['sc_id']; ?>" value="<?php echo $sales_res['sc_id']; ?>" <?php
                                                                                    if (in_array($sales_res['sc_id'], $salesCatArr)) {
                                                                                        echo 'checked';
                                                                                    }
                                                                                    ?>>
                                                                                    <label class="custom-control-label" for="flag_<?php echo $sales_res['sc_id']; ?>"><?php echo $sales_res['scat_nm']; ?></label>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>   
                                                                    <div class="col pr-0 mb-3 align-self-center mt-4 ">
                                                                        <div class="custom-control custom-checkbox pr-0">
                                                                            <input type="checkbox" name="flag_other" class="custom-control-input" id="flag_other" value="1">
                                                                            <label class="custom-control-label" for="flag_other">Other</label>

                                                                        </div>
                                                                    </div>

                                                                    <div class="col pl-0 mb-3 align-self-center mt-4 ">
                                                                        <div class="custom-control custom-checkbox pl-0 valuText">


                                                                            <input type="text" name="other_text" id="othertext" autocomplete="off" disabled>
                                                                        </div>
                                                                    </div>



                                                                </div>
        <?php } ?>                                                                
                                                            <input type="submit" class="btn chng w-100 chanAddres" name="submit" value="Submit">
                                                            <input type="button" class="btn chng w-100 chanAddres viewOldLogs" name="View Old Logs" value="View Old Logs">

                                                        </div>
                                                        <input type="hidden" name="changeApt" value="1">
                                                        <input type="hidden" name="user_id" id="user_id_apt" value="<?php echo $user_id; ?>">
                                                        <input type="hidden" name="temp_user_id" id="temp_user_id" value="<?php echo $tempuser_id; ?>">
                                                        <input type="hidden" name="ss_id" value="<?php if (isset($ss_id)) echo $ss_id; ?>">
                                                    </form>
                                                </div>

                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>

<!--<password>-->
<?php if (isset($userdata['report_access']) && $userdata['report_access'] == 1) { ?>
                                    <div class="tab-pane container fade" id="salesreport">
                                        <form method="post" id="salesreport_form" >
                                            <?php
                                            $user_name = '';
                                            $suser_name = '';
                                            $r_status = '';
                                            $from_date = '';
                                            $to_date = '';

                                            if (isset($_POST['user_name']) && $_POST['user_name'] != '') {
                                                $user_name = $_POST['user_name'];
                                            }
                                            if (isset($_GET['user_name']) && $_GET['user_name'] != '') {
                                                $user_name = $_GET['user_name'];
                                            }
                                            if (isset($_POST['sales_name']) && $_POST['sales_name'] != '') {
                                                $suser_name = $_POST['sales_name'];
                                            }
                                            if (isset($_GET['sales_name']) && $_GET['sales_name'] != '') {
                                                $suser_name = $_GET['sales_name'];
                                            }
                                            if (isset($_POST['r_status']) && $_POST['r_status'] != '') {
                                                $r_status = $_POST['r_status'];
                                            }
                                            if (isset($_GET['r_status']) && $_GET['r_status'] != '') {
                                                $r_status = $_GET['r_status'];
                                            }
                                            if (isset($_POST['search_from_date']) && $_POST['search_from_date'] != '') {
                                                $from_date = $_POST['search_from_date'];
                                            }
                                            if (isset($_GET['search_from_date']) && $_GET['search_from_date'] != '') {
                                                $from_date = $_GET['search_from_date'];
                                            }
                                            if (isset($_POST['search_to_date']) && $_POST['search_to_date'] != '') {
                                                $to_date = $_POST['search_to_date'];
                                            }
                                            if (isset($_GET['search_to_date']) && $_GET['search_to_date'] != '') {
                                                $to_date = $_GET['search_to_date'];
                                            }
                                            ?>
                                            <div class="row search_by justify-content-between    ">
                                                <div class="form-group col-lg-6">
                                                    <label>Select Company</label>
                                                    <select class="form-control" name="user_name" id="user_name">
                                                        <option value="">Select Company</option>
                                                        <?php
                                                        $usql = "select u_id,firstName,lastName,companyName,com_zipCode from rollco_ms_users where cust_type = 1 and (user_status = 2 || user_status = 4) and companyName !='' and cal_show=1  order by companyName asc";
                                                        $udata = $sq->query($usql);
                                                        while ($ures = $sq->fetch($udata)) {
                                                            $optionname = trim($ures['companyName']);
                                                            if ($ures['com_zipCode'] != '')
                                                                $optionname .= '(' . $ures['com_zipCode'] . ')';
                                                            ?>
                                                            <option value="<?php echo $ures['u_id'] ?>" <?php
                                                            if ($user_name != '') {
                                                                if ($user_name == $ures['u_id']) {
                                                                    echo "selected";
                                                                }
                                                            }
                                                            ?>><?php echo $optionname ?></option>
                                                                    <?php
                                                                }
                                                                ?>                                                    
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <label>Select Sales</label>
                                                    <select class="form-control" name="sales_name" id="sales_name">
                                                        <option value="">Select Sales Person</option>
                                                        <?php
                                                        $usql = "select u_id,firstName,lastName,com_zipCode from rollco_ms_users where cust_type = 3 and user_status = 2 and firstName !=''  order by firstName asc ";
                                                        $udata = $sq->query($usql);
                                                        while ($ures = $sq->fetch($udata)) {
                                                            $optionname = trim($ures['firstName'] . ' ' . $ures['lastName']);
                                                            if ($ures['com_zipCode'] != '')
                                                                $optionname .= '(' . $ures['com_zipCode'] . ')';
                                                            ?>
                                                            <option value="<?php echo $ures['u_id'] ?>" <?php
                                                            if ($suser_name != '') {
                                                                if ($suser_name == $ures['u_id']) {
                                                                    echo "selected";
                                                                }
                                                            }
                                                            ?>><?php echo $optionname ?></option>
                                                                    <?php
                                                                }
                                                                ?>                                                    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row search_by justify-content-between    ">
                                                <div class="form-group col-lg-6">
                                                    <label>Report Status</label>
                                                    <select class="form-control" name="r_status" id="r_status">
                                                        <option value="">All</option>
                                                        <option value="1"  <?php
                                                        if ($r_status != '') {
                                                            if ($r_status == 1) {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?>>Open</option>
                                                        <option value="2" <?php
                                                        if ($r_status != '') {
                                                            if ($r_status == 2) {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?>>Closed</option>

                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-2">
                                                    <label>From Date</label>
                                                    <input autocomplete="off" type="text" placeholder="From Date" id="search_from_date" class="form-control " name="search_from_date" value="<?php echo $from_date; ?>" />
                                                </div>
                                                <div class="form-group col-lg-2">
                                                    <label>To Date</label>
                                                    <input autocomplete="off" type="text" placeholder="To Date" id="search_to_date" class="form-control " name="search_to_date" value="<?php echo $to_date; ?>" />
                                                </div>


                                                <div class="form-group col-lg-2">
                                                    <label>&nbsp;</label>
                                                    <input class="btn-sm btn-success saveButton" type="submit" name="search_submit" id="search_submit" value="Search" />
                                                </div>


                                            </div>
                                        </form>
                                        <div class="sucess-msg successappointment text-center pb-4 font-weight-bold"></div>
                                        <div class="partner-style" id="show_partner">
                                            <div class="row viewAppointment ">
                                                <div class="col-lg-12">
                                                    <table class="border">
                                                        <tbody><tr >
                                                                <th  >Appointment Date</th>
                                                                <th  >Ac Name</th>  
                                                                <th  >Start Time</th>
                                                                <th  >End Time</th>
                                                                <th  >Remarks</th>
                                                                <th  >Status</th>
                                                                <th  >Sales Person Name</th>
                                                                <th >Log Details</th>
                                                            </tr>

                                                            <?php
                                                            if (isset($_GET['pageno'])) {
                                                                $pageno = $_GET['pageno'];
                                                            } else {
                                                                $pageno = 1;
                                                            }
                                                            $no_of_records_per_page = 10;
                                                            $offset = ($pageno - 1) * $no_of_records_per_page;
                                                            $applist_sql = "select * from rollco_salescal where sc_id > 0  AND full_name !='' ";
                                                            $applist_num = $sq->numsrow($applist_sql);
                                                            if ($user_name != '') {
                                                                $applist_sql .= " AND u_id='" . $user_name . "'";
                                                            }
                                                            if ($suser_name != '') {
                                                                $applist_sql .= " AND sec_id='" . $suser_name . "'";
                                                            }
                                                            if ($r_status != '') {
                                                                $applist_sql .= " AND sc_status='" . $r_status . "'";
                                                            }

                                                            if (($from_date != "") && ($to_date != "")) {
                                                                $applist_sql .= " and date(sc_date) between  '" . $from_date . "' and '" . $to_date . "'";
                                                            }

                                                            $applist_sql .= " order by sc_date desc";
                                                            $applist_sql .= " LIMIT $offset, $no_of_records_per_page";
//$applist_num=0;
                                                            $applist_num = $sq->numsrow($applist_sql);
                                                            if ($applist_num > 0) {
                                                                $applist_data = $sq->query($applist_sql);
                                                                while ($applist_res = $sq->fetch($applist_data)) {
//$applist_res['sc_status']=2;
                                                                    ?>
                                                                    <tr id="rm_<?php echo $applist_res['sc_id'] ?>">
                                                                        <td><?php if (isset($applist_res['sc_date']) && $applist_res['sc_date'] != '') echo date('d-m-Y', strtotime($applist_res['sc_date'])); ?></td>

                                                                        <td><?php
                                                                            if (isset($applist_res['full_name']))
                                                                                echo $applist_res['full_name'];
                                                                            if (isset($applist_res['post_code']) && $applist_res['post_code'] != '')
                                                                                echo '(' . $applist_res['post_code'] . ')';
                                                                            ?></td>


                                                                        <td ><?php if (isset($applist_res['sc_stime']) && $applist_res['sc_stime'] != '') echo date('h:i A', strtotime(date('y-m-d') . ' ' . $applist_res['sc_stime'])); ?></td>
                                                                        <td ><?php if (isset($applist_res['sc_etime']) && $applist_res['sc_etime'] != '') echo date('h:i A', strtotime(date('y-m-d') . ' ' . $applist_res['sc_etime'])); ?></td>
                                                                        <td ><?php if (isset($applist_res['sc_remarks'])) echo stripslashes($applist_res['sc_remarks']); ?></td>
                                                                        <td ><?php
                                                                            if ($applist_res['sc_status'] == 1) {
                                                                                echo "open";
                                                                            } else {
                                                                                echo "Closed";
                                                                            }
                                                                            ?></td>
                                                                        <td ><?php
                                                                            if (isset($applist_res['sec_id'])) {
                                                                                $userdetails = getUserName($applist_res['sec_id']);
                                                                                echo $userdetails['firstName'] . ' ' . $userdetails['lastName'];
                                                                            }
                                                                            ?></td>
                                                                        <td >
                                                                            <?php $check = getActCodeUser($applist_res['u_id'], $applist_res['temp_id']); ?>
                                                                            <?php if ($check) { ?>
                                                                                <input type="button" class="btn chng w-100 chanAddres viewOldLogs1" name="View Log Details" value="View Log Details" data-id="<?php echo $applist_res['u_id']; ?>" data-temp="<?php echo $applist_res['temp_id']; ?>">
                                                                            <?php } else { ?>
                                                                                <input type="button" class="btn chng w-100 chanAddres" name="N/A" value="N/A">
                                                                            <?php } ?>
                                                                        </td>


                                                                    </tr>
                                                                    <?php
//$applist_res['sc_id']
                                                                }
                                                            } else {
                                                                ?>
                                                                <tr>
                                                                    <td colspan="11" class="text-center">Report not found.</td>
                                                                </tr>
                                                                <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <?php
                                                    if ($applist_num > 0) {
                                                        $sql = "SELECT COUNT(u_id) FROM rollco_salescal where sc_id > 0 AND full_name !=''   ";
                                                        if ($user_name != '') {
                                                            $sql .= " AND u_id='" . $user_name . "'";
                                                        }
                                                        if ($suser_name != '') {
                                                            $sql .= " AND sec_id='" . $suser_name . "'";
                                                        }
                                                        if ($r_status != '') {
                                                            $sql .= " AND sc_status='" . $r_status . "'";
                                                        }

                                                        if (($from_date != "") && ($to_date != "")) {
                                                            $sql .= " and date(sc_date) between  '" . $from_date . "' and '" . $to_date . "'";
                                                        }

                                                        $sql .= " order by sc_date  asc  ";
                                                        //echo $sql;
                                                        $rs_result = $sq->query($sql);
                                                        $row = $sq->ferow($sql);
                                                        //$row = mysql_fetch_row($rs_result);
                                                        $total_rows = $row[0];
                                                        $total_pages = ceil($total_rows / $no_of_records_per_page);
                                                        $next_page = $pageno + 1;
                                                        $previous_page = $pageno - 1;
                                                        $second_last = $total_pages - 1;
                                                        ?>
                                                        <?php /* ?><div class="row pb-5">
                                                          <div class="col-lg-2">
                                                          <a class="btn-sm btn-success saveButton pb-3 text-center" href="<?php echo $siteurl; ?>inc/export_report.php?user_name=<?php echo $user_name ?>&sales_name=<?php echo $suser_name ?>&r_status=<?php echo $r_status ?>&search_from_date=<?php echo $from_date ?>&search_to_date=<?php echo $to_date ?>'">EXPORT</a>
                                                          </div>
                                                          </div><?php */ ?>
                                                        <div class="row pb-5 pt-3">
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
                                                                                echo "href='?pageno=$previous_page&user_name=$user_name&sales_name=$suser_name&r_status=$r_status&search_from_date=$from_date&search_to_date=$to_date'";
                                                                            }
                                                                            ?>>Previous</a>
                                                                        </li>

                                                                        <?php
                                                                        if ($total_pages <= 10) {
                                                                            for ($counter = 1; $counter <= $total_pages; $counter++) {
                                                                                if ($counter == $pageno) {
                                                                                    echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                                                                } else {
                                                                                    echo "<li  class='page-item'><a class='page-link' href='?pageno=$counter&user_name=$user_name&sales_name=$suser_name&r_status=$r_status&search_from_date=$from_date&search_to_date=$to_date'>$counter</a></li>";
                                                                                }
                                                                            }
                                                                        } elseif ($total_pages > 10) {

                                                                            if ($pageno <= 4) {
                                                                                for ($counter = 1; $counter < 8; $counter++) {
                                                                                    if ($counter == $pageno) {
                                                                                        echo "<li class=' page-item active'><a class='page-link'>$counter</a></li>";
                                                                                    } else {
                                                                                        echo "<li class='active'><a class='page-link' href='?pageno=$counter&user_name=$user_name&sales_name=$suser_name&r_status=$r_status&search_from_date=$from_date&search_to_date=$to_date'>$counter</a></li>";
                                                                                    }
                                                                                }
                                                                                echo "<li class=' page-item '><a class='page-link'>...</a></li>";
                                                                                echo "<li class=' page-item '><a class='page-link' href='?pageno=$second_last&user_name=$user_name&sales_name=$suser_name&r_status=$r_status&search_from_date=$from_date&search_to_date=$to_date'>$second_last</a></li>";
                                                                                echo "<li class=' page-item '><a class='page-link' href='?pageno=$total_pages&user_name=$user_name&sales_name=$suser_name&r_status=$r_status&search_from_date=$from_date&search_to_date=$to_date'>$total_pages</a></li>";
                                                                            } elseif ($pageno > 4 && $pageno < $total_pages - 4) {
                                                                                echo "<li class=' page-item '><a class='page-link' href='?pageno=1&user_name=$user_name&sales_name=$suser_name&r_status=$r_status&search_from_date=$from_date&search_to_date=$to_date'>1</a></li>";
                                                                                echo "<li class=' page-item '><a class='page-link' href='?pageno=2&user_name=$user_name&sales_name=$suser_name&r_status=$r_status&search_from_date=$from_date&search_to_date=$to_date'>2</a></li>";
                                                                                echo "<li class=' page-item '><a class='page-link'>...</a></li>";
                                                                                for ($counter = $pageno - $adjacents; $counter <= $pageno + $adjacents; $counter++) {
                                                                                    if ($counter == $pageno) {
                                                                                        echo "<li class=' page-item active'><a class='page-link'>$counter</a></li>";
                                                                                    } else {
                                                                                        echo "<li class=' page-item '><a class='page-link' href='?pageno=$counter&user_name=$user_name&sales_name=$suser_name&r_status=$r_status&search_from_date=$from_date&search_to_date=$to_date'>$counter</a></li>";
                                                                                    }
                                                                                }
                                                                                echo "<li  class=' page-item '><a class='page-link'>...</a></li>";
                                                                                echo "<li  class=' page-item '><a class='page-link' href='?pageno=$second_last&user_name=$user_name&sales_name=$suser_name&r_status=$r_status&search_from_date=$from_date&search_to_date=$to_date'>$second_last</a></li>";
                                                                                echo "<li  class=' page-item '><a class='page-link' href='?pageno=$total_pages&user_name=$user_name&sales_name=$suser_name&r_status=$r_status&search_from_date=$from_date&search_to_date=$to_date'>$total_pages</a></li>";
                                                                            } else {
                                                                                echo "<li  class=' page-item '><a class='page-link' href='?pageno=1&user_name=$user_name&sales_name=$suser_name&r_status=$r_status&search_from_date=$from_date&search_to_date=$to_date'>1</a></li>";
                                                                                echo "<li  class=' page-item '><a class='page-link' href='?pageno=2&user_name=$user_name&sales_name=$suser_name&r_status=$r_status&search_from_date=$from_date&search_to_date=$to_date'>2</a></li>";
                                                                                echo "<li  class=' page-item '><a class='page-link'>...</a></li>";

                                                                                for ($counter = $total_pages - 6; $counter <= $total_pages; $counter++) {
                                                                                    if ($counter == $pageno) {
                                                                                        echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                                                                    } else {
                                                                                        echo "<li class='page-item active'><a class='page-link' href='?pageno=$counter&user_name=$user_name&sales_name=$suser_name&r_status=$r_status&search_from_date=$from_date&search_to_date=$to_date'>$counter</a></li>";
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
                                                                                echo "href='?pageno=$next_page&user_name=$user_name&sales_name=$suser_name&r_status=$r_status&search_from_date=$from_date&search_to_date=$to_date'";
                                                                            }
                                                                            ?>>Next</a>
                                                                        </li>
                                                                        <?php
                                                                        if ($pageno < $total_pages) {
                                                                            echo "<li class='page-item '><a class='page-link' href='?pageno=$total_pages&user_name=$user_name&sales_name=$suser_name&r_status=$r_status&search_from_date=$from_date&search_to_date=$to_date'>Last &rsaquo;&rsaquo;</a></li>";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </section>
        <div class="modal" id="myModal">
            <div class="modal-dialog  modal-dialog-scrollable modal-lg">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title config-title text-center w-100">Appointment Details</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <table  class="table table-striped ">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" width='45%'>Appointment Details</th>
                                    <th class="column-title"> Visit Done By</th>
                                    <th class="column-title">Created Date</th>
                                </tr>
                            </thead>
                            <tbody class="populateLogs">



                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal" id="rofdel">
            <div class="modal-dialog  modal-dialog-scrollable modal-sm">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title config-title text-center w-100">Delete Appointment</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <input type="hidden" id="del_id">
                        <div class="row">
                            <div class="col-12 mb-2"><label>Please enter reason to delete this appointment</label></div>
                            <div class="col-12">
                                <textarea id="rofdeltext" class="form-control"></textarea>
                            </div>
                            <div class="col-5 mt-4 align-self-end">
                                <button type="button" class="btn btn-danger" id="deleteAppointment">Submit & Delete</button>
                            </div>
                        </div>



                    </div>

                </div>
            </div>
        </div>
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
                                                                            var activeTab = '';
                                                                            $(document).on('click', '.save-tag-calendar', function () {
                                                                                activeTab = '#newcalendar';
                                                                                localStorage.setItem('activeTab', '#newcalendar');
                                                                                location.reload();
                                                                            });
                                                                            $(document).on('click', '.save-tag-appointment', function () {
                                                                                activeTab = '#appointments';
                                                                                localStorage.setItem('activeTab', '#appointments');
                                                                                location.reload();
                                                                            });
                                                                            $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
                                                                                localStorage.setItem('activeTab', $(e.target).attr('href'));
                                                                            });


                                                                            activeTab = localStorage.getItem('activeTab');

                                                                            if (activeTab) {
                                                                                $('#myTab a[href="' + activeTab + '"]').tab('show');
                                                                            }
                                                                        });
    <?php
}
?>


                                                                    $(document).ready(function () {
                                                                        var today = new Date();

                                                                        var dd = today.getDate();
                                                                        var mm = today.getMonth() + 1; //January is 0! 
                                                                        var yyyy = today.getFullYear();
                                                                        if (dd < 10) {
                                                                            dd = '0' + dd
                                                                        }
                                                                        if (mm < 10) {
                                                                            mm = '0' + mm
                                                                        }

                                                                        today.setMonth(today.getMonth() + 3);

                                                                        var dd1 = today.getDate();
                                                                        var mm1 = today.getMonth() + 1; //January is 0! 
                                                                        var yyyy1 = today.getFullYear();
                                                                        if (dd1 < 10) {
                                                                            dd1 = '0' + dd1
                                                                        }
                                                                        if (mm1 < 10) {
                                                                            mm1 = '0' + mm1
                                                                        }

                                                                        var today1 = yyyy + '-' + mm + '-' + dd;

                                                                        var today2 = yyyy1 + '-' + mm1 + '-' + dd1;
                                                                        $('#app_date').daterangepicker({
                                                                            autoUpdateInput: true,
                                                                            singleDatePicker: true,
                                                                            singleClasses: "picker_1",
                                                                            minDate: today1,
                                                                            maxDate: today2,
                                                                            locale: {
                                                                                format: "YYYY-MM-DD",
                                                                            }
                                                                        });
                                                                        $('#app_date').on('apply.daterangepicker', function (ev, picker) {
                                                                            $(this).val(picker.startDate.format('YYYY-MM-DD'));
                                                                        });
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
                                                                        });
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
                        $('#del_id').val(del_id);
                        $('#rofdel').modal('show');

                        return false;
                    }
                }
            }

            $(document).on('click', '#deleteAppointment', function () {
                var del_id = $('#del_id').val();
                if ($('#rofdeltext').val() === '') {
                    alert('Please enter reason of deleting');
                    $('#rofdeltext').focus();
                    return false;
                }
                var data = {"sc_id": del_id, "sec_id":<?php echo $_SESSION['u_id'] ?>, "del_res": $('#rofdeltext').val()};
                $.ajax({
                    type: 'post',
                    url: "<?php echo $siteurl; ?>ajax/del_appointment.php",
                    data: data,
                    success: function (data) {
                        $('.loading').hide();
                        var html = '';
                        var data = JSON.parse(data);
                        if (data.status == 1) {
                            $('#rofdel').modal('hide');
                            $('.successappointment').addClass('text-success').show().html('<p>' + data.data + '</p>');

                            $('.successappointment').delay(5000).fadeOut('slow');
                            $("#rm_" + del_id).remove();
                        } else {
                            $('.successappointment').addClass('text-danger').show().html(data.data);
                        }
                    }
                });
            });
            function close_appointment(sc_id, u_id, temp_id) {
                /*if (u_id === '0') {
                 
                 $('.successappointment').addClass('text-danger').show();
                 $('.successappointment').html('You can not close appointment of temp user.');
                 $("html, body").animate({scrollTop: 300}, "slow");
                 $('.successappointment').delay(5000).fadeOut('slow');
                 return false;
                 }*/
                checkLogs(sc_id, u_id, temp_id);

            }

            function checkLogs(sc_id, u_id, temp_id) {
                var data = {"sc_id": sc_id, 'user_id': u_id, 'temp_id': temp_id};
                console.log(data);
                $.ajax({
                    type: 'post',
                    url: "<?php echo $siteurl; ?>ajax/checkAptLogs.php",
                    data: data,
                    success: function (data) {
                        $('.loading').hide();
                        var html = '';
                        var data = JSON.parse(data);
                        if (data.status == 1) {
                            if (confirm('Are you sure want to close the Appointment?')) {
                                if (sc_id > 0) {
                                    var data = {"sc_id": sc_id, "sec_id":<?php echo $_SESSION['u_id'] ?>};
                                    $.ajax({
                                        type: 'post',
                                        url: "<?php echo $siteurl; ?>ajax/close_appointment.php",
                                        data: data,
                                        success: function (data) {
                                            $('.loading').hide();
                                            var html = '';
                                            var data = JSON.parse(data);
                                            if (data.status == 1) {
                                                $('.successappointment').addClass('text-success').show().html('<p>' + data.data + '</p>');
                                                $('.successappointment').delay(5000).fadeOut('slow');
                                                $("#rm_" + sc_id).remove();
                                            } else {
                                                $('.successappointment').addClass('text-danger').show().html(data.data);
                                            }
                                        }
                                    });
                                    return false;
                                }
                            }
                        } else {
                            $('.successappointment').addClass('text-danger').show().html(data.data);
                            $("html, body").animate({scrollTop: 300}, "slow");
                            $('.successappointment').delay(5000).fadeOut('slow');
                            return false;
                        }
                    }
                });
            }


            $(document).ready(function () {
                $('#flag_other').change(function () {
                    if ($('#flag_other').is(':checked')) {
                        $('#othertext').prop('disabled', false);
                        $('#othertext').focus();
                    } else {
                        $('#othertext').prop('disabled', true);
                    }
                });
                $("#AC_Name").change(function () {
                    //alert($(this).val()) ;
                    if ($(this).val() === 'new') {
                        $("#AC_Name").hide();
                        $('.backbtn').show();
                        $("#AC_Name_new").show().attr("readonly", false).val('');
                        $("#Post_Code").attr("readonly", false).val('');
                        $("#county").attr("readonly", false).val('');
                    } else if ($(this).val() > 0) {
                        var data = {"AC_Name": $(this).val()};
                        $.ajax({
                            type: 'post',
                            url: "<?php echo $siteurl; ?>ajax/getAC_Name.php",
                            data: data,
                            success: function (data) {
                                $('.loading').hide();
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
                        $("#Post_Code").attr("readonly", false).val('');
                        $("#county").attr("readonly", false).val('');
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




            $(function () {
                $('#calendar_form').on('submit', function () {
                    if ($("#calendar_form").valid()) {
//                        e.preventDefault();
                        var calSub = 1;
                        //AC_Name_new-error
                        //alert($("#AC_Name").val());
                        if ($("#AC_Name").val() == 'new') {
                            if ($("#AC_Name_new").val() == '') {
                                $("#AC_Name_new-error").html('This field is required.').show();
                                calSub = 2;
                            } else {
                                $("#AC_Name_new-error").hide();
                                calSub = 1;
                            }
                            if ($("#Post_Code").val() == '') {
                                $("#Post_Code-error").html('This field is required.').show();
                                calSub = 2;
                            } else {
                                $("#Post_Code-error").hide();
                                calSub = 1;
                            }
                            if ($("#county").val() == '') {
                                $("#county-error").html('This field is required.').show();
                                calSub = 2;
                            } else {
                                $("#county-error").hide();
                                calSub = 1;
                            }
                        }
                        if (calSub == '2')
                        {
                            return false;
                        }

                        $('.successcalendar').html();
                        $.ajax({
                            type: 'post',
                            url: "<?php echo $siteurl; ?>ajax/calendar_form.php",
                            data: $('#calendar_form').serialize(),
                            success: function (data) {
                                $('.loading').hide();
                                var html = '';
                                var data = JSON.parse(data);
                                if (data.status == 1) {
                                    $('.successcalendar').addClass('text-success').show().html(data.data);
//                                    $('.successcalendar').delay(5000).fadeOut('slow');
                                    $('#calendar_form').hide();
                                    localStorage.setItem('activeTab', '#appointments');
                                    location.reload();
                                } else if (data.status == 4) {
                                    $("#AC_Name_new").hide().val('');
                                    $("#AC_Name").show();
                                    $('.successcalendar').addClass('text-danger').show().html(data.data);
                                    $('.successcalendar').delay(5000).fadeOut('slow');
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
                $('#apt_details').on('submit', function (e) {
                    if ($("#apt_details").valid()) {
                        e.preventDefault();
                        $('.successappointment').html();
                        $.ajax({
                            type: 'post',
                            url: "<?php echo $siteurl; ?>ajax/save_appointmentdetails.php",
                            data: $('#apt_details').serialize(),
                            success: function (data) {
                                $('.loading').hide();
                                var html = '';
                                var data = JSON.parse(data);
                                if (data.status == 1) {
                                    $('.successappointment').addClass('text-success').show().html('<p>' + data.data + '</p>');
                                    $("html, body").animate({scrollTop: 300}, "slow");
                                    $('.successappointment').delay(5000).fadeOut('slow');
                                    setTimeout(function () {
                                        location.reload();
                                    }, 3000);
                                } else {
                                    $('.successappointment').addClass('text-danger').show().html(data.data);
                                    $("html, body").animate({scrollTop: 300}, "slow");
                                    $('.successappointment').delay(5000).fadeOut('slow');
                                    return false;
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
                            url: "<?php echo $siteurl; ?>ajax/calendar_editform.php",
                            data: $('#calendar_editform').serialize(),
                            success: function (data) {
                                $('.loading').hide();
                                var html = '';
                                var data = JSON.parse(data);
                                if (data.status == 1) {
                                    $('.successcalendar').addClass('text-success').show().html('<p>' + data.data + '</p>');
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

                $('.viewOldLogs').click(function () {
                    $.ajax({
                        type: 'post',
                        url: "<?php echo $siteurl; ?>ajax/getSalesSheetAptDetails.php",
                        data: {'user_id': $('#user_id_apt').val(), 'temp_user_id': $('#temp_user_id').val()},
                        success: function (data) {
                            $('.loading').hide();
                            var html = '';
                            var data = JSON.parse(data);
                            if (data.status == 1) {
                                $('.populateLogs').html(data.data);
                                $('#myModal').modal('show');
                            } else {
                                $('.successappointment').addClass('text-danger').show().html(data.data);
                                $("html, body").animate({scrollTop: 300}, "slow");
                                $('.successappointment').delay(5000).fadeOut('slow');
                                return false;
                            }
                        }
                    });
                });

                $('.viewOldLogs1').click(function () {
                    $.ajax({
                        type: 'post',
                        url: "<?php echo $siteurl; ?>ajax/getSalesSheetAptDetails.php",
                        data: {'user_id': $(this).data('id'), 'temp_user_id': $(this).data('temp')},
                        success: function (data) {
                            $('.loading').hide();
                            var html = '';
                            var data = JSON.parse(data);
                            if (data.status == 1) {
                                $('.populateLogs').html(data.data);
                                $('#myModal').modal('show');
                            } else {
                                $('.successappointment').addClass('text-danger').show().html(data.data);
                                $("html, body").animate({scrollTop: 300}, "slow");
                                return false;
                            }
                        }
                    });
                });
            });









        </script>
    </body>
</html>

<?php
//if (isset($_SESSION['new_apt']) && $_SESSION['new_apt'] == 1) {
//    unset($_SESSION['new_apt']);
//}
?>
