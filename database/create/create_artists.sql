USE instaphoto_db;

CREATE TABLE artists (
	artist_id INT NOT NULL AUTO_INCREMENT,
	artist_instagram_user_name VARCHAR(30),
	artist_instagram_access_token VARCHAR(256),
	PRIMARY KEY( artist_id )
) ENGINE=InnoDB;