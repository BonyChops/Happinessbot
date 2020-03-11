
<?php
function chooseTweet($objTwitterConection, $custom = ""){
    srand(time());
    for($i=0; $i<10; $i++){
        $date = date('Y-m-d G:i:s');

        $minusword = [
            "しね","死ね","最悪","ごみ","ゴミ","コロナ","フェミ","悪い","かす","カス",
            "暴力","性被害","寝取","NTR","クソ","だるい","痛い","寂しい","生理","愚痴",
            "副業"
        ];

        $words = [
            "おいし","美味し","いい天気","眠いな","買い物","好きな人","お腹いっぱい",
            "腹減った","お腹へった","食べたい","おなかすいた","なつかしい","すこ","すき","好き",
            "何しよう","おもしろ","空が綺麗","昼寝"
        ];
        if((date('H') >= 20)||(date('H') <= 4)){
            $words = [
                "眠いな","ねれない","寝れない","羊 数え","いい夢","腹減った",
                "おやすみ","眠くなって","何しよう","おもしろ","美味しかった",
                "星がきれい","やべえ","あったかい"
            ];
        }
        if((date('H') >= 5)&&(date('H') <= 8)){
            $words = [
                "おはよう","まだ眠い","朝ごはん","太陽","いい気分"
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
                $searchResult = $objTwitterConection->get("search/tweets",["q" => $cntWord, "count" => 100,"lang" => "ja"]);
            }else{
                //printf("LastID detected:".$LastID."\n");
                $searchResult = $objTwitterConection->get("search/tweets",["q" => $cntWord, "count" => 100,"lang" => "ja","max_id"=>$LastID]);
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
                                return $str;
                            }
                        }
                }
                
            }
            $LastID = $value->{"id"};
        }
    }
}