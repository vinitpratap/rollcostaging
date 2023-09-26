@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>View Search Not Found</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <form method="get">
                        <div class="row mt-4">
                            <div class="col-md-4 mb-3 padRig">
                                <label>Search By</label>
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
                    <?php if (count($data) > 0) { ?>
                        <table class="table table-striped ">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title">S. No.</th>
                                    <th class="column-title">Name</th>
                                    <th class="column-title">Search Text</th>
                                    <th class="column-title">Make</th>
                                    <th class="column-title">Model</th>
                                    <th class="column-title">Year</th>
                                    <th class="column-title">CCM</th>
                                    <th class="column-title">Engine</th>
                                    <th class="column-title">IP</th>
                                    <th class="column-title">Date</th>
                                    <th class="column-title">Action</th>
                                    <th class="column-title">Check All &nbsp; <input type="checkbox" class="deleteCross" id="checkAll"></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php $i = 1; ?>
                                @foreach($data as $key=>$value)
                                <tr class="pointer">
                                    <td>{{$i++}}</td>
                                    <td>{{$value->snf_user}}</td>
                                    <td>{{$value->snf_text}}</td>
                                    <td>{{getMakeName($value->snf_make)}}</td>
                                    <td>{{getModelName($value->snf_model)}}</td>
                                    <td>{{getProYear($value->snf_yr)}}</td>
                                    <td>{{getProCCM($value->snf_cc)}}</td>
                                    <td>{{getEngineCode($value->snf_ec)}}</td>
                                    <td>{{($value->snf_ip)}}</td>
                                    <td>{{$value->created_at}}</td>
                                    <td >
                                        <a href="{{route('search_nf.delete',base64_encode($value->snf_id))}}"  title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
                                    </td>
                                    <td class="last"><input type="checkbox" class="deleteSNF deleteCrossref" id="{{$value->snf_id}}"></td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    <?php } else { ?>
                        <strong style="margin-left: 35%;color: red;">No data available </strong>
                    <?php } ?>
                    {{ $data->links('common.custompagination') }}
                </div>
<div class="clearfix"></div>

                <?php if (count($data) > 0) { ?>
                    <div class="row  m-0">
                        <div class="col-6"><span>Total  {{ $data->total() }} records</span></div>
                        <?php $routeValues = '?search=' . app('request')->input('search'); ?>
                        <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="{{route('search_nf.export',$routeValues)}}" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="{{ URL::asset('images/excel.svg') }}" class="pr-2" alt="Export to Excel"> Export Last 30 days search analytic data </a></div>

                    </div>
<div class="row  m-0">
                        <?php $routeValues = '?search=' . app('request')->input('search'); ?>
                        <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="{{route('search_nfall.export',$routeValues)}}" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="{{ URL::asset('images/excel.svg') }}" class="pr-2" alt="Export to Excel"> Export All Search not found data </a></div>

                    </div>
                <?php } ?>
                <div class="row  m-0 deleteCrossButt" style="display:none;">
                    <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="javascript:void(0);" class="btn btn-outline-secondary  pl-4 pr-4 pt-2 pb-2  m-0" id="deleteSNFDetails"> Delete </a></div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection