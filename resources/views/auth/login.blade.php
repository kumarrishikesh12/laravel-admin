@extends('layouts.laravel_app')
@section('title')
{!! trans('user/auth.login') !!}
@endsection('title')
@section('content')
<div class="container">
            <form role="form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="row justify-content-md-center">
                    <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                        <div class="login-screen">
                            <div class="login-box">
                                <a href="javascript:void(0);" class="login-logo text-center">
                                    <img src="{{ asset('assets/admin/images/logo.png') }}" alt="{{ config('app.name') }}" />
                                </a>
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control" placeholder="{!! trans('user/auth.email') !!}" />
                                    @if ($errors->has('email'))
                                        <span class="text-danger" role="alert">
                                            {{ $errors->first('email') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="{!! trans('user/auth.password') !!}" />
                                    @if ($errors->has('password'))
                                        <span class="text-danger" role="alert">
                                            {{ $errors->first('password') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="actions">
                                    <button type="submit" class="btn btn-primary btn-block"><span class="icon-log-out"></span> {!! trans('user/auth.login') !!}</button>
                                    <a href="{{ route('password.request') }}">{!! trans('user/auth.forgot_password') !!}?</a>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('register') }}" class="additional-link">{!! trans('user/auth.not_registered') !!}? <span>{!! trans('admin/auth.create_account') !!}</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <!-- Container end -->
@endsection
