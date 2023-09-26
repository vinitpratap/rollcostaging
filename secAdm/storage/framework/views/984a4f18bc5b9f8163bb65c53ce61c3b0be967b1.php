<?php $__env->startSection('content'); ?>
<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText" >Upload Products</h2>
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
                    <div class="col-md-4 mb-3 ">
                        <label for="products_file"> File</label>
                        <input  name="products_file" type="file" id="products_file" >
                    </div>
                </div>
                <div class="row mt-4">                   
                    <div class="col-md-4 mb-3 ">
                        <label for="products_file"> File Detail</label>
                        <input  name="products_file_detail" type="file" id="products_file_detail" >
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix">
                        <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitUproducts">Upload </button>
                        <a href="<?php echo e(URL('Demo')); ?>/demo-ProductData.csv"><button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="downloadspearOEM">Product Sample</button></a>
                        <a href="<?php echo e(URL('Demo')); ?>/demo-ProductDetailData.csv"><button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="downloadspearOEM">Product Detail Sample</button></a>
                        <a href="<?php echo e(route('products.manage')); ?>"><button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="downloadspearOEM">Data Download</button></a>
                    
                        <p class="pt-4">Please first download file and don't change cell header</p>
                        
                        
                        <?php /*?><a href="{{URL('Demo')}}/demo-ApplicationData.csv"><button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="downloadspearOEM">Download </button></a>
                        <p class="pt-4">Please first download file and don't change cell header</p><?php */?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>