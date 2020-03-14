<?php
require_once '../vendor/autoload.php';
require_once 'accesstoken.php';
require_once '../login/config.php';
require_once "../chooseTweet.php";
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



$discord = new \Discord\Discord([
    'token' => $accesstoken , // ←作成したBotのTokenを入力してね
]);

$discord->on('ready', function ($discord) {
    echo "Bot is ready.", PHP_EOL;

    // Listen for events here
    $discord->on('message', function ($message) {
        global $objTwitterConection,$objTwitterConection2;
        if ($message->content === "/happy") {
            $str = chooseTweet($objTwitterConection,$objTwitterConection2,"",false);
            $message->reply($str);
        }
    });
});

$discord->run();
