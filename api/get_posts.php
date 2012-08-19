<?php
include('./api-config.php');
header('Content-Type: text/plain; charset=utf-8');
function filter_where_week( $where = '' ) {
	$where .= " AND post_date > '" . date('Y-m-d', strtotime('-7 days')) . "'";
	return $where;
}
function filter_where_month( $where = '' ) {
	$where .= " AND post_date > '" . date('Y-m-d', strtotime('-31 days')) . "'";
	return $where;
}
function filter_where_3months( $where = '' ) {
	$where .= " AND post_date > '" . date('Y-m-d', strtotime('-93 days')) . "'";
	return $where;
}
function post_json($post){
	$post_id = $post->ID;
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
	return $return;
	
}
switch ($_GET['mode']){
	case 'category':
		if(!isset($_GET['id'])){
			die(json_encode(array('msg'=>'You should give this page the category\'s ID(integer) by GET method.')));
		}
		$id=$_GET['id'];
		$page=isset($_GET['page'])?$_GET['page']:1;
		$time=isset($_GET['time'])?$_GET['time']:'all';
		switch($time){
			case 'all':
				$query=new WP_Query('cat='.$id.'&posts_per_page=8&paged='.$page);
				if($query){
					foreach ($query->posts as $post){
						$return[]=post_json($post);
					}
				}
				echo json_encode($return);
			case 'week':break;
			case 'month':break;
			case '3months':break;
			default:die(json_encode(array('msg'=>'Invalid time span.')));
		}
}
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
