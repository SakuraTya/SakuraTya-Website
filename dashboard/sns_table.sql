CREATE TABLE `user_sns`(
	`UID` bigint(20) unsigned NOT NULL,
	`sns_type` varchar(10) NOT NULL,
	`ext_data` varchar(233) NOT NULL,
	PRIMARY KEY (`UID`,`sns_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;