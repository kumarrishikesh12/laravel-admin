@extends('layouts.main')
@section('title')
    {!! trans('user/dashboard.dashboard') !!}
@stop
@section('content')
<!-- BEGIN .main-heading -->
<header class="main-heading">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="page-icon">
                    <i class="icon-home"></i>
                </div>
                <div class="page-title">
                    <h3>{!! trans('user/dashboard.dashboard') !!}</h3>
                   
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">

    <div class="card">
     <div class="card-body">
  

     <button type="button" class="btn btn-info"> 
        <a href="dashboard/connect_to_twitter">  Twitter Credential </a>
    </button>
    
     <button type="button" class="btn btn-primary">
     <a href="dashboard/connect_to_instagram"> Instagram Credential </a>
     </button>

     <button type="button" class="btn btn-primary">
      <a href="dashboard/connect_to_facebook"> Facebook Credential </a>
     </button>



    </div>
   </div>
</form>
</div>
<!-- END: .main-content -->
@endsection
