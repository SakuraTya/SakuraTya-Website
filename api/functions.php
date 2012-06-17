<?php
header("Content-Type: text/plain; charset=utf-8");
require_once("./api-config.php");
function get_hot_tags(){
	function clean_data(&$value, $key){
		$value = strip_tags($value);
	}
	$tag = wp_tag_cloud(array('format'=>'array', 'orderby'=>'count', 'order'=>'DESC', 'number'=>20));
	array_walk($tag, "clean_data");
	return $tag;
}
function is_liked($post_id, $user_id){
	global $wpdb;
	return !is_null($wpdb->get_var("SELECT * FROM `".FAV_NAME."` WHERE `user_id` = ".$user_id." AND `post_id` = ".$post_id));
}
function get_likes($post_id){
	return get_post_meta($post_id, "liked", true);
}
function get_downloads($post_id){
	return get_post_meta($post_id, "downloads", true);
}
function get_post_info($post_id){
	$post = get_post($post_id, ARRAY_A);
	$user = get_userdata($post['ID']);
	$info = array(
			'title'=>$post['post_title'], 
			'url'=>$post['guid'],
			'comments'=>$post['comment_count'],
			'author'=>$user->data->display_name,
			'preview'=>get_field("preview", $post_id));
	print_r($info);
	print_r(get_userdata(1));
}
echo is_liked(2,1);
get_post_info(1);