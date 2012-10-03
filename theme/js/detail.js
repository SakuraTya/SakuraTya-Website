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

function workPanel(data){
	var node=$("<div>");
	node.attr({"class":"works_panel","id":"work_id_"+data.id});
	var con_wrapper=$("<div>").attr("class","work_content_wrapper");
	$("<div>")
	.attr("class","preview_img_wrapper")
	.append(
			$("<a>")
			.attr("href",data.url)
			.append(
					$("<img>").attr("src",data.preview)
					)
			)
	.append(
			$("<div>")
			.addClass("img_lightbox_controls")
			.append(
					$("<a>")
					.attr({"href":data.preview_big,"class":"zoom_in_tool"})
					)
			)
	.appendTo(con_wrapper);
	$("<div>")
	.addClass("work_title")
	.append(
			$("<a>")
			.attr({"href":data.url,"title":data.title})
			.html(data.title)
			)
	.appendTo(con_wrapper);
	$("<div>")
	.addClass("work_author")
	.append($("<span>by</span>"))
	.append(
			$("<a>")
			.attr("href",data.author.url)
			.html(data.author.name)
			)
	.appendTo(con_wrapper);
	$("<div>")
	.addClass("work_tags")
	.append(
			$("<ul>")
			.append(function(){
				if(typeof data.tags == 'undefined')return "";
				var ret="";
				$.each(data.tags,function(i,val){
					ret +="<li data=\""+val.id+"\">"+val.name+"</li>";
				});
				return ret;
			})
			)
	.appendTo(con_wrapper);
	$("<div>").addClass("work_panel_divider").appendTo(con_wrapper);
	var stat_wrapper=$("<div>")
	.addClass("statistics_show_wrapper");
	$("<div>")
	.addClass("statistics_downloads_wrapper")
	.attr("title",data.downloads+"次下载")
	.append($("<div>").addClass("downloads_icon"))
	.append($("<span>").html(data.downloads))
	.appendTo(stat_wrapper);
	$("<div>")
	.addClass("statistics_comments_wrapper")
	.attr("title",data.comments+"条评论")
	.append($("<div>").addClass("comments_icon"))
	.append($("<span>").html(data.comments))
	.appendTo(stat_wrapper);
	$("<div>")
	.addClass("statistics_favorites_wrapper")
	.attr("title",data.favorites+"次收藏")
	.append($("<div>").addClass("favorites_icon"))
	.append($("<span>").html(data.favorites))
	.appendTo(stat_wrapper);
	stat_wrapper.appendTo(con_wrapper);
	con_wrapper.appendTo(node);
	$("<div>").addClass("work_special_indicator").appendTo(node);
	return node;
}

function layoutUserCPL () {
    var userSignature= $("#signature");
    $("#user_signature_wrapper").height(userSignature.height()+30);

}

function page_handle (page_num, paginator) {
    //console.log(paginator);
	console.log(page_num);
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
function lockPanel(){
	
}
function page_ajax_update(page_num,paginator) {
	page_num+=1;
	//Lock the <div>element here.
	/*$("<div>")
	.css({"mirgin-left":"auto","mirgin-right":"auto","width":"100px"})
	.addClass("loadingGif")
	.append(
			$("<img>").attr("src","/wp-content/themes/sakuratya/img/loading.gif")
			)
	.prependTo($("#user_works"));
	$("#user_works .works_panel").css("display","none");
	*/
	lockPanel();
	$.ajax({
		"url":"/api/get_postsd.php",
		"dataType":"json",
		"data":{"mode":"user","id":Request("author"),"page":page_num},
		"success":function(data){
			j=0;
			if (typeof data.msg !='undefined'){
				//error
			}
			$("#user_works .works_panel").remove();
			$.each(data,function(i,val){
				workPanel(val).prependTo($("#user_works")).find(".work_tags").convertToTags({
			        "click":function(tag_frame, event){
			            var data = tag_frame.attr("data");
			        }
			    });
				j=j+1;
			});
			var getInt = function (pxValue) {
		        var pattern = /\d+/g;
		        return parseInt(pxValue.match(pattern)[0]);
		    };
		    //Add margins to work panel, but not the last one of each row.
		    $(".works_panel_wrapper").children(".works_panel").each(function(index, item) {
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
		    //convert the more content link to a relief button.
		    $(".more_content_button_wrapper").convertToButton();
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

		    var maxWords = 16;
		    //trim the long title to fit the size of work panel
		    var workTitleWidth = $(".work_title").width();
		    
		    $(".work_title a").ellipsis({"width":workTitleWidth, "useContainerPadding": true, "useContainerMargin": false});
			page_handle(page_num-1,paginator);
			//$(".loadingGif").remove();
		},
		"error":function(xhr,text){
			console.log(text);
		}
	});
}
function layoutWorkPanel(totalItems,num_per_page) {
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
        "totalItems": totalItems,
        "num_per_page": num_per_page,
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
});