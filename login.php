<?php
include 'class/config.php';

if(isset( $_SESSION['u_id']) &&  $_SESSION['u_id'] !=''){
    header("Location: index.php");
}
$err = 0;
$emailErr = $pwdErr = "";
$nrmlErr = "";
$email = $pwd = '';
if (isset($_POST['fsubmit']) && $_POST['fsubmit'] == 1) {
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $err = 1;
        }
    }

    if (empty($_POST["password"])) {
        $pwdErr = "Password is required";
    } else {
        $pwd = test_input($_POST["password"]);
        // check if password is 6 digit minimum
        if (strlen($pwd) < 6) {
            $pwdErr = "Password length is less than 6";
            $err = 1;
        }
    }
    if (!$err) {
        $check_sql = "SELECT u_id,com_emailAddress,firstName,lastName,com_Telephone,g_id,cust_type,report_access,customerID FROM rollco_ms_users WHERE com_emailAddress = '" . $email . "' AND password='" . md5($pwd) . "' AND user_status = 2 LIMIT 1";
        $numsrow = $sq->numsrow($check_sql);
        if ($numsrow > 0) {
            $userdata = $sq->fearr($check_sql);
            $_SESSION['u_id'] = $userdata['u_id'];
            $_SESSION['com_emailAddress'] = $userdata['com_emailAddress'];
            $_SESSION['firstName'] = $userdata['firstName'];
            $_SESSION['lastName'] = $userdata['lastName'];
            $_SESSION['com_Telephone'] = $userdata['com_Telephone']; 
            $_SESSION['g_id'] = $userdata['g_id'];
            $_SESSION['cust_type'] = $userdata['cust_type'];
            $_SESSION['report_access'] = $userdata['report_access'];
            $_SESSION['loginmodal'] = 1;
            $_SESSION['customerID'] = $userdata['customerID'];
            echo "<script>window.location='index.php';</script>";
        } else {
            $check_sql = "SELECT u_id,com_emailAddress,firstName,lastName,com_Telephone FROM rollco_ms_users WHERE com_emailAddress = '" . $email . "' AND password='" . md5($pwd) . "' AND user_status = 0 LIMIT 1";
            $numsrow = $sq->numsrow($check_sql);
            if ($numsrow > 0) {
                $nrmlErr = "Your account is in verification...Please wait";
            } else {
                $nrmlErr = "The username or password you entered is incorrect";
            }
        }
    }
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Rollco: Login </title>
        <link rel="shortcut icon" type="image/x-icon" href="favicon.png">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' />
        <link href="https://fonts.googleapis.com/css?family=Montserrat:200i,300,300i,400,400i,500,500i,600,600i,700i,700" rel="stylesheet">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-grid.min.css?v=2.3">
        <link rel="stylesheet" href="css/bootstrap-reboot.css?v=2.3">
        <link rel="stylesheet" href="css/login.css?v=2.3">
    </head>

    <body class="no-scroll">
        <section class="clearfix logArea">

            <div class="position-absolute">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 ">
                            <div class="row d-flex justify-content-center">
                                <div class="col-9 col-lg-5 col-md-5 col-sm-6  pl-3 pl-md-5 order-sm-1 order-md-1 order-lg-1 order-2 logNav">
                                    <ul>
                                        <li>Electrical</li>
                                        <li>ENGINE MANAGEMENT</li>
                                        <li>BRAKE</li>
                                        <li>STEERING & SUSPENSION</li>
                                        <!--<li>ENGINE MANAGEMENT</li>-->
                                        <li>TRANSMISSION</li>
                                        <!--<li>COOLING & HEATING</li>-->
                                        <!--<li>TURBOS</li>-->
                                        <li>SPARE PARTS</li>

                                    </ul>


                                </div>

                               <div class="col-12 col-lg-5 col-md-7 col-sm-6 ml-md-auto mr-0 mt-md-5 align-self-right signIn order-sm-2 order-md-2 order-lg-2 order-1 mb-3 ">
                                    <div class="bg-white pl-3 pt-3 pr-3">
                                        <form method="post" id="rollco_login_form">

                                            <div class="row ">
                                                <div class="col-12 text-center pb-4"> <img src="images/logo.svg" class="img-fluid d-inline-block" alt=""></div>
                                                <div class="col-12">
                                                    <h1 class=" pb-3">Welcome, Please Sign in</h1>
                                                </div>
                                            </div>
                                            <?php
                                            if (strlen($nrmlErr) > 1) {
                                                ?>
                                                <div class="error-msg" style="color: #ef4135!important;"><?php echo $nrmlErr; ?></div>
                                            <?php } ?>
                                            <input type="hidden" name="fsubmit" value="1">
                                            <div class="row d-flex pb-3">
                                                <div class="col-md-4 col-12 align-self-center text-right">
                                                    <label for="login">Email:</label>
                                                </div>
                                                <div class="col-md-8 col-12">
                                                    <input type="text" class="form-control" id="email" name="email" autocomplete="off">
                                                    <?php
                                                    if (strlen($emailErr) > 1) {
                                                        ?>
                                                    <div class="error-msg" style="color: #ef4135!important;"><?php echo $emailErr; ?></div>
                                                    <?php } ?>
                                                </div> 


                                            </div>
                                            <div class="row d-flex pb-3">
                                                <div class="col-md-4 col-12 align-self-center text-right">
                                                    <label for="password">Password:</label>
                                                </div>
                                                <div class="col-md-8 col-12">
                                                    <input type="password" class="form-control" id="password" name="password">
                                                    <?php
                                                    if (strlen($pwdErr) > 1) {
                                                        ?>
                                                        <div class="error-msg" style="color: #ef4135!important;"><?php echo $pwdErr; ?></div>
                                                    <?php } ?>
                                                </div> 

                                                <div class="col-12 pt-3">
                                                    <input type="submit" class="form-control submit "  id="submit" value="Login">

                                                </div>


                                            </div>
                                            <div class="row bg-light p-3 text-center">



                                                <div class="col-12"> <p><a href="forgot-password.php" class="d-block"><span class="d-block">Forgot Password? Click here</span></a>
<!--                                                    <a href="#" class="d-block"><span class="d-block"> Activation request <strong>Click here</strong></span> </a></p></div>-->



                                                <div class="col-12"><p class="texUpp mb-0"><strong><a href="create-account.php" class="d-block">Sign up for New Customer</a></strong></p></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

        <script src="js/jquery.min.js" type="text/javascript"></script> 
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/jquery.validate.js" type="text/javascript"></script>
        <script src="js/customFormValidation.js" type="text/javascript"></script> 
    </body>


    <script>


    </script>
</html>
