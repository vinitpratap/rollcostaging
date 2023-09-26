<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Spare</h2>
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
                                    <option value="<?php echo e($val); ?>" <?php if (app('request')->input('data_entries')
        == $val) { ?> selected <?php } ?>><?php echo e($val); ?></option>
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
                                <th class="column-title">Spare Part No</th>
                                <th class="column-title">Make</th>
                                <th class="column-title">Availability</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>

<?php $i = 1; ?>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php
                            $srvCount = getservesCount($value->spare_part_no);
                            $oemCount = getoemCount($value->spare_part_no);
                            ?>

                            <tr class="pointer">
                                <td><?php echo e($i++); ?></td>
                                <td><?php echo e($value->spare_part_no); ?></td>
                                <td><?php echo e($value->spare_make); ?></td>
                                <td><?php if($value->spare_avail ==1): ?> In Stock <?php else: ?> Not In Stock <?php endif; ?></td>
                                <td><?php if($value->spare_status ==1): ?> Enable <?php else: ?> Disable <?php endif; ?></td>
                                <td class="last">
                                    <?php if($srvCount>0): ?><a href="<?php echo e(route('spare_services.manage',base64_encode($value->spare_part_no))); ?>" title="Edit" class="mr-4 ml-2 d-inline-block">Services</a> <?php endif; ?> 
                                    <?php if($oemCount>0): ?><a href="<?php echo e(route('spare_oem.manage',base64_encode($value->spare_part_no))); ?>" title="Edit" class="mr-4 ml-2 d-inline-block">OEM</a> <?php endif; ?>
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="<?php echo e(base64_encode($value->spare_id)); ?>" class="editSpare" src="<?php echo e(URL::asset('images/edit.svg')); ?>" alt=""></a> 
                                    <a href="<?php echo e(route('spare.delete',base64_encode($value->spare_id))); ?>"  title="Delete" class="d-inline-block delete confirmation"><img src="<?php echo e(URL::asset('images/delete.svg')); ?>" alt=""></a>
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
                    <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="<?php echo e(route('spare.export',$routeValues)); ?>" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="<?php echo e(URL::asset('images/excel.svg')); ?>" class="pr-2" alt="Export to Excel"> Export to Excel </a></div>

                </div>
            <?php } ?>


        </div>
    </div>
</div>

<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText" >Add Spare</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="spareRegister" action="<?php echo e(route('spare.register')); ?>" enctype="multipart/form-data"> 

                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="spare_id" id="spare_id" >
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
                    <?php /* ?><div class="col-md-3 mb-3">
                      <label for="category">Make</label>
                      <select  class="form-control select"   id="make" name="makeid" onchange="populateProductData(0);" required="">
                      <option value="" >Select Make</option>
                      @foreach($make as $key =>$value)
                      <option value="{{$value['make_id']}}" >{{$value['make_nm']}}</option>
                      @endforeach
                      </select>
                      </div>


                      <div class="col-md-3 mb-3">
                      <label for="product">Product</label>
                      <select  class="form-control select"   id="product" name="prodid" required="">
                      <option value="" >Select make First</option>
                      </select>
                      </div><?php */ ?>

                    <div class="col-md-3 mb-3">
                        <label for="status">Name</label>
                        <?php if($errors->has('spare_nm')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('spare_nm')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="spare_nm" name="spare_nm" placeholder="Spare Name" >
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="status">Part No</label>
                        <?php if($errors->has('spare_part_no')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('spare_part_no')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="spare_part_no" name="spare_part_no" placeholder="Spare Part No" >
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="status">Description</label>
                        <?php if($errors->has('prod_desc')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('spare_desc')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="spare_desc" name="spare_desc" placeholder="Spare Info" >
                    </div>

                    <div class="col-md-3 mb-3">

                        <label for="status" >Availability</label>
                        <?php if($errors->has('spare_avail')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('spare_avail')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <select  class="form-control select " id="spare_avail" name="spare_avail">
                            <option value="1"  >IN Stock</option>
                            <option value="0" >Not in Stock</option>
                        </select>
                    </div>

                </div>

                <div class="row mt-4">



                    <div class="col-md-3 mb-3">
                        <label for="add_inf">Add. Info</label>
                        <?php if($errors->has('spare_add_inf')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('spare_add_inf')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="spare_add_inf" name="spare_add_inf" placeholder="Spare Add. Info" >
                    </div>
                    <!--                    <div class="col-md-3 mb-3">
                                            <label for="prod_price">Price</label>
                                            <?php if($errors->has('spare_price')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('spare_price')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                            <input type="text" class="form-control " autocomplete="off" id="spare_price" name="spare_price" placeholder="Spare Price" >
                                        </div>-->
                    <div class="col-md-3 mb-3">
                        <label for="prod_price">Cargo</label>
                        <?php if($errors->has('spare_cargo')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('spare_cargo')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="spare_cargo" name="spare_cargo" placeholder="Spare Cargo" >
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="prod_price">OEM</label>
                        <?php if($errors->has('spare_oem')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('spare_oem')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="spare_oem" name="spare_oem" placeholder="Spare OEM" >
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="spare_make">Make</label>
                        <?php if($errors->has('spare_make')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('spare_make')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="spare_make" name="spare_make" placeholder="Spare Make" >
                    </div>
                </div>

                <div class="row mt-4">

                    <div class="col-md-3 mb-3">
                        <label for="status">Status</label>
                        <?php if($errors->has('spare_status')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('spare_status')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <select  class="form-control select " id="cstatus" name="spare_status">
                            <option value="1"  >Enable</option>
                            <option value="0" >Disable</option>
                        </select>
                    </div>

                    <div class="col-md-9 mb-3 padRig">
                        <label for="categoryId"> Image (* you can upload up to 8 images.File name should be ALT100-1.jpg till  ALT100-8.jpg. Image size should be 640 X 300)</label>
                        <?php if($errors->has('spare_img1')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('spare_img1')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input name="spare_img[]" type="file" id="serimageInput" multiple>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-3 mb-3 padRig" id="spare_img1"></div>
                    <div class="col-md-3 mb-3 padRig" id="spare_img2"></div>
                    <div class="col-md-3 mb-3 padRig" id="spare_img3"></div>
                    <div class="col-md-3 mb-3 padRig" id="spare_img4"></div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-3 mb-3 padRig" id="spare_img5"></div>
                    <div class="col-md-3 mb-3 padRig" id="spare_img6"></div>
                    <div class="col-md-3 mb-3 padRig" id="spare_img7"></div>
                    <div class="col-md-3 mb-3 padRig" id="spare_img8"></div>
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitSubCategory">Add</button></div>
                </div>



            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>