@extends('admin.layouts.app')

@section('content')

<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText"> Manage Sales Sheets</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="salesSheetRegister" action="{{route('salessheet.data')}}" enctype="multipart/form-data" > 
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
                <input type="hidden" id="checkflag" value="1">
                <input type="hidden" id="temp_uid">
                <div class="row mt-4">
                    <div class="col-md-4 mb-3 padRig">
                        <label for="requestCurrency">Select Company</label>
                        <select  class="form-control select user_id_sales" id="user_id" name="user_id" required="required" >
                            <option value="">Select Company</option>
                            @foreach($cdata as $key=>$value)
                            <option value="{{$value['u_id']}}">{{$value['companyName'] . '('. $value['com_zipCode'].')'}}</option>
                            @endforeach
                            <?php if(count($tempData) > 0) { ?>
                            <optgroup label="Temp Users">
                            @foreach($tempData as $key=>$value)
                            <option value="temp_{{$value['u_id']}}">{{$value['firstName'] .' '.$value['lastName']}}</option>
                            @endforeach
                            </optgroup>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <span class="show-msg"></span>
                
                
            </form>
        </div>
    </div>
</div>

@endsection