@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage MScode</h2>
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
                                    <option value="{{$val}}" <?php if (app('request')->input('data_entries')
        == $val) { ?> selected <?php } ?>>{{$val}}</option>
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
                    <table id="datatable1" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title"> ID</th>
                                <th class="column-title">Part No.</th>
                                <th class="column-title">V8key</th>
                                <th class="column-title">Action</th>
                                
                            </tr>
                        </thead>
                        <tbody>

<?php $i = 1; ?>
                            @foreach($data as $key=>$value)
                            <tr class="pointer">
                                <td>{{$i++}}</td>
                                <td>{{$value->part_no}}</td>
                                <td>{{$value->V8Key}}</td>
                               
                                <td>
                                    

                                    <a href="{{route('mscode.delete',base64_encode($value->ms_id))}}"  title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
                                </td>
                                
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
               <?php } else { ?>
                        <strong style="margin-left: 35%;color: red;">No data available </strong>
                    <?php } ?>
                        {{ $data->links('common.custompagination') }}
            </div>

            <div class="clearfix"></div>
<?php if (count($data) > 0) { ?>
                <div class="row  m-0">
                    <div class="col-6"><span>Total  {{ $data->total() }} records</span></div>
<?php } ?>

            <div class="row  m-0 deleteCrossButt" style="display:none;">
                <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="javascript:void(0);" class="btn btn-outline-secondary  pl-4 pr-4 pt-2 pb-2  m-0" id="deletecrossRef"> Delete </a></div>
            </div>

        </div>
    </div>
</div>
</div>
<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText" >Upload MsCode</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="spearOEMRegister" action="{{route('MsCode.upload')}} " enctype="multipart/form-data">
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
                @if(isset($message) && $message !='')
                <div class="error">
                    {{ $message }}
                </div>
                @endif
<!--                <div class="row mt-4">                   
                    <div class="col-md-4 mb-3 ">
                        <label for="MsCode_file"> File</label>
                        <input  name="MsCode_file" type="file" id="MsCode_file" >
                    </div>
                </div>-->
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix">
                        <div class="d-block filedetail mb-4">
                        <label for="MsCode_file"> File</label>
                        <input  name="MsCode_file" type="file" id="application_file" >        <a href="{{URL('Demo')}}/sample_mscode.csv" class="d-block "> Download sample file</a> </div>
                        @if($status == 1)
                        <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitMsCode">Upload </button>
                        @endif
                        <p class="pt-4">Please first download file and don't change cell header</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection