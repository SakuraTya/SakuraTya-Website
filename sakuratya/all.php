<?php
/*
 Plugin Name: 各种杂七杂八的前端和后端函数等
 */
add_filter('default_content', 'sakuratya_def_cont');
function sakuratya_def_cont(){
	return '这里填写日志内容，请不要使用&lt;script&gt;、&lt;style&gt;等非格式标签';
}
add_filter('default_title', 'sakuratya_def_title');
function sakuratya_def_title(){
	return '这里填写标题';
}
add_action('publish_post', 'sakuratya_publish');
function sakuratya_publish($id){
	global $wpdb;
	$the_post = get_post($id);
	$sql = sprintf("INSERT INTO  `wp_acf` (`id` ,`post_id` ,`key` ,`value`)VALUES (NULL , '%d', '%s', '%s');", $the_post->ID,  'title', $the_post->post_title);
	$wpdb->query($sql);
}