<?php
include 'class/config.php';
if (!isset($_SESSION['u_id'])) {
    header("Location: index.php");
}
$u_id = $_SESSION['u_id'];
$checkuser_sql = "SELECT u_id,chooseOption,firstName,lastName,com_Telephone,com_Fax,com_emailAddress,streetAddress1,streetAddress2,com_city,com_state,com_zipCode FROM rollco_ms_users WHERE u_id = '" . $u_id . "' AND user_status = 2";
$numsrow = $sq->numsrow($checkuser_sql);
if ($numsrow > 0) {
    $userdata = $sq->fearr($checkuser_sql);
}
?>
<!doctype html>
<html>
    <head>
        <?php include("inc-head.php"); ?>
    </head>

    <body class="myAccountDetail" >
        <?php include("inc-header.php"); ?>
        <section class="clearfix cataloGue">
            <?php /* ?> <?php
              if (isset($_SESSION['u_id']) && $_SESSION['u_id'] != '') {
              include("inc-afterlogin-userdetails.php");
              }
              ?><?php */ ?>

            <article class="clearfix aos-item bestChoice" data-aos='fade-up'>
                <div class="container">
                    <div id="cataloGue" class="position-relative text-center subHead prlogin"> <img src="images/login-page-products.jpg"  alt="banner" class="img-fluid w-100">
                        <div class="position-absolute text-left pl-5">
                            <h2 class="text-white electri">
                                <hr class="mb-2">
                                BEST CHOICE<br>
                                FOR SPARE PARTS </h2>
                        </div>
                    </div>
                </div>
            </article>


            <article class="pb-5 mt-5 mb-5 acctDetails creatAccouText ">
                <div class="container pb-5 ">                    
                    <div class="row pb-5 justify-content-center">
                        <div class="col-lg-10 pb-5 accountInfo">
                            <ul class="nav nav-tabs nav-justified">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#personalInfo">Personal info</a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#AddRess">Manage Addresses</a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#chanpassword">Change password</a> </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane container active" id="personalInfo">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6 col-12 pb-4">
                                                <label for="myBusiness">I would describe myself or my business as</label>
                                                <input type="text" name="chooseOption"  class="form-control" id="chooseOption" value="<?php if (isset($userdata['chooseOption']) && $userdata['chooseOption'] != '')
                echo $userdata['chooseOption'];
            ?>" disabled >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-12 pb-3">
                                                <label for="firstName">First Name</label>
                                                <input type="text" name="firstName"  class="form-control" id="firstName" value="<?php if (isset($userdata['firstName']) && $userdata['firstName'] != '')
                                                           echo $userdata['firstName'];
            ?>" disabled>
                                            </div>
                                            <div class="col-md-6 col-12 pb-3">
                                                <label for="lastName">Last Name</label>
                                                <input type="text" name="lastName" class="form-control" id="lastName" value="<?php if (isset($userdata['lastName']) && $userdata['lastName'] != '')
                                                           echo $userdata['lastName'];
            ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-12 pb-3">
                                                <label for="Telephone">Telephone</label>
                                                <input type="text" name="com_Telephone" class="form-control" id="com_Telephone"  value="<?php if (isset($userdata['com_Telephone']) && $userdata['com_Telephone'] != '')
                                                           echo $userdata['com_Telephone'];
            ?>" disabled>
                                            </div>
                                            <div class="col-md-6 col-12 pb-3">
                                                <label for="Fax">Fax</label>
                                                <input type="text" name="com_Fax" class="form-control" id="com_Fax"  value="<?php if (isset($userdata['com_Fax']) && $userdata['com_Fax'] != '')
                                                           echo $userdata['com_Fax'];
            ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-12 pb-3">
                                                <label for="emailAddress">Email Address</label>
                                                <input type="email" name="com_emailAddress"  class="form-control" id="com_emailAddress"  value="<?php if (isset($userdata['com_emailAddress']) && $userdata['com_emailAddress'] != '')
                                                           echo $userdata['com_emailAddress'];
            ?>" disabled>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!--<address>-->

                                <div class="tab-pane container fade" id="AddRess">     

                                    <form method="post" id="changeaddress_form" >
                                        <div class="sucess-msg successaddress"></div>
                                        <div class="partner-style" id="show_partner">
                                            <div class="row">
                                                <div class="col-md-7 col-12 pb-2">
                                                    <p class="formHead">Primary Address</p>
                                                </div>
                                            </div>

                                            <div class="row ">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-md-6 col-12 pb-4">
                                                            <label for="streetAddress1">Street Address 1</label>
                                                            <input type="text" name="streetAddre1" class="form-control" id="streetAddre1" value="<?php if (isset($userdata['streetAddress1']) && $userdata['streetAddress1'] != '')
                                                           echo $userdata['streetAddress1'];
            ?>" readonly>
                                                        </div>
                                                        <div class="col-md-6 col-12 pb-4">
                                                            <label for="streetAddress2">Street Address 2 </label>
                                                            <input type="text" name="streetAddre2" class="form-control" id="streetAddre2" value="<?php if (isset($userdata['streetAddress2']) && $userdata['streetAddress2'] != '')
                                                           echo $userdata['streetAddress2'];
            ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4 col-12 pb-4">
                                                            <label for="city">City</label>
                                                            <input type="text" name="city"  class="form-control" id="city" value="<?php if (isset($userdata['com_city']) && $userdata['com_city'] != '')
                                                                       echo $userdata['com_city'];
            ?>" readonly>
                                                        </div>
                                                        <div class="col-md-4 col-12 pb-4">
                                                            <label for="state">State</label>
                                                            <input type="text" name="state" class="form-control" id="state" value="<?php if (isset($userdata['com_state']) && $userdata['com_state'] != '')
                                                                       echo $userdata['com_state'];
            ?>" readonly>
                                                        </div>
                                                        <div class="col-md-4 col-12 pb-4">
                                                            <label for="zipCode">Zip Code</label>
                                                            <input type="text" name="zipCode" class="form-control" id="zipCode" value="<?php if (isset($userdata['com_zipCode']) && $userdata['com_zipCode'] != '')
                                                                       echo $userdata['com_zipCode'];
            ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 justify-content-end d-flex pb-2">

                                                    <div class="otheraddress w-100" id="otheraddress">

                                                    </div>
                                                </div>
                                                <div class="col-12 justify-content-end d-flex pb-2">
                                                    <div class="add-more">
                                                        <p class="mb-0"><a onClick="addRow()">+ Add More</a></p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div id="content"></div>

                                        <div class="col-lg-1 col-md-2 col-sm-2 col-4 text-right ml-auto pr-0 d-flex pb-2 ">  <input type="submit"  class="btn saveButton w-100" value="Save"></div>
                                    </form>

                                </div>
                                <!--<password>-->

                                <div class="tab-pane container fade" id="chanpassword">
                                    <form method="post" id="changepassword_form" >
                                        <div class="sucess-msg successpass"></div>
                                        <div class="row">
                                            <div class="col-md-6 col-12 pb-3">
                                                <label for="oldpassword"> Old Password</label>
                                                <input type="password" maxlength="15" name="oldpassword" id="oldpassword" class="form-control" placeholder="Old Password" autocomplete="nope">
                                                <div class="error-msg oldpassworderror"></div>

                                                <span toggle="#oldpassword" class="togglePassword text-danger font14 ">Show</span> </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-12 pb-3">
                                                <label for="password">Password</label>
                                                <input type="password" maxlength="15" name="password" id="password" class="form-control" placeholder="password" autocomplete="nope">
                                                <span toggle="#password" class="togglePassword text-danger font14 ">Show</span> </div>
                                            <div class="col-md-6 col-12 ">
                                                <label for="confirmPassword">Confirm Password</label>
                                                <input type="password" maxlength="15" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Confirm Password"  autocomplete="nope">
                                                <span toggle="#confirmPassword" class="togglePassword text-danger font14">Show</span> </div>
                                        </div>
                                        <div class="row ">
                                            <div class="col-md-3 col-12 pb-4">
                                                <input type="submit" class="btn chanAddres chng w-100" name="change_password" value="Change password" >
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </section>
<?php include("inc-footer.php"); ?>
        <script>
            jQuery.validator.addClassRules("required", {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            });
            jQuery.validator.addMethod("alphanumeric", function (value, element) {
                return this.optional(element) || /^[\w]+$/i.test(value);
            }, "Letters and numbers only please");
            
            jQuery.validator.addMethod("passwordcheck", function (value, element) {
                return this.optional(element) || /^[\w]+$/i.test(value);
            }, "Letters and numbers only please");

            jQuery.validator.addMethod("alphabetsAndSpacesOnly", function (value, element) {
                return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
            }, "Only Letters");

            jQuery.validator.addMethod("alphabetsAndSpacesnumbOnly", function (value, element) {
                return this.optional(element) || /^[\w\s]+$/.test(value);
            }, "Only Letters");

            $('#changepassword_form').validate({// initialize the plugin
                rules: {
                    oldpassword: {
                        required: true,
                        minlength: 6,
                        //alphanumeric: true
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        //alphanumeric: true
                    },
                    confirmPassword: {
                        required: true,
                        minlength: 6,
                        //alphanumeric: true,
                        equalTo: "#password"
                    },
                },
            });
            $('#changeaddress_form').validate({// initialize the plugin
                rules: {
                    'addresstype1[]': {
                        alphabetsAndSpacesOnly: true,
                        required: true

                    },
                    'streetAddress1[]': {
                        required: true,
                        alphabetsAndSpacesnumbOnly: true
                    },
                    'streetAddress2[]': {
                        required: true,
                        alphabetsAndSpacesnumbOnly: true
                    },
                    'com_city[]': {
                        alphabetsAndSpacesOnly: true,
                        required: true,
                    },
                    'com_state[]': {
                        alphabetsAndSpacesOnly: true,
                        required: true
                    },
                    'com_zipCode[]': {
                        required: true,
                        alphanumeric: true
                    },
                },
            });

            $(document).ready(function () {
                $(".togglePassword").click(function () {
                    $(this).toggleClass("eyeIcon eyeSlash");
                    var input = $($(this).attr("toggle"));
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                });
            });

            $(function () {

                $('#changepassword_form').on('submit', function (e) {
                    if ($("#changepassword_form").valid()) {
                        e.preventDefault();
                        $('.oldpassworderror').html('');
                        $('.successpass').html('');
                        $.ajax({
                            type: 'post',
                            url: "ajax/getchangepassword.php",
                            data: $('#changepassword_form').serialize(),
                            success: function (data) {
                                var html = '';
                                var data = JSON.parse(data);
                                if (data.status == 1) {
                                    $('.oldpassworderror').html('');
                                    $('.successpass').html(data.data);
                                    $('.successpass').delay(5000).fadeOut('slow');
                                    $('#changepassword_form').trigger("reset");
                                }
                                if (data.status == 2) {
                                    $('.successpass').html('');
                                    $('.oldpassworderror').html(data.data);
                                    $('.oldpassworderror').delay(5000).fadeOut('slow');
                                }
                                $('.loading').hide();
                            }
                        });
                    }
                });
            });


            $(function () {
                $('#changeaddress_form').on('submit', function (e) {
                    if ($("#changeaddress_form").valid()) {
                        e.preventDefault();
                        $('.successaddress').html();
                        $.ajax({
                            type: 'post',
                            url: "ajax/changeaddress.php",
                            data: $('#changeaddress_form').serialize(),
                            success: function (data) {
                                var html = '';
                                var data = JSON.parse(data);
                                if (data.status == 1) {
                                    document.querySelectorAll(".newclass").forEach(e => e.parentNode.removeChild(e));
                                    addaddress();
                                    $('.successaddress').html(data.data);
                                    $('.successaddress').delay(5000).fadeOut('slow');
                                    $('#changeaddress_form').trigger("reset");

                                }
                                if (data.status == 2) {
                                    $('.successaddress').html(data.data);
                                    $('.successaddress').delay(5000).fadeOut('slow');
                                }
                            }
                        });
                    }
                });
            });
            addaddress();
            function addaddress() {
                $('#otheraddress').html('');
                $.ajax({
                    type: 'get',
                    url: "ajax/getuserotheraddress.php",
                    data: {data: '1'},
                    success: function (data) {
                        var html = '';
                        var data = JSON.parse(data);
                        if (data.status == 1) {
                            $.each(data.data, function (index, item) {
                                html += '<div class="row " style="margin-top:20px "><div class="col-md-7 col-12 pb-2"><p class="formHead">Other Address ' + (index + 1) + '</p></div><div class="col-lg-12"><div class="row"><div class="col-md-4 col-12 pb-3"><label for="myBusiness">Address Type </label><input type="text" name="addresstype1[]" class="form-control" id="addresstype1" value="' + item.addresstypeother + '"></div></div><div class="row"><div class="col-md-6 col-12 pb-4"><label for="streetAddress1">Street Address 1</label> <input type="text" name="streetAddress1[]" class="form-control" id="streetAddress1" value="' + item.streetAddress1other + '"> </div><div class="col-md-6 col-12 pb-4"><label for="streetAddress2">Street Address 2 </label> <input type="text" name="streetAddress2[]" class="form-control" id="streetAddress2" value="' + item.streetAddress2other + '"></div></div><div class="row"><div class="col-md-4 col-12 pb-4"><label for="city">City</label><input type="text" name="com_city[]"  class="form-control" id="com_city" value="' + item.com_cityother + '"></div><div class="col-md-4 col-12 pb-4"><label for="state">State</label><input type="text" name="com_state[]" class="form-control" id="com_state" value="' + item.com_stateother + '"></div> <div class="col-md-4 col-12 pb-4"><label for="zipCode">Zip Code</label><input type="text" name="com_zipCode[]" class="form-control" id="com_zipCode" value="' + item.com_zipCodeother + '"></div></div></div></div><hr style="border: 1px solid red">';
                            });
                            $('#otheraddress').html(html);
                            $('.successaddress').html(data.data);
                            $('#changeaddress_form').trigger("reset");
                        }
                        if (data.status == 2) {
                            $('.successaddress').html(data.data);
                        }
                        $('.loading').hide();
                    }
                });
            }

            function addRow() {
                document.querySelector('#content').insertAdjacentHTML('afterbegin', '<div class="row newclass"><div class="col-lg-12"><div class="row"><div class="col-md-4 col-12 pb-3"><label for="myBusiness">Address Type </label><input type="text" name="addresstype1[]" class="form-control" id="addresstype1" placeholder="Home, Office, etc" ></div> </div><div class="row"><div class="col-md-6 col-12 pb-4"><label for="streetAddress1">Street Address 1</label><input type="text" name="streetAddress1[]" class="form-control" id="streetAddress1" placeholder="House No."></div><div class="col-md-6 col-12 pb-4"><label for="streetAddress2">Street Address 2 </label><input type="text" name="streetAddress2[]" class="form-control" id="streetAddress2" placeholder="Street / Locality/ Building Name"></div></div><div class="row"><div class="col-md-4 col-12 pb-4"><label for="city">City</label><input type="text" name="com_city[]" class="form-control" id="com_city" placeholder="City"></div><div class="col-md-4 col-12 pb-4"><label for="state">State</label><input type="text" name="com_state[]" class="form-control" id="com_state" placeholder="State"></div><div class="col-md-4 col-12 pb-4"><label for="zipCode">Zip Code</label><input type="text" name="com_zipCode[]" class="form-control" id="com_zipCode" placeholder="Zip Code"></div></div></div><p onclick="removeRow(this)" class="text-right w-100 d-block pr-3 pl-3 remPoint"><a>- Remove</a></p></div>');
            }

            function removeRow(input) {
                input.parentNode.remove()
            }
        </script>
    </body>
</html>
