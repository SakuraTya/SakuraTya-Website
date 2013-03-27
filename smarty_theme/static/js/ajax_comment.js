function updateComments(){
	var raw=$('.commentlist').children().detach();
	$('.commentlist')
	.append($('<img>').attr('src','/wp-content/themes/sakuratya/img/loading.gif').addClass('ajax_loading'))
	.load(ajaxurl,{
		"action":"update_comments",
		"id":post_id
	},function(data,code){
		$('.ajax_loading').remove();
	});
}

function createReplyForm(parentUserUrl,parentUserName,parentId){
	var avatar=$(".respond_avatar img").attr('src');
	var user_url=$(".respond_name").attr('href');
	var uname=$(".respond_name").text();
	console.log('Form created.');
	return $('<div>')
	.addClass('comment')
	.append(
		$('<div>')
		.addClass('comment_meta')
		.append(
			$('<div>')
			.addClass('comment_author')
			.append(
				$('<a>')
				.addClass('comment_author_avatar')
				.attr('href',user_url)
				.append(
					$('<img>')
					.attr('src',avatar)
				)
			)
			.append(
				$('<a>')
				.addClass('comment_author_name')
				.attr('href',user_url)
				.text(uname)
			)
		)
		.append(
			$('<div>')
			.addClass('comment_conversation')
			.append('<span>对</span>')
			.append($('<a>').attr('href',parentUserUrl).text(parentUserName))
			.append('<span>的回复</span>')
		)
	)
	.append(
		$('<div>')
		.css({
			"display":"block",
			"clear":"both"
		})
	)
	.append(
		$('<textarea>')
		.addClass('reply_textarea')
	)
	.append(
		$('<div>').addClass('reply_action_links')
		.append(
			$('<span>').text('提交').addClass('reply_action_submit')
		)
		.append(
			$('<span>').text('取消').addClass('reply_action_cancel')
		)
		.attr('cid',parentId)
	);
}

$(function(){
	$('.reply_textarea').live('keyup',function(e){
		if(e.keyCode==27){
			$(e.target).parent().parent().remove();
		}
	});
	$('.reply_action_cancel').live('click',function(e){
		$(e.target).parent().parent().parent().remove();
	});
	$(".reply").live('click',function(e){
		console.log('Event fire!');
		com=$(e.target).parent().parent();
		var cid=com.children('.edit_link').attr('cid');
		if(com.parent().parent().is('ol')){
			parent=com;
		}else{
			parent=com.parent().parent().prev();
		}
		form=createReplyForm(parent.find('.comment_author_name').attr('href'),parent.find('.comment_author_name').text(),parent.find('.edit_link').attr('cid'));
		if(com.next().is('ul')==false){
			com.parent().append('<ul calss="children"><li class="comment"></li></ul>');
		}else{
			com.next().append('<li class="comment"></li>');
		}
		com.next().children('li:last').append(form);
		form.find('textarea').css('width',form.innerWidth());
	});
	$('.edit_link').live('click',function(e){
		var com=$(e.target).parent().parent();
		var cid=com.children('.edit_link').attr('cid');
		noty({
			"text":"在未经评论原作者同意的情况下修改评论，可能会引起原作者的不满。<br>是否继续？",
			"type":"warning",
			"buttons":[
			{"addClass":"btn btn-danger","text":'继续',"onClick":function($noty){
				var src=com.children(".reply, .edit_link, .comment_content").detach();
				$noty.close();
				$('<textarea>')
				.css("width",com.innerWidth())
				.addClass('edit_textarea')
				.val(src.eq(0).find('p').html())
				.appendTo(com)
				.keyup(function(e){
					if(e.keyCode==27){
						$(e.target).parent().children('.comment_meta').after(src);
						$(e.target).parent().children(".edit_textarea, .edit_action_links").remove();
					}
				});
				$('<div>').addClass('edit_action_links')
				.append(
					$('<span>').text('提交').addClass('edit_action_submit')
				)
				.append(
					$('<span>').text('取消').addClass('edit_action_cancel')
				)
				.appendTo(com);
				$(".edit_action_cancel").click(function(e){
					$(e.target).parent().parent().children('.comment_meta').after(src);
					$(e.target).parent().parent().children(".edit_textarea, .edit_action_links").remove();
				});
				$(".edit_action_submit").click(function(e){
					var prog=noty({
						 "dismissQueue":false,
						 "text":"正在处理，请勿关闭此页面。",
						 "type":'information'
					});
					$.ajax({
						"dataType":"json",
						"type":"POST",
						"url":ajaxurl,
						"success":function(data,stat){
							prog.close();
							if(data.status!=1){
								noty({
									"dismissQueue":false,
									"text":"操作失败，请重试。",
									"type":"error"
								});
							}else{
								noty({
									"dismissQueue":false,
									"text":"操作成功<br>正在刷新",
									"timeout":"2000",
									"type":"success"
								});
							}
							updateComments();
						},
						"data":{
							"content":$(e.target).parent().parent().children(".edit_textarea").val(),
							"action":"edit_comment",
							"cid":cid
						}
					});
					$(e.target).parent().parent().children('.comment_meta').after(src);
					$(e.target).parent().parent().children(".edit_textarea, .edit_action_links").remove();
				});
				
			}},
			{"addClass":"btn btn-primary","text":"取消","onClick":function($noty){
				$noty.close();
			}}
			           ]
		});
			});	
});