<?php
include("class/config.php");
$_SESSION['mstart'] = time();
if (isset($_FILES['file'])) {          //If Condition start here
    $handle = fopen($_FILES['file']['tmp_name'], "r");
    $mycount = 0;
    $count = 0;
    $mycnts = 0;
//$current_date=date('d-m-y');
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { //While loop start here
        if ($mycnts > 0) {
//Swith Case Variable start here
//code start for import Profile Change
//            echo "<pre>";
//            print_r($data);
//            die;
            $ACCOUNTNO = trim($data[0]);
            $BEARINGHUBKITQTY = trim($data[1]);
            $BEARINGHUBKITVALUE = trim($data[2]);
            $CALIPERQTY = trim($data[3]);
            $CALIPERVALUE = trim($data[4]);
            $CVJOINTQTY = trim($data[5]);
            $CVJOINTVALUE = trim($data[6]);
            $DRIVESHAFTQTY = trim($data[7]);
            $DRIVESHAFTVALUE = trim($data[8]);
            $EMSQTY = trim($data[9]);
            $EMSVALUE = trim($data[10]);
            $STEERINGPUMPQTY = trim($data[11]);
            $STEERINGPUMPVALUE = trim($data[12]);
            $SPARESQTY = trim($data[13]);
            $SPARESVALUE = trim($data[14]);
            $ROTATINGQTY = trim($data[15]);
            $ROTATINGVALUE = trim($data[16]);

            $u_id = 0;
            $com_emailAddress = '';
            $com_zipCode = '';

            $u_sql = "select u_id,com_emailAddress,com_zipCode from rollco_ms_users where customerID = '" . $ACCOUNTNO . "' AND  user_status = 2 AND cust_type !=3  LIMIT 1 ";
            $u_res = $sq->fearr($u_sql);
            if (isset($u_res['u_id']) && $u_res['u_id'] > 0) {
                $u_id = $u_res['u_id'];
                $com_emailAddress = $u_res['com_emailAddress'];
                $com_zipCode = $u_res['com_zipCode'];
            }


            if ($u_id > 0) {

                $check_sql = "SELECT AcCode,ss_id FROM rollco_ms_sales_sheet WHERE AcCode='" . $ACCOUNTNO . "' ";
                $check_num = $sq->numsrow($check_sql);
                if ($check_num > 0) {
                    $ssvdata = $sq->fearr($check_sql);
                    $ssv_ss_id = $ssvdata['ss_id'];
                    for ($i = 0; $i < 8; $i++) {

                        if ($i == 0) {
                            $deleteSql = "DELETE FROM rollco_ms_scat_sales_val WHERE ssv_scat_id = 11 AND ssv_scat_year = 2021 and ssv_ss_id = ".$ssv_ss_id;
                            $sq->query($deleteSql);
                            
                            $ss_sql = "INSERT INTO  rollco_ms_scat_sales_val  SET ssv_scat_id= 11  ,ssv_scat_name = 'BEARING HUB & KIT',ssv_scat_year='2021',ssv_scat_value='" . $BEARINGHUBKITVALUE . "',ssv_scat_qty='" . $BEARINGHUBKITQTY . "',ssv_ss_id=" . $ssv_ss_id;
                            $sq->query($ss_sql);
                        }
                        if ($i == 1) {
                             $deleteSql = "DELETE FROM rollco_ms_scat_sales_val WHERE ssv_scat_id = 6 AND ssv_scat_year = 2021 and ssv_ss_id = ".$ssv_ss_id;
                            $sq->query($deleteSql);
                            
                            $ss_sql = "INSERT INTO  rollco_ms_scat_sales_val  SET ssv_scat_id= 6  ,ssv_scat_name = 'CALIPER',ssv_scat_year='2021',ssv_scat_value='" . $CALIPERVALUE . "',ssv_scat_qty='" . $CALIPERQTY . "',ssv_ss_id=" . $ssv_ss_id;
                            $sq->query($ss_sql);
                        }
                        if ($i == 2) {
                             $deleteSql = "DELETE FROM rollco_ms_scat_sales_val WHERE ssv_scat_id = 8 AND ssv_scat_year = 2021 and ssv_ss_id = ".$ssv_ss_id;
                            $sq->query($deleteSql);
                            
                            $ss_sql = "INSERT INTO  rollco_ms_scat_sales_val  SET ssv_scat_id= 8  ,ssv_scat_name = 'CV JOINT',ssv_scat_year='2021',ssv_scat_value='" . $CVJOINTVALUE . "',ssv_scat_qty='" . $CVJOINTQTY . "',ssv_ss_id=" . $ssv_ss_id;
                            $sq->query($ss_sql);
                        }
                        if ($i == 3) {
                             $deleteSql = "DELETE FROM rollco_ms_scat_sales_val WHERE ssv_scat_id = 10 AND ssv_scat_year = 2021 and ssv_ss_id = ".$ssv_ss_id;
                            $sq->query($deleteSql);
                            
                            $ss_sql = "INSERT INTO  rollco_ms_scat_sales_val  SET ssv_scat_id= 10  ,ssv_scat_name = 'DRIVE SHAFT',ssv_scat_year='2021',ssv_scat_value='" . $DRIVESHAFTVALUE . "',ssv_scat_qty='" . $DRIVESHAFTQTY . "',ssv_ss_id=" . $ssv_ss_id;
                            $sq->query($ss_sql);
                        }
                        if ($i == 4) {
                             $deleteSql = "DELETE FROM rollco_ms_scat_sales_val WHERE ssv_scat_id = 5 AND ssv_scat_year = 2021 and ssv_ss_id = ".$ssv_ss_id;
                            $sq->query($deleteSql);
                            
                            $ss_sql = "INSERT INTO  rollco_ms_scat_sales_val  SET ssv_scat_id= 5  ,ssv_scat_name = 'EMS',ssv_scat_year='2021',ssv_scat_value='" . $EMSVALUE . "',ssv_scat_qty='" . $EMSQTY . "',ssv_ss_id=" . $ssv_ss_id;
                            $sq->query($ss_sql);
                        }
                        if ($i == 5) {
                             $deleteSql = "DELETE FROM rollco_ms_scat_sales_val WHERE ssv_scat_id = 9 AND ssv_scat_year = 2021 and ssv_ss_id = ".$ssv_ss_id;
                            $sq->query($deleteSql);
                            
                            $ss_sql = "INSERT INTO  rollco_ms_scat_sales_val  SET ssv_scat_id= 9  ,ssv_scat_name = 'STEERING PUMP',ssv_scat_year='2021',ssv_scat_value='" . $STEERINGPUMPVALUE . "',ssv_scat_qty='" . $STEERINGPUMPQTY . "',ssv_ss_id=" . $ssv_ss_id;
                            $sq->query($ss_sql);
                        }
                        if ($i == 6) {
                             $deleteSql = "DELETE FROM rollco_ms_scat_sales_val WHERE ssv_scat_id = 4 AND ssv_scat_year = 2021 and ssv_ss_id = ".$ssv_ss_id;
                            $sq->query($deleteSql);
                            
                            $ss_sql = "INSERT INTO  rollco_ms_scat_sales_val  SET ssv_scat_id= 4  ,ssv_scat_name = 'SPARES',ssv_scat_year='2021',ssv_scat_value='" . $SPARESVALUE . "',ssv_scat_qty='" . $SPARESQTY . "',ssv_ss_id=" . $ssv_ss_id;
                            $sq->query($ss_sql);
                        }
                        if ($i == 7) {
                             $deleteSql = "DELETE FROM rollco_ms_scat_sales_val WHERE ssv_scat_id = 7 AND ssv_scat_year = 2021 and ssv_ss_id = ".$ssv_ss_id;
                            $sq->query($deleteSql);
                            
                            $ss_sql = "INSERT INTO  rollco_ms_scat_sales_val  SET ssv_scat_id= 7  ,ssv_scat_name = 'ROTATING',ssv_scat_year='2021',ssv_scat_value='" . $ROTATINGVALUE . "',ssv_scat_qty='" . $ROTATINGQTY . "',ssv_ss_id=" . $ssv_ss_id;
                            $sq->query($ss_sql);
                        }
                    }
                } else {

                    $cr_sql = "INSERT INTO  rollco_ms_sales_sheet  SET user_id= '" . $u_id . "'  ,user_email = '" . $com_emailAddress . "',user_postcode='" . $com_zipCode . "',AcCode='" . $ACCOUNTNO . "'";

                    $sq->query($cr_sql);
                    $ssv_ss_id = $sq->insertid();
                }
                $count++;
            }
        }
        $mycnts++;
    }  //While loop end here
//exit;
    echo "<script>location.href='import_sales_sheet_2021.php?mycnts=" . $count . "';</script>";
}   //If Condition end here
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $sitetitle; ?></title>
        <link href="stylesheet.css" rel="stylesheet" type="text/css">
        <SCRIPT language=JavaScript>
            function validate_import()
            {
                if (document.getElementById('file').value == "")
                {
                    alert("Please upload file");
                    document.getElementById('file').focus();
                    return false;
                }
            }
            function close_the_window() {
                self.close();
            }
        </script>
        <link rel="stylesheet" type="text/css" href="stylesheet.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/main.css" media="screen" />
    </head>
    <body>
        <div id="wrapper" style="width: 700px"> 

            <div class="header"> 
                <div class="logo"><a><img src="images/logo.svg" alt="Rollco" /> </a></div> <h1>Rollco</h1> 

                <div class="nav"> 
                </div>
                <!--Header-End--></div>      

            <table width="100%" cellpadding="0" cellspacing="0" align="center">
                <tr> 
                    <td valign="top"><table width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td> 
                                <td> <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" >
                                        <tr> 
                                            <td> <table width="100%%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr> 
                                                        <td height="400" align="left" valign="top"><form action="import_sales_sheet_2021.php" method="post" enctype="multipart/form-data" name="form1" class="text09" onSubmit="return validate_import();">
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td colspan="2" class="txt5" style="padding-bottom: 20px">Import User Sales Sheet 2021</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="txt11"><span>
<?php if (isset($_GET['mycnts'])) { ?>
                                                                                    Total <?php echo $_GET['mycnts']; ?> record(s) has been inserted successfully.
                                                                                    <br /><br /><br />
                                                                                    <a style="color: #000" href="import_sales_sheet_2021.php">Back to Import User Sales Sheet</a>
    <?php
} else
    echo "Please click on 'Browse' button to select and upload csv file.";
?>
                                                                            </span></td>
                                                                    </tr>
<?php
if (isset($_GET['mycnts'])) {
    
} else {
    ?>                            
                                                                        <tr>
                                                                            <td colspan="2">&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2" style="height: 3px"></td>
                                                                        </tr>
                                                                        <tr class="text06">
                                                                            <td width="20%" class="txt5">&nbsp;<span class="txt11">Upload CSV: </span></td>
                                                                            <td width="80%"><input type="file" id="file" name="file"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2">&nbsp;</td>
                                                                        </tr>
                                                                        <tr class="text06">
                                                                            <td>&nbsp;</td>
                                                                            <td>
                                                                                <input name="Submit" type="submit" class="subbtn" value="Upload"></td>
                                                                        </tr>
<?php } ?>                          
                                                                </table>
                                                            </form></td>
                                                    </tr>
                                                </table></td>
                                        </tr>
                                    </table></td>
                            </tr>
                        </table></td>
                </tr>
            </table>
        </div>    
    </body>
</html>