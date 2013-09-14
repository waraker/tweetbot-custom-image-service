<?php

/* ----- URL To Array -----
v1.2.1
*/
function URL2Array(){
	$uri = $_SERVER['REQUEST_URI'];
	$uri = trim($uri, '/');
	if(!empty($uri)) return explode('/', $uri);
}

/* ----- Header Location -----
v1.3.2
*/
function headerLocation($location='', $note=''){
	$url = 'http://'.$_SERVER['SERVER_NAME'].'/'.$location;
	if(HEADER_LOCATION){
		header('Location: '.$url);
		exit;
	}
	else{
		if($note) $output = '"'.$note.'" ';
		$output = '<a href="'.$url.'">Location: '.$url.'</a>';
		echo $output;
	}
}

?>