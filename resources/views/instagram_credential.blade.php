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
                    <h3>{!! trans('user/instagram.instagram') !!}</h3>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END: .main-heading -->
<script type="text/javascript">

/* Not Allow to Put Blank Space in TextBox  */
function AvoidSpace(event) {
    var k = event ? event.which : window.event.keyCode;
    if (k == 32) return false;
}

/* Remove Space Automatically From Textbox String  */
function removeSpaces(string) {
 return string.split(' ').join('');
}

</script>


<div class="main-content">

        <form id="instagram_create_form" action="{{ url('dashboard/connect_to_instagram')}}" method="post" enctype="multipart/form-data">

             @include('layouts.include.notifications')
            {{ csrf_field() }}
            <div class="card">
                <div class="card-body">
                    <div class="row gutters">
                   
   
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="instagramaccesstoken" name="accesstoken" placeholder="CLIENT ID*" value="" onkeypress="return AvoidSpace(event);" onblur="this.value=removeSpaces(this.value);"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="instagramaccesstokensecret" name="accesstokensecret" placeholder="CLIENT SECRET ID*" value=""  onkeypress="return AvoidSpace(event);" onblur="this.value=removeSpaces(this.value);" />
                            </div>
                        </div>


                    </div>

                    <div class="actions clearfix">
                        <button type="submit" style="margin-top: 15px;
" class="btn btn-primary"><span class="icon-save2"></span>Create / Save </button>


<button type="submit" style="margin-top: 15px;
" class="btn btn-primary"><span class="icon-"></span> <a style="color: #ffffff;" href="{{ url('dashboard') }}"> Back </a> </button>

                    </div>





                </div>
            </div>
        </form>



    </div>
    <!-- END: .main-content -->
@endsection
		