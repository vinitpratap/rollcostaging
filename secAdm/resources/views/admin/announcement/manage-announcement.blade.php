@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Announcement</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title"> ID</th>
                                <th class="column-title">Announcement</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $i = 1;?>
                            @foreach($data as $key=>$value)
                            <tr class="pointer">
                                <td>{{$i++}}</td>
                                <td>{{$value->announcement_text}}</td>
                                 <td>@if($value->announcement_status ==1) Enable @else Disable @endif</td>
                                <td class="last">
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="{{base64_encode($value->announcement_id)}}" class="editAnnouncement" src="{{ URL::asset('images/edit.svg') }}" alt=""></a> 
                                    <a href="{{route('announcement.delete',base64_encode($value->announcement_id))}}"  title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
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
                <h2 id="titleText"> Add Announcement</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="announcementRegister" action="{{route('announcement.register')}} "> 

                {{ csrf_field() }}
                <input type="hidden" name="announcement_id" id="announcement_id">
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
                        <label for="announcement_text">Announcement Text</label>
                        @if ($errors->has('announcement_text'))
                        <span class="help-block">
                            <strong>{{ $errors->first('announcement_text') }}</strong>
                        </span>
                        @endif
                        <textarea class="form-control " autocomplete="off" id="announcement_text" name="announcement_text" placeholder="Announcement Text"  value="{{old('announcement_text')}}"></textarea>
                        
                    </div>
                    
                </div>
                <div class="row mt-4">
                    <div class="col-md-4 mb-3">
                        <label for="announcement_status">Status</label>
                        @if ($errors->has('announcement_status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('announcement_status') }}</strong>
                        </span>
                        @endif
                        <select  class="form-control select " id="announcement_status" name="announcement_status">
                            <option value="1"  >Enable</option>
                            <option value="0" >Disable</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitAnnouncement">Add </button></div>
                </div>



            </form>
        </div>
    </div>
</div>
@endsection