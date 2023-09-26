

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Categories</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Category ID</th>
                                <th class="column-title">Master Category Name</th>
                                <th class="column-title">Category Name</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $i = 1;?>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="pointer">
                               <td><?php echo e($i++); ?></td>
                                <td><?php echo e($value->getMCategory['mcat_nm']); ?></td>
                                <td><?php echo e($value->cat_nm); ?></td>
                                <td><?php if($value->cat_status ==1): ?> Enable <?php else: ?> Disable <?php endif; ?></td>
                                <td class="last">
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="<?php echo e(base64_encode($value->cat_id)); ?>" class="editCategory" src="<?php echo e(URL::asset('images/edit.svg')); ?>" alt=""></a> 
                                    <a href="<?php echo e(route('category.delete',base64_encode($value->cat_id))); ?>"  title="Delete" class="d-inline-block delete confirmation"><img src="<?php echo e(URL::asset('images/delete.svg')); ?>" alt=""></a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="clearfix"></div>
            <div class="row  m-0">
                <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="javascript:void(0);" onclick="scrollToCustomerForm();" class="btn btn-outline-secondary  pl-4 pr-4 pt-2 pb-2  m-0" id="addNewRequest"> Add New Category </a></div>
            </div>


        </div>
    </div>
</div>

<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText"> Add Category</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="categoryRegister" action="<?php echo e(route('category.register')); ?>" enctype="multipart/form-data"> 

                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="cat_id" id="cat_id">
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
                    <div class="col-md-4 mb-3">
                        <label for="mcatid">Master Category</label>
                        <select  class="form-control select" id="mcatid" name="mcatid">
                            <option value="">Select</option>
                            <?php $__currentLoopData = $mcategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value['mcat_id']); ?>" ><?php echo e($value['mcat_nm']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                        <label for="cat_nm">Category</label>
                        <?php if($errors->has('cat_nm')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('cat_nm')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="cat_nm" name="cat_nm" placeholder="eg:-Alternator"  >
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label>
                        <?php if($errors->has('cat_status')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('cat_status')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <select  class="form-control select " id="cat_status" name="cat_status">
                            <option value="1">Enable</option>
                            <option value="0">Disable</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12 col-lg-12  mb-3">            
                        <label for="description">Description</label>
                        <?php if($errors->has('cat_detail')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('cat_detail')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <textarea class="form-control"  rows="10" placeholder="Description" id="cat_detail" name="cat_detail" ></textarea>
                    </div>

                </div>
                <div class="row mt-4">
                    <div class="col-lg-12 col-lg-12  mb-3">            
                        <label for="description">Catalog Description</label>
                        <?php if($errors->has('cat_catlog')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('cat_catlog')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <textarea class="form-control"  rows="10" placeholder="Description" id="cat_catlog" name="cat_catlog" ></textarea>
                    </div>

                </div>
                <div class="row mt-4">
                    <div class="col-md-4 mb-3 padRig">
                        <label for="cat_imageInput"> Image </label>
                        <?php if($errors->has('cat_image')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('cat_image')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input  name="cat_image" type="file" id="cat_imageInput" >
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-3 mb-3 padRig" id="cat_image"></div>
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitCategory">Add </button></div>
                </div>



            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>