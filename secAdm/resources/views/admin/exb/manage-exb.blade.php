@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Exhibition</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title"> ID</th>
                                <th class="column-title">Name</th>
                                <th class="column-title">Description</th>
                                <th class="column-title">Date</th>
                                <th class="column-title">Place</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $i = 1;?>
                            @foreach($data as $key=>$value)
                            <tr class="pointer">
                                <td>{{$i++}}</td>
                                <td>{{$value->exb_nm}}</td>
                                <td>{{$value->exb_inf}}</td>
                                <td>{{date('jS F Y',strtotime($value->exb_date))}}</td>
                                <td>{{$value->exb_place}}</td>
                                 <td>@if($value->exb_status ==1) Enable @else Disable @endif</td>
                                <td class="last">
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="{{base64_encode($value->exb_id)}}" class="editExb" src="{{ URL::asset('images/edit.svg') }}" alt=""></a> 
                                    <a href="{{route('exb.delete',base64_encode($value->exb_id))}}"  title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>


        </div>
    </div>
</div>

<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText"> Add News</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="exbRegister" action="{{route('exb.register')}} " enctype="multipart/form-data"> 

                {{ csrf_field() }}
                <input type="hidden" name="exb_id" id="exb_id">
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
                    <div class="col-md-12 mb-3 padRig">
                        <label for="exb_nm">Name</label>
                        @if ($errors->has('exb_nm'))
                        <span class="help-block">
                            <strong>{{ $errors->first('exb_nm') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="exb_nm" name="exb_nm" placeholder="Exhibition name"  >
                    </div>
                    
                </div>
                <div class="row mt-4">
                    <div class="col-md-12 mb-3 padRig">
                        <label for="exb_inf">Description</label>
                        @if ($errors->has('exb_inf'))
                        <span class="help-block">
                            <strong>{{ $errors->first('exb_inf') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="exb_inf" name="exb_inf" placeholder="Exhibition Description"  >
                    </div>
                    
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-3 mb-3 padRig">
                        <label for="exb_img"> Image</label>
                        @if ($errors->has('exb_img'))
                        <span class="help-block">
                            <strong>{{ $errors->first('exb_img') }}</strong>
                        </span>
                        @endif
                        <input  name="exb_img" type="file" id="serimageInput" >
                    </div>
                    
                    <div class="col-md-3 mb-3 padRig">
                        <label for="exb_date">Date</label>
                        @if ($errors->has('exb_date'))
                        <span class="help-block">
                            <strong>{{ $errors->first('exb_date') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="exb_date" name="exb_date" placeholder="Exhibition date"  >
                    </div>
                     <div class="col-md-3 mb-3 padRig">
                        <label for="exb_place">Place</label>
                        @if ($errors->has('exb_place'))
                        <span class="help-block">
                            <strong>{{ $errors->first('exb_place') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="exb_place" name="exb_place" placeholder="Exhibition place"  >
                    </div>
                     <div class="col-md-3 mb-3">
                        <label for="status">Status</label>
                        @if ($errors->has('exb_status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('exb_status') }}</strong>
                        </span>
                        @endif
                        <select  class="form-control select " id="exb_status" name="exb_status">
                            <option value="1"  >Enable</option>
                            <option value="0" >Disable</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-3 mb-3 padRig" id="exb_img"></div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitNews">Add </button></div>
                </div>



            </form>
        </div>
    </div>
</div>
@endsection