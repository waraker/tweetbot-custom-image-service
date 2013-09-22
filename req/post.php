<?php

switch ($_POST['source']){
	case 'form':
		$origin = 'form';
		break;
	default:
		$origin = 'client';
		break;
}

$host = $_SERVER['SERVER_NAME'];

require'../lib/pseudo-crypt.php';

if(POST_SYSTEM){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		if($origin == 'client'){

			$credentials = null;
			$service_provider = null;
			$twitter_response = null;

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
				copy($tmp_filepath, $uid.'.'.$extension);
				unlink($tmp_filepath);

				// Response
				if($origin == 'client') echo'<mediaurl>http://'.$host.'/'.$uid.'.'.$extension.'</mediaurl>';
				if($origin == 'form') echo'<img src="http://'.$host.'/'.$uid.'.'.$extension.'"><p><a href="http://'.$host.'/'.$uid.'.'.$extension.'">http://'.$host.'/'.$uid.'.'.$extension.'</a></p>';
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

			file_put_contents('../log/'.$datetime->format('ymd-Hi').'-'.$uid.'.'.$extension.'.log', $log);
		}
	}
}

?>