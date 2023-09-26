<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Product Application</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <form method="get">
                        <div class="row mt-4">
                            <div class="col-md-4 mb-3 padRig">
                                <label>&nbsp;</label>
                                <input type="text" placeholder="Search by" name="search"  autocomplete="off" class="form-control" value="<?php echo e(app('request')->input('search')); ?>">
                            </div>

                            <div class="col-md-4 mb-3 padRig">
                                <label>Show Entries</label>
                                <select class="form-control select" id="data_entries" name="data_entries" >                                    <?php $__currentLoopData = $pagination_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val); ?>" <?php if(app('request')->input('data_entries') == $val) {?> selected <?php } ?>><?php echo e($val); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            
                            <div class="col-md-4 mb-3 pt-35 padRig">
                                <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase">Search</button>
                            </div>



                        </div>
                        <?php echo e(csrf_field()); ?>


                    </form>
                    <table class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Sr No</th>
                                <th class="column-title">Product</th>
                                <th class="column-title">Make</th>
                                <th class="column-title">Model</th>
                                <th class="column-title">ENGINE</th>
                                <th class="column-title">Year</th>
                                <th class="column-title">CCM</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php $i = 1;?>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php 
                            $apCount = getapCount($value->prod_part_no);
                            ?>

                            <tr class="pointer">
                                <td><?php echo e($i++); ?></td>
                                <td><?php echo e($value->part_no); ?></td>
                                <td><?php echo e($value->make_nm); ?></td>
                                <td><?php echo e($value->model_nm); ?></td>
                                <td><?php echo e($value->eng_nm); ?></td>
                                <td><?php echo e($value->year); ?></td>
                                <td><?php echo e($value->cc); ?></td>
                                <td class="last">                                     
                                    <a href="<?php echo e(route('application.delete',base64_encode($value->ap_id))); ?>"  title="Delete" class="d-inline-block delete confirmation"><img src="<?php echo e(URL::asset('images/delete.svg')); ?>" alt=""></a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                </div>

            </div>
                    <?php echo e($data->links('common.custompagination')); ?>

            <div class="clearfix"></div>
<?php if (count($data) > 0) { ?>
                <div class="row  m-0">
                    <div class="col-6"><span>Total  <?php echo e($data->total()); ?> records</span></div>
                    <?php $routeValues = 'search=' . app('request')->input('search') ; ?>
                    <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="<?php echo e(route('application.export',$routeValues)); ?>" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="<?php echo e(URL::asset('images/excel.svg')); ?>" class="pr-2" alt="Export to Excel"> Export to Excel </a></div>

                </div>
            <?php } ?>


        </div>
    </div>
</div>

<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText" >Upload Application</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="spearOEMRegister" action="<?php echo e(route('application.upload')); ?> " enctype="multipart/form-data">
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
                        <label for="application_file"> File</label>
                        <input  name="application_file" type="file" id="application_file" >
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix">
                        <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitapplication">Upload </button>
                        <a href="<?php echo e(URL('Demo')); ?>/demo-ApplicationData.csv"><button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="downloadspearOEM">Sample Format</button></a>
                        <p class="pt-4">Please first download file and don't change cell header</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>