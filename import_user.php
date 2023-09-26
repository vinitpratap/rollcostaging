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
        if ($mycnts > 0) {
            //echo "<pre>";print_r($data);die;
//Swith Case Variable start here
//code start for import Profile Change

            $customerID = trim($data[1]);
            $GroupCode = trim($data[2]);
            $username = trim($data[3]);
            $email = trim($data[4]);
            $pwd = trim($data[5]);
            $CompanyName = addslashes(trim($data[6]));
            $regisdate = trim($data[7]);
            $verifyDate = trim($data[8]);
            $CurrencyName = trim($data[9]);
            $currencySymbol = trim($data[10]);
            $Address1 = addslashes(trim($data[11]));
            $Address2 = addslashes(trim($data[12]));
            $Zip = trim($data[13]);
            $Tel = trim($data[14]);
            $Mobile = '';
            if (trim($data[15]) != '')
                $Mobile = trim($data[15]);
            $Province = addslashes(trim($data[16]));
            $Country = addslashes(trim($data[17]));
            $city = addslashes(trim($data[18]));
            $IPAddress = trim($data[19]);
            $Category = '';
            if (trim($data[22]) != 'NA' && trim($data[22]) != '')
                $Category = trim($data[22]);

            $OtherEmailId = trim($data[23]);
            $OtherPWD = trim($data[24]);
            $ANOTHEREmailId = trim($data[25]);
            $ANOTHERPWD = trim($data[26]);
            $AccoutOpenDate = trim($data[27]);
            $primarybranch = trim($data[28]);

            if($primarybranch == 1){
                $primarybranch = 2;
            }else{
                $primarybranch = 4;
            }
            $userarr = explode(' ', $username, 2);
            $firstName = addslashes($userarr[0]);
            if (isset($userarr[1]))
                $lastName = addslashes($userarr[1]);

            $gr_id = 0;
            $curr_id = 0;
            $gr_sql = "select gr_id from rollco_ms_group where gr_nm = '" . $GroupCode . "'";
            $gr_res = $sq->fearr($gr_sql);
            if (isset($gr_res['gr_id']) && $gr_res['gr_id'] > 0)
                $gr_id = $gr_res['gr_id'];


            if ($email != "") {

                   
                    $query = "insert into rollco_ms_users SET 
firstName='" . $firstName . "',
lastName='" . $lastName . "',
streetAddress1='" . $Address1 . "',
streetAddress2='" . $Address2 . "',
com_city='" . $city . "',
com_state='" . $Province . "',
com_zipCode='" . $Zip . "',
user_status='".$primarybranch."',
com_emailAddress='".str_replace("'",'',$email)."',
password='".md5($pwd)."',
com_Telephone='" . $Tel . "',
role='" . $Category . "',
companyName='" . str_replace("/\/","",$CompanyName) . "',
g_id='" . $gr_id . "',
CurrencyName='" . $CurrencyName . "',
Country='" . $Country . "',
companyAccountPerMobile='" . $Mobile . "',
ANOTHERPWD='" . $ANOTHERPWD . "',
ANOTHEREmailId='" . $ANOTHEREmailId . "',
OtherPWD='" . $OtherPWD . "',
regisdate='" . $regisdate . "',
OtherEmailId='" . $OtherEmailId . "',
verifyDate='" . $verifyDate . "',
AccoutOpenDate='" . $AccoutOpenDate . "',
new_user='1',
customerID='".$customerID."',
created_at = '" . $getdatetime . "'";
                  
$instatus = $sq->query($query);
if($instatus){
    $insertcount++; 
}

            }else {
                $notuploadedcount++;
            }
          
//Swith Case Variable end here
        }

        $mycnts++;
    }  //While loop end here
//exit;

    echo "<script>location.href='import_user.php?inscnt=".$insertcount."&updcnt=".$updatecount."&notuploadcnt=".$notuploadedcount."';</script>";
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
                                                        <td height="400" align="left" valign="top"><form action="import_user.php" method="post" enctype="multipart/form-data" name="form1" class="text09" onSubmit="return validate_import();">
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td colspan="2" class="txt5" style="padding-bottom: 20px">Import User</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="txt11"><span>
                                                                               
<?php if (isset($_GET['inscnt']) || isset($_GET['updcnt']) ||  isset($_GET['notuploadcnt'])) { ?>
                                                                                    Total <?php echo $_GET['inscnt']; ?>  record(s) has been inserted successfully.
                                                                                    Total <?php echo $_GET['updcnt']; ?>  record(s) has been updated successfully.
                                                                                    Total <?php echo $_GET['notuploadcnt']; ?>  record(s) has been not uploaded.
                                                                                    <br /><br /><br />
                                                                                    <a style="color: #000" href="import_user.php">Back to Import User</a>
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