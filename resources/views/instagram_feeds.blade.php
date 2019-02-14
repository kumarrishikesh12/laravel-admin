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
                    <h3>{!! trans('user/dashboard.instagram') !!}</h3>
                   
                </div>
            </div>
        </div>
    </div>
</header>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">

$(document).ready(function(){

  $('[data-toggle="tooltip"]').tooltip();   


// ===== Scroll to Top ==== 
$(window).scroll(function() {
    if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
        $('#return-to-top').fadeIn(200);    // Fade in the arrow
    } else {
        $('#return-to-top').fadeOut(200);   // Else fade out the arrow
    }
});
$('#return-to-top').click(function() {      // When arrow is clicked
    $('body,html').animate({
        scrollTop : 0                       // Scroll to top of body
    }, 500);
});




});

</script>


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


#return-to-top {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: rgb(0, 0, 0);
    background: rgba(0, 0, 0, 0.7);
    width: 50px;
    height: 50px;
    display: block;
    text-decoration: none;
    -webkit-border-radius: 35px;
    -moz-border-radius: 35px;
    border-radius: 35px;
    display: none;
    -webkit-transition: all 0.3s linear;
    -moz-transition: all 0.3s ease;
    -ms-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    transition: all 0.3s ease;
}
#return-to-top i {
    color: #fff;
    margin: 0;
    position: relative;
    left: 16px;
    top: 13px;
    font-size: 19px;
    -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    -ms-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    transition: all 0.3s ease;
}
#return-to-top:hover {
    background: rgba(0, 0, 0, 0.9);
}
#return-to-top:hover i {
    color: #fff;
    top: 5px;
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

if(!empty($next_full_url) && !empty($next_page['end_cursor']) ){ //Start next url empty or exist or not

?>

<ul class="pagination">
  <li class="page-item float-left" id="previous_data"><a class="page-link" href=<?php echo 'instagram_feeds?__a=1&first='.$limit.'&after='.$next_page['end_cursor']; ?> name="previous">Previous Page </a></li>

    <li class="page-item float-right" id="next_data"><a class="page-link" href=<?php echo 'instagram_feeds?__a=1&first='.$limit.'&after='.$next_page['end_cursor']; ?> name="next"> Next Page</a></li>
</ul>

<?php

} //End next url empty or exist or not

?>


<?php 

if(isset($insta_array) && !empty($insta_array) ) {
//if data exist in Instas, print$


      $limit = 18; //page per limit

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

       //print_r($instas); 
       //echo "</br>";
       //die(); 

  }



?>

 <div class="card">
      <div class="card-body">



       <p><b> Instagram Post: </b>
        <?php  

          echo $caption = $instas['caption']; 
         
           $view_link = $instas['link']; 
          echo "<a href=".$view_link."> View Post  </a>";
           
         ?>
       </p>


        <p><b>  Post Date: </b>
        <?php  

          $unix_date = $instas['date']; 
          echo $date = date('M j, Y', $unix_date);

         ?>
       </p>    


       <p>

        <img src="<?php echo $instas['image']; ?>" alt="profie_pic" style="width:100%"  >

       </p>



   </div>
</div>





<?php

  } //foreach 

} //main if

?>






<?php

/*

if(isset($instas) && !empty($instas)) {
//if data exist in Instas, print

 foreach( $instas['data'] as $key => $value ) {

?>
        
  
  <div class="card">
      <div class="card-body">

        <?php
          $tags =  $instas['data'][$key] = $value['tags'];
          $my_tags = implode(',', $tags);

          if(!empty($my_tags)){

            echo "<p><b> Hashags: </b>".$my_tags;    

          }
     
      

    ?>


        <p><b> Instagram Post: </b> 
         <?php 
            $text_caption =  $instas['data'][$key] = $value['caption']['text'];

            if(!empty($text_caption)){
                echo $text_caption;
              }else{  

                echo "  ";  

                }

          ?> 
         </p> 


             <?php 
             $type = $instas['data'][$key] = htmlspecialchars_decode($value['type']);

             if (!empty($type) && $type === 'image' ) {  ?>
                 

            <img src= <?php  //$profile_picture_url =  $instas['data'][$key] = $value['images']['type'];

             $profile_picture_url =  $instas['data'][$key] = $value['images']['standard_resolution']['url'];

             //$profie_pic = str_replace("_normal", "_400x400", $profile_picture_url);

             if (!empty($profile_picture_url)) {
               echo $profile_picture_url;
             }else{
              echo public_path("/profile_pics/user_twitter.jpg");
             }   ?> alt="profie_pic" style="width:100%">


             <?php
               } 
             ?>


            <?php
            
            $type = $instas['data'][$key] = htmlspecialchars_decode($value['type']);

             if (!empty($type) && $type === 'video' ) {  

            $insta_video_url =  $instas['data'][$key] = $value['videos']['standard_resolution']['url'];


                ?>

                <video width="400" controls style="margin-left: -14px !important">
                <source src="<?php echo $insta_video_url; ?>" type="video/mp4">
                Your browser does not support HTML5 video.
                </video>





             <?php
               } 
             ?>



        <div class="container" style="margin-top:10px"/>

          <p><b> Name: </b> <?php

           $full_name =  $instas['data'][$key] = $value['user']['full_name'];
           if (!empty($full_name)) {
            echo '<span style="font-size: 16px;font-weight: bold;margin-left: 12px;">   '.$full_name.'</span>';
           }else {
              echo $full_name;
           }

           ?> </p>


          
          <h6><b> Username:
            <?php

            $username = $instas['data'][$key] = $value['user']['username'];
            if (!empty($username)) {
              echo $username;
            }else{
              echo "  ";
            }

           ?>
          </b></h6> 



          <p><b> Likes: </b> 
           <?php 

             $post_likes =  $instas['data'][$key] = $value['likes']['count'];
  
            if(!empty($post_likes)){
              echo '<span style="font-size: 16px;font-weight: bold;margin-left: 12px;">   '.$post_likes.'</span>';
            }else{

               echo $post_likes = "  ";
            }

            ?>
           </p>



            <p><b> Location: </b> 
           <?php 

            $location =  $instas['data'][$key] = $value['location']['name']; //location_name

            if(!empty($location)){
              echo '<span style="font-size: 16px;font-weight: bold;margin-left: 12px;">   '.$location.'</span>';
            }else{

               echo $location = " ";
            }

            ?>
           </p>



           <p><b> Uploaded Date: </b> 
           <?php 

           $join_date =   $instas['data'][$key] = $value['created_time'];
            
            if(!empty($join_date)){

                 //$dateandtime = new DateTime($join_date);
                 //$variable1 = $dateandtime->format("h:i:A");  
                 //$variable2 = $dateandtime->format("d");         
                 //$variable3 = $dateandtime->format("d M Y");
            
                 $pic_created_time=date("F j, Y", $join_date);
                 $pic_created_time=date("F j, Y", strtotime($pic_created_time . " +1 days"));


    
          echo '<span data-toggle="tooltip" data-placement="top" title='.$pic_created_time.' style="font-size: 16px;font-weight: bold;margin-left: 12px;">   '.$pic_created_time.'</span>';
            }else{

               echo $pic_created_time = "  ";
            }

            ?>
           </p>
          


          </div> <!--  Div Class Container Close -->    
         </div>
        </div>

 

<?php       

 }//foreach end

}//if end



*/
?>







<?php

 //if(!empty($next_url_api)){ 

//instagram pagination link    //print_r($next_url_api);
  
/*<ul class="pagination">
  <li class="page-item"><a class="page-link" href="#1">1</a></li>
  <li class="page-item"><a class="page-link" href="#2">2</a></li>
  <li class="page-item"><a class="page-link" href="#3">3</a></li>
</ul>  
*/ 

 // }
?>






<?php
 /*
    

                 $type = $instas['data'][$key] = htmlspecialchars_decode($value['type']);
                 $main_id =  $instas['data'][$key] = htmlspecialchars_decode($value['id']);
                 $insta_id =  $instas['data'][$key] = $value['user']['id'];
                 $full_name =  $instas['data'][$key] = $value['user']['full_name'];
                 $profile_picture =  $instas['data'][$key] = $value['user']['profile_picture'];
                 $username =  $instas['data'][$key] = $value['user']['username'];
                 $post_picture =  $instas['data'][$key] = $value['images']['standard_resolution']['url'];
                 $text_caption =  $instas['data'][$key] = $value['caption']['text'];
                 $post_likes =  $instas['data'][$key] = $value['likes']['count'];
                 $location =  $instas['data'][$key] = $value['location']['name']; //location_name
                 $created_time =   $instas['data'][$key] = $value['created_time']; //convert to time


*/
?>

<a href="javascript:" id="return-to-top"><i class="icon-chevron-up"></i></a>


</div>
<!-- END: .main-content -->
@endsection
