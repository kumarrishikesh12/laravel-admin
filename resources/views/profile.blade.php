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
                    <h3>{!! trans('user/profile.profile') !!}</h3>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END: .main-heading -->
<div class="main-content">
        <form id="SignUp" action="{{ url('profile/update')}}" method="post" enctype="multipart/form-data">

             @include('layouts.include.notifications')
            {{ csrf_field() }}
            <div class="card">
                <div class="card-body">
                    <div class="row gutters">
                   
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <!-- Gallery start -->
                                        <div class="baguetteBoxThree gallery">
                                            <!-- Row start -->
                                            <div class="row gutters">
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
                                                                 <?php
                                                                    if($profile['image']!=''){
                                                                    ?>
                                                            
                                                                <a style="display: inline-block;" href="{{ USER_IMAGE_URL.$profile['image'] }}" class="effects">
                                                                <img src="{{ USER_IMAGE_URL.$profile['image'] }}" class="img-responsive">
                                                                <div class="overlay">
                                                                    <span class="expand">+</span>
                                                                </div>
                                                            </a> 
                                                             <?php
                                                            }
                                                            else{
                                                                ?>
                                                            <a style="display: inline-block;" href="{{ url('uploads/users/user.jpg') }}" class="effects">
                                                            <img src="{{ url('uploads/users/user.jpg') }}"class="img-responsive"> 
                                                            <div class="overlay">
                                                                    <span class="expand">+</span>
                                                            </div>
                                                            </a>  
                                                             
                                                             <?php
                                                         }
                                                         ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name *" value="<?php echo isset($profile['firstname'])?$profile['firstname']:''; ?>" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name *" value="<?php echo isset($profile['lastname'])?$profile['lastname']:''; ?>" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username *" value="<?php echo isset($profile['username'])?$profile['username']:''; ?>" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email Address *" value="<?php echo isset($profile['email'])?$profile['email']:''; ?>" readonly="true" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image" />
                                <label class="custom-file-label custom-file-label-primary" for="image">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="actions clearfix">
                        <button type="submit" style="margin-top: 15px;
" class="btn btn-primary"><span class="icon-save2"></span>Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- END: .main-content -->
@endsection
		