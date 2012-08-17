<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf("第%s页", max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php $dir = get_stylesheet_directory_uri()."/";?>
<link rel="stylesheet" type="text/css" href="<?php echo $dir;?>css/index.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $dir;?>css/jquery.ultrawidget-1.0.css">
<link rel="stylesheet" type="text/css" href="<?php echo $dir;?>fancybox/jquery.fancybox-1.3.4.css">
<script type="text/javascript" src="<?php echo $dir;?>js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/jquery.lavalamp-1.3.5.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/jquery.ultrawidget-1.0.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/core.js"></script>
</head>
<body>
<!-- 头部 -->
	<div id="header_bar">
		<div id="header_wrapper">
			<div id="logo"></div>
			<div id="user_container_wrapper"></div>
		</div>
	</div>
<!-- 导航菜单 -->
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