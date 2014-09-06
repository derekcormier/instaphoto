<?php 

	// This function takoes the user's access token as a parameter and
	//	requests likes from the Instagram API until it either has 350+
	//	or there are no likes left to get. The liked image IDs are
	//	returned in an array.
	function get350LikesFromAccessToken($access_token) {
		
		$likesCount = 0;			// Counts likes recieved from the server
		$likedImageIds = array();	// Stores the image ids of the images the user liked
		$maxLikeID = null;			// Stores the max_like_id, if recieved from the server, for
									//	pagination
		
		do {
			$getLikesURL = "https://api.instagram.com/v1/users/self/media/liked" .	// The URL to access
					"?access_token=" . $access_token;								// user's likes
			
			if($maxLikeID != null) {										// If the response included 
				$getLikesURL = $getLikesURL . "&max_like_id=" . $maxLikeID;	// a max like ID, add this
			}																// to the URL to get the next
																			// page
				
			$curlHandle = curl_init($getLikesURL);					
			curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);	// Have cURL return the data as 
																	// variable instead of printing
				
			$responseJSON = curl_exec($curlHandle);
				
			$likes = json_decode($responseJSON, true);
				
			foreach($likes['data'] as $like) {				
				array_push($likedImageIds,$like['id']);		// Add each liked image ID to the array
				$likesCount++;
			}
				
			if(!empty($likes['pagination']['next_max_like_id'])) {		// Set max like ID if it was
				$maxLikeID = $likes['pagination']['next_max_like_id'];	// returned
			} else {
				$maxLikeID = null;
			}
		
		} while($likesCount < 350 && $maxLikeID != null);	// While there are still likes left, or we've
															// grabbed 350 already

		return $likedImageIds;
	}
?>