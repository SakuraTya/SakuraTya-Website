<?php
require_once('api-config.php');
if (!isset($_GET['key'])){
	header("HTTP/1.1 403");
	echo("No authcation key found.");
	exit;
}
if (strcasecmp($_GET['key'], API_KEY)!=0){
	header("HTTP/1.1 403");
	echo("Key does not match.");
	exit;
}
if (!isset($_GET['id'])){
	header("HTTP/1.1 500");
	echo("No page ID found.");
	exit;
}
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($mysqli->errno) {
	header("HTTP/1.1 500");
	echo("Unable to connect to the database.");
	$mysqli->close();
	exit;
}
$mysqli->autocommit(FALSE);
$mysqli->query("UPDATE  `wordpress`.`wp_acf` SET  `value` = `value` + 1 WHERE  `wp_acf`.`post_id` =" . $_GET['id'] . " AND  `wp_acf`.`key` =  'like'  AND  `wp_acf`.`data_type` =" . DT_LIKE . " LIMIT 1 ;");
if ($mysqli->affected_rows != 1){
	header("HTTP/1.1 500");
	echo("There was a problem with the like action.");
	$mysqli->rollback();
	$mysqli->close();
	exit;
}
$mysqli->commit();
header("HTTP/1.1 200 OK");
$mysqli->close();