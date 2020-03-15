# Happiestbot
Collect happy tweets.

# Caution!
This bot is not completed! Please try this at your own risk, but I don't recommend... If you just want to check how it works, try the sample bot below.  
このbotは完成していません！試す場合は自己責任でお願いしますが、おすすめはしません。実際の動作の確認は以下のサンプルボットをどうぞ。

# Sample
## 幸せうんちくんbot
Twitter - https://twitter.com/IamHappiestPoop  
YouTube - https://www.youtube.com/channel/UCtpBLAoNCGs32cnn8Mu06-A 
Discord - https://bonychops.com/experiment/Happinessbot/sample/discord.php

# How it works
First, this bot will search for one happy word that bot chose. Then it checks it doesn't include any unhappy word. Then tweet it.

# Language
This bot is in Japanese but you can make this in English and other language.  
Please edit `chooseTweet.php`.


# First Setup
1. Go https://developer.twitter.com/ and create your app.
1. Run command `git clone https://github.com/BonyChops/Happinessbot.git` to download this.
1. Run command `composer require abraham/twitteroauth`
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
11. Edit crontab to make this bot can tweet itself.  
For example, if you want to make it to tweet every 20 minutes,
```
*/20 * * * * sh path/to/Happiestbot/run.sh
```
12. Done!
# Feature
- Search tweets with happy words and tweet.
- Send a reply to users who mentioned bot or sent a reply to the bot. (documentation not yet)
- Learn verbs and nouns from several tweets (but humans have to teach which is a happy word and not). (documentation not yet)
- Post the video to YouTube which reports the happiest tweet in the day. (Now developing)

# Quote source
PHP で Twitter API OAuth 認証 「ログイン」 | WEPICKS! - https://wepicks.net/twitter-restapi-login/  
Upload Video to YouTube using PHP - CodexWorld - https://www.codexworld.com/upload-video-to-youtube-using-php/
Videos: insert  |  YouTube Data API  |  Google Developers- https://developers.google.com/youtube/v3/docs/videos/insert

# Package
TwitterOAuth - https://github.com/abraham/twitteroauth  
MeCab - https://taku910.github.io/mecab/  
desbma / GoogleSpeech - https://github.com/desbma/GoogleSpeech  
googleapis / google-api-php-client - https://github.com/googleapis/google-api-php-client
teamreflex / DiscordPHP - https://github.com/teamreflex/DiscordPHP