<?php

$api = false;
$content = null;

/* ----- Landing Page ----- */
if(empty($l)){
	$content = 'landing';
}

/* ----- Twitter API enpoint ----- */
elseif($l[0] == $url['api-node']){
	$api = true;
	require'post.php';
}

/* --- Post Test --- */
elseif($l[0] == $url['post-test-node']){
	$api = true;
	require'../content/post-test-form.php';
}

/* ----- Error ----- */
elseif($l[0] == $url['error-node']){
	$content = 'error';
}

else headerLocation($url['error-node']);

?>