@extends('admin.layouts.main')
@section('title')
    {!! trans('admin/dashboard.dashboard') !!}
@stop
@section('content')
<!-- BEGIN .main-heading -->
<header class="main-heading">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="page-icon">
                    <i class="icon-home"></i>
                </div>
                <div class="page-title">
                    <h3>{!! trans('admin/dashboard.dashboard') !!}</h3>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">
            <div class="row gutters">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <a href="{{ url('admin/sub_admin') }}">
                            <div class="plain-widget" data-toggle="tooltip" title="Admin Users">
                                <div class="growth bg-info"><i class="icon-users"></i></div>
                                <h3>{{$admin}}</h3>
                                <p>{!! trans('admin/dashboard.admin') !!}</p>
                                <div class="progress sm no-shadow">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 100%;" aria-valuenow="37" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <a href="{{ url('admin/users') }}">
                            <div class="plain-widget" data-toggle="tooltip" title="Users">
                                <div class="growth bg-info"><i class="icon-users"></i></div>
                                <h3>{{$users}}</h3>
                                <p>{!! trans('admin/dashboard.users') !!}</p>
                                <div class="progress sm no-shadow">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 100%;" aria-valuenow="37" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <a href="{{ url('admin/categories') }}">
                            <div class="plain-widget" data-toggle="tooltip" title="Categories">
                                <div class="growth bg-orange"><i class="icon-layers"></i></div>
                                <h3>{{$categories}}</h3>
                                <p>{!! trans('admin/dashboard.categories') !!}</p>
                                <div class="progress sm no-shadow">
                                    <div class="progress-bar bg-orange" role="progressbar" style="width: 100%;" aria-valuenow="37" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <a href="{{ url('admin/products') }}">
                            <div class="plain-widget" data-toggle="tooltip" title="Products">
                                <div class="growth bg-orange"><i class="icon-layers"></i></div>
                                <h3>{{$products}}</h3>
                                <p>{!! trans('admin/dashboard.products') !!}</p>
                                <div class="progress sm no-shadow">
                                    <div class="progress-bar bg-orange" role="progressbar" style="width: 100%;" aria-valuenow="37" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                   
                </div>
</div>
<!-- END: .main-content -->
@endsection
