<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Product Application </h2>
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
                    <table class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Sr No</th>
                                <th class="column-title">Product</th>
                                <th class="column-title">Make</th>
                                <th class="column-title">Model</th>
                                <!--<th class="column-title">ENGINE</th>-->
                                <th class="column-title">Year</th>
                                <th class="column-title">CCM</th>
								<th class="column-title">Status</th>	
                                <th class="column-title">Action</th>
								<th class="column-title">Check All (Delete) &nbsp; <input type="checkbox" class="deleteCross" id="checkAll"></th>
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
                                <!--<td><?php echo e($value->eng_nm); ?></td>-->
                                <td><?php echo e($value->year); ?></td>
                                <td><?php echo e($value->cc); ?></td>
								 <td><?php if($value->ap_status ==1): ?> Enable <?php else: ?> Disable <?php endif; ?></td>
                                <td class="last">
									<a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="<?php echo e(base64_encode($value->part_no)); ?>_<?php echo e(base64_encode($value->ap_id)); ?>" class="editproduct-application" src="<?php echo e(URL::asset('images/edit.svg')); ?>" alt=""></a> 
                                    <a href="<?php echo e(route('application.delete',base64_encode($value->ap_id))); ?>"  title="Delete" class="d-inline-block delete confirmation"><img src="<?php echo e(URL::asset('images/delete.svg')); ?>" alt=""></a>
                                </td>
								<td class="last"><input type="checkbox" class="deleteCrossref" id="<?php echo e($value->ap_id); ?>"></td>
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
                    <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="<?php echo e(route('application.export',$routeValues)); ?>" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="<?php echo e(URL::asset('images/excel.svg')); ?>" class="pr-2" alt="Export to Excel"> Export to Text </a></div>

                </div>
            <?php } ?>
 <div class="row  m-0 deleteCrossButt" style="display:none;">
                <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="javascript:void(0);" class="btn btn-outline-secondary  pl-4 pr-4 pt-2 pb-2  m-0" id="deleteApplication"> Delete </a></div>
            </div>

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
            <form method="post" id="applicationUpdate" action="<?php echo e(route('application.upload')); ?> " enctype="multipart/form-data">
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
                        <label for="application_file"> File</label>
                        <input  name="application_file" type="file" id="application_file" >
                    </div>
                </div>-->
				<input type="hidden" name="ap_id" id="ap_id" >
				<input type="hidden" name="part_no" id="part_no" >
				<input type="hidden" name="app_upload" value="1" >
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix fileuploaddiv" >
                        <div class="d-block filedetail mb-4">
                        <label for="application_file"> File</label>
                        <input  name="application_file" type="file" id="application_file" >        <a href="<?php echo e(URL('Demo')); ?>/demo-ApplicationData1.csv" class="d-block "> Download sample file</a> </div>
                        
                      
                        
                        <p class="pt-4">Please first download file and don't change cell header</p>
						
                    </div>
					<div class="col-md-4 mb-3 padRig otherdiv" style="display:none;">
                        <label for="make_nm">MAKE</label>
                        <?php if($errors->has('make_nm')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('make_nm')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="make_nm" name="make_nm" placeholder="eg:-1202152" value="<?php echo e(old('make_nm')); ?>"   >
                    </div>
                    <div class="col-md-4 mb-3 padRig otherdiv" style="display:none;">
                        <label for="model_nm">MODEL</label>
                        <?php if($errors->has('model_nm')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('model_nm')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="model_nm" name="model_nm" placeholder="eg:-1202152" value="<?php echo e(old('model_nm')); ?>"  >
                    </div>
                    <div class="col-md-4 mb-3 padRig otherdiv" style="display:none;">
                        <label for="year">Year</label>
                        <?php if($errors->has('year')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('year')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="year" name="year" placeholder="eg:-1202152" value="<?php echo e(old('year')); ?>" >
                    </div>
                    <div class="col-md-4 mb-3 padRig otherdiv" style="display:none;">
                        <label for="cc">CC</label>
                        <?php if($errors->has('cc')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('cc')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="cc" name="cc" placeholder="eg:-1202152" value="<?php echo e(old('cc')); ?>" >
                    </div>
					<div class="col-12  pb-3 clearfix">
					  <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitapplication">Upload </button>
                	</div>
				</div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>