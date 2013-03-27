<?php
$smarty->assign('tags',get_tags());
$smarty->assign('cats',get_categories(array('hide_empty'=>0)));