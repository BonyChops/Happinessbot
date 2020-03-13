<?php
session_start();
 
//インクルード
require_once 'config.php';

    $querys = array(
            'client_id' => HogeUtil::getGoogleClientId(),
            'redirect_uri' => HogeUtil::getGoogleClientCallBack(),
            'scope' => 'https://www.googleapis.com/auth/userinfo.profile',
            'response_type' => 'code',
    );

    return 'https://accounts.google.com/o/oauth2/auth?' . http_build_query($querys);