<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php global $title; echo $title;?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php $dir = get_stylesheet_directory_uri()."/";?>
<link rel="stylesheet" type="text/css" href="<?php echo $dir;?>css/jquery.ultrawidget-1.0.css">
<link rel="stylesheet" type="text/css" href="<?php echo $dir;?>fancybox/jquery.fancybox.css">
<script type="text/javascript" src="<?php echo $dir;?>js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/jquery.lavalamp-1.4.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/jquery.ultrawidget-1.0.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/core.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $dir;?>css/index.css" />
<script type="text/javascript" src="<?php echo $dir;?>js/index.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/detail.js"></script>