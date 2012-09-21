<?php
/*
Plugin Name: 自定义用户头像
Description: 在不能使用gravatar的情况下，本插件可以替代gravatar为指定的用户组提供头像设置功能
Version: 1.0
Author: Harry Cheng
*/
include("manager.php");
include("user.php");
function avatar_upload(){
	$file=wp_handle_upload($_FILES['avatarFile'],array('test_form' => FALSE));
	if (isset($file['error'])){
		echo json_encode($file);
		return;
	}
	$wp_filetype = wp_check_filetype(basename($file['file']), null );
	$attach=wp_insert_attachment(array(
			'guid'=>$file['file'],
			'post_title'=>get_user_by('id', get_current_user_id())->display_name."的头像",
			'post_content' => '',
     		'post_status' => 'inherit',
			'post_mime_type' => $file['type']
			),$file['file']);
	echo json_encode(array_merge($file,array('aid'=>$attach)));
}
function avatar_admin_head(){
	?>
	<script type="text/javascript" src="/wp-content/plugins/custom-avatar/js/ajaxfileupload.js"></script>
	<?php 
}
function avatar_crop(){
	$file=wp_crop_image($_POST['aid'],$_POST['x'],$_POST['y'],$_POST['w'],$_POST['h'],$_POST['w'],$_POST['h'],false,get_attached_file($_POST['aid']));
	if (!is_file($file)){
		echo json_encode(array('error'=>'图片裁剪失败','status'=>'1'));
		return;
	}
	update_post_meta($_POST['aid'],'avatar_for',get_current_user_id());
	update_user_meta(get_current_user_id(), 'have_avatar', true);
	update_user_meta(get_current_user_id(), 'avatar_id', $_POST['aid']);
	echo json_encode(array('status'=>'0'));
}
function avatar_add_menu(){
	add_submenu_page('users.php','用户头像管理', '头像管理', 'activate_plugins', 'manager.php', 'avatar_create_manager');
	add_submenu_page('users.php','头像设置', '头像设置', 'read', 'user.php', 'avatar_create_user_page');
}
function avatar_del($id){
	$uid=get_post_meta($id,'avatar_for');
	if(is_numeric($uid)){
		update_user_meta($uid,'have_avatar',false);
		delete_post_meta($uid, 'avatar_id');
	}
}
add_action('delete_attachment','avatar_del');
add_action('wp_ajax_avatar_upload', 'avatar_upload');
add_action('wp_ajax_avatar_crop', 'avatar_crop');
add_action('admin_menu', 'avatar_add_menu');
add_action('admin_head', 'avatar_admin_head');