@extends('admin.layouts.main')
@section('title')
    {!! trans('admin/sub_categories.sub_categories') !!}
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
                    <h3>{!! trans('admin/sub_categories.sub_categories') !!}</h3>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                <div class="daterange-container">
                    <a data-toggle="tooltip" title="{{ trans('admin/common.view') }}" class="btn btn-primary btn-sm btn-view" href="{{ url('admin/sub_categories') }}"><i class="icon-eye"></i> {{ trans('admin/common.view') }}</a>
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
            @if(isset($sub_category))
                {!! Form::model($sub_category, ['route' => array('sub_categories.update', $sub_category->id), 'method' => 'PATCH', 'id' => 'form', 'novalidate' => 'novalidate', 'files'=>true]) !!}
            @else
                {!! Form::open(['route' => 'sub_categories.store', 'id' => 'form', 'novalidate' => 'novalidate', 'files'=>true]) !!}
            @endif

            <div class="card">
                <div class="card-body">
                    @if(isset($sub_category) && $sub_category->image!='')
                        <div class="table-responsive modal-body gutters">
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="baguetteBoxThree gallery">
                                        <div class="row gutters">
                                            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-6">
                                                <a href="{{ $sub_category->image }}" data-toggle="tooltip" title="{{ trans('admin/sub_categories.image') }}" class="effects">
                                                    <img src="{{ $sub_category->image }}" class="img-thumbnail" style="width: 200px;" />
                                                    <div class="overlay">
                                                        <span class="expand">+</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('category',trans('admin/sub_categories.category').config('common.required_sign'),[],false) !!}
                                {!! Form::select('category_id', $categories, old('category_id'),['class'=>'form-control selectpicker','data-live-search'=>'true']); !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('name',trans('admin/sub_categories.name').config('common.required_sign'),[],false) !!}
                                {!! Form::text('name',old('name'), array('class'=>'form-control','id' => 'name', 'max'=>191)) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            {!! Form::label('image',trans('admin/sub_categories.image'),[],false) !!}
                            <div class="custom-file">
                                {!! Form::file('image',array('class'=>'form-control custom-file-input','id' => 'image')) !!}
                                {!! Form::label('image',trans('admin/common.choose_file'),['class'=>'custom-file-label custom-file-label-primary'],false) !!}
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