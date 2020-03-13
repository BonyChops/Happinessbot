<?php
$statuses = json_decode(file_get_contents("words/statuses.js",true));
if($statuses == ""){
    printf("There is no statuses.");
    exit;
}

$targetStatus = $statuses[rand(0,sizeof($statuses)-1)];
var_dump($targetStatus);
//Run command to generate img and voice (in jp)
printf("Generating img and voice...");
exec('convert -font SourceHanSerif-Heavy.otf -gravity center -pointsize 100 -fill white -annotate 0 "'.$targetStatus->{"str"}.'" happy_back.png tmp.png & google_speech -l ja -o tmp.mp3 "'.$targetStatus->{"str"}.'"');
printf("Mixing BGM and voice...");
exec('ffmpeg -y -i back_bgm2.wav -i tmp.mp3 -filter_complex amix=inputs=2:duration=longest tmp2.mp3');
printf("Rendering... (1 of 2)");
exec('ffmpeg -y -r 60 -loop 1 -t 8.3 -i tmp.png -i tmp2.mp3 -vcodec libx264 -r 60 -ar 48000 tmp.mp4');
printf("Rendering... (2 of 2)");
//exec('ffmpeg -y -i video_back.mp4 -i tmp.mp4 -filter_complex "[0:v] [0:a] [1:v] [1:a] concat=n=2" output.mp4');
exit('melt video_back.mp4 tmp.mp4 -consumer avformat:output3.mp4 acodec=libmp3lame vcodec=libx264');