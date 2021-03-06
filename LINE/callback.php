<?php
require_once '../vendor/autoload.php';
require_once 'accesstoken.php';
require_once '../login/config.php';
require_once "../chooseTweet.php";
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

//ユーザーからのメッセージ取得
$json_string = file_get_contents('php://input');
$json_object = json_decode($json_string);
 
//取得データ
$replyToken = $json_object->{"events"}[0]->{"replyToken"};        //返信用トークン
$userId =  $json_object->{"events"}[0]->{"source"}->{"userId"};
$sourceType =  $json_object->{"events"}[0]->{"source"}->{"type"};
$sendType = $json_object->{"events"}[0]->{"type"}; 
$message_type = $json_object->{"events"}[0]->{"message"}->{"type"};    //メッセージタイプ
if ($message_type == "text"){
    $message_text = $json_object->{"events"}[0]->{"message"}->{"text"};    //メッセージ内容
}
$recieve_data = $json_object->{"events"}[0]->{"postback"}->{"data"};


if((($sourceType != "group")&&($sourceType != "room"))||(strpos($message_text,"/happy") !== FALSE)){
    $str = chooseTweet($objTwitterConection,$objTwitterConection2,"",false);

    $response_format_text = [[
        "type" => "text",
        "text" => $str
    ]];
    $result = sending_messages($accesstoken, $replyToken, $response_format_text);
}

if((($sourceType != "group")&&($sourceType != "room"))||(strpos($message_text,"/unchi") !== FALSE)){
    $response_format_text = [[
        "type" => "video",
        "originalContentUrl" => "https://bonychops.com/experiment/Happinessbot/LINE/OtowareShimaziro.mp4",
        "previewImageUrl" => "https://kotonova.com/wp-content/uploads/2016/05/ecb4746a9a9e9ca11f60f6e1fcdc3d76-768x432.png"
    ]];
    $result = sending_messages($accesstoken, $replyToken, $response_format_text);
}

if(($sourceType == "group")||($sourceType == "room")){
    if($sendType == "join"){
        $response_format_text = [[
            "type" => "text",
            "text" => "うんちです。/happyで反応するよ。よろしくー"
        ]];
        $result = sending_messages($accesstoken, $replyToken, $response_format_text);
    }
}


//echo $result;
function sending_messages($accessToken, $replyToken, $response_format_text){
    //レスポンスフォーマット
   
 
    //ポストデータ
    $post_data = [
        "replyToken" => $replyToken,
        "messages" => $response_format_text
    ];
 
    //curl実行
    $ch = curl_init("https://api.line.me/v2/bot/message/reply");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charser=UTF-8',
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}