<?php
require_once '../vendor/autoload.php';
require_once 'accesstoken.php';



$discord = new \Discord\Discord([
    'token' => $accesstoken , // ←作成したBotのTokenを入力してね
]);

$discord->on('ready', function ($discord) {
    echo "Bot is ready.", PHP_EOL;

    // Listen for events here
    $discord->on('message', function ($message) {
        if ($message->author->id !== $botUser->id) {
            $message->reply('こんにちはーっ！');
        }
    });
});

$discord->run();