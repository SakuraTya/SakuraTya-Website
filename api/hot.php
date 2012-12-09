<?php
require('../wp-config.php');
//header('Content-Type:text/plain');
global $title;
$title=get_bloginfo('title').' | '.'热门作品';
if(isset($_GET['cat'])){
	
	$title=get_bloginfo('title').' | '.get_category($_GET['cat'])->name.'中的热门作品';
	$pop=$wpdb->get_results('SELECT post_id FROM wp_score LEFT JOIN wp_term_relationships ON wp_score.post_id=wp_term_relationships.object_id WHERE term_taxonomy_id=(SELECT term_id FROM wp_terms WHERE slug=\''.urlencode($_GET['cat']).'\')',ARRAY_N);
}elseif(isset($_GET['tag'])){
	$title=get_bloginfo('title').' | '.get_tag($_GET['tag'])->name.'中的热门作品';
	$pop=$wpdb->get_results('SELECT post_id FROM wp_score LEFT JOIN wp_term_relationships ON wp_score.post_id=wp_term_relationships.object_id WHERE term_taxonomy_id=(SELECT term_id FROM wp_terms WHERE slug=\''.urlencode($_GET['tag']).'\')',ARRAY_N);
}
else{
	$pop=$wpdb->get_results('SELECT * FROM wp_score ORDER BY score DESC',ARRAY_N);
}
get_header('hot');
$i=0;
?>
<script type="text/javascript">
$(document).ready(function() {
	var global_StartItem = 1; //this javascript variable need to convert to php variable.
	navMenuBuilding(global_StartItem);
	layoutWorkPanel(<?php echo count($pop)?>,4);
});
</script>
</head>
<body>
<?php nav_menu();?>
<a style="display: none" id="data_type"><?php if (isset($_GET['cat'])){echo 'cat';}elseif(isset($_GET['tag'])){echo 'tag';}else{ echo 'all';}?></a>
<div id="popular_works_show">
            <div id="popworks_group_header" class="group_header_bg">
                <div id="popworks_group_label"></div>
                <div id="search_box_for_pop">
                    <div class="search_box_wrapper">
                        <span class="search_box_icon"></span>
                        <input class="search_box_input" name="search" id="search_pop" placeholder="搜索..." type="text" />
                    </div>
                </div>
                <div id="tags_selector_for_pop">
                    <ul>
                        <?php 
                        $tags = get_tags();
                        foreach ($tags as $tag){
                        ?>
                        <li data="<?php echo $tag->term_id;?>"><?php echo $tag->name;?></li>
                        <?php }?>
                        <div style="clear:both;display:block;"></div>
                    </ul>
                </div>
                <div id="platform_selector_for_pop">
                    <ul>
                        <?php
                        $cats = get_categories(array('hide_empty'=>0));
                        $i = 1;
                        foreach ($cats as $cat){ 
                        ?>
                        <li data="<?php echo $cat->term_id;?>" <?php if ($i == 1){echo "class=\"selected\"";$i = 2;}?>><?php echo $cat->name;?></li>
                        <?php }?>
                    </ul>
                </div>
                <div id="time_selector_for_pop">
                    <ul>
                        <li data="week" class="selected">最近一周</li>
                        <li data="months">最近一个月</li>
                        <li data="3months">最近三个月</li>
                        <li data="all">全部</li>
                    </ul>
                </div>
            </div>
            <div class="works_panel_wrapper" id="user_works">
            <?php
            $i=0;
            foreach ($pop as $po){
            	work_block(get_post($po[0]));
            	$i++;
            	if($i==4)break;
            }
            ?>
            <div style="clear:both;display:block;"></div>
            <div class="category_paginater">
                </div>
                
            </div>
            </div>
            <?php get_footer();?>
</body>
</html>