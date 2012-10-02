function layoutWorkInfo () {
    $("#project_download_button").convertToButton();
    $("#project_favorite_button").convertToButton();
    $("#work_tags_list").convertToTags();
}

function Request(argname)
{ 
	var url = document.location.href; 
	var arrStr = url.substring(url.indexOf("?")+1).split("&"); 
	for(var i =0;i<arrStr.length;i++) 
	{ 
			var loc = arrStr[i].indexOf(argname+"="); 
			if(loc!=-1) 
			{ 
				return arrStr[i].replace(argname+"=","").replace("?",""); 
				break; 
			} 
	} 
	return ""; 
} 

function layoutUserCPL () {
    var userSignature= $("#signature");
    $("#user_signature_wrapper").height(userSignature.height()+30);

}

function page_handle (page_num, paginator) {
    // console.log(paginator);
    paginator.goToPage(page_num);
    paginator.children(".page_button_wrapper").convertToButton();
    var paginator_width = 0;
    paginator.children().each(function() {
        var child = $(this);
        
        if(child.hasClass("page_ellipsis_wrapper")) {
            paginator_width+= child.width() + 21;
        } else {
            paginator_width+= child.width()+8;
        }
        // console.log(paginator_width);
    });
    paginator_width += 20;
    // console.log(paginator_width);
    paginator.css({"width":  paginator_width+"px", "margin-left": "auto", "margin-right": "auto"});
}

function page_ajax_update(page_num,paginator) {
	alert(page_num);
	window.page_update_num=page_num;
	window.page_upd_paginator=paginator;
	$.ajax({
		"url":"/api/get_posts.php",
		"dataType":"json",
		"data":{"mode":"user","id":Request("author"),"page":page_num},
		"success":function(data){
			j=0;
			
			$.each(data,function(i,val){
				var work=$(".works_panel:eq("+j+")").children(".work_content_wrapper");
				var img=work.children(".preview_img_wrapper");
				img.children("a").attr("href",val.url);
				img.find("a img").attr("src","").attr("src",val.preview);
				img.find(".zoom_in_tool").attr("src",val.preview_big).fancybox({
			        "closeClick": true,
			        "helpers": {
			            "overlay": {
			                "css": {
			                    "overflow": "hidden"
			                }
			            }
			        }
			    });
				work.find(".work_title a").attr({"href":val.url,"title":val.title}).html(val.title);
				work.find(".work_author a").attr("href",val.author.url).html(val.author.name);
				tags=work.find(".work_tags").children("ul");
				tags.html("");
				if (typeof val.tags != 'undefined'){
					$.each(val.tags,function(i,val){
						var work=$(".works_panel:eq("+j+")").children(".work_content_wrapper");
						var tags=work.find(".work_tags").children("ul");
						tags.append("<li data=\""+val.id+"\">"+val.name+"</li>");
					});
					tags.convertToTags({
					       "click":function(tag_frame, event){
					            var data = tag_frame.attr("data");
					        }
					});
				}
				var stat=work.children(".statistics_show_wrapper");
				stat.children(".statistics_downloads_wrapper")
				.attr("title",val.downloads+"次下载")
				.children("span")
				.html(val.downloads)
				;
				stat.children(".statistics_comments_wrapper")
				.attr("title",val.comments+"条评论")
				.children("span")
				.html(val.comments)
				;
				stat.children(".statistics_favorites_wrapper")
				.attr("title",val.comments+"次收藏")
				.children("span")
				.html(val.favorites)
				;
				console.log(val.id);
				j=j+1;
			});
			console.log("comp");
			page_handle(page_update_num,page_upd_paginator);
		}
	});
}
function layoutWorkPanel() {
    //Add margins to work panel, but not the last one of each row.
    $("#user_works").children(".works_panel").each(function(index, item) {
        if( (index+1) % 4 != 0 ) {
            $(item).addClass("works_panel_margin");
        }
    });
    //Add slide animation to preview image light box controls.
    $(".work_content_wrapper div.preview_img_wrapper").hover(function(event) {
        $(this).find("div.img_lightbox_controls").slideDown("fast");
    }, function(event) {
        $(this).find("div.img_lightbox_controls").slideUp("fast");
    });
    //Apply FancyBox to light box controls
    //This version have bug, so, make sure have helpers property like this.
    $(".zoom_in_tool").fancybox({
        "closeClick": true,
        "helpers": {
            "overlay": {
                "css": {
                    "overflow": "hidden"
                }
            }
        }
    });
    //trim the long title to fit the size of work panel
    var workTitleWidth = $(".work_title").width();
    $(".work_title a").ellipsis({"width":workTitleWidth, "useContainerPadding": true, "useContainerMargin": false});
    //convert tags
    $(".work_tags").convertToTags({
        "click":function(tag_frame, event){
            var data = tag_frame.attr("data");
            console.log(data);
        }
    });

    $(".category_paginater").paginator({
        "totalItems": 500,
        "num_per_page": 16,
        "currentPage": 0,
        "num_display_entries": 5,
        "num_edge_entires": 1,
        "prev_page_text": "上一页",
        "next_page_text": "下一页",
        "ellipsis_text": "...",
        "callback": page_ajax_update,
        "ajax": true
    });
    $(".page_button_wrapper").convertToButton();
    
    $(".category_paginater").each(function(){
        var paginator_width = 0;
        $(this).children().each(function() {
            var child = $(this);
            
            if(child.hasClass("page_ellipsis_wrapper")) {
                paginator_width+= child.width() + 21;
            } else {
                paginator_width+= child.width()+8;
            }
            // console.log(paginator_width);
        });
        paginator_width += 20;
        // console.log(paginator_width);
        $(this).css({"width":  paginator_width+"px", "margin-left": "auto", "margin-right": "auto"});
    });
}

$(document).ready(function(){
    layoutWorkInfo();
    layoutUserCPL();
    layoutWorkPanel();
});