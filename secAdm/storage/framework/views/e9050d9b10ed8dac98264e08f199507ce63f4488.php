<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>View Recently viewed</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <form method="get">
                         <div class="row mt-4">
                            <div class="col-md-4 mb-3 padRig">
                                <label>Search By</label>
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
                    <?php if (count($data) > 0) { ?>
                    <table class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">S. No.</th>
                                <th class="column-title">Name</th>
                                <th class="column-title">Email</th>
                                <th class="column-title">Mobile</th>
                                <th class="column-title">Product</th>
                                <th class="column-title">Spare</th>
                                <th class="column-title">IP</th>
                                <th class="column-title">Date</th>
                                <th class="column-title">Action</th>
                                <th class="column-title">Check All &nbsp; <input type="checkbox" class="deleteCross" id="checkAll"></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $i = 1;?>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="pointer">
                                <td><?php echo e($i++); ?></td>
                                <td><?php echo e($value->firstName.' '.$value->lastName); ?></td>
                                <td><?php echo e($value->com_emailAddress); ?></td>
                                <td><?php echo e($value->com_Telephone); ?></td>
                                <td><?php echo e($value->prod_part_no); ?></td>
                                <td><?php echo e($value->spare_part_no); ?></td>
                                <td><?php echo e($value->u_ip); ?></td>
                                <td><?php echo e($value->created_at); ?></td>
                                <td class="last">
                                    <a href="<?php echo e(route('recent_search.delete',base64_encode($value->sf_id))); ?>"  title="Delete" class="d-inline-block delete confirmation"><img src="<?php echo e(URL::asset('images/delete.svg')); ?>" alt=""></a>
                                </td>
                                <td class="last"><input type="checkbox" class="deleteRecent" id="<?php echo e($value->sf_id); ?>"></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                    <?php } else { ?>
                        <strong style="margin-left: 35%;color: red;">No data available </strong>
                    <?php } ?>
                        <?php echo e($data->links('common.custompagination')); ?>

                </div>

                   
<?php if (count($data) > 0) { ?>
                <div class="row  m-0">
                    <div class="col-6"><span>Total  <?php echo e($data->total()); ?> records</span></div>
                    <?php $routeValues = 'search=' . app('request')->input('search') ; ?>
                    <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="<?php echo e(route('recent_search.export',$routeValues)); ?>" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="<?php echo e(URL::asset('images/excel.svg')); ?>" class="pr-2" alt="Export to Excel"> Export Last 30 days search analytic data   </a></div>

                </div>
            <?php } ?>
<div class="row  m-0 deleteCrossButt" style="display:none;">
                    <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="javascript:void(0);" class="btn btn-outline-secondary  pl-4 pr-4 pt-2 pb-2  m-0" id="deleteRecentDetails"> Delete </a></div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>