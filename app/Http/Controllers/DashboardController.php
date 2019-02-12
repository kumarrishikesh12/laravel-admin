<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Facebook\Facebook as Facebook;

use App\User as User;
use App\UsersSocialCredentials;
use Hash;
use Validator;
use File;
use auth;
use DB;
use Session;
use TwitterAPIExchange;
use Exception;






class DashboardController extends Controller
{   
    protected $auth;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->auth = auth()->user();
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard');
    }



   //----------------------- Twitter ------------------------------------


    public function connecttotwitter(Request $request) {

        //login user_details
        $user = User::findOrFail(Auth::user()->id);
        $social_webname = 'twitter';

        if(isset($user) && !empty($user)){

        $user_id = $user->id;//id

        $twitter_data = UsersSocialCredentials::where('social_webname','=',$social_webname)->Where('user_id',$user_id)->first(); //data

        $accesstoken = $twitter_data['accesstoken'];
        $accesstokensecret = $twitter_data['accesstokensecret'];
        $consumerkeyapikey = $twitter_data['consumerkeyapikey'];
        $consumersecretapikey = $twitter_data['consumersecretapikey'];

            if(!empty($accesstoken) && !empty($accesstokensecret) && !empty($consumerkeyapikey) && !empty($consumersecretapikey) ){

               //$this->update_twitter();

         $user_exist = DB::select( DB::raw("SELECT * FROM userssocial_credentials WHERE user_id = '$user_id' and social_webname = '$social_webname' ") ); 

                return view('twitter_credential_update')->with('user_exist',$user_exist);

            }else{

                 return view('twitter_credential');
            }

        }

    }


    public function connect_to_twitter(Request $request){

        $rules = array(
            'accesstoken' => 'required',
            'accesstokensecret' => 'required',
            'consumerkeyapikey' => 'required',
            'consumersecretapikey' => 'required'

        );

         //login user
        $user = User::findOrFail(Auth::user()->id);

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }      
        

            $social_webname = 'twitter';
            $accesstoken = $request->accesstoken;
            $accesstokensecret = $request->accesstokensecret;
            $consumerkeyapikey = $request->consumerkeyapikey;
            $consumersecretapikey = $request->consumersecretapikey;
            //$twitterhashtags = $request->twitterhashtags;
            $user_id = $user->id;
            //die();
        //$user_exist = UsersSocialCredentials::where('social_webname', $social_webname)->orWhere('user_id', $user_id)->get();

        $user_exist = DB::select( DB::raw("SELECT * FROM userssocial_credentials WHERE user_id = '$user_id' and social_webname = '$social_webname' ") );  


          if(empty($user_exist)) {
           //"Given Array is empty"; 

        // echo 'user not exist'; //insert      

         $socialCredentials = new UsersSocialCredentials;

         $socialCredentials->social_webname = $social_webname;
         $socialCredentials->accesstoken = $accesstoken;
         $socialCredentials->accesstokensecret = $accesstokensecret;
         $socialCredentials->consumerkeyapikey = $consumerkeyapikey;
         $socialCredentials->consumersecretapikey = $consumersecretapikey;
         //$socialCredentials->twitterhashtags = $twitterhashtags;
         $socialCredentials->user_id = $user_id;
         $socialCredentials->save();   //insert
            

        //return redirect()->back()->with('success_message', trans('user/twitter.successfullyChanged'));

           $user_exist = DB::select( DB::raw("SELECT * FROM userssocial_credentials WHERE user_id = '$user_id' and social_webname = '$social_webname' ") );  

          return view('twitter_credential_update')->with('user_exist',$user_exist)->with('success_message', trans('user/twitter.successfullyChanged'));


            }else{
              
              //print_r("$user_exist"); // user details exist update 
              //die();
                 Session::flash('success_message', "Your Twitter Details is AlreadyExist, Please Update it.");

                 return view('twitter_credential_update')->with('user_exist',$user_exist);

            } 

    }


    public function update_twitter(Request $request){ 

     $rules = array(
            'accesstoken' => 'required',
            'accesstokensecret' => 'required',
            'consumerkeyapikey' => 'required',
            'consumersecretapikey' => 'required',
            'twitter_hashtags' => 'required'

        );

        //login user
        $user = User::findOrFail(Auth::user()->id);

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
            
            $social_webname = 'twitter';
            $accesstoken = $request->accesstoken;
            $accesstokensecret = $request->accesstokensecret;
            $consumerkeyapikey = $request->consumerkeyapikey;
            $consumersecretapikey = $request->consumersecretapikey;
            $twitterhashtags = $request->twitter_hashtags;
            $uid = $request->uid; //id
            $user_id = $request->user_id;
       
       

        $user_exist = DB::select( DB::raw("SELECT * FROM userssocial_credentials WHERE user_id = '$user_id' and social_webname = '$social_webname' ") );

         //$user_exist = UsersSocialCredentials::where('social_webname', $social_webname)->orWhere('user_id', $user_id)->get();

          //print_r($user_exist);   //die();

          if(!empty($user_exist)) {
            
                DB::table('userssocial_credentials')
                ->where('id', $uid)
                ->update([

                    'accesstoken' => $accesstoken,
                     'accesstokensecret' => $accesstokensecret,
                      'consumerkeyapikey' => $consumerkeyapikey,
                       'consumersecretapikey' => $consumersecretapikey,
                         'hashtags' => $twitterhashtags,
                       
                ]);


                
                $user_exist = DB::select( DB::raw("SELECT * FROM userssocial_credentials WHERE user_id = '$user_id' and social_webname = '$social_webname' ") );

                Session::flash('success_message', "Your Twitter Details is updated successfully.");

               //return redirect()->back()->with('user_exist',$user_exist)->with('success_message', trans('user/twitter.successfullyChanged'));

        return view('twitter_credential_update')->with('user_exist',$user_exist)->with('success_message', trans('user/twitter.successfullyChanged'));


            }

            
    } 




   //----------------------- facebook ------------------------------------




    public function connecttofacebook(){

        //login user_details
        $user = User::findOrFail(Auth::user()->id);
        $social_webname = 'facebook';

        if(isset($user) && !empty($user)){

        $user_id = $user->id;//id

        $facebook_data = UsersSocialCredentials::where('social_webname','=',$social_webname)->Where('user_id',$user_id)->first(); //data

         $accesstoken = $facebook_data['app_id'];
         $accesstokensecret = $facebook_data['appsecret'];
         $username = $facebook_data['username'];

        if(!empty($accesstoken) && !empty($accesstokensecret) && !empty($username)){

          //$this->update_facebook();

         $user_exist = DB::select( DB::raw("SELECT * FROM userssocial_credentials WHERE user_id = '$user_id' and social_webname = '$social_webname' ") ); 

                return view('facebook_credential_update')->with('user_exist',$user_exist);

            }else{

                 return view('facebook_credential');
            }
        }


    }



    public function connect_to_facebook(Request $request){

        $rules = array(
            'facebook_appid' => 'required',
            'facebook_appsecret' => 'required',
            'facebook_username' => 'required'
        );

         //login user
        $user = User::findOrFail(Auth::user()->id);

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }      
        

            $social_webname = 'facebook';
            $app_id = $request->facebook_appid;
            $appsecret_id = $request->facebook_appsecret;
            $facebook_username = $request->facebook_username;
            $user_id = $user->id;


       // $user_exist = UsersSocialCredentials::where('social_webname', $social_webname)->orwhere('user_id', $user_id)->exists();

        $user_exist = DB::select( DB::raw("SELECT * FROM userssocial_credentials WHERE user_id = '$user_id' and social_webname = '$social_webname' ") );


          if(empty($user_exist)) {
           //"Given Array is empty"; 
    
              // echo 'user not exist'; //insert      

         $socialCredentials = new UsersSocialCredentials;

         $socialCredentials->social_webname = $social_webname;
         $socialCredentials->app_id = $app_id;
         $socialCredentials->appsecret = $appsecret_id;
         $socialCredentials->username = $facebook_username;
         $socialCredentials->user_id = $user_id;         
         $socialCredentials->save();   //insert
                

            $user_exist = DB::select( DB::raw("SELECT * FROM userssocial_credentials WHERE user_id = '$user_id' and social_webname = '$social_webname' ") );

             return view('facebook_credential_update')->with('user_exist',$user_exist)->with('success_message', trans('user/facebook.successfullyChanged'));


            //return redirect()->back()->with('success_message', trans('user/facebook.successfullyChanged'));

            }else{

                //echo "$user_exist"; // user exist update  + //die();

                Session::flash('success_message', "Your Facebook Details is AlreadyExist, Please Update it.");

                return view('facebook_credential_update')->with('user_exist',$user_exist);

            }

    }






    public function update_facebook(Request $request){ 

     $rules = array(
            'facebook_appid' => 'required',
            'facebook_appsecret' => 'required',
            'facebook_hashtags' => 'required',
            'facebook_username' => 'required'
        );  

        //login user
        $user = User::findOrFail(Auth::user()->id);

        $data = $request->all();

        $validator = Validator::make($data,$rules);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        }
            
            $social_webname = 'facebook';
            $app_id = $request->facebook_appid;
            $app_secret = $request->facebook_appsecret;
            $facebookhashtags = $request->facebook_hashtags;
            $facebook_username = $request->facebook_username;
            $uid = $request->uid; //id
            $user_id = $request->user_id;
    
          
         //$user_exist = UsersSocialCredentials::where('social_webname', $social_webname)->orWhere('user_id', $user_id)->get();

        $user_exist = DB::select( DB::raw("SELECT * FROM userssocial_credentials WHERE user_id = '$user_id' and social_webname = '$social_webname' ") );


              if(!empty($user_exist)) {

              //echo "$user_exist"; // user exist update //die();
            
                DB::table('userssocial_credentials')
                ->where('id', $uid)
                ->update([

                    'app_id' => $app_id,
                     'appsecret' => $app_secret,
                       'hashtags' => $facebookhashtags,
                        'username' => $facebook_username,
                       
                ]);



                $user_exist = DB::select( DB::raw("SELECT * FROM userssocial_credentials WHERE user_id = '$user_id' and social_webname = '$social_webname' ") );

                 Session::flash('success_message', "Your facebook Details is updated successfully.");

                return view('facebook_credential_update')->with('user_exist',$user_exist)->with('success_message', trans('user/facebook.successfullyChanged'));

                 //return redirect()->back()->with('success_message', trans('user/facebook.successfullyChanged'));

            }

            
    } 




   //---------------------  Instagram ------------------------------------



    public function connecttoinstagram(){

        //login user_details
        $user = User::findOrFail(Auth::user()->id);
        $social_webname = 'instagram';

        if(isset($user) && !empty($user)){

        $user_id = $user->id;//id

        $instagram_data = UsersSocialCredentials::where('social_webname','=',$social_webname)->Where('user_id',$user_id)->first(); //data

            $accesstoken = $instagram_data['accesstoken'];
            $accesstokensecret = $instagram_data['accesstokensecret'];

          if(!empty($accesstoken) && !empty($accesstokensecret) ){

          //$this->update_instagram();  

          $user_exist = DB::select( DB::raw("SELECT * FROM userssocial_credentials WHERE user_id = '$user_id' and social_webname = '$social_webname' ") ); 

            return view('instagram_credential_update')->with('user_exist',$user_exist);

        }else{

                 return view('instagram_credential');
            }

       }


    }
      

    public function connect_to_instagram(Request $request){

        $rules = array(
            'accesstoken' => 'required', // CLIENT ID
            'accesstokensecret' => 'required'  // CLIENT SECRET ID


        );

         //login user
        $user = User::findOrFail(Auth::user()->id);

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }      
        

            $social_webname = 'instagram';
            $accesstoken = $request->accesstoken;  // CLIENT ID
            $accesstokensecret = $request->accesstokensecret;  // CLIENT SECRET ID
            $user_id = $user->id;

        $user_exist = DB::select( DB::raw("SELECT * FROM userssocial_credentials WHERE user_id = '$user_id' and social_webname = '$social_webname' ") );  


          if(empty($user_exist)) {
           //"Given Array is empty"; 

        // echo 'user not exist'; //insert      

         $socialCredentials = new UsersSocialCredentials;

         $socialCredentials->social_webname = $social_webname;
         $socialCredentials->accesstoken = $accesstoken;  // CLIENT  ID
         $socialCredentials->accesstokensecret = $accesstokensecret; // CLIENT SECRET ID
         $socialCredentials->user_id = $user_id;
         $socialCredentials->save();   //insert
            

         $user_exist = DB::select( DB::raw("SELECT * FROM userssocial_credentials WHERE user_id = '$user_id' and social_webname = '$social_webname' ") );  

        //return redirect()->back()->with('success_message', trans('user/instagram.successfullyChanged'));

         return view('instagram_credential_update')->with('user_exist',$user_exist)->with('success_message', trans('user/instagram.successfullyChanged'));


            }else{

                //echo "$user_exist"; // user details exist update 
            
                Session::flash('success_message', "Your Instagram Details is AlreadyExist, Please Update it.");

                return view('instagram_credential_update')->with('user_exist',$user_exist);

            }

    }  



    public function update_instagram(Request $request){ 

     $rules = array(
            'accesstoken' => 'required',  // CLIENT ID
            'accesstokensecret' => 'required', // CLIENT SECRET ID
            'instagram_hashtags' => 'required' // CLIENT SECRET ID
        );

        //login user
        $user = User::findOrFail(Auth::user()->id);

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
            
            $social_webname = 'instagram';
            $accesstoken = $request->accesstoken;  // CLIENT ID
            $accesstokensecret = $request->accesstokensecret; // CLIENT SECRET ID
            $instagram_hashtags = $request->instagram_hashtags; //hashtags
            $uid = $request->uid; //id
            $user_id = $request->user_id;
    

        $user_exist = DB::select( DB::raw("SELECT * FROM userssocial_credentials WHERE user_id = '$user_id' and social_webname = '$social_webname' ") );


              if(!empty($user_exist)) {

              //echo "$user_exist"; // user exist update //die();
            
                DB::table('userssocial_credentials')
                ->where('id', $uid)
                ->update([

                    'accesstoken' => $accesstoken, //CLIENT ID
                     'accesstokensecret' => $accesstokensecret, //CLIENT SECRET ID
                      'hashtags' => $instagram_hashtags,  //hashtags
                       
                ]);


                 //return redirect()->back()->with('success_message', trans('user/instagram.successfullyChanged'));

                $user_exist = DB::select( DB::raw("SELECT * FROM userssocial_credentials WHERE user_id = '$user_id' and social_webname = '$social_webname' ") );


                Session::flash('success_message', "Your Instagram Details Update successfully.");

                return view('instagram_credential_update')->with('user_exist',$user_exist)->with('success_message', trans('user/instagram.successfullyChanged'));


            }

            
    } 



 



   //--------------------- Start Twitter Feeds GEt's -------------------------------



  public function twitter_feeds(Request $request){ 

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


                $url = 'https://api.twitter.com/1.1/search/tweets.json';
                $getfield = '?q='.$hashtags.'&count=50'; //30hashtag post defined
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
                      $getfield = '?q='.$hashtag_search.'&count=50'.$next_results; 
                      $requestMethod = 'GET';
                      $twitter = new TwitterAPIExchange($settings);
                      $tweest = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
                      $tweets_next_page = json_decode($tweest, true);

                      //$next_results = $tweets_next_page['search_metadata']['next_results'];
                        //die();

                 }

                  


                Session::flash('success_message', "Your Instagram Details Found");

                return view('twitter_feeds')->with('tweets',$tweets)->with('tweets_next_page',$tweets_next_page);



      }else{

      //data empty
        Session::flash('success_message', "Details Not Found, Please Update Tokens");

      return redirect()->back()->with('success_message', trans('user/twitter.UserNotFound'));


      }



  }


  //--------------------- Start Instagram Feeds GEt's ----------------------------


    
 public function instagram_feeds(Request $request){  



        //https://www.instagram.com/kumarrishikesh12/?__a=1     //user_profile
        //https://www.instagram.com/explore/tags/dhoni/?__a=1  //HashTags_Profile
        //https://www.instagram.com/explore/tags/india/?hl=en  //View

         //login user
         $user = User::findOrFail(Auth::user()->id);
         $user_id = $user->id; //get login user id
         $social_webname = 'instagram';  // Social webname
         $link = env('APP_URL').'/laravel-admin/instagram_feeds';  //http://localhost/laravel-admin/instagram_feeds
        
         $instagram_data = UsersSocialCredentials::where('social_webname','=',$social_webname)->Where('user_id',$user_id)->first();

         if(isset($instagram_data) && !empty($instagram_data) && !empty($instagram_data['accesstoken']) && !empty($instagram_data['accesstokensecret']) ){ //if data found
         
         $client_id = $instagram_data['accesstoken'];
         $client_secret = $instagram_data['accesstokensecret'];
         $hashtags = $instagram_data['hashtags'];
         $hashtags = str_replace('#', '', $hashtags);
         

         
         $access_token_url = 'http://instagram.com/oauth/authorize/?client_id='.$client_id.'&redirect_uri='.$link.'&response_type=token';
         

         $tags_json_link = "https://www.instagram.com/explore/tags/".$hashtags."/?__a=1";
        
         //$tags_json_link = "https://www.instagram.com/explore/tags/india/?__a=1"; //&page=10

         $arrContextOptions=array(
            "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
           ),
         ); 


        $instas = file_get_contents($tags_json_link, false, stream_context_create($arrContextOptions));
          //dd($instas);
          //echo "<pre>";
          //print_r($instas);
          //die();

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

         //print_r($last_page); // exist_next_page: 1 = true , end_cursor: token_next_page   

  }

}
        /* if Next Page Exist then get the end_Cursor for that and data  */
        $next_page_end_cursor = $next_page['end_cursor'];
        $exist_next_page = $next_page['exist_next_page'];
        //die();


   return view('instagram_feeds')->with('instas',$instas)->with('insta_array',$insta_array)->with('next_page',$next_page)->with('tags_json_link',$tags_json_link);

     
  }//if closed instagram_data

else{//else Part  


 if($instagram_data['accesstoken'] === NULL && $instagram_data['accesstokensecret'] === NULL ){
            
            //if don't get access_token from database then redirect without data
            //echo "if don't get access_token from database then redirect without data";
            
            return view('instagram_feeds')->with('instagram_data',$instagram_data);
         }

 
     } //end else

    //return view('instagram_feeds')->with('instas',$instas)->with('next_url_api',$next_url_api);
 

}// function closed





   //--------------------- Start Facebook Feeds GEt's -----------------------------------

    //https://www.sammyk.me/access-token-handling-best-practices-in-facebook-php-sdk-v4


  public function facebook_feeds(Request $request){ 

        #Follow This Steps to Get App_id and App_Secret with Public Data Access Permission   
        //https://www.codexworld.com/create-facebook-app-id-app-secret/
       

         //login user
         $user = User::findOrFail(Auth::user()->id);
         $user_id = $user->id; //get login user id
         $social_webname = 'facebook';  // Social webname
         //$link = env('APP_URL').'/laravel-admin/facebook_feeds';  //http://localhost/laravel-admin/facebook_feeds


    $facebook_data = UsersSocialCredentials::where('social_webname','=',$social_webname)->Where('user_id',$user_id)->first();

    if(isset($facebook_data) && !empty($facebook_data)  &&  !empty($facebook_data['app_id']) && !empty($facebook_data['appsecret']) ){ //if data found


         $client_id = $facebook_data['app_id'];
         $client_secret = $facebook_data['appsecret'];
         
         
          $access_token_url = 'https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id='.$client_id.'&client_secret='.$client_secret;

         //$authToken = file_get_contents("https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id={$app_id}&client_secret={$app_secret}");


         $arrContextOptions=array(
            "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
          ),
        
         ); 

         //access_token and token_type: bearer  

         //$authToken = file_get_contents("https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id={$app_id}&client_secret={$app_secret}");


    

            try {

                $authToken = file_get_contents($access_token_url, true, stream_context_create($arrContextOptions));

                 //throw new Exception($authToken); 
             }

             //catch exception
             catch(Exception $e) {            
              //echo 'Message: ' .$e->getMessage();
              Session::flash('error_message', "Invalid Facebook App_ID Or App_Secret");
              return view('facebook_feeds')->with('success_message', trans('user/facebook.Wrong_App_Details'));

             }

 

           //$authToken = file_get_contents($access_token_url, false, stream_context_create($arrContextOptions));

            
           $access_token = http_build_query(json_decode($authToken));
           //access_token=606343186475644%7COBsiJBsp8lm_mtSj63o34UL_4kA&token_type=bearer



          $authToken = json_decode($authToken, true);
          $appid_apptoken =  $authToken['access_token']; //App_ID OR Client_ID | Get_App_token            
          $arr = (explode("|",$appid_apptoken));
          $app_id = $arr[0]; //App_ID OR Client_ID
          $app_access_token = $arr[1]; //Get_App_token  


         if (!empty($app_access_token)) {  //app_access_token_exist


        //Save App_Access_token in db
         
         DB::table('userssocial_credentials')
                ->where('user_id', $user_id)
                ->where('social_webname',$social_webname)
                ->update([

                    'accesstoken' => $app_access_token, //facebook_App_access_token 
                    
                       
                ]);
    
    $facebook_data = UsersSocialCredentials::where('social_webname','=',$social_webname)->Where('user_id',$user_id)->first();

            $app_id = $facebook_data['app_id'];
            $app_secret =  $facebook_data['appsecret'];
            $app_access_token =  $facebook_data['accesstoken'];
            $hashtags = $facebook_data['hashtags']; 
            $username = $facebook_data['username']; 
        
            //https://www.facebook.com/hashtag/india       
            //die();


              //try catch to check username is valid or not

              try{

              $options  = array('http' => array('user_agent' => 'some_obscure_browser'));
              $context  = stream_context_create($options);
              $fbsite = file_get_contents('https://www.facebook.com/' . $username, false, $context);

              }catch(Exception $e) {            
              //echo 'Message: ' .$e->getMessage();
            Session::flash('error_message', "Invalid Facebook App_ID Or App_Secret");
             
              return view('facebook_feeds')->withError('success_message', trans('user/facebook.Wrong_Username_Details'));

             }






              $fbIDPattern = '/\"entity_id\":\"(\d+)\"/';
              if (!preg_match($fbIDPattern, $fbsite, $matches)) {
               throw new Exception('Unofficial API is broken or user not found');
             }

                //convert to facebook Number_id
                $username_id = $matches[1];
               //$username_id = 'ayushmannkhurrana'; //792517837455295




//$json_object = file_get_contents("https://graph.facebook.com/{$username_id}/feed?".http_build_query(json_decode($facebook_data['accesstoken']))."&summary=1&fields=full_picture,message,link,name,likes,comments,description,from,caption,attachments,created_time&limit=20");

//$json_object = file_get_contents("https://graph.facebook.com/{$username_id}/?fields=id,name,first_name,last_name,short_name,email";

//$url = "https://graph.facebook.com/v3.2/{$username_id}/?fields=id,name,first_name,last_name,email,about,birthday,location,link,likes,address,hometown,age_range,feed{story_tags,type}&access_token={$access_token}";

//$url = "https://graph.facebook.com/v3.2/{$username_id}/?feeds=id,name,first_name,last_name,full_picture&access_token={$access_token}";

//$url = "https://graph.facebook.com/{$username_id}/?fields=name,id&access_token={$access_token}"; 

//$url = "https://graph.facebook.com/{$username_id}/?feeds=name,id&access_token={$access_token}"; 

//$json_object = file_get_contents(""? . http_build_query(json_decode($authToken)) . "&summary=1&fields=full_picture,message,link,name,likes,comments,description,from,caption,attachments,created_time&limit=100");



                 $url = "https://graph.facebook.com/{$username_id}/?{$access_token}&summary=1&fields=id,name,first_name,last_name,email,picture,posts"; 

                //die();

                $json_object = file_get_contents($url, false, stream_context_create($arrContextOptions));

                 $facebook_feeds = json_decode($json_object, true);
                 
                 print_r($facebook_feeds);
                 die();



            
            $fb = new \Facebook\Facebook([
              'app_id' => $app_id,
              'app_secret' => $app_secret,
              'default_graph_version' => 'v3.2',

            ]);
            try {
            $response = $fb->get('/'.$username_id.'/?access_token='.$app_id.'%7C'.$app_access_token.'&token_type=bearer&fields=id,name,first_name,last_name,short_name,name_format,gender,birthday,age_range,email,hometown,location{name},picture{url},link,posts{id,type,name,description,link,full_picture}');

            } catch(Facebook\Exceptions\FacebookResponseException $e) {
              echo 'Graph returned an error: ' . $e->getMessage();
              exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
              echo 'Facebook SDK returned an error: ' . $e->getMessage();
              exit;
            }

             $user = $response->getGraphUser();
             $fb_user_data = json_decode($user, true);
                
             //print_r($fb_user_data);  
             //die('');




             /*
             if (!empty($fb_next_url)){

                if ($fb_next_url == '1'){

                  $facebook_feeds['data'] = [];
                 }else{

                 $json_object = file_get_contents($fb_next_url);
                 $facebook_feeds = json_decode($json_object, true);
                }
             }
             else{

             //$json_object = file_get_contents("https://graph.facebook.com/{$profile_id}/feed"?.http_build_query(json_decode($app_access_token)) . "&summary=1&fields=full_picture,message,link,name,likes,comments,description,from,caption,attachments,created_time&limit=20");
            
             $facebook_feeds = json_decode($json_object, true);
            

             echo $facebook_feeds;
             die();

             }

             */

             //$fb_user_data = 'hello';


             return view('facebook_feeds')->with('fb_user_data',$fb_user_data);



     }//if closed if token found

   }//if closed facebook_data
 
 else{//Main else Part  


        //echo "else part";
        //die();

        $user = User::findOrFail(Auth::user()->id);
        $user_id = $user->id; //get login user id or user_id
        $social_webname = 'facebook';  // Social webname

        $facebook_data = UsersSocialCredentials::where('social_webname','=',$social_webname)->Where('user_id',$user_id)->first();

        if ($facebook_data['accesstoken'] === NULL) {
            
            //if don't get access_token from database then redirect without data
            //echo "if don't get access_token from database then redirect without data";
            
            return view('facebook_feeds')->with('facebook_data',$facebook_data);

        }else{//innere_else

            //if get access_token from database then redirect with feeds

             $access_token = $facebook_data['accesstoken'];

            $app_id = $facebook_data['app_id'];
            $app_secret =  $facebook_data['appsecret'];
            $authToken = file_get_contents("https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id={$app_id}&client_secret={$app_secret}");


            $authToken = json_decode($authToken, true);
            $appid_apptoken =  $authToken['access_token']; //App_id and client_id
            

             $arr = (explode("|",$appid_apptoken));
             $app_id = $arr[0]; //App_id OR CLient_id
             $app_access_token = $arr[1]; // access_token


            $fb = new \Facebook\Facebook([
              'app_id' => $app_id,
              'app_secret' => $app_secret,
              'default_graph_version' => 'v3.2',
              //'default_access_token' => $access_token,

            ]);

             $default_access_token = $access_token;


              try {
            

            $response = $fb->get('/me?fields=id,name,first_name,last_name,short_name,name_format,gender,birthday,age_range,email,hometown,location{name},picture{url},link,posts{id,type,name,description,link,full_picture}',$default_access_token );

            } catch(Facebook\Exceptions\FacebookResponseException $e) {
              echo 'Graph returned an error: ' . $e->getMessage();
              exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
              echo 'Facebook SDK returned an error: ' . $e->getMessage();
              exit;
            }


             $user = $response->getGraphUser();
             $fb_user_data = json_decode($user, true);
 

             $data['fb_data']= $fb_user_data;
        

             return view('facebook_feeds')->with('fb_user_data',$fb_user_data)->withdata($data);



        }//inner_else_close


  } //main_else_part_end

}//funtion_end









//--------------------- Start All In One Hashtags Feeds -----------------------------------



public function all_feeds(Request $request){ 


    return view('all_feeds');

}



    
    
}
