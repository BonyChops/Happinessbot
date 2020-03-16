<?php
ini_set('display_errors', "On");
/*
require_once "../vendor/autoload.php";
require_once "define.php";

use Socialite\Provider\LineProvider;
use Socialite\Socialite;


Socialite::driver(LineProvider::class, $config)->redirect();
*/
require_once('accesstoken.php');
echo $callback_url;
$url = sprintf(
    "https://slack.com/oauth/authorize"
    ."?response_type=code"
    ."&client_id=%s"
    ."&scope=commands"
    ,$slackclientid
);

header("Location: {$url}");
exit;
?>