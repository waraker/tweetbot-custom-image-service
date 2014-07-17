<?php

$api = false;
$content = null;

// Landing Page
if (empty($l)) {
	$content = 'landing';
}

// Twitter API enpoint
elseif ($l[0] == $url['api-node']) {
	$api = true;
	require'post.php';
}

// Post Test
elseif ($l[0] == $url['post-test-node']) {
	$content = 'post-test';
}

// Viewer
elseif ($l[0] == $url['view-node']) {
	$content = 'viewer';
}

// Error
elseif ($l[0] == $url['error-node']) {
	$content = 'error';
}

else headerLocation($url['error-node']);

?>