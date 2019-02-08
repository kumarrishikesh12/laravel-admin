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
                    <h3>{!! trans('user/twitter.twitter') !!}</h3>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END: .main-heading -->

  
<div class="main-content">
        <form id="twitter_create_form" action="{{ url('dashboard/connect_to_twitter')}}" method="post" enctype="multipart/form-data">

             @include('layouts.include.notifications')
             {{ csrf_field() }}

            <div class="card">
                <div class="card-body">
                    <div class="row gutters">
                   
                        <input type="hidden" class="form-control" id="userdata" name="userdata" value="" />
   
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="twitteraccesstoken" name="accesstoken" placeholder="Access Token*" value="" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="twitteraccesstokensecret" name="accesstokensecret" placeholder="Access Token Secret*" value="" />
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="twitterconsumerkeyapikey" name="consumerkeyapikey" placeholder="ConsumerKey API Key*" value="" />
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="twitterconsumersecretapi" name="consumersecretapikey" placeholder="ConsumerSecret APISecret Key*" value="" />
                            </div>
                        </div>

                      <!--   <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="twitterhashtags" name="twitterhashtags" placeholder="Twitter Hashtagged Keyword*" value="" />
                            </div>
                        </div> -->

                    </div>

                    <div class="actions clearfix">
			

                    <button name="createtwitter" type="submit" style="margin-top: 15px;
" class="btn btn-primary"><span class="icon-save2"></span>Create </button>
                    
					

                    <button type="submit" style="margin-top: 15px;
" class="btn btn-primary"><span class="icon-"></span> <a style="color: #ffffff;" href="{{ url('dashboard') }}"> Back </a> </button>
                
                    
                </div>
                </div>
            </div>
        </form>
    </div>




    <!-- END: .main-content -->
@endsection
        