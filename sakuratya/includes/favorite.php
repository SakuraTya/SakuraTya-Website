<?php
function sakuratya_add_page_fav(){
	add_menu_page('管理收藏', '收藏管理', 'read', __FILE__, 'sakuratya_show_favorite_page');
}
/**
 * 收藏管理函数。
 */
function sakuratya_show_favorite_page(){
	global $wpdb;
	global $table_prefix;
	if (isset($_GET['action'])){
		switch ($_GET['action']){
			case "del":
				$query = "DELETE FROM `".$table_prefix."favorites` WHERE `post_id` = ".$_GET['id']." AND `user_id` = ".get_current_user_id();
				$wpdb->query($query);
		}
	}
	echo "<h1>收藏管理</h1>";
	$query = "SELECT `post_id` FROM `".$table_prefix."favorites` WHERE `user_id` = ".get_current_user_id();
	//echo $query."<br/>";
	$result = $wpdb->get_results($query, ARRAY_A);
	foreach($result as $post_id){
		sakuratya_get_post_info($post_id['post_id']);
		?>
		<a href="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>&action=del&id=<?php echo $post_id['post_id']?>">删除</a><br/>
		<?php 
	}
}
function sakuratya_get_post_info($post_id){
	$the_post = get_post($post_id, ARRAY_A);
	//print_r ($the_post);
	?>
		<a href="<?php echo $the_post['guid']?>"><?php echo $the_post['post_title']?></a>
		<?php 
}