<?php

$error_message = 'error';

if(filter_var($_GET['url'], FILTER_VALIDATE_URL)){

	$image_url = $_GET['url'];
	$url_data = parse_url($image_url);

	// Only permit viewing of a local image
	if($url_data['host'] == $_SERVER['SERVER_NAME']){

		?>

<section id="view">
<article>
<h1><a href="/<?php

		echo $image_url;

		?>"><?php

		echo $image_url;

		?></a></h1>
<a href="/<?php

		echo $image_url;

		?>"><img src="<?php

		echo $image_url;

		?>"></a>
</article>
</section><?php

	}
	else echo $error_message;
}
else echo $error_message;

?>