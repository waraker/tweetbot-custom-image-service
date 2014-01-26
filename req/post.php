<?php

switch ($_POST['source']){
	case 'form':
		$origin = 'form';
		break;
	default:
		$origin = 'client';
		break;
}

$credentials = null;
$service_provider = null;
$twitter_response = null;

$host = $_SERVER['SERVER_NAME'];

require'../lib/pseudo-crypt.php';

if(POST_SYSTEM){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		if($origin == 'client'){

			if(isset($_SERVER['HTTP_X_VERIFY_CREDENTIALS_AUTHORIZATION'])) $credentials = $_SERVER['HTTP_X_VERIFY_CREDENTIALS_AUTHORIZATION'];
			if(isset($_SERVER['HTTP_X_AUTH_SERVICE_PROVIDER'])) $service_provider = $_SERVER['HTTP_X_AUTH_SERVICE_PROVIDER'];

			// Validate against Twitter API
			$ch = curl_init();
			$headers = array(
				'Authorization:'.$credentials,
				'X-Auth-Service-Provider:'.$service_provider
			);
			curl_setopt($ch, CURLOPT_URL, "https://api.twitter.com/1.1/account/verify_credentials.json");
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$twitter_response = json_decode(curl_exec($ch), true);
			curl_close($ch);
		}

		if(isset($_FILES['media'])){

			$uid = pseudo_crypt::hash(time());
			$tmp_filepath = '../tmp/'.$uid;

			if(move_uploaded_file($_FILES['media']['tmp_name'], $tmp_filepath)){
				$extension = pathinfo($_FILES['media']['name'], PATHINFO_EXTENSION);
				$image_filename = $uid.'.'.$extension;
				copy($tmp_filepath, $image_filename);
				chmod($image_filename, UPLOADED_IMAGE_PERMISSIONS);
				unlink($tmp_filepath);
			}
			else $error_message .= 'There was an error processing the file.';
		}
		else $error_message .= 'Media error';

		if(DEBUG_TO_FILE){

			$datetime = new DateTime('now', new DateTimeZone('UTC'));

			$log = array();
			$log['origin'] = "origin: $origin\n";
			$log['POST'] = 'post data: '.var_export($_POST, true)."\n";
			$log['FILES'] = 'media data: '.var_export($_FILES, true)."\n";
			$log['extension'] = "extension: $extension\n";
			if($credentials) $log['HTTP_X_VERIFY_CREDENTIALS_AUTHORIZATION'] = "HTTP_X_VERIFY_CREDENTIALS_AUTHORIZATION: $credentials\n";
			if($service_provider) $log['HTTP_X_AUTH_SERVICE_PROVIDER'] = "HTTP_X_AUTH_SERVICE_PROVIDER: $service_provider\n";
			if($twitter_response) $log['twitter_response'] = 'twitter_response: '.var_export($twitter_response, true)."\n";
			if(isset($error_message)) $log['errors'] = 'errors: '.$error_message."\n";
			$log['REMOTE_ADDR'] = 'REMOTE_ADDR: '.$_SERVER['REMOTE_ADDR'];

			$log_filepath = '../log/'.$datetime->format('ymd-Hi').'-'.$image_filename.'.log';
			file_put_contents($log_filepath, $log);
			chmod($log_filepath, UPLOADED_IMAGE_PERMISSIONS);
		}

		// Response
		if($origin == 'client') echo'<mediaurl>http://'.$host.'/'.$image_filename.'</mediaurl>';
		if($origin == 'form') headerLocation($url['view-node'].'/?url='.urlencode('http://'.$host.'/'.$image_filename));
	}
}

?>