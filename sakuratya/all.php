<?php
/*
 Plugin Name: 各种杂七杂八的前端和后端函数等
 */

require('includes/favorite.php');
//require('includes/menu.php');
require('includes/def.php');
require('includes/avatar.php');
//add_action('admin_menu', 'adjust_the_wp_menu', 999 );
add_filter('default_content', 'sakuratya_def_cont');
add_filter('default_title', 'sakuratya_def_title');
add_action('admin_menu', 'sakuratya_add_page_fav');
add_action('admin_menu', 'sakuratya_add_page_ava');
?>
	