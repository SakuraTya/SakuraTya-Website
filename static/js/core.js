/**
 * The entry of scripting contain menu building.
 * Licensed under Free-BSD
 * Author: Delacstrasz
 * Date: July 15th, 2012
 * Version: 1.0
 */

//lock the menu hover effect when this menu is the  current page
(function($, undefined){
    // prevent duplicate loading
    // this is only a problem because we proxy existing functions
    // and we don't want to double proxy them
    $.simpleMenu = $.simpleMenu || {};

    if($.simpleMenu.version){
        return;
    }

    $.extend($.simpleMenu, {
        version: "1.00",
        hrefList: {},
        returnDelay: 100
    });

    $.fn.extend({
        lockedMenu:function (returnDelay) {
            $.simpleMenu.returnDelay = returnDelay || $.simpleMenu.returnDelay;
            var currentPath = window.location.pathname;
            var currentURL = currentPath.substring(currentPath.lastIndexOf("/"), currentPath.length);
            currentURL = currentURL || "/index.html";
            //consider our default index.html is root /,so if the path is /index.html. convert to root
            currentURL = currentURL=="/index.html" ? "/" : currentURL;
            $.extend($.simpleMenu, {
                defaultURL: currentURL
            });
            var menuElement = this;
            this.find("a").each(function(index,domElement){
                var $anchor = $(domElement);
                var href = $anchor.attr("href");
                if(href==currentURL) {
                    $.simpleMenu.hrefList[ href ] = true;
                    $anchor.addClass("hot");
                } else {
                    $.simpleMenu.hrefList[ href ] = false;
                    $anchor.hover(function(event){
                        activeMenuItem(event, menuElement);
                    },function(event){
                        deactiveMenuItem(event, menuElement);
                    });
                }
            });
        }
    });

    function activeMenuItem (event, menuElement) {
        var target = event.target;
        var $anchor = $(target);
        $.simpleMenu.hrefList[ $anchor.attr("href") ] = true;
        $anchor.addClass("hot");
        // $.simpleMenu.hrefList[$.simpleMenu.defaultURL] = false;
        // menuElement.find("a[href='"+$.simpleMenu.defaultURL+"']").removeClass("hot");
        menuElement.find("a[href!='"+$anchor.attr("href")+"']").each(function(i, item){
            $(item).removeClass("hot");
            $.simpleMenu.hrefList[$(item).attr("href")] = false;
        });
        // console.log(target);
    }

    function deactiveMenuItem (event, menuElement) {
        var target = event.target;
        var $anchor = $(target);
        $.simpleMenu.hrefList[ $anchor.attr("href")] = false;
        $anchor.removeClass("hot");
        setTimeout(function() {
            var isMouseLeft = true;
            $.each($.simpleMenu.hrefList, function(index, item){
                if(item){
                    isMouseLeft = false;
                }
            });
            if(isMouseLeft) {
                $.simpleMenu.hrefList[$.simpleMenu.defaultURL] = true;
                menuElement.find("a[href='"+$.simpleMenu.defaultURL+"']").addClass("hot");
            }
        }, $.simpleMenu.returnDelay);
    }

})(jQuery);

function navMenuBuilding() {
    $("#nav_menu").lockedMenu();
    $("#nav_menu").lavaLamp({
        speed: 300,
        click: function(){

        },
        starItem : 1
    });
}

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

function convertTags() {
    $(".work_tags, #tags_selector_for_pop, #tags_selector_for_new").convertToTags({
        "click":function(tag_frame, event){
            var data = tag_frame.attr("data");
            console.log(data);
        }
    });
}

function layoutWorkPanel() {
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
    $(".zoom_in_tool").fancybox();

}

$(document).ready(function(){
    layoutWorkPanel();
    navMenuBuilding();
    dropDownTimeSelectorForPop();
    dropDownPlatformSelectorForPop();
    dropDownTagsSelectorForPop();
    convertTags();
});