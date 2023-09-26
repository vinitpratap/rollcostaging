@extends('admin.layouts.app')

@section('title', 'login here')


@section('content')
<div class="container login">
<div class="row"><div class="col-lg-12 text-center"></div></div>
    <div class="row mt-5">
        <div class="col-md-8 ">
            <div class="panel panel-default" align="center">
                <h1>Rolling Components</h1>
            
            
            <br /><br /><br />
<br />

                <div class="panel-heading">Admin Login</div>

                <div class="panel-body">
                    <form class="form-horizontal" id="loginForm" method="POST" action="{{ route('admin.auth.loginAdmin') }}">
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
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-8">
                                <input id="email" autocomplete="off" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="sbmt_btn ">
                                    Login
                                </button>
<hr>
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a> 
                            </div><br />
<br />
© Copyright <?php echo date('Y');?>. rollingcomponents. All rights reserved.
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