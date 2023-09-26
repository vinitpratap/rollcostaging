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
            $Duplicate = 0;
//Swith Case Variable start here
//code start for import Profile Change
            $CustomerID = trim($data[0]);
            $RevCustomerID = trim($data[1]);
            $GroupCode = trim($data[2]);
            $RevGroupCode = trim($data[3]);
            $ZIP = trim($data[4]);
            $RevZIP = trim($data[5]);
            $Telephone = trim($data[6]);
            $RevTelephone = trim($data[7]);
            $Fax = trim($data[8]);
            $RevFax = trim($data[9]);
            $Email = trim($data[10]);
            $RevEmail = trim($data[11]);
            $Role = trim($data[12]);
            $RevRole = trim($data[13]);
            $CompanyName = trim($data[14]);
            $RevCompanyName = trim($data[15]);
            $Website = trim($data[16]);
            $RevWebsite = trim($data[17]);
            $RegNumber = trim($data[18]);
            $RevRegNumber = trim($data[19]);
            $vatno = trim($data[20]);
            $RevVatno = trim($data[21]);
            $AccountPersonname = trim($data[22]);
            $RevAccountPersonname = trim($data[23]);
            $AccountemailID = trim($data[24]);
            $RevAccountemailID = trim($data[25]);
            $RegistrationDate = trim($data[26]);
            $RevRegistrationDate = trim($data[27]);

            if(isset($data[30]) && $data[30] !=''){
                $Duplicate = trim($data[30]);
            }
            
            $gr_id = 0;
            $curr_id = 0;
            $gr_sql = "select gr_id from rollco_ms_group where gr_nm = '" . $RevGroupCode . "'";
            $gr_res = $sq->fearr($gr_sql);
            if (isset($gr_res['gr_id']) && $gr_res['gr_id'] > 0)
                $gr_id = $gr_res['gr_id'];


            if ($Email != "") {

                $query = "UPDATE rollco_ms_users SET 
customerID='" . $RevCustomerID . "',
g_id='" . $gr_id . "',
com_zipCode='" . $RevZIP . "',
com_Telephone='" . $RevTelephone . "',
com_Fax='" . $RevFax . "',
com_emailAddress='" . str_replace("/\/", "", $RevEmail) . "',
role='" . $RevRole . "',
companyName='" . str_replace("'", "", $RevCompanyName) . "',
companyWebsite='" . $RevWebsite . "',
companyRegistrationNumber='" . $RevRegNumber . "',
companyVatNumber='" . $RevVatno . "',
companyAccountPerName='" . $AccountPersonname . "',
companyAccountPerEmail='" . str_replace("/\/", "", $RevAccountemailID) . "',
regisdate='" . $RevRegistrationDate . "',
cal_show='".$Duplicate."',
temp_flag=1 WHERE com_emailAddress='" . str_replace("/\/", "", $Email) . "'";

                $instatus = $sq->query($query);

                if ($instatus) {
                    $updatecount++;
                } else {
                    $notuploadedcount++;
                }
            } else {
                echo $Email;
                $notuploadedcount++;
            }

//Swith Case Variable end here
        }

        $mycnts++;
    }  //While loop end here
//exit;

    echo "<script>location.href='update_temp_users.php?inscnt=" . $insertcount . "&updcnt=" . $updatecount . "&notuploadcnt=" . $notuploadedcount . "';</script>";
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
                                                        <td height="400" align="left" valign="top"><form action="update_temp_users.php" method="post" enctype="multipart/form-data" name="form1" class="text09" onSubmit="return validate_import();">
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td colspan="2" class="txt5" style="padding-bottom: 20px">Update Duplicate User</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="txt11"><span>

                                                                                <?php if (isset($_GET['inscnt']) || isset($_GET['updcnt']) || isset($_GET['notuploadcnt'])) { ?>
                                                                                    Total <?php echo $_GET['inscnt']; ?>  record(s) has been inserted successfully.
                                                                                    Total <?php echo $_GET['updcnt']; ?>  record(s) has been updated successfully.
                                                                                    Total <?php echo $_GET['notuploadcnt']; ?>  record(s) has been not uploaded.
                                                                                    <br /><br /><br />
                                                                                    <a style="color: #000" href="update_temp_users.php">Back to Import User</a>
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