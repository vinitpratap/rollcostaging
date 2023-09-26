@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage  Spare Cross references</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title"> ID</th>
                                <th class="column-title">Spare</th>
                                <th class="column-title">Servicing number</th>
                                <th class="column-title">OEM</th>
                                <th class="column-title">Delete</th>
                                <th class="column-title">Check All &nbsp; <input type="checkbox" class="deleteCross" id="checkAll"></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $i = 1;?>
                            @foreach($data as $key=>$value)
                            <tr class="pointer">
                               <td>{{$i++}}</td>
                                <td>{{getSpareName($value->spareid)}}</td>
                                <td>{{$value->serv_no}}</td>
                                <td>{{$value->comp_oem_no}}</td>
                                <td class="last">
                                    <a href="{{route('sparecrossref.delete',base64_encode($value->scref_id))}}"  title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
                                </td>
                                <td><input type="checkbox" class="deleteCrossref" id="{{$value->scref_id}}"></td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="clearfix"></div>
            <div class="row  m-0 deleteCrossButt" style="display:none;">
                <div class="col-12 text-right pl-0 pr-0 pb-3 clearfix"><a href="javascript:void(0);" class="btn btn-outline-secondary  pl-4 pr-4 pt-2 pb-2  m-0" id="deletescrossRef"> Delete </a></div>
            </div>


        </div>
    </div>
</div>

<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText"> Upload Spare Cross references</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="spareRegister" action="{{route('sparecrossref.register')}} " enctype="multipart/form-data"> 

                {{ csrf_field() }}
                <input type="hidden" name="scrossref_id" id="scrossref_id">
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
                        <label for="category">Spare</label>
                        <select  class="form-control select"   id="category" name="spareid" required="">
                            <option value="" >Select Spare</option>
                            @foreach($spare as $key =>$value)
                            <option value="{{$value['spare_id']}}" >{{$value['spare_nm']}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-4 mb-3 ">
                        <label for="crossref_file"> File</label>
                        <input  name="crossref_file" type="file" id="crossref_file" >
                    </div>
                    
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitCategory">Add </button></div>
                </div>



            </form>
        </div>
    </div>
</div>
@endsection