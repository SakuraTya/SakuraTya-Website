<?php
function avatar_create_user_page(){
	?>
	<div class="wrap">
		<h2>头像设置</h2>
	<?php 
	if(get_user_meta(get_current_user_id(),'hava_avatar')){
		$url=wp_get_attachment_image_src(get_user_meta(get_current_user_id(),'avatar_id'));
		if ($url){
		?>
		当前头像:<img src="<?php echo $url[0]?>" />
		<?php 
		}else{echo "<strong>头像文件不存在</strong>";}
	}
	?>
	<script type="text/javascript">
	<!--
	function ajaxFileUpload(){
		jQuery.ajaxFileUpload
		({
			url:'<?php bloginfo( 'wpurl' ); ?>/wp-admin/admin-ajax.php?action=avatar_upload',
			secureuri:false,
			fileElementId:'avatarFile',
			dataType: 'json',
			beforeSend:function(){
				jQuery("#alertText").html("正在上传，请稍候");
			},				
			success: function (data, status)
			{
				if (typeof data.error != "undefined"){
					jQuery("#alertText").html("上传出错:" + data.error);
					return;
				}
				aid=data.aid
				jQuery("#alertText").html("上传成功:"+ data.url);
				jQuery("<script type=\"text/javascript\" src=\"/wp-content/plugins/custom-avatar/js/jquery.Jcrop.min.js\"></script><link rel=\"stylesheet\" href=\"/wp-content/plugins/custom-avatar/js/jquery.Jcrop.min.css\" type=\"text/css\" media=\"all\" />").appendTo("head");
				jQuery("#uploader").html("");
				jQuery("<img id=\"cropbox\" src=\""+data.url+"\" /><button id=\"crop\">确认</button>").appendTo("#uploader");
				jQuery("#cropbox").Jcrop({
					aspectRatio:'1',
					minSize: [100,100],
					onSelect:function(c){
						crop=c;
					}
				},function(){jcapi=this;});
				jQuery("#crop").click(function(e){
					e.preventDefault();
					jQuery.ajax({
						type:"POST",
						url:"/wp-admin/admin-ajax.php?action=avatar_crop",
						data:{x:crop.x,y:crop.y,h:crop.h,w:crop.w,x2:crop.x2,y2:crop.y2,aid:aid},
						dataType:"json",
						success:function(data){
							if(data.status == 0){
								jcapi.setImage(jQuery('#cropbox').attr('src'));
								jcapi.release();
								jcapi.disable();
								jQuery('#uploader').remove('button');
							}
						}
					});
				});
			},
			error: function (data, status, e)
			{
				jQuery("#alertText").html("上传出错:" + e);
			}
		});
		return false;
	}
	//-->
	</script>
	<div id="uploader">
	<span id="alertText">请先上传头像，稍后可以进行裁剪。</span><br />
	<form id="upload" enctype="multipart/form-data" method="POST">
	<input id="avatarFile" type="file" name="avatarFile" />
	<button id="buttonUpload" onclick="return ajaxFileUpload()">上传</button>
	</form>
	</div>
	<?php 
}