<?php
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
	return !is_null($wpdb->get_var("SELECT * FROM `".FAV_NAME."` WHERE `user_id` = ".$user_id." AND `post_id` = ".$post_id));
}
function get_favorites($post_id){
	//$r = get_post_meta($post_id, "favorited", true);
	//if ($r == ""){return 0;}else{return $r;}
	return 9;
}
function get_downloads($post_id){
	$r = get_post_meta($post_id, "downloads", true);
	if ($r ==""){return 0;}else{return $r;}
}
function work_block($post){
	global $wpdb;
	$id = $post->ID;
	//$post = get_post($id, ARRAY_A);
	$tags = get_the_tags($id);
	//print_r($tags);
	$dc=get_downloads($id);
	$fc=get_favorites($id);
	$ra = (int)((100 * log($post->comment_count,10)) + (200 * log($dc,10)) + (10 * sqrt(log(100,10))) - (((int)(time()/60/60/24) - (int)(strtotime($post->post_date)/60/60/24)) * ((int)(time()/60/60/24) - log((int)(strtotime($post->post_date)/60/60/24),10))));
	?>
<div id="work_id_<?php echo $id;?>" class="works_panel">
	<div class="work_content_wrapper">
		<div class="preview_img_wrapper">
			<a href="<?php echo $post->guid;?>">
				<img src="<?php get_field("preview", $id);?>" />
			</a>
				<div class="img_lightbox_controls">
					<a href="<?php get_field("preview", $id);?>" class="zoom_in_tool"></a>
				</div>
		</div>
		<div class="work_title">
			<a href="<?php echo $post->guid;?>" title="<?php echo $post->post_title.'['.$ra.']'.get_post_views($id);?>"><?php echo $post->post_title.'['.$ra.']';?></a>
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