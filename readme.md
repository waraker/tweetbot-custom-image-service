# Tweetbot Custom Image Service

---

## Features

Enables the use of the custom image upload capabilities of Tweetbot for iOS and OS X: <a href="http://tapbots.net/tweetbot/custom_media/">http://tapbots.net/tweetbot/custom_media/</a>

Utilises OAuth Echo outlined here: <a href="http://dev.twitter.com/pages/oauth_echo">http://dev.twitter.com/pages/oauth_echo</a>

Additionally it can be used as a vanilla image upload service by utilising the test image post functionality.

## Usage

Set your Tweetbot image upload service to custom and the API endpoint to `http://yoursite.com/api`.

Images attached to your tweets are returned to Tweetbot as four character base 62 alpha-numeric named files e.g. `http://yoursite.com/Z1h4.jpg`.

## Testing

Use the HTML form at `http://yoursite.com/post`.

## Logging

Set the `DEBUG_TO_FILE` constant to enable debugging information. Each image upload outputs a file to `./log`.
