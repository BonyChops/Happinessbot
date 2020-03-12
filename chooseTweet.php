
<?php
function chooseTweet($objTwitterConection, $objTwitterConection2,$custom = "", $like = false){
    srand(time());
    for($i=0; $i<10; $i++){
        $date = date('Y-m-d G:i:s');

        $minusword = [
            "しね","死ね","最悪","ごみ","ゴミ","コロナ","フェミ","悪い","かす","カス",
            "暴力","性被害","寝取","NTR","クソ","だるい","痛い","寂しい","生理","愚痴",
            "副業","悲惨","なにやってんだよ","あほ","アホ"
        ];

        $words = [
            "おいし","美味し","いい天気","眠いな","買い物","好きな人","お腹いっぱい",
            "腹減った","お腹へった","食べたい","おなかすいた","なつかしい","すこ","すき","好き",
            "何しよう","おもしろ","空が綺麗","昼寝","うんち"
        ];
        if((date('H') >= 20)||(date('H') <= 4)){
            $words = [
                "眠いな","ねれない","寝れない","羊 数え","いい夢","腹減った",
                "おやすみ","眠くなって","何しよう","おもしろ","美味しかった",
                "星がきれい","やべえ","あったかい","うんち"
            ];
        }
        if((date('H') >= 5)&&(date('H') <= 8)){
            $words = [
                "おはよう","まだ眠い","朝ごはん","太陽","いい気分","うんち"
            ];
        }

        shuffle($words);
        $cntWord = $words[rand(0,sizeof($words)-1)];
        if($custom != ""){
            $cntWord = $custom;
        }
        if(!isset($buf)){
            $buf = "";
        }
        if($cntWord != $buf){
            $buf = $cntWord;
            printf($cntWord."\n");
            if(!isset($LastID)){
                $searchResult = $objTwitterConection2->get("search/tweets",["q" => $cntWord, "count" => 100,"lang" => "ja"]);
            }else{
                //printf("LastID detected:".$LastID."\n");
                $searchResult = $objTwitterConection2->get("search/tweets",["q" => $cntWord, "count" => 100,"lang" => "ja","max_id"=>$LastID]);
            }

            //var_dump($searchResult->{"statuses"}[0]);
            foreach($searchResult->{"statuses"} as $value){
                if (
                    ($value->{"in_reply_to_status_id"} == null)&&
                    (strlen($value->{"text"}) <= 80)&&
                    ($value->{"retweeted"} == false)){
                        $no=0;
                        for($i=0;$i<sizeof($minusword);$i++){
                            if((strpos($value->{"text"},$minusword[$i]) !== false)){
                                $no = 1;
                                break;
                            }
                        }
                        if($no == 0){
                            $str = $value->{"text"};
                            if(strpos($str, '@') != null){
                                list($gomi,$str) = sscanf($str,"@%s %s");
                            }
                            printf($str."\n");
                            if (($str != "")&&(isset($str))){
                                if($like == true){
                                    printf("Like!"."\n");
                                    $likeResult = $objTwitterConection->post("favorites/create",["id" => $value->{"id"}]);
                                }
                                return processTweet($str);
                            }
                        }
                }
                
            }
            $LastID = $value->{"id"};
        }
    }
}
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