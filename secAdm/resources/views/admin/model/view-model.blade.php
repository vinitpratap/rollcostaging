@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Models</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Sr No</th>
                                <th class="column-title">Category</th>
                                <th class="column-title">Make</th>
                                <th class="column-title">Model</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $i = 1;?>
                            @foreach($data as $key=>$value)

                            <tr class="pointer">
                                <td>{{$i++}}</td>
                                <td>{{$value->getcategory['cat_nm']}}</td>
                                <td>{{getMakeName($value->makeid)}}</td>
                                <td>{{$value->model_nm}}</td>
                               <td>@if($value->model_status ==1) Enable @else Disable @endif</td>
                                <td class="last">
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="{{base64_encode($value->model_id)}}" class="editModel" src="{{ URL::asset('images/edit.svg') }}" alt=""></a> 
                                    <a href="{{route('model.delete',base64_encode($value->model_id))}}"  title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="clearfix"></div>
            <div class="row  m-0">
                <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="javascript:void(0);" onclick="scrollToCustomerForm();"  class="btn btn-outline-secondary  pl-4 pr-4 pt-2 pb-2  m-0" id="addNewRequest"> Add New Model </a></div>
            </div>


        </div>
    </div>
</div>

<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText" >Add Model</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="modelRegister" action="{{route('model.register')}}" enctype="multipart/form-data"> 

                {{ csrf_field() }}
                <input type="hidden" name="model_id" id="model_id" >
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
                    <div class="col-md-4 mb-3">
                        <label for="category">Category</label>
                        <select  class="form-control select"   id="category" name="catid" onchange="populateMakeData(0);">
                             <option value="" >Select Category</option>
                            @foreach($category as $key =>$value)
                            <option value="{{$value['cat_id']}}" >{{$value['cat_nm']}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                     <div class="col-md-4 mb-3">
                        <label for="category">Make</label>
                        <select  class="form-control select"   id="product_make" name="makeid">
                               <option value="" >Select Category First</option>
                        </select>
                    </div>
                    
                    
                    <div class="col-md-4 mb-3 padRig">
                        <label for="categoryName">Model Name</label>
                        @if ($errors->has('model_nm'))
                        <span class="help-block">
                            <strong>{{ $errors->first('model_nm') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="model_nm" name="model_nm" placeholder="Model" >
                    </div>


                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label>
                        @if ($errors->has('model_status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('model_status') }}</strong>
                        </span>
                        @endif
                        <select  class="form-control select " id="cstatus" name="model_status">
                            <option value="1"  >Enable</option>
                            <option value="0" >Disable</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitSubCategory">Add</button></div>
                </div>



            </form>
        </div>
    </div>
</div>
@endsection