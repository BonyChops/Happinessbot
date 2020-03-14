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

<h2>うんちくん for <i class="fab fa-discord"></i>Discord</h2>
<p class="c">僕をDiscordで呼び出せるようになったよ！やったね！<br>
使い方は会話中に/happyって言うだけ！</p>
<p class="c"><img src="discord.png"></p>
<p class="c">招待はここから↓</p>
<p class="c"><a target="_blank" href="https://discordapp.com/api/oauth2/authorize?client_id=688390082616623131&permissions=2048&redirect_uri=https%3A%2F%2Fbonychops.com%2Fexperiment%2FHappinessbot%2Flogin_discord%2Fcallback.php&scope=bot" class="fab fa-discord"></a></p>

</section>

<section>
<h2>その他のソーシャルアカウント</h2>
<p class="c">気軽にのぞいてね！</p>
<p class="c"><a target="_blank" href="https://twitter.com/IamHappiestPoop" class="fab fa-twitter"></a>
<a target="_blank" href="https://www.youtube.com/channel/UCtpBLAoNCGs32cnn8Mu06-A" class="fab fa-youtube"></a>
</section>


<section>
<h2>仕組み</h2>
<p class="c">Githubにて配布しております。</p>
<p class="c"><a target="_blank" href="https://github.com/BonyChops/Happinessbot" class="fa fa-github"></a></p>
</section>



<!--/contents-->
</div>
<?php require_once('../../../footer.php'); ?>
