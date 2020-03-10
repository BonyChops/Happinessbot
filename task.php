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

//$objTwUserInfo = $objTwitterConection->post("statuses/update",["status" => "Hello, world!"]);
var_dump($objTwUserInfo);
$date = date('Y-m-d G:i:s');

$minusword = [
    "しね","死ね","最悪","ごみ","ゴミ","コロナ","フェミ","悪い","かす","カス","暴力","性被害"
];

$words = [
    "おいし","美味し","いい天気","眠いな","買い物","好きな人","お腹いっぱい"
];
if(date('H') > 20){
    $words = [
        "眠いな","ねれない","寝れない","羊 数え","いい夢"
    ];
}


srand(time());
$cntWord = $words[rand(0,sizeof($words)-1)];
printf($cntWord);
$searchResult = $objTwitterConection->get("search/tweets",["q" => $cntWord, "count" => 100]);
//var_dump($searchResult->{"statuses"}[0]);
foreach($searchResult->{"statuses"} as $value){
    if (
        ($value->{"in_reply_to_status_id"} == null)&&
        (strlen($value->{"text"}) <= 80)){
            $no=0;
            for($i=0;$i<sizeof($minusword);$i++){
                if(strpos($value->{"text"},$minusword[$i]) != null){
                    $no = 1;
                    break;
                }
            }
            if($no == 0){
                echo $value->{"text"};
                exit;
            }
    }
}
