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
                                <i class="fa fa-home"></i>
                            </span>
                            <span class="nav-title">{!! trans('user/sidebar.dashboard') !!}</span>
                        </a>
                    </li>


                    <li class="{{ Request::is('twitter_feeds')?'selected':'' }}">
                        <a href="{{ url('twitter_feeds') }}">
                            <span class="has-icon">
                                <i class="fa fa-twitter"></i>
                            </span>
                            <span class="nav-title">{!! trans('user/sidebar.twitter') !!}</span>
                        </a>
                    </li>


                    <li class="{{ Request::is('facebook_feeds')?'selected':'' }}">
                        <a href="{{ url('facebook_feeds') }}">
                            <span class="has-icon">
                                <i class="fa fa-facebook"></i>
                            </span>
                            <span class="nav-title">{!! trans('user/sidebar.facebook') !!}</span>
                        </a>
                    </li>


                   <li class="{{ Request::is('instagram_feeds')?'selected':'' }}">
                        <a href="{{ url('instagram_feeds') }}">
                            <span class="has-icon">
                                <i class="fa fa-instagram"></i>
                            </span>
                            <span class="nav-title">{!! trans('user/sidebar.instagram') !!}</span>
                        </a>
                    </li>


                   <li class="{{ Request::is('all_feeds')?'selected':'' }}">
                        <a href="{{ url('all_feeds') }}">
                            <span class="has-icon">
                                <i class="fa fa-hashtag"></i>
                            </span>
                            <span class="nav-title">{!! trans('user/sidebar.all_feeds') !!}</span>
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