USE instaphoto_db;

CREATE TABLE artworks (
	artwork_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	artist_id INT NOT NULL,
	artwork_photo_id VARCHAR(40) NOT NULL,
	PRIMARY KEY( artwork_id )
) ENGINE=InnoDB;