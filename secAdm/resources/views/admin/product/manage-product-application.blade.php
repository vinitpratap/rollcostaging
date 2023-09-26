@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Application</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">S. No.</th>
                                <th class="column-title">Part No.</th>
                                <th class="column-title">MAKE</th>
                                <th class="column-title">MODEL</th>
                                <th class="column-title">YEAR</th>
                                <th class="column-title">CC</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;?>
                            @foreach($data as $key=>$value)
                            <tr class="pointer">
                               <td>{{$i++}}</td>
                                <td>{{$value->part_no}}</td>
                                <td>{{$value->make_nm}}</td>
                                <td>{{$value->model_nm}}</td>
                                <td>{{$value->year}}</td>
                                <td>{{$value->cc}}</td>
                                <td class="last"> 
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="{{base64_encode($value->part_no)}}_{{base64_encode($value->ap_id)}}" class="editproduct-application" src="{{ URL::asset('images/edit.svg') }}" alt=""></a> 
                                    <a href="{{route('product_application.delete',[base64_encode($value->part_no),base64_encode($value->ap_id)])}}" title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row pt-3 viewPrgrp" <?php if((isset($errors) && count($errors) > 0) || (session()->has('message'))){} else echo 'style="display: none"';?>>
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText"> Edit Price</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="applicationUpdate" action="{{route('product_application.edit')}}"> 
                {{ csrf_field() }}
                <input type="hidden" name="part_no" id="part_no" value="{{ old('part_no') }}">
                <input type="hidden" name="ap_id" id="ap_id" value="{{ old('ap_id') }}">
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
                    <div class="col-md-4 mb-3 padRig">
                        <label for="make_nm">MAKE</label>
                        @if ($errors->has('make_nm'))
                        <span class="help-block">
                            <strong>{{ $errors->first('make_nm') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="make_nm" name="make_nm" placeholder="eg:-1202152" value="{{ old('make_nm') }}" required="required"  >
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                        <label for="model_nm">MODEL</label>
                        @if ($errors->has('model_nm'))
                        <span class="help-block">
                            <strong>{{ $errors->first('model_nm') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="model_nm" name="model_nm" placeholder="eg:-1202152" value="{{ old('model_nm') }}" required="required"  >
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                        <label for="year">Year</label>
                        @if ($errors->has('year'))
                        <span class="help-block">
                            <strong>{{ $errors->first('year') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="year" name="year" placeholder="eg:-1202152" value="{{ old('year') }}" >
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                        <label for="cc">CC</label>
                        @if ($errors->has('cc'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cc') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="cc" name="cc" placeholder="eg:-1202152" value="{{ old('cc') }}" >
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitApplication">Edit Application</button></div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection