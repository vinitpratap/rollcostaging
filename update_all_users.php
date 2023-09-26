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
            $GroupCode = trim($data[1]);
            $FirstName = trim($data[2]);
            $LastName = trim($data[3]);
            $Add1 = trim($data[4]);
            $Add2 = trim($data[5]);
            $City = trim($data[6]);
            $State = trim($data[7]);
            $ZIP = trim($data[8]);
            $Telephone = trim($data[9]);
            $Fax = trim($data[10]);
            $Email = trim($data[11]);
            $Role = trim($data[12]);
            $CompanyName = trim($data[13]);
            
            $Website = trim($data[14]);
            $RegNumber = trim($data[15]);
            
            $VATno = trim($data[16]);
            $Companyage = trim($data[17]);
            
            $RegAdd1 = trim($data[18]);
            
            $RegAdd2 = trim($data[19]);
            
            $Regcity = trim($data[20]);
            
            $RegState = trim($data[21]);
            
            $RegZIP = trim($data[22]);
            $InvoiceAdd1 = trim($data[23]);
            $InvoiceAdd2 = trim($data[24]);
            $Invoicecity = trim($data[25]);
            $Invoicestate = trim($data[26]);
            $InvoiceZIP = trim($data[27]);
            
            $AccountPersonname = trim($data[28]);
            $AccountemailID = trim($data[29]);
            $Accountmobile = trim($data[30]);
            $Accountdepartmentname = trim($data[31]);
            $Turnover = trim($data[32]);
            $Branches = trim($data[33]);
            $Bankname = trim($data[34]);
            $Bankaddress = trim($data[35]);
            $Bankpostcode = trim($data[36]);
            $BankAccountno = trim($data[37]);
            $Contactnumber = trim($data[38]);
            $Sortcode = trim($data[39]);
            $Userstatus = trim($data[40]);
            $RegistrationDate = trim($data[41]);
            $Createdat = trim($data[42]);

            
            $gr_id = 0;
            $curr_id = 0;
            $gr_sql = "select gr_id from rollco_ms_group where gr_nm = '" . $GroupCode . "'";
            $gr_res = $sq->fearr($gr_sql);
            if (isset($gr_res['gr_id']) && $gr_res['gr_id'] > 0)
                $gr_id = $gr_res['gr_id'];


            if ($Email != "") {

                $query = "UPDATE rollco_ms_users SET 
firstName='" . str_replace("'", "", $FirstName) . "',
lastName='" . str_replace("'", "", $LastName)  . "',
streetAddress1='" . str_replace("'", "", $Add1) . "',
streetAddress2='" . str_replace("'", "", $Add2) . "',
com_city='" .  str_replace("'", "", $City)  . "',
com_state='" .  str_replace("'", "", $State)  . "',
com_zipCode='" . str_replace("'", "", $ZIP) . "',
com_Telephone='" . str_replace("'", "", $Telephone) . "',
com_Fax='" . str_replace("'", "", $Fax)  . "',
com_emailAddress='" . str_replace("'", "", $Email) . "',
role='" .  str_replace("'", "", $Role) . "',
companyName='" . str_replace("'", "", $CompanyName) . "',
companyWebsite='" . str_replace("'", "", $Website) . "',
companyRegistrationNumber='" . str_replace("'", "", $RegNumber) . "',
companyVatNumber='".str_replace("'", "", $VATno)."',
companyAge='".str_replace("'", "", $Companyage)."',
companyRegAdd1='".str_replace("'", "", $RegAdd1)."',
companyRegAdd2='".str_replace("'", "", $RegAdd2)."',
companyRegCity='".str_replace("'", "", $Regcity)."',
companyRegState='".str_replace("'", "", $RegState)."',
companyRegZip='".str_replace("'", "", $RegZIP)."',
companyAccountPerName='".str_replace("'", "", $AccountPersonname)."',
companyAccountPerEmail='".str_replace("'", "", $AccountemailID)."',
companyAccountPerMobile='".str_replace("'", "", $Accountmobile)."',
regisdate='".str_replace("'", "", $RegistrationDate)."',
all_flag=1 WHERE com_emailAddress='" . str_replace("/\/", "", $Email) . "' AND temp_flag=0";

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

    echo "<script>location.href='update_all_users.php?inscnt=" . $insertcount . "&updcnt=" . $updatecount . "&notuploadcnt=" . $notuploadedcount . "';</script>";
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
                                                        <td height="400" align="left" valign="top"><form action="update_all_users.php" method="post" enctype="multipart/form-data" name="form1" class="text09" onSubmit="return validate_import();">
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
                                                                                    <a style="color: #000" href="update_all_users.php">Back to Import User</a>
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