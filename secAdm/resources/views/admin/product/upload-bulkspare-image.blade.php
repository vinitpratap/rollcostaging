@extends('admin.layouts.app')

@section('content')
<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText" >Upload Bulk Spare Image</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="spearServiceRegister" action="{{route('sparebulkimage.upload')}} " enctype="multipart/form-data">
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
                <div class="row mt-4">                   
                    <div class="col-md-4 mb-3 ">
                        <label for="bulkProduct_file"> File</label>
                        <input  name="bulkProduct_file" type="file" id="bulkProduct_file" >
                    </div>                   
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix">
                        <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitCategory">Upload </button>
                        <p class="pt-4">
                        <ul>
                            <li>Please Upload Zip file only, No folder inside the zip file</li>
                            <li>All the Image names should be equal to spare name. Example - Spare = ALT100 , Image = ALT100-1.jpg till ALT100-8.jpg</li>
                            <li>Image should be of png/jpeg/jpg format only</li>
                            <li>Image size should be 400 X 300</li>
                            <li>The folder should contain maximum 1500 images.</li>
                        </ul>
                        </p>
                    
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection