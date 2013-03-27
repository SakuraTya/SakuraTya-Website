<?php
require('../smarty/SmartyBC.class.php');
require('../wp-config.php');
if(!current_user_can('read')){
	header('HTTP/1.1 403');
	die('您尚未登录或已被加入黑名单，请点击<a href="/wp-login.php?redirect_to=http%3A%2F%2F'.$_SERVER['HTTP_HOST'].'%2Fdashboard%2F&reauth=1">此处</a>登录。');
}
$smarty = new Smarty();
$smarty->assign('debug',true);
$smarty->assign('mod',$_GET['mod']);
$smarty->assign('user',wp_get_current_user());
if(current_user_can('publish_posts')){
	$smarty->assign('env','internal_staff');
}else{
	$smarty->assign('env','users');
}
$smarty->display('./template/frame.tpl');