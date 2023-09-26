<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Product Group</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">S. No.</th>
                                <th class="column-title">Group</th>
                                <th class="column-title">Part No.</th>
                                <th class="column-title">Price</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;?>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="pointer">
                               <td><?php echo e($i++); ?></td>
                                <td><?php echo e($value->getGroup[0]->gr_nm); ?></td>
                                <td><?php echo e($value->part_nm); ?></td>
                                <td><?php echo e($value->pr_price); ?></td>
                                <td class="last"> 
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="<?php echo e(base64_encode($value->gr_id)); ?>_<?php echo e(base64_encode($value->grp_id)); ?>" class="editProductsgroup" src="<?php echo e(URL::asset('images/edit.svg')); ?>" alt=""></a> 
                                    <a href="<?php echo e(route('productsgroup.delete',[base64_encode($value->gr_id),base64_encode($value->grp_id)])); ?>" title="Delete" class="d-inline-block delete confirmation"><img src="<?php echo e(URL::asset('images/delete.svg')); ?>" alt=""></a>
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
            <form method="post" id="priceUpdate" action="<?php echo e(route('productsgroup.edit')); ?>"> 
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="gr_id" id="gr_id" value="<?php echo e(old('gr_id')); ?>">
                <input type="hidden" name="grp_id" id="grp_id" value="<?php echo e(old('grp_id')); ?>">
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
                        <label for="locationName">Part No.</label>
                        <?php if($errors->has('part_nm')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('part_nm')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="part_nm" name="part_nm" placeholder="eg:-ALT100" value="<?php echo e(old('part_nm')); ?>" required="required"  >
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                        <label for="locationName">Price</label>
                        <?php if($errors->has('pr_price')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('pr_price')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="pr_price" name="pr_price" placeholder="eg:-100" value="<?php echo e(old('pr_price')); ?>" required="required"  >
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitProductGroup">Edit Price</button></div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>