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
                    <h3>{!! trans('user/twitter.Update') !!}</h3>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END: .main-heading -->
<script type="text/javascript">

function AvoidSpace(event) {
    var k = event ? event.which : window.event.keyCode;
    if (k == 32) return false;
}

</script>


@foreach ($user_exist as $user)
  
<div class="main-content">
        <form id="twitter_update_form" action="{{ url('twitter/update')}}" method="post" enctype="multipart/form-data">

             @include('layouts.include.notifications')
             {{ csrf_field() }}

            <div class="card">
                <div class="card-body">
                    <div class="row gutters">
                   
                        <input type="hidden" class="form-control" id="uid" name="uid" value="{{ $user->id }}" />

                         <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ $user->user_id }}" />

   
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="twitteraccesstoken" name="accesstoken" placeholder="Access Token*" value="{{ $user->accesstoken }}" required="required" oninvalid="this.setCustomValidity('Please Enter Valid Twitter AccessToken');" oninput="setCustomValidity('')" onkeypress="return AvoidSpace(event);" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="twitteraccesstokensecret" name="accesstokensecret" placeholder="Access Token Secret*" value="{{ $user->accesstokensecret }}" required="required" oninvalid="this.setCustomValidity('Please Enter Valid Twitter AccessTokenSecret');" oninput="setCustomValidity('')" onkeypress="return AvoidSpace(event);" />
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="twitterconsumerkeyapikey" name="consumerkeyapikey" placeholder="ConsumerKey API Key*" value="{{ $user->consumerkeyapikey }}" required="required" oninvalid="this.setCustomValidity('Please Enter Valid Twitter ConsumerApiKey');" oninput="setCustomValidity('')" onkeypress="return AvoidSpace(event);" />
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="twitterconsumersecretapi" name="consumersecretapikey" placeholder="ConsumerSecret APISecret Key*" value="{{ $user->consumersecretapikey }}" required="required" oninvalid="this.setCustomValidity('Please Enter Valid Twitter ConsumerSecretApi');" oninput="setCustomValidity('')" onkeypress="return AvoidSpace(event);" />
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="twitterhashtags" name="twitter_hashtags" placeholder="Hashtag Keyword*" value="{{ $user->hashtags }}" required="required" oninvalid="this.setCustomValidity('Please Enter Valid Twitter Hashtag');" oninput="setCustomValidity('')" onkeypress="return AvoidSpace(event);" />
                            </div>
                        </div>





                    </div>

                    <div class="actions clearfix">
			

                    <button name="createtwitter" type="submit" style="margin-top: 15px;
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
        