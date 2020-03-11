<?php
//インクルード
require_once '../login/config.php';
require_once '../vendor/autoload.php';
 
//インポート
use Abraham\TwitterOAuth\TwitterOAuth;

$TwitterAccountInfo = json_decode(file_get_contents('../login/'.$accesstoken_filename),true);

$objTwitterConection = new TwitterOAuth
(
$sTwitterConsumerKey,
$sTwitterConsumerSecret,
$TwitterAccountInfo['twAccessToken']['oauth_token'],
$TwitterAccountInfo['twAccessToken']['oauth_token_secret']
);

$title="Happy Tweets";

require_once('../../../header.php');
?>

<div id="contents">

<section>

<h2>Happy Tweets<span>幸せをさがそう</span></h2>
<p class="c">近年、物騒なツイートがいいねやRTを稼いでいます。ですがそれでいいのでしょうか。<br>
そんなTLで心が荒んでしまったあなた。ぜひここで幸せなツイートを探してみましょう。<br>
適当な単語を入れてみてください。</p>
<form method="get">
<input type="text" name="search" placeholder="単語を入れてください">
<input type="submit" value="検索">
</form>
</section>
<?php
if(isset($_GET['search'])){
    $result = chooseTweet($objTwitterConection, $_GET['search']);
    ?>
<section>
<h2>検索結果</h2>
    <?php if($result == "IMPOSSIBLE!"){ ?>
<p class="c">ごめんなさい、幸せなツイートを見つけることができませんでした...別の単語でお試しください。</p>
<?php } else if($result == "IMPOSSIBLE!"){ ?>
    <p class="c">ごめんなさい、幸せなツイートを見つけることができませんでした...別の単語でお試しください。</p>
    <?php }else{ 
        list($id,$screen_name) = $result;
        ?>
        <center><blockquote class="twitter-tweet"><p lang="ja" dir="ltr">ツイートをロードしています...</p>&mdash; <a href="https://twitter.com/<?= $screen_name ?>/status/<?= $id ?>?ref_src=twsrc%5Etfw">March 11, 2020</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></center>
    <?php }
?>
</section> 
<?php } ?>


</section>
<style>
.twt_wrap {
  text-align: center;
}
.twt_wrap > iframe {
  margin: auto;
}
</style>


<h2>幸せうんちくんbot</h2>
<p class="c">上のアルゴリズムを使って幸せなツイートを定期的につぶやいています。よかったらフォローお願いします。</p>
<div class="twt_wrap">
<a href="https://twitter.com/IamHappiestPoop?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-size="large" data-show-count="false">Follow @IamHappiestPoop</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script><br>
  <a class="twitter-timeline">
  <a class="twitter-timeline" data-width="1000" data-height="500" data-theme="dark" href="https://twitter.com/IamHappiestPoop?ref_src=twsrc%5Etfw">Tweets by IamHappiestPoop</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
</div>

<!--/contents-->
</div>
<?php require_once('../../../footer.php'); ?>


<?php


function chooseTweet($objTwitterConection, $custom = ""){
    srand(time());
    for($i=0; $i<1; $i++){
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
            for($i=0;$i<sizeof($minusword);$i++){
                if((strpos($custom,$minusword[$i]) != null)){
                    return "BAD";
                }
            }
        }
        if(!isset($buf)){
            $buf = "";
        }
        if($cntWord != $buf){
            $buf = $cntWord;
            printf($cntWord."\n");
            if(!isset($LastID)){
                $searchResult = $objTwitterConection->get("search/tweets",["q" => $cntWord, "count" => 100]);
            }else{
                printf("LastID detected:".$LastID."\n");
                $searchResult = $objTwitterConection->get("search/tweets",["q" => $cntWord, "count" => 100,"max_id"=>$LastID]);
            }

            //var_dump($searchResult->{"statuses"}[0]);
            foreach($searchResult->{"statuses"} as $value){
                if (
                    ($value->{"in_reply_to_status_id"} == null)&&
                    (strlen($value->{"text"}) <= 80)&&
                    ($value->{"retweeted"} == false)){
                        $no=0;
                        for($i=0;$i<sizeof($minusword);$i++){
                            if((strpos($value->{"text"},$minusword[$i]) != null)){
                                $no = 1;
                                break;
                            }
                        }
                        if($no == 0){
                            $str = $value->{"text"};
                            if(strpos($str, '@') != null){
                                list($gomi,$str) = sscanf($str,"@%s %s");
                            }
                            //printf($str."\n");
                            if (($str != "")&&(isset($str))){
                                return [$value->{"id_str"},$value->{"user"}->{"screen_name"}];
                            }
                        }
                }
                
            }
            $LastID = $value->{"id"};
        }
    }
    return "IMPOSSIBLE!";
}