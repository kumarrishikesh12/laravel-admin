@extends('layouts.laravel_app')
@section('title')
{!! trans('user/auth.forgot_password') !!}
@endsection('title')
@section('content')
<!-- Container start -->
        <div class="container">
            <form role="form" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}
                <div class="row justify-content-md-center">
                    <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                        <div class="login-screen">
                            <div class="login-box">
                                <a href="javascript:void(0);" class="login-logo text-center">
                                    <img src="{{ asset('assets/admin/images/logo.png') }}" alt="{{ config('app.name') }}" />
                                </a>
                                <h5>{!! trans('user/auth.forgot_password') !!}?</h5>
                                <p class="info">{!! trans('user/auth.forgot_password_message') !!}</p>
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control" placeholder="{!! trans('user/auth.email') !!}" />
                                    @if ($errors->has('email'))
                                        <span class="text-danger" role="alert">
                                            {{ $errors->first('email') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="actions">
                                    <button type="submit" class="btn btn-primary btn-block"><span class="icon-log-out"></span> {!! trans('user/auth.reset_password') !!}</button>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('login')}}">Have Password? <span>Login</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <!-- Container end -->
@endsection
