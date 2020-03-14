<?php
$arr = array(
    'speech' => "どうもどうも！", 
    'displayText' => "平素より大変お世話になっております。"
);
header("Content-Type: application/json; charset=utf-8");
echo json_encode($arr);