@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Spare Service Number</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">S. No.</th>
                                <th class="column-title">Spare Part No.</th>
                                <th class="column-title">Services No.</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;?>
                            @foreach($data as $key=>$value)
                            <tr class="pointer">
                               <td>{{$i++}}</td>
                                <td>{{$value->spare_num}}</td>
                                <td>{{$value->srvs_num}}</td>
                                <td class="last"> 
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="{{base64_encode($value->spare_num)}}_{{base64_encode($value->sps_id)}}" class="editspare_services" src="{{ URL::asset('images/edit.svg') }}" alt=""></a> 
                                    <a href="{{route('spare_services.delete',[base64_encode($value->spare_num),base64_encode($value->sps_id)])}}" title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
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
            <form method="post" id="servsUpdate" action="{{route('spare_services.edit')}}"> 
                {{ csrf_field() }}
                <input type="hidden" name="spare_num" id="spare_num" value="{{ old('spare_num') }}">
                <input type="hidden" name="sps_id" id="sps_id" value="{{ old('sps_id') }}">
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
                        <label for="srvs_num">Service No.</label>
                        @if ($errors->has('srvs_num'))
                        <span class="help-block">
                            <strong>{{ $errors->first('srvs_num') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="srvs_num" name="srvs_num" placeholder="eg:-ALT100" value="{{ old('srvs_num') }}" required="required"  >
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitspare_services">Edit Service</button></div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection