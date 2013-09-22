<?php

if(isset($_GET['url'])) $image_url = urldecode($_GET['url'])

?>

<section id="view">
<article>
<h1><?php

echo $image_url;

?></h1>
<a href="<?php

echo $image_url;

?>"><img src="<?php

echo $image_url;

?>"></a>

</article>
</section>