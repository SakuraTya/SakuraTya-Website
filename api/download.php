<?php
require_once("../wp-config.php");
function output_json($json) {
	echo json_encode($json);
	exit;
}
$json = array();
if (!is_user_logged_in()){
	$json['status']=3;
	output_json($json);
}
if (!isset($_GET['id'])){
	$json['status']=2;
	output_json($json);
}
$post_id = $_GET['id'];
if(!add_post_meta($post_id, "downloads", 0, true)){
	update_post_meta($post_id, "downloads", get_post_meta($post_id, "downloads", true) + 1);
}
$json['status']=0;
output_json($json);