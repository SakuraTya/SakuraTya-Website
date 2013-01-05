<?php get_header();$dir = get_stylesheet_directory_uri()."/";global $post;?>
<link rel="stylesheet" type="text/css" href="<?php echo $dir;?>css/detail.css">
<link rel="stylesheet" type="text/css" href="<?php echo $dir;?>css/editable.css">
<link rel="stylesheet" type="text/css" href="<?php echo $dir;?>css/buttons.css">
<script type="text/javascript" src="<?php echo $dir;?>js/detail.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/noty/jquery.noty.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/noty/layouts/top.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/noty/themes/default.js"></script>
<script type="text/javascript">
            $(document).ready(function() {
                var global_StartItem = 1; //this javascript variable need to convert to php variable.
                navMenuBuilding(global_StartItem);
            });
            ajaxurl="<?php echo admin_url('admin-ajax.php'); ?>";
            post_id=<?php echo $post->ID;?>;
</script>
<body>
<?php nav_menu();
$cats=get_the_category();?>
<div class="main_content_wrapper">
<div id="detail_header" class="group_header_bg">
<div id="detail_title" class="title_wrapper">
<div class="title_wrapper_left"></div>
<div class="title_content"><span><?php echo $post->post_title;?></span></div>
<div class="title_wrapper_right"></div>
</div>
<!-- this link should be modifed according to the article's category and sub category -->
                <div id="detail_category" class="detail_properties_link">
                <?php foreach ($cats as $cat){
                	if ($cat->category_parent!=0)continue;
                ?>
                <a href="<?php echo get_category_link($cat);?>"><?php echo $cat->name;?></a>
                <?php }?>
                </div>
                <div id="detail_subcategory" class="detail_properties_link">
                <?php foreach ($cats as $cat){
                	if ($cat->category_parent==0)continue;
                ?>
                <a href="<?php echo get_category_link($cat);?>"><?php echo $cat->name;?></a>
                <?php }?>
                </div>
            </div>
            <div id="work_content_wrapper">
            	<div id="article">
            		<?php echo $post->post_content;?>
            	</div>
            	<?php comments_template();?>
            	<script type="text/javascript" src="<?php echo $dir;?>js/ajax_comment.js"></script>
            </div>
            <div id="work_info_wrapper">
                <?php author_info($post->post_author);?>
                    <div id="project_info">
                    <div id="project_brief">
                    <span>发表于：<?php echo strftime('%Y年%m月%d日',strtotime($post->post_modified));?></span>
                    <span>查看：<?php echo get_post_views($post->ID);?></span>
                    <span>评论：<?php echo $post->comment_count;?></span>
                    </div>
                    <!-- This button need ajax load the real download link -->
                    <div id="project_download_button">
                    <div id="download_icon"></div>
                    <span class="button_title">查看下载地址</span>
                    <span class="button_desc">已下载<?php echo get_downloads($post->ID);?>次</span>
                    </div>
                    <div id="project_favorite_button">
                    <div id="favorite_icon"></div>
                    <span class="button_title">收藏这个作品</span>
                    <span class="button_desc">收藏次数<?php echo get_favorites($post->ID);?>次</span>
                    </div>
                    <div class="info_section_label">
                    <div id="info_label_project"></div>
                    <div class="info_section_divider"></div>
                    </div>
                    </div>
                    <div id="work_tags">
                    <ul id="work_tags_list">
                    <!-- work_tags are dynamically generated -->
                    </ul>
                    <div class="info_section_label">
                    <div id="info_label_tags"></div>
                    <div class="info_section_divider"></div>
                    </div>
                    </div>
                    <div id="share_buttons">
                    <div id="share_buttons_wrapper">
                    <!-- Place share buttons here -->
                    </div>
                    <div class="info_section_label">
                    <div id="info_label_share"></div>
                    <div class="info_section_divider"></div>
                    </div>
                    </div>
                    </div>
                    <div style="display:block;clear:both;"></div>
                    </div>
                    <?php set_post_views($post->ID);get_footer();?>
    </body>
    </html>