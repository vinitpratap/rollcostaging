<?php
include("class/config.php");
$_SESSION['mstart'] = time();

$not_importedemails = array();
$new_users = array();
$old_users = array();
if (isset($_FILES['file'])) {          //If Condition start here
    $handle = fopen($_FILES['file']['tmp_name'], "r");
    $mycount = 0;
    $count = 0;
    $mycnts = 0;

    $insertcount = 0;
    $updatecount = 0;
    $notuploadedcount = 0;
//$current_date=date('d-m-y');
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { //While loop start here
//echo "<pre>";print_r($data);die;
        if ($mycnts > 0) {

            $Duplicate = 0;
            $cal_show = 0;
//Swith Case Variable start here
//code start for import Profile Change
            $CustomerID = str_replace("?", "", mb_convert_encoding(trim($data[0]), 'UTF-8', 'UTF-8'));
            $NAME = str_replace("?", "", mb_convert_encoding(trim($data[1]), 'UTF-8', 'UTF-8'));
            $ZIP = str_replace("?", "", mb_convert_encoding(trim($data[2]), 'UTF-8', 'UTF-8'));
            $GROUP = str_replace("?", "", mb_convert_encoding(trim($data[3]), 'UTF-8', 'UTF-8'));
            $TOWN = str_replace("?", "", mb_convert_encoding(trim($data[4]), 'UTF-8', 'UTF-8'));
            $COUNTY = str_replace("?", "", mb_convert_encoding(trim($data[5]), 'UTF-8', 'UTF-8'));
            $REGION = str_replace("?", "", mb_convert_encoding(trim($data[6]), 'UTF-8', 'UTF-8'));
            $COUNTRY = str_replace("?", "", mb_convert_encoding(trim($data[7]), 'UTF-8', 'UTF-8'));
            $Telephone = str_replace("?", "", mb_convert_encoding(trim($data[8]), 'UTF-8', 'UTF-8'));
            $Fax = str_replace("?", "", mb_convert_encoding(trim($data[9]), 'UTF-8', 'UTF-8'));
            $acemail = str_replace("?", "", mb_convert_encoding(trim($data[10]), 'UTF-8', 'UTF-8'));
            $Role = str_replace("?", "", mb_convert_encoding(trim($data[11]), 'UTF-8', 'UTF-8'));
            $Website = str_replace("?", "", mb_convert_encoding(trim($data[12]), 'UTF-8', 'UTF-8'));
            $vat = str_replace("?", "", mb_convert_encoding(trim($data[13]), 'UTF-8', 'UTF-8'));
            $regno = str_replace("?", "", mb_convert_encoding(trim($data[14]), 'UTF-8', 'UTF-8'));
            $AccountPersonname = str_replace("?", "", mb_convert_encoding(trim($data[15]), 'UTF-8', 'UTF-8'));
            $Registrationdate = str_replace("?", "", mb_convert_encoding(trim($data[16]), 'UTF-8', 'UTF-8'));
            $email = str_replace("?", "", mb_convert_encoding(trim($data[17]), 'UTF-8', 'UTF-8'));
            $otheremail = str_replace("?", "", mb_convert_encoding(trim($data[19]), 'UTF-8', 'UTF-8'));
            $otherpwd = str_replace("?", "", mb_convert_encoding(trim($data[20]), 'UTF-8', 'UTF-8'));
            $ANOTHERemail = str_replace("?", "", mb_convert_encoding(trim($data[21]), 'UTF-8', 'UTF-8'));
            $ANOTHERpwd = str_replace("?", "", mb_convert_encoding(trim($data[22]), 'UTF-8', 'UTF-8'));
            $pricelist = str_replace("?", "", mb_convert_encoding(trim($data[23]), 'UTF-8', 'UTF-8'));
            $CustomerID = str_replace("?", "", mb_convert_encoding(trim($data[0]), 'UTF-8', 'UTF-8'));
            $CurrencyName = str_replace("?", "", mb_convert_encoding(trim($data[24]), 'UTF-8', 'UTF-8'));
            $status = str_replace("?", "", mb_convert_encoding(trim($data[25]), 'UTF-8', 'UTF-8'));



            if ($status == 'YES') {
                $cal_show = 1;
            } else {
                $cal_show = 0;
            }


            $gr_id = 0;
            $curr_id = 0;
            $gr_sql = "select gr_id from rollco_ms_group where gr_nm = '" . $pricelist . "'";
            $gr_res = $sq->fearr($gr_sql);
            if (isset($gr_res['gr_id']) && $gr_res['gr_id'] > 0)
                $gr_id = $gr_res['gr_id'];

            if ($CustomerID != "") {
               $query = "UPDATE rollco_ms_users SET 
g_id='" . str_replace("'", "", $gr_id) . "',
grp_nm='" . str_replace("'", "", $GROUP) . "',
all_flag=1 WHERE customerID='" . str_replace("/\/", "", $CustomerID) . "' AND temp_flag=0 ";

                $instatus = $sq->query($query);

                if ($instatus) {
                    $insertLog = "INSERT INTO rollco_latest_userlog SET acname='" . $CustomerID . "',name='" . $NAME . "',zip='" . $ZIP . "',GROUPName='" . $GROUP . "',TOWN='" . $TOWN . "',COUNTY='" . $COUNTY . "',REGION='" . $REGION . "',COUNTRY='" . $COUNTRY . "',Telephone='" . $Telephone . "',Fax='" . $Fax . "',ac_email='" . $acemail . "',Role='" . $Role . "',Website='" . $Website . "',vat='" . $vat . "',RegNumber='" . $regno . "',AccountPersonname='" . $AccountPersonname . "',RegistrationDate='" . $Registrationdate . "',LOGINemailID='" . $email . "',PriceList='" . $pricelist . "',CurrencyName='" . $CurrencyName . "',status='new'";
                    $sq->query($insertLog);
                    $updatecount++;
                } else {
                    $insertLog = "INSERT INTO rollco_latest_userlog SET acname='" . $CustomerID . "',name='" . $NAME . "',zip='" . $ZIP . "',GROUPName='" . $GROUP . "',TOWN='" . $TOWN . "',COUNTY='" . $COUNTY . "',REGION='" . $REGION . "',COUNTRY='" . $COUNTRY . "',Telephone='" . $Telephone . "',Fax='" . $Fax . "',ac_email='" . $acemail . "',Role='" . $Role . "',Website='" . $Website . "',vat='" . $vat . "',RegNumber='" . $regno . "',AccountPersonname='" . $AccountPersonname . "',RegistrationDate='" . $Registrationdate . "',LOGINemailID='" . $email . "',PriceList='" . $pricelist . "',CurrencyName='" . $CurrencyName . "',status='exist'";
                    $sq->query($insertLog);
                    $notuploadedcount++;
                }
            } else {
                $insertLog = "INSERT INTO rollco_latest_userlog SET acname='" . $CustomerID . "',name='" . $NAME . "',zip='" . $ZIP . "',GROUPName='" . $GROUP . "',TOWN='" . $TOWN . "',COUNTY='" . $COUNTY . "',REGION='" . $REGION . "',COUNTRY='" . $COUNTRY . "',Telephone='" . $Telephone . "',Fax='" . $Fax . "',ac_email='" . $acemail . "',Role='" . $Role . "',Website='" . $Website . "',vat='" . $vat . "',RegNumber='" . $regno . "',AccountPersonname='" . $AccountPersonname . "',RegistrationDate='" . $Registrationdate . "',LOGINemailID='" . $email . "',PriceList='" . $pricelist . "',CurrencyName='" . $CurrencyName . "',status='not uploaded'";
                $sq->query($insertLog);
                $notuploadedcount++;
            }

//Swith Case Variable end here
        }

        $mycnts++;
    }  //While loop end here
//exit;

    echo "<script>location.href='update_user_latest.php?inscnt=" . $insertcount . "&updcnt=" . $updatecount . "&notuploadcnt=" . $notuploadedcount . "';</script>";
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
                                                        <td height="400" align="left" valign="top"><form action="update_user_latest.php" method="post" enctype="multipart/form-data" name="form1" class="text09" onSubmit="return validate_import();">
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td colspan="2" class="txt5" style="padding-bottom: 20px">Update All User</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="txt11"><span>

                                                                                <?php if (isset($_GET['inscnt']) || isset($_GET['updcnt']) || isset($_GET['notuploadcnt'])) { ?>
                                                                                    Total <?php echo $_GET['inscnt']; ?>  record(s) has been inserted successfully.
                                                                                    Total <?php echo $_GET['updcnt']; ?>  record(s) has been updated successfully.
                                                                                    Total <?php echo $_GET['notuploadcnt']; ?>  record(s) has been not uploaded.
                                                                                    <br /><br /><br />
                                                                                    <a style="color: #000" href="update_user_latest.php">Back to Import User</a>
                                                                                    <?php
                                                                                } else
                                                                                    echo "Please click on 'Browse' button to select and upload csv file.";
                                                                                ?>
                                                                            </span></td>
                                                                    </tr>
                                                                    <?php
                                                                    if (isset($_GET['updcnt'])) {
                                                                        
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