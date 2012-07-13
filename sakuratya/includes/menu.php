<?php
function adjust_the_wp_menu() {
	//remove_submenu_page( 'edit.php', 'edit.php' );
	add_submenu_page('edit.php', '所有文章V2', '所有文章V2', 'edit_posts', __FILE__, function (){
		global $wpdb;
		$post_id = 31;
		$query = "SELECT id FROM `".$wpdb->posts."` WHERE post_author = ".get_current_user_id();
		$result = $wpdb->get_results($query, ARRAY_A);
		print_r(get_post($post_id, ARRAY_A));
	});
}