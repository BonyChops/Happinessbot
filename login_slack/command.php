<?php
$userId = $_GET['user_id'];
require_once '../login/config.php';
require_once '../vendor/autoload.php';
 
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
require_once("../chooseTweet.php");
$str = chooseTweet($objTwitterConection,$objTwitterConection2,"",false,false);


$format = [
    "blocks"=> [
        [
            "type"=> "section",
            "text"=> [
                "type"=> "mrkdwn",
                "text"=> "<@".$userId.">, ".$str
            ]
        ]
    ]
];
echo json_encode($format);