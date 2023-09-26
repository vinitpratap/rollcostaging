@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage News</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title"> ID</th>
                                <th class="column-title">News</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $i = 1;?>
                            @foreach($data as $key=>$value)
                            <tr class="pointer">
                                <td>{{$i++}}</td>
                                <td class="whiteSpace"> {{strip_tags($value->news_text)}}</td>
                                 <td>@if($value->news_status ==1) Enable @else Disable @endif</td>
                                <td class="last">
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="{{base64_encode($value->news_id)}}" class="editNews" src="{{ URL::asset('images/edit.svg') }}" alt=""></a> 
                                    <a href="{{route('news.delete',base64_encode($value->news_id))}}"  title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
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
            <form method="post" id="newsRegister" action="{{route('news.register')}} "> 

                {{ csrf_field() }}
                <input type="hidden" name="news_id" id="news_id">
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
                        <label for="locationName">News Text</label>
                        @if ($errors->has('news_text'))
                        <span class="help-block">
                            <strong>{{ $errors->first('news_text') }}</strong>
                        </span>
                        @endif
                        <textarea  class="form-control" autocomplete="off" id="news_text" name="news_text" placeholder="News Text"  required></textarea>
                    </div>
                    
                </div>
                <div class="row mt-4">
                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label>
                        @if ($errors->has('news_status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('news_status') }}</strong>
                        </span>
                        @endif
                        <select  class="form-control select " id="news_status" name="news_status">
                            <option value="1">Enable</option>
                            <option value="0">Disable</option>
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