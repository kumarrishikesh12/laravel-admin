<header class="app-header">
    <!-- Container fluid starts -->
    <div class="container-fluid">
        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-7 col-lg-7 col-md-6 col-sm-7 col-7">
                <!-- BEGIN .logo -->
                <div class="logo-block">
                    <a href="{{ url('admin/dashboard') }}" class="logo">
                        <img src="{{ asset('assets/admin/images/logo.png') }}" alt="{{ config('app.name') }}" />
                    </a>
                    <a class="mini-nav-btn" href="javascript:void(0);" id="onoffcanvas-nav">
                        <i class="open"></i>
                        <i class="open"></i>
                        <i class="open"></i>
                    </a>
                    <a href="#app-side" data-toggle="onoffcanvas" class="onoffcanvas-toggler" aria-expanded="true">
                        <i class="open"></i>
                        <i class="open"></i>
                        <i class="open"></i>
                    </a>
                </div>
                <!-- END .logo -->
            </div>
            <div class="col-xl-5 col-lg-5 col-md-6 col-sm-5 col-5">
                <!-- Header actions start -->
                <ul class="header-actions">
                    <li class="dropdown">
                        <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                            <div class="avatar avatar-img">
                                 @if(isset(Auth::user()->image))
                                <img src="{{ USER_IMAGE_URL.Auth::user()->image }}">
                                <!-- <span class="status online"></span> -->
                                @else
                                <img src="{{ asset('uploads/users/user.jpg') }}" />
                                @endif
                                
                            </div>
                            <span class="user-name">{{ Auth::user()->firstname }}</span>
                            <i class="icon-chevron-small-down downarrow"></i>
                        </a>
                        <div class="dropdown-menu lg dropdown-menu-right" aria-labelledby="userSettings">
                            <div class="admin-settings">
                                <ul class="admin-settings-list">
                                    <li>
                                        <a href="{{ url('profile/edit') }}">
                                            <span class="icon icon-user"></span>
                                            <span class="text-name">{!! trans('user/header.profile') !!}</span>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="admin-settings-list">
                                    <li>
                                        <a href="{{ url('password/change') }}">
                                            <span class="icon icon-cog"></span>
                                            <span class="text-name">{!! trans('user/header.changePassword') !!}</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="actions">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-primary btn-block"><span class="icon-log-out"></span> {!! trans('user/header.logout') !!}</a>
                                    <form id="logout-form" action="{{ route('logout')  }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <!-- Header actions end -->
            </div>
        </div>
        <!-- Row start -->
    </div>
    <!-- Container fluid ends -->
</header>