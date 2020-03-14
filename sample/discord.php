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

<h2><i class="fab fa-discord"></i>Discord</h2>
<p class="c">僕をDiscordで呼び出せるようになったよ！やったね！<br>
使い方は会話中に/happyって言うだけ！</p>
<p>招待はここから↓</p>
<p class="c"><a target="_blank" href="https://discordapp.com/api/oauth2/authorize?client_id=688390082616623131&permissions=2048&redirect_uri=https%3A%2F%2Fbonychops.com%2Fexperiment%2FHappinessbot%2Flogin_discord%2Fcallback.php&scope=bot" class="fab fa-discord"></a></p>





<!--/contents-->
</div>
<?php require_once('../../../footer.php'); ?>
