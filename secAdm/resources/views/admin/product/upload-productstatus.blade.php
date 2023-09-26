@extends('admin.layouts.app')

@section('content')
<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText" >Upload Products Status</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="uproductRegister" action="{{route('productsstock.upload')}} " enctype="multipart/form-data">
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
                        <h2 id="titleText" >Upload Products Status</h2>
                        <div class="d-block filedetail mb-4">
                            <label for="products_file"> File</label>
                            <input  name="productsstatus_file" type="file" id="products_file" ><a href="{{URL('Demo')}}/sample_product_stock.csv" class="d-block "> Download sample file</a> </div>
                        <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitUproducts">Upload </button>


                        <p class="pt-4">Please first download file and don't change cell header</p>


                        <?php /* ?><a href="{{URL('Demo')}}/demo-ApplicationData.csv"><button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="downloadspearOEM">Download </button></a>
                          <p class="pt-4">Please first download file and don't change cell header</p><?php */ ?>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
</div>
@endsection