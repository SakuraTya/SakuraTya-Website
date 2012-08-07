<?php
function get_post_tags($id){
	$query = "SELECT `term_taxonomy_id` FROM `wp_term_relationships`
			WHERE `object_id`=".$id;
	$wpdb->get_results($query, ARRAY_A);
	$tags = array();
	foreach ($wpdb->get_results($query, ARRAY_A)as $d){
		$tid = $d['term_taxonomy_id'];
		$query = "SELECT name, slug FROM `wp_terms` WHERE term_id=".$tid;
		$result = $wpdb->get_results($query, ARRAY_A);
		$tags[]=array_merge($result[0], array('url'=>'/?tag='.$result[0]['slug']));
	}
	return $tags;
}
function work_block($id){
	global $wpdb;
	if (!is_int($id)){return false;}
	$post = get_post($id, ARRAY_A);
	print_r($tags);
	?>
<div id="work_id_<?php echo $post['id'];?>" class="works_panel">
	<div class="work_content_wrapper">
		<div class="preview_img_wrapper">
			<a href="<?php echo $post['guid'];?>">
				<img src="<?php //prev_img_small?>" />
			</a>
				<div class="img_lightbox_controls">
					<a href="<?php //prev_img_big?>" class="zoom_in_tool"></a>
				</div>
		</div>
		<div class="work_title">
			<a href="<?php echo $post['guid'];?>" title="<?php echo $post['post_title'];?>"><?php echo $post['post_title'];?></a>
		</div>
        <div class="work_author">
			<span>by</span>
			<a href="<?php echo get_author_posts_url($post['post_author']);?>"><?php echo get_author_name($post['post_author']);?></a>
		</div>
		<div class="work_tags">
			<!-- data attribute in li element is tagID, the text is tagName -->
			<ul>
				<li data="<?php //tag id?>"><?php //tag name?></li>
				<div style="clear:both;display:block;"></div>
			</ul>
		</div>
		<div class="work_panel_divider"></div>
		<div class="statistics_show_wrapper">
			<div class="statistics_downloads_wrapper" title="<?php //download_count?>次下载">
				<div class="downloads_icon"></div>
					<span><?php //download_count?></span>
			</div>
		<div class="statistics_comments_wrapper" title="<?php //comment count?>条评论">
			<div class="comments_icon"></div>
			<span><?php //comment count?></span>
		</div>
		<div class="statistics_favorites_wrapper" title="<?php //favorite count?>次收藏">
			<div class="favorites_icon"></div>
			<span><?php //favorite count?></span>
		</div>
		</div>
	</div>
	<div class="work_special_indicator"></div>
</div>
                <?php
}