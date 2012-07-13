<?php
//header("Content-Type: text/plain; charset=utf-8");
require_once("./api-config.php");
function fileext($file)
{
	return pathinfo($file, PATHINFO_EXTENSION);
}

/**
 * 生成缩略图
* @param string     源图绝对完整地址{带文件名及后缀名}
* @param string     目标图绝对完整地址{带文件名及后缀名}
* @param int        缩略图宽{0:此时目标高度不能为0，目标宽度为源图宽*(目标高度/源图高)}
* @param int        缩略图高{0:此时目标宽度不能为0，目标高度为源图高*(目标宽度/源图宽)}
* @param int        是否裁切{宽,高必须非0}
* @param int/float  缩放{0:不缩放, 0<this<1:缩放到相应比例(此时宽高限制和裁切均失效)}
* @return boolean
*/
function img2thumb($src_img, $dst_img, $width = 75, $height = 75, $cut = 0, $proportion = 0)
{
	if(!is_file($src_img))
	{
		return false;
	}
	$ot = fileext($dst_img);
	$otfunc = 'image' . ($ot == 'jpg' ? 'jpeg' : $ot);
	$srcinfo = getimagesize($src_img);
	$src_w = $srcinfo[0];
	$src_h = $srcinfo[1];
	$type  = strtolower(substr(image_type_to_extension($srcinfo[2]), 1));
	$createfun = 'imagecreatefrom' . ($type == 'jpg' ? 'jpeg' : $type);

	$dst_h = $height;
	$dst_w = $width;
	$x = $y = 0;

	/**
	 * 缩略图不超过源图尺寸（前提是宽或高只有一个）
	 */
	if(($width> $src_w && $height> $src_h) || ($height> $src_h && $width == 0) || ($width> $src_w && $height == 0))
	{
		$proportion = 1;
	}
	if($width> $src_w)
	{
		$dst_w = $width = $src_w;
	}
	if($height> $src_h)
	{
		$dst_h = $height = $src_h;
	}

	if(!$width && !$height && !$proportion)
	{
		return false;
	}
	if(!$proportion)
	{
		if($cut == 0)
		{
			if($dst_w && $dst_h)
			{
				if($dst_w/$src_w> $dst_h/$src_h)
				{
					$dst_w = $src_w * ($dst_h / $src_h);
					$x = 0 - ($dst_w - $width) / 2;
				}
				else
				{
					$dst_h = $src_h * ($dst_w / $src_w);
					$y = 0 - ($dst_h - $height) / 2;
				}
			}
			else if($dst_w xor $dst_h)
			{
				if($dst_w && !$dst_h)  //有宽无高
				{
					$propor = $dst_w / $src_w;
					$height = $dst_h  = $src_h * $propor;
				}
				else if(!$dst_w && $dst_h)  //有高无宽
				{
					$propor = $dst_h / $src_h;
					$width  = $dst_w = $src_w * $propor;
				}
			}
		}
		else
		{
			if(!$dst_h)  //裁剪时无高
			{
				$height = $dst_h = $dst_w;
			}
			if(!$dst_w)  //裁剪时无宽
			{
				$width = $dst_w = $dst_h;
			}
			$propor = min(max($dst_w / $src_w, $dst_h / $src_h), 1);
			$dst_w = (int)round($src_w * $propor);
			$dst_h = (int)round($src_h * $propor);
			$x = ($width - $dst_w) / 2;
			$y = ($height - $dst_h) / 2;
		}
	}
	else
	{
		$proportion = min($proportion, 1);
		$height = $dst_h = $src_h * $proportion;
		$width  = $dst_w = $src_w * $proportion;
	}

	$src = $createfun($src_img);
	$dst = imagecreatetruecolor($width ? $width : $dst_w, $height ? $height : $dst_h);
	$white = imagecolorallocate($dst, 255, 255, 255);
	imagefill($dst, 0, 0, $white);

	if(function_exists('imagecopyresampled'))
	{
		imagecopyresampled($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
	}
	else
	{
		imagecopyresized($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
	}
	$otfunc($dst, $dst_img);
	imagedestroy($dst);
	imagedestroy($src);
	return true;
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