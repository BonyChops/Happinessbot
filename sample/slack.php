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
<?php if($_GET['logedid']!=true){ ?>
<h2>うんちくん for <i class="fab fa-slack"></i>Slack</h2>
<p class="c">ビジネスにユーモアを</p>
<p class="c"><img src="slack2.png"></p>
<h3 class="c">コマンドから呼び出してください</h3>
<p class="c"><img src="slack.png"></p>
<h3 class="c">Slackにうんちくんを招待する</h3>
<p class="c"><a target="_blank" href="https://slack.com/oauth/v2/authorize?client_id=1001639938256.991566717393&scope=commands" class="fab fa-slack"></a></p>
<?php }else{?>
  <h2>うんちくん for <i class="fab fa-slack"></i>Slack</h2>
<p class="c">ビジネスにユーモアを</p>
<h3 class="c">うんちくんの招待ありがとうございます！</h3>
<p class="c">うんちくんとのおしゃべりをお楽しみください。</p>
<h3 class="c">Slackにうんちくんを招待する</h3>
<p class="c"><a target="_blank" href="https://slack.com/oauth/v2/authorize?client_id=1001639938256.991566717393&scope=commands" class="fab fa-slack"></a></p>

<?php } ?>
</section>

<?php require_once('sns_unchi.php'); ?>



<!--/contents-->
</div>
<?php require_once('../../../footer.php'); ?>
