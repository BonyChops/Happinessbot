<?php
 
//インクルード
require_once 'login/config.php';
require_once 'vendor/autoload.php';
 
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


//$objTwUserInfo = $objTwitterConection->post("statuses/update",["status" => "Hello, world!"]);
require_once("chooseTweet.php");
$str = chooseTweet($objTwitterConection,$objTwitterConection2,"",false);
$objTwUserInfo = $objTwitterConection->post("statuses/update",["status" => $str]);
$statuses = json_decode(file_get_contents("words/statuses.js",true));
if($statuses == ""){
    $statuses = array();
}
$statusInfo = ["str" => $str,"id" => $objTwUserInfo->{"id"}];
array_push($statuses,$statusInfo);
file_put_contents("words/statuses.js",json_encode($statuses));