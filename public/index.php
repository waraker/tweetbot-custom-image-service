<?php

require'../req/server.php';
require'../req/conf.php';
require'../req/function.php';

$l = URL2Array();

if(SITE_LIVE) $load_site = true;
elseif(in_array($_SERVER['REMOTE_ADDR'], $admin_ip_address)) $load_site = true;
else{
	if($l) headerLocation();
	$load_site = false;
}

if($load_site){

	require'../req/switch.php';

	if(!$api){
		require'../req/head.php';
		require'../req/body.php';
	}
}
else require'content/holding.php';

?>