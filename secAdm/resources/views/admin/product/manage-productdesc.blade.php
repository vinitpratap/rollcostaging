@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Product Description</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
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
                                    <option value="{{$val}}" <?php if(app('request')->input('data_entries') == $val) {?> selected <?php } ?>>{{$val}}</option>
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
                                <th class="column-title">Product</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Action</th>
                                <th class="column-title">Delete Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php $i = 1;?>
                            @foreach($data as $key=>$value)
                            <?php 
                            $apCount = getapCount($value->prod_part_no);
                            ?>

                            <tr class="pointer">
                                <td>{{$i++}}</td>
                                <td>{{getCatName($value->catid)}}</td>
                                <td>{{$value->prod_nm}}</td>
                                <td>
                                   @if($value->prod_status == 1) Enable @else Disable @endif 
                                </td>
                                <td class="last">
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="{{base64_encode($value->prod_nm)}}" class="editProdDesc" src="{{ URL::asset('images/edit.svg') }}" alt=""></a> 
                                  
                                </td>
                                <td class="last">                                     
                                    <a href="{{route('prodimage.delete',base64_encode($value->prod_nm))}}"  title="Delete" class="d-inline-block delete confirmation1"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
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
                    
                </div>
            <?php } ?>


        </div>
    </div>
</div>

<div class="row pt-3 proddescform" style="display:none;">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText" >Edit Product Description</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="prodRegister" action="{{route('productdesc.edit')}}" enctype="multipart/form-data"> 

                {{ csrf_field() }}
                <input type="hidden" name="prod_name" id="prod_name" >
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
                        <label for="status">Name</label>
                        @if ($errors->has('prod_nm'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prod_nm') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="prod_nm" name="prod_nm" placeholder="Product Name" >
                    </div>
					
                    <div class="col-md-3 mb-3">
                        <label for="status">Part No</label>
                        @if ($errors->has('prod_part_no'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prod_part_no') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="prod_part_no" name="prod_part_no" placeholder="Product Part No" >
                    </div>

                    
                    <div class="col-md-3 mb-3">
                        <label for="add_inf">Add. Info</label>
                        @if ($errors->has('prod_add_inf'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prod_add_inf') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="prod_add_inf" name="prod_add_inf" placeholder="Product Add. Info" >
                    </div>

                    
                    <div class="col-md-3 mb-3">

                        <label for="status" >Stock</label>
                        @if ($errors->has('prod_stock'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prod_stock') }}</strong>
                        </span>
                        @endif
                        <select  class="form-control select " id="prod_stock" name="prod_stock">
                            <option value="1"  >IN Stock</option>
                            <option value="2"  >Low Stock</option>
                            <option value="0" >Not in Stock</option>
                        </select>
                    </div>
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
					
					<div class="col-md-3 mb-3">
                        <label for="Weight" onclick="changeInputState('Weight')">
                        <input type="checkbox" name="push" class="custom-control-input Weight" id="prcy_weight" >
                        <span class="notreq">Weight</span></label>
                        @if ($errors->has('Weight'))
                        <span class="help-block">
                            <strong>{{ $errors->first('Weight') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="Weight" name="Weight" placeholder="Product Weight" disabled="disabled" >
                    </div>
                    
                    
                    
                </div>
				
				<div class="row mt-4">
                    
                    <div class="col-md-3 mb-3">
                        <label for="Disc_Dia" onclick="changeInputState('Disc_Dia')">
                        <input type="checkbox" name="push" class="custom-control-input Disc_Dia" id="prDisc_Dia" >
                        <span class="notreq">Disc Dia.</span></label>
                        @if ($errors->has('Disc_Dia'))
                        <span class="help-block">
                            <strong>{{ $errors->first('Disc_Dia') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control" autocomplete="off" id="Disc_Dia" name="Disc_Dia" placeholder="Product Disc Dia" disabled="disabled">
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="Disc_Thick" onclick="changeInputState('Disc_Thick')">
                        <input type="checkbox" name="push" class="custom-control-input Disc_Thick" id="prDisc_Thick" >
                        <span class="notreq">Disc Thick</span></label>
                        @if ($errors->has('Disc_Thick'))
                        <span class="help-block">
                            <strong>{{ $errors->first('Disc_Thick') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="Disc_Thick" name="Disc_Thick" placeholder="Disc Thick" disabled="disabled" >
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="Piston_Dia" onclick="changeInputState('Piston_Dia')">
                        <input type="checkbox" name="push" class="custom-control-input Piston_Dia" id="prPiston_Dia" >
                        <span class="notreq">Piston Dia</span></label>
                        @if ($errors->has('Piston_Dia'))
                        <span class="help-block">
                            <strong>{{ $errors->first('Piston_Dia') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="Piston_Dia" name="Piston_Dia" placeholder="Piston Dia" disabled="disabled" >
                    </div>
					
					<div class="col-md-3 mb-3">
                        <label for="Man" onclick="changeInputState('Man')">
                        <input type="checkbox" name="push" class="custom-control-input Man" id="prMan" >
                        <span class="notreq">Man</span></label>
                        @if ($errors->has('Man'))
                        <span class="help-block">
                            <strong>{{ $errors->first('Man') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="Man" name="Man" placeholder="Product Man" disabled="disabled" >
                    </div>
                    
                    
                    
                </div>


<div class="row mt-4">
                    
                    <div class="col-md-3 mb-3">
                        <label for="Pump_Type" onclick="changeInputState('Pump_Type')">
                        <input type="checkbox" name="push" class="custom-control-input Pump_Type" id="prPump_Type" >
                        <span class="notreq">Pump Type</span></label>
                        @if ($errors->has('Pump_Type'))
                        <span class="help-block">
                            <strong>{{ $errors->first('Pump_Type') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control" autocomplete="off" id="Pump_Type" name="Pump_Type" placeholder="Product Pump Type" disabled="disabled">
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="Pressure" onclick="changeInputState('Pressure')">
                        <input type="checkbox" name="push" class="custom-control-input Pressure" id="prPressure" >
                        <span class="notreq">Pressure</span></label>
                        @if ($errors->has('Pressure'))
                        <span class="help-block">
                            <strong>{{ $errors->first('Pressure') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="Pressure" name="Pressure" placeholder="Pressure" disabled="disabled" >
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="Pully_Ribs" onclick="changeInputState('Pully_Ribs')">
                        <input type="checkbox" name="push" class="custom-control-input Pully_Ribs" id="prPully_Ribs" >
                        <span class="notreq">Pully Ribs</span></label>
                        @if ($errors->has('Pully_Ribs'))
                        <span class="help-block">
                            <strong>{{ $errors->first('Pully_Ribs') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="Pully_Ribs" name="Pully_Ribs" placeholder="Pully Ribs" disabled="disabled" >
                    </div>
					
					<div class="col-md-3 mb-3">
                        <label for="Total_Length" onclick="changeInputState('Total_Length')">
                        <input type="checkbox" name="push" class="custom-control-input Total_Length" id="prTotal_Length" >
                        <span class="notreq">Total Length</span></label>
                        @if ($errors->has('Total_Length'))
                        <span class="help-block">
                            <strong>{{ $errors->first('Total_Length') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="Total_Length" name="Total_Length" placeholder="Product Total Length" disabled="disabled" >
                    </div>
                    
                    
                    
                </div>
				
		
<div class="row mt-4">
                    
                    <div class="col-md-3 mb-3">
                        <label for="Pin" onclick="changeInputState('Pin')">
                        <input type="checkbox" name="push" class="custom-control-input Pin" id="prPin" >
                        <span class="notreq">Pin</span></label>
                        @if ($errors->has('Pin'))
                        <span class="help-block">
                            <strong>{{ $errors->first('Pin') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control" autocomplete="off" id="Pin" name="Pin" placeholder="Product Pin" disabled="disabled">
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="Fitting_position" onclick="changeInputState('Fitting_position')">
                        <input type="checkbox" name="push" class="custom-control-input Fitting_position" id="prFitting_position" >
                        <span class="notreq">Fitting position</span></label>
                        @if ($errors->has('Fitting_position'))
                        <span class="help-block">
                            <strong>{{ $errors->first('Fitting_position') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="Fitting_position" name="Fitting_position" placeholder="Fitting position" disabled="disabled" >
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="No_of_Holes" onclick="changeInputState('No_of_Holes')">
                        <input type="checkbox" name="push" class="custom-control-input No_of_Holes" id="prNo_of_Holes" >
                        <span class="notreq">No of Holes</span></label>
                        @if ($errors->has('No_of_Holes'))
                        <span class="help-block">
                            <strong>{{ $errors->first('No_of_Holes') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="No_of_Holes" name="No_of_Holes" placeholder="No of Holes" disabled="disabled" >
                    </div>
					
					<div class="col-md-3 mb-3">
                        <label for="Bolt_Hole_Circle_Dia" onclick="changeInputState('Bolt_Hole_Circle_Dia')">
                        <input type="checkbox" name="push" class="custom-control-input Bolt_Hole_Circle_Dia" id="prBolt_Hole_Circle_Dia" >
                        <span class="notreq">Bolt Hole Circle Dia</span></label>
                        @if ($errors->has('Bolt_Hole_Circle_Dia'))
                        <span class="help-block">
                            <strong>{{ $errors->first('Bolt_Hole_Circle_Dia') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="Bolt_Hole_Circle_Dia" name="Bolt_Hole_Circle_Dia" placeholder="Product Bolt Hole Circle Dia" disabled="disabled" >
                    </div>
                    
                    
                    
                </div>	

<div class="row mt-4">
                    
                    <div class="col-md-3 mb-3">
                        <label for="Inner_Dia" onclick="changeInputState('Inner_Dia')">
                        <input type="checkbox" name="push" class="custom-control-input Inner_Dia" id="prInner_Dia" >
                        <span class="notreq">Inner Dia</span></label>
                        @if ($errors->has('Inner_Dia'))
                        <span class="help-block">
                            <strong>{{ $errors->first('Inner_Dia') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control" autocomplete="off" id="Inner_Dia" name="Inner_Dia" placeholder="Product Inner Dia" disabled="disabled">
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="Outer_Dia" onclick="changeInputState('Outer_Dia')">
                        <input type="checkbox" name="push" class="custom-control-input Outer_Dia" id="prOuter_Dia" >
                        <span class="notreq">Outer Dia</span></label>
                        @if ($errors->has('Outer_Dia'))
                        <span class="help-block">
                            <strong>{{ $errors->first('Outer_Dia') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="Outer_Dia" name="Outer_Dia" placeholder="Outer Dia" disabled="disabled" >
                    </div>
                    

                    
                    <div class="col-md-3 mb-3">
                        <label for="Teeth_wheel_side" onclick="changeInputState('Teeth_wheel_side')">
                        <input type="checkbox" name="push" class="custom-control-input Teeth_wheel_side" id="prTeeth_wheel_side" >
                        <span class="notreq">Teeth Wheel Side</span></label>
                        @if ($errors->has('Teeth_wheel_side'))
                        <span class="help-block">
                            <strong>{{ $errors->first('Teeth_wheel_side') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="Teeth_wheel_side" name="Teeth_wheel_side" placeholder="Teeth wheel side" disabled="disabled" >
                    </div>	

                    <div class="col-md-3 mb-3">
                        <label for="Teeth_Diff_Side" onclick="changeInputState('Teeth_Diff_Side')">
                        <input type="checkbox" name="push" class="custom-control-input Teeth_Diff_Side" id="prTeeth_Diff_Side" >
                        <span class="notreq">Teeth Diff. Side</span></label>
                        @if ($errors->has('Teeth_Diff_Side'))
                        <span class="help-block">
                            <strong>{{ $errors->first('Teeth_Diff_Side') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="Teeth_Diff_Side" name="Teeth_Diff_Side" placeholder="Teeth Diff Side" disabled="disabled" >
                    </div>					
                    
                    
                </div>					
                <div class="row mt-4">

                    <div class="col-md-3 mb-3">
                        <label for="mscode">MS Code</label>
                        @if ($errors->has('mscode'))
                        <span class="help-block">
                            <strong>{{ $errors->first('mscode') }}</strong>
                        </span>
                        @endif
                        <textarea class="form-control"  rows="10" placeholder="Description" id="mscode" name="mscode" ></textarea>
                    </div>
                    
                    <div class="col-md-3 mb-3">
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
                    </div>
                    
                    <div class="col-md-3 mb-3">
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
                    </div>
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
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitProdDesc">Submit</button></div>
                </div>



            </form>
        </div>
    </div>
</div>
@endsection