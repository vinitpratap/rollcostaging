@extends('admin.layouts.app')

@section('title', 'login here')


@section('content')
<div class="container login">
<div class="row"><div class="col-lg-12 text-center"></div></div>
    <div class="row mt-5">
        <div class="col-md-8 ">
            <div class="panel panel-default" align="center">
            <img src="{{ URL::asset('images/logo-lg.svg') }}" /><br /><br /><br />
<br />

                <div class="panel-heading">Forget Password</div>

                <div class="panel-body">
                    <form class="form-horizontal" id="loginForm" method="POST" action="{{ route('password.email') }}">
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
                       <input type="hidden" name="submit" value="1">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-6 control-label">E-Mail Address</label>

                            <div class="col-md-12">
                                <input id="email" autocomplete="off" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-4">
                                <button type="submit" class="btn btn-default submit">Send Password Reset Link</button>
                                <a class="btn btn-link" href="{{route('admin.auth.login')}}">Login</a>
<hr>
<br />
© Copyright <?php echo date('Y');?>. enviro. All rights reserved.


                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> <script>
 $(document).ready(function(){
	 $('#loginForm').validate({ // initialize the plugin
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            },
        }
    });
 })
 </script>
@endsection