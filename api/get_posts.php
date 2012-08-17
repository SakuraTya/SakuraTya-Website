<?php
include('./api-config.php');
header('Content-Type: text/plain; charset=utf-8');
$post_id = 10;
$post = get_post($post_id);
/*
 * $return = array();
$return['id'] = $post_id;
$return['category'] = array(
		'name'=>'分类名称',
		'id'=>'分类ID'
);
$return['url'] = $post->guid;
$return['title'] = $post->post_title;
$return['author'] = array('name'=>'作者昵称', 'id'=>'作者ID', 'url'=>"作者页面URL");
$return['tags'] = array(
		array('name'=>'标签名称',
				'id'=>'标签ID'
		),
		array('name'=>'标签名称',
				'id'=>'标签ID'
		)
);
$return['preview'] = '预览图URL';
$return['downloads'] = '下载次数';
$return['favorites'] = '收藏次数';
$return['comments'] = $post->comment_count;
 */
$return = array();
$return['id'] = $post_id;
$cats = get_the_category($post_id);
if ($cats){
	foreach ($cats as $cat){
		$return['category'][] = array(
				'name'=>$cat->name,
				'url'=>get_category_link($cat->term_id)
				);
	}
}
$return['url'] = $post->guid;
$return['title'] = $post->post_title;
$return['author'] = array('name'=>get_author_name($post->post_author), 'id'=>$post->post_author, 'url'=>get_author_posts_url($post->post_author));
$tags = get_the_tags($post_id);
if ($tags){
	foreach ($tags as $tag){
		$return['tags'][]=array(
				'name'=>$tag->name,
				'id'=>$tag->term_id
				);
	}
}
if (function_exists('get_field')){
	$aid = get_field('preview',$post_id);
	if (!$aid == ""){
		$a = wp_get_attachment_image_src($aid, array(240,180));
		$b = wp_get_attachment_image_src($aid,'full');
		$return['preview'] = $a[0];
		$return['preview_big']= $b[0];
	}
}
$return['downloads'] = get_downloads($post_id);
$return['favorites'] = get_favorites($post_id);
$return['comments'] = $post->comment_count;
print json_encode($return);