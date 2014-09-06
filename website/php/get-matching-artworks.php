<?php
	
	// This function takes an array of photo IDs and checks them against
	//	the artworks in the database and returns an array of photo IDs
	//	which matched IDs in the artworks database
	function getMatchingArtworks($photoIds, $mysqli) {
		
		$matchingArtworkIds = array();
		
		$likesCount = count($photoIds);
		
		if($likesCount > 0) {
			$query = "SELECT artwork_photo_id ".
					"FROM artworks ";
				
			for($i = 0; $i < $likesCount; $i++) {
				if($i != 0) {
					$query = $query . " OR ";
				} else {
					$query = $query . "WHERE ";
				}
				$query = $query . "artwork_photo_id='" . $photoIds[$i] . "'";
			}
			
			$rslt = $mysqli->query($query);
				
			for($i = 0; $r = $rslt->fetch_object(); $i++) {
				$matchingArtworkIds[$i] = array("likedPhoto" => $r->artwork_photo_id);
			}
		}
		
		return $matchingArtworkIds;
	}

?>