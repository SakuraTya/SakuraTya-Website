function navMenuBuilding(currentItem) {
    $("#nav_menu").lavaLamp({
        "speed": 300,
        "click": function(){

        },
        "startItem" : currentItem,
        "returnStart": function(homeElement) {
            $("#nav_menu").children().each(function() {
                if(!$(this).hasClass("selectedLava")){
                    $(this).children().removeClass("hot");
                }
            })
        },
        "returnFinish": function(homeElement) {
            var homeAnchor = homeElement.children("a");
            homeAnchor.addClass("hot");
        },
        "hoverStart": function(hoverElement) {
            if(hoverElement!=null && hoverElement.hasClass("selectedLava")){
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
    $("#nav_menu").children().each(function(){
        var listElement = $(this);
        if(listElement.hasClass("selectedLava")) {
            listElement.children().addClass("hot");
        }
    })
}

(function($, undefined) {

    $.fn.listAdapter = function(list) {
        $.extend(this, {
            "list": new Array(),
            "getCount": function() {
                return list.length;
            },
            "getItem":function(position) {
                return list[position];
            },
            "getItemId": function(position) {
                return 0;
            },
            "getView": function(position) {
                return null;
            }
        });
        this.list = list;
    }

    $.fn.gridList = function(params) {
        params = $.extend({
            "stretchMode": false,
            "numColumn": 4,
            "columnWidth": "250px",
            "verticalSpacing": "6px"
        }, params || {});

        $.extend(this, {
            /**
             * Add a view before or after specific position.
             * @param position, an integer value, define where should be insert to.
             * @param before, an boolean value, define if should insert before the position or after it.
             */
            "addView":function(position, before) {
                if (adapter && adapter.length > 0) {
                    var child = adapter.getView(position);
                    if(child) {
                        addViewInLayout(position, before, child);
                    }
                };
            },
            /**
             * Remove a view in specific position.
             * position, an integer value, define which view of position should be removed.
             */
            "removeView":function(position) {

            },
            "adapter": null,
            "recycleBin": new Array();
        });

        var addViewInLayout = function(position, before, view) {
            if(before) {
                
            } else {

            }
        }
        var removeViewInLayout = function(view) {
            // body...
        }
    }
})(jQuery);