<?php 
$cuser=get_current_user_id();
if(!$cuser==0){
	$cuser=get_user_by('id', $cuser);
}
?>
<!-- <?php var_dump($cuser)?> -->
<div id="comments">
                    <div id="comments_title"><span><?php echo $post->comment_count;?>条评论</span></div>
                    <ol class="commentlist">
                    <?php wp_list_comments(array('callback'=>'sakuratya_list_comments','max_depth'=>3));?>
                    </ol>
                    <?php if (is_user_logged_in()){?>
                    <div id="respond">
                        <div class="respond_account">
                            <a class="respond_avatar" href="<?php echo get_author_posts_url(get_user_by('id',$cuser->data->ID));?>"><img src=<?php echo get_custom_avatar($cuser->data->ID);?> /></a>
                            <a class="respond_name" href="<?php echo get_author_posts_url(get_user_by('id',$cuser->data->ID));?>"><?php echo $cuser->data->display_name;?></a>
                        </div>
                        <span class="respond_tips">来说点什么吧</span>
                        <div id="compose_comment"><textarea id="comment" name="comment" cols="45" rows="8"></textarea></div>
                        <a href="" id="comment_submit"><span>发表评论</span></a>
                        <div style="display:block;clear:both;"></div>
                    </div>
                    <?php }?>
                    <!-- #respond -->
                </div>