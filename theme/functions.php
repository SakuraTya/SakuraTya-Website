<?php
define('FAV_NAME', $table_prefix . "favorites");
function rank_score_calc($post, $dc, $vc, $g){
	date_default_timezone_set('Asia/Shanghai');
	$cc = (int)$post->comment_count;
	$dtm = new DateTime($post->post_modified);
	$dtn = new DateTime();
	$span = $dtn->diff($dtm)->days;
	$score = (0.5*$dc + 0.3*$cc + 0.2*$vc)/(pow($span+2,$g));
	return $score;
}
//@todo 须在单独文章显示页面放入set_post_views函数，统计浏览数
function set_post_views($postID) {
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
	}else{
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}
function get_post_views($postID){
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
		return "0";
	}
	return $count;
}
function is_favorite($post_id, $user_id){
	global $wpdb;
	return $wpdb->get_var("SELECT COUNT(*) FROM `".FAV_NAME."` WHERE `user_id` = ".$user_id." AND `post_id` = ".$post_id)!=0;
}
function get_favorites($post_id){
	global $wpdb;
	return $wpdb->get_var("SELECT COUNT(*) FROM `".FAV_NAME."` WHERE `post_id` = ".$post_id);
}
function get_downloads($post_id){
	$r = get_post_meta($post_id, "downloads", true);
	if ($r ==""){return 0;}else{return $r;}
}
function work_block($post){
	global $wpdb;
	$id = $post->ID;
	$tags = get_the_tags($id);
	$dc=get_downloads($id);
	$fc=get_favorites($id);
	//@todo 排行榜每天0点更新，需在配置时写入crontab
	if (function_exists('get_field')){
		$aid = get_field('preview',$post_id);
		if (!$aid == ""){
			$a = wp_get_attachment_image_src($aid, array(240,180));
			$b = wp_get_attachment_image_src($aid,'full');
			$preview= $a[0];
			$preview_big= $b[0];
			unset($a);unset($b);
		}
	}
	?>
<div id="work_id_<?php echo $id;?>" class="works_panel">
	<div class="work_content_wrapper">
		<div class="preview_img_wrapper">
			<a href="<?php echo $post->guid;?>">
				<img src="<?php echo $preview;?>" />
			</a>
				<div class="img_lightbox_controls">
					<a href="<?php echo $preview_big;?>" class="zoom_in_tool"></a>
				</div>
		</div>
		<div class="work_title">
			<a href="<?php echo $post->guid;?>" title="<?php echo $post->post_title;?>"><?php echo $post->post_title."(".rank_score_calc($post, $dc, get_post_views($id), 1).")";?></a>
		</div>
        <div class="work_author">
			<span>by</span>
			<a href="<?php echo get_author_posts_url($post->post_author);?>"><?php echo get_author_name($post->post_author);?></a>
		</div>
		<div class="work_tags">
			<!-- data attribute in li element is tagID, the text is tagName -->
			<ul>
				<?php if($tags){?>
					<?php foreach ($tags as $tag){?>
					<li data="<?php echo $tag->term_id;?>"><?php echo $tag->name;?></li>
					<?php }?>
				<?php }?>
				<div style="clear:both;display:block;"></div>
			</ul>
		</div>
		<div class="work_panel_divider"></div>
		<div class="statistics_show_wrapper">
			<div class="statistics_downloads_wrapper" title="<?php echo $dc;?>次下载">
				<div class="downloads_icon"></div>
					<span><?php echo $dc;?></span>
			</div>
		<div class="statistics_comments_wrapper" title="<?php echo $post->comment_count;?>条评论">
			<div class="comments_icon"></div>
			<span><?php echo $post->comment_count;?></span>
		</div>
		<div class="statistics_favorites_wrapper" title="<?php echo $fc;?>次收藏">
			<div class="favorites_icon"></div>
			<span><?php echo $fc;?></span>
		</div>
		</div>
	</div>
	<div class="work_special_indicator"></div>
</div>
                <?php
}