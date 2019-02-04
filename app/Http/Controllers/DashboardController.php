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


    public function connecttotwitter(Request $request)
    {
        return view('twitter_credential');
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
            

            return redirect()->back()->with('success_message', trans('user/twitter.successfullyChanged'));

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


                //Session::flash('success_message', "Your Twitter Details is updated successfully.");


                 return redirect()->back()->with('success_message', trans('user/twitter.successfullyChanged'));

            //return view('twitter_credential_update')->with('user_exist',$user_exist);


            }

            
    } 




   //----------------------- facebook ------------------------------------




    public function connecttofacebook(){

        return view('facebook_credential');
    }



    public function connect_to_facebook(Request $request){

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
        

            $social_webname = 'facebook';
            $accesstoken = $request->accesstoken;
            $accesstokensecret = $request->accesstokensecret;
            $consumerkeyapikey = $request->consumerkeyapikey;
            $consumersecretapikey = $request->consumersecretapikey;
            $user_id = $user->id;


       // $user_exist = UsersSocialCredentials::where('social_webname', $social_webname)->orwhere('user_id', $user_id)->exists();

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
         $socialCredentials->user_id = $user_id;
         $socialCredentials->save();   //insert
            

            return redirect()->back()->with('success_message', trans('user/facebook.successfullyChanged'));

            }else{

                //echo "$user_exist"; // user exist update  + //die();

                Session::flash('success_message', "Your Facebook Details is AlreadyExist, Please Update it.");

                return view('facebook_credential_update')->with('user_exist',$user_exist);

            }

    }






    public function update_facebook(Request $request){ 

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
            
            $social_webname = 'facebook';
            $accesstoken = $request->accesstoken;
            $accesstokensecret = $request->accesstokensecret;
            $consumerkeyapikey = $request->consumerkeyapikey;
            $consumersecretapikey = $request->consumersecretapikey;
            $uid = $request->uid; //id
            $user_id = $request->user_id;
    
          
         //$user_exist = UsersSocialCredentials::where('social_webname', $social_webname)->orWhere('user_id', $user_id)->get();

        $user_exist = DB::select( DB::raw("SELECT * FROM userssocial_credentials WHERE user_id = '$user_id' and social_webname = '$social_webname' ") );


              if(!empty($user_exist)) {

              //echo "$user_exist"; // user exist update //die();
            
                DB::table('userssocial_credentials')
                ->where('id', $uid)
                ->update([

                    'accesstoken' => $accesstoken,
                     'accesstokensecret' => $accesstokensecret,
                      'consumerkeyapikey' => $consumerkeyapikey,
                       'consumersecretapikey' => $consumersecretapikey,
                       
                ]);



                 return redirect()->back()->with('success_message', trans('user/twitter.successfullyChanged'));

            }

            
    } 




   //---------------------  Instagram ------------------------------------



    public function connecttoinstagram()
    {
        return view('instagram_credential');
    }
      

    public function connect_to_instagram(Request $request){

        $rules = array(
            'accesstoken' => 'required', // CLIENT ID
            'accesstokensecret' => 'required'  // CLIENT SECRET ID
            //'consumerkeyapikey' => 'required',
            //'consumersecretapikey' => 'required'

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
            //$consumerkeyapikey = $request->consumerkeyapikey;
            //$consumersecretapikey = $request->consumersecretapikey;
            $user_id = $user->id;

        $user_exist = DB::select( DB::raw("SELECT * FROM userssocial_credentials WHERE user_id = '$user_id' and social_webname = '$social_webname' ") );  


          if(empty($user_exist)) {
           //"Given Array is empty"; 

        // echo 'user not exist'; //insert      

         $socialCredentials = new UsersSocialCredentials;

         $socialCredentials->social_webname = $social_webname;
         $socialCredentials->accesstoken = $accesstoken;  // CLIENT  ID
         $socialCredentials->accesstokensecret = $accesstokensecret; // CLIENT SECRET ID
         //$socialCredentials->consumerkeyapikey = $consumerkeyapikey;
         //$socialCredentials->consumersecretapikey = $consumersecretapikey;
         $socialCredentials->user_id = $user_id;
         $socialCredentials->save();   //insert
            

            return redirect()->back()->with('success_message', trans('user/instagram.successfullyChanged'));

            }else{

                //echo "$user_exist"; // user details exist update 
            
                Session::flash('success_message', "Your Instagram Details is AlreadyExist, Please Update it.");

                return view('instagram_credential_update')->with('user_exist',$user_exist);

            }

    }  



    public function update_instagram(Request $request){ 

     $rules = array(
            'accesstoken' => 'required',  // CLIENT ID
            'accesstokensecret' => 'required' // CLIENT SECRET ID
            //'consumerkeyapikey' => 'required',
            //'consumersecretapikey' => 'required'

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
            //$consumerkeyapikey = $request->consumerkeyapikey;
            //$consumersecretapikey = $request->consumersecretapikey;
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
                      //'consumerkeyapikey' => $consumerkeyapikey,
                      //'consumersecretapikey' => $consumersecretapikey,
                       
                ]);



                 return redirect()->back()->with('success_message', trans('user/instagram.successfullyChanged'));

            }

            
    } 











   //--------------------- Start Twitter Feeds GEt's -------------------------------



  public function twitter_feeds(Request $request){ 

        //login user
        $user = User::findOrFail(Auth::user()->id);
        $user_id = $user->id; //get login user id
        $social_webname = 'twitter';  // Social webname
        

         $user_hashtags = DB::select( DB::raw("SELECT hashtags FROM userssocial_credentials WHERE user_id = '$user->id' and social_webname = '$social_webname' ") );

          $hashtags_data = $user_hashtags['0']->hashtags; 

         if(!empty($hashtags_data)){

            $hashtag_search = $hashtags_data; // My Search Tag Add Dynamic Here

         }else{
            $hashtag_search = '';
         }


        
     
     $user_exist = DB::select( DB::raw("SELECT * FROM userssocial_credentials WHERE user_id = '$user->id' and social_webname = '$social_webname' ") );

       //$myJSON = json_encode($user_exist);
       //echo $myJSON;
       //die();

      include(app_path()."/TwitterAPIExchange.php");

      if(!empty($user_exist)) { 
        //data exist

            $tw_next_url ='';

            $settings = array(
                'oauth_access_token' => "3413713334-uROrvdJT6kwD347za6YXtPS36HzF1zgSRhOTcnJ",
                'oauth_access_token_secret' => "diDI8DdvES7ZtoCQvaOwzoar8ck26cVyVuf6Ec0KlQ6ra",
                'consumer_key' => "6b04ZSegdWhBBh8x37itrnZ51",
                'consumer_secret' => "flpga2v8VbU2UDejAB00s3SVM9YvpLHQ20SWC36z1EVcww7eXP"
            );

             // $url = 'https://api.twitter.com/1.1/search/tweets.json';
                $url = 'https://api.twitter.com/1.1/search/tweets.json';

                $getfield = '?q='.$hashtag_search.'&count=30'; 
                                //30hashtag post defined
          
            
                $requestMethod = 'GET';
                $twitter = new TwitterAPIExchange($settings);
                //$tweest = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();


                $tweest = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
               

                 $tweets = json_decode($tweest, true);
                 
 
                Session::flash('success_message', "Your Instagram Details Found");

                return view('twitter_feeds')->with('tweets',$tweets);



      }else{

      //data empty
        Session::flash('success_message', "Details Not Found, Please Update Tokens");

      return redirect()->back()->with('success_message', trans('user/twitter.UserNotFound'));


      }



  }


  //--------------------- Start Instagram Feeds GEt's ----------------------------




  public function instagram_feeds(Request $request){  


    //http://instagram.com/oauth/authorize/?client_id=2907a5d9495a437ba75097b2a9414bfd&redirect_uri=http://localhost/laravel-admin/twitter_feeds&response_type=token

    //http://instagram.com/oauth/authorize/?client_id=YOURCLIENTIDHERE&redirect_uri=HTTP://YOURREDIRECTURLHERE.COM&response_type=token


    // Redirect URl //Localhost
     $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; 


     $client_id  = '2907a5d9495a437ba75097b2a9414bfd';
     $client_secret_id  = 'f3bfbb47b0974c108c0ce0b8247732d8';

      $access_token_gen = 'http://instagram.com/oauth/authorize/?client_id='.$client_id.'&redirect_uri='.$link.'&response_type=token'; 
    

     //$access_token = file_get_contents($access_token_gen);
    

    //http://localhost/laravel-admin/twitter_feeds#access_token=1942978854.2907a5d.70172592a0ff4d85bde6542405843b9d


      $photo_count = 10; 
      $access_token = '1942978854.2907a5d.5986445cf4574831a2bdd53e14025d3e';
      $json_link = "https://api.instagram.com/v1/users/self/media/recent/?";
      $json_link.= "access_token={$access_token}&count={$photo_count}&max_id";


      $json = file_get_contents($json_link);

      $instas = json_decode($json, true);

      //die('');

     foreach ($instas['pagination'] as $page) {
       
        //print_r($page);   //['next_max_id'];  //['next_url'];

      $next_max_id_data = explode('https://',trim($page));
      //$next_max_id =  $next_max_id_data[0]; 

      preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $page, $match);


        if (!empty($match)) {

            $next_url_api = implode(" ",$match[0]);  //url

                if(!empty($next_url_api)){

                  $json = file_get_contents($next_url_api);
                  $next_url_api = json_decode($json, true);

                }else{

                    $json = "No More Data Found !!";

                }


        }


        if (!empty($next_max_id_data)) {

           $next_max_id =  $next_max_id_data[0]; 

        }

      }


         //$next_url_api
        //echo $next_url_api;
        //die('');

      //instagram pagination link



        Session::flash('success_message', "Your Instagram Details Found");

        return view('instagram_feeds')->with('instas',$instas)->with('next_url_api',$next_url_api);


  }




   //--------------------- Start Facebook Feeds GEt's -----------------------------------


  public function facebook_feeds(Request $request){ 


            $profile_id = '100004914815943';
            $app_id = "606343186475644";
            $app_secret = "aab3203d2fee6c0eb72aece9d986e201";
            //$authToken = file_get_contents("https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id={$app_id}&client_secret={$app_secret}");

            //$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; 
  

             //$authToken = "https://graph.facebook.com/oauth/access_token?client_id=".$app_id."&redirect_uri=".$link."&client_secret=".$app_secret;


            //Access Token FB
            //$authToken ="EAAInd0Y96nwBAMvOpLIOokrilyETbZAQ7RzhlS4vZCZBp2aP3LtCZAws2d6SLCoKsrne1kTplPxltOupUXV41qrB7vtqtVUoVZAZAWZB3lg2EewIDwhVousvyqVb4Kaw2r9FSH6V4ZCshUkuxfq7s1iynWGcexgwB8crwNXwT9My4AZDZD";


            //echo require_once __DIR__ . '/vendor/autoload.php'; // change path as needed

            $fb = new \Facebook\Facebook([
              'app_id' => $app_id,
              'app_secret' => $app_secret,
              'default_graph_version' => 'v3.2',
             // 'default_access_token' => 'EAAInd0Y96nwBAMvOpLIOokrilyETbZAQ7RzhlS4vZCZBp2aP3LtCZAws2d6SLCoKsrne1kTplPxltOupUXV41qrB7vtqtVUoVZAZAWZB3lg2EewIDwhVousvyqVb4Kaw2r9FSH6V4ZCshUkuxfq7s1iynWGcexgwB8crwNXwT9My4AZDZD', // optional
            ]);

             $default_access_token = 'EAAInd0Y96nwBAMvOpLIOokrilyETbZAQ7RzhlS4vZCZBp2aP3LtCZAws2d6SLCoKsrne1kTplPxltOupUXV41qrB7vtqtVUoVZAZAWZB3lg2EewIDwhVousvyqVb4Kaw2r9FSH6V4ZCshUkuxfq7s1iynWGcexgwB8crwNXwT9My4AZDZD';


            try {
              // Returns a `Facebook\FacebookResponse` object
             // $response = $fb->get('/me?fields=id,name', $default_access_token);

                 $response = $fb->get('/me?fields=id,first_name,last_name,name,email', $default_access_token);

            } catch(Facebook\Exceptions\FacebookResponseException $e) {
              echo 'Graph returned an error: ' . $e->getMessage();
              exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
              echo 'Facebook SDK returned an error: ' . $e->getMessage();
              exit;
            }


            echo $user = $response->getGraphUser();

            //echo 'Name: ' . $user['name'];
            // OR
            // echo 'Name: ' . $user->getName();



            die();

            /*
            
            if (!empty($fb_next_url))
            {
                if ($fb_next_url == '1')
                {
                    $facebook_feeds['data'] = [];
                }
                else
                {
                    $json_object = file_get_contents($fb_next_url);
                    $facebook_feeds = json_decode($json_object, true);
                }
            }
            else
            {
                $json_object = file_get_contents("https://graph.facebook.com/{$profile_id}/feed"? . http_build_query(json_decode($authToken)) . "&summary=1&fields=full_picture,message,link,name,likes,comments,description,from,caption,attachments,created_time&limit=100");
                $facebook_feeds = json_decode($json_object, true);
            } 

            */
  
     return view('facebook_feeds');

  }







//-------------------------- Login With Social_Site ----------------------------------------


  public function social_login(Request $request){  

     return view('social_login');

  }







    
    
}
