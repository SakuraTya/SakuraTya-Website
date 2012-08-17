DROP TABLE IF EXISTS `wp_favorites`;
CREATE TABLE `wp_favorites` (
  `user_id` bigint(20) unsigned NOT NULL,
  `post_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;