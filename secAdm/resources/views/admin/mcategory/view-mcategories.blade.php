@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Master Categories</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">S. No.</th>
                                <th class="column-title">Master Category Name</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $i = 1;?>
                            @foreach($data as $key=>$value)
                            <tr class="pointer">
                               <td>{{$i++}}</td>
                                <td>{{$value->mcat_nm}}</td>
                                <td>@if($value->mcat_status ==1) Enable @else Disable @endif</td>
                                <td class="last">
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="{{base64_encode($value->mcat_id)}}" class="editMCategory" src="{{ URL::asset('images/edit.svg') }}" alt=""></a> 
                                    <a href="{{route('mcategory.delete',base64_encode($value->mcat_id))}}"  title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="clearfix"></div>
            <div class="row  m-0">
                <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="javascript:void(0);" onclick="scrollToCustomerForm();" class="btn btn-outline-secondary  pl-4 pr-4 pt-2 pb-2  m-0" id="addNewRequest"> Add New Master Category </a></div>
            </div>


        </div>
    </div>
</div>

<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText"> Add Master Category</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="mcategoryRegister" action="{{route('mcategory.register')}} "  enctype="multipart/form-data"> 

                {{ csrf_field() }}
                <input type="hidden" name="mcat_id" id="mcat_id">
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
                        <label for="mcat_nm">Master Category</label>
                        @if ($errors->has('mcat_nm'))
                        <span class="help-block">
                            <strong>{{ $errors->first('mcat_nm') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="mcat_nm" name="mcat_nm" placeholder="eg:-Electrical"  >
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="mcat_status">Status</label>
                        @if ($errors->has('mcat_status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('mcat_status') }}</strong>
                        </span>
                        @endif
                        <select  class="form-control select " id="mcat_status" name="mcat_status">
                            <option value="1"  >Enable</option>
                            <option value="0" >Disable</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                        <label for="mcat_imageInput"> Image </label>
                        @if ($errors->has('mcat_image'))
                        <span class="help-block">
                            <strong>{{ $errors->first('mcat_image') }}</strong>
                        </span>
                        @endif
                        <input  name="mcat_image" type="file" id="mcat_imageInput" >
                    </div>
                    
                </div>
                <div class="row mt-4">
                    <div class="col-md-3 mb-3 padRig" id="mcat_image"></div>
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitMCategory">Add </button></div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection