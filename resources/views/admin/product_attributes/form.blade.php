@extends('admin.layouts.main')
@section('title')
    {!! trans('admin/product_attributes.product_attributes') !!}
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
                    <h3>{!! trans('admin/product_attributes.product_attributes') !!}</h3>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                <div class="daterange-container">
                    <a data-toggle="tooltip" title="{{ trans('admin/common.view') }}" class="btn btn-primary btn-sm btn-view" href="{{ url('admin/productattributes') }}"><i class="icon-eye"></i> {{ trans('admin/common.view') }}</a>
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
            @if(isset($product_attribute))
                {!! Form::model($product_attribute, ['route' => array('productattributes.update', $product_attribute->id), 'method' => 'PATCH', 'id' => 'form', 'novalidate' => 'novalidate', 'files'=>true]) !!}
            @else
                {!! Form::open(['route' => 'productattributes.store', 'id' => 'form', 'novalidate' => 'novalidate', 'files'=>true]) !!}
            @endif

            <div class="card">
                <div class="card-body">
                    @if(isset($product_attribute) && $product_attribute->image!='')
                        <div class="table-responsive modal-body gutters">
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="baguetteBoxThree gallery">
                                        <div class="row gutters">
                                            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-6">
                                                <a href="{{ $product_attribute->image }}" data-toggle="tooltip" title="{{ trans('admin/categories.image') }}" class="effects">
                                                    <img src="{{ $product_attribute->image }}" class="img-thumbnail" style="width: 200px;" />
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
                                {!! Form::label('attribute_id',trans('admin/product_attributes.marketplace').config('common.required_sign'),[],false) !!}
                                {!! Form::select('marketplace_id', $marketplaces, old('marketplace_id'),['class'=>'form-control selectpicker','data-live-search'=>'true']); !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('attribute_id',trans('admin/product_attributes.attribute').config('common.required_sign'),[],false) !!}
                                {!! Form::select('attribute_id', $attributes, old('attribute_id'),['class'=>'form-control selectpicker','data-live-search'=>'true']); !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('name',trans('admin/product_attributes.name').config('common.required_sign'),[],false) !!}
                                {!! Form::text('name',old('name'), array('class'=>'form-control','id' => 'name', 'max'=>191)) !!}
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