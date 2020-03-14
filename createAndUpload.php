<?php
//インクルード
require_once 'login/config.php';
require_once 'vendor/autoload.php';
 
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



$statuses = json_decode(file_get_contents("words/statuses.js",true));
if($statuses == ""){
    printf("There is no statuses.");
    exit;
}

$targetStatus = $statuses[rand(0,sizeof($statuses)-1)];
var_dump($targetStatus);

//Run command to generate img and voice (in jp)
printf("Generating img and voice...\n");
exec('convert -font SourceHanSerif-Heavy.otf -gravity center -pointsize 100 -fill white -annotate 0 "'.$targetStatus->{"str"}.'" happy_back.png tmp.png & google_speech -l ja -o tmp.mp3 "'.$targetStatus->{"str"}.'"');
printf("Volume up...\n");
exec('mp3gain -g 9 tmp.mp3');
printf("Mixing BGM and voice...\n");
exec('ffmpeg -y -i back_bgm2.wav -i tmp.mp3 -filter_complex amix=inputs=2:duration=longest tmp2.mp3');
printf("Rendering... (1 of 2)\n");
exec('ffmpeg -y -r 60 -loop 1 -t 8.3 -i tmp.png -i tmp2.mp3 -vcodec libx264 -r 60 -ar 48000 tmp.mp4');
printf("Rendering... (2 of 2)\n");
//exec('ffmpeg -y -i video_back.mp4 -i tmp.mp4 -filter_complex "[0:v] [0:a] [1:v] [1:a] concat=n=2" output.mp4');
exec('melt video_back.mp4 tmp.mp4 -consumer avformat:output.mp4 acodec=libmp3lame vcodec=libx264');

require_once('uploadVideo.php');
printf("Wait 2 min to post a tweet...");
sleep(60);
printf("Wait 1 min to post a tweet...");
sleep(60);
$str = "動画アップロードしました！\n".$uploadedTITLE."\n"."https://youtu.be/".$uploadedID;
$objTwUserInfo = $objTwitterConection->post("statuses/update",["status" => $str]);
unlink("words/statuses.js");