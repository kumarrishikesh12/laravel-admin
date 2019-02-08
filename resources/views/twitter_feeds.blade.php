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



<?php 

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSLVERSION, 3);

?>

<div class="main-content">

<?php

if(isset($tweets) && !empty($tweets && !empty($tweets_next_page['search_metadata']['next_results']))) { 
?>
 
  <ul class="pagination">
    <li class="page-item float-left" id="previous_data"><a class="page-link" href=<?php echo $tweets['search_metadata']['refresh_url']; ?> name="previous">Previous</a></li>
    
    <li class="page-item float-right" id="next_data"><a class="page-link" href=<?php echo $tweets_next_page['search_metadata']['next_results']; ?> name="next"> Next</a></li>
  </ul>


<?php

  /*For Search_metadata --> next_results_set  Pagination */
   
    // $next_results = $tweets['search_metadata']['next_results'];
   // $max_id = $tweets['search_metadata']['max_id'];
   //die();



 foreach( $tweets['statuses'] as $key => $value ) {

?>
        
  
   <div class="card">
      <div class="card-body">

        <p><b> Tweet Post: </b> 
         <?php 
               $tweet = $tweets['statuses'][$key]['text'] = htmlspecialchars_decode($value['text']);
              if(!empty($tweet)){
                echo $tweet;
              }else{  

                echo "  ";  

                }

          ?> 
         </p> 
              

         <img src=<?php

             $profile_image_url = $tweets['statuses'][$key] = $value['user']['profile_image_url']; 

             $profie_pic = str_replace("_normal", "_400x400", $profile_image_url);

             if (!empty($profie_pic)) {
               echo $profie_pic;
             }else{
              echo public_path("/profile_pics/user_twitter.jpg");
             }
          ?> alt="profie_pic" style="width:100%">
         

         <div class="container" style="margin-top:10px">
          
          <h6><b> Username:
            <?php

            $username = $tweets['statuses'][$key] = $value['user']['screen_name']; 
            if (!empty($username)) {
              echo $username;
            }else{
              echo "  ";
            }


           ?>
          </b></h6> 


          <p><b> Name: </b> <?php

           $name = $tweets['statuses'][$key] = $value['user']['name'];  
           if (!empty($name)) {
            echo '<span style="font-size: 16px;font-weight: bold;margin-left: 12px;">   '.$name.'</span>';
           }else {
              echo $username;
           }

           ?> </p>
          

          <p> <b> Description: </b> 
            <?php 

            $description = $tweets['statuses'][$key] = $value['user']['description']; 
            if (!empty($description)) {
              echo $description;
            }else{
              echo "  ";
            }


            ?> </p>



          <p><b> Location: </b> 
           <?php 

           $location = $tweets['statuses'][$key] = $value['user']['location'];  
            if(!empty($location)){
              echo '<span style="font-size: 16px;font-weight: bold;margin-left: 12px;">   '.$location.'</span>';
            }else{

               echo $location = " ";
            }

            ?>
           </p>



          <p><b> Followers: </b> 
           <?php 

           $followers = $tweets['statuses'][$key] = $value['user']['followers_count'];  
            if(!empty($followers)){
             echo '<span style="font-size: 16px;font-weight: bold;margin-left: 12px;">   '.$followers.'</span>';

            }else{

               echo $followers = "  ";
            }

            ?>
           </p>



           <p><b> Following: </b> 
           <?php 

           $following = $tweets['statuses'][$key] = $value['user']['friends_count'];  
            if(!empty($following)){
              echo '<span style="font-size: 16px;font-weight: bold;margin-left: 12px;">   '.$following.'</span>';

            }else{

               echo $following = "  ";
            }

            ?>
           </p>



           <p><b> Tweets: </b> 
           <?php 

           $tweets_count = $tweets['statuses'][$key] = $value['user']['statuses_count'];  
            if(!empty($tweets_count)){
              echo '<span style="font-size: 16px;font-weight: bold;margin-left: 12px;">   '.$tweets_count.'</span>';
            }else{

               echo $tweets_count = "  ";
            }

            ?>
           </p>


            <p><b> Joined Date: </b> 
           <?php 

           $join_date = $tweets['statuses'][$key] = $value['user']['created_at'];  
            if(!empty($join_date)){

                 $dateandtime = new DateTime($join_date);
                 $variable1 = $dateandtime->format("h:i:A");  
                 $variable2 = $dateandtime->format("d");         
                 $variable3 = $dateandtime->format("d M Y");


          echo '<span data-toggle="tooltip" data-placement="top" title='.$variable1.' style="font-size: 16px;font-weight: bold;margin-left: 12px;">   '.$variable3.'</span>';
            }else{

               echo $join_date = "  ";
            }

            ?>
           </p>

           


         </div>
     </div>
   </div>  







<?php       

 }

}

?>











<!--  

                $tweet =  $tweets['statuses'][$key]['text'] = htmlspecialchars_decode($value['text']);
                $id =  $tweets['statuses'][$key] = $value['user']['id'];
                $name =  $tweets['statuses'][$key] = $value['user']['name'];    
                $screen_name =  $tweets['statuses'][$key] = $value['user']['screen_name'];
                $location =  $tweets['statuses'][$key] = $value['user']['location'];
                $description =  $tweets['statuses'][$key] = $value['user']['description'];
                $followers  =  $tweets['statuses'][$key] = $value['user']['followers_count'];
                $following =  $tweets['statuses'][$key] = $value['user']['friends_count'];
                $tweets_count =  $tweets['statuses'][$key] = $value['user']['statuses_count'];
                $profile_image_url =  $tweets['statuses'][$key] = $value['user']['profile_image_url'];
                $created_at =   $tweets['statuses'][$key] = $value['user']['created_at'];
                     


-->

</div>

<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>

<!-- END: .main-content -->
@endsection
