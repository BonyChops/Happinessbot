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
$minusword = json_decode(file_get_contents("words/negative.js",true));
$words = json_decode(file_get_contents("words/positive.js",true));
$others = json_decode(file_get_contents("words/others.js",true));
$nonrated = json_decode(file_get_contents("words/nonrated.js",true));


printf("Learning...");
$cntWord = "";
for($i=0;$i<100;$i++){
    $cntWord = $words[rand(0,sizeof($words)-1)];
    printf($cntWord."\n");
    if(!isset($LastID)){
        $searchResult = $objTwitterConection2->get("search/tweets",["q" => $cntWord, "count" => 100,"lang" => "ja"]);
    }else{
        //printf("LastID detected:".$LastID."\n");
        $searchResult = $objTwitterConection2->get("search/tweets",["q" => $cntWord, "count" => 100,"lang" => "ja","max_id"=>$LastID]);
    }

    //var_dump($searchResult->{"statuses"}[0]);
    foreach($searchResult->{"statuses"} as $value){
        $str = $value->{"text"};
        $str = processTweet($str);
        $array = explode("\n", $str);
        $array = array_map('trim', $array);
        $array = array_filter($array, 'strlen');
        foreach($array as $value2){
            if($value == 'EOS'){
                continue;
            }
            list($name,$type,$dump,$dump,$dump,$dump,$dump,$default,$dump,$dump)=sscanf($value2,"%s %s,%s,%s,%s,%s,%s,%s,%s,%s");
            if(($type == "名詞")||($type == "動詞")){
                if(
                    (array_search($default,$minusword) === false)&&
                    (array_search($default,$words) === false)&&
                    (array_search($default,$others) === false)&&
                    (array_search($default,$nonrated) === false)
                ){
                    array_push($nonrated,$default);
                }
            }
        }
    }
    $LastID = $value->{"id"};
    printf($i."\n");
}

var_dump($nonrated);
file_put_contents("words/nonrated.js",json_encode($nonrated));
printf("Done.");


//From https://qiita.com/nobuyuki-ishii/items/2838e663e2ab8d99ffd5
function processTweet($text) {
    $text = deleteUser($text);
    $text = deleteNewLine($text);
    $text = deleteUrl($text);
    //$text = deleteHashtag($text);
    $text = deleteNonUtf8($text);
    $text = convertHtmlSpecialCharcter($text);
    return $text;
  }
  // ユーザ名（@～）を消す
  function deleteUser($text) {
    return preg_replace('/@.*\s/', '', $text);
  }
  
  // 改行をスペースに変換
  function deleteNewLine($text) {
    return str_replace(array("\r\n", "\r", "\n"), ' ', $text);
  }
  
  // http引用を消す
  function deleteUrl($text) {
    return preg_replace('/(https?)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/', '', $text);
  }
  
  // ハッシュタグ（#～）を消す
  function deleteHashtag($text) {
    return preg_replace('/#.*/', '', $text);
  }
  
  // 変換不能文字を消す
  function deleteNonUtf8($text) {
    //reject overly long 2 byte sequences, as well as characters above U+10000 and replace with ?
    $text = preg_replace(
      '/[\x00-\x08\x10\x0B\x0C\x0E-\x19\x7F]'.
      '|[\x00-\x7F][\x80-\xBF]+'.
      '|([\xC0\xC1]|[\xF0-\xFF])[\x80-\xBF]*'.
      '|[\xC2-\xDF]((?![\x80-\xBF])|[\x80-\xBF]{2,})'.
      '|[\xE0-\xEF](([\x80-\xBF](?![\x80-\xBF]))|(?![\x80-\xBF]{2})|[\x80-\xBF]{3,})/S',
      '', $text );
  
    //reject overly long 3 byte sequences and UTF-16 surrogates and replace with ?
    $text = preg_replace(
      '/\xE0[\x80-\x9F][\x80-\xBF]'.
      '|\xED[\xA0-\xBF][\x80-\xBF]/S',
      '', $text );
  
    return $text;
  }

  // html特殊文字を変換する
  function convertHtmlSpecialCharcter($text) {
    return htmlspecialchars_decode($text);
  }