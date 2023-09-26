<?php 
include("class/config.php"); 
$_SESSION['mstart']=time();
if(isset($_FILES['file']))          //If Condition start here
{
$handle = fopen($_FILES['file']['tmp_name'], "r");
$mycount=0;
$count=0;
$mycnts=0;
//$current_date=date('d-m-y');
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) //While loop start here
{
if ($mycnts>0)
{
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


$gr_id=0;
$curr_id=0;
$gr_sql="select gr_id from rollco_ms_group where gr_nm = '".$GroupCode."'";
$gr_res=$sq->fearr($gr_sql);
if(isset($gr_res['gr_id']) && $gr_res['gr_id']>0) $gr_id=$gr_res['gr_id'];

if ( $email!="" ) {
$sqlsts="select u_id from rollco_ms_users where com_emailAddress='".$email."' ";
$pnums=$sq->numsrow($sqlsts);

$query="update rollco_ms_users SET 
g_id='".$gr_id."' 
where com_emailAddress='".$email."'";
$sq->query($query) ;
$count++;
}
//Swith Case Variable end here
}

$mycnts++;
}  //While loop end here
//exit;
echo "<script>location.href='update_user_accntcode.php?mycnts=".$count."';</script>";
}   //If Condition end here
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $sitetitle;?></title>
<link href="stylesheet.css" rel="stylesheet" type="text/css">
<SCRIPT language=JavaScript>
function validate_import()
{
	if(document.getElementById('file').value=="")
	{
	alert("Please upload file");
	document.getElementById('file').focus();
	return false;
	}
}
function close_the_window(){
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
                      <td height="400" align="left" valign="top"><form action="update_user_accntcode.php" method="post" enctype="multipart/form-data" name="form1" class="text09" onSubmit="return validate_import();">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td colspan="2" class="txt5" style="padding-bottom: 20px">Import User</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="txt11"><span>
                                  <?php if(isset($_GET['mycnts'])) {?>
Total <?php echo $_GET['mycnts'];?> record(s) has been updated successfully.
<br /><br /><br />
<a style="color: #000" href="update_user_accntcode.php">Back to Import User</a>
<?php
}
else echo "Please click on 'Browse' button to select and upload csv file.";
?>
                                </span></td>
                            </tr>
<?php 
if(isset($_GET['mycnts'])){}
else{
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
<?php }?>                          
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