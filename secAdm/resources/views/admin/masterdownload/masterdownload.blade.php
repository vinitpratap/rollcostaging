@extends('admin.layouts.app')

@section('content')
<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText" >Download Master</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="uproductRegister" action="{{route('products.upload')}} " enctype="multipart/form-data">
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

                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Products</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="{{route('masterproduct.export')}}" class="d-block "> Download Product</a>
						</div>
                       
                    </div>
                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Product Details</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="{{route('masterproductdetails.export')}}" class="d-block "> Download Product Details</a>
						</div>
                       
                    </div>
                </div>
                <div class="row mt-4">

                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Product Stock</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="{{route('masterproductstock.export')}}" class="d-block "> Download Product Stock</a>
						</div>
                       
                    </div>
                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download MS Code</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="{{route('mscode.export')}}" class="d-block "> Download MS Code</a>
						</div>
                       
                    </div>
                </div>
                <div class="row mt-4">

                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Product Status</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="{{route('masterproductstatus.export')}}" class="d-block "> Download Product Status</a>
						</div>
                       
                    </div>
                    
                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Appointment Calendar Data</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="{{route('report.export')}}" class="d-block ">Appointment Calender Data</a>
						</div>
                       
                    </div>
                </div>
				
				<div class="row mt-4">

                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Product Crossref</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="{{route('mastercrossref.export')}}" class="d-block "> Download Product Crossref</a>
						</div>
                       
                    </div>
                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Product Application</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="{{route('masterapplication.export')}}" class="d-block "> Download Product Application</a>
						</div>
                       
                    </div>
                </div>
				
				<div class="row mt-4">

                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Spare</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="{{route('masterspare.export')}}" class="d-block "> Download Spare</a>
						</div>
                       
                    </div>
                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Spare Service</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="{{route('masterspareservice.export')}}" class="d-block "> Download Spare Service</a>
						</div>
                       
                    </div>
                </div>
				
				<div class="row mt-4">

                    <div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Spare OEM</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="{{route('masterspareoem.export')}}" class="d-block "> Download Spare OEM</a>
						</div>
                       
                    </div>
					
					<div class="col-6  pb-3 clearfix">
                        <h2 id="titleText" >Download Group Price</h2>
                        <div class="d-block filedetail mb-4">
                            <a class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase"  style="text-decoration: none;color:white" href="{{route('mastergroupprice.export')}}" class="d-block "> Download Group Price</a>
						</div>
                       
                    </div>
                </div>
				
            </form>
        </div>
    </div>
</div>
@endsection