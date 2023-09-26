<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Application</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">S. No.</th>
                                <th class="column-title">Part No.</th>
                                <th class="column-title">MAKE</th>
                                <th class="column-title">MODEL</th>
                                <th class="column-title">YEAR</th>
                                <th class="column-title">CC</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;?>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="pointer">
                               <td><?php echo e($i++); ?></td>
                                <td><?php echo e($value->part_no); ?></td>
                                <td><?php echo e($value->make_nm); ?></td>
                                <td><?php echo e($value->model_nm); ?></td>
                                <td><?php echo e($value->year); ?></td>
                                <td><?php echo e($value->cc); ?></td>
                                <td class="last"> 
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="<?php echo e(base64_encode($value->part_no)); ?>_<?php echo e(base64_encode($value->ap_id)); ?>" class="editproduct-application" src="<?php echo e(URL::asset('images/edit.svg')); ?>" alt=""></a> 
                                    <a href="<?php echo e(route('product_application.delete',[base64_encode($value->part_no),base64_encode($value->ap_id)])); ?>" title="Delete" class="d-inline-block delete confirmation"><img src="<?php echo e(URL::asset('images/delete.svg')); ?>" alt=""></a>
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
            <form method="post" id="applicationUpdate" action="<?php echo e(route('product_application.edit')); ?>"> 
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="part_no" id="part_no" value="<?php echo e(old('part_no')); ?>">
                <input type="hidden" name="ap_id" id="ap_id" value="<?php echo e(old('ap_id')); ?>">
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
                        <label for="make_nm">MAKE</label>
                        <?php if($errors->has('make_nm')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('make_nm')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="make_nm" name="make_nm" placeholder="eg:-1202152" value="<?php echo e(old('make_nm')); ?>" required="required"  >
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                        <label for="model_nm">MODEL</label>
                        <?php if($errors->has('model_nm')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('model_nm')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="model_nm" name="model_nm" placeholder="eg:-1202152" value="<?php echo e(old('model_nm')); ?>" required="required"  >
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                        <label for="year">Year</label>
                        <?php if($errors->has('year')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('year')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="year" name="year" placeholder="eg:-1202152" value="<?php echo e(old('year')); ?>" >
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                        <label for="cc">CC</label>
                        <?php if($errors->has('cc')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('cc')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="cc" name="cc" placeholder="eg:-1202152" value="<?php echo e(old('cc')); ?>" >
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitApplication">Edit Application</button></div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>