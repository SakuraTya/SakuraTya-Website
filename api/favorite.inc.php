<?php
class FavoriteApi extends Api{
	public $name='favorite';
	public function post($data){
		return array(
				'body'=>'test',
				'status'=>200,
				'type'=>'text/plain'
				);
	}
	private function remove_favorite($post_id, $user_id){
		global $wpdb;
		$wpdb->query("DELETE FROM ".FAV_NAME." WHERE `post_id` = ".$post_id." AND `user_id` = ".$user_id);
	}
	private function add_favorite($post_id, $user_id){
		global $wpdb;
		if ($wpdb->insert(FAV_NAME, array('post_id'=>$post_id, 'user_id'=>$user_id)) == false){
			return false;
		}
		return true;
	}
}