

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Group</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Group ID</th>
                                <th class="column-title">Group Name</th>
                                <th class="column-title">Currency</th>
                                <th class="column-title">No. of Parts</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;?>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $prCount = getTotalProdCount($value->gr_id);?>
                            
                            <tr class="pointer">
                               <td><?php echo e($i++); ?></td>
                                <td><?php echo e($value->gr_nm); ?></td>
                                <td><?php echo e($value->getCurrency[0]->curr_name); ?></td>
                                <td><?php if($prCount>0): ?><a href="<?php echo e(route('productgroup.manage',base64_encode($value->gr_id))); ?>"><?php echo e($prCount); ?></a> <?php else: ?> 0  <?php endif; ?></td>
                                <td><?php if($value->gr_status ==1): ?> Enable <?php else: ?> Disable <?php endif; ?></td>
                                <td class="last">
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="<?php echo e(base64_encode($value->gr_id)); ?>" class="editGroup" src="<?php echo e(URL::asset('images/edit.svg')); ?>" alt=""></a> 
                                    <a href="<?php echo e(route('group.delete',base64_encode($value->gr_id))); ?>"  title="Delete" class="d-inline-block delete confirmation"><img src="<?php echo e(URL::asset('images/delete.svg')); ?>" alt=""></a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row  m-0">
                <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="<?php echo e(route('group.export')); ?>" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="<?php echo e(URL::asset('images/excel.svg')); ?>" class="pr-2" alt="Export to Excel"> Export to Excel </a></div>
            </div>
        </div>
    </div>
</div>
<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText"> Add Group</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="GroupRegister" action="<?php echo e(route('group.register')); ?>" enctype="multipart/form-data" > 
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="gr_id" id="gr_id">
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
                        <label for="locationName">Group</label>
                        <?php if($errors->has('gr_nm')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('gr_nm')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="groupName" name="gr_nm" placeholder="eg:-Group" required="required"  >
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                        <label for="requestCurrency">Currency</label>
                        <select  class="form-control select" id="gr_currency" name="gr_currency" required="required">
                            <option value="">Select currency</option>
                            <?php $__currentLoopData = $currency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value['curr_id']); ?>"><?php echo e($value['curr_name']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label>
                        <?php if($errors->has('gr_status')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('gr_status')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <select  class="form-control select " id="curr_status" name="gr_status">
                            <option value="1"  >Enable</option>
                            <option value="0" >Disable</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3 ">
                        <label for="productgroup_file"> File (CSV Only)</label>
                        <input  name="productgroup_file" type="file" id="productgroup_file" >
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix">
                        <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitGroup">Add </button>
                        <a href="<?php echo e(URL('Demo')); ?>/demo-group-product-price.csv"><button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="downloadspearOEM">Download </button></a>
                    
                        <p class="pt-4">Please first download file and don't change cell header</p>
                    
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>