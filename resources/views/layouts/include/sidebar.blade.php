<aside class="app-side" id="app-side">
    <!-- BEGIN .side-content -->
    <div class="side-content ">
        <!-- Current login user start -->
        <div class="login-user">
            <div class="profile-thumb">
                @if(isset(Auth::user()->image))
                <img src="{{ USER_IMAGE_URL.Auth::user()->image}}">
                <!-- <span class="status online"></span> -->
                @else
                <img src="{{ asset('uploads/users/user.jpg') }}" />
                @endif
            </div>
            <h6 class="profile-name">{{ Auth::user()->firstname }}</h6>
        </div>
        <!-- Current login user end -->
        <!-- Nav scroll start -->
        <div class="sidebarNoQuicklinks">
            <!-- BEGIN .side-nav -->
            <nav class="side-nav">
                <!-- BEGIN: side-nav-content -->
                <ul class="unifyMenu" id="unifyMenu">
                    <li class="{{ Request::is('dashboard')?'selected':'' }}">
                        <a href="{{ url('dashboard') }}">
                            <span class="has-icon">
                                <i class="icon-home"></i>
                            </span>
                            <span class="nav-title">{!! trans('user/sidebar.dashboard') !!}</span>
                        </a>
                    </li>
                </ul>
                <!-- END: side-nav-content -->
            </nav>
            <!-- END: .side-nav -->
        </div>
        <!-- Nav scroll end -->
    </div>
    <!-- END: .side-content -->
</aside>