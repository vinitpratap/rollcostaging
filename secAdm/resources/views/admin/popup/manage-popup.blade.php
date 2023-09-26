@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Popup</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title"> ID</th>
                                <th class="column-title">Title</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $i = 1;?>
                            @foreach($data as $key=>$value)
                            <tr class="pointer">
                                <td>{{$i++}}</td>
                                <td>{{$value->p_title}}</td>
                                 <td>@if($value->p_status ==1) Enable @else Disable @endif</td>
                                <td class="last">
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="{{base64_encode($value->p_id)}}" class="editPopup" src="{{ URL::asset('images/edit.svg') }}" alt=""></a> 
                                    <a href="{{route('popup.delete',base64_encode($value->p_id))}}"  title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
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
                <h2 id="titleText"> Add Popup</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="newsRegister" action="{{route('popup.register')}} " enctype="multipart/form-data"> 

                {{ csrf_field() }}
                <input type="hidden" name="p_id" id="p_id">
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
                        <label for="locationName">Popup Title</label>
                        @if ($errors->has('p_title'))
                        <span class="help-block">
                            <strong>{{ $errors->first('p_title') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="p_title" name="p_title" placeholder="Popup title"  >
                    </div>
                    
                </div>   
				<div class="row mt-4">
                    <div class="col-md-12 mb-3 padRig">
                        <label for="locationName">Popup Content</label>
                        @if ($errors->has('p_content'))
                        <span class="help-block">
                            <strong>{{ $errors->first('p_content') }}</strong>
                        </span>
                        @endif
						<textarea class="form-control " autocomplete="off" id="p_content" name="p_content" placeholder="Popup Content" ></textarea>
                        
                    </div>
                    
                </div>
				
				<div class="row mt-4">
                    <div class="col-md-12 mb-3 padRig">
                        <label for="categoryId"> Image </label>
                        @if ($errors->has('p_image'))
                        <span class="help-block">
                            <strong>{{ $errors->first('p_image') }}</strong>
                        </span>
                        @endif
                        <input  name="p_image" type="file" id="serimageInput">
                    </div>
				</div>
				
				<div class="row mt-4">
                    <div id="p_image_div">
                        
                    </div>
				</div>
				
                <div class="row mt-4">
                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label>
                        @if ($errors->has('p_status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('p_status') }}</strong>
                        </span>
                        @endif
                        <select  class="form-control select " id="p_status" name="p_status">
                            <option value="1"  >Enable</option>
                            <option value="0" >Disable</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitNews">Add </button></div>
                </div>



            </form>
        </div>
    </div>
</div>
@endsection