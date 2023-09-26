@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Product Group</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">S. No.</th>
                                <th class="column-title">Group</th>
                                <th class="column-title">Part No.</th>
                                <th class="column-title">Price</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;?>
                            @foreach($data as $key=>$value)
                            <tr class="pointer">
                               <td>{{$i++}}</td>
                                <td>{{$value->getGroup[0]->gr_nm}}</td>
                                <td>{{$value->part_nm}}</td>
                                <td>{{$value->pr_price}}</td>
                                <td class="last"> 
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="{{base64_encode($value->gr_id)}}_{{base64_encode($value->grp_id)}}" class="editProductsgroup" src="{{ URL::asset('images/edit.svg') }}" alt=""></a> 
                                    <a href="{{route('productsgroup.delete',[base64_encode($value->gr_id),base64_encode($value->grp_id)])}}" title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
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

<div class="row pt-3 viewPrgrp" <?php if((isset($errors) && count($errors) > 0) || (session()->has('message'))){} else echo 'style="display: none"';?>>
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText"> Edit Price</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="priceUpdate" action="{{route('productsgroup.edit')}}"> 
                {{ csrf_field() }}
                <input type="hidden" name="gr_id" id="gr_id" value="{{ old('gr_id') }}">
                <input type="hidden" name="grp_id" id="grp_id" value="{{ old('grp_id') }}">
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
                        <label for="locationName">Part No.</label>
                        @if ($errors->has('part_nm'))
                        <span class="help-block">
                            <strong>{{ $errors->first('part_nm') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="part_nm" name="part_nm" placeholder="eg:-ALT100" value="{{ old('part_nm') }}" required="required"  >
                    </div>
                    <div class="col-md-4 mb-3 padRig">
                        <label for="locationName">Price</label>
                        @if ($errors->has('pr_price'))
                        <span class="help-block">
                            <strong>{{ $errors->first('pr_price') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="pr_price" name="pr_price" placeholder="eg:-100" value="{{ old('pr_price') }}" required="required"  >
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitProductGroup">Edit Price</button></div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection