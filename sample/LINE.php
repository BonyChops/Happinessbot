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
$objTwitterConection2 = new TwitterOAuth
(
$sTwitterConsumerKey,
$sTwitterConsumerSecret
);

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

<h2>うんちくん for <i class="fab fa-line"></i>LINE</h2>
<p class="c">みんなともっとおしゃべりしたいな。</p>
<p class="c"><img src="LINE.png"></p>
<h3 class="c">グループにも行くよ！</h3>
<p class="c">※ただし会話に/happyを入れないと反応しません</p>
<p class="c"><img src="LINE2.png"></p>
<h3 class="c">うんちくんを登録する</h3>
<p class="c"><a target="_blank" href="https://lin.ee/Yv0oOW" class="fab fa-line"></a></p>

</section>

<?php require_once('sns_unchi.php'); ?>



<!--/contents-->
</div>
<?php require_once('../../../footer.php'); ?>
