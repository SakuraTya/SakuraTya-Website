<?php get_header();
$dir = get_stylesheet_directory_uri()."/";
$cat=get_category($_GET['cat'],ARRAY_A);
$wpq=new WP_Query('cat='.$_GET['cat']."&order=ASC");
$posts=$wpq->posts;
?>
<link rel="stylesheet" type="text/css" href="<?php echo $dir;?>css/detail.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $dir;?>css/index.css" />
<script type="text/javascript" src="<?php echo $dir;?>js/detail.js"></script>
<script type="text/javascript">
            $(document).ready(function() {
                var global_StartItem = 0; //this javascript variable need to convert to php variable.
                navMenuBuilding(global_StartItem);
            });
</script>
<body>
<?php nav_menu();
echo nl2br(print_r($posts,true));?>
</body>
