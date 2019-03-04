//--------------------- Start Twitter Api GEt's -------------------------------



  public function twitter_api(Request $request){ 

        //login user
        $user = User::findOrFail(Auth::user()->id);
        $user_id = $user->id; //get login user id
        $social_webname = 'twitter';  // Social webname
        

         $user_hashtags = DB::select( DB::raw("SELECT hashtags FROM userssocial_credentials WHERE user_id = '$user->id' and social_webname = '$social_webname' ") );

         //print_r($user_hashtags);
         //die();

         if(empty($user_hashtags)){

            //if not get hashtags show blank  tweeter page
            return view('twitter_feeds');

         }else{


          $hashtags_data = $user_hashtags['0']->hashtags; 


         if(!empty($hashtags_data)){

            $hashtag_search = $hashtags_data; // My Search Tag Add Dynamic Here

         }else{
            $hashtag_search = '#india';
         }

       }    
        
     
     $user_exist = DB::select( DB::raw("SELECT * FROM userssocial_credentials WHERE user_id = '$user->id' and social_webname = '$social_webname' ") );

       //$myJSON = json_encode($user_exist);
       //echo $myJSON;
       //die();

      include(app_path()."/TwitterAPIExchange.php");

      if(!empty($user_exist)) { 
        //data exist

       $twitter_data = UsersSocialCredentials::where('social_webname','=',$social_webname)->Where('user_id',$user_id)->first(); //data

       //echo "$twitter_data";
       //die();

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


                  //$parameters = $_SERVER['REQUEST_URI']; 
                  //$parameter = str_replace('/laravel-admin/twitter_api?','',$parameters);
                  //$get_max_id = $_GET["max_id"]; 
                  //http://localhost/laravel-admin/twitter_api?max_id=1096296476781760512&q=%23india&count=40&include_entities=1
                  //die();


                $url = 'https://api.twitter.com/1.1/search/tweets.json';
                $getfield = '?q='.$hashtags.'&count=40'; //40hashtag post defined
                $requestMethod = 'GET';
                $twitter = new TwitterAPIExchange($settings);
                 $tweest_json = $twitter->setGetfield($getfield)->buildOauth($url,$requestMethod)->performRequest();

                
                  $tweets = json_decode($tweest_json, true);
                  //echo $tweest_json;
                  //print_r($tweets);
                  //die();

                 /* error Handle if Credential is wrong */
                  if(!empty($tweets['errors'])) {

                    //if Credential is wrong then show blank tweeter page
                  Session::flash('success_message', "Please Check Your Twitter Credential We Could not authenticate you.");
                  
                  return view('twitter_feeds');

                  }

                  /* if No Data found in Status Array */
                  if(empty($tweets['statuses'])){

                   return view('twitter_feeds');

                 }




             /*Start For Search_metadata --> next_results_set  Pagination */
   
                 $next_results = $tweets['search_metadata']['next_results'];
                 $max_id = $tweets['search_metadata']['max_id'];
                
             /*End For Search_metadata --> next_results_set  Pagination */


                 if(isset($next_results) && !empty($next_results) && isset($max_id) && !empty($max_id)){

                    //echo $next_results;   //echo $max_id;  //die();
                      $url = 'https://api.twitter.com/1.1/search/tweets.json';
                      $getfield = '?q='.$hashtag_search.'&count=40'.$next_results; 
                      $requestMethod = 'GET';
                      $twitter = new TwitterAPIExchange($settings);
                      $tweest = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
                      $tweets_next_page = json_decode($tweest, true);

                      //$next_results = $tweets_next_page['search_metadata']['next_results'];
                        //die();

                 }

                  


                Session::flash('success_message', "Your Instagram Details Found");
                return view('twitter_api')->with('tweest_json',$tweest_json)->with('tweets_next_page',$tweets_next_page);



      }else{

      //data empty
        Session::flash('success_message', "Details Not Found, Please Update Tokens");

      return redirect()->back()->with('success_message', trans('user/twitter.UserNotFound'));


      }



  }
