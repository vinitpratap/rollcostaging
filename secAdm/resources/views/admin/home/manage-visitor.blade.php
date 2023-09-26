@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Visitor's IP Address</h2>
                <div class="clearfix"></div>
            </div>

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

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <form method="get">


                        <div class="row mt-4">
                            <div class="col-md-8 mb-3 padRig">
                                <input type="text" placeholder="Search by IP Address" name="search"  autocomplete="off" class="form-control" value="{{ app('request')->input('search') }}">
                            </div>
                            <div class="col-md-4 mb-3 padRig">
                                <button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase">Search</button>
                            </div>
                             {{ csrf_field() }}
                        </div>
                        
                    </form>
                    <?php if (count($data) > 0) { ?>
                        <table id="datatable1" class="table table-striped ">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title">ID</th>
                                    <th class="column-title">IP Address</th>
                                    <th class="column-title">Date</th>
                                    <th class="column-title">Action</th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach($data as $key=>$value)
                                <tr class="pointer">
                                    <td>{{$value->id}}</td>
                                    <td>{{$value->ip_add}}</td>
                                    <td>{!! date("jS M Y",strtotime($value->created_at))!!}</td>
                                    
                                    <td class="last">
                                        @if(Auth::guard('admin')->user()->admin_role==1)
                                        <a href="{{route('visitor.delete',base64_encode($value->id))}}"  title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
                                    </td>
                                    @endif

                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    <?php } else { ?>
                        <strong style="margin-left: 35%;color: red;">No data available </strong>
                    <?php } ?>
                    {{ $data->links('common.custompagination') }}

                </div>

            </div>

            <div class="clearfix"></div>

        </div>
    </div>
</div>


@endsection