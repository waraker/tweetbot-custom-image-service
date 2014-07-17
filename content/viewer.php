<?php

if (filter_var($_GET['url'], FILTER_VALIDATE_URL)) {

	$image_url = $_GET['url'];
	//error_log($image_url);
	$url_data = parse_url($image_url);
	//print_r($url_data);

	// Permit viewing of a local image only.
	if ($url_data['host'] == $_SERVER['SERVER_NAME']) { ?>

<section id="view">
<article>
<h1><a href="<?php echo $image_url; ?>"><?php echo $image_url; ?></a></h1>
<a href="<?php echo $image_url; ?>"><img src="<?php echo $image_url; ?>"></a>
</article>
</section><?php

	}
	else echo 'Sorry, I can only show a local image.';
}
else echo 'Invalid image URL.';

?>