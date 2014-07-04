<?php
echo '<html><head></head><body>';

$path_to_library = 'facebook_connect/';
include($path_to_library.'include/webzone.php');

$f1 = new Facebook_class();
$f1->loadJsSDK($path_to_library);

$fb_cookie = $f1->getCookie();

if($fb_cookie!='') {
	
	$user_data = $f1->getUserData();
	$fb_profile_picture = $f1->getProfilePicture();
	$fb_link = $user_data->link;
	$fb_userid = $f1->getUserid();
	$fb_full_name = $user_data->name;
	
	echo '<p>';
	echo '<img src="'.$fb_profile_picture.'" width=36 style="padding-right:10px; vertical-align:middle;">';
	echo '<a href="javascript:" onclick="logoutFacebookUser()">Disconnect my Facebook account</a>';
	echo '</p>';
	
	echo '<br>';
	
	//display user's information
	echo '<h3>My Facebook information</h3>';
	echo '<p>';
	echo '<b>My name</b>: '.$fb_full_name.'<br>';
	echo '<b>My email</b>: '.$user_data->email.'<br>';
	echo '<b>My profile URL</b>: <a href="'.$fb_link.'" target="_blank">'.$fb_link.'</a><br>';
	echo '<b>My Access token</b>: <input type="text" value="'.$fb_cookie['access_token'].'" style="width:340px;"><br>';
	echo '<b>My token expiration</b>: '.$fb_cookie['expires'].'<br>';
	echo '<b>My Facebook id</b>: '.$fb_userid;
	echo '</p>';
	
	//display user's friends
	$fb_friends = $f1->getFacebookFriends();
	echo '<h3>My Facebook friends <small>(limited to 40 in this example)</small></h3>';
	$fb_friends_display = $f1->displayUsersIcons(array('users'=>$fb_friends, 'nb_display'=>40));
	echo $fb_friends_display.'<br><br>';
	
	//display user's pages or applications
	echo '<h3>My Facebook pages and/or applications</h3>';
	echo '<p>';
	$fb_accounts = $f1->getFacebookAccounts();
	for($i=0; $i<count($fb_accounts['data']); $i++) {
		echo $fb_accounts['data'][$i]['name'].' - ';
	}
	echo '</p>';
	
	//user's last status
	echo '<h3>My last Facebook status</h3>';
	echo '<p>';
	$fb_status = $f1->getFacebookFeeds();
	echo $fb_status[0]['message'].'<br>';
	echo '<small>'.$fb_status[0]['created'].'</small>';
	echo '</p>';
	
	//update status
	echo '<form method=get action="'.$path_to_library.'connect.php">';
	echo '<h3><b>Update my Facebook status</b></h3>';
	echo '<p><textarea id="status" name="status" rows=3 cols=60></textarea><br>';
	echo '<input type="submit" value=" Update status ">';
	echo '</p></form>';
}

else {
	echo '<h3>Please click on the link bellow to connect with your Facebook account</h3>';
	echo '<p>';
	$f1->displayLoginButton();
	echo '</p>';
}

echo '</body></html>';
?>