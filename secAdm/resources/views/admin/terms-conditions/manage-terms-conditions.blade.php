@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Update Terms & Conditions</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title"> ID</th>
                                <th class="column-title">Title</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $i = 1;?>
                            @foreach($data as $key=>$value)
                            <tr class="pointer">
                                <td>{{$i++}}</td>
                                <td class="whiteSpace">{{$value->term_title}}</td>
                                <td class="last">
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="{{base64_encode($value->id)}}" class="editTerms" src="{{ URL::asset('images/edit.svg') }}" alt=""></a>
                                    
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

<div class="row pt-3 privacy-policy-form" >
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText"> Update Terms & Conditions</h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="privacyRegister" action="{{route('terms.register')}} ">

                {{ csrf_field() }}
                <input type="hidden" name="id" id="id">
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
                        <label for="locationName">Title</label>
                        @if ($errors->has('term_title'))
                        <span class="help-block">
                            <strong>{{ $errors->first('term_title') }}</strong>
                        </span>
                        @endif
                        <input type="text" class="form-control " autocomplete="off" id="term_title" name="term_title" placeholder="Title"  required>
                    </div>
                    
                </div>
                <div class="row mt-4">
                    <div class="col-md-12 mb-3 padRig">
                        <label for="locationName">Terms Text</label>
                        @if ($errors->has('term_text'))
                        <span class="help-block">
                            <strong>{{ $errors->first('term_text') }}</strong>
                        </span>
                        @endif

                        <textarea  class="form-control" autocomplete="off" id="term_text" name="term_text" placeholder="Terms Text"  required></textarea>
                    </div>

                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitNews">Update  </button></div>
                </div>



            </form>
        </div>
    </div>
</div>
@endsection
