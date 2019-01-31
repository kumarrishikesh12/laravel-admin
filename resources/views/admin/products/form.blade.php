@extends('admin.layouts.main')
@section('title')
    {!! trans('admin/products.products') !!}
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
                    <h3>{!! trans('admin/products.products') !!}</h3>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                <div class="daterange-container">
                    <a data-toggle="tooltip" title="{{ trans('admin/common.view') }}" class="btn btn-primary btn-sm btn-view" href="{{ url('admin/products') }}"><i class="icon-eye"></i> {{ trans('admin/common.view') }}</a>
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
            @if(isset($product))
                {!! Form::model($product, ['route' => array('products.update', $product->id), 'method' => 'PATCH', 'id' => 'form', 'novalidate' => 'novalidate', 'files'=>true]) !!}
            @else
                {!! Form::open(['route' => 'products.store', 'id' => 'form', 'novalidate' => 'novalidate', 'files'=>true]) !!}
            @endif

            <div class="card">
                <div class="card-body">
                    @if(isset($product) && $product->image!='')
                        <div class="table-responsive modal-body gutters">
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="baguetteBoxThree gallery">
                                        <div class="row gutters">
                                            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-6">
                                                <a href="{{ $product->image }}" data-toggle="tooltip" title="{{ trans('admin/products.image') }}" class="effects">
                                                    <img src="{{ $product->image }}" class="img-thumbnail" style="width: 200px;" />
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
                                {!! Form::label('category',trans('admin/products.category').config('common.required_sign'),[],false) !!}
                                {!! Form::select('category_id', $categories, old('category_id'),['class'=>'form-control selectpicker','data-live-search'=>'true']); !!}
                            </div>
                        </div>
                    </div>
                  
                    <div class="row">
                    @foreach($attributes as $key=>$val)
                    <div class="col-md-6">
                        <div class="form-group">
                            @php($abc=strtolower($val->name))
                            @if(strtolower($val->attributetype) == 'file')
                            {!! Form::label(strtolower($val->name),$val->name.config('common.required_sign'),['style' => 'margin-top: 15px;'],false) !!}
                            <div class="custom-file">
                                <input class="form-control custom-file-input" id="{!!strtolower($val->name)!!}" name="{!!strtolower($val->name)!!}" value="{{$product->$abc}}" type="file">
                                <label for="image" class="custom-file-label custom-file-label-primary">Choose file</label>
                            </div>
                            @elseif(strtolower($val->attributetype) == 'radio')
                            <label for="color" style="margin-top: 15px;">{{$val->name}}</label><br>
                            <?php
                                $valueofattribute = explode(',',$val->attributevalue);
                                ?>
                                @foreach($valueofattribute as $value)
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="{!!strtolower($val->attributetype)!!}" name="{!!strtolower($val->name)!!}" value="{{$value}}" {{ old($abc) == $value ? 'checked' : ''}}  @if(isset($product->$abc)) @if($value == $product->$abc) {{"checked"}}  @endif @endif >
                                <label class="form-check-label" for="defaultCheck0">
                                    {{$value}}
                                </label>
                            </div>
                                @endforeach
                            @elseif(strtolower($val->attributetype) == 'checkbox')
                            <label for="color" style="margin-top: 15px;">{{$val->name}}</label><br>
                                <?php
                                $valueofattribute = explode(',',$val->attributevalue);
                                ?>
                                @foreach($valueofattribute as $value)
                            <div class="form-check form-check-inline">
                                
                              <input class="form-check-input" type="{!!strtolower($val->attributetype)!!}" name="{!!strtolower($val->name)!!}[]" value="{{$value}}" @if(is_array(old($abc)) && in_array($value, old($abc))) checked @endif id="{{$value}}" @if(isset($product->$abc))@foreach($product->$abc as $values)@if($values == $value) {{"checked"}} @endif @endforeach @endif>
                                <label class="form-check-label" for="defaultCheck0">
                                    {{$value}}
                                </label>
                            </div>
                                @endforeach
                            @elseif($val->attributetype == 'textarea')
                            {!! Form::label(strtolower($val->name),$val->name.config('common.required_sign'),['style' => 'margin-top: 15px;'],false) !!}
                            <textarea class="form-control" name="{!!strtolower($val->name)!!}" role="textbox" aria-multiline="true">{{{ Request::old($abc) }}}@if(isset($product)){{$product->$abc}}@endif</textarea>
                            @else
                            {!! Form::label(strtolower($val->name),$val->name.config('common.required_sign'),['style' => 'margin-top: 15px;'],false) !!}
                            
                            <input type="{!!strtolower($val->attributetype)!!}" name="{!!strtolower($val->name)!!}" class='form-control' id ="{!!strtolower($val->name)!!}" value="{{old($abc)}}@if(isset($product)){{$product->$abc}}@endif"style="float:left;">
                            @endif
                        </div>
                    </div>
                    @endforeach
                    </div>
                    <div class="row">
                    {!! Form::button('<i class="icon-save2"></i> '.trans('admin/common.save'),array('type'=>'submit','class'=>'btn btn-primary btn-sm btn-save', 'id'=>'submitform', 'style'=>'margin-top: 15px;margin-left:15px;')) !!}
                   </div>
                </div>
            </div>
             {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- END: .main-content -->
@endsection