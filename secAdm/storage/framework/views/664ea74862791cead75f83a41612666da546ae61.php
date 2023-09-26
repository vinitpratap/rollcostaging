<?php $__env->startSection('content'); ?>

<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText"> View Sales Sheet Data</h2>
                <a href="<?php echo e(route('salessheet.manage')); ?>" class="mr-4 ml-2 d-inline-block btn btn-secondary btnp text-uppercase pull-right" ><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a> 
                <div class="clearfix"></div>
            </div>
            <form method="post" id="salesSheetDataRegister" action="<?php echo e(route('salessheet.register')); ?>" enctype="multipart/form-data" > 
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="user_id" value="<?php echo e($user_id); ?>">
                <input type="hidden" name="user_email" value="<?php echo e($userData['com_emailAddress']); ?>">
                <input type="hidden" name="ss_id" id="ss_id" value="<?php echo e($sheetData['ss_id']); ?>">
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
                    <div class="col-md-4 mb-3 padRig">
                        <label>Company Name </label>
                        <h6><?php echo e($userData['companyName']); ?></h6>
                    </div>
                </div>
                <div class="row mt-4 sscustcat" >
                    <div class="col-md-4 mb-3 padRig">
                        <label>Account No</label>
                        <h6><?php echo e(($userData['customerID'])); ?></h6>
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                        <label>Post Code</label>
                        <h6><?php echo e($userData['com_zipCode']); ?></h6>
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                        <label>Email</label>
                        <h6><?php echo e($userData['com_emailAddress']); ?></h6>
                    </div>
                </div>
                <div class="row mt-4 sscustcat" >
                    <div class="col-md-4 mb-3 padRig">
                        <label>Phone No</label>
                        <h6><?php echo e($userData['com_Telephone']); ?></h6>
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                        <label>Buying Group</label>
                        <h6><?php echo e($userData['buying_group']); ?></h6>
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                        <label>Account opened date</label>
                        <h6><?php echo e($userData['regisdate']); ?></h6>
                    </div>
                </div>


                <?php
                $prevtoprevyr = date("Y") - 2;
                $prevyr = date("Y") - 1;
                $curryr = date("Y") ;
                ?>
                <div class="sheet_other_details">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
<!--                                <tr>
                                    <td ><span id="label5">Rotating Turnover Last Year</span></td>
                                    <td><input name="roll_last_year_turnover" type="text" autocomplete="off" value="<?php echo e($sheetData['roll_last_year_turnover']); ?>" id="TurnoverLastYear" class="onlyDec"></td>
                                    <td><span >ROLLING SHARE %</span></td>
                                    <td><input name="roll_share_per" type="text" autocomplete="off" value="<?php echo e($sheetData['roll_share_per']); ?>" id="txtROLLINGSHAREPer" class="onlyDec"></td>
                                </tr>-->
                                <tr>
                                    <td ><span id="label222">OTHER DETAILS</span></td>
                                    <td>&nbsp;</td>
                                    <td colspan="2">&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><span id="label20">SPEND INFO</span></td>
                                    <td><span id="Label21"><?php echo e($prevtoprevyr); ?></span></td>
                                    <td colspan="2"><span id="Label22"><?php echo e($prevyr); ?></span></td>
                                    <td><span id="Label23"><?php echo e($curryr); ?></span></td>
                                </tr>

                                <?php $__currentLoopData = $userCatData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(count($scatvalArr)>0): ?>
                                <tr>
                                    <td ><span><?php echo e(getSalesCategoryName($value['cat_id'])); ?>- QTY </span></td>
                                    <td><span><?php if (isset($scatvalArr[$prevtoprevyr][$value['cat_id']]['ssv_scat_qty'])) echo $scatvalArr[$prevtoprevyr][$value['cat_id']]['ssv_scat_qty']; ?></span></td>
                                    <td colspan="2"><?php if (isset($scatvalArr[$prevyr][$value['cat_id']]['ssv_scat_qty'])) echo $scatvalArr[$prevyr][$value['cat_id']]['ssv_scat_qty']; ?><span></span></td>
                                    <td><input name="<?php echo e($value['cat_id']); ?>_Qty_<?php echo e($curryr); ?>" type="text" autocomplete="off" style="max-width:100%; width:100%;  " value="<?php if (isset($scatvalArr[$curryr][$value['cat_id']]['ssv_scat_qty'])) echo $scatvalArr[$curryr][$value['cat_id']]['ssv_scat_qty']; ?>" class="onlyDec unitsQty" >

                                        <div class="d-flex mt-2 addWhite">
                                            <span class="white-space align-self-center "> Faulty :</span> <input name="<?php echo e($value['cat_id']); ?>_fQty_<?php echo e($curryr); ?>" type="text" autocomplete="off" class="ml-2 onlyDec funitsQty" value="<?php if (isset($scatvalArr[$curryr][$value['cat_id']]['ssv_scat_faulty'])) echo $scatvalArr[$curryr][$value['cat_id']]['ssv_scat_faulty']; ?>"  >  
                                            <span class="white-space pl-2 align-self-center">  Faulty % : </span> <input class="ml-2 onlyDec funitPer" name="<?php echo e($value['cat_id']); ?>_fQtyPer_<?php echo e($curryr); ?>" type="text" autocomplete="off" value="<?php if (isset($scatvalArr[$curryr][$value['cat_id']]['ssv_scat_faulty_per'])) echo $scatvalArr[$curryr][$value['cat_id']]['ssv_scat_faulty_per']; ?>" > </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td ><span id="label12"><?php echo e(getSalesCategoryName($value['cat_id'])); ?>- VALUE</span></td>
                                    <td><span><?php if (isset($scatvalArr[$prevtoprevyr][$value['cat_id']]['ssv_scat_value'])) echo $scatvalArr[$prevtoprevyr][$value['cat_id']]['ssv_scat_value']; ?></span></td>
                                    <td colspan="2"><span><?php if (isset($scatvalArr[$prevyr][$value['cat_id']]['ssv_scat_value'])) echo $scatvalArr[$prevyr][$value['cat_id']]['ssv_scat_value']; ?></span></td>
                                    <td><input name="<?php echo e($value['cat_id']); ?>_val_<?php echo e($curryr); ?>" type="text" autocomplete="off" value="<?php if (isset($scatvalArr[$curryr][$value['cat_id']]['ssv_scat_value'])) echo $scatvalArr[$curryr][$value['cat_id']]['ssv_scat_value']; ?>" class="onlyDec"></td>
                                </tr>
                                <?php else: ?>
                                <tr>
                                    <td ><span><?php echo e(getSalesCategoryName($value['cat_id'])); ?>- QTY </span></td>
                                    <td><span></span></td>
                                    <td colspan="2"><span></span></td>
                                    <td><input name="<?php echo e($value['cat_id']); ?>_Qty_<?php echo e($curryr); ?>" type="text" autocomplete="off" style="max-width:100%; width:100%;  " value="" class="onlyDec unitsQty">

                                        <div class="d-flex mt-2 addWhite">
                                            <span class="white-space align-self-center "> Faulty :</span> <input name="<?php echo e($value['cat_id']); ?>_fQty_<?php echo e($curryr); ?>" type="text" autocomplete="off" value="" class="ml-2 onlyDec funitsQty">  
                                            <span class="white-space pl-2 align-self-center">  Faulty % : </span> <input name="<?php echo e($value['cat_id']); ?>_fQtyPer_<?php echo e($curryr); ?>" type="text" autocomplete="off" value="" class="ml-2 onlyDec funitPer"> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td ><span id="label12"><?php echo e(getSalesCategoryName($value['cat_id'])); ?>- VALUE</span></td>
                                    <td><span id="lbl<?php echo e(getSalesCategoryName($value['cat_id'])); ?>Value<?php echo e($prevtoprevyr); ?>"></span></td>
                                    <td colspan="2"><span id="lbl<?php echo e(getSalesCategoryName($value['cat_id'])); ?>Value<?php echo e($prevyr); ?>"></span></td>
                                    <td><input name="<?php echo e($value['cat_id']); ?>_val_<?php echo e($curryr); ?>" type="text" autocomplete="off" value="" class="onlyDec"></td>
                                </tr>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<!--                                <tr>
                                    <td><span id="label24">TOTAL SPEND</span></td>
                                    <td><span ><?php if (isset($cntYrArr[$prevtoprevyr])) echo $cntYrArr[$prevtoprevyr]; ?></span></td>
                                    <td colspan="2"><span ><?php if (isset($cntYrArr[$prevtoprevyr])) echo $cntYrArr[$prevyr]; ?></span></td>
                                    <td><span><?php if (isset($cntYrArr[$curryr])) echo $cntYrArr[$curryr]; ?></span></td>
                                </tr>-->
<!--                                <tr>
                                    <td ><span id="label37">Gross Sale Qty</span></td>
                                    <td><input name="gross_qty" type="text" autocomplete="off" value="<?php echo e($sheetData['gross_qty']); ?>" id="txtGrossSaleQty" class="onlyDec grossSale"></td>
                                    <td colspan="2" ><span id="Label38">Faulty</span></td>
                                    <td><input name="gross_faulty" type="text" autocomplete="off" value="<?php echo e($sheetData['gross_faulty']); ?>" id="txtFaulty" class="onlyDec grossFaulty"></td>
                                </tr>
                                <tr>
                                    <td ><span id="label39">Return to stock</span></td>
                                    <td><input name="gross_return_stock" type="text" autocomplete="off" value="<?php echo e($sheetData['gross_return_stock']); ?>" id="txtReturntostock" class="onlyDec"></td>
                                    <td colspan="2" ><span id="Label40">Faulty %</span></td>
                                    <td><input name="gross_faulty_per" type="text" autocomplete="off" value="<?php echo e($sheetData['gross_faulty_per']); ?>" id="txtFaultyPer" class="onlyDec grossFaultyPer"></td>
                                </tr>
                                <tr>
                                    <td ><span id="label41">Faulty Category</span></td>
                                    <td><span id="Label42">Faulty</span></td>
                                    <td><span id="Label43">NFF</span></td>
                                    <td><span id="Label44">Transit Damage</span></td>
                                    <td><span id="Label45">Contaminated</span></td>
                                </tr>
                                <tr>
                                    <td ><span id="label46">QTY</span></td>
                                    <td><input name="faulty_cat_qty" type="text" autocomplete="off" value="<?php echo e($sheetData['faulty_cat_qty']); ?>" id="txtFaultyQty" class="onlyDec"></td>
                                    <td><input name="faulty_cat_nff" type="text" autocomplete="off" value="<?php echo e($sheetData['faulty_cat_nff']); ?>" id="txtNFFQty" class="onlyDec"></td>
                                    <td><input name="faulty_cat_transit_damage" type="text" autocomplete="off" value="<?php echo e($sheetData['faulty_cat_transit_damage']); ?>" id="txtTransitDamage" class="onlyDec"></td>
                                    <td><input name="faulty_cat_contanimated" type="text" autocomplete="off" value="<?php echo e($sheetData['faulty_cat_contanimated']); ?>" id="txtContaminatedQty" class="onlyDec"></td>
                                </tr>-->
                                <tr>
                                    <td ><span id="label28">Current Outstanding</span></td>
                                    <td><input name="roll_curr_outstanding" type="text" autocomplete="off" value="<?php echo e($sheetData['roll_curr_outstanding']); ?>" id="txtCurrentOutstanding" class="onlyDec"></td>
                                    <td colspan="2" ><span id="Label30">SOR / EXTENDED QTY</span></td>
                                    <td><input name="roll_consgnmt_qty" type="text" autocomplete="off" value="<?php echo e($sheetData['roll_consgnmt_qty']); ?>" id="txtCongnmntQty" class="onlyDec"></td>
                                </tr>
                                <tr>
                                    <td ><span id="label29">Over Due Outstanding If any</span></td>
                                    <td><input name="roll_overdue_outstanding" type="text" autocomplete="off" value="<?php echo e($sheetData['roll_overdue_outstanding']); ?>" id="txtOverDueIfany" class="onlyDec"></td>
                                    <td colspan="2" ><span id="Label31">SOR / EXTENDED VALUE</span></td>
                                    <td><input name="roll_consgnmt_value" type="text" autocomplete="off" value="<?php echo e($sheetData['roll_consgnmt_value']); ?>" id="txtCongnmntValue" class="onlyDec"></td>
                                </tr>
                                <tr>
                                    <td ><span id="label32">Last stock cleanse date</span></td>
                                    <td><input name="roll_last_stock_cdate" type="date" value="<?php if(isset($sheetData['roll_last_stock_cdate'])) { ?><?php echo e(date("Y-m-d",strtotime($sheetData['roll_last_stock_cdate']))); ?><?php } ?>" id="txtLaststockcleansedate" ></td>
<!--                                    <td colspan="2" ><span id="Label34">SOR / EXTENDED (if any)</span></td>
                                    <td><input name="roll_sor_extended" type="text" autocomplete="off" value="<?php echo e($sheetData['roll_sor_extended']); ?>" id="txtEXTENDED" class="onlyDec"></td>-->
                                </tr>
                                <tr>
                                    <td><span id="Label36">Last Visit Done By</span></td>
                                    <td ><strong><?php if(isset($lastVisitArr['firstName'])) { ?><?php echo e($lastVisitArr['firstName'].$lastVisitArr['lastName']); ?> <?php } else{ echo "NONE"; }?></strong></td>
                                    <td>&nbsp;</td>
                                    <td><span id="Label36">Last Visit Date</span></td>
                                    <td ><strong><?php if(isset($lastVisitArr['sc_date'])) { ?><?php echo e(date("Y-m-d",strtotime($lastVisitArr['sc_date']))); ?><?php } else { echo "NONE";} ?> </strong></td>
                                </tr>
<!--                                <tr>
                                    <td colspan="2"><span>APPOINTMENT DETAILS DISCUSSED	</span></td>
                                    <td colspan="3"><span>Action Taken / Action to be Taken
                                        </span></td>

                                </tr>
                                <tr>
                                    <td colspan="2"><textarea name="apt_details_discussed" type="text" autocomplete="off" id="txtEXTENDED"></textarea></td>
                                    <td colspan="3"><textarea name="apt_details_action" type="text" autocomplete="off"  id="txtEXTENDED"></textarea></td>
                                </tr>-->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-4 ">
                    <div class="col-12  pb-3 clearfix">
                        <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitGroup">Submit</button>
                        <?php $ss_id = getActCodeUser($user_id); ?>
                        <?php if (isset($ss_id) && $ss_id != '') { ?>
                            <button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="populateAptLogs" data-id="<?php echo e($user_id); ?>">View Old Logs</button>
                        <?php } ?>
                    </div>
                </div>
            </form>
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