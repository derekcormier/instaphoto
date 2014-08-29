<?php 
	session_start();
	require_once './db-connect.php';
	
	// Get the code from the GET request
	$instagramCode = $_GET['code'];
		
	// POST variables to send
	$postVariables = array(
		'client_id' => 'ed3786f3ede549e08c407331abe4f77b',
		'client_secret' => 'd713984492ff4423a8260464abdb86e5',
		'grant_type' => 'authorization_code',
		'redirect_uri' => 'http://instaphoto.derekcormier.com/php/get-access-token.php',
		'code' => $instagramCode
	);
	
	$curlHandle = curl_init("https://api.instagram.com/oauth/access_token");
	curl_setopt($curlHandle, CURLOPT_POST, true);
	curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $postVariables);
	curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
	$userInformationJSON = curl_exec($curlHandle);
	
	if(curl_error($curlHandle) !== "") {
		echo 'cURL error: ' . curl_error($curlHandle);
	}
	
	curl_close($curlHandle);
	
	// Decode the JSON to get the information
	$userInformation = json_decode($userInformationJSON, true);
	
	$username = mysqli_real_escape_string($mysqli, $userInformation['user']['username']);
	$accessToken = mysqli_real_escape_string($mysqli, $userInformation['access_token']);
	
	$query = "SELECT instagram_user_name FROM users WHERE instagram_user_name='$username'";
	if(mysqli_num_rows(mysqli_query($mysqli, $query)) === 0){
		$query = "INSERT INTO users (instagram_user_name, instagram_access_token)
					VALUES ('$username', '$accessToken')";
		mysqli_query($mysqli, $query);
	} else {
		$query = "UPDATE users
					SET instagram_access_token='$accessToken'
					WHERE instagram_user_name='$username'";
		mysqli_query($mysqli, $query);
	}
	mysqli_close($mysqli);
				
	// Put the user's information in session variables to use later
	$_SESSION['access_token'] = $userInformation['access_token'];
	$_SESSION['username'] = $userInformation['user']['username'];
	
	header("Location: http://instaphoto.derekcormier.com/successfully-registered.php" . "");
?>