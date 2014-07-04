<?php

$appId = '435931553218217'; //Replace with your App ID
$appSecret = '94f3f397f1f40e8d115ef9622a405412'; //Replace with your App Secret
$fb_id = '460450763996757'; //Replace with your Facebook ID


# Don't need to edit below this line #
######################################

require 'facebook.php';
$facebook = new Facebook(array(
    'appId' => $appId,
    'secret' => $appSecret,
));

$fbApiGetPosts = $facebook->api('/'.$fb_id.'?fields=feed&date_format=U');

echo json_encode($fbApiGetPosts );

?>