<?php


//--------------------- Start All In One Hashtags Feeds -----------------------------------



public function all_feeds(Request $request){ 

       // return $this->twitter_feeds($request);
      //return $this->instagram_feeds($request);

         $user = User::findOrFail(Auth::user()->id);
         $user_id = $user->id; //get login user id
         $social_webname = 'instagram';  // Social webname
         $link = env('APP_URL').'/laravel-admin/instagram_feeds'; 


        
     $instagram_data = UsersSocialCredentials::where('social_webname','=',$social_webname)->Where('user_id',$user_id)->first();

         if(isset($instagram_data) && !empty($instagram_data) && !empty($instagram_data['accesstoken']) && !empty($instagram_data['accesstokensecret']) ){ //if data found
         
         $client_id = $instagram_data['accesstoken'];
         $client_secret = $instagram_data['accesstokensecret'];
         $hashtags = $instagram_data['hashtags'];
         $hashtags = str_replace('#', '', $hashtags);
         
         $access_token_url = 'http://instagram.com/oauth/authorize/?client_id='.$client_id.'&redirect_uri='.$link.'&response_type=token';
         
         $tags_json_link = "https://www.instagram.com/explore/tags/".$hashtags."/?__a=1";
    
         $arrContextOptions=array(
            "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
           ),
         ); 

         $instas = file_get_contents($tags_json_link, false, stream_context_create($arrContextOptions));
         $insta_array = json_decode($instas, TRUE);  //gives array of that json
         $insta_array_url = json_decode($instas, TRUE);


         $limit = 18; //page per limit

         for ($i=$limit; $i >= 0; $i--) {

         if(array_key_exists($i,$insta_array["graphql"]["hashtag"]["edge_hashtag_to_media"]["edges"])){

         $next_url_array = $insta_array["graphql"]["hashtag"]["edge_hashtag_to_media"]["page_info"];
 
         $next_page = [

         "exist_next_page"=> $next_url_array['has_next_page'],
         "end_cursor"=> $next_url_array['end_cursor']
      
        ];
  }
}
       
        $next_page_end_cursor = $next_page['end_cursor'];
        $exist_next_page = $next_page['exist_next_page'];
 

   return view('all_feeds')->with('instas',$instas)->with('insta_array',$insta_array)->with('next_page',$next_page)->with('tags_json_link',$tags_json_link);

     
  }//if closed instagram_data

else{//else Part  


 if($instagram_data['accesstoken'] === NULL && $instagram_data['accesstokensecret'] === NULL ){
            
            return view('all_feeds')->with('instagram_data',$instagram_data);
         }

 
} //end else

  /* ----------------------------------------------------------------------------------------- */


          //login user
        $user = User::findOrFail(Auth::user()->id);
        $user_id = $user->id; //get login user id
        $social_webname = 'twitter';  // Social webname
        
         $user_hashtags = DB::select( DB::raw("SELECT hashtags FROM userssocial_credentials WHERE user_id = '$user->id' and social_webname = '$social_webname' ") );

         if(empty($user_hashtags)){

            return view('all_feeds');

         }else{


          $hashtags_data = $user_hashtags['0']->hashtags; 

         if(!empty($hashtags_data)){

            $hashtag_search = $hashtags_data; // My Search Tag Add Dynamic Here

         }else{
            $hashtag_search = '#india';
         }

       }    
     
     $user_exist = DB::select( DB::raw("SELECT * FROM userssocial_credentials WHERE user_id = '$user->id' and social_webname = '$social_webname' ") );

      include(app_path()."/TwitterAPIExchange.php");

      if(!empty($user_exist)) { 

       $twitter_data = UsersSocialCredentials::where('social_webname','=',$social_webname)->Where('user_id',$user_id)->first(); //data

         $accesstoken = $twitter_data['accesstoken'];
         $accesstokensecret = $twitter_data['accesstokensecret'];
         $consumerkeyapikey = $twitter_data['consumerkeyapikey'];
         $consumersecretapikey = $twitter_data['consumersecretapikey'];
         $hashtags = $twitter_data['hashtags']; //database_hastag
        
         //$hashtags = '#india_india'; //static_hastag

            $settings = array(
                'oauth_access_token' => $consumerkeyapikey,
                'oauth_access_token_secret' => $consumersecretapikey,
                'consumer_key' => $accesstoken,
                'consumer_secret' => $accesstokensecret
            );


                $url = 'https://api.twitter.com/1.1/search/tweets.json';
                $getfield = '?q='.$hashtags.'&count=50'; //30hashtag post defined
                $requestMethod = 'GET';
                $twitter = new TwitterAPIExchange($settings);
                $tweest_json = $twitter->setGetfield($getfield)->buildOauth($url,$requestMethod)->performRequest();
                
                $tweets = json_decode($tweest_json, true);

                 /* error Handle if Credential is wrong */
                  if(!empty($tweets['errors'])) {

                    //if Credential is wrong then show blank tweeter page
                  Session::flash('success_message', "Please Check Your Twitter Credential We Could not authenticate you.");
                  
                  return view('all_feeds');

                  }

                  /* if No Data found in Status Array */
                  if(empty($tweets['statuses'])){

                   return view('all_feeds');

                 }

             /*Start For Search_metadata --> next_results_set  Pagination */
   
                 $next_results = $tweets['search_metadata']['next_results'];
                 $max_id = $tweets['search_metadata']['max_id'];
                
             /*End For Search_metadata --> next_results_set  Pagination */

                 if(isset($next_results) && !empty($next_results) && isset($max_id) && !empty($max_id)){

                    //echo $next_results;   //echo $max_id;  //die();
                      $url = 'https://api.twitter.com/1.1/search/tweets.json';
                      $getfield = '?q='.$hashtag_search.'&count=50'.$next_results; 
                      $requestMethod = 'GET';
                      $twitter = new TwitterAPIExchange($settings);
                      $tweest = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
                      $tweets_next_page = json_decode($tweest, true);

                      print_r($tweets_next_page);
                      die();
                 }

                
                Session::flash('success_message', "Your Instagram Details Found");
                return view('all_feeds')->with('tweets',$tweets)->with('tweets_next_page',$tweets_next_page);

      }











  }//close all feeds function


 ?>