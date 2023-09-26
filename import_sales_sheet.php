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
            $PostCode = trim($data[2]);
            $RotatingTurnoverLastYear = trim($data[3]);
            $RollingSharePer = trim($data[4]);
            $GrossSaleQty = trim($data[5]);
            $Faulty = trim($data[6]);
            $ReturnToStock = trim($data[7]);
            $FaultyPer = trim($data[8]);
            $FaultyCategoryQtyFaulty = trim($data[9]);
            $FaultyCategoryNff = trim($data[10]);
            $FaultyCategoryTransitDamage = trim($data[11]);
            $FaultyCategoryQtyContaminated = trim($data[12]);
            $CurrentOutstanding = trim($data[13]);
            $CongnmentQtySR = trim($data[14]);
            $OverDueOutstandingIfAny = trim($data[15]);
            $CongnmntValueSR = trim($data[16]);
            $LastStockCleanseDate = trim($data[17]);
            $ExtendedSOR = trim($data[18]);
            $LastVisitedBy = trim($data[19]);
            $ActionStatus = trim($data[22]);
            $CreatedBy = trim($data[23]);
            $AcCode = trim($data[27]);


            $u_id = 0;
            $com_emailAddress = '';
            $com_zipCode = '';

            $u_sql = "select u_id,com_emailAddress,com_zipCode from rollco_ms_users where customerID = '" . $AcCode . "' AND  user_status = 2 AND cust_type !=3  LIMIT 1 ";
            $u_res = $sq->fearr($u_sql);
            if (isset($u_res['u_id']) && $u_res['u_id'] > 0) {
                $u_id = $u_res['u_id'];
                $com_emailAddress = $u_res['com_emailAddress'];
                $com_zipCode = $u_res['com_zipCode'];
            }


            if ($u_id > 0) {

                $check_sql = "SELECT AcCode FROM rollco_ms_sales_sheet WHERE AcCode='" . $AcCode . "' ";
                $check_num = $sq->numsrow($check_sql);
                if ($check_num > 0) {
                    $del_sql = "DELETE FROM rollco_ms_sales_sheet WHERE AcCode='" . $AcCode . "'";
                    $sq->query($del_sql);
                }

                $cr_sql = "INSERT INTO  rollco_ms_sales_sheet  SET user_id= '" . $u_id . "'  ,user_email = '" . $com_emailAddress . "',user_postcode='" . $com_zipCode . "',roll_last_year_turnover='" . $RotatingTurnoverLastYear . "',roll_share_per='" . $RollingSharePer . "',gross_qty='" . $GrossSaleQty . "',gross_faulty='" . $Faulty . "',gross_faulty_per='" . $FaultyPer . "',gross_return_stock='" . $ReturnToStock . "',faulty_cat_qty='" . $FaultyCategoryQtyFaulty . "',faulty_cat_nff='" . $FaultyCategoryNff . "',faulty_cat_transit_damage='" . $FaultyCategoryTransitDamage . "',faulty_cat_contanimated='" . $FaultyCategoryQtyContaminated . "',roll_curr_outstanding='" . $CurrentOutstanding . "',roll_consgnmt_qty='" . $CongnmentQtySR . "',roll_overdue_outstanding='" . $OverDueOutstandingIfAny . "',roll_consgnmt_value='" . $CongnmntValueSR . "' ,roll_last_stock_cdate='" . date('Y-m-d H:i:s', strtotime($LastStockCleanseDate)) . "',roll_sor_extended='" . $ExtendedSOR . "',roll_last_visit='" . $LastVisitedBy . "',created_by_email='" . $CreatedBy . "',AcCode='" . $AcCode . "'";

                $sq->query($cr_sql);
                $count++;
            }
        }
        $mycnts++;
    }  //While loop end here
//exit;
    echo "<script>location.href='import_sales_sheet.php?mycnts=" . $count . "';</script>";
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
                                                        <td height="400" align="left" valign="top"><form action="import_sales_sheet.php" method="post" enctype="multipart/form-data" name="form1" class="text09" onSubmit="return validate_import();">
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td colspan="2" class="txt5" style="padding-bottom: 20px">Import User Sales Sheet</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="txt11"><span>
                                                                                <?php if (isset($_GET['mycnts'])) { ?>
                                                                                    Total <?php echo $_GET['mycnts']; ?> record(s) has been inserted successfully.
                                                                                    <br /><br /><br />
                                                                                    <a style="color: #000" href="import_sales_sheet.php">Back to Import User Sales Sheet</a>
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