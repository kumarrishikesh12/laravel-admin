<?php


$url= 'https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id=606343186475644&client_secret=aab3203d2fee6c0eb72aece9d986e201';

$arrContextOptions=array(
      "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    );  

$response = file_get_contents($url, false, stream_context_create($arrContextOptions));
echo "<pre>";
print_r($response);



?>




<?php

/*$client_id = '2907a5d9495a437ba75097b2a9414bfd';
$client_secret = 'f3bfbb47b0974c108c0ce0b8247732d8';
$redirect_uri = 'http://localhost/laravel-admin/instagram_feeds';


$url = "http://instagram.com/oauth/authorize/?client_id=2907a5d9495a437ba75097b2a9414bfd&redirect_uri=http://localhost/laravel-admin/instagram_feeds&response_type=token";

$data = array(
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'redirect_uri' => $redirect_uri
     //'code' => $authorization_code
 );
$options = array(
    'http' => array(
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($data)
    )
);

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
print_r($result);*/

?>