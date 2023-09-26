<?php $__env->startSection('content'); ?>
<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText" >Download Master</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="uproductRegister" action="<?php echo e(route('products.upload')); ?> " enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

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

                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Products</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="<?php echo e(route('masterproduct.export')); ?>" class="d-block "> Download Product</a>
						</div>
                       
                    </div>
                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Product Details</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="<?php echo e(route('masterproductdetails.export')); ?>" class="d-block "> Download Product Details</a>
						</div>
                       
                    </div>
                </div>
                <div class="row mt-4">

                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Product Stock</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="<?php echo e(route('masterproductstock.export')); ?>" class="d-block "> Download Product Stock</a>
						</div>
                       
                    </div>
                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download MS Code</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="<?php echo e(route('mscode.export')); ?>" class="d-block "> Download MS Code</a>
						</div>
                       
                    </div>
                </div>
                <div class="row mt-4">

                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Product Status</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="<?php echo e(route('masterproductstatus.export')); ?>" class="d-block "> Download Product Status</a>
						</div>
                       
                    </div>
                    
                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Appointment Calendar Data</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="<?php echo e(route('report.export')); ?>" class="d-block ">Appointment Calender Data</a>
						</div>
                       
                    </div>
                </div>
				
				<div class="row mt-4">

                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Product Crossref</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="<?php echo e(route('mastercrossref.export')); ?>" class="d-block "> Download Product Crossref</a>
						</div>
                       
                    </div>
                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Product Application</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="<?php echo e(route('masterapplication.export')); ?>" class="d-block "> Download Product Application</a>
						</div>
                       
                    </div>
                </div>
				
				<div class="row mt-4">

                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Spare</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="<?php echo e(route('masterspare.export')); ?>" class="d-block "> Download Spare</a>
						</div>
                       
                    </div>
                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Spare Service</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="<?php echo e(route('masterspareservice.export')); ?>" class="d-block "> Download Spare Service</a>
						</div>
                       
                    </div>
                </div>
				
				<div class="row mt-4">

                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Spare OEM</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="<?php echo e(route('masterspareoem.export')); ?>" class="d-block "> Download Spare OEM</a>
						</div>
                       
                    </div>
					
					<div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Group Price</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="<?php echo e(route('mastergroupprice.export')); ?>" class="d-block "> Download Group Price</a>
						</div>
                       
                    </div>
                </div>
				
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>