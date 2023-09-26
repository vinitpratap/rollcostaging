<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Popup</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title"> ID</th>
                                <th class="column-title">Title</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $i = 1;?>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="pointer">
                                <td><?php echo e($i++); ?></td>
                                <td><?php echo e($value->p_title); ?></td>
                                 <td><?php if($value->p_status ==1): ?> Enable <?php else: ?> Disable <?php endif; ?></td>
                                <td class="last">
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="<?php echo e(base64_encode($value->p_id)); ?>" class="editPopup" src="<?php echo e(URL::asset('images/edit.svg')); ?>" alt=""></a> 
                                    <a href="<?php echo e(route('popup.delete',base64_encode($value->p_id))); ?>"  title="Delete" class="d-inline-block delete confirmation"><img src="<?php echo e(URL::asset('images/delete.svg')); ?>" alt=""></a>
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
                <h2 id="titleText"> Add Popup</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="newsRegister" action="<?php echo e(route('popup.register')); ?> " enctype="multipart/form-data"> 

                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="p_id" id="p_id">
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
                        <label for="locationName">Popup Title</label>
                        <?php if($errors->has('p_title')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('p_title')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="p_title" name="p_title" placeholder="Popup title"  >
                    </div>
                    
                </div>   
				<div class="row mt-4">
                    <div class="col-md-12 mb-3 padRig">
                        <label for="locationName">Popup Content</label>
                        <?php if($errors->has('p_content')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('p_content')); ?></strong>
                        </span>
                        <?php endif; ?>
						<textarea class="form-control " autocomplete="off" id="p_content" name="p_content" placeholder="Popup Content" ></textarea>
                        
                    </div>
                    
                </div>
				
				<div class="row mt-4">
                    <div class="col-md-12 mb-3 padRig">
                        <label for="categoryId"> Image </label>
                        <?php if($errors->has('p_image')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('p_image')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input  name="p_image" type="file" id="serimageInput">
                    </div>
				</div>
				
				<div class="row mt-4">
                    <div id="p_image_div">
                        
                    </div>
				</div>
				
                <div class="row mt-4">
                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label>
                        <?php if($errors->has('p_status')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('p_status')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <select  class="form-control select " id="p_status" name="p_status">
                            <option value="1"  >Enable</option>
                            <option value="0" >Disable</option>
                        </select>
                    </div>
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