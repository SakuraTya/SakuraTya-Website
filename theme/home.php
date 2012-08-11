<?php get_header();?>
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
            <!--This is works panel area where all panels place here, a template should modify to a loop structure-->
            <div class="works_panel_wrapper">
            <?php
			$d=10;$p = get_post($d);work_block($p);work_block($p);work_block($p);work_block($p);work_block($p);work_block($p);work_block($p);work_block($p);
            ?>
            <div style="clear:both;display:block;"></div>
            </div>
                
            <div class="page_navigator_holder">
                <a id="pop_more_content_button" class="more_content_button_wrapper" href="/category">
                    <span>更多</span>
                    <div class="right_arrow_icon">
                    </div>
                </a>
                <div style="clear:both;display:block;"></div>
            </div>
        </div>
        <div id="new_works_show">
            <div id="newworks_group_header" class="group_header_bg">
                <div id="newworks_group_label"></div>
                <div id="search_box_for_new">
                    <div class="search_box_wrapper">
                        <span class="search_box_icon"></span>
                        <input class="search_box_input" name="search" id="search_new" placeholder="搜索..." type="text" />
                    </div>
                </div>
                <div id="tags_selector_for_new">
                    <ul>
                        <?php 
                        foreach ($tags as $tag){
                        ?>
                        <li data="<?php echo $tag->term_id;?>"><?php echo $tag->name;?></li>
                        <?php }?>
                        <div style="clear:both;display:block;"></div>
                    </ul>
                </div>
                <div id="platform_selector_for_new">
                    <ul>
                        <?php
                        $i = 1;
                        foreach ($cats as $cat){ 
                        ?>
                        <li data="<?php echo $cat->term_id;?>" <?php if ($i == 1){echo "class=\"selected\"";$i = 2;}?>><?php echo $cat->name;?></li>
                        <?php }?>
                    </ul>
                </div>
                <div id="time_selector_for_new">
                    <ul>
                        <li data="week" class="selected">最近一周</li>
                        <li data="months">最近一个月</li>
                        <li data="3months">最近三个月</li>
                        <li data="all">全部</li>
                    </ul>
                </div>
            </div>
            <!--This is works panel area where all panels place here, a template should modify to a loop structure-->
            <div class="works_panel_wrapper">
            <?php             
            $q = new WP_Query( array('post_type'=>'post', 'orderby'=>'date', 'order'=>'DESC', 'posts_per_page'=>8,'paged'=>1) );
            foreach ($q->posts as $post){
				work_block($post);
			} 
			?>
            </div>
            <div class="page_navigator_holder">
                <a id="new_more_content_button" class="more_content_button_wrapper" href="/category">
                    <span>更多</span>
                    <div class="right_arrow_icon">
                    </div>
                </a>
                <div style="clear:both;display:block;"></div>
            </div>
        </div>
        <div id="footer_bar">
            <div id="nav_links_area">

            </div>
        </div>
    </body>
