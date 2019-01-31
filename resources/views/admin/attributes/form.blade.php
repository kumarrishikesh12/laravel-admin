@extends('admin.layouts.main')
@section('title')
    {!! trans('admin/attributes.attributes') !!}
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
                    <h3>{!! trans('admin/attributes.attributes') !!}</h3>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                <div class="daterange-container">
                    <a data-toggle="tooltip" title="{{ trans('admin/common.view') }}" class="btn btn-primary btn-sm btn-view" href="{{ url('admin/attributes') }}"><i class="icon-eye"></i> {{ trans('admin/common.view') }}</a>
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
            @if(isset($attribute))  
                {!! Form::model($attribute, ['route' => array('attributes.update', $attribute->id), 'method' => 'PATCH', 'id' => 'form', 'novalidate' => 'novalidate', 'files'=>true]) !!}
            @else
                {!! Form::open(['route' => 'attributes.store', 'id' => 'form', 'novalidate' => 'novalidate', 'files'=>true]) !!}
            @endif

            <div class="card">
                <div class="card-body">
          
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('name',trans('admin/attributes.name').config('common.required_sign'),[],false) !!}
                                {!! Form::text('name',old('name'), array('class'=>'form-control','id' => 'name', 'max'=>191)) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('type',trans('admin/attributes.type').config('common.required_sign'),[],false) !!}
                                <select name="attributetype" id="attributetype" class="form-control selectpicker" data-live-search="true" value="{{old('attributetype')}}">
                                    <option value="">{!! trans('admin/attributes.pick_category') !!}</option>
                                    @if(isset($attributes))
                                    @foreach($attributes as $values)
                                     <option  @if($values == $type) {{"selected"}}  @endif value="{{ $values }}">{{ $values }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group values" style="@if(isset($attribute) && ($attribute->attributetype == 'Radio' || $attribute->attributetype == 'Checkbox')) {{"display:block"}} @endif {{"display:none"}} ">
                                {!! Form::label('type','Enter comma(,) separated string',[],false) !!}
                                <input type="text" name="attributevalue" id="attributevalue" class="form-control" value="{{isset($attribute)?$attribute->attributevalue:old('attribute')}}" placeholder="{!!trans('admin/attributes.value')!!}">
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
@section('scripts')
<script>
$(document).ready(function() {
$("#attributetype").on('change', function() {
    var value = $(this).val();
    /*var id = element.attr("formvalue");
    var div = element.find("." + id);*/
  if(value == "Radio" || value == "Checkbox"){
    $('.values').show();
  }
  else
  {
   $('.values').hide();
  }
 });
 // div.hide();      

});
</script>
@endsection