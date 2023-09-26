<?php $__env->startSection('content'); ?>

<?php if(Auth::guard('admin')->user()->admin_role == 1): ?>
<?php $custData = getTotalCustCount(); $reqData = getTotalReqCount(); ?>
<div class="tile_count bg-white">
    <div class="row">
        <div class="col  tile_stats_count"> <span class="count_top"><i class="fa fa-user"></i> Total Customers</span>
            <div
                class="count"><?php echo e($custData['count']); ?></div>
            <span class="count_bottom">
                <?php if ($custData['perIncr']
                        > 0) { ?>
                    <i class="green"><i class="fa fa-sort-asc"></i><?php echo e(round($custData['perIncr'],1)); ?>% </i>
                <?php } else if ($custData['perIncr']
                        < 0) { ?>
                    <i class="red"><i class="fa fa-sort-down"></i><?php echo e(round(abs($custData['perIncr']),1)); ?>% </i>
                <?php } else { ?>
                    <i class="green"><?php echo e(round(abs($custData['perIncr']),1)); ?>% </i>
<?php } ?>
                From last Month
            </span> </div>
        <div class="col   tile_stats_count"> <span class="count_top"><i class="fa fa-user"></i> This Month</span>
            <div
                class="count"><?php echo e($custData['currmonth']); ?></div>
            <span class="count_bottom">
                <?php if ($custData['perDiffWeek']
                        > 0) { ?>
                    <i class="green"><i class="fa fa-sort-asc"></i><?php echo e(round($custData['perDiffWeek'],1)); ?>% </i>
                <?php } else if ($custData['perDiffWeek']
                        < 0) { ?>
                    <i class="red"><i class="fa fa-sort-down"></i><?php echo e(round(abs($custData['perDiffWeek']),1)); ?>% </i>
<?php } else { ?>
                    <i class="green"><?php echo e(round(abs($custData['perDiffWeek']),1)); ?>% </i>
<?php } ?>
                From last Week
            </span> </div>
        <div class="col   tile_stats_count"> <span class="count_top"><i class="fa fa-user"></i> New Requests</span>
            <div
                class="count green"><?php echo e($reqData['new_req_count']); ?></div>
            <span class="count_bottom">
                <?php if ($reqData['newperDiffWeek']
                        > 0) { ?>
                    <i class="green"><i class="fa fa-sort-asc"></i><?php echo e(round($reqData['newperDiffWeek'],1)); ?>% </i>
<?php } else if ($reqData['newperDiffWeek']
        < 0) { ?>
                    <i class="red"><i class="fa fa-sort-down"></i><?php echo e(round(abs($reqData['newperDiffWeek']),1)); ?>% </i>
<?php } else { ?>
                    <i class="green"><?php echo e(round(abs($reqData['newperDiffWeek']),1)); ?>% </i>
                <?php } ?>
                From last Week
            </span> </div>
        <div class="col   tile_stats_count"> <span class="count_top"><i class="fa fa-user"></i> In Progress</span>
            <div
                class="count"><?php echo e($reqData['prog_req_count']); ?></div>
            <span class="count_bottom">
                <?php if ($reqData['progperDiffWeek']
                        > 0) { ?>
                    <i class="green"><i class="fa fa-sort-asc"></i><?php echo e(round($reqData['progperDiffWeek'],1)); ?>% </i>
<?php } else if ($reqData['progperDiffWeek']
        < 0) { ?>
                    <i class="red"><i class="fa fa-sort-down"></i><?php echo e(round(abs($reqData['progperDiffWeek']),1)); ?>% </i>
                <?php } else { ?>
                    <i class="green"><?php echo e(round(abs($reqData['progperDiffWeek']),1)); ?>% </i>
                <?php } ?>
                From last Week
            </span> </div>
        <div class="col   tile_stats_count"> <span class="count_top"><i class="fa fa-user"></i> Total Requests</span>
            <div
                class="count"><?php echo e($reqData['total_req_count']); ?></div>
            <span class="count_bottom">
<?php if ($reqData['perIncr']
        > 0) { ?>
                    <i class="green"><i class="fa fa-sort-asc"></i><?php echo e(round($reqData['perIncr'],1)); ?>% </i>
<?php } else if ($reqData['perIncr']
        < 0) { ?>
                    <i class="red"><i class="fa fa-sort-down"></i><?php echo e(round(abs($reqData['perIncr']),1)); ?>% </i>
<?php } else { ?>
                    <i class="green"><?php echo e(round(abs($reqData['perIncr']),1)); ?>% </i>
<?php } ?>
                From last Month
            </span> </div>
        <!--<div class="col-lg-2 col-md-4 col-6 tile_stats_count">

            <span class="count_top"><i class="fa fa-user"></i> Total Connections</span>

            <div class="count">7,325</div>

            <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>

          </div>--></div>
</div>
<!-- /top tiles -->

<div class="row">
    <div class="col-12 col-md-12 col-lg-12 col-xl-5   d-flex ">
        <div class="col-12 x_panel tile  borRadiShad">
            <div class="x_title">
                <h2>Request History</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content row m-0">
                <div class="col-lg-6 col-sm-6 col-12 col-xl-5  mt-4 proj310 p-0">
                    <canvas id="canvasDoughnut" height="200" width="200"></canvas>
                    <samp>  <strong><?php echo e($reqData['total_req_count']); ?></strong></samp> </div>
                <div class="col-lg-6 col-sm-5 col-12 col-xl-7  mt-5 float-right ml-auto pr-0">
                    <table class="tile_info bg-light mt-2">
                        <tr>
                            <td><i class="fa fa-square blue"></i>In-Progress- <strong id="prog_req_count"><?php echo e($reqData['prog_req_count']); ?></strong></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-square  lightGreen"></i>Pending  - <strong id="new_req_count"><?php echo e($reqData['open_req_count']); ?></strong></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-square text-warning "></i>Closed - <strong id="closed_req_count"><?php echo e($reqData['closed_req_count']); ?></strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-12 col-xl-7 mt-4 mt-xl-0  d-flex ">
        <div class="col-12 dashboard_graph borRadiShad">
            <div class="row x_title m-0">
                <div class="col-lg-6 p-0">
                    <h2 class="size-16">Order Summary</h2>
                </div>
                <div class="col-lg-6">
                    <?php
                        $first_day = date('m-01-Y'); // hard-coded '01' for first day
                        $last_day = date('m-t-Y');
                    ?>
                    <div id="reportrange" class="float-right border p-1"> <i class="glyphicon glyphicon-calendar fa fa-calendar"></i> <span><?php echo e(date("M j, Y",strtotime($first_day))); ?> - <?php echo e(date("M j, Y",strtotime($last_day))); ?></span> <b
                            class="caret"></b> </div>
                </div>
            </div>
            <div class="row m-0">
                <div class="col-lg-9 col-md-9 col-12 mt-4" id="graph-container">
                    <input type="hidden" id="closed_req" value="<?php echo e($reqData['closedReqArr']); ?>">
                    <input type="hidden" id="cancel_req" value="<?php echo e($reqData['openReqArr']); ?>">
                    <canvas id="orderSummary" class="demo-placeholder" ></canvas>

                </div>
                <div class="col-lg-3 col-md-3 col-12 bg-white pt-5">
                    <div class="col-12"><h2 class="pb-2 size-14">This Month</h2></div>

                    <div class="col-lg-12 col-md-12 col-12 mb-2 mb-xl-0">
                        <div class="col pl-0 pr-0 pt-3">
                            <p class="mb-2 size-12">Closed Requests - <strong class="text-success float-right"><?php echo e($reqData['closed_req_count']); ?></strong></p>

                            <div class="progress progress_sm">
                                <div class="progress-bar bg-success" role="progressbar" data-transitiongoal="<?php echo e($reqData['closed_req_count']); ?>"></div>
                            </div>

                        </div>
                        <div class="col pl-0 pr-0 pt-3">
                            <p class="mb-2 size-12">Open Requests - <strong class="text-warning float-right"><?php echo e($reqData['open_req_count']); ?></strong></p>

                            <div class="progress progress_sm">
                                <div class="progress-bar bg-warning" role="progressbar" data-transitiongoal="<?php echo e($reqData['open_req_count']); ?>"></div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>