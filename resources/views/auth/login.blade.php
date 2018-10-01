@extends('layouts.app')

@section('content')

    <h1>Đăng nhập</h1>
    <div class=" w3l-login-form">
        <form method="POST" action="{{ route('login') }}">
            <div class=" w3l-form-group form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                {{ csrf_field() }}
                <label for="email">E-Mail Address:</label>
                <div class="group">
                    <i class="fas fa-user"></i>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Email"/>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class=" w3l-form-group form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password">Password:</label>
                <div class="group">
                    <i class="fas fa-unlock"></i>
                    <input id="password"  name="password" type="password" class="form-control" placeholder="Password" required="required" />
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <button type="submit">Đăng nhập</button>
        </form>
    </div>
    {{--<footer>--}}
    {{--<p class="copyright-agileinfo"> &copy; 2018 Material Login Form. All Rights Reserved | Design by <a href="http://w3layouts.com">W3layouts</a></p>--}}
    {{--</footer>--}}

    {{--<div class="container">--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-8 col-md-offset-2">--}}
    {{--<div class="panel panel-default">--}}
    {{--<div class="panel-heading">Login</div>--}}

    {{--<div class="panel-body">--}}



    {{--<form class="form-horizontal" method="POST" action="{{ route('login') }}">--}}
    {{--{{ csrf_field() }}--}}

    {{--<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">--}}
    {{--<label for="email" class="col-md-4 control-label">E-Mail Addressssssssssssssssssssssssss</label>--}}

    {{--<div class="col-md-6">--}}
    {{--<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>--}}

    {{--@if ($errors->has('email'))--}}
    {{--<span class="help-block">--}}
    {{--<strong>{{ $errors->first('email') }}</strong>--}}
    {{--</span>--}}
    {{--@endif--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">--}}
    {{--<label for="password" class="col-md-4 control-label">Password</label>--}}

    {{--<div class="col-md-6">--}}
    {{--<input id="password" type="password" class="form-control" name="password" required>--}}

    {{--@if ($errors->has('password'))--}}
    {{--<span class="help-block">--}}
    {{--<strong>{{ $errors->first('password') }}</strong>--}}
    {{--</span>--}}
    {{--@endif--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="form-group">--}}
    {{--<div class="col-md-6 col-md-offset-4">--}}
    {{--<div class="checkbox">--}}
    {{--<label>--}}
    {{--<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me--}}
    {{--</label>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="form-group">--}}
    {{--<div class="col-md-8 col-md-offset-4">--}}
    {{--<button type="submit" class="btn btn-primary">--}}
    {{--Đăng nhập--}}
    {{--</button>--}}

    {{--<!-- <a class="btn btn-link" href="{{ route('password.request') }}">--}}
    {{--Forgot Your Password?--}}
    {{--</a> -->--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
@endsection
