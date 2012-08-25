<?php
require_once("./api-config.php");
add_post_meta($_GET['id'], "favorited", 0, true);
$json = array();
function add_favorite($post_id, $user_id){
	global $wpdb;
	if ($wpdb->insert(FAV_NAME, array('post_id'=>$post_id, 'user_id'=>$user_id)) == false){
		return false;
	}
	return true;
}
function remove_favorite($post_id, $user_id){
	global $wpdb;
	$wpdb->query("DELETE FROM ".FAV_NAME." WHERE `post_id` = ".$post_id." AND `user_id` = ".$user_id);
}
if (!is_user_logged_in()){
	$json['status']=3;
	echo json_encode($json);
	exit;
}
if (!isset($_GET['action'])){
	$json['status']=2;
	echo json_encode($json);
	exit;
}
if (!isset($_GET['id'])){
	$json['status']=2;
	echo json_encode($json);
	exit;
}
switch($_GET['action']){
	case "add":
		if (!add_favorite($_GET['id'], get_current_user_id())){
			$json['status']=2;
			echo json_encode($json);
			exit;
		}
		break;
	case "remove":
		remove_favorite($_GET['id'], get_current_user_id());
		break;
}
$json['status']=0;
echo json_encode($json);