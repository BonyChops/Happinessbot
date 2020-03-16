<?php
ini_set('display_errors', "On");
require_once "accesstoken.php";


if (!$_GET["code"]) {
   echo 'エラった';
   exit;
}

// アクセストークン取得
$url = "https://slack.com/api/oauth.access";


$data = array(
    "client_id" => $slackclientid,
    "client_secret" => $slackclientsecret,
    "code" => $_GET["code"]
);



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($ch);
curl_close($ch);
$result = (array)json_decode($response, true);

if (empty($result) || isset($result["error"])) {
    echo "エラった\n\n";
    var_dump($result);
    exit;
}

header("Location:https://bonychops.com/experiment/Happinessbot/sample/slack.php");
