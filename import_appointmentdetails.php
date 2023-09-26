<?php
include("class/config.php");
ini_set('max_execution_time', 0);
$_SESSION['mstart'] = time();
if (isset($_FILES['file'])) {          //If Condition start here
    $handle = fopen($_FILES['file']['tmp_name'], "r");
    $mycount = 0;
    $count = 0;
    $mycnts = 0;
//$current_date=date('d-m-y');
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { //While loop start here
        if ($mycnts > 0) {
			//echo "<pre>";print_r($data);die;
//Swith Case Variable start here
//code start for import Profile Change

            $sa_apt_details = addslashes(trim($data[0]));
            $AcCode = addslashes(trim($data[1]));
            $SalesPersonName = addslashes(trim($data[2]));
            $CreatedBy = addslashes(trim($data[3]));

            $u_id = 0;
            $u_sql = "select ss_id from rollco_ms_sales_sheet where AcCode = '" . $AcCode . "'  LIMIT 1 ";
            $u_res = $sq->fearr($u_sql);
            if (isset($u_res['ss_id']) && $u_res['ss_id'] != '') {
                $u_id = $u_res['ss_id'];
            } else {
                $u_id = 0;
            }

            if ($sa_apt_details != '') {
                    $check_sql = "SELECT sa_ss_id FROM rollco_ms_sales_appointment WHERE AcCode='" . $AcCode . "' AND sa_ss_id='" . $u_id . "' AND sa_apt_details = '" . $sa_apt_details . "' AND AcCode='" . $AcCode . "' AND SalesPersonName='" . $SalesPersonName . "' AND CreatedBy='" . $CreatedBy . "'";
                    $check_num = $sq->numsrow($check_sql);
                    if($check_num > 0){
                        $del_sql = "DELETE FROM rollco_ms_sales_appointment WHERE AcCode='" . $AcCode . "' AND sa_ss_id='" . $u_id . "' AND sa_apt_details = '" . $sa_apt_details . "' AND AcCode='" . $AcCode . "' AND SalesPersonName='" . $SalesPersonName . "' AND CreatedBy='" . $CreatedBy . "'";
                        $sq->query($del_sql);
                    }
                $ins_sql = "INSERT INTO rollco_ms_sales_appointment SET sa_ss_id='" . $u_id . "',sa_apt_details = '" . $sa_apt_details . "',AcCode='" . $AcCode . "',SalesPersonName='" . $SalesPersonName . "',CreatedBy='" . $CreatedBy . "'";
                $sq->query($ins_sql);
                $count++;
            }
        }
        $mycnts++;
    }  //While loop end here
//exit;
    echo "<script>location.href='import_appointmentdetails.php?mycnts=" . $count . "';</script>";
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
                                                        <td height="400" align="left" valign="top"><form action="import_appointmentdetails.php" method="post" enctype="multipart/form-data" name="form1" class="text09" onSubmit="return validate_import();">
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td colspan="2" class="txt5" style="padding-bottom: 20px">Import User Sales Log</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="txt11"><span>
                                                                                <?php if (isset($_GET['mycnts'])) { ?>
                                                                                    Total <?php echo $_GET['mycnts']; ?> record(s) has been inserted successfully.
                                                                                    <br /><br /><br />
                                                                                    <a style="color: #000" href="import_appointmentdetails.php">Back to Import User Sales Log</a>
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