@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>View Recently viewed</h2>
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
                    <?php if (count($data) > 0) { ?>
                    <table class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">S. No.</th>
                                <th class="column-title">Name</th>
                                <th class="column-title">Email</th>
                                <th class="column-title">Mobile</th>
                                <th class="column-title">Product</th>
                                <th class="column-title">Spare</th>
                                <th class="column-title">IP</th>
                                <th class="column-title">Date</th>
                                <th class="column-title">Action</th>
                                <th class="column-title">Check All &nbsp; <input type="checkbox" class="deleteCross" id="checkAll"></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $i = 1;?>
                            @foreach($data as $key=>$value)
                            <tr class="pointer">
                                <td>{{$i++}}</td>
                                <td>{{$value->firstName.' '.$value->lastName}}</td>
                                <td>{{$value->com_emailAddress}}</td>
                                <td>{{$value->com_Telephone}}</td>
                                <td>{{$value->prod_part_no}}</td>
                                <td>{{$value->spare_part_no}}</td>
                                <td>{{$value->u_ip}}</td>
                                <td>{{$value->created_at}}</td>
                                <td class="last">
                                    <a href="{{route('recent_search.delete',base64_encode($value->sf_id))}}"  title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
                                </td>
                                <td class="last"><input type="checkbox" class="deleteRecent" id="{{$value->sf_id}}"></td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <?php } else { ?>
                        <strong style="margin-left: 35%;color: red;">No data available </strong>
                    <?php } ?>
                        {{ $data->links('common.custompagination') }}
                </div>

                   
<?php if (count($data) > 0) { ?>
                <div class="row  m-0">
                    <div class="col-6"><span>Total  {{ $data->total() }} records</span></div>
                    <?php $routeValues = 'search=' . app('request')->input('search') ; ?>
                    <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="{{route('recent_search.export',$routeValues)}}" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="{{ URL::asset('images/excel.svg') }}" class="pr-2" alt="Export to Excel"> Export Last 30 days search analytic data   </a></div>

                </div>
            <?php } ?>
<div class="row  m-0 deleteCrossButt" style="display:none;">
                    <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="javascript:void(0);" class="btn btn-outline-secondary  pl-4 pr-4 pt-2 pb-2  m-0" id="deleteRecentDetails"> Delete </a></div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection