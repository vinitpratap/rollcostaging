<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>View Order Details</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">S. No.</th>
                                <th class="column-title">Order No</th>
                                <th class="column-title">Part No.</th>
                                <th class="column-title">Make</th>
                                <th class="column-title">OEM</th>
                                <th class="column-title">Qty.</th>
                                <th class="column-title">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $value->getOrderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $okey=>$ovalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php $prName = getprName($ovalue->prod_id); ?>

                            <tr class="pointer">
                                <td><?php echo e($i++); ?></td>
                                <td><?php echo e($value->order_no); ?></td>
                                <td><?php echo e($prName); ?></td>
                                <td><?php echo e(getMakeByProductID($ovalue->prod_id)); ?></td>
                                <td><?php echo e(getProductOEM($prName)); ?></td>
                                <td><?php echo e($ovalue->prod_qty); ?></td>
                                <td><?php echo e($value->price_sign .' '.$ovalue->prod_price); ?></td>
                                
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <span class="totalPriceSpan">Total price : <strong><?php echo e($value->price_sign .' '.$value->totalprice); ?></strong></span>
            </div>
            
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <form method="post" id="GroupRegister" action="<?php echo e(route('order.edit')); ?>" enctype="multipart/form-data" > 
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="order_id" id="order_id" value="<?php echo e($value->order_id); ?>">
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
                        <label for="status">Status</label>
                        <?php if($errors->has('order_status')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('order_status')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <select  class="form-control select " id="order_status" name="order_status">
                            <option value="1" <?php if($value->order_status=='1'): ?> selected="selected" <?php endif; ?>>Open</option>
                            <option value="3" <?php if($value->order_status==3): ?> selected="selected" <?php endif; ?>>Pending</option>
                            <option value="2" <?php if($value->order_status==2): ?> selected="selected" <?php endif; ?>>Processing</option>
                            <option value="4" <?php if($value->order_status==4): ?> selected="selected" <?php endif; ?>>Hold</option>
                            <option value="5" <?php if($value->order_status==5): ?> selected="selected" <?php endif; ?>>Complete</option>
                            <option value="6" <?php if($value->order_status==6): ?> selected="selected" <?php endif; ?>>Closed</option>
                            <option value="7" <?php if($value->order_status==7): ?> selected="selected" <?php endif; ?>>Canceled</option>
                        </select>
                    </div>


                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix">
                        <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitOrder">Update </button>

                        <a href="<?php echo e(route('order.manage')); ?> "><button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitOrder">Back</button></a>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>