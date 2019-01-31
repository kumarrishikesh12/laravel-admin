<aside class="app-side" id="app-side">
    <!-- BEGIN .side-content -->
    <div class="side-content ">
        <!-- Current login user start -->
        <div class="login-user">
            <div class="profile-thumb">
                <img src="{{ asset('assets/admin/images/user.jpg') }}" />
                <!-- <span class="status online"></span> -->
            </div>
            <h6 class="profile-name">{{ Auth::guard('admin')->user()->name }}</h6>
        </div>
        <!-- Current login user end -->
        <!-- Nav scroll start -->
        <div class="sidebarNoQuicklinks">
            <!-- BEGIN .side-nav -->
            <nav class="side-nav">
                <!-- BEGIN: side-nav-content -->
                <ul class="unifyMenu" id="unifyMenu">
                    <li class="{{ Request::is('admin/dashboard')?'selected':'' }}">
                        <a href="{{ url('admin/dashboard') }}">
                            <span class="has-icon">
                                <i class="icon-home"></i>
                            </span>
                            <span class="nav-title">{!! trans('admin/sidebar.dashboard') !!}</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('admin/marketplaces*')?'selected':'' }}">
                        <a href="{{ url('admin/marketplaces') }}">
                            <span class="has-icon">
                                <i class="icon-layers"></i>
                            </span>
                            <span class="nav-title">{!! trans('admin/sidebar.marketplaces') !!}</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('admin/attributes*')?'selected':'' }}">
                        <a href="{{ url('admin/attributes') }}">
                            <span class="has-icon">
                                <i class="icon-layers"></i>
                            </span>
                            <span class="nav-title">{!! trans('admin/sidebar.attributes') !!}</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('admin/productattributes*')?'selected':'' }}">
                        <a href="{{ url('admin/productattributes') }}">
                            <span class="has-icon">
                                <i class="icon-layers"></i>
                            </span>
                            <span class="nav-title">Product Attributes</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('admin/categories*')?'selected':'' }}">
                        <a href="{{ url('admin/categories') }}">
                            <span class="has-icon">
                                <i class="icon-layers"></i>
                            </span>
                            <span class="nav-title">{!! trans('admin/sidebar.categories') !!}</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('admin/products*')?'selected':'' }}">
                        <a href="{{ url('admin/products') }}">
                            <span class="has-icon">
                                <i class="icon-layers"></i>
                            </span>
                            <span class="nav-title">{!! trans('admin/sidebar.products') !!}</span>
                        </a>
                    </li>
       <!--              <li class="{{ Request::is('admin/reports*')?'selected':'' }}">
                        <a href="#">
                            <span class="has-icon">
                                <i class="icon-layers"></i>
                            </span>
                            <span class="nav-title">{!! trans('admin/sidebar.reports') !!}</span>
                        </a>
                    </li> -->
                    <li class="{{ Request::is('admin/users')?'selected':'' }}">
                        <a href="{{ url('admin/users') }}">
                            <span class="has-icon">
                                <i class="icon-users"></i>
                            </span>
                            <span class="nav-title">{!! trans('admin/sidebar.users') !!}</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('admin/admins')?'selected':'' }}">
                        <a href="{{ url('admin/sub_admin') }}">
                            <span class="has-icon">
                                <i class="icon-users"></i>
                            </span>
                            <span class="nav-title">{!! trans('admin/sidebar.admin') !!}</span>
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