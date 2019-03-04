<?php 

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSLVERSION, 3);

?>


<?php

if(isset($tweest_json) && !empty($tweest_json) && isset($tweets_next_page) && !empty($tweets_next_page)) {

echo $tweest_json;

} 
?>



