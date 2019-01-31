@extends('layouts.main')
@section('title')
    {!! trans('user/changePassword.changePassword') !!}
@stop
@section('content')
<!-- BEGIN .main-heading -->
<header class="main-heading">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="page-icon">
                    <i class="icon-cog"></i>
                </div>
                <div class="page-title">
                    <h3>{!! trans('user/changePassword.changePassword') !!}</h3>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">
    @include('layouts.include.notifications')
    {!! Form::open(['route' => 'user.password.change', 'id' => 'change-password-form', 'novalidate' => 'novalidate']) !!}
        <!-- Default card -->
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    {!! Form::label('password',trans('user/changePassword.currentPassword').config('common.required_sign'),[],false) !!}
                    {!! Form::password('current_password', array('class'=>'form-control','id' => 'current_password')) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('password',trans('user/changePassword.password').config('common.required_sign'),[],false) !!}
                    {!! Form::password('password', array('class'=>'form-control','id' => 'password')) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('cpassword',trans('user/changePassword.confirmPassword').config('common.required_sign'),[],false) !!}
                    {!! Form::password('password_confirmation', array('class'=>'form-control','id' => 'password_confirmation')) !!}
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                {{ Form::button('<span class="icon-floppy-disk"></span> Save',array('type'=>'submit','class'=>'btn btn-primary btn-sm', 'id'=>'submitform')) }}
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.box -->
    {!! Form::close() !!}
</div>
<!-- END: .main-content -->
@endsection
