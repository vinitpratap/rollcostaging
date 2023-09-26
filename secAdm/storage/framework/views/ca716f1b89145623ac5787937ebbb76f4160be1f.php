<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Spare OEM</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">S. No.</th>
                                <th class="column-title">Spare Part No.</th>
                                <th class="column-title">OEM</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;?>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="pointer">
                               <td><?php echo e($i++); ?></td>
                                <td><?php echo e($value->spare_num); ?></td>
                                <td><?php echo e($value->oem_num); ?></td>
                                <td class="last"> 
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="<?php echo e(base64_encode($value->spare_num)); ?>_<?php echo e(base64_encode($value->spm_id)); ?>" class="editspare_oem" src="<?php echo e(URL::asset('images/edit.svg')); ?>" alt=""></a> 
                                    <a href="<?php echo e(route('spare_oem.delete',[base64_encode($value->spare_num),base64_encode($value->spm_id)])); ?>" title="Delete" class="d-inline-block delete confirmation"><img src="<?php echo e(URL::asset('images/delete.svg')); ?>" alt=""></a>
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

<div class="row pt-3 viewPrgrp" <?php if((isset($errors) && count($errors) > 0) || (session()->has('message'))){} else echo 'style="display: none"';?>>
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText"> Edit Price</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="oemUpdate" action="<?php echo e(route('spare_oem.edit')); ?>"> 
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="spare_num" id="spare_num" value="<?php echo e(old('spare_num')); ?>">
                <input type="hidden" name="spm_id" id="spm_id" value="<?php echo e(old('spm_id')); ?>">
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
                        <label for="oem_num">OEM</label>
                        <?php if($errors->has('oem_num')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('oem_num')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="oem_num" name="oem_num" placeholder="eg:-1202152" value="<?php echo e(old('oem_num')); ?>" required="required"  >
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitspare_oem">Edit OEM</button></div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>