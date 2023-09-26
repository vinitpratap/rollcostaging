<?php $__env->startSection('content'); ?>

<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText"> Manage Sales Category Tagging</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="salesSheetRegister" action="<?php echo e(route('salessheetcat.register')); ?>" enctype="multipart/form-data" > 
                <?php echo e(csrf_field()); ?>

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
                <input type="hidden" id="checkflag" value="0">
                <div class="row mt-4">
                    <div class="col-md-4 mb-3 padRig">
                        <label for="requestCurrency">Select Company</label>
                        <select  class="form-control select user_id_sales" id="user_id" name="user_id" required="required" >
                            <option value="">Select Company</option>
                            <?php $__currentLoopData = $cdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value['u_id']); ?>"><?php echo e($value['companyName'] . '('. $value['com_zipCode'].')'); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
<!--                <div class="row mt-4 sscustcat" style="display: none">
                    <div class="col-md-4 mb-3 padRig">
                       <label>Account No</label>
                       <h6 id="grp_name"></h6>
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                       <label>Post Code</label>
                       <h6 id="post_code"></h6>
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                       <label>Email</label>
                       <h6 id="user_email"></h6>
                    </div>
                </div>
                <div class="row mt-4 sscustcat" style="display: none">
                    <div class="col-md-4 mb-3 padRig">
                       <label>Phone No</label>
                       <h6 id="user_phone_no"></h6>
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                       <label>Buying Group</label>
                       <h6 id="user_buying_grp"></h6>
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                       <label>Account opened date</label>
                       <h6 id="user_acnt_date"></h6>
                    </div>
                </div>-->
                <span class="sscustcat" style="display: none;"> Sales Category </span>
                <div class="row mt-4 sscustcat" style="display: none;">
                    <?php $__currentLoopData = $custCatData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k =>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col mb-3 align-self-center mt-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="custCat[]" class="custom-control-input all_flag" id="flag_<?php echo e($v->sc_id); ?>" value="<?php echo e($v->sc_id); ?>">
                            <label class="custom-control-label" for="flag_<?php echo e($v->sc_id); ?>"><?php echo e($v->scat_nm); ?></label>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
                <div class="row mt-4" id="dynamic_div_sales">

                </div>
                <div class="row mt-4 sscustcat" style="display: none;">
                    <div class="col-12  pb-3 clearfix">
                        <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitGroup">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>