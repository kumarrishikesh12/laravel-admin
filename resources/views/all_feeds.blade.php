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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">

$(document).ready(function(){

  $('[data-toggle="tooltip"]').tooltip();   

});

</script>


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

.ajax-load{
            background: #62bcf666;
            padding: 10px 0px;
            width: 100%;
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


<!--  ####################  Check Instagram Next Page Data Exist    #####################  -->

<?php

#Get all data, if end_cursor is not empty 
  
if(!empty($next_page['end_cursor'])){    

//print_r($insta_array);  //Instagram k currnet page ka array data
//echo $instas;           //Instagram k currnet page ka json data

$limit = 18;  
$next_page['end_cursor'];  //current_page next_results end_cursor
//$next_full_url = $tags_json_link.'&first='.$limit.'&after='.$next_page['end_cursor']; 

$next_full_url = env('APP_URL').'/laravel-admin/instagram_api'; 

//http://localhost/laravel-admin/instagram_api
//Full_link + end_cursor 
//die();

}

?>
<!--  ####################  End Check Instagram Next Page Data Exist    #####################  -->





<!--  ####################  Check Twitter Next Page Data Exist    #####################  -->
<?php

if(!empty($tweets['search_metadata']['next_results'])  ){   


//$next_page_parameter = $tweets['search_metadata']['next_results']; 
//current_result_page 

//echo "</br></br>";

$tweets_next_results_page = $tweets_next_page['search_metadata']['next_results'];
//next_results_page;

$twitter_url = env('APP_URL').'/laravel-admin/twitter_api'.$tweets_next_results_page;


/*  if(isset($next_results_parameters) && !empty($next_results_parameters)){
    $twitter_url = env('APP_URL').'/laravel-admin/twitter_api'.$next_results_parameters;      
  }*/




//print_r($tweets);   //twitter k currnet page ka array data
//echo $tweest_json;  //twitter k currnet page ka json data

//echo "</br></br></br></br></br></br></br></br>";
//echo "</br></br></br></br></br></br></br></br>";

//print_r($tweets_next_page);   //twitter k next page ka array data
//echo $tweest_json_next_page;  //twitter k next page ka json data


}

?>
<!--  ####################  End Check Instagram Next Page Data Exist    #####################  -->



<script type="text/javascript">

function load_more(){

$(document).ready(function(){

/*  $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height()) {  */


            var insta_end_cursor = "<?php
              
               if(!empty($next_full_url)){
                echo $next_full_url; 
               }else{
                echo $next_full_url = 'undefined';
                }  

             ?>";


            var twitter_full_url = "<?php

               if(!empty($twitter_url)) {
                echo $twitter_url; 
               }else {
               echo $twitter_url = 'undefined';
               }  ?>";


                console.log(insta_end_cursor);
                console.log(twitter_full_url);



               if (typeof insta_end_cursor === 'undefined' || insta_end_cursor === null ) {
                       // variable is undefined or null   
                }
                else{    // variable is defined   

                loadMoreData(twitter_full_url); //twitter
                loadMoreDataInstagram(insta_end_cursor); //instagram

               

/*
    }
 });

*/

 function loadMoreData(twitter_full_url){


       $.ajax({
                      url: twitter_full_url,
                      type: "get",
                      beforeSend: function(){
                      $('.ajax-load').show();
                      }

              })

       .done(function(data){

         $('.ajax-load').hide();
         // $("#loadMoreData").append(data);

         let feeds = JSON.parse(data)
         console.log('twitter --> ', feeds);
         // statuses[""0""].user.profile_background_image_url_https
         let feedElement = '';
         feeds.statuses.forEach(function(feed){
          //console.log(feed);


          var profile_pics = feed.user.profile_image_url;
           profile_pics = profile_pics.replace("_normal", "_400x400");


            //console.log(feed.user.created_at); //Sat Dec 12 17:17:20 +0000 2015

            var myDate = feed.user.created_at;
            var str = myDate; 
            var day = str.slice(0, 3);
            var month = str.slice(4, 7);
            var date = str.slice(8, 10);
            var year = str.slice(26, 31);
          

            /* get url of tweet */

            var tweet_string_get = feed.text;
            var matches = tweet_string_get.match(/\bhttps?::\/\/\S+/gi);

            console.log(matches);



          let feedDiv = '<div class="col-lg-3 col-sm-4 col-xs-8"><div class="card"><div class="card-body"><p><span> Tweet Post: </span> <span style="font-size: 10px;font-weight: bold;margin-left: 12px;"> '+feed.text+'  </span></p><img class="img-responsive" src=" '+profile_pics+' " alt="profie_pic" style="width:100%"><div class="container" style="margin-top:10px"><p><span> Username: </span> <span style="font-size: 10px;font-weight: bold;margin-left: 12px;"> '+feed.user.screen_name+' </span></p><p><span> Name: </span> <span style="font-size: 10px;font-weight: bold;margin-left: 12px;"> '+feed.user.name+'</span></p><p><span> Description: </span> <span style="font-size: 10px;font-weight: bold;margin-left: 12px;"> '+feed.user.description+'</span></p><p><span> Location: </span> <span style="font-size: 10px;font-weight: bold;margin-left: 12px;"> '+feed.user.location+' </span></p><p><span> Followers: </span> <span style="font-size: 10px;font-weight: bold;margin-left: 12px;">  '+feed.user.followers_count+' </span></p><p><span> Following: </span> <span style="font-size: 10px;font-weight: bold;margin-left: 12px;">  '+feed.user.friends_count+'  </span></p><p><span> Tweets: </span> <span style="font-size: 10px;font-weight: bold;margin-left: 12px;"> '+feed.user.statuses_count+'</span></p><p><span> Joined Date: </span> <span data-toggle="tooltip" data-placement="top" title="" style="font-size: 10px;font-weight: bold;margin-left: 12px;" data-original-title="07:48:AM">  '+date+ ' '+month+' '+year+' </span></p></div></div></div></div>'


          feedElement += feedDiv;

         })

         $('#loadMoreData').append(feedElement);

       })

       .fail(function(jqXHR, ajaxOptions, thrownError){
                  alert('Twitter Server Not Responding...');
         });    
    
 }  //loadMoreData
 

function loadMoreDataInstagram(insta_end_cursor){


   $.ajax({
                      url: insta_end_cursor,
                      type: "get",
                      beforeSend: function(){
                      $('.ajax-load').show();
                      }

              })

       .done(function(data){

         $('.ajax-load').hide();



         let insta_feeds = JSON.parse(data)
         console.log('instagram --> ', insta_feeds);
         // statuses[""0""].user.profile_background_image_url_https
         //.graphql.hashtag.edge_hashtag_to_media.edges["0"].node.display_url
         let feedElements = '';

          insta_feeds.graphql.hashtag.edge_hashtag_to_media.edges.forEach(function(feed_insta){


            //var instat_date = feed_insta.node.taken_at_timestamp;
             //Fri Feb 15 2019 18:48:54 GMT+0530 (IST)
            //var insta_month = date_moment.slice(4, 7);
            //var insta_date =  date_moment.slice(8, 10);
            //var insta_year =  date_moment.slice(11, 15);
            

            //let feedsDiv = '<div class="col-lg-3 col-sm-4 col-xs-8"><div class="card"><div class="card-body"><p><b> Instagram Post: </b>'+ feed_insta.node.edge_media_to_caption.edges["0"].node.text +'<a href="https://www.instagram.com/p/"> View Post  </a></p>  <p><b> Post Date: </b>'+ feed_insta.node.taken_at_timestamp +'</p><p><img src="'+feed_insta.node.display_url+'" alt="profie_pic" style="width:100%"></p> </div></div></div>'
                
        
            var ti = feed_insta.node.taken_at_timestamp;
            var myDate = new Date(ti*1000);
            var insta_post_date = myDate.toGMTString();  //Mon, 18 Feb 2019 04:45:54 GMT


              var dat = insta_post_date.slice(5, 8);
              var mont = insta_post_date.slice(8,11);
              var yea = insta_post_date.slice(12,16);
  
            //document.write(myDate.toGMTString()+"<br>"+myDate.toLocaleString());
            //console.log(myDate);


            let feedsDiv = '<div class="col-lg-3 col-sm-4 col-xs-8"><div class="card"><div class="card-body"><p><b> Instagram Post: </b>'+ feed_insta.node.edge_media_to_caption.edges["0"].node.text +'</p>  <p><b> Post Date: </b>'+mont+' '+dat+', '+ yea +'</p><p><img src="'+feed_insta.node.display_url+'" alt="profie_pic" style="width:100%"></p> </div></div></div>'

            feedElements += feedsDiv;


    })

      $('#loadMoreData').append(feedElements);
 })
          
/*
          

          


          })

          $('#loadMoreData').append(feedElement);


         });   

            .fail(function(jqXHR, ajaxOptions, thrownError){
                  alert('Instagram Server Not Responding...');
         });

*/

} //loadMoreDataInstagram




   } //else


 });

 }    


</script>








<!--  ###################  Start - Display Twitter Feeds   ###########################  -->

<div class="main-content">
  <div class="container">
      <div class="row">

<?php

if(isset($tweets) && !empty($tweets) && !empty($tweets['search_metadata']['next_results'])) {  

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
    
<!--  ###################  End - Display Twitter Feeds   ###########################  -->








<!-- #################### Start - Display Instagram Feeds ########################### -->

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



<!-- ########################## End Display Instagram Feeds ################################ -->






<!-- ########################## Display See More Feeds ################################ -->
                            
                             <!-- Twitter and Insta  -->

<!-- https://itsolutionstuff.com/post/php-infinite-scroll-pagination-using-jquery-ajax-exampleexample.html -->
  
    <div class="container">
       <div class="row" id="loadMoreData">   
 
       </div>  
  </div>


<div class="ajax-load text-center" style="display:none">
    <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More post</p>
</div>

<!-- ########################## ENd Display See More Feeds ################################ -->




<div class="container">

<button type="button" onclick="load_more()" id="ViewMore" name="viewmore" style="margin-top: 15px;margin-bottom: 15px;" class="btn btn-primary btn-block">View More</button> 
 
</div>
<!-- END: .main-content -->
@endsection