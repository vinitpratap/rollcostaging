<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Cross references</h2>
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

                            <?php if(app('request')->input('search') !=''): ?>
                            <div class="col-md-4 mb-3 padRig">
                                <label>Select Company</label>
                                <select class="form-control select" id="comp_name" name="comp_name" >   
                                    <option value="">Please Select Company</option>
                                    <?php $__currentLoopData = $custData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value->g_id.'_'.$value->u_id); ?>" <?php if (app('request')->input('comp_name') == $value->companyName) {
   ?> selected <?php } ?>><?php echo e($value->companyName.'('.$value->customerID.')'); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <?php endif; ?>
                            <div class="col-md-4 mb-3 padRig">
                                <label>Show Entries</label>
                                <select class="form-control select" id="data_entries" name="data_entries" >                                    <?php $__currentLoopData = $pagination_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val); ?>" <?php if (app('request')->input('data_entries') == $val) {
   ?> selected <?php } ?>><?php echo e($val); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <?php if(app('request')->input('search') ==''): ?>
                            <div class="col-md-4 mb-3 pt-35 padRig">
                                <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase">Search</button>
                            </div>
                            <?php endif; ?>

                        </div>
                        <?php if(app('request')->input('search') !=''): ?>
                        <div class="row mt-4">
                            <div class="col-md-4 mb-3  padRig">
                                <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase">Search</button>
                            </div>

                            <div class="col-md-8 mb-3  padRig">
                                <?php $routeValues = 'search=' . app('request')->input('search');?>
                                <a href="<?php echo e(route('crossrefcust.export',$routeValues)); ?>" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcelComp"> <img src="<?php echo e(URL::asset('images/excel.svg')); ?>" class="pr-2" alt="Export to Excel"> Export Company </a>
                            </div>

                        </div>
                        <?php endif; ?>
                        <?php echo e(csrf_field()); ?>


                    </form>
                    <?php if (count($data) > 0) { ?>
                        <table id="datatable1" class="table table-striped ">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title"> ID</th>
                                    <th class="column-title">Part No.</th>
                                    <th class="column-title">Manufacturer</th>
                                    <th class="column-title">OEM</th>
                                    <th class="column-title">Status</th>
                                    <th class="column-title">Action</th>
                                    <th class="column-title">Check All (Delete) &nbsp; <input type="checkbox" class="deleteCross" id="checkAll"></th>
                                    <th class="column-title">Check All(Status Change) &nbsp; <input type="checkbox" class="changeStatusCross" id="checkAllStatus"></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php $i = 1; ?>
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="pointer">
                                    <td><?php echo e($i++); ?></td>
                                    <td><?php echo e($value->rc_num); ?></td>
                                    <td><?php echo e($value->crossref_make); ?></td>
                                    <td><?php echo e($value->crossref_oem); ?></td>
                                    <td><?php if($value->crossref_status==1): ?> Enable <?php else: ?> Disable <?php endif; ?></td>
                                    <td>
                                        <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="<?php echo e(base64_encode($value->crossref_id)); ?>" class="editcrossref" src="<?php echo e(URL::asset('images/edit.svg')); ?>" alt=""></a>

                                        <a href="<?php echo e(route('crossref.delete',base64_encode($value->crossref_id))); ?>"  title="Delete" class="d-inline-block delete confirmation"><img src="<?php echo e(URL::asset('images/delete.svg')); ?>" alt=""></a>
                                    </td>
                                    <td class="last"><input type="checkbox" class="deleteCrossref" id="<?php echo e($value->crossref_id); ?>"></td>
                                    <td class="last"><input type="checkbox" class="changeStatusCrossref" id="<?php echo e($value->crossref_id); ?>"></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <strong style="margin-left: 35%;color: red;">No data available </strong>
                <?php } ?>
                <?php echo e($data->links('common.custompagination')); ?>

            </div>

            <div class="clearfix"></div>
            <?php if (count($data) > 0) { ?>
                <div class="row  m-0">
                    <div class="col-6"><span>Total  <?php echo e($data->total()); ?> records</span></div>
                    <?php $routeValues = 'search=' . app('request')->input('search'); ?>
                    <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="<?php echo e(route('crossref.export',$routeValues)); ?>" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="<?php echo e(URL::asset('images/excel.svg')); ?>" class="pr-2" alt="Export to Excel"> Export to Text </a></div>

                </div>
                <div class="row  m-0">

                    <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="<?php echo e(route('crossrefcsv.export',$routeValues)); ?>" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="<?php echo e(URL::asset('images/excel.svg')); ?>" class="pr-2" alt="Export to Excel"> Export to CSV </a></div>

                </div>
            <?php } ?>

            <div class="row  m-0 deleteCrossButt" style="display:none;">
                <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="javascript:void(0);" class="btn btn-outline-secondary  pl-4 pr-4 pt-2 pb-2  m-0" id="deletecrossRef"> Delete </a></div>
            </div>

            <div class="row  m-0 statusCrossButt" style="display:none;">
                <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="javascript:void(0);" class="btn btn-outline-secondary  pl-4 pr-4 pt-2 pb-2  m-0" id="changeStatuscrossRef"> Change Status </a></div>
            </div>


        </div>
    </div>
</div>

<div class="row pt-3 updCr">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText"> Upload Cross references</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="categoryRegister" action="<?php echo e(route('crossref.register')); ?> " enctype="multipart/form-data"> 

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
                                        <label for="crossref_file"> File</label>
                                        <input  name="crossref_file" type="file" id="crossref_file" >
                                    </div>
                                </div>-->
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix">
                        <div class="d-block filedetail mb-4">
                            <label for="crossref_file"> File</label>
                            <input  name="crossref_file" type="file" id="crossref_file" >        <a href="<?php echo e(URL('Demo')); ?>/demo-CrossRef.csv" class="d-block " target="_blank"> Download sample file</a> </div>
                        <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitCategory">Upload </button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row pt-3 edtCr" style="display: none">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="edt_titleText">Edit Cross references</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="crossrefRegister" action="<?php echo e(route('crossref.register')); ?> " > 

                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="crossref_id" id="crossref_id" value="">
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
                    <div class="col-md-3 mb-3 padRig">
                        <label for="rc_num">Part No.</label>
                        <?php if($errors->has('rc_num')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('rc_num')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="rc_num" name="rc_num" >
                    </div>
                    <div class="col-md-3 mb-3 padRig">
                        <label for="crossref_make">Make</label>
                        <?php if($errors->has('crossref_make')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('crossref_make')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="crossref_make" name="crossref_make">
                    </div>
                    <div class="col-md-3 mb-3 padRig">
                        <label for="crossref_oem">OCM</label>
                        <?php if($errors->has('crossref_oem')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('crossref_oem')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="crossref_oem" name="crossref_oem" >
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="crossref_status">Status</label>
                        <?php if($errors->has('crossref_status')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('crossref_status')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <select  class="form-control select " id="crossref_status" name="crossref_status">
                            <option value="1">Enable</option>
                            <option value="0">Disable</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitcrossref">Edit Cross references</button></div>
                </div>



            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>