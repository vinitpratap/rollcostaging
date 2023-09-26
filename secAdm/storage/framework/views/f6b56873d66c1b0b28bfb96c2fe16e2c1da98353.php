<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Exhibition</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title"> ID</th>
                                <th class="column-title">Name</th>
                                <th class="column-title">Description</th>
                                <th class="column-title">Date</th>
                                <th class="column-title">Place</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $i = 1;?>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="pointer">
                                <td><?php echo e($i++); ?></td>
                                <td><?php echo e($value->exb_nm); ?></td>
                                <td><?php echo e($value->exb_inf); ?></td>
                                <td><?php echo e(date('jS F Y',strtotime($value->exb_date))); ?></td>
                                <td><?php echo e($value->exb_place); ?></td>
                                 <td><?php if($value->exb_status ==1): ?> Enable <?php else: ?> Disable <?php endif; ?></td>
                                <td class="last">
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="<?php echo e(base64_encode($value->exb_id)); ?>" class="editExb" src="<?php echo e(URL::asset('images/edit.svg')); ?>" alt=""></a> 
                                    <a href="<?php echo e(route('exb.delete',base64_encode($value->exb_id))); ?>"  title="Delete" class="d-inline-block delete confirmation"><img src="<?php echo e(URL::asset('images/delete.svg')); ?>" alt=""></a>
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
                <h2 id="titleText"> Add News</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="exbRegister" action="<?php echo e(route('exb.register')); ?> " enctype="multipart/form-data"> 

                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="exb_id" id="exb_id">
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
                    <div class="col-md-12 mb-3 padRig">
                        <label for="exb_nm">Name</label>
                        <?php if($errors->has('exb_nm')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('exb_nm')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="exb_nm" name="exb_nm" placeholder="Exhibition name"  >
                    </div>
                    
                </div>
                <div class="row mt-4">
                    <div class="col-md-12 mb-3 padRig">
                        <label for="exb_inf">Description</label>
                        <?php if($errors->has('exb_inf')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('exb_inf')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="exb_inf" name="exb_inf" placeholder="Exhibition Description"  >
                    </div>
                    
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-3 mb-3 padRig">
                        <label for="exb_img"> Image</label>
                        <?php if($errors->has('exb_img')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('exb_img')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input  name="exb_img" type="file" id="serimageInput" >
                    </div>
                    
                    <div class="col-md-3 mb-3 padRig">
                        <label for="exb_date">Date</label>
                        <?php if($errors->has('exb_date')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('exb_date')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="exb_date" name="exb_date" placeholder="Exhibition date"  >
                    </div>
                     <div class="col-md-3 mb-3 padRig">
                        <label for="exb_place">Place</label>
                        <?php if($errors->has('exb_place')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('exb_place')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="exb_place" name="exb_place" placeholder="Exhibition place"  >
                    </div>
                     <div class="col-md-3 mb-3">
                        <label for="status">Status</label>
                        <?php if($errors->has('exb_status')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('exb_status')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <select  class="form-control select " id="exb_status" name="exb_status">
                            <option value="1"  >Enable</option>
                            <option value="0" >Disable</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-3 mb-3 padRig" id="exb_img"></div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitNews">Add </button></div>
                </div>



            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>