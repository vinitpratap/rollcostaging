@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage Deleted Temp Customers</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content  mb-3 col-12 clearfix">

                <div class="table-responsive-md collRquest pb-4">
                    <form method="get">
                        <div class="row mt-4">
                            <div class="col-md-4 mb-3 padRig">
                                <label>&nbsp;</label>
                                <input type="text" placeholder="Search by" name="search"  autocomplete="off" class="form-control" value="{{ app('request')->input('search') }}">
                            </div>

                            <div class="col-md-4 mb-3 padRig">
                                <label>Show Entries</label>
                                <select class="form-control select" id="data_entries" name="data_entries" >                                    @foreach($pagination_arr as $val)
                                    <option value="{{$val}}" <?php if (app('request')->input('data_entries') == $val) { ?> selected <?php } ?>>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 pt-35 padRig">
                                <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase">Search</button>
                            </div>



                        </div>
                        {{ csrf_field() }}

                    </form>
                    <div class="clearfix table-responsive">  
                    <table id="datatable1" class="table">

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
                        <thead>
                            <tr class="headings">
                                <td class="column-title">Customers ID</td>
                                <td class="column-title">Company Name</td>
                                <td class="column-title">City</td>
                                <td class="column-title">ZIP</td>
                                <td class="column-title">Registered on</td>
                                <td class="column-title">Action</td>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if (count($data) > 0) { ?>
                                @foreach($data as $key=>$value)
                                <tr class="pointer">
                                    <td>{{$value->customerID}}</td>
                                    <td>{{$value->firstName . " ". $value->lastName}}</td>
                                    <td class="whiteSpace">{{$value->com_city}} </td>
                                    <td>{{$value->com_zipCode}}</td>
                                    <td>{{date("jS M Y H:i:s", strtotime($value->created_at))}}</td>
                                    <td class="last">
                                        <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="{{base64_encode($value->u_id)}}" class="restoreDelTempUser" src="{{ URL::asset('images/restore-user.png') }}" alt=""></a> 
                                        <a href="{{route('deltempuser.delete',base64_encode($value->u_id))}}"  title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
                                    </td>

                                </tr>
                                @endforeach
                            <?php } else { ?>
                                <tr class="pointer">
                                    <td colspan="100%" style="text-align: center">
                                        No customer data
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                    {{ $data->links('common.custompagination') }}
                </div>



            </div>
			            <div class="clearfix"></div>
<?php if (count($data) > 0) { ?>
                <div class="row  m-0">
                    <div class="col-6"><span>Total  {{ $data->total() }} records</span></div>
                    <?php $routeValues = 'search=' . app('request')->input('search'); ?>
                    <div class="col-6 text-right pl-0 pr-0 pb-3 clearfix"><a href="{{route('deltempuser.export',$routeValues)}}" class="btn btn-outline-secondary pl-4 pr-4 pt-2 pb-2  m-0" id="exporttoExcel"> <img src="{{ URL::asset('images/excel.svg') }}" class="pr-2" alt="Export to Excel"> Export Deleted Temp Customers </a></div>

                </div>
            <?php } ?>
        </div>
    </div>
</div>


<div class="col-lg-12 col-md-12 col-12 cust-form" <?php if(isset($tempData)) { ?> style="display: block;" <?php } else  { ?> style="display: none;" <?php } ?>>
    <div class="x_panel newRequestForm">
        <div class="x_title">
            <h2 id="titleText">Approve Temp Customer</h2>
            <div class="clearfix"></div>
        </div>
        
        <form method="post" id="tempcustRegister" action=" {{route('tempuser.edit')}}"> 

            {{ csrf_field() }}
            <input type="hidden" name="u_id" id="u_id"  value="<?php if(isset($tempData)) { echo $tempData['u_id']; } ?>">
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
                
                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName">First Name</label>
                    <input type="text" class="form-control" autocomplete="off" id="requestFName" name="firstName"   >
                </div>
                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName">Last Name</label>
                    <input type="text" class="form-control" autocomplete="off" id="requestLName" name="lastName"   >
                </div>
                <div class="col-md-3 mb-3 padRig">
                    <label for="requestLocation">Category</label>
                    <select  class="form-control select" id="custcatid" name="role" required="required">
                        <option value="">Select Category</option>
                        @foreach($catData as $key=>$value)
                        <option value="{{$value['cust_cat_nme']}}">{{$value['cust_cat_nme']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3 padRig">
                    <label for="requestEmailID">Email ID *</label>
                    <input type="text" class="form-control" autocomplete="off" id="com_emailAddress" name="com_emailAddress" value="" required>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName">Street Address 1</label>
                    <input type="text" class="form-control" autocomplete="off" id="streetAddress1" name="streetAddress1"  value="" >
                </div>
                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName">Street Address 2</label>
                    <input type="text" class="form-control" autocomplete="off" id="streetAddress2" name="streetAddress2"  value="" >
                </div>

                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName">City</label>
                    <input type="text" class="form-control" autocomplete="off" id="com_city" name="com_city"  value="<?php if(isset($tempData)) { ?> {{$tempData['com_city']}} <?php } ?>" >
                </div>

                <div class="col-md-3 mb-3 padRig">
                    <label for="requestEmailID">State</label>
                    <input type="text" class="form-control" autocomplete="off" id="com_state" name="com_state"  value="" >
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4 mb-3 padRig">
                    <label for="requestName">Zip Code</label>
                    <input type="text" class="form-control" autocomplete="off" id="com_zipCode" name="com_zipCode"  value="<?php if(isset($tempData)) { ?> {{$tempData['com_zipCode']}} <?php } ?>" >
                </div>
                <div class="col-md-4 mb-3 padRig">
                    <label for="requestName">Telephone</label>
                    <input type="text" class="form-control" autocomplete="off"  onkeyup="if (/\D/g.test(this.value))
                                this.value = this.value.replace(/\D/g, '')" id="com_Telephone" name="com_Telephone"  value="" >
                </div>

                <div class="col-md-4 mb-3 padRig">
                    <label for="requestName">Fax</label>
                    <input type="text" class="form-control" autocomplete="off" id="com_Fax" name="com_Fax"  value="" >
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName">Company Name</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyName" name="companyName"  value="<?php if(isset($tempData)) { ?> {{$tempData['firstName']}} <?php } ?>" required>
                </div>
                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName">Company Website </label>
                    <input type="text" class="form-control" autocomplete="off" id="companyWebsite" name="companyWebsite"  value="" >
                </div>

                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName">Registration Number</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyRegistrationNumber" name="companyRegistrationNumber"  value="" >
                </div>

                <div class="col-md-3 mb-3 padRig">
                    <label for="requestEmailID">VAT Registration Number</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyVatNumber" name="companyVatNumber"  value="" >
                </div>
            </div>
            <h8 id="titleText">Company Registered Office Address</h8>
            <div class="row mt-4">

                <div class="col-md-2 mb-3 padRig">
                    <label for="requestName">Address 1</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyRegAdd1" name="companyRegAdd1"  value="" >
                </div>
                <div class="col-md-2 mb-3 padRig">
                    <label for="requestName">Address 2</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyRegAdd2" name="companyRegAdd2"  value="" >
                </div>

                <div class="col-md-2 mb-3 padRig">
                    <label for="requestName"> City</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyRegCity" name="companyRegCity"  value="" >
                </div>

                <div class="col-md-2 mb-3 padRig">
                    <label for="requestName"> State</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyRegState" name="companyRegState"  value="" >
                </div>

                <div class="col-md-2 mb-3 padRig">
                    <label for="requestName">Zip / Post Code</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyRegZip" name="companyRegZip"  value="" >
                </div>

            </div>
            <h8 id="titleText">Company Invoice Office Address</h8>
            <div class="row mt-4">
                <div class="col-md-2 mb-3 padRig">
                    <label for="requestName">Address 1</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyInvAdd1" name="companyInvAdd1"  value="" >
                </div>
                <div class="col-md-2 mb-3 padRig">
                    <label for="requestName">Address 2</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyInvAdd2" name="companyInvAdd2"  value="" >
                </div>

                <div class="col-md-2 mb-3 padRig">
                    <label for="requestName"> City</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyInvCity" name="companyInvCity"  value="" >
                </div>

                <div class="col-md-2 mb-3 padRig">
                    <label for="requestName"> State</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyInvState" name="companyInvState"  value="" >
                </div>

                <div class="col-md-2 mb-3 padRig">
                    <label for="requestName">Zip / Post Code</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyInvZip" name="companyInvZip"  value="" >
                </div>

            </div>
            <h8 id="titleText"> Company Contact Person (Accounts) </h8>
            <div class="row mt-4">

                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName">Name</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyAccountPerName" name="companyAccountPerName"  value="" >
                </div>
                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName">E-mail ID</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyAccountPerEmail" name="companyAccountPerEmail"  value="" >
                </div>

                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName"> Mobile</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyAccountPerMobile" name="companyAccountPerMobile"  value="" onkeyup="if (/\D/g.test(this.value))
                                this.value = this.value.replace(/\D/g, '')">
                </div>

                <div class="col-md-3 mb-3 padRig">
                    <label for="requestName"> Department</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyAccountPerDepartment" name="companyAccountPerDepartment"  value="" >
                </div>


            </div>


            <h8 id="titleText">Bank Details</h8>
            <div class="row mt-4">

                <div class="col-md-4 mb-3 padRig">
                    <label for="requestEmailID">Bank Name</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyBankName" name="companyBankName" value="" >
                </div>
                <div class="col-md-4 mb-3 padRig">
                    <label for="requestAddress">Bank Address</label>
                    <input type="text" class="form-control" id="companyBankAddress" autocomplete="off" name="companyBankAddress"  value="" >
                </div>
                <div class="col-md-4 mb-3">
                    <label for="requestAddress2">Zip / Post Code</label>
                    <input type="text" class="form-control" id="companyBankPostCode" autocomplete="off" name="companyBankPostCode"  value="" >
                </div>

            </div>

            <div class="row mt-4">
                <div class="col-md-4 mb-3 padRig">
                    <label for="requestEmailID">Account Number</label>
                    <input type="text" class="form-control" autocomplete="off" id="companyBankAccount" name="companyBankAccount" value="" onkeyup="if (/\D/g.test(this.value))
                                this.value = this.value.replace(/\D/g, '')">
                </div>
                <div class="col-md-4 mb-3 padRig">
                    <label for="requestAddress">Contact Number</label>
                    <input type="text" class="form-control" id="companyContactNumber" autocomplete="off" name="companyContactNumber"  value="" >
                </div>
                <div class="col-md-4 mb-3">
                    <label for="requestAddress2">Sort Code</label>
                    <input type="text" class="form-control" id="companySortCode" autocomplete="off" name="companySortCode"  value="" >
                </div>

            </div>
<!--            <span>Category : </span>
            <div class="row mt-4">

                @foreach($custCatData as $k =>$v)
                <div class="col mb-3 align-self-center mt-4">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="custCat[]" class="custom-control-input all_flag" id="flag_{{$v->sc_id}}" value="{{$v->sc_id}}">
                        <label class="custom-control-label" for="flag_{{$v->sc_id}}">{{$v->scat_nm}}</label>
                    </div>
                </div>
                @endforeach

            </div>-->
            <div class="row mt-4">

                <div class="col-md-3 mb-3 padRig">
                    <label for="requestLocation">Group</label>
                    <select  class="form-control select" id="grp_id" name="g_id" required="required">
                        <option value="">Select Group</option>
                        @foreach($groupData as $key=>$value)
                        <option value="{{$value['gr_id']}}">{{$value['gr_nm']}}</option>
                        @endforeach
                    </select>
                </div>
				
				<div class="col-md-4 mb-4 padRig">
                    <label for="requestLocation">Account Code</label>
                   <input type="text" class="form-control" autocomplete="off" id="accnt_code" name="accnt_code"  value="<?php if(isset($tempData)) { ?> {{$tempData['customerID']}} <?php } ?>" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="status">Status</label>
                    @if ($errors->has('cust_status'))
                    <span class="help-block">
                        <strong>{{ $errors->first('user_status') }}</strong>
                    </span>
                    @endif
                    <select  class="form-control select " id="cust_status" name="user_status">
                        <option value="2"  >Active</option>
                        <option value="1"  >Pending</option>
                        <option value="0" >Blocked</option>
                    </select>
                </div>
            </div>


            <div class="row mt-4">
                <div class="col-12  pb-3 clearfix"><div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitCust">Approve </button></div>
                </div>



        </form>
    </div>
</div>
</div>

@endsection