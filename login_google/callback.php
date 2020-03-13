<?php
var_dump($_GET);
var_dump($_POST);

$clientInfo = json_decode(file_get_contents("client_secret.json"));

$baseURL = 'https://accounts.google.com/o/oauth2/token';
$params = array(
        'code'          => $_GET['code'],
        'client_id'     => $clientInfo->{"web"}->{"client_id"},
        'client_secret' => $clientInfo->{"web"}->{"client_secret"},
        'redirect_uri'  => $clientInfo->{"web"}->{"redirect_uris"}[0],
        'grant_type'    => 'authorization_code'
);
$headers = array(
        'Content-Type: application/x-www-form-urlencoded',
);

$options = array('http' => array(
        'method' => 'POST',
        'content' => http_build_query($params),
        'header' => implode("\r\n", $headers),
));

$response = json_decode(
        file_get_contents($baseURL, false, stream_context_create($options)));

if(!$response || isset($response->error)){
    printf("なしは草");
}
printf("アクセストークン！\n");
printf($response->access_token);