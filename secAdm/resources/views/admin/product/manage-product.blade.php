@extends('admin.layouts.app')
 
@section('content')
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
                                <input type="text" placeholder="Search by" name="search"  autocomplete="off" class="form-control" value="{{ app('request')->input('search') }}">
                            </div>

                            <div class="col-md-4 mb-3 padRig">
                                <label>Show Entries</label>
                                <select class="form-control select" id="data_entries" name="data_entries" >                                    @foreach($pagination_arr as $val)
                                    <option value="{{$val}}" <?php if (app('request')->input('data_entries') == $val) { ?> selected <?php } ?>>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 pt-35 padRig">
                                <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase">Search</button>
                            </div>



                        </div>
                        {{ csrf_field() }}

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

                            <?php $i = 1; ?>
                            @foreach($data as $key=>$value)
                            <?php
                            $apCount = getapCount($value->prod_part_no);
                            ?>

                            <tr class="pointer">
                                <td>{{$i++}}</td>
                                <td>{{getCatName($value->catid)}}</td>
                                <td>{{getMakeName($value->makeid)}}</td>
                                <td>{{getModelName($value->modelid)}}</td>
                                <td>{{getProYear($value->proyrid)}}</td>
                                <td>{{getProCCM($value->proccmid)}}</td>
                                <td>{{getEngineCode($value->engid)}}</td>
                                <td>{{$value->prod_nm}}</td>
                                <td>@if($value->prod_status ==1) Enable @else Disable @endif</td>
                                <td class="last">
                                    <?php $routeValues1 = 'search=' . $value->prod_nm; ?>
                                    @if($apCount>0)<a href="{{route('application.manage',$routeValues1)}}" title="Edit" class="mr-4 ml-2 d-inline-block">Application</a> @else NA @endif                                     
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="{{base64_encode($value->prod_id)}}" class="editProd" src="{{ URL::asset('images/edit.svg') }}" alt=""></a> 
                                    <a href="{{route('product.delete',base64_encode($value->prod_id))}}"  title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
            {{ $data->links('common.custompagination') }}
            <div class="clearfix"></div>
            <?php if (count($data) > 0) { ?>
                <div class="row  m-0">
                    <div class="col-6"><span>Total  {{ $data->total() }} records</span></div>
                    <?php $routeValues = 'search=' . app('request')->input('search'); ?>
                    <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="{{route('product.export',$routeValues)}}" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="{{ URL::asset('images/excel.svg') }}" class="pr-2" alt="Export to CSV"> Export to CSV </a></div>

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
            <form method="post" id="prodRegister" action="{{route('product.register')}}" enctype="multipart/form-data"> 

                {{ csrf_field() }}
                <input type="hidden" name="prod_id" id="prod_id" >
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.								
                    @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach								
                </div>
                @endif
                @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @endif
                <div class="row mt-4">
                    <div class="col-md-3 mb-3">
                        <label for="category">Master Category</label>
                        <select  class="form-control select" id="mcategory" name="mcatid" onchange="populateCategoryData(0);" required="">
                            <option value="" >Select Master Category</option>
                            @foreach($mcategory as $key =>$value)
                            <option value="{{$value['mcat_id']}}" >{{$value['mcat_nm']}}</option>
                            @endforeach
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
                        <select  class="form-control select"   id="proccm" name="proccmid" onchange="populateEngCodeData(0);">
                            <option value="" >Select Year First</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="categoryName">Engine Code</label>
                        <select  class="form-control select"   id="engcode" name="engid" >
                            <option value="" >Select CCM First</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="status">Name</label>
                        @if ($errors->has('prod_nm'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prod_nm') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="prod_nm" name="prod_nm" placeholder="Product Name" >
                    </div>


                </div>
                <div class="row mt-4">
                    <div class="col-md-3 mb-3">
                        <label for="status">Part No</label>
                        @if ($errors->has('prod_part_no'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prod_part_no') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="prod_part_no" name="prod_part_no" placeholder="Product Part No" >
                    </div>

                    <!--<div class="col-md-3 mb-3">
                        <label for="status">Description</label>
                        @if ($errors->has('prod_desc'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prod_desc') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="prod_desc" name="prod_desc" placeholder="Product Info" >
                    </div>-->

                    <div class="col-md-3 mb-3">
                        <label for="add_inf">Add. Info</label>
                        @if ($errors->has('prod_add_inf'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prod_add_inf') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="prod_add_inf" name="prod_add_inf" placeholder="Product Add. Info" >
                    </div>


                    <!--<div class="col-md-3 mb-3">

                        <label for="status" >Stock</label>
                        @if ($errors->has('prod_stock'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prod_stock') }}</strong>
                        </span>
                        @endif
                        <select  class="form-control select " id="prod_stock" name="prod_stock">
                            <option value="1"  >IN Stock</option>
                            <option value="0" >Not in Stock</option>
                        </select>
                    </div>-->
                </div>
                <div class="row mt-4">
                    <div class="col-md-3 mb-3">
                        <label for="ptype" onclick="changeInputState('ptype')">
                            <input type="checkbox" name="push" class="custom-control-input ptype" id="prtype" >
                            <span class="notreq">Type (Description)</span></label>
                        @if ($errors->has('ptype'))
                        <span class="help-block">
                            <strong>{{ $errors->first('ptype') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="ptype" name="ptype" placeholder="Product Type" disabled="disabled">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="position" onclick="changeInputState('position')">
                            <input type="checkbox" name="push" class="custom-control-input position" id="prposition" >
                            <span class="notreq">Position</span></label>
                        @if ($errors->has('position'))
                        <span class="help-block">
                            <strong>{{ $errors->first('position') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="position" name="position" placeholder="Product Position" disabled="disabled">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="voltage" onclick="changeInputState('prod_volt')">
                            <input type="checkbox" name="push" class="custom-control-input prod_volt" id="voltage" >
                            <span class="notreq">Voltage</span></label>
                        @if ($errors->has('prod_volt'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prod_volt') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="prod_volt" name="prod_volt" placeholder="Product Voltage" disabled="disabled">
                    </div>


                    <div class="col-md-3 mb-3">
                        <label for="pout" onclick="changeInputState('prod_out')">
                            <input type="checkbox" name="push" class="custom-control-input prod_out" id="pout" >
                            <span class="notreq">Output</span></label>
                        @if ($errors->has('prod_out'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prod_out') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="prod_out" name="prod_out" placeholder="Product Output" disabled="disabled">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-3 mb-3">
                        <label for="regulator" onclick="changeInputState('prod_regu')">
                            <input type="checkbox" name="push" class="custom-control-input prod_regu" id="regulator" >
                            <span class="notreq">Regulator</span></label>
                        @if ($errors->has('prod_regu'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prod_regu') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="prod_regu" name="prod_regu" placeholder="Product Regulator" disabled="disabled" >
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="prod_pull" onclick="changeInputState('prod_pull_type')">
                            <input type="checkbox" name="push" class="custom-control-input prod_pull_type" id="prod_pull" >
                            <span class="notreq">Pulley Type</span></label>
                        @if ($errors->has('prod_pull_type'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prod_pull_type') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="prod_pull_type" name="prod_pull_type" placeholder="Product Pulley Type" disabled="disabled">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="fan" onclick="changeInputState('prod_fan')">
                            <input type="checkbox" name="push" class="custom-control-input prod_fan" id="fan" >
                            <span class="notreq">Fan</span></label>
                        @if ($errors->has('prod_fan'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prod_fan') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="prod_fan" name="prod_fan" placeholder="Product Fan" disabled="disabled">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="pteeth" onclick="changeInputState('prod_teeth')">
                            <input type="checkbox" name="push" class="custom-control-input prod_teeth" id="pteeth" >
                            <span class="notreq">Teeth</span></label>
                        @if ($errors->has('prod_teeth'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prod_teeth') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="prod_teeth" name="prod_teeth" placeholder="Product teeth" disabled="disabled">
                    </div>

                </div>

                <div class="row mt-4">


                    <div class="col-md-3 mb-3">
                        <label for="gr" onclick="changeInputState('gr')">
                            <input type="checkbox" name="push" class="custom-control-input gr" id="prgr" >
                            <span class="notreq">GR</span></label>
                        @if ($errors->has('gr'))
                        <span class="help-block">
                            <strong>{{ $errors->first('gr') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="gr" name="gr" placeholder="Product GR" disabled="disabled">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="ptrans" onclick="changeInputState('prod_trans')">
                            <input type="checkbox" name="push" class="custom-control-input prod_trans" id="ptrans" >
                            <span class="notreq">Transmission</span></label>
                        @if ($errors->has('prod_trans'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prod_trans') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="prod_trans" name="prod_trans" placeholder="Product transmission" disabled="disabled">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="prot" onclick="changeInputState('prod_rot')">
                            <input type="checkbox" name="push" class="custom-control-input prod_rot" id="prot" >
                            <span class="notreq">Rotation</span></label>
                        @if ($errors->has('prod_rot'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prod_rot') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="prod_rot" name="prod_rot" placeholder="Product rotation" disabled="disabled">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="car_fits" onclick="changeInputState('car_fits')">
                            <input type="checkbox" name="push" class="custom-control-input car_fits" id="prcar_fits" >
                            <span class="notreq">Car Fits</span></label>
                        @if ($errors->has('car_fits'))
                        <span class="help-block">
                            <strong>{{ $errors->first('car_fits') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="car_fits" name="car_fits" placeholder="Product Car Fits" disabled="disabled">
                    </div>

                </div>

                <div class="row mt-4">

                    <div class="col-md-3 mb-3">
                        <label for="fuel" onclick="changeInputState('fuel')">
                            <input type="checkbox" name="push" class="custom-control-input fuel" id="prfuel" >
                            <span class="notreq">Fuel</span></label>
                        @if ($errors->has('fuel'))
                        <span class="help-block">
                            <strong>{{ $errors->first('fuel') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control" autocomplete="off" id="fuel" name="fuel" placeholder="Product Fuel" disabled="disabled">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="external_teeth" onclick="changeInputState('external_teeth')">
                            <input type="checkbox" name="push" class="custom-control-input external_teeth" id="prexternal_teeth" >
                            <span class="notreq">External Teeth</span></label>
                        @if ($errors->has('external_teeth'))
                        <span class="help-block">
                            <strong>{{ $errors->first('external_teeth') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control" autocomplete="off" id="external_teeth" name="external_teeth" placeholder="Product External Teeth" disabled="disabled">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="internal_teeth" onclick="changeInputState('internal_teeth')">
                            <input type="checkbox" name="push" class="custom-control-input internal_teeth" id="printernal_teeth" >
                            <span class="notreq">Internal Teeth</span></label>
                        @if ($errors->has('internal_teeth'))
                        <span class="help-block">
                            <strong>{{ $errors->first('internal_teeth') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control" autocomplete="off" id="internal_teeth" name="internal_teeth" placeholder="Product Internal Teeth" disabled="disabled">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="height" onclick="changeInputState('height')">
                            <input type="checkbox" name="push" class="custom-control-input height" id="prheight" >
                            <span class="notreq">Height</span></label>
                        @if ($errors->has('height'))
                        <span class="help-block">
                            <strong>{{ $errors->first('height') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control" autocomplete="off" id="height" name="height" placeholder="Product Height" disabled="disabled">
                    </div>

                </div>

                <div class="row mt-4">

                    <div class="col-md-3 mb-3">
                        <label for="abs_ring" onclick="changeInputState('abs_ring')">
                            <input type="checkbox" name="push" class="custom-control-input abs_ring" id="prabs_ring" >
                            <span class="notreq">Number of Teeth, ABS ring</span></label>
                        @if ($errors->has('abs_ring'))
                        <span class="help-block">
                            <strong>{{ $errors->first('abs_ring') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control" autocomplete="off" id="abs_ring" name="abs_ring" placeholder="Product Abs Ring" disabled="disabled">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="pdim" onclick="changeInputState('prod_dim')">
                            <input type="checkbox" name="push" class="custom-control-input prod_dim" id="pdim" >
                            <span class="notreq">Dimension</span></label>
                        @if ($errors->has('prod_dim'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prod_dim') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="prod_dim" name="prod_dim" placeholder="Product dimension" disabled="disabled" >
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="cylinders" onclick="changeInputState('cylinders')">
                            <input type="checkbox" name="push" class="custom-control-input cylinders" id="prcylinders" >
                            <span class="notreq">Cylinders</span></label>
                        @if ($errors->has('cylinders'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cylinders') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="cylinders" name="cylinders" placeholder="Product cylinders" disabled="disabled" >
                    </div>



                </div>

                <div class="row mt-4">
                    <!--                    <div class="col-md-3 mb-3">
                                            <label for="prod_price">Price</label>
                                            @if ($errors->has('prod_price'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('prod_price') }}</strong>
                                            </span>
                                            @endif
                                            <input type="text" class="form-control " autocomplete="off" id="prod_price" name="prod_price" placeholder="Product Price" >
                                        </div>-->
                    <div class="col-md-3 mb-3">
                        <label for="mscode">MS Code</label>
                        @if ($errors->has('mscode'))
                        <span class="help-block">
                            <strong>{{ $errors->first('mscode') }}</strong>
                        </span>
                        @endif
                        <textarea class="form-control"  rows="10" placeholder="Description" id="mscode" name="mscode" ></textarea>
                    </div>

                    <!--<div class="col-md-3 mb-3">
                        <label for="status">Status</label>
                        @if ($errors->has('prod_status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prod_status') }}</strong>
                        </span>
                        @endif
                        <select  class="form-control select " id="cstatus" name="prod_status">
                            <option value="1"  >Enable</option>
                            <option value="0" >Disable</option>
                        </select>
                    </div>-->

                    <!-- <div class="col-md-3 mb-3">
                         <label for="status">Latest</label>
                         @if ($errors->has('is_latest'))
                         <span class="help-block">
                             <strong>{{ $errors->first('is_latest') }}</strong>
                         </span>
                         @endif
                         <select  class="form-control select " id="is_latest" name="is_latest">
                             <option value="0"  >No</option>
                             <option value="1" >Yes</option>
                         </select>
                     </div>-->
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12 col-lg-12  mb-3">            
                        <label for="description">Overview</label>
                        @if ($errors->has('prod_overview'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prod_overview') }}</strong>
                        </span>
                        @endif
                        <textarea class="form-control"  rows="10" placeholder="Overview" id="prod_overview" name="prod_overview" ></textarea>
                    </div>

                </div>
                <div class="row mt-4">
                    <div class="col-md-12 mb-3 padRig">
                        <label for="categoryId"> Image <br/>(* you can upload up to 8 images.File name should be ALT100-1.jpg till  ALT100-8.jpg. Image size should be 640 X 300)</label>
                        @if ($errors->has('prod_img1'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prod_img1') }}</strong>
                        </span>
                        @endif
                        <input  name="prod_img[]" type="file" id="serimageInput" multiple>
                    </div>
                    <!--                    <div class="col-md-3 mb-3 padRig">
                                            <label for="categoryId"> Image 2</label>
                                            @if ($errors->has('prod_img1'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('prod_img2') }}</strong>
                                            </span>
                                            @endif
                                            <input  name="prod_img2" type="file" id="serimageInput" >
                                        </div>
                                        <div class="col-md-3 mb-3 padRig">
                                            <label for="categoryId"> Image 3</label>
                                            @if ($errors->has('prod_img3'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('prod_img3') }}</strong>
                                            </span>
                                            @endif
                                            <input  name="prod_img3" type="file" id="serimageInput" >
                                        </div>
                                        <div class="col-md-3 mb-3 padRig">
                                            <label for="categoryId"> Image 4</label>
                                            @if ($errors->has('prod_img4'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('prod_img4') }}</strong>
                                            </span>
                                            @endif
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
@endsection