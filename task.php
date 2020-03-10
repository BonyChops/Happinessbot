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

//$objTwUserInfo = $objTwitterConection->post("statuses/update",["status" => "Hello, world!"]);
var_dump($objTwUserInfo);

$words = [
    "おいし","美味し","眠いな","いい天気"
];
$cntWord = $words[rand(0,sizeof($words)-1)];

$searchResult = $objTwitterConection->get("search/tweets",["q" => $cntWord]);
var_dump($searchResult['statuses'][0]);
    
