<?php
ini_set('display_errors', "On");
require_once "accesstoken.php";


if (!$_GET["code"]) {
   echo 'エラった';
   exit;
}

// アクセストークン取得
$url = "https://slack.com/api/oauth.access";

$redirect_url = "https://bonychops.com/BonyShopper/LINE/line_callback.php";
if($_GET['redirect_url']) $redirect_url = $redirect_url.'?redirect_url='.urlencode($_GET['redirect_url']);

$data = array(
    "client_id" => $redirect_uri,
    "client_secret" => $slackclientsecret,
    "code" => $_GET["code"],
    "redirect_uri" => 'https://bonychops.com/experiment/Happinessbot/login_slack/callback.php'
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

print_r($result);
