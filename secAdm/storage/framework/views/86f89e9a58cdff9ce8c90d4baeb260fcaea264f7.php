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
                <!--                <div class="row mt-4">                   
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
                                </div>-->
                <div class="row mt-4">

                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Upload New Products</h2>
                        <div class="d-block filedetail mb-4">
                            <label for="products_file"> File</label>
                            <input  name="products_file" type="file" id="products_file" >        <a href="<?php echo e(URL('Demo')); ?>/demo-ProductData.csv" class="d-block "> Download sample file</a> </div>
                        <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitUproducts">Upload </button>


                        <p class="pt-4">Please first download file and don't change cell header</p>


                        <?php /* ?><a href="{{URL('Demo')}}/demo-ApplicationData.csv"><button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="downloadspearOEM">Download </button></a>
                          <p class="pt-4">Please first download file and don't change cell header</p><?php */ ?>
                    </div>
                    <div class="col-6  pb-3 clearfix">

                        <div class="d-block mb-4 filedetail">
                            <h2 id="titleText" >Upload Products Detail</h2>
                            <label for="products_file">File</label>
                            <input  name="products_file_detail" type="file" id="products_file_detail" >
                            <a href="<?php echo e(URL('Demo')); ?>/demo_productdetailsv4.csv" class="d-block "> Download sample file</a>
                        </div>
                        <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitUproducts">Upload </button>

                        <!--                        <a href="<?php echo e(URL('Demo')); ?>/demo-ProductDetailData.csv"><button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="downloadspearOEM">Product Detail Sample</button></a>-->
                        <!--                        <a href="<?php echo e(route('products.manage')); ?>"><button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="downloadspearOEM">Data Download</button></a>-->

                        <p class="pt-4">Please first download file and don't change cell header</p>


                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-6  pb-3 clearfix">

                        <div class="d-block mb-4 filedetail">
                            <h2 id="titleText" >Upload Products Bulk Image</h2>

                        </div>
                        <a href="<?php echo e(route('productbulkimage.upload')); ?>" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitUproducts">Click Here </a>
                        <p class="pt-4">
                        <ul>
                            <li>Please Upload Zip file only, No folder inside the zip file</li>
                            <li>All the Image names should be equal to product name. Example - Product = ALT100 , Image = ALT100-1.jpg till ALT100-8.jpg</li>
                            <li>Image should be of png/jpeg/jpg format only</li>
                            <li>Image size should be 400 X 300</li>
                            <li>The folder should contain maximum 1500 images.</li>
                        </ul>
                        </p>
                    </div>

                    <div class="col-6  pb-3 clearfix">

                        <div class="d-block mb-4 filedetail">
                            <h2 id="titleText" >Upload Products Stock</h2>
                            <label for="products_file">File</label>
                            <input  name="productsstatus_file" type="file" id="productsstatus_file" >
                            <a href="<?php echo e(URL('Demo')); ?>/sample_product_stockv2.csv" class="d-block "> Download sample file</a>
                        </div>
                        <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitUproducts">Upload </button>

                        <!--                        <a href="<?php echo e(URL('Demo')); ?>/demo-ProductDetailData.csv"><button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="downloadspearOEM">Product Detail Sample</button></a>-->
                        <!--                        <a href="<?php echo e(route('products.manage')); ?>"><button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="downloadspearOEM">Data Download</button></a>-->

                        <p class="pt-4">Please first download file and don't change cell header</p>


                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-6  pb-3 clearfix">
                        <div class="d-block mb-4 filedetail">
                            <h2 id="titleText" >Upload Products Status</h2>
                            <label for="products_file">File</label>
                            <input  name="productstatuschnage_file" type="file" id="productstatuschnage_file" >
                            <a href="<?php echo e(URL('Demo')); ?>/sample_product_status.csv" class="d-block "> Download sample file</a>
                        </div>
                        <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitUproducts">Upload </button>

                        <!--                        <a href="<?php echo e(URL('Demo')); ?>/demo-ProductDetailData.csv"><button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="downloadspearOEM">Product Detail Sample</button></a>-->
                        <!--                        <a href="<?php echo e(route('products.manage')); ?>"><button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="downloadspearOEM">Data Download</button></a>-->

                        <p class="pt-4">Please first download file and don't change cell header</p>


                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>