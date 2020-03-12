<?php
require_once('../login/config.php');
$minusword = json_decode(file_get_contents("../words/negative.js",true));
$words = json_decode(file_get_contents("../words/positive.js",true));
 $others = json_decode(file_get_contents("../words/others.js",true));
$nonrated = json_decode(file_get_contents("../words/nonrated.js",true)); 
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

$chosei = 0;
if(isset($_POST[0])){
    for($i=0;$i<sizeof($nonrated);$i++){
        if($_POST[$i] == "happy"){
            array_push($words,$nonrated[$i-$chosei]);
            array_splice($nonrated, $i-$chosei, 1);
            $chosei--;
        }
        if($_POST[$i] == "minusword"){
            array_push($minusword,$nonrated[$i-$chosei]);
            array_splice($nonrated, $i-$chosei, 1);
            $chosei--;
        }
        if($_POST[$i] == "others"){
            array_push($others,$nonrated[$i-$chosei]);
            array_splice($others, $i-$chosei, 1);
            $chosei--;
        }
    }
    file_put_contents("../words/negative.js",json_encode($minusword));
    file_put_contents("../words/positive.js",json_encode($words));
    file_put_contents("../words/others.js",json_encode($others));
    file_put_contents("../words/nonrated.js",json_encode($nonrated));
}

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

echo '<form method="post"><input type="submit" value="決定">';
$cnt = 0;
foreach($nonrated as $value){
    echo '<p>'.$value.'<input type="radio" name="'.$cnt.'" value="happy">幸せ
    <input type="radio" name="'.$cnt.'" value="minusword">不幸
    <input type="radio" name="'.$cnt.'" value="others">その他
    <input type="radio" name="'.$cnt.'" value="nonrated" checked="checked">未分類</p>';
    $cnt++;
}
echo '<input type="submit" value="決定"></form>'
?>




</section>

<!--/contents-->
</div>
<?php require_once('../../../footer.php'); ?>

