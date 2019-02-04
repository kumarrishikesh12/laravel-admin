@extends('layouts.main')
@section('title')
    {!! trans('user/profile.profile') !!}
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
                    <h3>{!! trans('user/facebook.Update') !!}</h3>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END: .main-heading -->

@foreach ($user_exist as $user)

<div class="main-content">
        <form id="SignUp" action="{{ url('facebook/update')}}" method="post" enctype="multipart/form-data">

             @include('layouts.include.notifications')
            {{ csrf_field() }}
            <div class="card">
                <div class="card-body">
                    <div class="row gutters">
                        

                        <input type="hidden" class="form-control" id="uid" name="uid" value="{{ $user->id }}" />

                         <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ $user->user_id }}" />
                         
   
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="facebookaccesstoken" name="accesstoken" placeholder="Access Token*" value="{{ $user->accesstoken }}" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="facebookaccesstokensecret" name="accesstokensecret" placeholder="Access Token Secret*" value="{{ $user->accesstokensecret }}" />
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="facebookconsumerkeyapikey" name="consumerkeyapikey" placeholder="ConsumerKey API Key*" value="{{ $user->consumerkeyapikey }}" />
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="facebookconsumersecretapi" name="consumersecretapikey" placeholder="ConsumerSecret APISecret Key*" value="{{ $user->consumersecretapikey }}" />
                            </div>
                        </div>

                    </div>
                    <div class="actions clearfix">
                        <button type="submit" style="margin-top: 15px;
" class="btn btn-primary"><span class="icon-save2"></span>Update</button>
                   

                    <button type="submit" style="margin-top: 15px;
" class="btn btn-primary"><span class="icon-"></span> <a style="color: #ffffff;" href="{{ url('dashboard') }}"> Back </a> </button>
					
					</div>
                </div>
            </div>
        </form>
    </div>

 @endforeach

    <!-- END: .main-content -->
@endsection
		