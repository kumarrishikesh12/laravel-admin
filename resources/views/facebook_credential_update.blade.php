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
                        

                        <input type="hidden" class="form-control" id="uid" name="uid" value="{{ $user->id }}" required="required" />

                         <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ $user->user_id }}" required="required" />
                         
   
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="facebookappid" name="facebook_appid" placeholder="App ID*" value="{{ $user->app_id }}" required="required" oninvalid="this.setCustomValidity('Please Enter Valid Facebook AppID');" oninput="setCustomValidity('')" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="facebookappsecret" name="facebook_appsecret" placeholder="App Secret ID*" value="{{ $user->appsecret }}" required="required" oninvalid="this.setCustomValidity('Please Enter Valid Facebook AppSecretKey');" oninput="setCustomValidity('')" />
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="facebookhashtags" name="facebook_hashtags" placeholder="Hashtag Keyword*" value="{{ $user->hashtags }}"  required="required" oninvalid="this.setCustomValidity('Please Enter Valid Facebook Hashtag Keyword');" oninput="setCustomValidity('')" />
                            </div>
                        </div>

                         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="facebookusername" name="facebook_username" placeholder="Facebook Username* ex: zuck " value="{{ $user->username }}" oninvalid="this.setCustomValidity('Please Enter Valid Facebook Username');" oninput="setCustomValidity('')" required="required" />
                            </div>
                        </div>



    <?php 


     // Redirect URl //Localhost
     $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; 

     $client_id  =  $user->app_id;
     $client_secret_id  = $user->appsecret;

     
    //$authToken = file_get_contents("https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id={$app_id}&client_secret={$app_secret}");

    //$access_token_gen = 'https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id='.$client_id.'&client_secret='.$client_secret_id;


      $default_access_token = 'https://www.facebook.com/v3.2/dialog/oauth?response_type=token&display=popup&client_id='.$client_id.'&redirect_uri='.$link;



     ?> 





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
		