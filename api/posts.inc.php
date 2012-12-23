<?php
class PostsApi extends Api{
	function post_order($data){
		switch($_GET['order']){
			case 'pop':{
				foreach($data as $post){
					unset($post->post_content,$post->menu_order,$post->to_ping,$post->pinged,$post->ping_status,$post->post_password,$post->post_status,$post->comment_status,$post->post_excerpt,$post->post_type,$post->post_name,$post->post_date,$post->post_date_gmt,$post->post_parent,$post->post_content_filtered,$post->filter,$post->post_mime_type,$post->post_modified_gmt,$post->post_modified);
					$result[serialize($post)]=rank_score_calc($post, get_downloads($post->ID),get_post_views($post->ID), 1);
				}
				print_r($result);
				asort($result,SORT_NUMERIC);
				foreach(array_keys($result)as $post){
					$return[]=post_json(unserialize($post));
				}
				return $return;
			}
			default:{
				return $data;
			}
		}
	}
	function filter_where_week( $where = '' ) {
		$where .= " AND post_date > '" . date('Y-m-d', strtotime('-7 days')) . "'";
		return $where;
	}
	function filter_where_month( $where = '' ) {
		$where .= " AND post_date > '" . date('Y-m-d', strtotime('-31 days')) . "'";
		return $where;
	}
	function filter_where_3months( $where = '' ) {
		$where .= " AND post_date > '" . date('Y-m-d', strtotime('-93 days')) . "'";
		return $where;
	}
	function post_json($post){
		$post_id = $post->ID;
		$return = array();
		$return['id'] = $post_id;
		$cats = get_the_category($post_id);
		if ($cats){
			foreach ($cats as $cat){
				$return['category'][] = array(
						'name'=>$cat->name,
						'url'=>get_category_link($cat->term_id)
				);
			}
		}
		$return['url'] = $post->guid;
		$return['title'] = $post->post_title;
		$return['author'] = array('name'=>get_author_name($post->post_author), 'id'=>$post->post_author, 'url'=>get_author_posts_url($post->post_author));
		$tags = get_the_tags($post_id);
		if ($tags){
			foreach ($tags as $tag){
				$return['tags'][]=array(
						'name'=>$tag->name,
						'id'=>$tag->term_id
				);
			}
		}
		if (function_exists('get_field')){
			$aid = get_field('preview',$post_id);
			if (!$aid == ""){
				$a = wp_get_attachment_image_src($aid, array(240,180));
				$b = wp_get_attachment_image_src($aid,'full');
				$return['preview'] = $a[0];
				$return['preview_big']= $b[0];
			}
		}
		$return['downloads'] = get_downloads($post_id);
		$return['favorites'] = get_favorites($post_id);
		$return['comments'] = $post->comment_count;
		return $return;
	
	}
	public $name='posts';
	public function get($data){
		switch ($_GET['mode']){
			case 'category':
				if(!isset($_GET['id'])){
					error('You should give this page the category\'s ID(integer) by GET method.');
				}
				$id=$_GET['id'];
				$page=isset($_GET['page'])?$_GET['page']:1;
				$time=isset($_GET['time'])?$_GET['time']:'all';
				switch($time){
					case 'all':
						$query=new WP_Query('cat='.$id.'&posts_per_page=8&paged='.$page);
						if($query){
							foreach ($query->posts as $post){
								$return[]=$post;
							}
						}
						echo json_encode(post_order($return));
						break;
					case 'week':
						add_filter('posts_where', 'filter_where_week');
						$query=new WP_Query('cat='.$id.'&posts_per_page=8&paged='.$page);
						remove_filter('posts_where', 'filter_where_week');
						if($query){
							foreach ($query->posts as $post){
								$return[]=$post;
							}
						}
						echo json_encode(post_order($return));
						break;
					case 'month':
						add_filter('posts_where', 'filter_where_month');
						$query=new WP_Query('cat='.$id.'&posts_per_page=8&paged='.$page);
						remove_filter('posts_where', 'filter_where_month');
						if($query){
							foreach ($query->posts as $post){
								$return[]=$post;
							}
						}
						echo json_encode(post_order($return));
						break;
					case '3months':
						add_filter('posts_where', 'filter_where_3months');
						$query=new WP_Query('cat='.$id.'&posts_per_page=8&paged='.$page);
						remove_filter('posts_where', 'filter_where_3months');
						if($query){
							foreach ($query->posts as $post){
								$return[]=$post;
							}
						}
						echo json_encode(post_order($return));
						break;
					default:die(json_encode(array('msg'=>'Invalid time span.')));
				}
				break;
			case 'tag':
				if(!isset($_GET['id'])){
					die(json_encode(array('msg'=>'You should give this page the tag\'s ID(integer) by GET method.')));
				}
				$id=$_GET['id'];
				$page=isset($_GET['page'])?$_GET['page']:1;
				$time=isset($_GET['time'])?$_GET['time']:'all';
				switch($time){
					case 'all':
						$query=new WP_Query('tag_id='.$id.'&posts_per_page=8&paged='.$page);
						if($query){
							foreach ($query->posts as $post){
								$return[]=post_json($post);
							}
						}
						echo json_encode($return);
						break;
					case 'week':
						add_filter('posts_where', 'filter_where_week');
						$query=new WP_Query('tag_id='.$id.'&posts_per_page=8&paged='.$page);
						remove_filter('posts_where', 'filter_where_week');
						if($query){
							foreach ($query->posts as $post){
								$return[]=post_json($post);
							}
						}
						echo json_encode($return);
						break;
					case 'month':
						add_filter('posts_where', 'filter_where_month');
						$query=new WP_Query('tag_id='.$id.'&posts_per_page=8&paged='.$page);
						remove_filter('posts_where', 'filter_where_month');
						if($query){
							foreach ($query->posts as $post){
								$return[]=post_json($post);
							}
						}
						echo json_encode($return);
						break;
					case '3months':
						add_filter('posts_where', 'filter_where_3months');
						$query=new WP_Query('tag_id='.$id.'&posts_per_page=8&paged='.$page);
						remove_filter('posts_where', 'filter_where_3months');
						if($query){
							foreach ($query->posts as $post){
								$return[]=post_json($post);
							}
						}
						echo json_encode($return);
						break;
					default:error('Invalid time span.');
				}
				break;
			case 'user':
				if(!isset($_GET['id'])||is_int($_GET['id'])){
					error('You should give this page the user\'s ID(integer) by GET method.');
				}
				$id=$_GET['id'];
				$page=isset($_GET['page'])?$_GET['page']:1;
				$query = new WP_Query(array('author'=>$curauth->ID,'posts_per_page'=>4,'paged'=>$page));
				if($query){
					foreach ($query->posts as $post){
						$return[]=post_json($post);
					}
				}else{
					error('Query failed.');
				}
				echo json_encode($return);
				break;
			default:error('Invalid argument.');
		}
	}
}