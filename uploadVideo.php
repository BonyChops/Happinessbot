<?php
$statuses = json_decode(file_get_contents("words/statuses.js",true));
if($statuses == ""){
    printf("There is no statuses.");
    exit;
}

$targetStatus = $statuses[rand(0,sizeof($statuses)-1)];
//Run command to generate img and voice (in jp)
exec('convert -font SourceHanSerif-Heavy.otf -gravity center -pointsize 100 -fill white -annotate 0 "'.$targetStatus['str'].'" happy_back.png tmp.png & google_speech -l ja -o tmp.mp3 "'.$targetStatus['str'].'"');
exec('ffmpeg -r 60 -loop 1 -t 8.3 -i tmp.png -vcodec libx264 -pix_fmt yuv420p -r 60 tmp.mp4');
exec('')