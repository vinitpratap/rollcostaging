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
			
			if($data[4] !=''){
				$aptDateArr = explode('-',$data[4]);
			}
			$dd = '';
			$mm = '';
			$yy = '';
			if(count($aptDateArr) == 3){
				$dd = $aptDateArr[0];
				$mm = $aptDateArr[1];
				$yy = $aptDateArr[2];
			}
			//echo "<pre>";print_r($aptDateArr);die;
//Swith Case Variable start here
//code start for import Profile Change

			$ACCODE = stripcslashes(str_replace( "'", "", trim($data[0])));
            $Name =  stripcslashes(str_replace( "'", "", trim($data[1])));
            $postcode =  stripcslashes(str_replace( "'", "", trim($data[2])));
            $country =  stripcslashes(str_replace( "'", "", trim($data[3])));
            $appointmentdate = date("Y-m-d",strtotime($yy.'-'.$mm.'-'.$dd));
            $appintmentstarttime = date("H:i",strtotime(trim($data[5])));
			$appintmentendtime = date("H:i",strtotime(trim($data[6])));
			
			//echo "<pre>";print_r($appointmentdate);die;

			$remarks =  stripcslashes(str_replace( "'", "", trim($data[7])));
			
			/*$ACCODE = utf8_encode($ACCODE);
			$Name = utf8_encode($Name);
			$postcode = utf8_encode($postcode);
			$country = utf8_encode($country);
			$remarks = utf8_encode($remarks);*/

            $u_id = 0;
			$t_id = 0;
            $u_sql = 'select u_id from rollco_ms_users where customerID = "' . $ACCODE . '"  LIMIT 1 ';
            //echo "<br/>";
			$check_num = $sq->numsrow($u_sql);
			
            if ($check_num>0) {
				$u_res = $sq->fearr($u_sql);
				if($u_res['u_id'] > 0){
					 $u_id = $u_res['u_id'];
				}
            }else{
				$checktmpSql = 'SELECT u_id FROM rollco_ms_tmpusers WHERE customerID="'.$ACCODE.'"  LIMIT 1';
				$check_numt = $sq->numsrow($checktmpSql);
				
				if ($check_numt>0) {
					$temp_res = $sq->fearr($checktmpSql);
					if($temp_res['u_id'] > 0){
					 $t_id = $temp_res['u_id'];
					}
				}
				
			}
			
			if($u_id > 0 || $t_id >0){
				
				$checksql = 'SELECT sc_id FROM rollco_salescal WHERE (u_id="'.$u_id.'" OR temp_id="'.$t_id.'") 
				AND post_code="'.$postcode.'" AND sc_date="'.$appointmentdate.'" AND sc_stime="'.$appintmentstarttime.'" 
				AND sc_etime="'.$appintmentendtime.'" LIMIT 1';
				$checkres = $sq->fearr($checksql);
				if (isset($checkres['sc_id']) && $checkres['sc_id'] != '') {
					$notinsertedSql1 = "INSERT INTO rollco_callog_notinserted SET ACCODE='".$ACCODE."',Name ='".$Name."',
					postcode='".$postcode."',country='".$country."',appointmentdate='".$appointmentdate."',
					appintmentstarttime='".$appintmentstarttime."',appintmentendtime='".$appintmentendtime."', case_check='Exist'";
					
					$sq->query($notinsertedSql1);
				}else{
					
$insertSql = "INSERT INTO rollco_salescal SET cdate='".$getdatetime."',ipaddress='".$_SERVER['REMOTE_ADDR']."',u_id='".$u_id."',temp_id='".$t_id."',full_name='".$Name."',post_code='".$postcode."',sc_country='".$country."',sc_date='".$appointmentdate."',sc_stime='".$appintmentstarttime."',sc_etime='".$appintmentendtime."',sc_remarks='".$remarks."'";
$sq->query($insertSql) or die(mysqli_error(GetMyConnection()));

$insertSql1 = "INSERT INTO rollco_salescallog SET u_id='".$u_id."',temp_id='".$t_id."',full_name='".$Name."',post_code='".$postcode."',
					sc_country='".$country."',sc_date='".$appointmentdate."',sc_stime='".$appintmentstarttime."'
					,sc_etime='".$appintmentendtime."',sc_remarks='".$remarks."',log_action='Insert',cdate='".$getdatetime."',log_date='".$getdatetime."'";
					
					
					$sq->query($insertSql1)  or die(mysqli_error(GetMyConnection()));
					
					$notinsertedSql2 = "INSERT INTO rollco_callog_notinserted SET ACCODE='".$ACCODE."',Name ='".$Name."',
					postcode='".$postcode."',country='".$country."',appointmentdate='".$appointmentdate."',
					appintmentstarttime='".$appintmentstarttime."',appintmentendtime='".$appintmentendtime."', case_check='Insert'";
					
					$sq->query($notinsertedSql2);
					
				//	$stat = $sq->query($insertSql);
					//if(!$stat){
						//echo "insertsql".$insertSql."</br>";
					//}
					$count++;
				}
			}else{
				$notinsertedSql3 = "INSERT INTO rollco_callog_notinserted SET ACCODE='".$ACCODE."',Name ='".$Name."',
					postcode='".$postcode."',country='".$country."',appointmentdate='".$appointmentdate."',
					appintmentstarttime='".$appintmentstarttime."',appintmentendtime='".$appintmentendtime."', case_check='Skip'";
				
				$sq->query($notinsertedSql3);
			}
        }
        $mycnts++;
    }  //While loop end here
	
    echo "<script>location.href='import_calanderdata.php?mycnts=" . $count . "';</script>";
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
                                                        <td height="400" align="left" valign="top"><form action="import_calanderdata.php" method="post" enctype="multipart/form-data" name="form1" class="text09" onSubmit="return validate_import();">
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td colspan="2" class="txt5" style="padding-bottom: 20px">Import User Calander Sheet</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="txt11"><span>
                                                                                <?php if (isset($_GET['mycnts'])) { ?>
                                                                                    Total <?php echo $_GET['mycnts']; ?> record(s) has been inserted successfully.
                                                                                    <br /><br /><br />
                                                                                    <a style="color: #000" href="import_calanderdata.php">Back to Import User Calander Sheet</a>
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