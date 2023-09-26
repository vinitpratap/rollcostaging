@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Product Application </h2>
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
                    <table class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Sr No</th>
                                <th class="column-title">Product</th>
                                <th class="column-title">Make</th>
                                <th class="column-title">Model</th>
                                <!--<th class="column-title">ENGINE</th>-->
                                <th class="column-title">Year</th>
                                <th class="column-title">CCM</th>
								<th class="column-title">Status</th>	
                                <th class="column-title">Action</th>
								<th class="column-title">Check All (Delete) &nbsp; <input type="checkbox" class="deleteCross" id="checkAll"></th>
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
                                <td>{{$value->part_no}}</td>
                                <td>{{$value->make_nm}}</td>
                                <td>{{$value->model_nm}}</td>
                                <!--<td>{{$value->eng_nm}}</td>-->
                                <td>{{$value->year}}</td>
                                <td>{{$value->cc}}</td>
								 <td>@if($value->ap_status ==1) Enable @else Disable @endif</td>
                                <td class="last">
									<a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="{{base64_encode($value->part_no)}}_{{base64_encode($value->ap_id)}}" class="editproduct-application" src="{{ URL::asset('images/edit.svg') }}" alt=""></a> 
                                    <a href="{{route('application.delete',base64_encode($value->ap_id))}}"  title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
                                </td>
								<td class="last"><input type="checkbox" class="deleteCrossref" id="{{$value->ap_id}}"></td>
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
                    <?php $routeValues = 'search=' . app('request')->input('search') ; ?>
                    <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="{{route('application.export',$routeValues)}}" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="{{ URL::asset('images/excel.svg') }}" class="pr-2" alt="Export to Excel"> Export to Text </a></div>

                </div>
            <?php } ?>
 <div class="row  m-0 deleteCrossButt" style="display:none;">
                <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="javascript:void(0);" class="btn btn-outline-secondary  pl-4 pr-4 pt-2 pb-2  m-0" id="deleteApplication"> Delete </a></div>
            </div>

        </div>
    </div>
</div>

<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText" >Upload Application</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="applicationUpdate" action="{{route('application.upload')}} " enctype="multipart/form-data">
                {{ csrf_field() }}
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
<!--                <div class="row mt-4">                   
                    <div class="col-md-4 mb-3 ">
                        <label for="application_file"> File</label>
                        <input  name="application_file" type="file" id="application_file" >
                    </div>
                </div>-->
				<input type="hidden" name="ap_id" id="ap_id" >
				<input type="hidden" name="part_no" id="part_no" >
				<input type="hidden" name="app_upload" value="1" >
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix fileuploaddiv" >
                        <div class="d-block filedetail mb-4">
                        <label for="application_file"> File</label>
                        <input  name="application_file" type="file" id="application_file" >        <a href="{{URL('Demo')}}/demo-ApplicationData1.csv" class="d-block "> Download sample file</a> </div>
                        
                      
                        
                        <p class="pt-4">Please first download file and don't change cell header</p>
						
                    </div>
					<div class="col-md-4 mb-3 padRig otherdiv" style="display:none;">
                        <label for="make_nm">MAKE</label>
                        @if ($errors->has('make_nm'))
                        <span class="help-block">
                            <strong>{{ $errors->first('make_nm') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="make_nm" name="make_nm" placeholder="eg:-1202152" value="{{ old('make_nm') }}"   >
                    </div>
                    <div class="col-md-4 mb-3 padRig otherdiv" style="display:none;">
                        <label for="model_nm">MODEL</label>
                        @if ($errors->has('model_nm'))
                        <span class="help-block">
                            <strong>{{ $errors->first('model_nm') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="model_nm" name="model_nm" placeholder="eg:-1202152" value="{{ old('model_nm') }}"  >
                    </div>
                    <div class="col-md-4 mb-3 padRig otherdiv" style="display:none;">
                        <label for="year">Year</label>
                        @if ($errors->has('year'))
                        <span class="help-block">
                            <strong>{{ $errors->first('year') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="year" name="year" placeholder="eg:-1202152" value="{{ old('year') }}" >
                    </div>
                    <div class="col-md-4 mb-3 padRig otherdiv" style="display:none;">
                        <label for="cc">CC</label>
                        @if ($errors->has('cc'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cc') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="cc" name="cc" placeholder="eg:-1202152" value="{{ old('cc') }}" >
                    </div>
					<div class="col-12  pb-3 clearfix">
					  <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitapplication">Upload </button>
                	</div>
				</div>
            </form>
        </div>
    </div>
</div>
@endsection