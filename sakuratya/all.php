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
add_action('admin_menu', 'sakuratya_add_pages');
function sakuratya_add_pages(){
	add_menu_page('管理收藏', '收藏管理', 'read', __FILE__, 'sakuratya_show_favorites_page');
}
function sakuratya_get_post_info($post_id){
	$the_post = get_post($post_id, ARRAY_A);
	?>
	<a href="<?php echo $the_post['guid']?>"><?php echo $the_post['post_title']?></a>
	<?php 
}
function sakuratya_show_favorites_page(){
	global $wpdb;
	global $table_prefix;
	echo "<h1>收藏管理</h1>";
	$query = "SELECT `post_id` FROM `".$table_prefix."favorites` WHERE `user_id` = ".get_current_user_id();
	$result = $wpdb->get_results($query, ARRAY_A);
	foreach($result as $post_id){
		sakuratya_get_post_info($post_id['post_id']);
		?>
		<a href="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>&action=del&id=<?php echo $post_id['post_id']?>">删除</a><br/>
		<?php 
	}
}