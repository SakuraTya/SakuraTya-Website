CREATE TABLE wp_score (
	post_id BIGINT(20) unsigned NOT NULL,
	score DOUBLE NOT NULL,
	PRIMARY KEY (post_id)
)ENGINE=InnoDB;