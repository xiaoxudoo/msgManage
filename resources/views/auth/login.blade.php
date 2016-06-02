@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('u_name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">User Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="u_name" value="{{ old('u_name') }}">

                                @if ($errors->has('u_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('u_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('u_password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="u_password">

                                @if ($errors->has('u_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('u_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('u_captcha') ? ' has-error' : '' }}">
                            
                            <label class="col-md-4 control-label">Verify Code</label>

                            <div class="col-md-3">
                                <input type="text" class="form-control" name="u_captcha" value="{{ old('u_captcha') }}" required placeholder=请输入验证码 />

                                @if ($errors->has('u_captcha'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('u_captcha') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-3">
                               <a onclick="javascript:re_captcha();">
                                    <img id="recaptcha" src="{{ url('/validitPicture/1') }}" alt="">
                                </a> 
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i>Login
                                </button>

                                <!-- <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    function re_captcha() {
        $url = "{{ URL('/validitPicture') }}";
        $url = $url + "/" + Math.random();
        document.getElementById('recaptcha').src=$url;
    }
    
</script>
@endsection
