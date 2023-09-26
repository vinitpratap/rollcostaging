<?php $__env->startSection('content'); ?>

<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText"> Manage Sales Sheets</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="salesSheetRegister" action="<?php echo e(route('salessheet.data')); ?>" enctype="multipart/form-data" > 
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
                <input type="hidden" id="checkflag" value="1">
                <input type="hidden" id="temp_uid">
                <div class="row mt-4">
                    <div class="col-md-4 mb-3 padRig">
                        <label for="requestCurrency">Select Company</label>
                        <select  class="form-control select user_id_sales" id="user_id" name="user_id" required="required" >
                            <option value="">Select Company</option>
                            <?php $__currentLoopData = $cdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value['u_id']); ?>"><?php echo e($value['companyName'] . '('. $value['com_zipCode'].')'); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if(count($tempData) > 0) { ?>
                            <optgroup label="Temp Users">
                            <?php $__currentLoopData = $tempData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="temp_<?php echo e($value['u_id']); ?>"><?php echo e($value['firstName'] .' '.$value['lastName']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </optgroup>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <span class="show-msg"></span>
                
                
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>