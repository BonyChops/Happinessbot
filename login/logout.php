<?php
session_start();

$_SESSION = array();
$_COOKIE = array();

setcookie("PHPSESSID", '', time() - 1800, '/');

session_destroy();
?>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>タイトル</title>
<meta http-equiv="Content-Style-Type" content="text/css">
</head>
 
<h2>Twitter アカウント ログアウト</h2>
 
<?php
echo "ログアウトしました。"; 
echo "<a href='login.php'>ログインへ</a>";
?>
 
</body>
</html>