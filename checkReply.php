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
$json = json_decode(file_get_contents("login/Id.js"),true);
if($json['minId'] == null){
    $minId = 0;
}else{
    $minId = $json['minId'];
}

$cntMinId = -1;
$idsStr = "";
$searchResult = $objTwitterConection->get("statuses/mentions_timeline",["count" => 100,]);
var_dump($searchResult);


foreach($searchResult as $value){
    printf($value->{"user"}->{"screen_name"}."\n");
    if($value->{"user"}->{"screen_name"} != $botname){
        if($value->{"id"} > $minId){
            $str = chooseTweet($objTwitterConection,$objTwitterConection2,"",false);
            $likeResult = $objTwitterConection->post("favorites/create",["id" => $value->{"id"}]);
            $objTwUserInfo = $objTwitterConection->post("statuses/update",["status" => $str, "in_reply_to_status_id" => $value->{"id"},"auto_populate_reply_metadata" => true]);
            if($cntMinId < $value->{"id"}){
                $cntMinId = $value->{"id"};
            }
            if ($cntMinId == -1){
                $cntMinId = $value->{"id"};
            }
        }

    }
}


if($cntMinId != -1){
    $json['minId'] = $cntMinId;
    file_put_contents("login/Id.js",json_encode($json));
}

