<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.ico') }}" />
		<title>{!! trans('admin/auth.login') !!} | {{ config('app.name') }}</title>
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap.min.css') }}" />
		<!-- Icomoon Icons CSS -->
		<link rel="stylesheet" href="{{ asset('assets/admin/fonts/icomoon/icomoon.css') }}" />
		<!-- Master CSS -->
		<link rel="stylesheet" href="{{ asset('assets/admin/css/main.css') }}" />
	</head>
	<body>
		<!-- Container start -->
		<div class="container">
            <form role="form" method="POST" action="{{ route('admin.login') }}">
                {{ csrf_field() }}
				<div class="row justify-content-md-center">
					<div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
						<div class="login-screen">
							<div class="login-box">
								<a href="javascript:void(0);" class="login-logo text-center">
									<img src="{{ asset('assets/admin/images/logo.png') }}" alt="{{ config('app.name') }}" />
								</a>
								<div class="form-group">
									<input type="text" name="username" class="form-control" placeholder="{!! trans('admin/auth.username').'/'.trans('admin/auth.email') !!}" />
                                    @if ($errors->has('username'))
                                        <span class="text-danger" role="alert">
                                            {{ $errors->first('username') }}
                                        </span>
                                    @elseif ($errors->has('email'))
                                        <span class="text-danger" role="alert">
                                            {{ $errors->first('email') }}
                                        </span>
                                    @endif
								</div>
								<div class="form-group">
									<input type="password" name="password" class="form-control" placeholder="{!! trans('admin/auth.password') !!}" />
                                    @if ($errors->has('password'))
                                        <span class="text-danger" role="alert">
                                            {{ $errors->first('password') }}
                                        </span>
                                    @endif
								</div>
								<div class="actions">
									<button type="submit" class="btn btn-primary btn-block"><span class="icon-log-out"></span> {!! trans('admin/auth.login') !!}</button>
									<a href="{{ route('admin.passwords.email') }}">{!! trans('admin/auth.forgot_password') !!}?</a>
								</div>
								<!-- <div class="mt-4">
									<a href="{{ route('admin.register') }}" class="additional-link">{!! trans('admin/auth.not_registered') !!}? <span>{!! trans('admin/auth.create_account') !!}</span></a>
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</form>

		</div>
		<!-- Container end -->
	</body>
</html>