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
<?php
$minusword = json_decode(file_get_contents("words/negative.js",true));
$words = json_decode(file_get_contents("words/positive.js",true));
 $others = json_decode(file_get_contents("words/others.js",true));
$nonrated = json_decode(file_get_contents("words/nonrated.js",true)); 
if($minusword == ""){
    $minusword = array();
}
if($words == ""){
    $words = array();
}
if($others == ""){
    $others = array();
}
if($nonrated == ""){
    $nonrated = array();
}
echo '<form method="post">';
foreach($nonrated as $value){
    echo '<p>'.$value.'<imput></p><input type="radio" name="'.$value.'" value="happy">幸せ
    <input type="radio" name="'.$value.'" value="minusword">不幸
    <input type="radio" name="'.$value.'" value="others">その他
    <input type="radio" name="'.$value.'" value="nonrated" selected="selected">未分類</p>';
}
echo '</form>'
?>




</section>

<!--/contents-->
</div>
<?php require_once('../../../footer.php'); ?>

