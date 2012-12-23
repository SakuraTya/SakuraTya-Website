<?php
class DownloadApi extends Api{
	public $name='download';
	public function get($data,$id){
		$return['type']='text/plain';
		if (!is_user_logged_in()){
			$return['body']['status']=3;
			$return['status']=403;
			return $return;
		}
		if (!isset($_GET['id'])){
			$return['body']['status']=2;
			$return['status']=404;
			return $return;
		}
		$post_id = $_GET['id'];
		if(!add_post_meta($post_id, "downloads", 0, true)){
			update_post_meta($post_id, "downloads", get_post_meta($post_id, "downloads", true) + 1);
		}
		$return['body']['status']=0;
		$return['status']=200;
	}
}