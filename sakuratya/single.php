<?php get_header();$dir = get_stylesheet_directory_uri()."/";?>
<link rel="stylesheet" type="text/css" href="<?php echo $dir;?>css/detail.css">
<script type="text/javascript" src="<?php echo $dir;?>js/detail.js"></script>
<script type="text/javascript">
            $(document).ready(function() {
                var global_StartItem = 2; //this javascript variable need to convert to php variable.
                navMenuBuilding(global_StartItem);
            });
</script>
<body>
<?php nav_menu();
global $post;?>
<div class="main_content_wrapper">
<div id="detail_header" class="group_header_bg">
<div id="detail_title" class="title_wrapper">
<div class="title_wrapper_left"></div>
<div class="title_content"><span><?php echo $post->post_title;?></span></div>
<div class="title_wrapper_right"></div>
</div>
<!-- this link should be modifed according to the article's category and sub category -->
                <div id="detail_category" class="detail_properties_link"><a href="">系统主题</a></div>
                <div id="detail_subcategory" class="detail_properties_link"><a href="">Windows 7</a></div>
            </div>
            <div id="work_content_wrapper">
            <?php echo $post->post_content;?>
            </div>
            <div id="work_info_wrapper">
                <?php author_info(the_post()->post_author);?>
                    <div id="project_info">
                    <div id="project_brief">
                    <span>发表于：2011年9月28日</span>
                    <span>查看：4480</span>
                    <span>评论：160</span>
                    </div>
                    <!-- This button need ajax load the real download link -->
                    <div id="project_download_button">
                    <div id="download_icon"></div>
                    <span class="button_title">查看下载地址</span>
                    <span class="button_desc">已下载3801次</span>
                    </div>
                    <div id="project_favorite_button">
                    <div id="favorite_icon"></div>
                    <span class="button_title">收藏这个作品</span>
                    <span class="button_desc">收藏次数1080次</span>
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
                    <?php get_footer();?>
    </body>
    </html>