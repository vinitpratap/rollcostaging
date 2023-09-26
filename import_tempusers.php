<?php
include("class/config.php");
$_SESSION['mstart'] = time();

if (isset($_FILES['file'])) {          //If Condition start here
    $handle = fopen($_FILES['file']['tmp_name'], "r");
    $mycount = 0;
    $count = 0;
    $mycnts = 0;
    $insertcount = 0;
    $updatecount = 0;
//$current_date=date('d-m-y');
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { //While loop start here
        if ($mycnts > 0) {
            //echo "<pre>";print_r($data);die;
//Swith Case Variable start here
//code start for import Profile Change
            $firstName = '';
            $lastName = '';
            $customerID = addslashes(trim($data[0]));
            $CompanyName = addslashes(trim($data[1]));
            $PostCode = addslashes(trim($data[2]));

             if($CompanyName != ''){
                       $nameArr = explode(' ',$CompanyName);
                       if(isset($nameArr[0]) && $nameArr[0] !=''){
                           $firstName = $nameArr[0];
                       }
                       if(isset($nameArr[1]) && $nameArr[1] !=''){
                           $lastName = $nameArr[1];
                       }
                   }
            


            if ($customerID != "") {
                $sqlsts = "select u_id from rollco_ms_tmpusers where customerID='" . $customerID . "',com_zipCode='" . $PostCode . "'";
                $pnums = $sq->numsrow($sqlsts);
                if ($pnums == 0) {
                  
                    $query = "insert into rollco_ms_tmpusers SET 
firstName='" . $firstName . "',
lastName='" . $lastName . "',
com_zipCode='" . $PostCode . "',
customerID='" . $customerID . "'";
                  
$sq->query($query);
  $insertcount++;
                } else {
                    
                    
                  $query = "update rollco_ms_tmpusers SET 
firstName='" . $firstName . "',
lastName='" . $lastName . "',
com_zipCode='" . $PostCode . "',
where customerID='" . $customerID . "'";
                    $sq->query($query);
                    $updatecount++;
                }
            }
          
//Swith Case Variable end here
        }

        $mycnts++;
    }  //While loop end here
//exit;

    echo "<script>location.href='import_tempusers.php?inscnt=".$insertcount."&updcnt=".$updatecount."';</script>";
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
                                                        <td height="400" align="left" valign="top"><form action="import_tempusers.php" method="post" enctype="multipart/form-data" name="form1" class="text09" onSubmit="return validate_import();">
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td colspan="2" class="txt5" style="padding-bottom: 20px">Import Temp User</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="txt11"><span>
                                                                                
<?php if (isset($_GET['inscnt']) || isset($_GET['updcnt'])) { ?>
                                                                                    Total <?php echo $_GET['inscnt']; ?>  record(s) has been inserted successfully.
                                                                                    Total <?php echo $_GET['updcnt']; ?>  record(s) has been updated successfully.
                                                                                    <br /><br /><br />
                                                                                    <a style="color: #000" href="import_tempusers.php">Back to Import User</a>
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