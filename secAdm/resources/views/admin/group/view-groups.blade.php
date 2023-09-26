@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Group</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
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
                    <table id="datatable1" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Group ID</th>
                                <th class="column-title">Group Name</th>
                                <th class="column-title">Currency</th>
                                <th class="column-title">No. of Parts</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($data) > 0) { ?>
                                <?php $i = 1; ?>
                                @foreach($data as $key=>$value)
                                <?php $prCount = getTotalProdCount($value->gr_id); ?>

                                <tr class="pointer">
                                    <td>{{$i++}}</td>
                                    <td>{{$value->gr_nm}}</td>
                                    <td>{{html_entity_decode(getCurrName($value->gr_currency))}}</td>
                                    <td>@if($prCount>0)<a href="{{route('productgroup.manage',base64_encode($value->gr_id))}}">{{$prCount}}</a> @else 0  @endif</td>
                                    <td>@if($value->gr_status ==1) Enable @else Disable @endif</td>
                                    <td class="last">
                                        <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="{{base64_encode($value->gr_id)}}" class="editGroup" src="{{ URL::asset('images/edit.svg') }}" alt=""></a> 
                                        <a href="{{route('group.delete',base64_encode($value->gr_id))}}"  title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
                                    </td>
                                </tr>
                                @endforeach
                            <?php } else { ?>
                                <tr class="pointer">
                                    <td colspan="6" style="text-align: center">
                                        No customer data
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                {{ $data->links('common.custompagination') }}
            </div>
            <div class="clearfix"></div>

            <?php if (count($data) > 0) { ?>
                <div class="row  m-0">
                    <div class="col-6"><span>Total  {{ $data->total() }} records</span></div>
                    <?php $routeValues = 'search=' . app('request')->input('search'); ?>
                    <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="{{route('group.export',$routeValues)}}" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="{{ URL::asset('images/excel.svg') }}" class="pr-2" alt="Export to CSV"> Export to CSV </a></div>

                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText"> Add Group</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="GroupRegister" action="{{route('group.register')}}" enctype="multipart/form-data" > 
                {{ csrf_field() }}
                <input type="hidden" name="gr_id" id="gr_id">
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
                        <label for="locationName">Group</label>
                        @if ($errors->has('gr_nm'))
                        <span class="help-block">
                            <strong>{{ $errors->first('gr_nm') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="groupName" name="gr_nm" placeholder="eg:-Group" required="required"  >
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                        <label for="requestCurrency">Currency</label>
                        <select  class="form-control select" id="gr_currency" name="gr_currency" required="required">
                            <option value="">Select currency</option>
                            @foreach($currency as $key=>$value)
                            <option value="{{$value['curr_id']}}">{{html_entity_decode($value['curr_name'])}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label>
                        @if ($errors->has('gr_status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('gr_status') }}</strong>
                        </span>
                        @endif
                        <select  class="form-control select " id="curr_status" name="gr_status">
                            <option value="1"  >Enable</option>
                            <option value="0" >Disable</option>
                        </select>
                    </div>
                    <!--                    <div class="col-md-4 mb-3 ">
                                            <label for="productgroup_file"> File (CSV Only)</label>
                                            <input  name="productgroup_file" type="file" id="productgroup_file" >
                                        </div>-->
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix">
                        <div class="d-block mb-4 filedetail">
                            <label for="productgroup_file">File</label>
                            <input  name="productgroup_file" type="file" id="products_file_detail" >
                            <a href="{{URL('Demo')}}/demo-group-product-pricev2.csv" class="d-block " target="_blank"> Download sample file</a>
                        </div>
                        <p class="pt-4">
                        <ul>
                            <li>Please first download file and don't change cell header</li>
                            <li>Please replace £ to GBP, $ to USD and € to EURO</li>
                        </ul>
                        </p>
                        <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitGroup">Upload </button>




                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection