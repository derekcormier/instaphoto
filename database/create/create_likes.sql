USE instaphoto_db;

CREATE TABLE likes (
	like_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	liked_photo_id VARCHAR(40) NOT NULL,
	user_notified BOOLEAN NOT NULL,
	PRIMARY KEY( like_id )
) ENGINE=InnoDB;