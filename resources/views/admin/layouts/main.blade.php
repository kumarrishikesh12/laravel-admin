<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.ico') }}" />
        <title>@yield('title') | {{ config('app.name') }}</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap.min.css') }}" />
        <!-- Icomoon Icons CSS -->
        <link rel="stylesheet" href="{{ asset('assets/admin/fonts/icomoon/icomoon.css') }}" />
        <!-- Master CSS -->
        <link rel="stylesheet" href="{{ asset('assets/admin/css/main.css') }}" />
    </head>
    <body>
        <!-- Loading start -->
        <div id="loading-wrapper">
            <div id="loader"></div>
        </div>
        <!-- Loading end -->
        <!-- BEGIN .app-wrap -->
        <div class="app-wrap">
            <!-- BEGIN .app-heading -->
            @include('admin.layouts.include.header')
            <!-- END: .app-heading -->
            <!-- BEGIN .app-container -->
            <div class="app-container">
                <!-- BEGIN .app-side -->
                @include('admin.layouts.include.sidebar')
                <!-- END: .app-side -->
                <!-- BEGIN .app-main -->
                <div class="app-main">
                    <!-- BEGIN content -->
                    @yield('content')
                    <!-- END: content -->
                    <!-- BEGIN .main-footer -->
                    <footer class="main-footer">
                        @include('admin.layouts.include.footer')
                    </footer>
                    <!-- END: .main-footer -->
                </div>
                <!-- END: .app-main -->
            </div>
            <!-- END: .app-container -->
        </div>
        <!-- END: .app-wrap -->
        <!-- jQuery JS. -->
        <script src="{{ asset('assets/admin/js/jquery.js') }}"></script>
        <!-- Tether Js, then other JS. -->
        <script src="{{ asset('assets/admin/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/admin/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/admin/js/nifty.min.js') }}"></script>
        <script src="{{ asset('assets/admin/js/bootbox.min.js') }}"></script>
        <script src="{{ asset('assets/admin/plugins/unifyMenu/unifyMenu.js') }}"></script>
        <script src="{{ asset('assets/admin/plugins/onoffcanvas/onoffcanvas.js') }}"></script>
        <script src="{{ asset('assets/admin/js/moment.js') }}"></script>
        <!-- News Ticker JS -->
        <script src="{{ asset('assets/admin/plugins/newsticker/newsTicker.min.js') }}"></script>
        <script src="{{ asset('assets/admin/plugins/newsticker/custom-newsTicker.js') }}"></script>
        <!-- Slimscroll JS -->
        <script src="{{ asset('assets/admin/plugins/slimscroll/slimscroll.min.js') }}"></script>
        <script src="{{ asset('assets/admin/plugins/slimscroll/custom-scrollbar.js') }}"></script>
        <!-- Gallery CSS -->
		<link rel="stylesheet" href="{{ asset('assets/admin/plugins/gallery/gallery.css') }}" />
        <!-- Gallery JS -->
		<script src="{{ asset('assets/admin/plugins/gallery/baguetteBox.js') }}" async></script>
		<script src="{{ asset('assets/admin/plugins/gallery/plugins.js') }}" async></script>
		<script src="{{ asset('assets/admin/plugins/gallery/custom-gallery.js') }}" async></script>
        <!-- Data Tables CSS -->
        <link rel="stylesheet" href="{{ asset('assets/admin/plugins/datatables/dataTables.bs4.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/admin/plugins/datatables/dataTables.bs4-custom.css') }}" />	
        <!-- Data Tables JS -->
        <script src="{{ asset('assets/admin/plugins/datatables/dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
        <!-- Custom Data tables JS -->
        <script src="{{ asset('assets/admin/plugins/datatables/custom/custom-datatables.js') }}"></script>
        <!-- Bootstrap Select CSS -->
		<link rel="stylesheet" href="{{ asset('assets/admin/plugins/bs-select/bs-select.css') }}" />
        <!-- Bootstrap Select JS -->
		<script src="{{ asset('assets/admin/plugins/bs-select/bs-select.min.js') }}"></script>
        <!-- Bootstrap autocomplete CSS -->
        <link rel="stylesheet" href="{{ asset('assets/admin/plugins/autocomplete/easy-autocomplete.css') }}" />
        <!-- Bootstrap autocomplete JS -->
        <script src="{{ asset('assets/admin/plugins/autocomplete/jquery.easy-autocomplete.js') }}"></script>
        <!-- Common JS -->
        <script src="{{ asset('assets/admin/js/common.js') }}"></script>
        @yield('scripts')
        @yield('styles')
    </body>
</html>