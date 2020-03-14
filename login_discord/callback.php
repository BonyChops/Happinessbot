<?php
$json_string = file_get_contents('php://input');
$json_object = json_decode($json_string);
 
var_dump($json_object);