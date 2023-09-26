<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Engine Code</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <form method="get">
                        <div class="row mt-4">
                            <div class="col-md-4 mb-3 padRig">
                                <input type="text" placeholder="Search by" name="search"  autocomplete="off" class="form-control" value="<?php echo e(app('request')->input('search')); ?>">
                            </div>
                            <div class="col-md-4 mb-3 padRig">
                                <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase">Search</button>
                            </div>
                            
                        </div>
                            <?php echo e(csrf_field()); ?>


                    </form>
                    <table class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Sr No</th>
                                <th class="column-title">Category</th>
                                <th class="column-title">Make</th>
                                <th class="column-title">Model</th>
                                <th class="column-title">Year</th>
                                <th class="column-title">Exact CCM</th>
                                <th class="column-title">Engine Code</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $i = 1; ?>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr class="pointer">
                                <td><?php echo e($i++); ?></td>
                                <td><?php echo e(getCatName($value->catid)); ?></td>
                                <td><?php echo e(getMakeName($value->makeid)); ?></td>
                                <td><?php echo e(getModelName($value->modelid)); ?></td>
                                <td><?php echo e(getProYear($value->proyrid)); ?></td>
                                <td><?php echo e(getProCCM($value->proccmid)); ?></td>
                                <td><?php echo e($value->engcode_inf); ?></td>
                                <td><?php if($value->engcode_status ==1): ?> Enable <?php else: ?> Disable <?php endif; ?></td>
                                <td class="last">
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="<?php echo e(base64_encode($value->engcode_id)); ?>" class="editEngcode" src="<?php echo e(URL::asset('images/edit.svg')); ?>" alt=""></a> 
                                    <a href="<?php echo e(route('engcode.delete',base64_encode($value->engcode_id))); ?>"  title="Delete" class="d-inline-block delete confirmation"><img src="<?php echo e(URL::asset('images/delete.svg')); ?>" alt=""></a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                </div>

            </div>
                    <?php echo e($data->links('common.custompagination')); ?>

            <div class="clearfix"></div>
            <div class="row  m-0">
                <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="javascript:void(0);" onclick="scrollToCustomerForm();"  class="btn btn-outline-secondary  pl-4 pr-4 pt-2 pb-2  m-0" id="addNewRequest"> Add Engine Code</a></div>
            </div>


        </div>
    </div>
</div>

<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText" >Add Engine Code</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="engcodeRegister" action="<?php echo e(route('engcode.register')); ?>" enctype="multipart/form-data"> 

                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="engcode_id" id="engcode_id" >
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
                    <div class="col-md-3 mb-3">
                        <label for="category">Category</label>
                        <select  class="form-control select"   id="category" name="catid" onchange="populateMakeData(0);" required="">
                            <option value="" >Select Category</option>
                            <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value['cat_id']); ?>" ><?php echo e($value['cat_nm']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="category">Make</label>
                        <select  class="form-control select"   id="product_make" name="makeid" onchange="populateModelData(0);" required="">
                            <option value="" >Select Category First</option>
                        </select>
                    </div>


                    <div class="col-md-3 mb-3 padRig">
                        <label for="categoryName">Model </label>
                        <select  class="form-control select"   id="product_model" name="modelid" required="" onchange="populateYearData(0);">
                            <option value="" >Select Make First</option>
                        </select>
                    </div>



                    <div class="col-md-3 mb-3">
                        <label for="categoryName">Year </label>
                        <select  class="form-control select"   id="proyr" name="proyrid" required="" onchange="populateCCMData(0);">
                            <option value="" >Select Model First</option>
                        </select>
                    </div>
                </div>
                
                <div class="row mt-4">
                    
                    <div class="col-md-3 mb-3">
                        <label for="categoryName">CCM </label>
                        <select  class="form-control select"   id="proccm" name="proccmid" >
                            <option value="" >Select Year First</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="status">Engine Code Info</label>
                        <?php if($errors->has('engcode_inf')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('engcode_inf')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="engcode_inf" name="engcode_inf" placeholder="Engine Code" >
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="status">Status</label>
                        <?php if($errors->has('engcode_status')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('engcode_status')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <select  class="form-control select " id="cstatus" name="engcode_status">
                            <option value="1"  >Enable</option>
                            <option value="0" >Disable</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitSubCategory">Add</button></div>
                </div>



            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>