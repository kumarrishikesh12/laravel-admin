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
                    <h3>{!! trans('user/dashboard.twitter') !!}</h3>
                   
                </div>
            </div>
        </div>
    </div>
</header>

<style>
.card {
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  width: 40%;
  display:inline-block;
  margin-right: 60px;  /* right margin from between*/
  margin-top: 10px;   /* top margin from header*/
  margin-left: 25px; /* left margin from sidebar*/

}

.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

.container {
  padding: 2px 16px;
}
</style>


<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<?php 

// include(app_path()."/TwitterTextFormatter.php");
// use Netgloo\TwitterTextFormatter;

?>

<div class="main-content">

<?php // foreach ($tweest as $user_tweet) {  ?>
    
<!-- #2 -->

<?php // $i = 1;  foreach ($user_tweet as $tweet) {  ?>
    
<?php
       if ($tweet) {
         $index = 1;
         foreach ($tweet as $key => $value) {
             if ($value['user'] && $value['text']) {
                 $ret[] = new Tweet($value['user']['name'], $value['text'], $value['user']['screen_name']);
             }
             $index += 1;
             if ($numberOfTweets !== 0 && $index > $numberOfTweets) {
                 break;
             }
         }
     }
?>


<!-- #30 -->   
<!--
     #  http://jsonviewer.stack.hu/
     #  http://blog.netgloo.com/2015/08/16/php-getting-latest-tweets-and-displaying-them-in-html/
 -->




<!--
    <div class="card">
     <div class="card-body">
              
        <img src="https://www.w3schools.com/howto/img_avatar.png" alt="profie_pic" style="width:100%">
        <div class="container">
          <h5> <?php //echo $i++;  ?> </h5>   

         <h4><b>Twitter Username:  </b></h4> 
         <p> Name: </p>
         <p> Description: </p>
         <p> Location: </p>
         <p> Tweet Post:  </p> 
          
        </div>

    </div>
   </div> 

-->






<?php
      
    //}

   //}
?>


    
<!--  <div class="card">
       <div class="card-body">              
          <img src="https://www.w3schools.com/howto/img_avatar.png" alt="profie_pic" style="width:100%">
        <div class="container">
         <h4><b>Twitter Screen Name</b></h4> 
         <p>Tweet Post</p> 
         <p>Location</p> 
        </div>
       </div>
      </div> 
-->


</form>
</div>
<!-- END: .main-content -->
@endsection
