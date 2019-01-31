@extends('admin.layouts.main')
@section('title')
    {!! trans('admin/categories.categories') !!}
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
                    <h3>{!! trans('admin/categories.categories') !!}</h3>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                <div class="daterange-container">
                    <a data-toggle="tooltip" title="{{ trans('admin/common.view') }}" class="btn btn-primary btn-sm btn-view" href="{{ url('admin/categories') }}"><i class="icon-eye"></i> {{ trans('admin/common.view') }}</a>
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
            @if(isset($category))
                {!! Form::model($category, ['route' => array('categories.update', $category->id), 'method' => 'PATCH', 'id' => 'form', 'novalidate' => 'novalidate', 'files'=>true]) !!}
            @else
                {!! Form::open(['route' => 'categories.store', 'id' => 'form', 'novalidate' => 'novalidate', 'files'=>true]) !!}
            @endif

            <div class="card">
                <div class="card-body">
                    @if(isset($category) && $category->image!='')
                        <div class="table-responsive modal-body gutters">
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="baguetteBoxThree gallery">
                                        <div class="row gutters">
                                            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-6">
                                                <a href="{{ $category->image }}" data-toggle="tooltip" title="{{ trans('admin/categories.image') }}" class="effects">
                                                    <img src="{{ $category->image }}" class="img-thumbnail" style="width: 200px;" />
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
                                {!! Form::label('category',trans('admin/categories.category').config('common.required_sign'),[],false) !!}
                                <select name="parent_id" id="parent_id" class="form-control selectpicker" data-live-search="true">
                                    <option value="0">{!! trans('admin/categories.pick_category') !!}...</option>
                                    @foreach($categories as $key=>$val)
                                        @php($sel='');
                                        @if(old('parent_id')==$val->id)
                                            @php($sel='selected="selected"')
                                        @elseif(isset($category) && $category->parent_id==$val->id)
                                            @php($sel='selected="selected"')
                                        @endif
                                        <option {{$sel}} data-subtext="{{$val->parent_name}}" value="{{$val->id}}">{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('name',trans('admin/categories.name').config('common.required_sign'),[],false) !!}
                                {!! Form::text('name',old('name'), array('class'=>'form-control','id' => 'name', 'max'=>191)) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            {!! Form::label('image',trans('admin/categories.image'),[],false) !!}
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