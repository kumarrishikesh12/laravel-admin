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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<style>


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
p{

  font-size: 10px;

}

#viewmorebtn{

color: #ffffff !important; 
text-decoration: none;

}


</style>


<?php 

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSLVERSION, 3);


if(!empty($next_page['end_cursor'])) { 

//display pagination if data exist and not empty
//$next_page['exist_next_page'];
$limit = 18;  
$next_page['end_cursor']; //end_cursor for next page
$tags_json_link; //link_url: https://www.instagram.com/explore/tags/guardiansofthegalaxy/?__a=1

$next_full_url = $tags_json_link.'&first='.$limit.'&after='.$next_page['end_cursor'];
//Get Full link with end_cursor above.
//echo $next_full_url;
//die();



$arrContextOptions=array(
  "ssl"=>array(
  "verify_peer"=>false,
  "verify_peer_name"=>false,
  ),
 ); 

$instas_next_json = file_get_contents($next_full_url, false, stream_context_create($arrContextOptions));
$insta_next_array = json_decode($instas_next_json, TRUE);  //next page ka array data


/*
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";

echo $instas_next_json; // next page ka json data

die();

*/

}

?>


<!--  #############################  Start Pagination Show   ###############################  -->

<div class="main-content">


<?php 


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

</br>


<!--  #############################  End Pagination Show   ###############################  -->
  
  <div class="container">
      <div class="row">



<?php

if(isset($tweets) && !empty($tweets) && !empty($tweets_next_page['search_metadata']['next_results'])) {  

foreach( $tweets['statuses'] as $key => $value){

?>
   <div class="col-lg-3 col-sm-4 col-xs-8">
      <div class="card">
        <div class="card-body">

          <p><span> Tweet Post: </span> 
         <?php 
              $tweet = $tweets['statuses'][$key]['text'] = htmlspecialchars_decode($value['text']);
              if(!empty($tweet)){
                echo   '<span style="font-size: 10px;font-weight: bold;margin-left: 12px;">'.$tweet .'.</span>';
              }else{  

                echo "  ";  

                }
          ?> 
      </p> 
              
     
      <img class="img-responsive" src=<?php

             $profile_image_url = $tweets['statuses'][$key] = $value['user']['profile_image_url']; 
             $profie_pic = str_replace("_normal", "_400x400", $profile_image_url);

             if (!empty($profie_pic)) {
               echo $profie_pic;
             }else{
              echo public_path("/profile_pics/user_twitter.jpg");
             }
             ?> alt="profie_pic" style="width:100%">

      <div class="container" style="margin-top:10px">
          
          <p><span> Username: </span> <?php
            $username = $tweets['statuses'][$key] = $value['user']['screen_name']; 
            if (!empty($username)) {
              echo '<span style="font-size: 10px;font-weight: bold;margin-left: 12px;">'.$username .'.</span>';
            }else{
              echo "  ";
            }
           ?>
          
          </p> 


          <p><span> Name: </span> <?php

           $name = $tweets['statuses'][$key] = $value['user']['name'];  
           if (!empty($name)) {
            echo '<span style="font-size: 10px;font-weight: bold;margin-left: 12px;">'.$name.'</span>';
           }else {
              echo $username;
           }

           ?>
          </p>
          


          <p><span> Description: </span> <?php 

            $description = $tweets['statuses'][$key] = $value['user']['description']; 
            if (!empty($description)) {
              echo '<span style="font-size: 10px;font-weight: bold;margin-left: 12px;">   '.$description.'</span>';
            }else{
              echo "  ";
            }
            ?>
          </p>


          <p><span> Location: </span> <?php 

           $location = $tweets['statuses'][$key] = $value['user']['location'];  
            if(!empty($location)){
              echo '<span style="font-size: 10px;font-weight: bold;margin-left: 12px;">   '.$location.'</span>';
            }else{

               echo $location = " ";
            }
            ?>
           </p>



          <p><span> Followers: </span> <?php 

           $followers = $tweets['statuses'][$key] = $value['user']['followers_count'];  
            if(!empty($followers)){
             echo '<span style="font-size: 10px;font-weight: bold;margin-left: 12px;">   '.$followers.'</span>';
            }else{

               echo $followers = "  ";
            }
            ?>
           </p>



          <p><span> Following: </span> <?php 

           $following = $tweets['statuses'][$key] = $value['user']['friends_count'];  
            if(!empty($following)){
              echo '<span style="font-size: 10px;font-weight: bold;margin-left: 12px;">   '.$following.'</span>';
            }else{

               echo $following = "  ";
            }
            ?>
           </p>



          <p><span> Tweets: </span> <?php 

           $tweets_count = $tweets['statuses'][$key] = $value['user']['statuses_count'];  
            if(!empty($tweets_count)){
              echo '<span style="font-size: 10px;font-weight: bold;margin-left: 12px;">   '.$tweets_count.'</span>';
            }else{

               echo $tweets_count = "  ";
            }
            ?>
          </p>


          <p><span> Joined Date: </span> <?php 

           $join_date = $tweets['statuses'][$key] = $value['user']['created_at'];  
            if(!empty($join_date)){

                 $dateandtime = new DateTime($join_date);
                 $variable1 = $dateandtime->format("h:i:A");  
                 $variable2 = $dateandtime->format("d");         
                 $variable3 = $dateandtime->format("d M Y");


          echo '<span data-toggle="tooltip" data-placement="top" title='.$variable1.' style="font-size: 10px;font-weight: bold;margin-left: 12px;">   '.$variable3.'</span>';
            }else{

               echo $join_date = "  ";
            }

            ?>
           </p>
         </div>



       </div>
     </div>
   </div>
   

<?php

   } //foreach_end
 }
?>

   
  </div>
 </div> 
</div>
    



<!-- ########################## Fetch Instagram Feeds ################################ -->

<!-- <div class="main-content" id="NextResult"> -->


<div class="main-content">
  <div class="container">
   <div class="row">


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

<div class="col-lg-3 col-sm-4 col-xs-8">
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
 </div>




<?php

  } //foreach 

} //main if

?>

    </div>
  </div>
</div>



<!-- ########################## End Fetch Instagram Feeds ################################ -->





<!-- ########################## Display See More Feeds ################################ -->

<!--  
<div class="main-content">
  <div class="container">
    <div class="row">

      <div class="col-lg-3 col-sm-4 col-xs-8">
        <div class="card">
          <div class="card-body">

            <p><b> Instagram Post:</b> <span id="instagram_caption"> </span></p>

             <p><b> Post Date: </b> <span id="instagram_post_date"> </span></p>

             <p> <img id="instagram_post_image" alt="profie_pic" style="width:100%" /> </p>

           </div>
        </div> 
      </div>
    </div>
  </div>
</div> 
 -->
     

<!-- ########################## ENd Display See More Feeds ################################ -->


<script type="text/javascript"> 

function myFunction(){

 getUserInfo(<?php echo json_encode($insta_next_array); ?>)

}



function getUserInfo(userObj){

   //console.log(userObj);
   //alert(userObj['graphql']['hashtag']['edge_hashtag_to_media']['edges'][0]['node']['display_url']);
   var limit = 18;

   for (i=limit; i>=0; i--) {
    
    
      if(userObj['graphql']['hashtag']['edge_hashtag_to_media']['edges'][i]['node']) {

        //var latest_array = userObj['graphql']['hashtag']['edge_hashtag_to_media']['edges'][$i]['node'];

        var image = userObj['graphql']['hashtag']['edge_hashtag_to_media']['edges'][i]['node']['display_url'];
        var thumbnail = userObj['graphql']['hashtag']['edge_hashtag_to_media']['edges'][i]['node']['thumbnail_src'];
        var instagram_id = userObj['graphql']['hashtag']['edge_hashtag_to_media']['edges'][i]['node']['id'];

        var link = "https://www.instagram.com/p/userObj['shortcode']";

        var caption = userObj['graphql']['hashtag']['edge_hashtag_to_media']['edges'][i]['node']['edge_media_to_caption']['edges'][0]["node"]["text"];

        var date_time = userObj['graphql']['hashtag']['edge_hashtag_to_media']['edges'][i]['node']['taken_at_timestamp'];
  
         var date = new Date(date_time);

         //alert(caption);
         //document.getElementById("instagram_caption").innerHTML = caption;
         //document.getElementById("instagram_post_date").innerHTML = date;
         //document.getElementById("instagram_post_image").innerHTML = image;  



           console.log(caption);
           console.log(date);
           console.log(image);




           /*

         var top_divi ="<div class='main-content'><div class='container'><div class='row'><div class='col-lg-3 col-sm-4 col-xs-8'><div class='card'><div class='card-body'>";
         document.write(top_divi);
        
        


         document.write("<?php //echo "<p><b> Instagram Post: </b><span>"; ?>"+ caption +"<?php //echo "</span></p>";  ?>" );
          

         var bottom_divi = "</div> </div> </div> </div> </div> </div>";
         document.write(bottom_divi);
        */

    }

  }

}

</script>















<div class="container">

 <button type="button" onclick="myFunction()" id="ViewMore" name="viewmore" style="margin-top: 15px;margin-bottom: 15px;" class="btn btn-primary btn-block">View More</button> 








 <button type="button" id="ViewMore" name="viewmore" style="margin-top: 15px;margin-bottom: 15px;" class="btn btn-primary btn-block">  <a href=<?php echo 'all_feeds?__a=1&first='.$limit.'&after='.$next_page['end_cursor']; ?> name="next" id="viewmorebtn"> Next Page </a></button>
   
 
</div>

<!-- END: .main-content -->
@endsection







