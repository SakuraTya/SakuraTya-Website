<?php
require('../smarty/SmartyBC.class.php');
require('../wp-config.php');
$smarty = new Smarty();
$smarty->allow_php_tag = true;
$smarty->assign('debug',true);
$smarty->assign('static','/theme/static');
$smarty->assign('mod',$_GET['mod']);
if(file_exists('./template/ext_header/'.$_GET['mod'].'.tpl')){
	$smarty->assign('ext_header','./ext_header/'.$_GET['mod'].'.tpl');
}
$smarty->registerPlugin('function','lang_attr','language_attributes');
$smarty->registerPlugin('function','exec_main','exec_main');
function exec_main($par,&$smarty){
	require('./mods/'.$par['mod'].'.php');
}
$smarty->display('./template/layout.tpl');