function navMenuBuilding(currentItem) {
    $("#nav_menu").lavaLamp({
        "speed": 300,
        "click": function() {

        },
        "startItem": currentItem,
        "returnStart": function(homeElement) {
            $("#nav_menu").children().each(function() {
                if(!$(this).hasClass("selectedLava")) {
                    $(this).children().removeClass("hot");
                }
            })
        },
        "returnFinish": function(homeElement) {
            var homeAnchor = homeElement.children("a");
            homeAnchor.addClass("hot");
        },
        "hoverStart": function(hoverElement) {
            if(hoverElement != null && hoverElement.hasClass("selectedLava")) {
                return;
            }
            $("#nav_menu").children().each(function() {
                $(this).children().removeClass("hot");
            })
        },
        "hoverFinish": function(hoverElement) {
            var hoverAnchor = hoverElement.children("a");
            hoverAnchor.addClass("hot");
        }
    });
    $("#nav_menu").children().each(function() {
        var listElement = $(this);
        if(listElement.hasClass("selectedLava")) {
            listElement.children().addClass("hot");
        }
    })
}

function buildList(page) {

    $.get("/api/get_posts.php?mode=category&id=3&time=all&page="+page, function(data) {
        console.log(data);
        if($.isArray(data)) {
            var listAdapter = {
                "list": data,
                "getCount": function() {
                    return this.list.length;
                },
                "getView": function(position) {
                    var item = this.list[position];
                    return buildWorkPanel(item);
                }
            };
            var gridList = $("#new_works_show .works_panel_wrapper").gridList({
                "loadMoreIndicator":createDefaultLoadMoreIndicator,
                "onLayoutComplete": onLayoutComplete,
                "onDataLoading": function(){
                    loadData(++page, listAdapter, gridList);
                },
                "maxLoadTimes": 1
            });
            gridList.setAdapter(listAdapter);
            
        }
    }, "json");
}

function buildWorkPanel(item) {
    var view = $("<div>").attr({
        "id": "work_id_" + item.id,
        "class": "works_panel"
    });
    var work_content_wrapper = $("<div>").addClass("work_content_wrapper").appendTo(view);

    var zoom_in_tool = $("<a>").attr({
        "href": item.preview_big,
        "class": "zoom_in_tool"
    });
    //build img_light_controls
    var img_lightbox_controls = $("<div>").addClass("img_lightbox_controls").append(zoom_in_tool);
    //build preview_img_wrapper
    var preview_img_wrapper = $("<div>").addClass("preview_img_wrapper").append(
    $("<a>").attr("href", item.url).append(
    $("<img>").attr("src", item.preview))).append(img_lightbox_controls).appendTo(work_content_wrapper);
    //Add slide animation to preview image light box controls.
    preview_img_wrapper.hover(function(event) {
        img_lightbox_controls.slideDown("fast");
    }, function(event) {
        img_lightbox_controls.slideUp("fast");
    });
    //Apply FancyBox to light box controls
    //This version have bug, so, make sure have helpers property like this.
    zoom_in_tool.fancybox({
        "closeClick": true,
        "helpers": {
            "overlay": {
                "css": {
                    "overflow": "hidden"
                }
            }
        }
    });

    var work_title_anchor = $("<a>").attr({
        "href": item.url,
        "title": item.title
    }).html(item.title);
    //build work_title
    $("<div>").addClass("work_title").append(work_title_anchor).appendTo(work_content_wrapper);

    //build work_author
    $("<div>").addClass("work_author").append(
    $("<span>").html("by")).append(
    $("<a>").attr("href", item.author.url).html(item.author.name)).appendTo(work_content_wrapper);
    //build work_tags
    $("<div>").addClass("work_tags").append(
    $("<ul>").append(

    function(index, html) {
        if(item.tags) {
            var tag = item.tags[0]
            return $("<li>").attr("data", tag.id).html(tag.name);
        }
    })).appendTo(work_content_wrapper).convertToTags({
        "click": function(tag_frame, event) {
            var data = tag_frame.attr("data");
            console.log(data);
        }
    });

    $("<div>").addClass("work_panel_divider").appendTo(work_content_wrapper);
    $("<div>").addClass("statistics_show_wrapper").append(
    $("<div>").attr({
        "class": "statistics_downloads_wrapper",
        "title": item.downloads + "次下载"
    }).append(
    $("<div>").addClass("downloads_icon")).append(
    $("<span>").html(item.downloads))).append(
    $("<div>").attr({
        "class": "statistics_comments_wrapper",
        "title": item.comments + "条评论"
    }).append(
    $("<div>").addClass("comments_icon")).append(
    $("<span>").html(item.comments))).append(
    $("<div>").attr({
        "class": "statistics_favorites_wrapper",
        "title": item.favorites + "次收藏"
    }).append(
    $("<div>").addClass("favorites_icon")).append(
    $("<span>").html(item.favorites))).appendTo(work_content_wrapper);
    $("<div>").addClass("work_special_indicator").appendTo(view);

    return view;
}

/**
 * Create a default load more indicator according to the params.loadOnScroll
 */
function createDefaultLoadMoreIndicator(gridList) {
    var loadMoreIndicator = $("<div>").addClass("gridlist_load_more");
    
    loadMoreIndicator.addClass("default_loadmoreIndicator");
    var loadMoreWrapper = $("<div>").addClass("load_more_wrapper");
    var loadMoreText = $("<div>").addClass("load_more_text").html("SHOW MORE");
    loadMoreWrapper.append(loadMoreText).appendTo(loadMoreIndicator);
    var loadMoreLoading = $("<div>").addClass("load_more_loading").appendTo(loadMoreWrapper);
    var loadMoreOverlay = $("<div>").addClass("load_more_overlay").appendTo(loadMoreWrapper);
    var loadMoreButton = $("<div>").addClass("load_more_button").appendTo(loadMoreWrapper);
    gridList.originalTop = 0;
    gridList.totalOffset = 10;
    gridList.maxMoveDuration = 300;
    loadMoreButton.hover(function(event){
        loadMoreOverlay.clearQueue();
        loadMoreOverlay.stop();
        // if(originalTop === 0) {
        //     originalTop = $.getInt(loadMoreOverlay.css("top"));
        // }
        var current = $.getInt(loadMoreOverlay.css("top"));
        var offset = gridList.totalOffset - (current - gridList.originalTop);
        if(offset > 0) {
            var duration = offset * (gridList.maxMoveDuration / gridList.totalOffset);
            loadMoreOverlay.animate({"top": "+="+offset}, duration);
        }
        
        loadMoreOverlay.delay(500);
    },function(event){
        if(gridList.isLoadingData) {
            return;
        }
        var current = $.getInt(loadMoreOverlay.css("top"));
        var offset = current - gridList.originalTop;
        if(offset > 0) {
            var duration = offset * (gridList.maxMoveDuration / gridList.totalOffset);
            loadMoreOverlay.animate({"top": "-="+offset}, duration);
        }
    });
    loadMoreButton.click(function(event){
        
        if($.isFunction(gridList.onDataLoading)) {
            
            gridList.onDataLoading();
        }
    });
    
    return loadMoreIndicator;
}

function loadData(page, adapter, gridList) {
    gridList.isLoadingData = true;
    var loadMoreText = gridList.find(".gridlist_load_more .load_more_text");
    var loadMoreLoading = gridList.find(".gridlist_load_more .load_more_loading");
    var loadMoreButton = gridList.find(".gridlist_load_more .load_more_button");
    var loadMoreOverlay = gridList.find(".gridlist_load_more .load_more_overlay");
    loadMoreText.css("display", "none");
    loadMoreLoading.css("display", "block");
    loadMoreButton.css("display", "none");
    var current = $.getInt(loadMoreOverlay.css("top"));
    var offset = gridList.totalOffset - (current - gridList.originalTop);
    if(offset > 0) {
        var duration = offset * (gridList.maxMoveDuration / gridList.totalOffset);
        loadMoreOverlay.animate({"top": "+="+offset}, duration);
    }
    $.get("/api/get_posts.php?mode=category&id=3&time=all&page="+page, function(data){
        setTimeout(function(){
            if($.isArray(data)) {
                var currentLast = adapter.getCount() - 1;
                $.merge(adapter.list, data);
                gridList.layoutChildren(currentLast + 1);
            } else {
                gridList.isLoadingData = false;
                restLoadMoreIndicator(gridList);
            }
        }, 2000);
        
    },"json")
}

function restLoadMoreIndicator (gridList, loadMoreIndicator) {
    var loadMoreText = gridList.find(".gridlist_load_more .load_more_text");
    var loadMoreLoading = gridList.find(".gridlist_load_more .load_more_loading");
    var loadMoreButton = gridList.find(".gridlist_load_more .load_more_button");
    var loadMoreOverlay = gridList.find(".gridlist_load_more .load_more_overlay");
    loadMoreOverlay.clearQueue();
    loadMoreOverlay.stop();
    loadMoreButton.css("display", "block");
    loadMoreLoading.css("display", "none");
    loadMoreText.css("display", "block");
    var current = $.getInt(loadMoreOverlay.css("top"));
    var offset = current - gridList.originalTop;
    if(offset > 0) {
        var duration = offset * (gridList.maxMoveDuration / gridList.totalOffset);
        loadMoreOverlay.animate({"top": "-="+offset}, duration);
    }
}

function onLayoutComplete(gridList, startPosition) {
    var loadMoreIndicator = gridList.children(".gridlist_load_more");
    var loadMoreOverlay = loadMoreIndicator.find(".load_more_overlay");
    if(gridList.originalTop === 0) {
        gridList.originalTop = $.getInt(loadMoreOverlay.css("top"));
    }
    if(gridList.isLoadingData) {
        gridList.isLoadingData = false;
        restLoadMoreIndicator(gridList);
    }
    //trim the long title to fit the size of work panel
    var workTitleWidth = gridList.find(".work_title").width();

    gridList.find(".work_title a:not(:lt("+ startPosition+ "))").ellipsis({
        "width": workTitleWidth,
        "useContainerPadding": true,
        "useContainerMargin": false
    });
    
}