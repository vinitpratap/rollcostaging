<?php $__env->startSection('content'); ?>


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Sales Person</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <!--<th class="column-title">Sales ID</th>-->
                                <th class="column-title">Name</th>
                                <th class="column-title">Email</th>
                                <th class="column-title">Telephone</th>
                                <th class="column-title">Date</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>


                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="pointer">
                                <!--<td><?php echo e($value->code); ?></td>-->
                                <td><?php echo e($value->firstName . ' ' . $value->lastName); ?></td>
                                <td><?php echo e($value->com_emailAddress); ?></td>
                                <td> <?php echo e($value->com_Telephone); ?></td>
                                <td>
                                    <?php echo date("d M Y",strtotime($value->created_at)); ?>

                                </td>
                                <td>
                                    <?php
                                    if ($value->user_status == 2) {
                                        echo 'Approved';
                                    }else if ($value->user_status == 1) {
                                        echo 'Pending';
                                    }else{
                                        echo 'Blocked';
                                    }
                                    ?>
                                </td>
                                <td class="last">
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="<?php echo e(base64_encode($value->u_id)); ?>"  class="editSubAdmin" src="<?php echo e(URL::asset('images/edit.svg')); ?>" alt=""></a> 
                                    <a href="<?php echo e(route('sales.delete',base64_encode($value->u_id))); ?>"  title="Delete" class="d-inline-block delete confirmation"><img src="<?php echo e(URL::asset('images/delete.svg')); ?>" alt=""></a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                </div>

            </div>


        </div>
    </div>
</div>

<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText" >Add New Sales</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="subAdminRegister" action="<?php echo e(route('subadmin.subAdmin_register')); ?>"> 

                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="id" id="subadmin_id" >
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
                    <div class="col-md-4 mb-3 padRig">
                        <label for="SubAdmin">Sales Name</label>
                        <input type="text" class="form-control " autocomplete="off" id="subadminName" name="user_name" placeholder="Your Name" value="" >
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                        <label for="requestEmailID">Email ID</label>
                        <input type="text" class="form-control" id="requestEmailID" autocomplete="off" name="email" placeholder="Your Email ID" value="" >
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="requestMobile">Phone</label>
                        <input type="tel" class="form-control" id="requestMobile"  autocomplete="off" name="mobile" placeholder="Your Phone No" value="" >
                    </div>
                </div>


                <div class="row mt-4">
                    <div class="col-md-4 mb-3 align-self-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="report_access" class="custom-control-input all_flag" id="flag_report" value="1">
                            <label class="custom-control-label" for="flag_report">Report Access</label>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label>
                        <select  class="form-control select"  id="status" name="status">
                            <option value="0"  >Blocked</option>
                            <option value="1" >Pending</option>
                            <option value="2" >Approved</option>
                        </select>
                    </div>

                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix">
                        <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitSubAdmin">Add Sales</button>

                    </div>

                </div>

            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>