<?php
session_start();

require_once 'config.php';
require_once '../vendor/autoload.php';
 
//インポート
use Abraham\TwitterOAuth\TwitterOAuth;
 
##############################################
### oauthトークン確認
if(empty($_SESSION['twOauthToken']) || empty($_SESSION['twOauthTokenSecret']) || empty($_REQUEST['oauth_token']) || empty($_REQUEST['oauth_verifier'])){
 echo 'error token!!';
 exit;
}
if($_SESSION['twOauthToken'] !== $_REQUEST['oauth_token']) {
 echo 'error token incorrect!!';
 exit;
}
 
##############################################
### アクセストークン作成
 
//取得したoauthトークンでTwitterOAuthクラスをインスタンス化
$objTwitterConection = new TwitterOAuth
 (
 $sTwitterConsumerKey,
 $sTwitterConsumerSecret,
 $_SESSION['twOauthToken'],
 $_SESSION['twOauthTokenSecret']
 );
 
//アクセストークンの取得
$_SESSION['twAccessToken'] = $objTwitterConection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));
 
//メンバーページへリダイレクト
header('location: member.php');