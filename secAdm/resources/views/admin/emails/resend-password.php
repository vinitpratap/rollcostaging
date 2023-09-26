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
                                <strong>Dear <?php echo $fname;?>,</strong><br><br>
                                Your new password is <?php echo $changedPwd; ?></td>
                        </tr>
                        <tr>
                            <td style="font-size:16px; color:#4d4d4f;line-height:24px;font-family:Arial, sans-serif; padding:20px 30px"> 	
                                You can reach us on +44 1268 271035  for any assistance.<br><br>
                                Team<br>
                                Rolling Components</td>
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