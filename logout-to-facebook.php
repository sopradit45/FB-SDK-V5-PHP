<?php

session_start();
require_once __DIR__ . '/src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '740357906069989',
  'app_secret' => '85be710ace9ac4e630fdcff56e51bdbd',
  'default_graph_version' => 'v2.4',
  ]);
