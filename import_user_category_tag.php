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
            $AcCode = trim($data[0]);
            $RotatingCheck = trim($data[1]);
            $EMSCheck = trim($data[2]);
            $CaliperCheck = trim($data[3]);
            $SpareCheck = trim($data[4]);
            $UnitCheck = trim($data[5]);

            $rotatingid = 0;
            $emsid = 0;
            $caliperid = 0;
            $spareid = 0;
            $unitid = 0;

            $u_id = 0;

            $u_sql = "select u_id from rollco_ms_users where customerID = '" . $AcCode . "' AND  user_status = 2 AND cust_type !=3  LIMIT 1 ";
            $u_res = $sq->fearr($u_sql);
            if (isset($u_res['u_id']) && $u_res['u_id'] > 0)
                $u_id = $u_res['u_id'];
            if ($u_id > 0) {
                
                $check_tagsql = "SELECT u_id FROM rollco_user_to_category_tag WHERE u_id='" . $u_id . "'";
                $check_tagnum = $sq->numsrow($check_tagsql);
                if ($check_tagnum > 0) {
                    $del_tagsql = "DELETE FROM rollco_user_to_category_tag WHERE u_id='" . $u_id . "'";
                    $sq->query($del_tagsql);
                }
                
                if (isset($RotatingCheck) && $RotatingCheck == 1) {
                    $rotatingid = 8;
                    $cr_sql = "INSERT INTO  rollco_user_to_category_tag  SET u_id= '" . $u_id . "'  ,cat_id = '" . $rotatingid . "'";
                    $sq->query($cr_sql);
                    $count++;
                }
                if (isset($EMSCheck) && $EMSCheck == 1) {
                    $emsid = 5;
                    $cr_sql = "INSERT INTO  rollco_user_to_category_tag  SET u_id= '" . $u_id . "'  ,cat_id = '" . $emsid . "'";
                    $sq->query($cr_sql);
                    $count++;
                }
                if (isset($CaliperCheck) && $CaliperCheck == 1) {
                    $caliperid = 6;
                    $cr_sql = "INSERT INTO  rollco_user_to_category_tag  SET u_id= '" . $u_id . "'  ,cat_id = '" . $caliperid . "'";
                    $sq->query($cr_sql);
                    $count++;
                }
                if (isset($SpareCheck) && $SpareCheck == 1) {
                    $spareid = 4;
                    $cr_sql = "INSERT INTO  rollco_user_to_category_tag  SET u_id= '" . $u_id . "'  ,cat_id = '" . $spareid . "'";
                    $sq->query($cr_sql);
                    $count++;
                }
                if (isset($UnitCheck) && $UnitCheck == 1) {
                    $unitid = 3;
                    $cr_sql = "INSERT INTO  rollco_user_to_category_tag  SET u_id= '" . $u_id . "'  ,cat_id = '" . $unitid . "'";
                    $sq->query($cr_sql);
                    $count++;
                }
            }
        }
        $mycnts++;
    }  //While loop end here
//exit;
    echo "<script>location.href='import_user_category_tag.php?mycnts=" . $count . "';</script>";
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
                                                        <td height="400" align="left" valign="top"><form action="import_user_category_tag.php" method="post" enctype="multipart/form-data" name="form1" class="text09" onSubmit="return validate_import();">
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td colspan="2" class="txt5" style="padding-bottom: 20px">Import User Category Tag</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="txt11"><span>
                                                                                <?php if (isset($_GET['mycnts'])) { ?>
                                                                                    Total <?php echo $_GET['mycnts']; ?> record(s) has been updated successfully.
                                                                                    <br /><br /><br />
                                                                                    <a style="color: #000" href="import_user_category_tag.php">Back to Import User Account</a>
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