<?php $dir = get_stylesheet_directory_uri()."/";get_header();?>
<link rel="stylesheet" type="text/css" href="<?php echo $dir;?>css/index.css" />
</head>
<body>
        <div id="header_bar">
            <div id="header_wrapper">
                <div id="logo">
                </div>
                <div id="user_container_wrapper"></div>
            </div>
        </div>
        <div id="nav_menu_wrapper">
            <ul id="nav_menu">
                <li><a href="/">首页</a></li>
                <li><a href="/themes">系统主题</a></li>
                <li><a href="/skins">软件皮肤</a></li>
                <li><a href="/icons-and-cursors">图标&amp;光标</a></li>
                <li><a href="/paintings">绘画作品</a></li>
            </ul>
            <div style="clear:both;display:block"></div>
        </div>
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
                        <li data="102">直角</li>
                        <li data="212">新番</li>
                        <li data="123">Galgame</li>
                        <li data="672">东方</li>
                        <li data="492">os</li>
                        <li data="312">effect</li>
                        <li data="333">concept</li>
                        <li data="977">mac</li>
                        <li data="214">ios</li>
                        <div style="clear:both;display:block;"></div>
                    </ul>
                </div>
                <div id="platform_selector_for_pop">
                    <ul>
                        <li data="Windows 7" class="selected">Windows 7</li>
                        <li data="Windows XP">Windows XP</li>
                        <li data="Android">Android</li>
                        <li data="Other">Other</li>
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
                <!-- work_id_001. this is a  work show area for work_id_001, should be generated with server side template or ajax-->
                <div id="work_id_001" class="works_panel">
                    <div class="work_content_wrapper">
                        <div class="preview_img_wrapper">
                            <a href="api/work_id_001">
                                <img src="img/prev1.jpg" />
                            </a>
                            <div class="img_lightbox_controls">
                                <a href="img/prev2_big.jpg" class="zoom_in_tool"></a>
                            </div>
                        </div>
                        <div class="work_title">
                            <a href="api/work_id_001" title="少女病Grow 愿希望的光芒">
                                少女病Grow 愿希望的光芒...
                            </a>
                        </div>
                        <div class="work_author">
                            <span>by</span>
                            <a href="api/author_id_001">
                                Seiren
                            </a>
                        </div>
                        <div class="work_tags">
                            <!-- data attribute in li element is tagID, the text is tagName -->
                            <ul>
                                <li data="0000">Windows 7</li>
                                <li data="0002">Grow</li>
                                <li data="0210">少女病</li>
                                <div style="clear:both;display:block;"></div>
                            </ul>
                        </div>
                        <div class="work_panel_divider"></div>
                        <div class="statistics_show_wrapper">
                            <div class="statistics_downloads_wrapper" title="11020次下载">
                                <div class="downloads_icon"></div>
                                <span>11020</span>
                            </div>
                            <div class="statistics_comments_wrapper" title="3501条评论">
                                <div class="comments_icon"></div>
                                <span>3501</span>
                            </div>
                            <div class="statistics_favorites_wrapper" title="200次收藏">
                                <div class="favorites_icon"></div>
                                <span>200</span>
                            </div>
                        </div>
                    </div>
                    <div class="work_special_indicator"></div>
                </div>

                <!-- work_id_002 demo only. you should generate this part by server-side code-->
                <div id="work_id_002" class="works_panel">
                    <div class="work_content_wrapper">
                        <div class="preview_img_wrapper">
                            <a href="api/work_id_002">
                                <img src="img/prev2.jpg" />
                            </a>
                            <div class="img_lightbox_controls">
                                <a href="img/prev2_big.jpg"  class="zoom_in_tool"></a>
                            </div>
                        </div>
                        <div class="work_title">
                            <a href="api/work_id_002" title="缘之空穹妹主题">
                                缘之空穹妹主题
                            </a>
                        </div>
                        <div class="work_author">
                            <span>by</span>
                            <a href="api/author_id_002">
                                lordfriend
                            </a>
                        </div>
                        <div class="work_tags">
                            <!-- data attribute in li element is tagID, the text is tagName -->
                            <ul>
                                <li data="0000">Windows 7</li>
                                <li data="0012">缘之空</li>
                                <li data="0212">穹妹</li>
                                <li data="0207">直角主题</li>
                                <div style="clear:both;display:block;"></div>
                            </ul>
                        </div>
                        <div class="work_panel_divider"></div>
                        <div class="statistics_show_wrapper">
                            <div class="statistics_downloads_wrapper" title="10201次下载">
                                <div class="downloads_icon"></div>
                                <span>10201</span>
                            </div>
                            <div class="statistics_comments_wrapper" title="3022条评论">
                                <div class="comments_icon"></div>
                                <span>3022</span>
                            </div>
                            <div class="statistics_favorites_wrapper" title="189次收藏">
                                <div class="favorites_icon"></div>
                                <span>189</span>
                            </div>
                        </div>
                    </div>
                    <div class="work_special_indicator"></div>
                </div>
                <!-- work_id_003 demo only. you should generate this part by server-side code-->
                <div id="work_id_003" class="works_panel">
                    <div class="work_content_wrapper">
                        <div class="preview_img_wrapper">
                            <a href="api/work_id_003">
                                <img src="img/prev3.jpg" />
                            </a>
                            <div class="img_lightbox_controls">
                                <a href="img/prev2_big.jpg"  class="zoom_in_tool"></a>
                            </div>
                        </div>
                        <div class="work_title">
                            <a href="api/work_id_003" title="Mac OS X Lion for Win7">
                                Mac OS X Lion for Win7
                            </a>
                        </div>
                        <div class="work_author">
                            <span>by</span>
                            <a href="api/author_id_003">
                                bodik87
                            </a>
                        </div>
                        <div class="work_tags">
                            <!-- data attribute in li element is tagID, the text is tagName -->
                            <ul>
                                <li data="0000">Windows 7</li>
                                <li data="0012">美化</li>
                                <li data="0212">Lion</li>
                                <li data="0207">Mac OS X</li>
                                <div style="clear:both;display:block;"></div>
                            </ul>
                        </div>
                        <div class="work_panel_divider"></div>
                        <div class="statistics_show_wrapper">
                            <div class="statistics_downloads_wrapper" title="10201次下载">
                                <div class="downloads_icon"></div>
                                <span>10201</span>
                            </div>
                            <div class="statistics_comments_wrapper" title="3022条评论">
                                <div class="comments_icon"></div>
                                <span>3022</span>
                            </div>
                            <div class="statistics_favorites_wrapper" title="189次收藏">
                                <div class="favorites_icon"></div>
                                <span>189</span>
                            </div>
                        </div>
                    </div>
                    <div class="work_special_indicator"></div>
                </div>
                <!-- work_id_004 demo only. you should generate this part by server-side code-->
                <div id="work_id_003" class="works_panel">
                    <div class="work_content_wrapper">
                        <div class="preview_img_wrapper">
                            <a href="api/work_id_004">
                                <img src="img/prev4.jpg" />
                            </a>
                            <div class="img_lightbox_controls">
                                <a href="img/prev2_big.jpg"  class="zoom_in_tool"></a>
                            </div>
                        </div>
                        <div class="work_title">
                            <a href="api/work_id_004" title="華桜の巫女—博麗靈夢Win7">
                                華桜の巫女—博麗靈夢Win7...
                            </a>
                        </div>
                        <div class="work_author">
                            <span>by</span>
                            <a href="api/author_id_004">
                                天翔の红牛
                            </a>
                        </div>
                        <div class="work_tags">
                            <!-- data attribute in li element is tagID, the text is tagName -->
                            <ul>
                                <li data="0000">Windows 7</li>
                                <li data="0012">美化</li>
                                <li data="0212">Lion</li>
                                <li data="0207">Mac OS X</li>
                                <div style="clear:both;display:block;"></div>
                            </ul>
                        </div>
                        <div class="work_panel_divider"></div>
                        <div class="statistics_show_wrapper">
                            <div class="statistics_downloads_wrapper" title="10201次下载">
                                <div class="downloads_icon"></div>
                                <span>10201</span>
                            </div>
                            <div class="statistics_comments_wrapper" title="3022条评论">
                                <div class="comments_icon"></div>
                                <span>3022</span>
                            </div>
                            <div class="statistics_favorites_wrapper" title="189次收藏">
                                <div class="favorites_icon"></div>
                                <span>189</span>
                            </div>
                        </div>
                    </div>
                    <div class="work_special_indicator"></div>
                </div>
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
                        <li data="102">直角</li>
                        <li data="212">新番</li>
                        <li data="123">Galgame</li>
                        <li data="672">东方</li>
                        <li data="492">os</li>
                        <li data="312">effect</li>
                        <li data="333">concept</li>
                        <li data="977">mac</li>
                        <li data="214">ios</li>
                        <div style="clear:both;display:block;"></div>
                    </ul>
                </div>
                <div id="platform_selector_for_new">
                    <ul>
                        <li data="Windows 7" class="selected">Windows 7</li>
                        <li data="Windows XP">Windows XP</li>
                        <li data="Android">Android</li>
                        <li data="Other">Other</li>
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
                <!-- work_id_001. this is a  work show area for work_id_001, should be generated with server side template or ajax-->
                <div id="work_id_001" class="works_panel">
                    <div class="work_content_wrapper">
                        <div class="preview_img_wrapper">
                            <a href="api/work_id_001">
                                <img src="img/prev1.jpg" />
                            </a>
                            <div class="img_lightbox_controls">
                                <a href="img/prev2_big.jpg" class="zoom_in_tool"></a>
                            </div>
                        </div>
                        <div class="work_title">
                            <a href="api/work_id_001" title="少女病Grow 愿希望的光芒">
                                少女病Grow 愿希望的光芒...
                            </a>
                        </div>
                        <div class="work_author">
                            <span>by</span>
                            <a href="api/author_id_001">
                                Seiren
                            </a>
                        </div>
                        <div class="work_tags">
                            <!-- data attribute in li element is tagID, the text is tagName -->
                            <ul>
                                <li data="0000">Windows 7</li>
                                <li data="0002">Grow</li>
                                <li data="0210">少女病</li>
                                <div style="clear:both;display:block;"></div>
                            </ul>
                        </div>
                        <div class="work_panel_divider"></div>
                        <div class="statistics_show_wrapper">
                            <div class="statistics_downloads_wrapper" title="11020次下载">
                                <div class="downloads_icon"></div>
                                <span>11020</span>
                            </div>
                            <div class="statistics_comments_wrapper" title="3501条评论">
                                <div class="comments_icon"></div>
                                <span>3501</span>
                            </div>
                            <div class="statistics_favorites_wrapper" title="200次收藏">
                                <div class="favorites_icon"></div>
                                <span>200</span>
                            </div>
                        </div>
                    </div>
                    <div class="work_special_indicator"></div>
                </div>

                <!-- work_id_002 demo only. you should generate this part by server-side code-->
                <div id="work_id_002" class="works_panel">
                    <div class="work_content_wrapper">
                        <div class="preview_img_wrapper">
                            <a href="api/work_id_002">
                                <img src="img/prev2.jpg" />
                            </a>
                            <div class="img_lightbox_controls">
                                <a href="img/prev2_big.jpg"  class="zoom_in_tool"></a>
                            </div>
                        </div>
                        <div class="work_title">
                            <a href="api/work_id_002" title="缘之空穹妹主题">
                                缘之空穹妹主题
                            </a>
                        </div>
                        <div class="work_author">
                            <span>by</span>
                            <a href="api/author_id_002">
                                lordfriend
                            </a>
                        </div>
                        <div class="work_tags">
                            <!-- data attribute in li element is tagID, the text is tagName -->
                            <ul>
                                <li data="0000">Windows 7</li>
                                <li data="0012">缘之空</li>
                                <li data="0212">穹妹</li>
                                <li data="0207">直角主题</li>
                                <div style="clear:both;display:block;"></div>
                            </ul>
                        </div>
                        <div class="work_panel_divider"></div>
                        <div class="statistics_show_wrapper">
                            <div class="statistics_downloads_wrapper" title="10201次下载">
                                <div class="downloads_icon"></div>
                                <span>10201</span>
                            </div>
                            <div class="statistics_comments_wrapper" title="3022条评论">
                                <div class="comments_icon"></div>
                                <span>3022</span>
                            </div>
                            <div class="statistics_favorites_wrapper" title="189次收藏">
                                <div class="favorites_icon"></div>
                                <span>189</span>
                            </div>
                        </div>
                    </div>
                    <div class="work_special_indicator"></div>
                </div>
                <!-- work_id_003 demo only. you should generate this part by server-side code-->
                <div id="work_id_003" class="works_panel">
                    <div class="work_content_wrapper">
                        <div class="preview_img_wrapper">
                            <a href="api/work_id_003">
                                <img src="img/prev3.jpg" />
                            </a>
                            <div class="img_lightbox_controls">
                                <a href="img/prev2_big.jpg"  class="zoom_in_tool"></a>
                            </div>
                        </div>
                        <div class="work_title">
                            <a href="api/work_id_003" title="Mac OS X Lion for Win7">
                                Mac OS X Lion for Win7
                            </a>
                        </div>
                        <div class="work_author">
                            <span>by</span>
                            <a href="api/author_id_003">
                                bodik87
                            </a>
                        </div>
                        <div class="work_tags">
                            <!-- data attribute in li element is tagID, the text is tagName -->
                            <ul>
                                <li data="0000">Windows 7</li>
                                <li data="0012">美化</li>
                                <li data="0212">Lion</li>
                                <li data="0207">Mac OS X</li>
                                <div style="clear:both;display:block;"></div>
                            </ul>
                        </div>
                        <div class="work_panel_divider"></div>
                        <div class="statistics_show_wrapper">
                            <div class="statistics_downloads_wrapper" title="10201次下载">
                                <div class="downloads_icon"></div>
                                <span>10201</span>
                            </div>
                            <div class="statistics_comments_wrapper" title="3022条评论">
                                <div class="comments_icon"></div>
                                <span>3022</span>
                            </div>
                            <div class="statistics_favorites_wrapper" title="189次收藏">
                                <div class="favorites_icon"></div>
                                <span>189</span>
                            </div>
                        </div>
                    </div>
                    <div class="work_special_indicator"></div>
                </div>
                <!-- work_id_004 demo only. you should generate this part by server-side code-->
                <div id="work_id_003" class="works_panel">
                    <div class="work_content_wrapper">
                        <div class="preview_img_wrapper">
                            <a href="api/work_id_004">
                                <img src="img/prev4.jpg" />
                            </a>
                            <div class="img_lightbox_controls">
                                <a href="img/prev2_big.jpg"  class="zoom_in_tool"></a>
                            </div>
                        </div>
                        <div class="work_title">
                            <a href="api/work_id_004" title="華桜の巫女—博麗靈夢Win7">
                                華桜の巫女—博麗靈夢Win7...
                            </a>
                        </div>
                        <div class="work_author">
                            <span>by</span>
                            <a href="api/author_id_004">
                                天翔の红牛
                            </a>
                        </div>
                        <div class="work_tags">
                            <!-- data attribute in li element is tagID, the text is tagName -->
                            <ul>
                                <li data="0000">Windows 7</li>
                                <li data="0012">美化</li>
                                <li data="0212">Lion</li>
                                <li data="0207">Mac OS X</li>
                                <div style="clear:both;display:block;"></div>
                            </ul>
                        </div>
                        <div class="work_panel_divider"></div>
                        <div class="statistics_show_wrapper">
                            <div class="statistics_downloads_wrapper" title="10201次下载">
                                <div class="downloads_icon"></div>
                                <span>10201</span>
                            </div>
                            <div class="statistics_comments_wrapper" title="3022条评论">
                                <div class="comments_icon"></div>
                                <span>3022</span>
                            </div>
                            <div class="statistics_favorites_wrapper" title="189次收藏">
                                <div class="favorites_icon"></div>
                                <span>189</span>
                            </div>
                        </div>
                    </div>
                    <div class="work_special_indicator"></div>
                </div>
                <div style="clear:both;display:block;"></div>
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
