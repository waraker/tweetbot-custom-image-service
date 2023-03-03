# Tweetbot Custom Image Service

---

## Update 2023

Twitter suspended access to Tweetbot on 12.1.23. See: https://tapbots.com/tweetbot/


## Update 2022

Tweetbot removed the custom image service in iOS version 6.


## Overview

Enables the use of the custom image upload capabilities of Tweetbot on iOS and OS X: <a href="https://tapbots.net/tweetbot/custom_media/">https://tapbots.net/tweetbot/custom_media/</a>

Utilises OAuth Echo outlined here: <a href="https://developer.twitter.com/en/docs/authentication/oauth-1-0a/oauth-echo">https://developer.twitter.com/en/docs/authentication/oauth-1-0a/oauth-echo</a>

Additionally it can be used as a vanilla image upload service by using the test image post functionality.


## Usage

Set your Tweetbot image upload service to custom and the API endpoint to `example.com/api`.

Images attached to your tweets are returned to Tweetbot as four character base 62 alpha-numeric named files e.g. `example.com/Z1h4.jpg`.


## Testing image posting

Use the form at `example.com/post`.


## Logging

Set `DEBUG_TO_FILE` to enable debugging information. Each image upload outputs a file to `./log`.
