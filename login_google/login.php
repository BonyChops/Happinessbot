<?php
session_start();
$clientInfo = json_decode(file_get_contents("client_secret.json"));

    $querys = array(
            'client_id' => $clientInfo->{"web"}->{"client_id"},
            'redirect_uri' => $clientInfo->{"web"}->{"redirect_uris"}[0],//Choose
            'scope' => 'https://www.googleapis.com/auth/userinfo.profile',
            'response_type' => 'code',
    );

    return 'https://accounts.google.com/o/oauth2/auth?' . http_build_query($querys);