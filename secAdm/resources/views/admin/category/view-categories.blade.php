@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Catalogue PDF</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Category ID</th>
                                <th class="column-title">Master Category Name</th>
                                <th class="column-title">Category Name</th>
                                <th class="column-title">PDF File</th>
                                <th class="column-title">Status</th>
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
                                <td>{{$value->getMCategory['mcat_nm']}}</td>
                                <td>{{$value->cat_nm}}</td>
                                <td><a 
                                    <?php if (isset($value->cat_brochure) && $value->cat_brochure != '') { ?>
                                            target="_blank" href="{{ $host.$file_url.$value->cat_brochure }}"
                                        <?php } else { ?>
                                            href="#"
                                        <?php } ?>
                                        >View</a></td>
                                <td>@if($value->cat_status ==1) Enable @else Disable @endif</td>
                                <td class="last">
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="{{base64_encode($value->cat_id)}}" class="editCategory" src="{{ URL::asset('images/edit.svg') }}" alt=""></a> 
<!--                                    <a href="{{route('category.delete',base64_encode($value->cat_id))}}"  title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>-->
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="clearfix"></div>
            <!--<div class="row  m-0">
                <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="javascript:void(0);" onclick="scrollToCustomerForm();" class="btn btn-outline-secondary  pl-4 pr-4 pt-2 pb-2  m-0" id="addNewRequest"> Add New Category </a></div>
            </div>-->


        </div>
    </div>
</div>

<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText"> Add Catalogue PDF</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="categoryRegister" action="{{route('category.register')}}" enctype="multipart/form-data"> 

                {{ csrf_field() }}
                <!--<input type="hidden" name="cat_id" id="cat_id">-->
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
                    <div class="col-md-6 mb-3">
                        <label for="mcatid">Category</label>
                        <select  class="form-control select" id="catid" name="catid">
                            <option value="">Select</option>
                            @foreach($data as $key =>$value)
                            <option value="{{$value['cat_id']}}" >{{$value['cat_nm']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status">Status</label>
                        @if ($errors->has('news_status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cat_status') }}</strong>
                        </span>
                        @endif
                        <select  class="form-control select " id="cat_status" name="cat_status">
                            <option value="1">Enable</option>
                            <option value="0">Disable</option>
                        </select>
                    </div>

                </div>


                <div class="row mt-4">
                    <div class="col-md-4 mb-3 padRig">
                        <label for="cat_imageInput"> PDF </label>
                        @if ($errors->has('cat_brochure'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cat_brochure') }}</strong>
                        </span>
                        @endif
                        <input  name="cat_brochure" type="file" id="cat_imageInput" >
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-3 mb-3 padRig" id="cat_brochure"></div>
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitCategory">Add </button></div>
                </div>



            </form>
        </div>
    </div>
</div>
@endsection