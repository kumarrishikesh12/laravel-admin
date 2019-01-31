@extends('layouts.laravel_app')
@section('title')
{!! trans('user/auth.register') !!}
@endsection('title')
@section('content')
<!-- Container start -->
        <div class="container">
            <form id="SignUp" action="{{ route('register') }}" method="post">
                {{ csrf_field() }}
                <div class="row justify-content-md-center">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="login-screen">
                            <div class="login-box">
                                <a href="javascript:void(0);" class="login-logo text-center">
                                    <img src="{{ asset('assets/admin/images/logo.png') }}" alt="{{ config('app.name') }}" />
                                </a>
                                <div class="row gutters">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <input type="text" name="firstname" class="form-control" placeholder="{!! trans('user/auth.firstname') !!}" />
                                            @if ($errors->has('firstname'))
                                                <span class="text-danger" role="alert">
                                                    {{ $errors->first('firstname') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <input type="text" name="lastname" class="form-control" placeholder="{!! trans('user/auth.lastname') !!}" />
                                            @if ($errors->has('lastname'))
                                                <span class="text-danger" role="alert">
                                                    {{ $errors->first('lastname') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control" placeholder="{!! trans('user/auth.username') !!}" />
                                            @if ($errors->has('username'))
                                                <span class="text-danger" role="alert">
                                                    {{ $errors->first('username') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control" placeholder="{!! trans('user/auth.email') !!}" />
                                            @if ($errors->has('email'))
                                                <span class="text-danger" role="alert">
                                                    {{ $errors->first('email') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control" placeholder="{!! trans('user/auth.password') !!}" />
                                            @if ($errors->has('password'))
                                                <span class="text-danger" role="alert">
                                                    {{ $errors->first('password') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="{!! trans('user/auth.password_confirmation') !!}" />
                                            @if ($errors->has('password_confirmation'))
                                                <span class="text-danger" role="alert">
                                                    {{ $errors->first('password_confirmation') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="actions clearfix">
                                    <button type="submit" class="btn btn-primary btn-block"><span class="icon-log-out"></span> {!! trans('user/auth.register') !!}</button>
                                </div>
                                <!-- <div class="or">
                                    <span>or signup using</span>
                                </div>
                                <div class="row gutters">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <button type="submit" class="btn btn-tw btn-block">Twitter</button>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <button type="submit" class="btn btn-fb btn-block">Facebook</button>
                                    </div>
                                </div> -->
                                <a href="{{ route('login') }}" class="additional-link">{!! trans('user/auth.have_account') !!}? <span>{!! trans('user/auth.login_now') !!}</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Container end -->
@endsection
