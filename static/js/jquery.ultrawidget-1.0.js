/**
 * 
 * This is code is under Free-BSD License.
 * Author: Delacstrasz
 * Version 1.0
 * Date: July 25th, 2012
 */

 (function($, undefined){
    /**
     * Usage:
     * We have a html like this:
     * <div id="menu"></div>
     * initialize the plugin: $("div#menu").jDropDownControl();
     * The following styles need to be defined:
     * div#menu ul.drop_down {
     *     background: #dfdfdf;
     * }
     * div#menu ul.drop_down li.selected {
     *     background: transparent;
     *     color: #156bcb;
     * }
     * div#menu ul.drop_down li {
     *     background:transparent;
     *     color: #989898;
     * }
     * div#menu ul.drop_down li.focused {
     *     background: #989898;
     *     color: #ffffff;
     * }
     *
     * If you have a menu already created. your should place all data that not shown in an attribute "data" of each <li> element.
     */
    $.getInt = function (pxValue) {
        if(typeof(pxValue)=="string") {
            var pattern = /\d+/g;
            var matchResult = pxValue.match(pattern);
            if(matchResult!=null && matchResult.length>0) {
                return parseInt(matchResult[0]);
            } else {
                console.log("error: this value can't parse to integer");
                return 0;
            }
        } else if(typeof(pxValue)=="number") {
            return pxValue;
        } else {
            return 0;
        }
    };

    $.fn.jDropDownControl = function(params) {
        params = $.extend({
            "url": null,
            "width": null,
            "height": "auto",
            "click": function() {
                return true;
            },
            "labelKeyName": "name", //If you choose ajax build your dropdown, this item must be set or it will use default key name.
            "dataKeyName": "data", //If you choose ajax build your dropdown, this item must be set or it will use default key name.
            "startItem": 1, //Only available in ajax load mode.
            "loadingText": "Loading...",
            "ready": false,
            "defaultLabel": null
        }, params || {});
        params.width = params.width ? $.getInt(params.width) : this.width();
        var holderHeight = this.height();
        //The div holder can't have a static position style.
        var cssPosition = this.css("position");
        if (cssPosition == "static") {
            this.css("position", "relative");
        }
        this.addClass("drop_down_holder");

        //Binding events to holder and other elements
        var buildDropDownControls = function(holder) {
            var ulElement = holder.children("ul");
            $("body").on("click", function(event) {
                var clickedTarget = $(event.target);
                // console.log(clickedTarget);
                if(clickedTarget.is(holder.get(0)) || clickedTarget.parents(".drop_down_holder").is(holder)){
                    return true;
                } else {
                    ulElement.hide();
                    drop_down_wrapper.removeClass("pressed");
                }

                return true;
            });
            
            //bind events to holder
            var drop_down_wrapper = holder.children("div.drop_down_wrapper");
            drop_down_wrapper.hover(function(event) {
                drop_down_wrapper.addClass("focused");
            },function(event) {
                drop_down_wrapper.removeClass("focused"); 
            });

            //bind hover and click handler to every list item(<li>element)
            ulElement.children("[data]").each(function(index, liElement) {
                $(liElement).hover(function(event) {
                    $(event.target).addClass("focused");
                }, function(event) {
                    $(event.target).removeClass("focused");
                }).click(function(event) {
                    ulElement.toggle();
                    ulElement.children("li[class~='selected']").removeClass("selected");
                    $(liElement).addClass("selected");
                    drop_down_wrapper.removeClass("pressed");
                    //pass the index and event to the handler given.
                    params.click(index, event);
                });
            })
            return drop_down_wrapper.click(function(event) {
                drop_down_wrapper.toggleClass("pressed");
                ulElement.toggle();
                console.log("display="+ulElement.css("display"));
            });
         }
        var onAjaxComplete = function(jqXHR, settings) {
              //TODO: need to be done.
         }
        var onAjaxError = function(jqXHR, textStatus, errorThrown) {
            //TODO: when something went wrong.
         }
        var onAjaxSuccess = function(data, textStatus, jqXHR) {
            //TODO: when get data successfully.
         }
        if (params.url) {
            //if use ajax to load dropdown menu, we need to build ul element first.
            var drop_down_wrapper = $("<div>");
            drop_down_wrapper.addClass("drop_down_wrapper");
            this.append(drop_down_wrapper);
            var holderTextSpan = $("<span>");
            if(params.defaultLabel){
                drop_down_wrapper.append(holderTextSpan.text(params.defaultLabel));
            } else {
                drop_down_wrapper.append(holderTextSpan.text(loadingText));
            }
            var holderPinImg =$("<div>");
            drop_down_wrapper.append(holderPinImg.addClass("dropDownPinImg"));
            var dropDownUL = $("<ul>");
            dropDownUL.addClass("drop_down");
            var dropDownUL = this.children("ul").addClass("drop_down");
            var paddingLeft = $.getInt(dropDownUL.css("padding-left"));
            var paddingRight = $.getInt(dropDownUL.css("padding-right"));
            var paddingTop = $.getInt(dropDownUL.css("padding-top"));
            var paddingBottom = $.getInt(dropDownUL.css("padding-bottom"));
            dropDownUL.css({
              "width": params.width - paddingLeft - paddingRight,
              "height": params.height -paddingTop - paddingBottom,
              "top": holderHeight
            });
            this.append(dropDownUL);

            var request = $.ajax(url, {
              "type": "GET",
              "complete": onAjaxComplete,
              "dataType": "json",
              "error": onAjaxError,
              "success": onAjaxSuccess,
              "timeout": 30000
            });
            var holder = this;
            request.done(function(data){
                if(data){
                    $.each(data,function(index, item){
                        //we use labelKeyName to display, others put as attribute "data" in each <li> element
                        var name = item[params.labelKeyName];
                        if(index+1 == params.startItem && params.defaultLabel){
                            holder.children("span").text(name);
                        }
                        var liElement = $("<li>");
                        liElement.text(name);
                        var otherData = item[params.dataKeyName];
                        liElement.attr("data", otherData);
                        holder.children("ul").append(liElement);
                    });
                    return buildDropDownControls(holder);
                }
            });
            // request.fail();

        } else {
            //If we already have a ul list, only get the default text. and show it at holder
            var defaultItemText = this.find("li[class~='selected']").text();
            var drop_down_wrapper = $("<div>");
            drop_down_wrapper.addClass("drop_down_wrapper");
            this.append(drop_down_wrapper);
            if(params.defaultLabel){
                drop_down_wrapper.append($("<span>").text(params.defaultLabel));
            } else {
                drop_down_wrapper.append($("<span>").text(defaultItemText));
            }
            var holderPinImg =$("<div>");
            drop_down_wrapper.append(holderPinImg.addClass("dropDownPinImg"));
            var dropDownUL = this.children("ul").addClass("drop_down");
            var paddingLeft = $.getInt(dropDownUL.css("padding-left"));
            var paddingRight = $.getInt(dropDownUL.css("padding-right"));
            var paddingTop = $.getInt(dropDownUL.css("padding-top"));
            var paddingBottom = $.getInt(dropDownUL.css("padding-bottom"));
            dropDownUL.css({
              "width": params.width - paddingLeft - paddingRight,
              "height": params.height -paddingTop - paddingBottom,
              "top": holderHeight
            });
            
            //build the dropdown menu now!
            return buildDropDownControls(this);
        }
        // return this;
    };

    /**
     * tags can make your list to a tags constructed list
     * Usage:
     * <div class='"tag_holder">
     *     <ul>
     *         <li>tag_a</li>
     *         <li>tag_b</li>
     *         <li>tag_c</li>
     *         <li>tag_d</li>
     *     </ul>
     * </div>
     * define styles with these class below:
     * .tag_frame {
     *       display: block;
     *      float: left;
     *       height: 18px;
     *       margin: 4px 4px 4px 5px;
     *       cursor: pointer;
     *   }
     *
     *   .tag_frame div.left_frame {
     *       padding: 2px 7px 2px 5px;
     *       display: block;
     *       float: left;
     *       background: #ffffff;
     *       border-top: 1px solid #cfcfcf;
     *       border-left: 1px solid #cfcfcf;
     *       border-bottom: 1px solid #cfcfcf;
     *       color: #a6a6a6;
     *       font-size: 12px;
     *       line-height: 12px;
     *   }
     *
     *   .tag_frame.focused div.left_frame {
     *       background: #cfcfcf;
     *       color: #ffffff;
     *   }
     *
     *   .tag_frame div.right_frame {
     *       width: 9px;
     *       height: 18px;
     *       display: block;
     *       float: left;
     *       background: url("../img/spirite.png") no-repeat;
     *       background-position: -300px -77px;
     *   }
     *
     *   .tag_frame.focused div.right_frame {
     *       background: url("../img/spirite.png") no-repeat;
     *       background-position: -300px -96px;
     *   }
     */
    $.fn.convertToTags = function(params){
        params = $.extend({
            "click": function(){return true},
            "maxWords": 0,
            "targetFrame": "li"
        }, params || {});
        return this.each(function() {
            $(this).find(params.targetFrame).each(function(index, item){
                var tag_frame = $(item).addClass("tag_frame");
                var tag_name = tag_frame.first().text();
                var tag_left = $("<div>").addClass("left_frame");
                //clean the text node of the taget element
                tag_frame.empty();
                //if give a max words limitation. we trim the words over maxWords. and add "...". add a title
                //attribute to tag_frame.
                if(params.maxWords>0 && tag_name!="" && tag_name.length > params.maxWords){
                    tag_frame.attr("title", tag_name);
                    tag_name = tag_name.substr(0, params.maxWords) + "...";   
                }
                tag_left.text(tag_name);
                var tag_right = $("<div>").addClass("right_frame");
                tag_frame.append(tag_left);
                tag_frame.append(tag_right);
                tag_frame.hover(function(event){
                    tag_frame.addClass("focused");
                }, function(event){
                    tag_frame.removeClass("focused");
                }).click(function(event) {
                    params.click(tag_frame, event);
                })
            });
        });
    };

    /**
     * Generate a reilef effect button without using any picture.
     * This plugin use orginal button width or params.width
     */
    $.fn.convertToButton = function(params) {
        params = $.extend({
            "width": null,
            "height" : null,
            "click": null
        },params || {});
        return this.each(function() {
            var button_wrapper = $(this);
            var width = params.width;
            var height = params.height;
            if( !width ) {
                width = button_wrapper.width();
            }
            if( !height) {
                height = button_wrapper.height();
            }
            width = $.getInt(width) + 1;
            height = $.getInt(height) + 1;
            button_wrapper.css({
                "width": width + "px",
                "height": height + "px"
            });
            var childElements = button_wrapper.children().detach();
            var glow_layer = $("<div>").css({
                "width": width + "px",
                "height": height + "px"
            });;
            var shadow_layer = $("<div>").css({
                "width": width + "px",
                "height": height + "px"
            });
            if(button_wrapper.hasClass("selected")) {
                glow_layer.addClass("button_glow_layer_selected");
                shadow_layer.addClass("button_shadow_layer_selected");
            } else if(button_wrapper.hasClass("disabled")) {
                glow_layer.addClass("button_glow_layer_disabled");
                shadow_layer.addClass("button_shadow_layer_disabled");
            } else {
                glow_layer.addClass("button_glow_layer");
                shadow_layer.addClass("button_shadow_layer");
            }
            button_wrapper.append(glow_layer);            
            glow_layer.append(shadow_layer);
            shadow_layer.append(childElements);
            //if button has disabled class or selected class, do not bind any event handler.
            if(button_wrapper.hasClass("selected") || button_wrapper.hasClass("disabled")) {
                return;
            }
            var isPressed = false;
            button_wrapper.hover(function(event) {
                if(!isPressed) {
                    glow_layer.addClass("focused");
                }
            }, function(event){
                glow_layer.removeClass("focused");
                shadow_layer.removeClass("pressed");
            }).mousedown(function(event) {
                isPressed = true;
                shadow_layer.addClass("pressed");
            }).mouseup(function(event) {
                isPressed = false;
                shadow_layer.removeClass("pressed");
            });
            if(params.click && typeof(params.click)=="function") {
                button_wrapper.click(function(event) {
                    event.preventDefault();
                    return params.click(event);
                })
            }
        });
    };

    /*
     * Use to create paginator according the json or html list
     * 
     */
    $.fn.paginator = function(params) {
        params = $.extend({
            "totalItems": 0,
            "num_per_page": 16,
            "currentPage": 0,
            "num_display_entries": 5,
            "num_edge_entires": 1,
            "prev_page_text": "Prev",
            "next_page_text": "Next",
            "ellipsis_text": "...",
            "callback": function() { return false },
            "ajax": true,
            "container_align_center": true
         }, params || {});
        if(params.totalItems<=0) {
            return this;
        }
        function getTotalPages () {
            return Math.ceil(params.totalItems / params.num_per_page);
        }
        /**
         * Caculate start and end page num of paginatrion
         * @return {Array}
         */
        function getInterval (current_page) {
            var half = Math.ceil(params.num_display_entries / 2);
            var totalPages = getTotalPages ();
            var upper_limit = totalPages - params.num_display_entries;
            var start = current_page > half ? Math.max(Math.min(current_page - half, upper_limit), 0) : 0;
            var end = current_page > half ? Math.min(current_page + half, totalPages) : Math.min(params.num_display_entries, totalPages);
            return [start, end];
        }

        function handleClick(event, page_num, paginator) {
            if(params.ajax) {
                event.preventDefault();
            }
            // console.log(paginator);
            params.callback(page_num, paginator);
            
        }

        return this.each(function() {
            var paginator = $(this);
            
            var totalPages = getTotalPages();
            // This helper function returns a handler function that calls pageSelected with the right page_id
            var getClickHandler = function(evt, page_num) {
                return function(evt){ return handleClick(evt, page_num, paginator);}
            }
            function addPageButton(page_num, option) {
                
                page_num = page_num > 0 ? ( page_num < totalPages ? page_num : totalPages-1) : 0;
                option =  $.extend({"text": page_num + 1, "class": "page_button_wrapper"}, option || {});
                // console.log(option.text+"   "+option.class);
                //this href attribute is useless when params.ajax is true. you should handle click event in your own callback.
                var pageButton = $("<a>").addClass(option["class"]).attr("href", "#!/page/"+page_num+"/");
                pageButton.bind("click", getClickHandler(event, page_num));
                var textWrapper = $("<span>").text(option.text);
                pageButton.append(textWrapper);
                paginator.append(pageButton);
            }
            /*
             * Use to generate paginator.
             */
            function generatePaginator (current_page) {
                var width = 0;
                var interval = getInterval(current_page);
                paginator.empty();
                //Generate previous button
                if(params.prev_page_text) {
                    var option = {"text": params.prev_page_text};
                    if(current_page==0) {
                        option["class"] = "page_button_wrapper disabled";
                    }
                    addPageButton(current_page - 1, option);
                }
                //Generate first page and edge entries
                if(interval[0]>0 && params.num_edge_entires > 0){
                    var end = Math.min(interval[0], params.num_edge_entires);
                    for(var i=0;i<end;i++) {
                        addPageButton(i);
                    }
                    if(interval[0] > params.num_edge_entires && params.ellipsis_text) {
                        var ellipsisWrapper = $("<span>"+params.ellipsis_text+"</span>").addClass("page_ellipsis_wrapper");
                        ellipsisWrapper.appendTo(paginator);
                    }
                }
                //Generate interval (displayed pages) page buttons
                for(var i=interval[0]; i<interval[1]; i++) {
                    if(i==current_page) {
                        addPageButton(i, {"class": "page_button_wrapper selected"});
                    } else {
                        addPageButton(i);
                    }
                }
                //Generate last page and edge entries
                if(interval[1] < totalPages && params.num_edge_entires > 0 ) {
                    if(totalPages - params.num_edge_entires > interval[1] && params.ellipsis_text) {
                        var ellipsisWrapper = $("<span>"+params.ellipsis_text+"</span>").addClass("page_ellipsis_wrapper");
                        ellipsisWrapper.appendTo(paginator);
                    }
                    var begin = Math.max(totalPages - params.num_edge_entires, interval[1]);
                    for(var i=begin; i<totalPages; i++) {
                        addPageButton(i);
                    }
                }
                //Generate next page buton.
                if(params.next_page_text) {
                    var option = {"text": params.next_page_text};
                    if(current_page==totalPages-1) {
                        option["class"]="page_button_wrapper disabled";
                    }
                    addPageButton(current_page + 1, option);
                }
                var container_float = paginator.css("float");
                if(container_float=="none") {
                    $("<div>").css({"display": "block", "clear":"both","width": "1px"}).appendTo(paginator);
                }
            }
            var current_page = params.currentPage;
            
            //add controls to this
            paginator.goToPage = function(page_num) {
                if(typeof(page_num)=="number") {
                    generatePaginator(page_num);
                }
            }
            generatePaginator(current_page);
        });
    };

    /**
     * This plugin is use to ellipsis the text to ensure the text is not overflow the parent.
     * To make sure the plugin work properly. The element and the container should have been added
     * to the Dom tree.
     */
    $.fn.ellipsis = function(params){ 
        params = $.extend({
            "width": null,
            "num": null,
            "useContainerPadding": true,
            "useContainerMargin": true,
            "padding": 0,
            "margin": 0
        }, params || {});

        return this.each(function(){
            var copyThis = $(this.cloneNode(true)).hide().css({
                'position': 'absolute',
                'width': 'auto',
                'overflow': 'visible',
                'white-space': 'nowrap'
            }); 
            if(params.useContainerPadding){
                params.padding = $.getInt($(this).css("padding-left")) + $.getInt($(this).css("padding-right"));    
            }
            if(params.useContainerMargin) {
                params.margin = $.getInt($(this).css("margin-left")) + $.getInt($(this).css("margin-right"));
            }
            var thisText = $.trim($(this).text());
            if(params.width){
                var measuredWidth = params.width - params.padding - params.margin;
                $(this).after(copyThis);
                if(copyThis.width() > measuredWidth){
                    $(this).text(thisText.substring(0,thisText.length-4));
                    $(this).html($(this).html()+'...');
                    copyThis.remove();
                    $(this).ellipsis({"width":params.width});
                }else{
                    copyThis.remove(); 
                    return;
                }   
            } else if(params.num) {
                var maxwidth=params.num;
                
                if(thisText.length>maxwidth){
                    $(this).text(thisText.substring(0,maxwidth));
                    $(this).html($(this).html()+'...');
                }
            } else {
                var measuredWidth = $(this).width() - params.padding - params.margin;
                $(this).after(copyThis);
                if(copyThis.width()>measuredWidth){
                    $(this).text(thisText.substring(0,thisText.length-4));
                    $(this).html($(this).html()+'...');
                    copyThis.remove();
                    $(this).ellipsis();
                }else{
                    copyThis.remove(); 
                    return;
                }
            }                    
        });
    }

    /**
     * Create a grid view with vertical scrolling. This grid view has animation effect when create and remove a child.
     * You should implement an adapter and use setAdapterMethod to create a grid view.
     *
     */
    $.fn.gridList = function(params) {
        params = $.extend({
            "stretchMode": false,
            "numColumn": 4,
            "columnWidth": "250px",
            "verticalSpacing": "23px",
            "horizontalSpacing": "6px",
            "enterEffect": null,
            "eraseEffect": null,
            "loadOnScroll": true, // If set to true, the onDataLoading is invoked when scroll to the ".gridlist_load_more" element.
            "maxLoadTimes": 4, // Use to limit the auto load when scrolling. only works when loadOnScroll is true.
            "maxDelay": 800, // Define the max delay when the last child is performing its animation.
            "loadMoreIndicator": null, //An area or button in the end of the list. Can be a jQuery object or an function.
            "onLayoutComplete": null, // When layout has completed, callback function can retrieve all children element from rootView.
            "onDataLoading": null
        }, params || {});

        // When grid_load_more indicator has shown, this 
        var hasLoadMoreIndicatorShown = false;

        // Prevent layout when addViewInLayout is invoked. This is useful for adding multiple children.
        // 
        var blockLayout = false;

        $.extend(this, {
            "isLoadingData": false,
            /**
             * Add a view before or after specific position.
             * @param position, an integer value, define where should be insert to.
             * @param before, an boolean value, define if should insert before the position or after it.
             */
            "addView": function(position, before) {
                if (this.adapter) {
                    var child = this.adapter.getView(position);
                    if(child) {
                        addViewInLayout(this, position, before, child);
                        if(!blockLayout) {
                            if(params.enterEffect) {
                                params.enterEffect(child);
                            } else {
                                layoutAnimation(child);
                            }
                        }
                    }
                }
            },
            /**
             * Remove a view in specific position.
             * position, an integer value, define which view of position should be removed.
             */
            "removeView": function(position) {
                var children = this.children();
                if(children.length == 0 || position < 0 || position >= children.length) {
                    return;
                } else if(position >= 0 && position < children.length) {
                    var victim = children.eq(position);
                    victim.remove();
                    layout(this, position, children.length);    
                }
                
            },
            "detachAllViews": function() {
                var detachedChildren = this.children().detach();
                recycleBin = detachedChildren;
            },
            "attachDetachedViews": function() {
                if(this.recycleBin) {
                    this.recycleBin.appendTo(this);
                }
            },
            /**
             * Perform a sequence layout from the given startPosition.
             */
            "layoutChildren": function(startPosition) {
                if(!this.adapter) {
                    return;
                }
                // Detach the load more indicator temporarily
                var loadMoreIndicator = this.children(".gridlist_load_more").detach();

                var count = this.adapter.getCount();
                if(startPosition >= count || startPosition < 0) {
                    return;
                }
                
                blockLayout = true;

                for(var i = startPosition; i < count; i++) {
                    this.addView(i, false);
                }

                blockLayout = false;
                var children = this.children();
                var childCount = children.length;
                layout(this, startPosition, childCount - 1);

                for(var pos=startPosition; pos < childCount; pos++) {
                    var child = children.eq(pos);
                    var delay = (pos - startPosition) * (params.maxDelay / childCount);
                    if($.isFunction(params.enterEffect)) {
                        params.enterEffect(child, delay);
                    } else {
                        layoutAnimation(child, delay);
                    }
                }

                // attach the load more indicator into
                if(loadMoreIndicator.length == 0) {
                    if($.isFunction(params.loadMoreIndicator)) {
                        loadMoreIndicator = params.loadMoreIndicator(this);
                    } else if(params.loadMoreIndicator && params.loadMoreIndicator.jquery) {
                        loadMoreIndicator = params.loadMoreIndicator;
                    } else {
                        loadMoreIndicator = $("<div>").addClass("gridlist_load_more");
                    }
                }
                loadMoreIndicator.appendTo(this);
                if($.isFunction(params.onLayoutComplete)) {
                    params.onLayoutComplete(this, startPosition);
                }
            },

            "recycleBin": new Array(),

            "adapter": {
                "list": null,
                "getCount": function() {
                    return list.length;
                },
                "getItem": function(position) {
                    return list[position];
                },
                "getItemId": function(position) {
                    return 0;
                },
                "getView": function(position) {
                    return null;
                }
            },
            "setAdapter": function(listAdapter) {
                $.extend(this.adapter, listAdapter || {});
                // Remove previous binded onListScroll Handler.
                if(params.loadOnScroll) {
                    $(window).unbind("scroll", onListScroll);
                }
                if(this.adapter) {
                    this.empty();
                    this.layoutChildren(0);
                }
                if(params.loadOnScroll) {
                    
                    $(window).bind("scroll", {"rootView": this}, onListScroll);
                }
            },
            "onDataLoading": params.onDataLoading,
            "autoLoadTimes": 0,
        });

        var addViewInLayout = function(rootView, position, before, view) {
            var children = rootView.children();
            var childCount = children.length;
            if(position >= childCount && childCount > 0) {
                if(before) {
                    rootView.prepend(view);
                    childCount++;
                    layout(rootView, 0, childCount-1);
                } else {
                    rootView.append(view);
                    children++;
                    layout(rootView, childCount - 1, childCount -1);
                }
            } else if(childCount == 0 || position < 0) {
                // If there are no child yet, just insert the view. if position is less than zero, just insert to the last position.
                rootView.append(view);
                childCount++;
                layout(rootView, childCount - 1, childCount - 1);
            } else if(position >=0 && position < childCount && childCount > 0) {
                var referenceView = children.eq(position);
                if(before) {
                    referenceView.before(view);
                    childCount++;
                    layout(rootView, (position > 0) ? (position - 1) : 0, childCount - 1);
                } else {
                    referenceView.after(view);
                    childCount++;
                    layout(rootView, position + 1, childCount - 1);
                }
            }
        }
        var layout = function(rootView, startPosition, endPosition) {
            if(blockLayout) {
                return;
            }
            var children = rootView.children();
            // var maxRow = Math.floor((rootView.adapter.getCount() - 1) / params.numColumn);
            for(var pos = startPosition; pos<=endPosition; pos++) {
                // var row = Math.floor(pos / params.numColumn);
                var marginRight = params.horizontalSpacing;
                var marginBottom = params.verticalSpacing;
                // if(row == maxRow) {
                //     marginBottom = "0px";
                // }
                var rowDelta = pos % params.numColumn;
                // console.log("rowDelta:" + rowDelta);
                if(rowDelta == params.numColumn - 1) {
                    marginRight = "0px";
                }
                var child = children.eq(pos);
                child.css({
                    "margin-top": "0px",
                    "margin-right": marginRight,
                    "margin-bottom": marginBottom,
                    "margin-left": "0px"
                });
            }
        }
        

        var onListScroll = function(event) {
            var rootView = event.data.rootView;
            var loadMoreIndicator = rootView.children(".gridlist_load_more");
            if(loadMoreIndicator.length==0) {
                return false;
            }
            var bodyScrollTop = document.body.scrollTop;
            var loadMoreIndicatorOffset = loadMoreIndicator.offset();
            var diff = loadMoreIndicatorOffset.top - bodyScrollTop;
            
            if(diff < window.innerHeight && !rootView.isLoadingData && !hasLoadMoreIndicatorShown && rootView.autoLoadTimes < params.maxLoadTimes) {
                hasLoadMoreIndicatorShown = true;
                console.log("------ loadMoreIndicator is " + hasLoadMoreIndicatorShown);
                if($.isFunction(rootView.onDataLoading)) {
                    rootView.autoLoadTimes++;
                    rootView.onDataLoading();
                }
            } else if(diff >= window.innerHeight && hasLoadMoreIndicatorShown){
                hasLoadMoreIndicatorShown = false;
                console.log("------ loadMoreIndicator is " + hasLoadMoreIndicatorShown);
            }
        }

        var layoutAnimation = function(child, delay) {
            
            child.animate({
                "left": "+=15",
                "opacity": 0
            },0);
            child.delay(delay);
            child.animate({
                "left": "-=15",
                "opacity": 1
            }, 500);
        }

        return this;
    }
 })(jQuery);