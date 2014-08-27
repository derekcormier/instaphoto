USE instaphoto_db;

CREATE TABLE users (
	user_id INT NOT NULL AUTO_INCREMENT,
	instagram_user_name VARCHAR(30),
	instagram_access_token VARCHAR(256),
	user_email_address VARCHAR(256) NOT NULL,
	PRIMARY KEY( user_id )
) ENGINE=InnoDB;