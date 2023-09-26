<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage User Category</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Category ID</th>
                                <th class="column-title">User Category</th>
                                <th class="column-title">Category Info</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $i = 1; ?>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="pointer">
                                <td><?php echo e($i++); ?></td>
                                <td><?php echo e($value->cust_cat_nme); ?></td>
                                <td><?php echo e($value->cust_cat_info); ?></td>
                                <td><?php if($value->cust_cat_status ==1): ?> Enable <?php else: ?> Disable <?php endif; ?></td>
                                <td class="last">
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="<?php echo e(base64_encode($value->cust_cat_id)); ?>" class="editUserCat" src="<?php echo e(URL::asset('images/edit.svg')); ?>" alt=""></a> 
                                    <a href="<?php echo e(route('usercategory.delete',base64_encode($value->cust_cat_id))); ?>"  title="Delete" class="d-inline-block delete confirmation"><img src="<?php echo e(URL::asset('images/delete.svg')); ?>" alt=""></a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                </div>
                <?php if (count($data) > 0) { ?>
                    <div class="row  m-0">
                        <?php $routeValues = '?search=' . app('request')->input('search'); ?>
                        <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="<?php echo e(route('customercat.export',$routeValues)); ?>" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="<?php echo e(URL::asset('images/excel.svg')); ?>" class="pr-2" alt="Export to Excel"> Export to Excel </a></div>

                    </div>
                <?php } ?>
            </div>


        </div>
    </div>
</div>

<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText"> Add User Category</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="userCatRegister" action="<?php echo e(route('usercategory.register')); ?> "> 

                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="cust_cat_id" id="cust_cat_id">
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
                        <label for="locationName">User Category</label>
                        <?php if($errors->has('cust_cat_nme')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('cust_cat_nme')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="cust_cat_nme" name="cust_cat_nme" placeholder="eg:-Distributer"  >
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                        <label for="locationName">Category Info</label>
                        <?php if($errors->has('cust_cat_info')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('cust_cat_info')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="cust_cat_info" name="cust_cat_info" placeholder="eg:-Distributer"  >
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label>
                        <?php if($errors->has('cust_cat_status')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('cust_cat_status')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <select  class="form-control select " id="cust_cat_status" name="cust_cat_status">
                            <option value="1"  >Enable</option>
                            <option value="0" >Disable</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitLocation">Add </button></div>
                </div>



            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>