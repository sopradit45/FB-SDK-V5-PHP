<?php

session_start();
require_once __DIR__ . '/src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '740357906069989',
  'app_secret' => '85be710ace9ac4e630fdcff56e51bdbd',
  'default_graph_version' => 'v2.4',
  ]);

$helper = $fb->getCanvasHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if ( isset($accessToken)) {
echo '<h3>Signed Request</h3>';
var_dump($helper->getSignedRequest());
echo '<h3>Access Token</h3>';
var_dump($helper->getAccessToken());
  echo 'No OAuth data could be obtained from the signed request. User has not authorized your app yet.';
  exit;
}
// Logged in
echo '<h3>Signed Request</h3>';
var_dump($helper->getSignedRequest());

echo '<h3>Access Token</h3>';
var_dump($accessToken->getValue());