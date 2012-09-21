function dropDownTimeSelectorForPop() {
    var api = "/api/time";
    $("#time_selector_for_pop").jDropDownControl({
        "click":function(index, event) {
            var target = event.target;
            var data = $(target).attr("data");
            console.log(data);
            // var time = $.parseJSON(data);
            $("#time_selector_for_pop div.drop_down_wrapper").children("span").text($(target).text());
            if(data){
                // window.location = api+"?time="+data;
                
            }
        }
    });
    $("#time_selector_for_new").jDropDownControl({
        "click":function(index, event) {
            var target = event.target;
            var data = $(target).attr("data");
            console.log(data);
            // var time = $.parseJSON(data);
            $("#time_selector_for_new div.drop_down_wrapper").children("span").text($(target).text());
            if(data){
                // window.location = api+"?time="+data;
                
            }
        }
    });
}

function dropDownPlatformSelectorForPop() {
    var api="/api/platform";
    $("#platform_selector_for_pop").jDropDownControl({
        "click":function(index, event) {
            var target = event.target;
            var data = $(target).attr("data");
            console.log(data);
            $("#platform_selector_for_pop div.drop_down_wrapper").children("span").text($(target).text());
            if(data) {
                // window.location = api+"?platform="+data;
            }
        }
    });
    $("#platform_selector_for_new").jDropDownControl({
        "click":function(index, event) {
            var target = event.target;
            var data = $(target).attr("data");
            console.log(data);
            $("#platform_selector_for_new div.drop_down_wrapper").children("span").text($(target).text());
            if(data) {
                // window.location = api+"?platform="+data;
            }
        }
    });
}

function dropDownTagsSelectorForPop() {
    var api="/api/tags";
    $("#tags_selector_for_pop").jDropDownControl({
        "click":function(index, event) {
            var target = event.target;
            var data = $(target).attr("data");
            console.log(data);
            if(data) {
                // window.location = api+"?platform="+data;
            }
        },
        "width": "200px",
        "defaultLabel": "TAGs"
    });
    $("#tags_selector_for_new").jDropDownControl({
        "click":function(index, event) {
            var target = event.target;
            var data = $(target).attr("data");
            console.log(data);
            if(data) {
                // window.location = api+"?platform="+data;
            }
        },
        "width": "200px",
        "defaultLabel": "TAGs"
    });
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

function layoutWorkPanel() {
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

    $(".category_paginater").paginator({
        "totalItems": 500,
        "num_per_page": 16,
        "currentPage": 0,
        "num_display_entries": 5,
        "num_edge_entires": 1,
        "prev_page_text": "上一页",
        "next_page_text": "下一页",
        "ellipsis_text": "...",
        "callback": page_handle,
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
    

    //convert tags
    $(".work_tags, #tags_selector_for_pop, #tags_selector_for_new").convertToTags({
        "click":function(tag_frame, event){
            var data = tag_frame.attr("data");
            console.log(data);
        }
    });
}

$(document).ready(function(){
    layoutWorkPanel();
    dropDownTimeSelectorForPop();
    dropDownPlatformSelectorForPop();
    dropDownTagsSelectorForPop();
});