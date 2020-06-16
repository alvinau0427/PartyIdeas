<?php

	require_once('facebook-sdk-v5/src/Facebook/autoload.php');

	$fb = new Facebook\Facebook([
	  'app_id' => '1751077158504743',//app_id 要改埋login-callback.php個app id
	  'app_secret' => '83849533e7b368d6c905baaf5b5013f1',//app_安全碼
	  'default_graph_version' => 'v2.7',//預設版本
	  ]);

	$helper = $fb->getRedirectLoginHelper();

?>