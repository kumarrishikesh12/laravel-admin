<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.ico') }}" />
        <title>@yield('title')</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap.min.css') }}" />
        <!-- Icomoon Icons CSS -->
        <link rel="stylesheet" href="{{ asset('assets/admin/fonts/icomoon/icomoon.css') }}" />
        <!-- Master CSS -->
        <link rel="stylesheet" href="{{ asset('assets/admin/css/main.css') }}" />
</head>
<body>

        @yield('content')
</body>
</html>
