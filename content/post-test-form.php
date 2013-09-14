<?php

require '../req/conf.php'

?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Post Test Form</title>
</head>
<body>
<form enctype="multipart/form-data" method="post" action="/<?php

echo $url['api-node'];

?>">
<input type="hidden" name="source" value="form">
<input name="media" type="file">
<input type="submit" value="Upload">
</form>
</body>
</html>