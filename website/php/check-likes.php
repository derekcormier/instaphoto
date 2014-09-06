<?php
	include './db-connect.php';
	require_once './get-likes.php';
	require_once './get-matching-artworks.php';
	
	$users = array();
	
	//Get a list of users to check
	$query = "SELECT user_id, instagram_user_name, instagram_access_token ".
		"FROM users";
	
	$rslt = $mysqli->query($query);
	
	for($i = 0; $r = $rslt->fetch_object(); $i++) {
		$users[$i] = array(
				"user_id" => $r->user_id,
				"instagram_user_name" => $r->instagram_user_name,
				"instagram_access_token" => $r->instagram_access_token);
	}
	
	foreach($users as $user) {
		echo("Checking user " . $user['instagram_user_name'] . "'s likes...<br><br>");
		
		$likedImageIds = get350LikesFromAccessToken($user['instagram_access_token']);
		
		$matchedLikes = getMatchingArtworks($likedImageIds, $mysqli);
		
		foreach($matchedLikes as $matchedLike) {
			$query = "INSERT INTO likes (user_id, liked_photo_id, user_notified) ".
					"SELECT * FROM (SELECT " . $user['user_id'] . ", '" . $matchedLike . "', false) AS tmp ".
					"WHERE NOT EXISTS (".
					"SELECT user_id, liked_photo_id FROM likes WHERE user_id=" . $user['user_id'] .
							" AND liked_photo_id='" . $matchedLike . "'".
					") LIMIT 1";
			
			$mysqli->query($query);
		}
		
		echo "Total matched likes: " . count($matchedLikes) . "<br>";
		
		echo "<br> Total likes: " . $likesCount . "<br><br>";
	}
?>