# Happiestbot
Collect happy tweets.

# Sample
幸せうんちくんbot - https://twitter.com/IamHappiestPoop

# How it works
First, this bot will search for one happy word that bot chose. Then it checks it doesn't include any unhappy word. Then tweet it.

# Language
This bot is in Japanese but you can make this in English and other language.  
Please edit `chooseTweet.php`.


# Setup
1. Go https://developer.twitter.com/ and create your app.
1. Set your Consumer key, Consumer key secret and callback URL to `login/config-sample.php`
1. Rename `login/config-sample.php` to `login/config.php`
1. For safety, all of the access is denied at the first by `.htaccess`. Edit this and add your IP address (which you want to access. For example, If you want to login from your home, then you should add your home IP address. But this setting is just used for when you log in to your account. That means it will make NO effect on tweeting. So as another means, you can remove `.htaccess` while you log in but please be aware that you have to  resurrect when it finishes.)
1. Login with your account by accessing `login/login.php`.
1. You will see your account info and it will automatically be saved in the `login` directory.  (As the default, the file name is `accesstoken.js`.)
1. You can check how it works by running `test.php`. (this won't tweet but if you want to check all of the works, run `task.php`)
1. Create `run.sh` and set up like this,  
```sh:run.sh
cd path/to/Happiestbot  
php task.php
```
9. Edit crontab to make this bot can tweet itself.  
For example, if you want to make it to tweet every 20 minutes,
```
*/20 * * * * sh path/to/Happiestbot/run.sh
```
10. Done!
# Quote source
PHP で Twitter API OAuth 認証 「ログイン」 | WEPICKS! - https://wepicks.net/twitter-restapi-login/  
Upload Video to YouTube using PHP - CodexWorld - https://www.codexworld.com/upload-video-to-youtube-using-php/

# Package
TwitterOAuth - https://github.com/abraham/twitteroauth  
MeCab - https://taku910.github.io/mecab/  
desbma / GoogleSpeech - https://github.com/desbma/GoogleSpeech  