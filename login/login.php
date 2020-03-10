<?php
session_start();
 
//インクルード
require_once 'config.php';
require_once '../vendor/autoload.php';
 
//インポート
use Abraham\TwitterOAuth\TwitterOAuth;

$objTwitterConection = new TwitterOAuth($sTwitterConsumerKey, $sTwitterConsumerSecret);
 
$aTwitterRequestToken = $objTwitterConection->oauth('oauth/request_token', array('oauth_callback' => $sTwitterCallBackUri));

$_SESSION['twOauthToken'] = $aTwitterRequestToken['oauth_token'];
$_SESSION['twOauthTokenSecret'] = $aTwitterRequestToken['oauth_token_secret'];

$sTwitterRequestUrl = $objTwitterConection->url('oauth/authenticate', array('oauth_token' => $_SESSION['twOauthToken']));

header('location: '.$sTwitterRequestUrl);
?>