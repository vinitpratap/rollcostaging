<?php
include("class/config.php");
ini_set('max_execution_time', 0);
$_SESSION['mstart'] = time();
if (isset($_FILES['file'])) {          //If Condition start here
    $handle = fopen($_FILES['file']['tmp_name'], "r");
    $mycount = 0;
    $count = 0;
    $mycnts = 0;
	$frmRef='Yes';
//$current_date=date('d-m-y');
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { //While loop start here
        if ($mycnts > 0) {
			$gr_nm = stripcslashes(str_replace( "'", "", trim($data[0])));
           $gr_currency =  stripcslashes(str_replace( "'", "", trim($data[1])));
            $gr_id = 0;
			$t_id = 0;
           $u_sql = 'select gr_id from rollco_ms_group where gr_nm = "' . $gr_nm . '"  LIMIT 1 ';
            //echo "<br/>";
			$check_num = $sq->numsrow($u_sql);
            if ($check_num>0) {
				$u_res = $sq->fearr($u_sql);
				if($u_res['gr_id'] > 0){
					 $gr_id = $u_res['gr_id'];
				} 
            }
			if($gr_id > 0){
if ($gr_currency=='USD') $gr_currency='2';
else if ($gr_currency=='GBP') $gr_currency='3';
else if ($gr_currency=='EURO') $gr_currency='4';
$update_sql = "UPDATE rollco_ms_group SET 
gr_currency='" . $gr_currency . "',
grstt='" . $frmRef . "',
grudate = '" . $getdatetime . "'
WHERE gr_nm='" . $gr_nm."'";
$sq->query($update_sql);
					$count++;
				} else {
$insertSql = "INSERT INTO rollco_ms_group_logs SET gr_nm='".$gr_nm."',gr_currency='" . $gr_currency . "',grstt='No ACCODE Available',grudate='".$getdatetime."'";
$sq->query($insertSql) or die(mysqli_error(GetMyConnection()));
					
					}
			}
        $mycnts++;
    }  //While loop end here
    echo "<script>location.href='import_groupcode.php?mycnts=" . $count . "';</script>";
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
                                                        <td height="400" align="left" valign="top"><form action="import_groupcode.php" method="post" enctype="multipart/form-data" name="form1" class="text09" onSubmit="return validate_import();">
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td colspan="2" class="txt5" style="padding-bottom: 20px">Import User Price Group Code</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="txt11"><span>
                                                                                <?php if (isset($_GET['mycnts'])) { ?>
                                                                                    Total <?php echo $_GET['mycnts']; ?> record(s) has been inserted successfully.
                                                                                    <br /><br /><br />
                                                                                    <a style="color: #000" href="import_groupcode.php">Back to Import User Price Group Code</a>
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