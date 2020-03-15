<?php
require_once '../vendor/autoload.php';
require_once 'accesstoken.php';
require_once '../login/config.php';
require_once "../chooseTweet.php";
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

$str = chooseTweet($objTwitterConection,$objTwitterConection2,"",false);

$response_format_text = [[
    "type" => "text",
    "text" => $str
]];

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