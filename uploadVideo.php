<?php
if(!isset($statuses)){
    $statuses = json_decode(file_get_contents("words/statuses.js",true));
    if($statuses == ""){
        printf("There is no statuses.");
        exit;
    }
    $targetStatus = $statuses[rand(0,sizeof($statuses)-1)];
    var_dump($targetStatus);
}

/**
 * Library Requirements
 *
 * 1. Install composer (https://getcomposer.org)
 * 2. On the command line, change to this directory (api-samples/php)
 * 3. Require the google/apiclient library
 *    $ composer require google/apiclient:~2.0
 */
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
  throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
}

require_once __DIR__ . '/vendor/autoload.php';
session_start();

/*
 * You can acquire an OAuth 2.0 client ID and client secret from the
 * Google API Console <https://console.developers.google.com/>
 * For more information about using OAuth 2.0 to access Google APIs, please see:
 * <https://developers.google.com/youtube/v3/guides/authentication>
 * Please ensure that you have enabled the YouTube Data API for your project.
 */

$clientInfo = json_decode(file_get_contents( __DIR__ . '/login_google/client_secret.json'));

$OAUTH2_CLIENT_ID = $clientInfo->{"web"}->{"client_id"};
$OAUTH2_CLIENT_SECRET = $clientInfo->{"web"}->{"client_secret"};

$client = new Google_Client();
$client->setClientId($OAUTH2_CLIENT_ID);
$client->setClientSecret($OAUTH2_CLIENT_SECRET);
$client->setScopes('https://www.googleapis.com/auth/youtube');
$redirect = filter_var('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
    FILTER_SANITIZE_URL);
$client->setRedirectUri($redirect);

// Define an object that will be used to make all API requests.
$youtube = new Google_Service_YouTube($client);

// Check if an auth token exists for the required scopes
$tokenSessionKey = 'token-' . $client->prepareScopes();
if (isset($_GET['code'])) {
  if (strval($_SESSION['state']) !== strval($_GET['state'])) {
    die('The session state did not match.');
  }

  $client->authenticate($_GET['code']);
  $accesstoken_YT["accesstoken"] = $client->getAccessToken();
  file_put_contents( __DIR__ . '/login_google/accesstoken.js',json_encode($accesstoken_YT));
  printf("OK!");
  exit;
}
$accesstoken_YT = json_decode(file_get_contents( __DIR__ . '/login_google/accesstoken.js'),true);
if (isset( $accesstoken_YT["accesstoken"])) {
  $client->setAccessToken($accesstoken_YT["accesstoken"]);
}

// Check to ensure that the access token was successfully acquired.
if ($client->getAccessToken()) {
  $htmlBody = '';
  try{
    // REPLACE this value with the path to the file you are uploading.
    $videoPath = __DIR__ . '/output.mp4';

    // Create a snippet with title, description, tags and category ID
    // Create an asset resource and set its snippet metadata and type.
    // This example sets the video's title, description, keyword tags, and
    // video category.
    $snippet = new Google_Service_YouTube_VideoSnippet();
    $time = json_decode(file_get_contents( __DIR__ . '/login_google/time.js'),true);
    if (isset( $time["time"])) {
        $time["time"]++;
        $timecnt=$time["time"];
    }else{
        $timecnt=0;
        $time = array();
        $time["time"] = 0;
    }
    $snippet->setTitle("今日の幸せ #".$timecnt);
    file_put_contents( __DIR__ . '/login_google/time.js',json_encode($time));
    $snippet->setDescription("今日の選ばれたツイート↓\nhttps://twitter.com/IamHappiestPoop/status/".$targetStatus->{"id"}."\n\n-----------以下開発者より-----------\nこのチャンネルはbotにより自動で投稿しています。\nYouTube Data APIのテストとしてBony_Chopsが運営しております。\n\nBony_Chops\nhttps://www.youtube.com/BonyChops");
    
    $snippet->setTags(array("うんちくん", "幸せ", "今日の幸せ"));

    // Numeric video category. See
    // https://developers.google.com/youtube/v3/docs/videoCategories/list
    $snippet->setCategoryId("22");

    // Set the video's status to "public". Valid statuses are "public",
    // "private" and "unlisted".
    $status = new Google_Service_YouTube_VideoStatus();
    $status->privacyStatus = "public";

    // Associate the snippet and status objects with a new video resource.
    $video = new Google_Service_YouTube_Video();
    $video->setSnippet($snippet);
    $video->setStatus($status);

    // Specify the size of each chunk of data, in bytes. Set a higher value for
    // reliable connection as fewer chunks lead to faster uploads. Set a lower
    // value for better recovery on less reliable connections.
    $chunkSizeBytes = 1 * 1024 * 1024;

    // Setting the defer flag to true tells the client to return a request which can be called
    // with ->execute(); instead of making the API call immediately.
    $client->setDefer(true);

    // Create a request for the API's videos.insert method to create and upload the video.
    $insertRequest = $youtube->videos->insert("status,snippet", $video);

    // Create a MediaFileUpload object for resumable uploads.
    $media = new Google_Http_MediaFileUpload(
        $client,
        $insertRequest,
        'video/*',
        null,
        true,
        $chunkSizeBytes
    );
    $media->setFileSize(filesize($videoPath));


    // Read the media file and upload it chunk by chunk.
    $status = false;
    $handle = fopen($videoPath, "rb");
    while (!$status && !feof($handle)) {
      $chunk = fread($handle, $chunkSizeBytes);
      $status = $media->nextChunk($chunk);
    }

    fclose($handle);

    // If you want to make other calls after the file upload, set setDefer back to false
    $client->setDefer(false);


    $htmlBody .= "<h3>Video Uploaded</h3><ul>";
    $htmlBody .= sprintf('<li>%s (%s)</li>',
        $status['snippet']['title'],
        $status['id']);
    $htmlBody .= '</ul>';
    $uploadedID = $status['id'];
    $uploadedTITLE = $status['snippet']['title'];

  } catch (Google_Service_Exception $e) {
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
  }

  $accesstoken_YT["accesstoken"] = $client->getAccessToken();
  file_put_contents( __DIR__ . '/login_google/accesstoken.js',json_encode($accesstoken_YT));
} elseif ($OAUTH2_CLIENT_ID == 'REPLACE_ME') {
  $htmlBody = <<<END
  <h3>Client Credentials Required</h3>
  <p>
    You need to set <code>\$OAUTH2_CLIENT_ID</code> and
    <code>\$OAUTH2_CLIENT_ID</code> before proceeding.
  <p>
END;
} else {
  // If the user hasn't authorized the app, initiate the OAuth flow
  $state = mt_rand();
  $client->setState($state);
  $_SESSION['state'] = $state;

  $authUrl = $client->createAuthUrl();
  $htmlBody = <<<END
  <h3>Authorization Required</h3>
  <p>You need to <a href="$authUrl">authorize access</a> before proceeding.<p>
END;
}
?>

<!doctype html>
<html>
<head>
<title>Video Uploaded</title>
</head>
<body>
  <?=$htmlBody?>
</body>
</html>
