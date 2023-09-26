

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Sales Report</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <form method="get">

                        <div class="row mt-4">
                            <div class="col-md-4 mb-3 padRig">
                                <label>Select Sales Person</label>
                                <select  class="form-control select"  id="su_id" name="su_id" >
                                    <option value="">Select Sales Person</option>
                                    <?php $__currentLoopData = $salesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value['u_id']); ?>" <?php
                                    if (!empty(app('request')->input('su_id')))
                                        if (app('request')->input('su_id') == $value['u_id']) {
                                            echo 'selected';
                                        }
                                    ?>><?php echo e($value['firstName'] . ' ' .$value['lastName']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 padRig">
                                <label>Select Company</label>
                                <select  class="form-control select"  id="u_id" name="u_id" >
                                    <option value="">Select  Company </option>
                                    <?php $__currentLoopData = $userData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									
                                    <option value="<?php echo e($value['u_id']); ?>" <?php
                                    if (!empty(app('request')->input('u_id')))
                                        if (app('request')->input('u_id') == $value['u_id']) {
                                            echo 'selected';
                                        }
                                    ?>><?php echo e($value['companyName'] .'('.$value['com_zipCode'].')'); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if (count($tempData) > 0) { ?>
                                        <optgroup label="Temp Users">
                                            <?php $__currentLoopData = $tempData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="temp_<?php echo e($value['u_id']); ?>" <?php
                                    if (!empty(app('request')->input('u_id')))
                                        if (app('request')->input('u_id') == 'temp_'.$value['u_id']) {
                                            echo 'selected';
                                        }
                                    ?>><?php echo e($value['firstName'] .' '.$value['lastName']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </optgroup>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 padRig">
                                <label>Select Report Status</label>
                                <select  class="form-control select"  id="sc_status" name="sc_status" >
                                    <option value="">Select  Status </option>
                                    <option value="1" <?php
                                    if (!empty(app('request')->input('sc_status') == 1)) {
                                        echo 'selected';
                                    }
                                    ?>>Open</option>
                                    <option value="2" <?php
                                    if (!empty(app('request')->input('sc_status') == 2)) {
                                        echo 'selected';
                                    }
                                    ?>>Closed</option>
                                </select>
                            </div>


                        </div>

                        <div class="row mt-4">

                            <div class="col-md-6 mb-4 align-self-center padRig">
                                <label>Select Date Range</label>
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
                                <div id="reportrange1" class="form-control"> <i class="glyphicon glyphicon-calendar fa fa-calendar"></i> <span><?php echo e(date("M j, Y",strtotime($first_day))); ?> - <?php echo e(date("M j, Y",strtotime($last_day))); ?></span> <b class="caret"></b> </div>
                                <input type="hidden" name="req_date_range" id="req_date_range" value="<?php echo e(app('request')->input('req_date_range')); ?>">
                            </div>
                            <div class="col-md-4  align-self-center padRig">
                                <?php echo e(csrf_field()); ?>

                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase">Search</button>
                            </div>
                        </div>

                    </form>
                    <?php if (count($data) > 0) { ?>
                        <table class="table table-striped ">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title">Appointment Date</th>
                                    <th class="column-title">Ac Name</th>
                                    <th class="column-title">Start Time</th>
                                    <th class="column-title">End Time</th>
                                    <th class="column-title">Remarks</th>
                                    <th class="column-title">Status</th>
                                    <th class="column-title">Sales Person Name</th>
                                    <th class="column-title">Log Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="pointer">
                                    <td><?php echo e($value->sc_date); ?></td>
                                    <td>
                                        <?php echo e($value->full_name .'('.$value->post_code.')'); ?>

                                        <?php if ($value->temp_id > 0) { ?>
                                            <a href="<?php echo e(route('tempuser.getdata',base64_encode($value->temp_id))); ?>">(Temp User)</a>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo e($value->sc_stime); ?></td>
                                    <td><?php echo e($value->sc_etime); ?></td>
                                    <td><?php echo e($value->sc_remarks); ?></td>
                                    <td><?php
                                        if ($value->sc_status == 1)
                                            echo "Open";
                                        else
                                            echo "Closed";
                                        ?></td>
                                    <td><?php echo e(getUserName($value->sec_id)); ?></td>
                                    <?php $ss_id = getActCodeUser($value->u_id); ?>


                                    <td class="last">
                                        <?php if (isset($ss_id) && $ss_id != '') { ?>
                                            <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block btn btn-secondary viewAptlogs" data-id="<?php echo e($ss_id); ?>" data-uid="<?php echo e($value->u_id); ?>">Log Details</a> 
                                        <?php } else { ?>
                                            <span>N/A</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>
                        </table>
                    <?php } else { ?>
                        <strong style="margin-left: 35%;color: red;">No data available </strong>
                    <?php } ?>
                </div>

            </div>
            <?php echo e($data->links('common.custompagination')); ?>

            <div class="clearfix"></div>
            <?php if (count($data) > 0) { ?>
                <div class="row  m-0">
                    <div class="col-6"><span>Total  <?php echo e($data->total()); ?> records</span></div>
                    <?php $routeValues = 'su_id=' . app('request')->input('su_id') . '&u_id=' . app('request')->input('u_id') . '&req_date_range=' . app('request')->input('req_date_range') . '&sc_status=' . app('request')->input('sc_status'); ?>
                    <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="<?php echo e(route('report.export',$routeValues)); ?>" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="<?php echo e(URL::asset('images/excel.svg')); ?>" class="pr-2" alt="Export to Excel"> Export Sales Report </a></div>
                    <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="<?php echo e(route('log.export',$routeValues)); ?>" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="<?php echo e(URL::asset('images/excel.svg')); ?>" class="pr-2" alt="Export to Excel"> Export Sales Logs </a></div>
                    <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="<?php echo e(route('calusers.export')); ?>" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="<?php echo e(URL::asset('images/excel.svg')); ?>" class="pr-2" alt="Export to Excel"> Export Calender Users </a></div>

                </div>
            <?php } ?>


        </div>
    </div>
</div>

<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title config-title">Appointment Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <table  class="table table-striped ">
                    <thead>
                        <tr class="headings">
                            <th class="column-title">MOM / Remarks</th>
                            <th class="column-title">Visit Done By</th>
                            <th class="column-title">Created Date</th>
                        </tr>
                    </thead>
                    <tbody class="populateLogs">



                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>