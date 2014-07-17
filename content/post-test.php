<?php

require '../req/conf.php'

?>

<form enctype="multipart/form-data" method="post" action="/<?php echo $url['api-node']; ?>">
<input type="hidden" name="source" value="form">
<input name="media" type="file">
<input type="submit" value="Upload">
</form>