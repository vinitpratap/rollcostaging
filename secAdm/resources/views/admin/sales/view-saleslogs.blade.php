@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Sales Logs</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <form method="get">

                        <div class="row mt-4">
                            <div class="col-md-4 mb-3 padRig">
                                <label>Select Sales Person</label>
                                <select  class="form-control select"  id="su_id" name="su_id" >
                                    <option value="">Select Sales Person</option>
                                    @foreach($salesData as $key =>$value)
                                    <option value="{{$value['u_id']}}" <?php
                                    if (!empty(app('request')->input('su_id')))
                                        if (app('request')->input('su_id') == $value['u_id']) {
                                            echo 'selected';
                                        }
                                    ?>>{{$value['firstName'] . ' ' .$value['lastName']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 padRig">
                                <label>Select Company</label>
                                <select  class="form-control select"  id="u_id" name="u_id" >
                                    <option value="">Select  Company </option>
                                    @foreach($userData as $key =>$value)
                                    @if($value['companyName'] !='')
                                    <option value="{{$value['u_id']}}" <?php
                                    if (!empty(app('request')->input('u_id')))
                                        if (app('request')->input('u_id') == $value['u_id']) {
                                            echo 'selected';
                                        }
                                    ?>>{{$value['companyName'] .'('.$value['com_zipCode'].')'}}</option>
                                    @endif
                                    @endforeach
                                    <?php if (count($tempData) > 0) { ?>
                                        <optgroup label="Temp Users">
                                            @foreach($tempData as $key=>$value)
                                            <option value="temp_{{$value['u_id']}}" <?php
                                    if (!empty(app('request')->input('u_id')))
                                        if (app('request')->input('u_id') == 'temp_'.$value['u_id']) {
                                            echo 'selected';
                                        }
                                    ?>>{{$value['firstName'] .' '.$value['lastName']}}</option>
                                            @endforeach
                                        </optgroup>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 padRig">
                                <label>Select Report Status</label>
                                <select  class="form-control select"  id="sc_status" name="sc_status" >
                                    <option value="">Select  Status </option>
                                    <option value="1" <?php
                                    if (!empty(app('request')->input('sc_status') == 1)) {
                                        echo 'selected';
                                    }
                                    ?>>Open</option>
                                    <option value="2" <?php
                                    if (!empty(app('request')->input('sc_status') == 2)) {
                                        echo 'selected';
                                    }
                                    ?>>Closed</option>
                                </select>
                            </div>


                        </div>

                        <div class="row mt-4">

                            <div class="col-md-6 mb-4 align-self-center padRig">
                                <label>Select Date Range</label>
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
                            <div class="col-md-4  align-self-center padRig">
                                {{ csrf_field() }}
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase">Search</button>
                            </div>
                        </div>

                    </form>
                    <?php if (count($data) > 0) { ?>
                        <table class="table table-striped ">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title">Appointment Date</th>
                                    <th class="column-title">Ac Name</th>
                                    <th class="column-title">Start Time</th>
                                    <th class="column-title">End Time</th>
                                    <th class="column-title">Remarks</th>
                                    <th class="column-title">Status</th>
                                    <th class="column-title">Sales Person Name</th>
                                    <th class="column-title">Log Action</th>
                                    <th class="column-title">Reason if delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $key=>$value)
                                <tr class="pointer">
                                    <td>{{$value->sc_date}}</td>
                                    <td>
                                        {{$value->full_name}}
                                    </td>
                                    <td>{{$value->sc_stime}}</td>
                                    <td>{{$value->sc_etime}}</td>
                                    <td>{{$value->sc_remarks}}</td>
                                    <td><?php
                                        if ($value->sc_status == 1)
                                            echo "Open";
                                        else
                                            echo "Closed";
                                        ?></td>
                                    <td>{{getUserName($value->sec_id)}}</td>
                                    <?php $ss_id = getActCodeUser($value->u_id); ?>


                                    <td>{{$value->log_action}}</td>
                                    <td class="last">{{$value->reason_delete}}</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    <?php } else { ?>
                        <strong style="margin-left: 35%;color: red;">No data available </strong>
                    <?php } ?>
                </div>

            </div>
            {{ $data->links('common.custompagination') }}
            <div class="clearfix"></div>
            <?php if (count($data) > 0) { ?>
                <div class="row  m-0">
                    <div class="col-6"><span>Total  {{ $data->total() }} records</span></div>
                    <?php $routeValues = 'su_id=' . app('request')->input('su_id') . '&u_id=' . app('request')->input('u_id') . '&req_date_range=' . app('request')->input('req_date_range') . '&sc_status=' . app('request')->input('sc_status'); ?>
                    <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="{{route('saleslog.export',$routeValues)}}" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="{{ URL::asset('images/excel.svg') }}" class="pr-2" alt="Export to Excel"> Export to Excel </a></div>

                </div>
            <?php } ?>


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


@endsection