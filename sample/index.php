<?php
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
<imput type="text" name="search" placeholder="単語を入れてください"/>
<imput type="submit" value="検索">
</form>
</section>

<section>

</section>
<h2>幸せうんちくんbot</h2>
<p class="c">上のアルゴリズムを使って幸せなツイートを定期的につぶやいています。よかったらフォローお願いします。</p>
<a class="twitter-timeline c" data-theme="dark" href="https://twitter.com/IamHappiestPoop?ref_src=twsrc%5Etfw">Tweets by IamHappiestPoop</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>


<!--/contents-->
</div>
<?php require_once('../../../footer.php'); ?>