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
                    <h3>{!! trans('user/instagram.Update') !!}</h3>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END: .main-heading -->

@foreach ($user_exist as $user)

<div class="main-content">
        <form id="instagram_forms" action="{{ url('instagram/update')}}" method="post" enctype="multipart/form-data">

             @include('layouts.include.notifications')
            {{ csrf_field() }}
            <div class="card">
                <div class="card-body">
                    <div class="row gutters">
                        

                        <input type="hidden" class="form-control" id="uid" name="uid" value="{{ $user->id }}" />

                         <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ $user->user_id }}" />
                         
   
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="instagramaccesstoken" name="accesstoken" placeholder="CLIENT ID*" value="{{ $user->accesstoken }}" required="required" oninvalid="this.setCustomValidity('Please Enter Valid Instagram AccessToken');" oninput="setCustomValidity('')" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="instagramaccesstokensecret" name="accesstokensecret" placeholder="CLIENT SECRET ID*" value="{{ $user->accesstokensecret }}" required="required" oninvalid="this.setCustomValidity('Please Enter Valid Instagram AccessTokenSecret');" oninput="setCustomValidity('')" />
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="instagramhashtags" name="instagram_hashtags" placeholder="Hashtag Keyword*" value="{{ $user->hashtags }}" required="required" oninvalid="this.setCustomValidity('Please Enter Valid Instagram Hashtag Keyword');" oninput="setCustomValidity('')" />
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
		