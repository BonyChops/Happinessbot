<?php
require_once('../login/config.php');
if($_GET['passwd'] != $passwd){
?>
<form method="get">
<input type="password" name="passwd">
<input type="submit" value="go">
</form>
<?php
exit;   
}
$title="Happy Tweets";

require_once('../../../header.php');
?>
<style>
.twt_wrap {
  text-align: center;
}
.twt_wrap > iframe {
  margin: auto;
}
</style>
<div id="contents">

<section>

<h2>Happy Tweets<span>幸せをさがそう</span></h2>
<p class="c">近年、物騒なツイートがいいねやRTを稼いでいます。ですがそれでいいのでしょうか。<br>
そんなTLで心が荒んでしまったあなた。ぜひここで幸せなツイートを探してみましょう。<br>
適当な単語を入れてみてください。</p>
<center>
<form method="get">
<input type="text" name="search" placeholder="単語を入れてください">
<input type="submit" value="検索">
</form>
</center>
</section>
<?php
if(isset($_GET['search'])){
    $result = chooseTweet($objTwitterConection,$objTwitterConection2, $_GET['search']);
    ?>
<section>
<h2>検索結果</h2>
<p class="c"><?= $_GET['search'] ?>での検索結果:</p>
    <?php if($result == "IMPOSSIBLE!"){ ?>
<p class="c">ごめんなさい、幸せなツイートを見つけることができませんでした...別の単語でお試しください。</p>
<?php } else if($result == "BAD"){ ?>
    <p class="c">ごめんなさい、幸せなツイートを見つけることができませんでした...別の単語でお試しください。</p>
    <?php }else{ 
        list($id,$screen_name) = $result;
        ?>
        <center><blockquote class="twitter-tweet" data-theme="dark"><p lang="ja" dir="ltr">ツイートをロードしています...</p>&mdash; <a href="https://twitter.com/<?= $screen_name ?>/status/<?= $id ?>?ref_src=twsrc%5Etfw">March 11, 2020</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></center>
    <?php }
?>
</section> 
<?php } ?>





<section>
<h2>幸せうんちくんbot</h2>
<p class="c">上のアルゴリズムを使って幸せなツイートを定期的につぶやいています。よかったらフォローお願いします。</p>
<div class="twt_wrap">
<a href="https://twitter.com/IamHappiestPoop?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-size="large" data-show-count="false">Follow @IamHappiestPoop</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script><br>
  <a class="twitter-timeline" data-width="1000" data-height="500" data-theme="dark" href="https://twitter.com/IamHappiestPoop?ref_src=twsrc%5Etfw">Tweets by IamHappiestPoop</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
</div>
</section>

<section>
<h2>仕組み</h2>
<p class="c">Githubにて配布しております。</p>
<p class="c"><a target="_blank" href="https://github.com/BonyChops/Happinessbot" class="fa fa-github"></a></p>
</section>

<!--/contents-->
</div>
<?php require_once('../../../footer.php'); ?>

