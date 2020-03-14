<?php
require_once '../login/config.php';
require_once '../vendor/autoload.php';
require_once "../chooseTweet.php";
//インポート
use Abraham\TwitterOAuth\TwitterOAuth;

$TwitterAccountInfo = json_decode(file_get_contents('login/'.$accesstoken_filename),true);

$objTwitterConection = new TwitterOAuth
 (
 $sTwitterConsumerKey,
 $sTwitterConsumerSecret,
 $TwitterAccountInfo['twAccessToken']['oauth_token'],
 $TwitterAccountInfo['twAccessToken']['oauth_token_secret']
 );

 $objTwitterConection2 = new TwitterOAuth
 (
 $sTwitterConsumerKey,
 $sTwitterConsumerSecret);

 $str = chooseTweet($objTwitterConection,$objTwitterConection2,"",false,false);
$arr = array(
    'fulfillment_text' => $str
);
header("Content-Type: application/json; charset=utf-8");



echo json_encode($arr);