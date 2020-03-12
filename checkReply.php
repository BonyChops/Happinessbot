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
$searchResult = $objTwitterConection->get("search/tweets",["q" => $botname.' filter:replies', "count" => 100,"lang" => "ja", "result_type" => "recent"]);
foreach($searchResult->{"statuses"} as $value){
    if($value->{"id"} > $minId){
        $idsStr = $idsStr.$value->{"id"}.',';
    }
}
$idsStr = substr($idsStr,0,-1);
printf($idsStr);
$tweetInfo = $objTwitterConection2->get("statuses/lookup",["id" => $idsStr]);
foreach($tweetInfo as $value){
    printf($value->{"in_reply_to_screen_name"}."\n");
    if($value->{"in_reply_to_screen_name"} == $botname){
        $str = chooseTweet($objTwitterConection,$objTwitterConection2,"",false);
        $objTwUserInfo = $objTwitterConection->post("statuses/update",["status" => '@'.$value->{"user"}->{"screen_name"}.' '.$str, "in_reply_to_status_id" => $value->{"id"}]);
        if($cntMinId > $value->{"id"}){
            $cntMinId = $value->{"id"};
        }
        if ($cntMinId == -1){
            $cntMinId = $value->{"id"};
        }
    }
}



$json['minId'] = $cntMinId;
file_put_contents("login/Id.js",json_encode($json));
