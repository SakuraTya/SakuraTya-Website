<?php
//header("Content-Type: text/plain; charset=utf-8");
function fileext($file)
{
	return pathinfo($file, PATHINFO_EXTENSION);
}
function get_hot_tags(){
	function clean_data(&$value, $key){
		$value = strip_tags($value);
	}
	$tag = wp_tag_cloud(array('format'=>'array', 'orderby'=>'count', 'order'=>'DESC', 'number'=>20));
	array_walk($tag, "clean_data");
	return $tag;
}
function is_favorite($post_id, $user_id){
	global $wpdb;
	return !is_null($wpdb->get_var("SELECT * FROM `".FAV_NAME."` WHERE `user_id` = ".$user_id." AND `post_id` = ".$post_id));
}
function get_favorites($post_id){
	return get_post_meta($post_id, "liked", true);
}
function get_downloads($post_id){
	return get_post_meta($post_id, "downloads", true);
}