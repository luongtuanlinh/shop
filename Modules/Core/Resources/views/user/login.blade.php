@extends('layouts.admin_login')
@section('title', 'Login')
@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>{{env('APP_NAME')}}</b></a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Đăng nhập để bắt đầu phiên làm việc</p>

        @if ($errors->any())
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        @endif

        @if(session()->has('login_error'))
            <span style="color:red">{{session()->get('login_error')}}</span>
        @endif

        <form method="post">
            <div class="form-group has-feedback">
                <input type="text" name="username" class="form-control" placeholder="Username">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember_me"> Ghi nhớ mật khẩu
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('core::general.login') }}</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        {{--<a href="{{route('forgot_password')}}">@lang('core::general.forgot_password')</a><br>--}}
 

    </div>
</div>
@endsection