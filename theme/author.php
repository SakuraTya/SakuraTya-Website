<?php get_header();$dir = get_stylesheet_directory_uri()."/";
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$page=isset($_GET['page'])?$_GET['page']:0;
$page=is_int($page)?$page:0;
$page=$_GET['page'];
$query = new WP_Query(array('author'=>$curauth->ID,'posts_per_page'=>4,'paged'=>$page));
echo '<!--';print_r($curauth);echo '-->';
?>
<link rel="stylesheet" type="text/css" href="<?php echo $dir;?>css/detail.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $dir;?>css/index.css" />
<script type="text/javascript" src="<?php echo $dir;?>js/detail.js"></script>
<script type="text/javascript">
            $(document).ready(function() {
                var global_StartItem = 0; //this javascript variable need to convert to php variable.
                navMenuBuilding(global_StartItem);
                layoutWorkPanel(<?php echo count_user_posts($curauth->ID)?>,4);
            });
</script>
<body><?php nav_menu(); ?>
        <div class="main_content_wrapper">
            <div id="cpl_header" class="group_header_bg">
                <div id="cpl_user_name" class="title_wrapper">
                    <div class="title_wrapper_left"></div>
                    <div class="title_content"><span><?php echo $curauth->display_name;?></span></div>
                    <div class="title_wrapper_right"></div>
                </div>
            </div>
            <div id="user_avatar">
                <img src="<?php echo get_custom_avatar($curauth->ID);?>" />
            </div>
            <div id="user_info">
                <div id="simple_user_info">
                    <div class="tiny_bubble_title">
                        <span>加入时间</span>
                    </div>
                    <span class="user_info_content">2012年7月11日</span>
                    <div class="tiny_bubble_title">
                        <span>作品数</span>
                    </div>
                    <span class="user_info_content">100</span>
                </div>
                <div id="extend_user_info">
                    <div class="tiny_bubble_title"><span>社交应用</span></div>
                    <ul id="user_sns_link">
                        <li><a href="http://twitter.com" title="twitter" class="sns_icon twitter"></a></li>
                        <li><a href="http://www.facebook.com" title="facebook" class="sns_icon facebook"></a></li>
                        <li><a href="http://www.foursquare.com" title="foursquare" class="sns_icon foursquare"></a></li>
                    </ul>
                </div>
            </div>
            
            <div id="user_signature_wrapper">
                <div id="signature"><span><?php echo get_sign($curauth->ID);?></span></div>
                <div id="signature_label"></div>
            </div>

            <div id="user_works">
                <?php foreach ($query->posts as $post){
				work_block($post);
			} ?>
                <div style="clear:both;display:block;"></div>
                <!-- this is the paginator container do not remove -->
                <div class="category_paginater">
                </div>
            </div>
            
        </div>


        <div id="footer_bar">
            <div id="nav_links_area">
                <ul id="about_us_list">
                    <li class="list_title">关于我们</li>
                    <li><a href="">关于樱茶</a></li>
                    <li><a href="">关于樱茶幻萌组</a></li>
                    <li><a href="">加入樱茶</a></li>
                    <li><a href="">版权投诉</a></li>
                </ul>
                <ul id="user_help_list">
                    <li class="list_title">使用帮助</li>
                    <li><a href="">隐私政策</a></li>
                    <li><a href="">发布作品指南</a></li>
                    <li><a href="">站点地图</a></li>
                    <li><a href="">社区守则</a></li>
                </ul>
                <ul id="blog_update">
                    <li class="list_title">樱茶blog</li>
                </ul>
                <ul id="sns_link">
                    <li class="list_title">关注樱茶</li>
                    <li style="background:url('img/icon_twitter.png') no-repeat;line-height:18px;"><a href="">Twitter</a></li>
                    <li style="background:url('img/icon_gplus.png') no-repeat;line-height:18px;"><a href="">Google+</a></li>
                    <li style="background:url('img/icon_weibo.png') no-repeat;line-height:18px;"><a href="">新浪微博</a></li>
                    <li style="background:url('img/icon_qweibo.png') no-repeat;line-height:18px;"><a href="">腾讯微博</a></li>
                </ul>
                <div style="clear:both;display:block;"></div>
            </div>
            <div id="copyright_info">© SakuraTya 2012 All Rights Received.</div>
        </div>
    </body>
</html>