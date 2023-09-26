

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>View Orders</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <form method="get">
                        <div class="row mt-4">
                            <div class="col-md-4 mb-3 padRig">
                                <input type="text" placeholder="Search by order number" name="search"  autocomplete="off" class="form-control" value="<?php echo e(app('request')->input('search')); ?>">
                            </div>
                            <div class="col-md-4 mb-3 padRig">
                                <input type="text" placeholder="Search by name,email" name="search_user"  autocomplete="off" class="form-control" value="<?php echo e(app('request')->input('search_user')); ?>">
                            </div>
                            <div class="col-md-4 mb-3 padRig">
                                <select  class="form-control select"  id="ser_category" name="ord_status" >
                                    <option value="">Select order status</option>
                                    
                                    <option value="1" <?php if (!empty(app('request')->input('ord_status')) == 1) {echo 'selected';} ?>>Open</option>
                                    <option value="2" <?php if (!empty(app('request')->input('ord_status')) == 2) {echo 'selected';} ?>>Processing</option>
                                    <option value="3" <?php if (!empty(app('request')->input('ord_status')) == 3) {echo 'selected';} ?>>Pending</option>
                                    <option value="4" <?php if (!empty(app('request')->input('ord_status')) == 4) {echo 'selected';} ?>>Hold</option>
                                    <option value="5" <?php if (!empty(app('request')->input('ord_status')) == 5) {echo 'selected';} ?>>Complete</option>
                                    <option value="6" <?php if (!empty(app('request')->input('ord_status')) == 6) {echo 'selected';} ?>>Closed</option>
                                    <option value="7" <?php if (!empty(app('request')->input('ord_status')) == 7) {echo 'selected';} ?>>Canceled</option>
                                </select>
                            </div>
                            

                        </div>
                        
                        <div class="row mt-4">
                             <div class="col-md-6 mb-3 padRig">
                                <?php
                                $dates = '';

                                if (!empty(app('request')->input('req_date_range'))) {
                                    $dates = explode('and', app('request')->input('req_date_range'));
                                }
                                //dd($dates);
                                if (!empty($dates)) {
                                    $first_day = date('m-01-Y', strtotime($dates[0])); // hard-coded '01' for first day
                                    $last_day = date('m-t-Y', strtotime($dates[1]));
                                } else {
                                    $first_day = date('m-01-Y'); // hard-coded '01' for first day
                                    $last_day = date('m-t-Y');
                                }
                                ?>
                                 <label>Select date</label>
                                <div id="reportrange1" class="form-control"> <i class="glyphicon glyphicon-calendar fa fa-calendar"></i> <span><?php echo e(date("M j, Y",strtotime($first_day))); ?> - <?php echo e(date("M j, Y",strtotime($last_day))); ?></span> <b class="caret"></b> </div>
                                <input type="hidden" name="req_date_range" id="req_date_range" value="<?php echo e(app('request')->input('req_date_range')); ?>">
                            </div>
                            
                            <div class="col-md-4 mb-3 padRig">
                                <label>Show Entries</label>
                                <select class="form-control select" id="data_entries" name="data_entries" >                                    <?php $__currentLoopData = $pagination_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val); ?>" <?php if(app('request')->input('data_entries') == $val) {?> selected <?php } ?>><?php echo e($val); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3 pt-35 padRig">
                                <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase">Search</button>
                            </div>
                        </div>
                            
                        <?php echo e(csrf_field()); ?>


                    </form>
                    <table id="datatable1" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">S. No.</th>
                                <th class="column-title">Order No</th>
                                <th class="column-title">Name</th>
                                <th class="column-title">Email</th>
                                <th class="column-title">Price</th>
                                <th class="column-title">Quantity</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>
<?php $i = 1; ?>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr class="pointer">
                                <td><?php echo e($i++); ?></td>
                                <td><?php echo e($value->order_no); ?></td>
                                <td><?php if(isset($value->getUserDetails[0])) { ?> <?php echo e($value->getUserDetails[0]->firstName); ?> <?php echo e($value->getUserDetails[0]->lastName); ?> <?php } ?></td>
                                <td><?php if(isset($value->getUserDetails[0])) { ?><?php echo e($value->getUserDetails[0]->com_emailAddress); ?> <?php } ?></td>
                                <td><?php if(isset($value->getUserDetails[0])) { ?><?php echo e(getUserCurrency($value->getUserDetails[0]->g_id) .' '.$value->totalprice); ?>  <?php } ?></td>
                                <td><?php echo e(countOrderProduct($value->order_id)); ?> Parts - <?php echo e($value->Qty); ?> Qty </td>

                                <td><?php if($value->order_status == 1): ?> Open <?php elseif($value->order_status == 2): ?> Processing <?php elseif($value->order_status == 3): ?> Pending <?php elseif($value->order_status == 4): ?> Hold <?php elseif($value->order_status == 5): ?> Complete <?php elseif($value->order_status == 6): ?> Closed <?php elseif($value->order_status == 7): ?> Canceled <?php endif; ?></td>
                                <td class="last">
                                    <a href="<?php echo e(route('order.details',base64_encode($value->order_id))); ?>" title="Edit" class="mr-4 ml-2 d-inline-block"><img src="<?php echo e(URL::asset('images/edit.svg')); ?>" alt=""></a>
                                    <?php if($value->order_status != 4): ?><a href="<?php echo e(route('order.delete',base64_encode($value->order_id))); ?>"  title="Delete" class="d-inline-block delete confirmation"><img src="<?php echo e(URL::asset('images/delete.svg')); ?>" alt=""></a><?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php echo e($data->links('common.custompagination')); ?>



            </div>
            <div class="clearfix"></div>
<?php if (count($data) > 0) { ?>
                <div class="row  m-0">
                    <div class="col-6"><span>Total  <?php echo e($data->total()); ?> records</span></div>
                    <?php $routeValues = 'search=' . app('request')->input('search'). '&search_user=' . app('request')->input('search_user') . '&ord_status=' . app('request')->input('ord_status') . '&daterange=' . app('request')->input('req_date_range'); ?>
                    <div class="col-6 text-right pl-0 pr-0 pb-3 clearfix"><a href="<?php echo e(route('order.export',$routeValues)); ?>" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="<?php echo e(URL::asset('images/excel.svg')); ?>" class="pr-2" alt="Export to Excel"> Export to Excel </a></div>

                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>