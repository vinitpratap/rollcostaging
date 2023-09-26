<!DOCTYPE html>
<html>
    <head>
        <title>Rollco mailer</title>
    </head>
    <style type="text/css">
        table {border-collapse:collapse;}
        body{ margin:0px; padding:0px;;font-family:Arial, sans-serif; }
    </style>
    <body>
        <table  border="0" cellspacing="0" cellpadding="0" width="890" align="center">
            <tr>

                <td style="padding:25px 0px 30px; background-color:#ffffff; margin:0px; border:1px solid #c5c5c6">
                    <table  border="0" cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                            <td style="font-size:18px; color:#4d4d4f;line-height:24px;font-family:Arial, sans-serif; padding:0px 30px"> <img src="http://rollingcomponents.com/mailer/images/logo.jpg?v=1.1">	</td>
                        </tr>
                        <tr>
                            <td style="font-size:16px; color:#4d4d4f;line-height:24px;font-family:Arial, sans-serif; padding:30px 30px 20px"> 	
                                <strong>Dear sir,</strong><br><br>
                                Calendar has been updated by <?php echo $com_emailAddress;?>
                                <br/>
                                <br>
                                <br>
                                Calendar detail(s) are
                                <br/>
Date : <?php echo $app_date; ?> <br/>
Post Code : <?php echo $zipCode; ?><br/>
Country/Town : <?php echo $city; ?> <br/>
Ac Name : <?php echo $fullname; ?> <br/>
Start Time : <?php echo $app_stime; ?> <br/>
End Time : <?php echo $app_etime; ?> <br/> 
Remark : <?php echo $app_remarks; ?> <br/>

<br/>

Old Calendar Value
                                <br/>
Date : <?php echo $olddate; ?> <br/>
Post Code : <?php echo $oldzip; ?><br/>
Country/Town : <?php echo $oldcity; ?> <br/>
Ac Name : <?php echo $oldname; ?> <br/>
Start Time : <?php echo $oldstime; ?> <br/>
End Time : <?php echo $oldetime; ?> <br/> 
Remark : <?php echo $oldremarks; ?> <br/>


                            
                            </td>
                        </tr>



                        <tr>
                            <td style="font-size:12px;padding:10px;color:#212529;font-weight:600; text-align:center; padding-top:25px; ">
                                <a href="http://www.rollingcomponents.com" style="color:#ef4135"> http://www.rollingcomponents.com</a> |  <a href="mailto:support@rollingcomponents.co.uk" style="color:#ef4135">support@rollingcomponents.co.uk</a>

                            </td>

                        </tr>
                        <tr>
                            <td style="font-size:12px;padding:10px;color:#343a40; text-align:center; ">
                                Copyrights <?php echo date('Y');?> Rolling Components. All Rights Reserved.	 </td>

                        </tr>
                    </table>
                </td>

            </tr>


        </table>

    </body>
</html>