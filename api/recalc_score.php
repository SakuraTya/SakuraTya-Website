<?php
require('./api-config.php');
$mysqli=new mysqli('localhost',DB_USER,DB_PASSWORD,DB_NAME);
echo get_field('preview',10);
$query="INSERT INTO wp_score SET post_id=?,score=?";
$mysqli->query('DELETE FROM wp_score');
$stmt=$mysqli->stmt_init();
$stmt->prepare($query);
$stmt->bind_param('id',$id,$sc);
$posts=new WP_Query('post_type=post');
$posts=$posts->posts;
$score=array();
foreach($posts as $post){
	$id = $post->ID;
	$dc=get_downloads($id);
	$fc=get_favorites($id);
	echo "ID:".$id." DC=".$dc." FC=".$fc." VC=".get_post_views($id)." SCORE=";
	$sc=rank_score_calc($post, $dc, get_post_views($id), 1);
	echo $sc.'<br />';
	$stmt->execute();
}
$stmt->close();
$mysqli->close();