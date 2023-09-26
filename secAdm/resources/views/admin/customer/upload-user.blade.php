@extends('admin.layouts.app')

@section('content')
<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText" >Upload User</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="spearOEMRegister" action="{{route('user.upload')}} " enctype="multipart/form-data">
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
<!--                <div class="row mt-4">                   
                    <div class="col-md-4 mb-3 ">
                        <label for="spearOEM_file"> File</label>
                        <input  name="spearOEM_file" type="file" id="spearOEM_file" >
                    </div>                   
                </div>-->
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix">
                        <div class="d-block filedetail mb-4">
                        <label for="user_file"> File</label>
                        <input  name="user_file" type="file" id="spearOEM_file" > </div>
                        <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitspearOEM">Upload </button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection