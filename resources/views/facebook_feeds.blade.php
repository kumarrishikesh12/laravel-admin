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
                    <h3>{!! trans('user/dashboard.facebook') !!}</h3>
                   
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

<?php 

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSLVERSION, 3);

?>


@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif




<div class="main-content">

<?php

if(isset($fb_user_data) && !empty($fb_user_data)){ //main if
//if data exist in fb_user_data, print

 foreach( $fb_user_data['picture'] as $value ) {

?>

    <div class="card">
     <div class="card-body">
    
      <?php echo "<img src='$value' alt='profie_pic' style='width:100%' height='100%'>"; 

   }
 
  ?>

           
            
           <p> <?php echo '</br>'; ?> </p> 
           <p><b> ID: </b> <?php echo $fb_user_data['id']; ?> </p> 
           <p><b> Full Name: </b> <?php echo $fb_user_data['name']; ?> </p> 
           <p><b> Short Name: </b> <?php echo $fb_user_data['short_name']; ?> </p> 
           <p><b> First Name: </b> <?php echo $fb_user_data['first_name']; ?> </p> 
           <p><b> Last Name: </b> <?php echo $fb_user_data['last_name']; ?> </p> 
           <p><b> Gender: </b> <?php echo $fb_user_data['gender']; ?> </p> 
           <p><b> email: </b> <?php echo $fb_user_data['email']; ?> </p> 
           <p><b> Birthdate: </b> <?php echo $fb_user_data['birthday']; ?> </p> 
           <p><b> Age: </b> <?php echo $fb_user_data['age_range']['min']; ?> </p> 
           <p><b> Location: </b> <?php echo $fb_user_data['location']['name']; ?> </p>
           <p><b> ProfileLink : </b> <a href="<?php echo $fb_user_data['link']; ?>" name="profile_link"> View </a> </p> 
           

    </div>
   </div>



 <?php foreach( $fb_user_data['posts'] as $picture){ 


    if(isset($picture['full_picture']) && isset($picture['type']) && isset($picture['description']) ){ ?>

     
    <div class="card">
     <div class="card-body">

    <p><b> Status: </b> <?php echo $picture['description'].' '.'<a href='.$picture["link"].'> View More </a> ' ?> </p><p><b>Page Name: </b> <?php echo $picture['name']; ?> </p> 



    <p>
     <?php 
        
     if( $picture['type'] == 'photo' || $picture['type'] == 'event') {
        //if(!empty($type) && $picture['type'] === 'photo' ){

               echo '<img src="'.$picture['full_picture'].'" alt="profie_pic" style="width:100%" >'; 


        }else{
            //for video and link
            echo $full_picture = $picture['type'];
      
        }


     ?>
     </p>
     </div>
     </div>

<?php
   }
  }
?>







<?php
} //if end
?>

<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>


</div>
<!-- END: .main-content -->
@endsection
