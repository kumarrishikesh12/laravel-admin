<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.ico') }}" />
		<title>{!! trans('admin/auth.forgot_password') !!} | {{ config('app.name') }}</title>
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
            <form role="form" method="POST" action="{{ route('admin.passwords.email') }}">
                {{ csrf_field() }}
				<div class="row justify-content-md-center">
					<div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
						<div class="login-screen">
							<div class="login-box">
								<a href="javascript:void(0);" class="login-logo text-center">
									<img src="{{ asset('assets/admin/images/logo.png') }}" alt="{{ config('app.name') }}" />
								</a>
								<h5>{!! trans('admin/auth.forgot_password') !!}?</h5>
								<p class="info">{!! trans('admin/auth.forgot_password_message') !!}</p>
								<div class="form-group">
									<input type="text" name="email" class="form-control" placeholder="{!! trans('admin/auth.email') !!}" />
                                    @if ($errors->has('email'))
                                        <span class="text-danger" role="alert">
                                            {{ $errors->first('email') }}
                                        </span>
                                    @endif
								</div>
								<div class="actions">
									<button type="submit" class="btn btn-primary btn-block"><span class="icon-log-out"></span> {!! trans('admin/auth.reset_password') !!}</button>
								</div>
								<div class="mt-4">
									<a href="{{ url('admin') }}">Have Password? <span>Login</span></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>

		</div>
		<!-- Container end -->
	</body>
</html>