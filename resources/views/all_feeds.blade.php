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
                    <h3>{!! trans('user/dashboard.all_feeds') !!}</h3>
                   
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

a{

 color:#ff8507;
 text-decoration: none;
}


</style>

<?php 
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSLVERSION, 3);
?>


<!--  #############################  Start Pagination Show   ###############################  -->
<div class="main-content">

<?php 

if(!empty($next_page['end_cursor'])) { 

//display pagination if data exist and not empty
//$next_page['exist_next_page'];
$limit = 18;  
$next_page['end_cursor']; //end_cursor for next page
$tags_json_link; //link_url: https://www.instagram.com/explore/tags/guardiansofthegalaxy/?__a=1
$next_full_url = $tags_json_link.'&first='.$limit.'&after='.$next_page['end_cursor'];
//Get Full link with end_cursor above.
//echo $next_full_url;
}

if(!empty($next_full_url) && !empty($next_page['end_cursor']) ){ 
   //Start next url empty or exist or not
?>

<ul class="pagination">
  <li class="page-item float-left" id="previous_data"><a class="page-link" href=<?php echo 'all_feeds?__a=1&first='.$limit.'&after='.$next_page['end_cursor']; ?> name="previous">Previous Page </a></li>

    <li class="page-item float-right" id="next_data"><a class="page-link" href=<?php echo 'all_feeds?__a=1&first='.$limit.'&after='.$next_page['end_cursor']; ?> name="next"> Next Page</a></li>
</ul>

<?php

} //End next url empty or exist or not

?>


<!--  #############################  End Pagination Show   ###############################  -->
  





<?php

if(isset($tweets) && !empty($tweets) && !empty($tweets_next_page['search_metadata']['next_results'])) {  

foreach( $tweets['statuses'] as $key => $value){

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
             ?>
      alt="profie_pic" style="width:100%">
         

      <div class="container" style="margin-top:10px">
          
          <h6><b> Username: <?php

            $username = $tweets['statuses'][$key] = $value['user']['screen_name']; 
            if (!empty($username)) {
              echo $username;
            }else{
              echo "  ";
            }
           ?>
          </b>
          </h6> 


          <p><b> Name: </b> <?php

           $name = $tweets['statuses'][$key] = $value['user']['name'];  
           if (!empty($name)) {
            echo '<span style="font-size: 16px;font-weight: bold;margin-left: 12px;">   '.$name.'</span>';
           }else {
              echo $username;
           }

           ?>
          </p>
          


          <p><b> Description: </b> <?php 

            $description = $tweets['statuses'][$key] = $value['user']['description']; 
            if (!empty($description)) {
              echo $description;
            }else{
              echo "  ";
            }
            ?>
          </p>


          <p><b> Location: </b> <?php 

           $location = $tweets['statuses'][$key] = $value['user']['location'];  
            if(!empty($location)){
              echo '<span style="font-size: 16px;font-weight: bold;margin-left: 12px;">   '.$location.'</span>';
            }else{

               echo $location = " ";
            }
            ?>
           </p>



          <p><b> Followers: </b> <?php 

           $followers = $tweets['statuses'][$key] = $value['user']['followers_count'];  
            if(!empty($followers)){
             echo '<span style="font-size: 16px;font-weight: bold;margin-left: 12px;">   '.$followers.'</span>';
            }else{

               echo $followers = "  ";
            }
            ?>
           </p>



          <p><b> Following: </b> <?php 

           $following = $tweets['statuses'][$key] = $value['user']['friends_count'];  
            if(!empty($following)){
              echo '<span style="font-size: 16px;font-weight: bold;margin-left: 12px;">   '.$following.'</span>';
            }else{

               echo $following = "  ";
            }
            ?>
           </p>



          <p><b> Tweets: </b> <?php 

           $tweets_count = $tweets['statuses'][$key] = $value['user']['statuses_count'];  
            if(!empty($tweets_count)){
              echo '<span style="font-size: 16px;font-weight: bold;margin-left: 12px;">   '.$tweets_count.'</span>';
            }else{

               echo $tweets_count = "  ";
            }
            ?>
          </p>


          <p><b> Joined Date: </b> <?php 

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

   } //foreach_end
 }
?>



<!-- ########################## Fetch Instagram Feeds ################################ -->













<?php 

if(isset($insta_array) && !empty($insta_array)){ //if data exist in Instas, display 


      for ($i=$limit; $i >= 0; $i--) {
        
       if(array_key_exists($i,$insta_array["graphql"]["hashtag"]["edge_hashtag_to_media"]["edges"]) ){

       $latest_array = $insta_array["graphql"]["hashtag"]["edge_hashtag_to_media"]["edges"][$i]["node"];
 

      $instas = [
        "image"=> $latest_array['display_url'],
        "thumbnail"=> $latest_array['thumbnail_src'],
        "instagram_id"=> $latest_array['id'],
        "link"=>"https://www.instagram.com/p/".$latest_array['shortcode'],
        "caption"=> $latest_array['edge_media_to_caption']['edges'][0]["node"]["text"],
        "date"=> $latest_array['taken_at_timestamp']
      
      ];

  }

?>

 <div class="card">
      <div class="card-body">

       <p><b> Instagram Post: </b> <?php  

          $caption = $instas['caption']; 
          $view_link = $instas['link']; 

           if(!empty($caption) && !empty($view_link)){

            echo $caption;
            echo "<a href=".$view_link."> View Post  </a>";
          }else{
              echo "  ";
            }
         ?>
       </p>


        <p><b> Post Date: </b> <?php  

          $unix_date = $instas['date']; 
          $date = date('M j, Y', $unix_date);

           if(!empty($date)){
            
              echo $date;
           
           }else{

             echo "  ";
           }
         ?>
       </p>    


       <p> <img src=<?php 

         $post_image = $instas['image']; 

        if(!empty($post_image)) {

               echo $post_image;
           }else{
             
              echo public_path("/profile_pics/user_instagram.jpg");
         }

       ?> alt="profie_pic" style="width:100%" />

       </p>



   </div>
</div>





<?php

  } //foreach 

} //main if

?>


















</div>

<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>

<!-- END: .main-content -->
@endsection
