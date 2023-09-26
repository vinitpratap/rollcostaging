@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Search List Not Found</h2>
                <div class="clearfix"></div>
            </div>

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

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <form method="get">


                        <div class="row mt-4">
                            <div class="col-md-8 mb-3 padRig">
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
                                <div id="reportrange1" class="form-control"> <i class="glyphicon glyphicon-calendar fa fa-calendar"></i> <span>{{date("M j, Y",strtotime($first_day))}} - {{date("M j, Y",strtotime($last_day))}}</span> <b class="caret"></b> </div>
                                <input type="hidden" name="req_date_range" id="req_date_range" value="{{app('request')->input('req_date_range')}}">
                            </div>
                            <div class="col-md-4 mb-3 padRig">
                                <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase">Search</button>
                            </div>
                             {{ csrf_field() }}
                        </div>
                        
                    </form>
                    <?php if (count($data) > 0) { ?>
                        <table id="datatable1" class="table table-striped ">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title">Make</th>
                                    <th class="column-title">Model</th>
                                    <th class="column-title">Year</th>
                                    <th class="column-title">CC</th>
                                    <th class="column-title">Engine Code</th>
                                    <th class="column-title">User Name</th>
                                    
                                    <th class="column-title">IP Address</th>
                                    <th class="column-title">Search Date</th>
                                    <th class="column-title">Action</th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach($data as $key=>$value)
                                <tr class="pointer">
                                    <td>{{$value->snf_make}}</td>
                                    <td>{{$value->snf_model}}</td>
                                    <td>{{$value->snf_yr}}</td>
                                    <td>{{$value->snf_cc}}</td>
                                    <td>{{$value->snf_ec}}</td>
                                    <td>{{$value->snf_user}}</td>
                                    <td>{{$value->snf_ip}}</td>
                                    <td>{!! date("jS M Y",strtotime($value->created_at))!!}</td>
                                    
                                    <td class="last">
                                        @if(Auth::guard('admin')->user()->admin_role==1)
                                        <a href="{{route('searchnotfound.delete',base64_encode($value->snf_id))}}"  title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
                                    </td>
                                    @endif

                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    <?php } else { ?>
                        <strong style="margin-left: 35%;color: red;">No data available </strong>
                    <?php } ?>
                    {{ $data->links('common.custompagination') }}

                </div>

            </div>

            <div class="clearfix"></div>
<?php if (count($data) > 0) { ?>
                <div class="row  m-0">
                    <?php $routeValues = '?daterange=' . app('request')->input('req_date_range'); ?>
                    <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="{{route('searchnotfound.export',$routeValues)}}" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="{{ URL::asset('images/excel.svg') }}" class="pr-2" alt="Export to Excel"> Export to Excel </a></div>

                </div>
            <?php } ?>  
        </div>
    </div>
</div>


@endsection