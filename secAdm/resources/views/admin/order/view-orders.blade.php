@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>View Orders</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <form method="get">
                        <div class="row mt-4">
                            <div class="col-md-4 mb-3 padRig">
                                <input type="text" placeholder="Search by order number" name="search"  autocomplete="off" class="form-control" value="{{ app('request')->input('search') }}">
                            </div>
                            <div class="col-md-4 mb-3 padRig">
                                <input type="text" placeholder="Search by name,email" name="search_user"  autocomplete="off" class="form-control" value="{{ app('request')->input('search_user') }}">
                            </div>
                            <div class="col-md-4 mb-3 padRig">
                                <select  class="form-control select"  id="ser_category" name="ord_status" >
                                    <option value="">Select order status</option>
                                    
                                    <option value="0" <?php if (!empty(app('request')->input('ord_status')) == 0) {echo 'selected';} ?>>Open</option>
                                    <!--<option value="1" <?php //if (!empty(app('request')->input('ord_status')) == 1) {echo 'selected';} ?>>Processing</option>
                                    <option value="2" <?php //if (!empty(app('request')->input('ord_status')) == 2) {echo 'selected';} ?>>Pending</option>
                                    <option value="3" <?php //if (!empty(app('request')->input('ord_status')) == 3) {echo 'selected';} ?>>Hold</option>
                                    <option value="4" <?php //if (!empty(app('request')->input('ord_status')) == 4) {echo 'selected';} ?>>Complete</option>-->
                                    <option value="5" <?php if (!empty(app('request')->input('ord_status')) && app('request')->input('ord_status') == 5) {echo 'selected';} ?>>Closed</option>
                                    <option value="6" <?php if (!empty(app('request')->input('ord_status')) && app('request')->input('ord_status') == 6) {echo 'selected';} ?>>Canceled</option>
                                </select>
                            </div>
                            

                        </div>
                        
                        <div class="row mt-4">
                             <div class="col-md-6 mb-3 padRig">
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
                                 <label>Select date</label>
                                <div id="reportrange1" class="form-control"> <i class="glyphicon glyphicon-calendar fa fa-calendar"></i> <span>{{date("M j, Y",strtotime($first_day))}} - {{date("M j, Y",strtotime($last_day))}}</span> <b class="caret"></b> </div>
                                <input type="hidden" name="req_date_range" id="req_date_range" value="{{app('request')->input('req_date_range')}}">
                            </div>
                            
                            <div class="col-md-4 mb-3 padRig">
                                <label>Show Entries</label>
                                <select class="form-control select" id="data_entries" name="data_entries" >                                    @foreach($pagination_arr as $val)
                                    <option value="{{$val}}" <?php if(app('request')->input('data_entries') == $val) {?> selected <?php } ?>>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mb-3 pt-35 padRig">
                                <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase">Search</button>
                            </div>
                        </div>
                            
                        {{ csrf_field() }}

                    </form>
                     <?php if (count($data) > 0) { ?>
                    <table id="datatable1" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">S. No.</th>
                                <th class="column-title">Order No</th>
                                <th class="column-title">Name</th>
                                <th class="column-title">Email</th>
                                <th class="column-title">Price</th>
                                <th class="column-title">Quantity</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Order Date</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>
<?php $i = 1; ?>
                            @foreach($data as $key=>$value)

                            <tr class="pointer">
                                <td>{{$i++}}</td>
                                <td>{{$value->order_no}}</td>
                                <td><?php if(isset($value->getUserDetails[0])) { ?> {{$value->getUserDetails[0]->companyName}}  <?php } ?></td>
                                <td><?php if(isset($value->getUserDetails[0])) { ?>{{$value->getUserDetails[0]->com_emailAddress}} <?php } ?></td>
                                <td><?php if(isset($value->getUserDetails[0])) { ?>{{html_entity_decode(getUserCurrency($value->getUserDetails[0]->g_id)) .' '.$value->totalprice}}  <?php } ?></td>
                                <td>{{countOrderProduct($value->order_id)}} Parts - {{ $value->Qty}} Qty </td>

                                <td>@if($value->order_status == 0) Open @elseif($value->order_status == 1) Processing @elseif($value->order_status == 2) Pending @elseif($value->order_status == 3) Hold @elseif($value->order_status == 4) Complete @elseif($value->order_status == 5) Closed @elseif($value->order_status == 6) Canceled @endif</td>
                                <td>{{$value->created_at}}</td>
                                <td class="last">
                                    <a href="{{route('order.details',base64_encode($value->order_id))}}" title="Edit" class="mr-4 ml-2 d-inline-block"><img src="{{ URL::asset('images/edit.svg') }}" alt=""></a>
                                    <?php if ($value->order_status != 5) { ?>
									<a href="{{route('order.delete',base64_encode($value->order_id))}}"  title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
									<?php } ?>
                                </td>
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
                    <div class="col-6"><span>Total  {{ $data->total() }} records</span></div>
                    <?php $routeValues = 'search=' . app('request')->input('search'). '&search_user=' . app('request')->input('search_user') . '&ord_status=' . app('request')->input('ord_status') . '&daterange=' . app('request')->input('req_date_range'); ?>
                    <div class="col-6 text-right pl-0 pr-0 pb-3 clearfix"><a href="{{route('order.export',$routeValues)}}" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="{{ URL::asset('images/excel.svg') }}" class="pr-2" alt="Export to Excel"> Export Order </a></div>

                </div>
				
				 <div class="row  m-0">
				 <div class="col-6"></div>
                    <?php $routeValues = 'search=' . app('request')->input('search'). '&search_user=' . app('request')->input('search_user') . '&ord_status=' . app('request')->input('ord_status') . '&daterange=' . app('request')->input('req_date_range'); ?>
                    <div class="col-6 text-right pl-0 pr-0 pb-3 clearfix"><a href="{{route('orderunitwise.export',$routeValues)}}" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="{{ URL::asset('images/excel.svg') }}" class="pr-2" alt="Export to Excel"> Export Unit Wise Order </a></div>

                </div>
            <?php } ?>
        </div>
    </div>
</div>
@endsection