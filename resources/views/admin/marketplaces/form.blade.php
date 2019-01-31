@extends('admin.layouts.main')
@section('title')
    {!! trans('admin/marketplaces.marketplaces') !!}
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
                    <h3>{!! trans('admin/marketplaces.marketplaces') !!}</h3>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                <div class="daterange-container">
                    <a data-toggle="tooltip" title="{{ trans('admin/common.view') }}" class="btn btn-primary btn-sm btn-view" href="{{ url('admin/marketplaces') }}"><i class="icon-eye"></i> {{ trans('admin/common.view') }}</a>
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
            @if(isset($marketplace))
                {!! Form::model($marketplace, ['route' => array('marketplaces.update', $marketplace->id), 'method' => 'PATCH', 'id' => 'form', 'novalidate' => 'novalidate', 'files'=>true]) !!}
            @else
                {!! Form::open(['route' => 'marketplaces.store', 'id' => 'form', 'novalidate' => 'novalidate', 'files'=>true]) !!}
            @endif

            <div class="card">
                <div class="card-body">
                    @if(isset($marketplace) && $marketplace->image!='')
                        <div class="table-responsive modal-body gutters">
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="baguetteBoxThree gallery">
                                        <div class="row gutters">
                                            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-6">
                                                <a href="{{ $marketplace->image }}" data-toggle="tooltip" title="{{ trans('admin/marketplaces.image') }}" class="effects">
                                                    <img src="{{ $marketplace->image }}" class="img-thumbnail" style="width: 200px;" />
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
                                {!! Form::label('name',trans('admin/marketplaces.name').config('common.required_sign'),[],false) !!}
                                {!! Form::text('name',old('name'), array('class'=>'form-control','id' => 'name', 'max'=>191)) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            {!! Form::label('categories',trans('admin/marketplaces.categories'),[],false) !!}
                            <div class="input-group mb-3">
                                <input type="text" id="categories" class="form-control" placeholder="Categories" aria-label="Categories" aria-describedby="basic-addon2" />
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2"><span class="icon-search"></span></span>
                                </div>
                            </div>
                            <!-- {!! Form::label('image',trans('admin/marketplaces.image'),[],false) !!}
                            <div class="custom-file">
                                {!! Form::file('image',array('class'=>'form-control custom-file-input','id' => 'image')) !!}
                                {!! Form::label('image',trans('admin/common.choose_file'),['class'=>'custom-file-label custom-file-label-primary'],false) !!}
                            </div> -->
                        </div>
                    </div>
                    <div class="form-group" id="cats">
                        @if(isset($marketplace)) 
                            @foreach($marketplace->mcategories as $key=>$val)
                                <button type="button" id="catbadge{{$key}}" class="badge badge-bdr badge-primary">{{$val}} <span class="badge badge-secondary2" data-id="{{$key}}" onclick="removeCat({{$key}})">&times;</span></button> 
                            @endforeach
                        @endif
                    </div>
                    
                    {!! Form::hidden('categories',old('categories2'), array('type'=>'hidden','class'=>'categories','id' => 'categories')) !!}

                    {!! Form::button('<i class="icon-save2"></i> '.trans('admin/common.save'),array('type'=>'submit','class'=>'btn btn-primary btn-sm btn-save', 'id'=>'submitform')) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- END: .main-content -->
@endsection
@section('styles')
    <style type="text/css">
        #cats button{
            margin-bottom: 4px;
        }
        .easy-autocomplete2{
            width: 90%;
        }
        .easy-autocomplete input{
            box-shadow: none;
        }
    </style>
@endsection
@section('scripts')
    <script type="text/javascript">
        function removeCat(id){
            var values = $('.categories').val().split(',');
            y = jQuery.grep(values, function(value) {
              return value != id;
            });
            y = y.join(',');
            $('.categories').val(y);
            $('#catbadge'+id).remove();
        }
        $(document).ready(function(){
            /*$('#categories').keyup(function(){
                console.log($(this).val());
            });*/
            var options = {
                adjustWidth: false,
              url: function(phrase) {
                return "{{url('admin/marketplaces/searchcategory')}}/"+phrase+"/0,"+$('.categories').val();
              },
              getValue: function(element) {
                return element.name;
              },
              ajaxSettings: {
                dataType: "json",
                method: "GET",
                data: {
                  dataType: "json"
                }
              },
              list: {
                  onChooseEvent: function() {
                    var value = $("#categories").getSelectedItemData().name;
                    var id = $("#categories").getSelectedItemData().id;
                    var button = '<button type="button" id="catbadge'+id+'" class="badge badge-bdr badge-primary">'+value+' <span class="badge badge-secondary2" data-id="'+id+'" onclick="removeCat('+id+')">&times;</span></button> ';
                    $('#cats').append(button);
                    
                    if($('.categories').val()!='0'){
                        $('.categories').val($('.categories').val()+','+id);
                    }
                    else{
                        $('.categories').val(id);
                    }
                    $("#categories").val('');
                  }
              },
              preparePostData: function(data) {
                data.phrase = $("#categories").val();
                return data;
              },
              //requestDelay: 400
            };
            $("#categories").easyAutocomplete(options);
            $('.easy-autocomplete').removeClass('easy-autocomplete').addClass('easy-autocomplete2');
        });
    </script>
@endsection