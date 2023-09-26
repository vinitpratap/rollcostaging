@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>View Order Details</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">S. No.</th>
                                <th class="column-title">Order No</th>
                                <th class="column-title">Part No.</th>
                                <th class="column-title">Make</th>
                                <th class="column-title">OEM</th>
                                <th class="column-title">Qty.</th>
                                <th class="column-title">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach($data as $key=>$value)
                            @foreach($value->getOrderDetails as $okey=>$ovalue)

                            <?php
                            if ($ovalue->prod_id > 0) {
                                $prName = getprName($ovalue->prod_id);
                                
                            } else {
                                $prName = getSpareName($ovalue->spr_id);
                                $sprDetail = getSpareDetail($ovalue->spr_id);
                            }
                            
                            ?>

                            <tr class="pointer">
                                <td>{{$i++}}</td>
                                <td>{{$value->order_no}}</td>
                                <td>{{$prName}}</td>
                                <?php 
                                if ($ovalue->prod_id > 0) {
                                ?>
                                <td>{{getMakeByProductID($ovalue->prod_id)}}</td>
                                <?php } else{ ?>
                                <td>{{$sprDetail->spare_make}}</td>
                                <?php } ?>
                                <?php
                                if ($ovalue->prod_id > 0) {
                                    $prOEM = getProductOEM($prName);
                                } else {
                                    $prOEM = $sprDetail->spare_oem;
                                }
                                ?>
                                <td>{{$prOEM}}</td>
                                <td>{{$ovalue->prod_qty}}</td>
                                <td>{{html_entity_decode(getUserCurrency(getGroupCurrencySign($value->user_id))) .' '.$ovalue->prod_price}}</td>

                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <span class="totalPriceSpan">Total price : <strong>{{html_entity_decode(getUserCurrency(getGroupCurrencySign($value->user_id))) .' '.$value->totalprice}}</strong></span>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <form method="post" id="GroupRegister" action="{{route('order.edit')}}" enctype="multipart/form-data" > 
                {{ csrf_field() }}
                <input type="hidden" name="order_id" id="order_id" value="{{$value->order_id}}">
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
                        <label for="status">Special Instructions</label>
                        <textarea class="form-control" readonly>
						@if($value->order_instruction)
						{{trim($value->order_instruction)}}
						@else
							None
						@endif
                        </textarea>

                    </div>

                    <div class="col-md-4 mb-3 padRig">
                        <label for="status">Status</label>
                        @if ($errors->has('order_status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('order_status') }}</strong>
                        </span>
                        @endif
                        <select  class="form-control select " id="order_status" name="order_status">
                            <option value="1" @if ($value->order_status=='0') selected="selected" @endif>Open</option>
                            <option value="5" @if ($value->order_status==5) selected="selected" @endif>Closed</option>
                            <option value="6" @if ($value->order_status==6) selected="selected" @endif>Canceled</option>
                        </select>
                    </div>


                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix">
                        <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitOrder">Update </button>

                        <a href="{{route('order.manage')}} "><button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitOrder">Back</button></a>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection