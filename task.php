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
srand(time());
$cntWord = $words[rand(0,sizeof($words)-1)];
printf($cntWord);
$searchResult = $objTwitterConection->get("search/tweets",["q" => $cntWord, "count" => 100]);
//var_dump($searchResult->{"statuses"}[0]);
foreach($searchResult->{"statuses"} as $value){
    if (
        ($value->{"in_reply_to_status_id"} == null)&&
        (strlen($value->{"text"}) <= 80)){
        echo $value->{"text"};
        exit;
    }
}
