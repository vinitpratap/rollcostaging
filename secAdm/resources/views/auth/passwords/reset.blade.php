<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @include('common.head')
    </head>

    <body class="nav-md myEffect bg-white">
        <div class="container " style="padding-left:70px; padding-right:15px; position: relative; padding-top:10%;  ">
            <div class="row  justify-content-center ">
                <div class="col-md-6  col-lg-4  col-10">
                    <div class="panel panel-default">
                        <div class="panel-heading pl-">Password Reset</div>

                        <div class="panel-body  row">
                            <form class="form-horizontal" id="loginForm" method="POST" action="{{ route('password.reset') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="token" value="{{ $token }}">
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

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    
                                    <label for="email" class="col-md-6 control-label">Password</label>

                                    <div class="col-md-12">
                                       <input type="password" class="form-control" id="password" name="password" placeholder="Password" required=""/>

                                        @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    
                                    
                                    <label for="email" class="col-md-6 control-label">Confirm Password</label>

                                    <div class="col-md-12">
                                       <input type="password_confirmation" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password"/>

                                        @if ($errors->has('password_confirmation'))
                                    <span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span> @endif
                                    </div>
                                    
                                   
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 col-md-offset-4">
                                        <button type="submit" class="btn btn-default submit">Reset Password</button>
                                        <a class="btn btn-link" href="{{route('admin.auth.login')}}">Login</a>
                                        <hr>


                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <script>
                    $(document).ready(function () {
                        $('#loginForm').validate({// initialize the plugin
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
            </div>
        </div>
        @include('common.footer')
    </body>
</html>




