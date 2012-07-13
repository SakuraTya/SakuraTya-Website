<?php
function sakuratya_add_page_ava(){
	add_menu_page('头像设置', '头像设置', 'read', __FILE__, 'sakuratya_show_avatar_page');
}
function sakuratya_show_avatar_page(){
	if (!is_user_logged_in()){
		die;
	}
	$mime = array(
			'image/jpeg'=>'.jpg',
			'image/bmp'=>'.bmp',
			'image/gif'=>'.gif',
			'image/png'=>'.png'
			);
	if(isset($_FILES['avatar'])){
		if($_FILES['avatar']['error'] != 0){
			//当文件上传发生错误
			$errors =  array(
					1=>'文件大小超出'.ini_get('upload_max_filesize').'的限制。',
					3=>'文件没有完全上传，请检查您的网络并重新上传。',
					4=>'请指定要上传的文件。',
					8=>'出现内部错误，错误代码为8，请联系管理员。',
					6=>'出现内部错误，错误代码为6，请联系管理员。',
					7=>'出现内部错误，错误代码为7，请联系管理员。',
					);
			print("<strong>".$errors[$_FILES['avatar']['error']]."</strong><br>上传失败。");
		}elseif(!array_key_exists($_FILES['avatar']['type'], $mime)){
			//当文件类型不符合规定
			print("<strong>只支持JPG/BMP/GIF/PNG格式的头像上传。</strong><br>上传失败。");
		}
		$store_dir = ABSPATH . "avatar/users/";
		$result = move_uploaded_file($_FILES['avatar']['tmp_name'], $store_dir.get_current_user_id().$mime[$_FILES['avatar']['type']]);
		if (get_user_meta(get_current_user_id(), 'have_avatar', true)){
			if (unlink($store_dir.get_current_user_id().get_user_meta(get_current_user_id(), 'avatar_ext', true))==false){
				$result = 10;
			}
		}
		if ($result == 1){
			echo "<strong>文件上传成功。</strong>";
			add_user_meta(get_current_user_id(), 'have_avatar', true, true);
			update_user_meta(get_current_user_id(), 'have_avatar', true);
			add_user_meta(get_current_user_id(), 'avatar_ext', $mime[$_FILES['avatar']['type']], true);
			update_user_meta(get_current_user_id(), 'avatar_ext', $mime[$_FILES['avatar']['type']]);
		}else{
			echo "<strong>出现内部错误，错误代码为10，请联系管理员。</strong>";
		}
	}
	if (get_user_meta(get_current_user_id(), 'have_avatar', true)){
		echo "<img src=\"/avatar/users/".get_current_user_id().get_user_meta(get_current_user_id(), 'avatar_ext', true)."\" /><br>";
	}
?>
	<h1>头像设置</h1>
	<strong>文件大小限制：<?php echo ini_get('upload_max_filesize');?>，支持JPG/BMP/GIF/PNG格式</strong>
	<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post" enctype="multipart/form-data">
	<input type="file" name="avatar" />
	<input type="submit" value="提交" />
	</form>
<?php }