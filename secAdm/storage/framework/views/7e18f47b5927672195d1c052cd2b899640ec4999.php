<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Deleted Customers</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content  mb-3 col-12 clearfix">

                <div class="table-responsive-md collRquest pb-4">
                    <?php if(count($errors) > 0): ?>
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.								
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p><?php echo e($error); ?></p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>								
                    </div>
                    <?php endif; ?>
                    <?php if(session()->has('message')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session()->get('message')); ?>

                    </div>
                    <?php endif; ?>
                    <form method="get">
                        <div class="row mt-4">
                            <div class="col-md-4 mb-3 padRig">
                                <label>&nbsp;</label>
                                <input type="text" placeholder="Search by" name="search"  autocomplete="off" class="form-control" value="<?php echo e(app('request')->input('search')); ?>">
                            </div>

                            <div class="col-md-4 mb-3 padRig">
                                <label>Show Entries</label>
                                <select class="form-control select" id="data_entries" name="data_entries" >                                    <?php $__currentLoopData = $pagination_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val); ?>" <?php if (app('request')->input('data_entries') == $val) { ?> selected <?php } ?>><?php echo e($val); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 pt-35 padRig">
                                <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase">Search</button>
                            </div>



                        </div>
                        <?php echo e(csrf_field()); ?>


                    </form>
                    <table id="datatable1" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Customers ID</th>
                                <th class="column-title">Name</th>
                                <th class="column-title">Mobile</th>
                                <th class="column-title">Address</th>
                                <th class="column-title">City</th>
                                <th class="column-title">Email</th>
                                <th class="column-title">ZIP</th>
                                <th class="column-title">Registered on</th>
                                <th class="column-title">Status</th>
<!--                                <th class="column-title">Check All (Delete) &nbsp; <input type="checkbox" class="deleteCross" id="checkAll"></th>-->
                                <th class="column-title">Action</th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php if (count($data) > 0) { ?>
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="pointer">
                                    <td><?php echo e($value->u_id); ?></td>
                                    <td><?php echo e($value->companyName); ?></td>
                                    <td><?php echo e($value->com_Telephone); ?></td>
                                    <td class="whiteSpace"><?php echo e($value->streetAddress1); ?></td>
                                    <td class="whiteSpace"><?php echo e($value->com_city); ?> </td>
                                    <td><?php echo e($value->com_emailAddress); ?></br>
                                        
                                    </td>
                                    <td><?php echo e($value->com_zipCode); ?></td>
                                    <td><?php echo e(date("jS M Y H:i:s", strtotime($value->created_at))); ?></td>
                                    <td>
                                        <?php
                                        if ($value->user_status == 1) {
                                            ?>
                                            Pending
                                            <?php
                                        } elseif ($value->user_status == 2) {
                                            ?>
                                            Active
                                        <?php } else { ?>
                                            Blocked
                                        <?php } ?>
                                        </br>
                                        
                                    </td>
                                    <!--<td class="last"><input type="checkbox" class="deleteCrossref" id="<?php echo e($value->crossref_id); ?>"></td>-->
                                    <td  class="last">
                                        <a href="javascript:void(0);" title="Restore" class="mr-4 ml-2 d-inline-block"><img data-id="<?php echo e(base64_encode($value->u_id)); ?>" class="restoreDelCustomer" src="<?php echo e(URL::asset('images/restore-user.png')); ?>" alt=""></a> 
                                        <a href="<?php echo e(route('deluser.delete',base64_encode($value->u_id))); ?>"  title="Delete" class="d-inline-block delete confirmation"><img src="<?php echo e(URL::asset('images/delete.svg')); ?>" alt=""></a>
                                    </td>

                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php } else { ?>
                                <tr class="pointer">
                                    <td colspan="6" style="text-align: center">
                                        No customer data
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <?php echo e($data->links('common.custompagination')); ?>



                <?php if (count($data) > 0) { ?>
                    <div class="row  m-0">
                        <?php $routeValues = ''; ?>
                        <div class="col-6"><span>Total  <?php echo e($data->total()); ?> records</span></div>
                        <div class="col-6 text-right pl-0 pr-0 pb-3 clearfix"><a href="<?php echo e(route('delcustomer.export',$routeValues)); ?>" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="<?php echo e(URL::asset('images/excel.svg')); ?>" class="pr-2" alt="Export to Excel"> Export Deleted Customers </a></div>

                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>


<div class="col-lg-12 col-md-12 col-12 cust-form" style="display: none;">
    <div class="x_panel newRequestForm">
        <div class="x_title">
            <h2 id="titleText">Add New Customer</h2>
            <div class="clearfix"></div>
        </div>
        <form method="post" id="custRegister" action=" <?php echo e(route('customer.register')); ?>"> 

            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="u_id" id="u_id">
            <?php if(count($errors) > 0): ?>
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.								
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p><?php echo e($error); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>								
            </div>
            <?php endif; ?>
            <?php if(session()->has('message')): ?>
            <div class="alert alert-success">
                <?php echo e(session()->get('message')); ?>

            </div>
            <?php endif; ?>
            <div class="row mt-4">
                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName">First Name</label>
                    <input type="text" class="form-control" autocomplete="off" id="requestFName" name="firstName"  value="" >
                </div>
                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName">Last Name</label>
                    <input type="text" class="form-control" autocomplete="off" id="requestLName" name="lastName"  value="" >
                </div>
                <div class="col-md-3 mb-3 padRig">
                    <label for="requestLocation">Category</label>
                    <select  class="form-control select" id="custcatid" name="role" required="required">
                        <option value="">Select Category</option>
                        <?php $__currentLoopData = $catData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value['cust_cat_nme']); ?>"><?php echo e($value['cust_cat_nme']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3 padRig">
                    <label for="requestEmailID">Email ID *</label>
                    <input type="text" class="form-control" autocomplete="off" id="com_emailAddress" name="com_emailAddress" value="" >
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName">Street Address 1</label>
                    <input type="text" class="form-control" autocomplete="off" id="streetAddress1" name="streetAddress1"  value="" >
                </div>
                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName">Street Address 2</label>
                    <input type="text" class="form-control" autocomplete="off" id="streetAddress2" name="streetAddress2"  value="" >
                </div>

                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName">City</label>
                    <input type="text" class="form-control" autocomplete="off" id="com_city" name="com_city"  value="" >
                </div>

                <div class="col-md-3 mb-3 padRig">
                    <label for="requestEmailID">State</label>
                    <input type="text" class="form-control" autocomplete="off" id="com_state" name="com_state"  value="" >
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4 mb-3 padRig">
                    <label for="requestName">Zip Code</label>
                    <input type="text" class="form-control" autocomplete="off" id="com_zipCode" name="com_zipCode"  value="" >
                </div>
                <div class="col-md-4 mb-3 padRig">
                    <label for="requestName">Telephone</label>
                    <input type="text" class="form-control" autocomplete="off"  onkeyup="if (/\D/g.test(this.value))
                                this.value = this.value.replace(/\D/g, '')" id="com_Telephone" name="com_Telephone"  value="" >
                </div>

                <div class="col-md-4 mb-3 padRig">
                    <label for="requestName">Fax</label>
                    <input type="text" class="form-control" autocomplete="off" id="com_Fax" name="com_Fax"  value="" >
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName">Company Name</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyName" name="companyName"  value="" >
                </div>
                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName">Company Website </label>
                    <input type="text" class="form-control" autocomplete="off" id="companyWebsite" name="companyWebsite"  value="" >
                </div>

                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName">Registration Number</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyRegistrationNumber" name="companyRegistrationNumber"  value="" >
                </div>

                <div class="col-md-3 mb-3 padRig">
                    <label for="requestEmailID">VAT Registration Number</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyVatNumber" name="companyVatNumber"  value="" >
                </div>
            </div>
            <h8 id="titleText">Company Registered Office Address</h8>
            <div class="row mt-4">

                <div class="col-md-2 mb-3 padRig">
                    <label for="requestName">Address 1</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyRegAdd1" name="companyRegAdd1"  value="" >
                </div>
                <div class="col-md-2 mb-3 padRig">
                    <label for="requestName">Address 2</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyRegAdd2" name="companyRegAdd2"  value="" >
                </div>

                <div class="col-md-2 mb-3 padRig">
                    <label for="requestName"> City</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyRegCity" name="companyRegCity"  value="" >
                </div>

                <div class="col-md-2 mb-3 padRig">
                    <label for="requestName"> State</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyRegState" name="companyRegState"  value="" >
                </div>

                <div class="col-md-2 mb-3 padRig">
                    <label for="requestName">Zip / Post Code</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyRegZip" name="companyRegZip"  value="" >
                </div>

            </div>
            <h8 id="titleText">Company Invoice Office Address</h8>
            <div class="row mt-4">
                <div class="col-md-2 mb-3 padRig">
                    <label for="requestName">Address 1</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyInvAdd1" name="companyInvAdd1"  value="" >
                </div>
                <div class="col-md-2 mb-3 padRig">
                    <label for="requestName">Address 2</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyInvAdd2" name="companyInvAdd2"  value="" >
                </div>

                <div class="col-md-2 mb-3 padRig">
                    <label for="requestName"> City</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyInvCity" name="companyInvCity"  value="" >
                </div>

                <div class="col-md-2 mb-3 padRig">
                    <label for="requestName"> State</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyInvState" name="companyInvState"  value="" >
                </div>

                <div class="col-md-2 mb-3 padRig">
                    <label for="requestName">Zip / Post Code</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyInvZip" name="companyInvZip"  value="" >
                </div>

            </div>
            <h8 id="titleText"> Company Contact Person (Accounts) </h8>
            <div class="row mt-4">

                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName">Name</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyAccountPerName" name="companyAccountPerName"  value="" >
                </div>
                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName">E-mail ID</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyAccountPerEmail" name="companyAccountPerEmail"  value="" >
                </div>

                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName"> Mobile</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyAccountPerMobile" name="companyAccountPerMobile"  value="" onkeyup="if (/\D/g.test(this.value))
                                this.value = this.value.replace(/\D/g, '')">
                </div>

                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName"> Department</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyAccountPerDepartment" name="companyAccountPerDepartment"  value="" >
                </div>


            </div>


            <h8 id="titleText">Bank Details</h8>
            <div class="row mt-4">

                <div class="col-md-4 mb-3 padRig">
                    <label for="requestEmailID">Bank Name</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyBankName" name="companyBankName" value="" >
                </div>
                <div class="col-md-4 mb-3 padRig">
                    <label for="requestAddress">Bank Address</label>
                    <input type="text" class="form-control" id="companyBankAddress" autocomplete="off" name="companyBankAddress"  value="" >
                </div>
                <div class="col-md-4 mb-3">
                    <label for="requestAddress2">Zip / Post Code</label>
                    <input type="text" class="form-control" id="companyBankPostCode" autocomplete="off" name="companyBankPostCode"  value="" >
                </div>

            </div>

            <div class="row mt-4">
                <div class="col-md-4 mb-3 padRig">
                    <label for="requestEmailID">Account Number</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyBankAccount" name="companyBankAccount" value="" onkeyup="if (/\D/g.test(this.value))
                                this.value = this.value.replace(/\D/g, '')">
                </div>
                <div class="col-md-4 mb-3 padRig">
                    <label for="requestAddress">Contact Number</label>
                    <input type="text" class="form-control" id="companyContactNumber" autocomplete="off" name="companyContactNumber"  value="" >
                </div>
                <div class="col-md-4 mb-3">
                    <label for="requestAddress2">Sort Code</label>
                    <input type="text" class="form-control" id="companySortCode" autocomplete="off" name="companySortCode"  value="" >
                </div>

            </div>
            <div class="row mt-4">


                <div class="col-md-3 mb-3 padRig">
                    <label for="requestLocation">Account Code</label>
                    <input type="text" class="form-control" id="customerID" autocomplete="off" name="customerID"  value=""  required>
                </div>


                <div class="col-md-3 mb-3 padRig">
                    <label for="requestLocation">Group</label>
                    <select  class="form-control select" id="grp_id" name="g_id" required="required">
                        <option value="">Select Group</option>
                        <?php $__currentLoopData = $groupData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value['gr_id']); ?>"><?php echo e($value['gr_nm']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>


                <div class="col-md-3 mb-3">
                    <label for="status">Status</label>
                    <?php if($errors->has('cust_status')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('user_status')); ?></strong>
                    </span>
                    <?php endif; ?>
                    <select  class="form-control select " id="cust_status" name="user_status">
                        <option value="2"  >Active</option>
                        <option value="1"  >Pending</option>
                        <option value="0" >Blocked</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="status">Calendar</label>
                    <?php if($errors->has('cal_show')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('cal_show')); ?></strong>
                    </span>
                    <?php endif; ?>
                    <select  class="form-control select " id="cal_show" name="cal_show">
                        <option value="0" >Hide</option>
                        <option value="1" >Show</option>
                    </select>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-3 mb-3">
                    <label for="status">Verify</label>
                    <select  class="form-control select " id="c_verified" name="c_verified">
                        <option value="0" >Pending</option>
                        <option value="1" >Active</option>
                    </select>
                </div>
            </div>


            <div class="row mt-4">
                <div class="col-12  pb-3 clearfix"><div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitCust">Add </button></div>
                </div>



        </form>
    </div>
</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>