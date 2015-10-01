<meta charset="utf-8">
<?php
session_start();
require_once __DIR__ . '/src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '740357906069989',
  'app_secret' => '85be710ace9ac4e630fdcff56e51bdbd',
  'default_graph_version' => 'v2.4',
  ]);

$helper = $fb->getRedirectLoginHelper();
	
try {
	if (isset($_SESSION['facebook_access_token'])) {
		$accessToken = $_SESSION['facebook_access_token'];
	} else {
  		$accessToken = $helper->getAccessToken();
	}
} catch(Facebook\Exceptions\FacebookResponseException $e) {
 	// When Graph returns an error
 	echo 'Graph returned an error: ' . $e->getMessage();
  	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
 	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
  	exit;
 }

 
 
if (isset($accessToken)) {
    
	if(isset($_SESSION['facebook_access_token'])) {
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	} else {
	  	// Logged in!
	  	$_SESSION['facebook_access_token'] = (string) $accessToken;

	  	// OAuth 2.0 client handler
		$oAuth2Client = $fb->getOAuth2Client();

		// Exchanges a short-lived access token for a long-lived one
		$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);

		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}
        

 
        
        
	try {
        $responsePicture = $fb->get('/me/picture?redirect=false&height=300');
	$response = $fb->get('me?fields=email,name');
        $picture = $responsePicture->getGraphUser();
	$userNode = $response->getGraphUser();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	// When Graph returns an error
	echo 'Graph returned an error: ' . $e->getMessage();
	unset($_SESSION['facebook_access_token']);
	exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
	}
	echo "<img src='".$picture['url']."'/>";
	echo '<hr width="300" align="left" > สวัสดีครับ คุณ :  ' . $userNode->getName();
        echo '<hr width="300" align="left" > รหัส ไอดีของคุณ  :  ' . $userNode->getId();
        echo ' <hr width="300" align="left" > อีเมลลืของคุณ :  ' . $userNode->getEmail();
        echo '<hr width="300" align="left" >';

  	// Now you can redirect to another page and use the
  	// access token from $_SESSION['facebook_access_token']
} else {
	$permissions = ['email']; // optional
	$loginUrl = $helper->getLoginUrl('http://localhost/Mycont-fb/login-to-facebook.php', $permissions);

	echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
}

