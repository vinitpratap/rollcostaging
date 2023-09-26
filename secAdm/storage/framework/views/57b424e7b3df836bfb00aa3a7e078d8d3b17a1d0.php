<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Product</h2>
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
                                <th class="column-title">Category</th>
                                <th class="column-title">Make</th>
                                <th class="column-title">Model</th>
                                <th class="column-title">Year</th>
                                <th class="column-title">Exact CCM</th>
                                <th class="column-title">Engine Code</th>
                                <th class="column-title">Product</th>
                                <th class="column-title">Status</th>
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
                                <td><?php echo e(getCatName($value->catid)); ?></td>
                                <td><?php echo e(getMakeName($value->makeid)); ?></td>
                                <td><?php echo e(getModelName($value->modelid)); ?></td>
                                <td><?php echo e(getProYear($value->proyrid)); ?></td>
                                <td><?php echo e(getProCCM($value->proccmid)); ?></td>
                                <td><?php echo e(getEngineCode($value->engid)); ?></td>
                                <td><?php echo e($value->prod_nm); ?></td>
                                <td><?php if($value->prod_status ==1): ?> Enable <?php else: ?> Disable <?php endif; ?></td>
                                <td class="last">
                                    <?php if($apCount>0): ?><a href="<?php echo e(route('product_application.manage',base64_encode($value->prod_part_no))); ?>" title="Edit" class="mr-4 ml-2 d-inline-block">Application</a> <?php endif; ?>                                     
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="<?php echo e(base64_encode($value->prod_id)); ?>" class="editProd" src="<?php echo e(URL::asset('images/edit.svg')); ?>" alt=""></a> 
                                    <a href="<?php echo e(route('product.delete',base64_encode($value->prod_id))); ?>"  title="Delete" class="d-inline-block delete confirmation"><img src="<?php echo e(URL::asset('images/delete.svg')); ?>" alt=""></a>
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
                    <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="<?php echo e(route('product.export',$routeValues)); ?>" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="<?php echo e(URL::asset('images/excel.svg')); ?>" class="pr-2" alt="Export to Excel"> Export to Excel </a></div>

                </div>
            <?php } ?>


        </div>
    </div>
</div>

<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText" >Add Product</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="prodRegister" action="<?php echo e(route('product.register')); ?>" enctype="multipart/form-data"> 

                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="prod_id" id="prod_id" >
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
                    <div class="col-md-3 mb-3">
                        <label for="category">Master Category</label>
                        <select  class="form-control select" id="mcategory" name="mcatid" onchange="populateCategoryData(0);" required="">
                            <option value="" >Select Master Category</option>
                            <?php $__currentLoopData = $mcategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value['mcat_id']); ?>" ><?php echo e($value['mcat_nm']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="category">Category</label>
                        <select  class="form-control select" id="category" name="catid" onchange="populateMakeData(0);" required="">
                            <option value="" >Select Master Category First</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="category">Make</label>
                        <select  class="form-control select"   id="product_make" name="makeid" onchange="populateModelData(0);" required="">
                            <option value="" >Select Category First</option>
                        </select>
                    </div>


                    <div class="col-md-3 mb-3 padRig">
                        <label for="categoryName">Model </label>
                        <select  class="form-control select"   id="product_model" name="modelid" required="" onchange="populateYearData(0);">
                            <option value="" >Select Make First</option>
                        </select>
                    </div>



                </div>

                <div class="row mt-4">
                    <div class="col-md-3 mb-3">
                        <label for="categoryName">Year </label>
                        <select  class="form-control select"   id="proyr" name="proyrid" required="" onchange="populateCCMData(0);">
                            <option value="" >Select Model First</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="categoryName">CCM </label>
                        <select  class="form-control select"   id="proccm" name="proccmid" onchange="populateEngCodeData(0);" required="">
                            <option value="" >Select Year First</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="categoryName">Engine Code</label>
                        <select  class="form-control select"   id="engcode" name="engid" required="">
                            <option value="" >Select CCM First</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="status">Name</label>
                        <?php if($errors->has('prod_nm')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('prod_nm')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="prod_nm" name="prod_nm" placeholder="Product Name" >
                    </div>


                </div>
                <div class="row mt-4">
                    <div class="col-md-3 mb-3">
                        <label for="status">Part No</label>
                        <?php if($errors->has('prod_part_no')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('prod_part_no')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="prod_part_no" name="prod_part_no" placeholder="Product Part No" >
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="status">Description</label>
                        <?php if($errors->has('prod_desc')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('prod_desc')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="prod_desc" name="prod_desc" placeholder="Product Info" >
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="add_inf">Add. Info</label>
                        <?php if($errors->has('prod_add_inf')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('prod_add_inf')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="prod_add_inf" name="prod_add_inf" placeholder="Product Add. Info" >
                    </div>

                    
                    <div class="col-md-3 mb-3">

                        <label for="status" >Stock</label>
                        <?php if($errors->has('prod_stock')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('prod_stock')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <select  class="form-control select " id="prod_stock" name="prod_stock">
                            <option value="1"  >IN Stock</option>
                            <option value="0" >Not in Stock</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-3 mb-3">
                        <label for="ptype" onclick="changeInputState('ptype')">
                            <input type="checkbox" name="push" class="custom-control-input ptype" id="prtype" >
                            <span class="notreq">Type</span></label>
                        <?php if($errors->has('ptype')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('ptype')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="ptype" name="ptype" placeholder="Product Type" disabled="disabled">
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="position" onclick="changeInputState('position')">
                            <input type="checkbox" name="push" class="custom-control-input position" id="prposition" >
                            <span class="notreq">Position</span></label>
                        <?php if($errors->has('position')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('position')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="position" name="position" placeholder="Product Position" disabled="disabled">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="voltage" onclick="changeInputState('prod_volt')">
                            <input type="checkbox" name="push" class="custom-control-input prod_volt" id="voltage" >
                            <span class="notreq">Voltage</span></label>
                        <?php if($errors->has('prod_volt')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('prod_volt')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="prod_volt" name="prod_volt" placeholder="Product Voltage" disabled="disabled">
                    </div>


                    <div class="col-md-3 mb-3">
                        <label for="pout" onclick="changeInputState('prod_out')">
                            <input type="checkbox" name="push" class="custom-control-input prod_out" id="pout" >
                            <span class="notreq">Output</span></label>
                        <?php if($errors->has('prod_out')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('prod_out')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="prod_out" name="prod_out" placeholder="Product Output" disabled="disabled">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-3 mb-3">
                        <label for="regulator" onclick="changeInputState('prod_regu')">
                            <input type="checkbox" name="push" class="custom-control-input prod_regu" id="regulator" >
                            <span class="notreq">Regulator</span></label>
                        <?php if($errors->has('prod_regu')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('prod_regu')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="prod_regu" name="prod_regu" placeholder="Product Regulator" disabled="disabled" >
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="prod_pull" onclick="changeInputState('prod_pull_type')">
                            <input type="checkbox" name="push" class="custom-control-input prod_pull_type" id="prod_pull" >
                            <span class="notreq">Pulley Type</span></label>
                        <?php if($errors->has('prod_pull_type')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('prod_pull_type')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="prod_pull_type" name="prod_pull_type" placeholder="Product Pulley Type" disabled="disabled">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="fan" onclick="changeInputState('prod_fan')">
                            <input type="checkbox" name="push" class="custom-control-input prod_fan" id="fan" >
                            <span class="notreq">Fan</span></label>
                        <?php if($errors->has('prod_fan')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('prod_fan')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="prod_fan" name="prod_fan" placeholder="Product Fan" disabled="disabled">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="pteeth" onclick="changeInputState('prod_teeth')">
                            <input type="checkbox" name="push" class="custom-control-input prod_teeth" id="pteeth" >
                            <span class="notreq">Teeth</span></label>
                        <?php if($errors->has('prod_teeth')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('prod_teeth')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="prod_teeth" name="prod_teeth" placeholder="Product teeth" disabled="disabled">
                    </div>

                </div>

                <div class="row mt-4">


                    <div class="col-md-3 mb-3">
                        <label for="gr" onclick="changeInputState('gr')">
                            <input type="checkbox" name="push" class="custom-control-input gr" id="prgr" >
                            <span class="notreq">GR</span></label>
                        <?php if($errors->has('gr')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('gr')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="gr" name="gr" placeholder="Product GR" disabled="disabled">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="ptrans" onclick="changeInputState('prod_trans')">
                            <input type="checkbox" name="push" class="custom-control-input prod_trans" id="ptrans" >
                            <span class="notreq">Transmission</span></label>
                        <?php if($errors->has('prod_trans')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('prod_trans')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="prod_trans" name="prod_trans" placeholder="Product transmission" disabled="disabled">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="prot" onclick="changeInputState('prod_rot')">
                        <input type="checkbox" name="push" class="custom-control-input prod_rot" id="prot" >
                        <span class="notreq">Rotation</span></label>
                        <?php if($errors->has('prod_rot')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('prod_rot')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="prod_rot" name="prod_rot" placeholder="Product rotation" disabled="disabled">
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="car_fits" onclick="changeInputState('car_fits')">
                        <input type="checkbox" name="push" class="custom-control-input car_fits" id="prcar_fits" >
                        <span class="notreq">Car Fits</span></label>
                        <?php if($errors->has('car_fits')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('car_fits')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="car_fits" name="car_fits" placeholder="Product Car Fits" disabled="disabled">
                    </div>

                </div>

                <div class="row mt-4">
                    
                    <div class="col-md-3 mb-3">
                        <label for="fuel" onclick="changeInputState('fuel')">
                        <input type="checkbox" name="push" class="custom-control-input fuel" id="prfuel" >
                        <span class="notreq">Fuel</span></label>
                        <?php if($errors->has('fuel')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('fuel')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control" autocomplete="off" id="fuel" name="fuel" placeholder="Product Fuel" disabled="disabled">
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="external_teeth" onclick="changeInputState('external_teeth')">
                        <input type="checkbox" name="push" class="custom-control-input external_teeth" id="prexternal_teeth" >
                        <span class="notreq">External Teeth</span></label>
                        <?php if($errors->has('external_teeth')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('external_teeth')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control" autocomplete="off" id="external_teeth" name="external_teeth" placeholder="Product External Teeth" disabled="disabled">
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="internal_teeth" onclick="changeInputState('internal_teeth')">
                        <input type="checkbox" name="push" class="custom-control-input internal_teeth" id="printernal_teeth" >
                        <span class="notreq">Internal Teeth</span></label>
                        <?php if($errors->has('internal_teeth')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('internal_teeth')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control" autocomplete="off" id="internal_teeth" name="internal_teeth" placeholder="Product Internal Teeth" disabled="disabled">
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="height" onclick="changeInputState('height')">
                        <input type="checkbox" name="push" class="custom-control-input height" id="prheight" >
                        <span class="notreq">Height</span></label>
                        <?php if($errors->has('height')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('height')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control" autocomplete="off" id="height" name="height" placeholder="Product Height" disabled="disabled">
                    </div>

                </div>

                <div class="row mt-4">
                    
                    <div class="col-md-3 mb-3">
                        <label for="abs_ring" onclick="changeInputState('abs_ring')">
                        <input type="checkbox" name="push" class="custom-control-input abs_ring" id="prabs_ring" >
                        <span class="notreq">Number of Teeth, ABS ring</span></label>
                        <?php if($errors->has('abs_ring')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('abs_ring')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control" autocomplete="off" id="abs_ring" name="abs_ring" placeholder="Product Abs Ring" disabled="disabled">
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="pdim" onclick="changeInputState('prod_dim')">
                        <input type="checkbox" name="push" class="custom-control-input prod_dim" id="pdim" >
                        <span class="notreq">Dimension</span></label>
                        <?php if($errors->has('prod_dim')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('prod_dim')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="prod_dim" name="prod_dim" placeholder="Product dimension" disabled="disabled" >
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="cylinders" onclick="changeInputState('cylinders')">
                        <input type="checkbox" name="push" class="custom-control-input cylinders" id="prcylinders" >
                        <span class="notreq">Cylinders</span></label>
                        <?php if($errors->has('cylinders')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('cylinders')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="cylinders" name="cylinders" placeholder="Product cylinders" disabled="disabled" >
                    </div>
                    
                    
                    
                </div>

                <div class="row mt-4">
<!--                    <div class="col-md-3 mb-3">
                        <label for="prod_price">Price</label>
                        <?php if($errors->has('prod_price')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('prod_price')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input type="text" class="form-control " autocomplete="off" id="prod_price" name="prod_price" placeholder="Product Price" >
                    </div>-->
                    <div class="col-md-3 mb-3">
                        <label for="mscode">MS Code</label>
                        <?php if($errors->has('mscode')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('mscode')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <textarea class="form-control"  rows="10" placeholder="Description" id="mscode" name="mscode" ></textarea>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="status">Status</label>
                        <?php if($errors->has('prod_status')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('prod_status')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <select  class="form-control select " id="cstatus" name="prod_status">
                            <option value="1"  >Enable</option>
                            <option value="0" >Disable</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="status">Latest</label>
                        <?php if($errors->has('is_latest')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('is_latest')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <select  class="form-control select " id="is_latest" name="is_latest">
                            <option value="0"  >No</option>
                            <option value="1" >Yes</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12 col-lg-12  mb-3">            
                        <label for="description">Overview</label>
                        <?php if($errors->has('prod_overview')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('prod_overview')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <textarea class="form-control"  rows="10" placeholder="Overview" id="prod_overview" name="prod_overview" ></textarea>
                    </div>

                </div>
                <div class="row mt-4">
                    <div class="col-md-12 mb-3 padRig">
                        <label for="categoryId"> Image <br/>(* you can upload up to 8 images.File name should be ALT100-1.jpg till  ALT100-8.jpg. Image size should be 640 X 300)</label>
                        <?php if($errors->has('prod_img1')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('prod_img1')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input  name="prod_img[]" type="file" id="serimageInput" multiple>
                    </div>
<!--                    <div class="col-md-3 mb-3 padRig">
                        <label for="categoryId"> Image 2</label>
                        <?php if($errors->has('prod_img1')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('prod_img2')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input  name="prod_img2" type="file" id="serimageInput" >
                    </div>
                    <div class="col-md-3 mb-3 padRig">
                        <label for="categoryId"> Image 3</label>
                        <?php if($errors->has('prod_img3')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('prod_img3')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input  name="prod_img3" type="file" id="serimageInput" >
                    </div>
                    <div class="col-md-3 mb-3 padRig">
                        <label for="categoryId"> Image 4</label>
                        <?php if($errors->has('prod_img4')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('prod_img4')); ?></strong>
                        </span>
                        <?php endif; ?>
                        <input  name="prod_img4" type="file" id="serimageInput" >
                    </div>-->
                </div>
                <div class="row mt-4">
                    <div class="col-md-3 mb-3 padRig" id="prod_img1"></div>
                    <div class="col-md-3 mb-3 padRig" id="prod_img2"></div>
                    <div class="col-md-3 mb-3 padRig" id="prod_img3"></div>
                    <div class="col-md-3 mb-3 padRig" id="prod_img4"></div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-3 mb-3 padRig" id="prod_img5"></div>
                    <div class="col-md-3 mb-3 padRig" id="prod_img6"></div>
                    <div class="col-md-3 mb-3 padRig" id="prod_img7"></div>
                    <div class="col-md-3 mb-3 padRig" id="prod_img8"></div>
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