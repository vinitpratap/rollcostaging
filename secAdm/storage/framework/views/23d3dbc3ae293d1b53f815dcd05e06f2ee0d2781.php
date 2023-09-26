<?php $__env->startSection('content'); ?>

<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText" >Upload Group Price</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="spareRegister" action="<?php echo e(route('groupprice.upload')); ?> " enctype="multipart/form-data"> 

                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="upload_groupprice" id="upload_groupprice" value="1">
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
<!--                <div class="row mt-4">
                    
                    <div class="col-md-4 mb-3 ">
                        <label for="spare_file"> File</label>
                        <input  name="spare_file" type="file" id="spare_file" >
                    </div>
                    
                </div>-->
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix">
                        <div class="d-block filedetail mb-4">
                        <label for="productgroup_file"> File</label>
                        <input  name="productgroup_file" type="file" id="productgroup_file" >        <a href="<?php echo e(URL('Demo')); ?>/demo-group-product-pricev2.csv" class="d-block " target="_blank"> Download sample file</a> 
						<p class="pt-4">
                        <ul>
                            <li>Please first download file and don't change cell header</li>
                            <li>Please replace £ to GBP, $ to USD and € to EURO</li>
                        </ul>
                        </p></div>
                        <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitCategory">Upload </button>
<!--                        <a href="<?php echo e(URL('Demo')); ?>/demo-spare.csv"><button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="downloadspearOEM">Sample format</button></a>-->
<!--                        <a href="<?php echo e(route('spare.manage')); ?>"><button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="downloadspearOEM">Data Download</button></a>-->
                    </div>
                </div>



            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>