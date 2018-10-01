@extends('layouts.app')

@section('content')

    <h1>Đăng ký</h1>
    <div class=" w3l-login-form">
        <form method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <div class=" w3l-form-group form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" control-label>Name:</label>
                <div class="group">
                    <i class="fas fa-user"></i>
                    <input id="name" type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}" required autofocus />
                    @if ($errors->has('name'))
                        <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class=" w3l-form-group form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" >E-Mail Address:</label>
                <div class="group">
                    <i class="fas fa-user"></i>
                    <input id="email" type="email" class="form-control" name="email" placeholder="E-Mail Address"  value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class=" w3l-form-group">
                <label for="password" >Password:</label>
                <div class="group">
                    <i class="fas fa-unlock"></i>
                    <input id="password" type="password" class="form-control" name="password" placeholder="Password"  required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class=" w3l-form-group">
                <label for="password-confirm">Confim Password:</label>
                <div class="group">
                    <i class="fas fa-unlock"></i>
                    <input id="password-confirm" type="password" class="form-control" placeholder="Confim Password"  name="password_confirmation" required>
                </div>
            </div>
            <button type="submit" class="btn-register">Đăng ký</button>
        </form>
    </div>


    {{--<div class="container">--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-8 col-md-offset-2">--}}
    {{--<div class="panel panel-default">--}}
    {{--<div class="panel-heading">Register</div>--}}

    {{--<div class="panel-body">--}}
    {{--<form class="form-horizontal" method="POST" action="{{ route('register') }}">--}}
    {{--{{ csrf_field() }}--}}

    {{--<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">--}}
    {{--<label for="name" class="col-md-4 control-label">Name</label>--}}

    {{--<div class="col-md-6">--}}
    {{--<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>--}}

    {{--@if ($errors->has('name'))--}}
    {{--<span class="help-block">--}}
    {{--<strong>{{ $errors->first('name') }}</strong>--}}
    {{--</span>--}}
    {{--@endif--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">--}}
    {{--<label for="email" class="col-md-4 control-label">E-Mail Address</label>--}}

    {{--<div class="col-md-6">--}}
    {{--<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>--}}

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
    {{--<label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>--}}

    {{--<div class="col-md-6">--}}
    {{--<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="form-group">--}}
    {{--<div class="col-md-6 col-md-offset-4">--}}
    {{--<button type="submit" class="btn btn-primary">--}}
    {{--Đăng ký--}}
    {{--</button>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
@endsection
