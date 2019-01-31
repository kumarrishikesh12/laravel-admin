@extends('admin.layouts.main')
@section('title')
    {!! trans('admin/admin.admins') !!}
@stop
@section('content')
<!-- BEGIN .main-heading -->
<header class="main-heading">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="page-icon">
                    <i class="icon-layers"></i>
                </div>
                <div class="page-title">
                    <h3>{!! trans('admin/admin.admins') !!}</h3>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                <div class="daterange-container">
                    <a data-toggle="tooltip" title="{{ trans('admin/common.view') }}" class="btn btn-primary btn-sm btn-view" href="{{ url('admin/sub_admin') }}"><i class="icon-eye"></i> {{ trans('admin/common.view') }}</a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">
    @include('admin.layouts.include.notifications')
    <!-- Row start -->
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            @if(isset($admin))
                {!! Form::model($admin, ['route' => array('sub_admin.update', $admin->id), 'method' => 'PATCH', 'id' => 'form', 'novalidate' => 'novalidate', 'files'=>true]) !!}
            @else
                {!! Form::open(['route' => 'sub_admin.store', 'id' => 'form', 'novalidate' => 'novalidate', 'files'=>true]) !!}
            @endif

            <div class="card">
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('firstname',trans('admin/admin.firstname').config('common.required_sign'),[],false) !!}
                                {!! Form::text('firstname',old('firstname'), array('class'=>'form-control','id' => 'firstname', 'max'=>191)) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('lastname',trans('admin/admin.lastname').config('common.required_sign'),[],false) !!}
                                {!! Form::text('lastname',old('lastname'), array('class'=>'form-control','id' => 'lastname', 'max'=>191)) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('username',trans('admin/users.username').config('common.required_sign'),[],false) !!}
                                {!! Form::text('username',old('username'), array('class'=>'form-control','id' => 'username', 'max'=>191)) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('email',trans('admin/users.email').config('common.required_sign'),[],false) !!}
                                {!! Form::text('email',old('email'), array('class'=>'form-control','id' => 'email', 'max'=>191)) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('password',trans('admin/users.password').config('common.required_sign'),[],false) !!}
                                {!! Form::password('password',array('class'=>'form-control','id' => 'password')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('password_confirmation',trans('admin/users.confirm_password').config('common.required_sign'),[],false) !!}
                                {!! Form::password('password_confirmation',array('class'=>'form-control','id' => 'password_confirmation')) !!}
                            </div>
                        </div>
                    </div>

                    {!! Form::button('<i class="icon-save2"></i> '.trans('admin/common.save'),array('type'=>'submit','class'=>'btn btn-primary btn-sm btn-save', 'id'=>'submitform')) !!}
                </div>
            </div>
            

            {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- END: .main-content -->
@endsection