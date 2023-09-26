@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Flyres</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content mb-3 col-12 clearfix">
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
                    <table id="datatable1" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title"> ID</th>
                                <th class="column-title">Title</th>
                                <th class="column-title">Detail</th>
                                <th class="column-title">Thumbnail</th>
                                <th class="column-title">PDF File</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $i = 1;
                            $file_url = '';

                            if ($host == 'http://localhost') {
                                $file_url = '/rollco/upload/catalogues/';
                            } else {
                                $file_url = '/upload/catalogues/';
                            }
                            ?>
                            @foreach($data as $key=>$value)
                            <tr class="pointer">
                                <td>{{$i++}}</td>
                                <td>{{$value->cat_title}}</td>
                                <td>{{$value->fly_detail}}</td>
								<td><a target="_blank" href="{{ $host.$file_url.$value->cat_thnail }}">View</a></td>
                                <td><a target="_blank" href="{{ $host.$file_url.$value->cat_filename }}">View</a></td>
                                <td>
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="{{base64_encode($value->id)}}" class="editFlyres" src="{{ URL::asset('images/edit.svg') }}" alt=""></a> 
                                    <a href="{{route('catalogue.delete',base64_encode($value->id))}}"  title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                {{ $data->links('common.custompagination') }}
            </div>
            <div class="clearfix"></div>
            <div class="row  m-0">
                <div class="col-6"><span>Total  {{ $data->total() }} records</span></div>
            </div>



        </div>
    </div>
</div>

<div class="row pt-3 updCr">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText"> Upload Flyres</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="catalogueRegister" action="{{route('catalogue.upload')}} " enctype="multipart/form-data"> 

                {{ csrf_field() }}
                <input name="id" id="id" type="hidden">
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
                    <div class="col-md-6">
                        <label for="cat_title" class="tit_bottom"> Title</label>
                        <input  name="cat_title" type="text" id="cat_title" autocomplete="off" style="width: 100%;">
                    </div>
                    <div class="col-md-6">
                        <label for="cat_title" class="tit_bottom"> Details</label>
                        <textarea name="fly_detail" id="fly_detail" rows="3" style="width: 100%;"></textarea>
                    </div>
                    <!--                    <div class="col-md-4 mb-3 ">
                                            <label for="cat_filename"> File &nbsp; (*PDF Only)</label>
                                            <input  name="cat_filename" type="file" id="cat_filename" >
                                        </div>-->
                </div>
                <div class="row mt-4">
                    <div class="col-md-6 mb-3 ">
                        <label for="cat_filename"> File &nbsp; (*PDF Only)</label>
                        <input  name="cat_filename" type="file" id="cat_filename" style="width: 100%;">
                    </div>
                    <div class="col-md-6 mb-3 ">
                        <label for="cat_thnail"> Thumbnail File &nbsp; (*JPEG,PNG Only)</label>
                        <input  name="cat_thnail" type="file" id="cat_thnail" style="width: 100%;">
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6 mb-3 padRig" id="flyer_file"></div>
                    <div class="col-md-6 mb-3 padRig" id="flyer_thfile"></div>
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitFlyers">Upload </button></div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection