<?php include("class/config.php"); ?>
<!doctype html>
<html>
    <head>
        <?php include("inc-head.php"); ?>
    </head>

    <body class="creatAcount">
        <?php include("inc-header.php"); ?>
        <section class="clearfix cataloGue">
            <article class="clearfix  aos-item fastEasy" data-aos='fade-up'>
                <div class="container mob-pad">
                    <div class="row m-0">
                        <div id="cataloGue" class="position-relative text-center w-100">
                            <div class="col-12 p-0"> <img src="images/create-account.jpg"  alt="create account" class="img-fluid w-100"> </div>
                            <div class="position-absolute col-lg-10 p-5 top-0">
                                <h1 class="text-white text-left pl-5 font28">FAST, EASY ORDERING STARTS HERE<br>

                                    <strong>Complete our one-time registration<br>
                                        process for fast ordering and checkout.</strong> </h1>
                            </div>
                        </div> 
                    </div>
                </div>
            </article>
            <article class="clearfix padB200  creatAccouText aos-item" data-aos='fade-up'>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-md-12 pt-4 pb-5">
                            <form method="post" action="save_account.php" id="rollco_reg_form" enctype="multipart/form-data">
                                <input type="hidden" value="1" name="fsubmit">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="h1  font-weight-normal pb-2 color-58595b">Create an Account</h2>
                                        <p class="creatTExt">Welcome to rollingcomponents.com</p>
                                        <p class="creatTExt pb-3"> Our simple one-time registration process will make ordering parts quick and easy.</p>
                                    </div>
                                </div>
                                <div class="form-submit-msg">
                                    <?php if (isset($_GET['success'])) { ?>

                                        <?php
                                        if ($_GET['success'] == 0) {
                                            ?>
                                            <div class="msg" style="color: #ef4135 !important;">There is some problem while creating your account.</div>
                                        <?php } ?>
                                        <?php
                                        if ($_GET['success'] == 1) {
                                            ?>
                                            <div class="msg" style="color: #ef4135 !important;">User successfully created , please check your mail.</div>
                                        <?php } ?>

                                        <?php
                                        if ($_GET['success'] == 3) {
                                            ?>
                                            <div class="msg" style="color: #ef4135 !important;">The file you have uploaded have some error.</div>
                                        <?php } ?>

                                        <?php
                                        if ($_GET['success'] == 4) {
                                            ?>
                                            <div class="msg" style="color: #ef4135 !important;">This emailid already exist. Please use another emailid to create account.</div>
                                        <?php } ?>

                                    <?php } ?>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <p class="creatTExt pb-2">Personal Information</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-5 col-12 pb-4">
                                        <label for="chooseOption font-weight-500">I would describe myself or my business as<span class="text-color">*</span></label>
                                        <select class="form-control" id="chooseOption" name="chooseOption" >
                                            <option>Please choose an option</option>
                                            <option value="limited">Limited Co.</option>
                                            <option value="soleProprietor">Sole Proprietor</option>
                                            <option value="Partnership">Partnership</option>
                                        </select>
                                    </div>
                                </div>

                                <!--<div class="row">
                                    <div class="col-md-5 col-12 pb-4">
                                        <label for="firstName">First Name</label>
                                        <input type="text" name="firstName"  class="form-control" id="firstName" placeholder=" eg -:First Name" autocomplete="off">
                                    </div>
                                    <div class="col-md-5 col-12 pb-4">
                                        <label for="lastName">Last Name</label>
                                        <input type="text" name="lastName" class="form-control" id="lastName" placeholder=" eg -:Last Name" autocomplete="off">
                                    </div>
                                </div>

                                <div class="row">
                                <?php /* ?><div class="col-md-3 col-4 pb-4">
                                  <label for="companyName">Company Name *</label>
                                  <input type="text" name="companyName"  class="form-control" id="companyName" placeholder=" eg -:Company Name">
                                  </div><?php */ ?>
                                    <div class="col-md-5 col-12 pb-4">
                                        <label for="streetAddress1">Street Address 1<span class="text-color">*</span></label>
                                        <input type="text" name="streetAddress1" class="form-control" id="streetAddress1" placeholder=" eg -:House No." autocomplete="off">
                                    </div>
                                    <div class="col-md-5 col-12 pb-4">
                                        <label for="streetAddress2">Street Address 2<span class="font-weight-light">(optional)</span></label>
                                        <input type="text" name="streetAddress2" class="form-control" id="streetAddress2" placeholder=" eg -:Street / Locality/ Building Name" autocomplete="off">
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-md-3 col-12 pb-3">
                                        <label for="city">City</label>
                                        <input type="text" name="com_city"  class="form-control" id="city" placeholder=" eg -:City" autocomplete="off">
                                    </div>
                                    <div class="col-md-3 col-12 pb-3">
                                        <label for="state">State</label>
                                        <input type="text" name="com_state" class="form-control" id="state" placeholder=" eg -:State" autocomplete="off">
                                    </div>
                                    <div class="col-md-3 col-12 pb-3">
                                        <label for="zipCode">Zip Code<span class="text-color">*</span></label>
                                        <input type="text" name="com_zipCode" class="form-control" id="zipCode" placeholder=" eg -:Zip Code" autocomplete="off">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-5 col-12 pb-4">
                                        <label for="Telephone">Telephone</label>
                                        <input type="text" name="com_Telephone" class="form-control" id="Telephone" placeholder=" eg -:01440 702815" autocomplete="off" onKeyUp="if (/\D/g.test(this.value))
                                                    this.value = this.value.replace(/\D/g, '')">
                                    </div>

                                    <div class="col-md-5 col-12 pb-4">
                                        <label for="Fax">Fax</label>
                                        <input type="text" name="com_Fax" class="form-control" id="Fax" placeholder=" eg -: 011-91" autocomplete="off" onKeyUp="if (/\D/g.test(this.value))
                                                    this.value = this.value.replace(/\D/g, '')">
                                    </div>

                                </div>-->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="creatTExt pt-2 pb-1">Company Information</p>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-md-5 col-12 pb-4">
                                        <label for="companyName">Company Name<span class="text-color">*</span></label>
                                        <input type="text" name="companyName"  class="form-control" id="companyName" placeholder=" eg -:ABC Pvt. Ltd"  autocomplete="off">
                                    </div>

                                    <!--<div class="col-md-5 col-12 pb-4">
                                        <label for="ZipPostCode">Company Website </label>
                                        <input type="text" name="companyWebsite"  class="form-control" id="Website" placeholder=" eg -:www.abc.com" autocomplete="off">
                                    </div>-->

                                </div>

                                <div class="row">
                                    <div class="col-md-5 col-12 pb-4">
                                        <label for="RegistrationNumber">Registration Number</label>
                                        <input type="text" name="companyRegistrationNumber" class="form-control" id="RegistrationNumber" placeholder=" eg -:11540284" autocomplete="off">
                                    </div>

                                    <div class="col-md-5 col-12 pb-4">
                                        <label for="VatNumber">VAT Registration Number</label>
                                        <input type="text" name="companyVatNumber" class="form-control" id="VatNumber" placeholder=" eg -:303095438" autocomplete="off">
                                    </div>

                                    <!--<div class="col-md-5 col-12 pb-4">
                                        <label for="PartnersDirectors">How old Is your company / Business</label>
                                        <input type="text" name="companyAge"  class="form-control" id="PartnersDirectors" placeholder=" eg -:5" autocomplete="off" onKeyUp="if (/\D/g.test(this.value))
                                                    this.value = this.value.replace(/\D/g, '')">
                                    </div>-->

                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <p class="creatTExt pt-2 pb-1">Company Registered Office Address</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-12 pb-4">
                                        <label for="Address1">Address 1<span class="text-color">*</span></label>
                                        <input type="text" name="companyRegAdd1"  class="form-control" id="companyRegAdd1" placeholder=" eg -:House No." autocomplete="off">
                                    </div>

                                    <div class="col-md-4 col-12 pb-4">
                                        <label for="Address2">Address 2</label>
                                        <input type="text" name="companyRegAdd2"  class="form-control" id="companyRegAdd2" placeholder=" eg -:Street / Locality/ Building Name" autocomplete="off">
                                    </div>

                                    <div class="col-md-4 col-12 pb-4">
                                        <label for="City">County</label>
                                        <input type="text" name="companyRegCity"  class="form-control" id="companyRegCity" placeholder=" eg -:County" autocomplete="off">
                                    </div>

                                    <div class="col-md-4 col-12 pb-4">
                                        <label for="State">Town</label>
                                        <input type="text" name="companyRegState"  class="form-control" id="companyRegState" placeholder=" eg -:Town" autocomplete="off">
                                    </div>

                                    <div class="col-md-4 col-12 pb-4">
                                        <label for="ZipPostCode">Post Code<span class="text-color">*</span></label>
                                        <input type="text" name="companyRegZip"  class="form-control" id="companyRegZip" placeholder=" eg -:CB983A" autocomplete="off">
                                    </div>

                                    <div class="col-md-4 col-12 pb-4">
                                        <label for="ZipPostCode">Contact Person Name</label>
                                        <input type="text" name="companyAccountPerName"  class="form-control" id="companyAccountPerName" placeholder=" " autocomplete="off">
                                    </div>



                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <p class="creatTExt pt-2 pb-1">Login Information</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-5 col-12 pb-4">
                                        <label for="emailAddress">Email Address<span class="text-color">*</span></label>
                                        <input type="email" name="com_emailAddress"  class="form-control" id="com_emailAddress" placeholder=" eg -:Email Address" autocomplete="off">
                                    </div>
                                    <div class="col-md-5 col-12 pb-4">
                                        <label for="confirmEmail">Confirm Email Address<span class="text-color">*</span></label>
                                        <input type="email" name="com_confirmEmail" class="form-control" id="confirmEmail" placeholder=" eg -:Confirm Email Address" autocomplete="off">
                                    </div>
                                    <div class="col-md-5 col-12 pb-4">
                                        <label for="password">Password<span class="text-color">*</span></label>
                                        <input type="password" maxlength="15" name="password" id="password" class="form-control" placeholder=" eg -: Password" autocomplete="nope" minlength="6">
                                        <span toggle="#password" class="togglePassword text-danger font14 ">Show</span> </div>
                                    <div class="col-md-5 col-12 pb-3 ">
                                        <label for="confirmPassword">Confirm Password<span class="text-color">*</span></label>
                                        <input type="password" maxlength="15" name="confirmPassword" id="confirmPassword" class="form-control" placeholder=" eg -:Confirm Password"  autocomplete="nope" minlength="6">
                                        <span toggle="#confirmPassword" class="togglePassword text-danger font14">Show</span> </div>
                                </div>









                                <!--<div class="row">
                                    <div class="col-md-7 col-12 pb-2">
                                        <p class="formHead pt-2">Invoice Address :</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-7 col-12 pb-2">
                                        <div class="form-check">
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="sameAbove">
                                                <label class="custom-control-label" for="sameAbove">Same As Above</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-4 col-12 pb-4">
                                        <label for="Address1">Address 1<span class="text-color">*</span></label>
                                        <input type="text" name="companyInvAdd1"  class="form-control invad" id="companyInvAdd1" placeholder=" eg -:House No." autocomplete="off">
                                    </div>

                                    <div class="col-md-4 col-12 pb-4">
                                        <label for="Address2">Address 2</label>
                                        <input type="text" name="companyInvAdd2"  class="form-control invad" id="companyInvAdd2" placeholder=" eg -:Street / Locality/ Building Name" autocomplete="off">
                                    </div>

                                    <div class="col-md-4 col-12 pb-4">
                                        <label for="City">City</label>
                                        <input type="text" name="companyInvCity"  class="form-control invad" id="companyInvCity" placeholder=" eg -:City" autocomplete="off">
                                    </div>

                                    <div class="col-md-4 col-12 pb-4">
                                        <label for="State">State</label>
                                        <input type="text" name="companyInvState"  class="form-control invad" id="companyInvState" placeholder=" eg -:State" autocomplete="off">
                                    </div>

                                    <div class="col-md-4 col-12 pb-4">
                                        <label for="ZipPostCode">Zip / Post Code<span class="text-color">*</span></label>
                                        <input type="text" name="companyInvZip"  class="form-control invad" id="companyInvZip" placeholder=" eg -:CB983A" autocomplete="off">
                                    </div>
                                </div>






                                <div class="disNone partner-style" id="show_partner">
                                    <div class="row">
                                        <div class="col-md-7 col-12 pb-2">
                                            <p class="formHead">For Partnership & Non-Limited companies :</p>
                                        </div>
                                    </div>

                                    <div class="row ">
                                        <div class="col-md-4 col-12 pb-2">
                                            <label for="Name">Name / Partners / Directors</label>
                                            <input type="text" name="companyPartnerName[]"  class="form-control" id="Names" placeholder=" eg -:ABC" autocomplete="off">
                                        </div>

                                        <div class="col-md-4 col-12 pb-2">
                                            <label for="Address">Address 1</label>
                                            <input type="text" name="companyPartnerAdd1[]"  class="form-control" id="Address1" placeholder=" eg -:House No." autocomplete="off">
                                        </div>

                                        <div class="col-md-4 col-12 pb-2">
                                            <label for="Address">Address 2</label>
                                            <input type="text" name="companyPartnerAdd2[]"  class="form-control" id="Address2" placeholder=" eg -:Street / Locality/ Building Name" autocomplete="off">
                                        </div>

                                        <div class="col-md-4 col-12 pb-2">
                                            <label for="City">City</label>
                                            <input type="text" name="companyPartnerCity[]"  class="form-control" id="City" placeholder=" eg -:City" autocomplete="off">
                                        </div>

                                        <div class="col-md-4 col-12 pb-2">
                                            <label for="State">State</label>
                                            <input type="text" name="companyPartnerState[]"  class="form-control" id="State" placeholder=" eg -:State" autocomplete="off">
                                        </div>

                                        <div class="col-md-4 col-12 pb-2">
                                            <label for="ZipPostCode">Zip / Post Code</label>
                                            <input type="text" name="companyPartnerZip[]"  class="form-control" id="ZipPostCode" placeholder=" eg -:CB983A" autocomplete="off">
                                        </div>

                                        <div class="col-12 justify-content-end d-flex pb-2">
                                            <div class="add-more">
                                                <p class="mb-0"><a onClick="addRow()">+ Add More</a></p>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div id="content"></div>




                                <div class="row">
                                    <div class="col-md-8 col-12 pb-2">
                                        <p class="creatTExt pt-2 ">Company Contact Person (Accounts) </p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-12 pb-4">
                                        <label for="Names"> Name</label>
                                        <input type="text" name="companyAccountPerName"  class="form-control" id="Accounts" placeholder=" eg -:abc" autocomplete="off">
                                    </div>

                                    <div class="col-md-4 col-12 pb-4">
                                        <label for="Address">E-mail ID</label>
                                        <input type="text" name="companyAccountPerEmail"  class="form-control" id="Email" placeholder=" eg -:abc@gmail.com" autocomplete="off">
                                    </div>

                                    <div class="col-md-4 col-12 pb-4">
                                        <label for="PartnersDirectors">Mobile</label>
                                        <input type="text" name="companyAccountPerMobile"  class="form-control" id="Mobile" placeholder=" eg -:XXXXXXXXX" autocomplete="off" onKeyUp="if (/\D/g.test(this.value))
                                                    this.value = this.value.replace(/\D/g, '')">
                                    </div>

                                    <div class="col-md-4 col-12 pb-4">
                                        <label for="Department">Department</label>
                                        <input type="text" name="companyAccountPerDepartment"  class="form-control" id="Department" placeholder=" eg -:abc" autocomplete="off">
                                    </div>
                                </div>




                                <div class="row">
                                    <div class="col-md-8 col-12 pb-2">
                                        <p class="formHead pt-2">Please help us to know you better, ARE YOU A</p>
                                        <p class="text-style">Please tick the appropriate Box below</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8 col-12 pb-4">
                                        <div class="form-check">
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input check" id="MotorFactor" name="role" value="MotorFactor" >

                                                <label class="custom-control-label" for="MotorFactor">Motor Factor</label>
                                            </div>

                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input check" id="Distributor" name="role" value="Distributor" >
                                                <label class="custom-control-label" for="Distributor">Distributor</label>
                                            </div>


                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input check" id="Electricals" name="role" value="Electricals" >

                                                <label class="custom-control-label" for="Electricals">Electricals / Rebuilder</label>
                                            </div>

                                            <div class="custom-control custom-checkbox custom-control-inline" >
                                                <input type="checkbox" class="custom-control-input check" id="Exporter" name="role" value="Exporter" >
                                                <label class="custom-control-label" for="Exporter">Exporter</label>
                                            </div>

                                            <div class="custom-control custom-checkbox custom-control-inline" id="">
                                                <input type="checkbox" class="custom-control-input check" id="check_other" name="role" value="check_other" >
                                                <label class="custom-control-label" for="check_other">Others</label>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-12 pb-4 ">
                                        <input type="text" name="other"  class="form-control disNone" id="other" placeholder=" eg -:" autocomplete="off">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-5 col-lg-4 col-12 pb-4">
                                        <label for="turnover">Your Turnover for the last Financial Year in £ :</label>
                                        <input type="text" name="companyturnover"  class="form-control" id="turnover" placeholder=" eg -:" autocomplete="off" onKeyUp="if (/\D/g.test(this.value))
                                                    this.value = this.value.replace(/\D/g, '')">
                                    </div>

                                    <div class="col-md-3 col-lg-3  col-12 pb-4 ">
                                        <label for="howMany">Do you have any Branches :</label>
                                        <select class="form-control" id="branches" name="companyBranches" onChange="selectBoolean()">
                                            <option value="">Please select</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 col-lg-4 col-12 pb-4 ">
                                        <div class="disNone" id="booleanChoose">
                                            <label for="howMany">How Many</label>
                                             <!--<input type="text" name="turnover"  class="form-control " id="howMany" placeholder=" eg -:3">
                                            <select class="form-control" id="howMany" name="companyBranchesCount" onChange="selectBoolean()">
                                                <option value="">Please select</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                                <option value="">4</option>
                                                <option value="">5</option>
                                                <option value="">6</option>
                                                <option value="">7</option>
                                                <option value="">8</option>
                                                <option value="">9</option>
                                                <option value="">10</option>
                                                <option value="">11</option>
                                                <option value="">12</option>
                                                <option value="">13</option>
                                                <option value="">14</option>
                                                <option value="">15</option>
                                                <option value="">16</option>
                                                <option value="">17</option>
                                                <option value="">18</option>
                                                <option value="">19</option>
                                                <option value="">20</option>
                                            </select>

                                        </div>
                                    </div>

                                </div>



                                <div class="row">
                                    <div class="col-12">
                                        <p class="creatTExt pt-2 pb-1">Bank Details</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-12 pb-4">
                                        <label for="BankName">Name of Bank</label>
                                        <input type="text" name="companyBankName"  class="form-control" id="BankName" placeholder=" eg -:SBI Bank" autocomplete="off">
                                    </div>

                                    <div class="col-md-4 col-12 pb-4">
                                        <label for="BankAddress">Address of Bank</label>
                                        <input type="text" name="companyBankAddress"  class="form-control" id="BankAddress" placeholder=" eg -:ABC Noida" autocomplete="off">
                                    </div>

                                    <div class="col-md-4 col-12 pb-4">
                                        <label for="BankPostCode">Zip / Post Code</label>
                                        <input type="text" name="companyBankPostCode"  class="form-control" id="BankPostCode" placeholder=" eg -:CB983A" autocomplete="off">
                                    </div>

                                    <div class="col-md-4 col-12 pb-4">
                                        <label for="BankAccount">Account Number</label>
                                        <input type="text" name="companyBankAccount"  class="form-control" id="BankAccount" placeholder=" eg -:26122268" autocomplete="off" onKeyUp="if (/\D/g.test(this.value))
                                                    this.value = this.value.replace(/\D/g, '')">
                                    </div>

                                    <div class="col-md-4 col-12 pb-4">
                                        <label for="ContactNumber">Contact Number</label>
                                        <input type="text" name="companyContactNumber"  class="form-control" id="ContactNumber" placeholder=" eg -: ABC" autocomplete="off" onKeyUp="if (/\D/g.test(this.value))
                                                    this.value = this.value.replace(/\D/g, '')">
                                    </div>

                                    <div class="col-md-4 col-12 pb-4">
                                        <label for="SortCode">Sort Code</label>
                                        <input type="text" name="companySortCode"  class="form-control" id="SortCode" placeholder=" eg -:30 - 93 - 99" autocomplete="off">
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col-md-5 col-12 pb-4">
                                        <label for="PrintName">Attached (Signed & Stamp)</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" name="companyAttachedDoc">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>





                                <div id="addName">
                                    <div class="row ">
                                        <div class="col-md-4 col-12 pb-4">
                                            <label for="PrintName">Name</label>
                                            <input type="text" name="companyPrintName[]"  class="form-control" id="PrintName" placeholder=" eg -:Michael Stone" autocomplete="off">
                                        </div>

                                        <div class="col-md-4 col-12 pb-4">
                                            <label for="Position">Position</label>
                                            <input type="text" name="companyPosition[]"  class="form-control" id="Position" placeholder=" eg -:Director" autocomplete="off">
                                        </div>

                                        <div class="col-md-4 col-12 pb-4">
                                            <label for="Date">Date</label>
                                            <input type="text" name="companyDate[]"  class="form-control datepicker" id="companyDate" placeholder=" eg -:06/09/2019" autocomplete="off">
                                        </div>

                                        <div class="col-md-4 col-12 pb-4">
                                            <label for="RollingRepresentative">Rolling Representative</label>
                                            <input type="text" name="RollingRepresentative[]"  class="form-control" id="RollingRepresentative" placeholder=" eg -:ABC" autocomplete="off">
                                        </div>



                                        <div class="col-md-8 col-6 pb-4 justify-content-end d-flex pb-2 align-items-end">
                                            <div class="add-more">
                                                <p class="mb-0"><a onClick="cloneName()">+ Add More</a></p>
                                            </div>
                                        </div>

                                    </div>
                                </div>-->


                                <div class="row">
                                    <!--<div class="col-12 pb-3 pt-3">
                                        <h2 class="pb-3 font-weight-normal">  Email & Cell Phone Preferences</h2>
                                        <p class="font14">  rollingcomponents.com will email you purchase confirmations and status updates for your order.</p>
                                        <p class="font14"> In addition, we can offer you the following services. We will not share your email address with third parties for their independent use.</p>
                                    </div>

                                    <div class="form-check col-12 pb-3 pl-3">
                                        <input type="checkbox" class="form-check-input ml-0" id="rollingComponents" name="offerRollco">
                                        <label class="form-check-label font14 pl-4" for="rollingComponents">Please email me product information, offers and incentives from Rolling Components.</label>
                                    </div>

                                    <div class="form-check col-12 pb-3 pl-3">
                                        <input type="checkbox" class="form-check-input ml-0" id="participatingCarriers" name="participatingCarriers">
                                        <label class="form-check-label font14 pl-4" for="participatingCarriers">Please notify me of periodic rollingcomponents.com special offers by sending text messages, or mobile alerts.
                                            Standard text messaging and other rates apply. Certain services available only on participating carriers.</label>
                                    </div>-->

                                    <div class="col-sm-6 pb-4 pt-3">
                                        <div class="g-recaptcha" data-sitekey="6LdrHuUUAAAAAOyNWBdwxQFBJf5LqZCHM70Ud5aR"></div>
                                    </div>
                                    <div class="form-check col-12 pb-4 pl-3">
                                        <input type="checkbox" class="form-check-input ml-0" id="termsConditions" name="termsConditions">
                                        <label class="form-check-label font14 pl-4" for="termsConditions">I have read and agree to the rollingcomponents.com <a href="https://www.rollingcomponents.com/terms_and_conditions.php" class="text-danger" target="_blank">Terms and Conditions</a></label>
                                    </div>
                                    <div class="col-sm-6 col-12 pb-3">
                                        <input type="submit" name="submit" value="Create Account" class="form-control submit" >
                                    </div>

                                </div>



                            </form>
                        </div>
                    </div>
                </div>    
            </article></section>



        <?php include("inc-footer.php"); ?>

        <script>
            jQuery.validator.addClassRules("required", {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            });
            jQuery.validator.addMethod("alphanumeric", function (value, element) {
                return this.optional(element) || /^[\w .,&-]+$/i.test(value);
            }, "Letters and numbers only please");
            
            jQuery.validator.addMethod("mintwo", function (value, element) {
                if(value.length < 5){
                    
                }
                return this.optional(element) || /^[a-zA-Z0-9.,&-]+(?:\s[a-zA-Z0-9.,&-]+)+$/.test(value.trim());
            }, "Please enter full address");

            jQuery.validator.addMethod("alpha", function (value, element) {
                return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
            }, "Letters only please");

            var tagCheckRE = new RegExp("(\\w+)(\\s+)(\\w+)");

            jQuery.validator.addMethod("tagcheck", function (value, element) {
                return tagCheckRE.test(value);
            }, "At least two words.");
            
            
            $('#rollco_reg_form').validate({// initialize the plugin
                rules: {
                    firstName: {

                        alpha: true
                    },
                    lastName: {

                        alpha: true
                    },
                    streetAddress1: {
                        required: true,
                        alphanumeric: true,
                        mintwo:true
                    },
                    com_city: {

                        alpha: true
                    },
                    com_state: {

                        alpha: true
                    },
                    com_zipCode: {
                        required: true,
                        alphanumeric: true
                    },
                    com_Telephone: {

                        alphanumeric: true
                    },
                    com_Fax: {

                        alphanumeric: true
                    },
                    com_emailAddress: {
                        required: true,
                        email: true,
                    },
                    com_confirmEmail: {
                        required: true,
                        email: true,
                        equalTo: "#com_emailAddress"
                    },
                    companyName: {
                        required: true,
                        alphanumeric: true
                    },
                    companyRegistrationNumber: {
                        alphanumeric: true
                    },
                    companyVatNumber: {
                        alphanumeric: true
                    },
                    companyAge: {
                        alphanumeric: true
                    },
                    companyRegAdd1: {
                        required: true,
                        alphanumeric: true,
                        maxlength:50,
                        minlength:5,
                    },
                    companyRegAdd2: {
                        alphanumeric: true
                    },
                    companyRegCity: {
                        alphanumeric: true
                    },
                    companyRegState: {
                        alphanumeric: true
                    },
                    companyRegZip: {
                        required: true,
                        alphanumeric: true
                    },
                    companyInvAdd1: {
                        required: true,
                        alphanumeric: true
                    },
                    companyInvAdd2: {
                        alphanumeric: true
                    },
                    companyInvCity: {
                        alphanumeric: true
                    },
                    companyInvState: {
                        alphanumeric: true
                    },
                    companyInvZip: {
                        required: true,
                        alphanumeric: true
                    },
                    'companyPartnerName[]': {
                        alphanumeric: true
                    },
                    'companyPartnerAdd1[]': {
                        alphanumeric: true
                    },
                    'companyPartnerAdd2[]': {
                        alphanumeric: true
                    },
                    'companyPartnerCity[]': {
                        alphanumeric: true
                    },
                    'companyPartnerState[]': {
                        alphanumeric: true
                    },
                    'companyPartnerZip[]': {
                        alphanumeric: true
                    },
                    'companyAccountPerName': {
                        alphanumeric: true
                    },
                    'companyAccountPerEmail': {
                        email: true
                    },
                    'companyAccountPerMobile': {
                        alphanumeric: true
                    },
                    'companyAccountPerDepartment': {
                        alphanumeric: true
                    },
                    'companyturnover': {
                        alphanumeric: true
                    },
                    'companyBranches': {
                        alphanumeric: true
                    },
                    'companyBankName': {
                        alphanumeric: true
                    },
                    'companyBankAddress': {
                        alphanumeric: true
                    },
                    'companyBankPostCode': {
                        alphanumeric: true
                    },
                    'companyBankAccount': {
                        alphanumeric: true
                    },
                    'companyContactNumber': {
                        alphanumeric: true
                    },
                    'companySortCode': {
                        alphanumeric: true
                    },
                    'companyPrintName[]': {
                        alphanumeric: true
                    },
                    'companyPosition[]': {
                        alphanumeric: true
                    },
                    'RollingRepresentative[]': {
                        alphanumeric: true
                    },
                    'termsConditions': {
                        required: true,
                        alphanumeric: true
                    },

                    'chooseOption': {
                        required: true,
                    },

                    password: {
                        required: true,
                        minlength: 6,
                        alphanumeric: true
                    },
                    confirmPassword: {
                        required: true,
                        minlength: 6,
                        alphanumeric: true,
                        equalTo: "#password"
                    },
                },
            });


            $(document).ready(function () {
                $("#check_other").click(function () {
                    $("#other").toggleClass("disBlock");
                });
                $('.check').click(function () {
                    $('.check').not(this).prop('checked', false);
                });


                $(".togglePassword").click(function () {
                    $(this).toggleClass("eyeIcon eyeSlash");
                    var input = $($(this).attr("toggle"));
                    if (input.attr("type") == "password") {
                        $(this).text('Hide');
                        input.attr("type", "text");
                    } else {
                        $(this).text('Show');
                        input.attr("type", "password");
                    }
                });
            });

            /*function partnership() {
             var show_partner = document.getElementById("chooseOption").value;
             if (show_partner == "Partnership") {
             document.getElementById("show_partner").style.display = "block";
             } else {
             document.getElementById("show_partner").style.display = "none";
             }
             }*/

            function selectBoolean() {
                var show_$ = "";
                var get_branches = document.getElementById("branches").value;
                //var get_branches = document.getElementById("branches").value;
                if (get_branches == "yes") {
                    document.getElementById("booleanChoose").style.display = "block";
                } else {
                    document.getElementById("booleanChoose").style.display = "none";
                }
            }


            function addRow() {
                document.querySelector('#content').insertAdjacentHTML(
                        'afterbegin',
                        `<div class="row">
                <div class="col-md-4 col-12 pb-2">
                  <label for="Name">Name</label>
                  <input type="text" name="companyPartnerName[]"  class="form-control" id="Names" placeholder=" eg -:ABC" autocomplete="off">
                </div>
            
                <div class="col-md-4 col-12 pb-2">
                  <label for="Address">Address 1</label>
                  <input type="text" name="companyPartnerAdd1[]"  class="form-control" id="Address1" placeholder=" eg -:XYZ Noida" autocomplete="off">
                </div>
			
                             <div class="col-md-4 col-12 pb-2">
                  <label for="Address">Address 2</label>
                  <input type="text" name="companyPartnerAdd2[]"  class="form-control" id="Address2" placeholder=" eg -:XYZ Noida" autocomplete="off">
                </div>
			
                             <div class="col-md-4 col-12 pb-2">
                  <label for="City">City</label>
                  <input type="text" name="companyPartnerCity[]"  class="form-control" id="City" placeholder=" eg -:City" autocomplete="off">
                </div>
            
                <div class="col-md-4 col-12 pb-2">
                  <label for="State">State</label>
                  <input type="text" name="companyPartnerState[]"  class="form-control" id="State" placeholder=" eg -:State" autocomplete="off">
                </div>
            
               <!-- <div class="col-md-3 col-6 pb-2">
              
                </div>-->
            
                 <div class="col-md-4 col-12 pb-2">
                  <label for="ZipPostCode">Zip / Post Code</label>
                  <input type="text" name="companyPartnerZip[]"  class="form-control" id="ZipPostCode" placeholder=" eg -: CB983A" autocomplete="off">
                </div>
			
                            <p onclick="removeRow(this)" class="text-right w-100 d-block pr-3 pl-3 remPoint"><a>- Remove</a></p>
        </div>`
                        )
            }

            function removeRow(input) {
                input.parentNode.remove()
            }


        </script>

        <script>
            function cloneName() {
                document.querySelector('#addName').insertAdjacentHTML(
                        'afterend',
                        `<div class="row add-style">
                   <div class="col-md-4 col-12 pb-4">
                   <label for="PrintName">Name<span class="text-color">*</span></label>
                     <input type="text" name="companyPrintName[]"  class="form-control" id="PrintName" placeholder=" eg -:Michael Stone" autocomplete="off">
                   </div>
            
                   <div class="col-md-4 col-12 pb-4">
                   <label for="Position">Position<span class="text-color">*</span></label>
                     <input type="text" name="companyPosition[]"  class="form-control" id="Position" placeholder=" eg -:Director" autocomplete="off">
                   </div>
            
                   <div class="col-md-4 col-12 pb-4">
                       <label for="Date">Date<span class="text-color">*</span></label>
                     <input type="text" name="companyDate[]"  class="form-control datepicker" id="Date" placeholder=" eg -:06/09/2019" autocomplete="off">
                   </div>
            
                    <div class="col-md-4 col-12 pb-4">
                     <label for="RollingRepresentative">Rolling Representative</label>
                     <input type="text" name="RollingRepresentative[]"  class="form-control" id="RollingRepresentative" placeholder=" eg -:ABC" autocomplete="off">
                   </div>
            
                   <div class="col-md-4 col-6 pb-4">
             
                   </div>
            
                   <p onclick="removeRow(this)" class="text-right w-100 d-block pr-3 pl-3 remPoint mtNeg"><a>- Remove</a></p>
            
                   </div>`
                        )
            }

            function removeRow(input) {
                input.parentNode.remove()
            }
            $(document).ready(function () {

                $('.datepicker').each(function () {
                    $(this).daterangepicker({
                        autoUpdateInput: false,
                        singleDatePicker: true,
                        singleClasses: "picker_1",
                        locale: {
                            format: "YYYY-MM-DD",
                        }
                    });
                    $(this).on('apply.daterangepicker', function (ev, picker) {
                        $(this).val(picker.startDate.format('YYYY-MM-DD'));

                        $(this).daterangepicker({
                            autoUpdateInput: false,
                            singleDatePicker: true,
                            singleClasses: "picker_1",
                            locale: {
                                format: "YYYY-MM-DD",
                            }
                        });

                        $(this).on('apply.daterangepicker', function (ev, picker) {
                            $(this).val(picker.startDate.format('YYYY-MM-DD'));
                        });
                    });
                });



            });
            $("#sameAbove").change(function () {
                if (this.checked) {
                    $('.invad').prop('readonly', 'true');
                    $('#companyInvAdd1').val($('#companyRegAdd1').val());
                    $('#companyInvAdd2').val($('#companyRegAdd2').val());
                    $('#companyInvCity').val($('#companyRegCity').val());
                    $('#companyInvState').val($('#companyRegState').val());
                    $('#companyInvZip').val($('#companyRegZip').val());
                } else {
                    $('.invad').prop('readonly', 'false');
                    $('.invad').val('');
                }
            });
        </script>




    </body>
</html>