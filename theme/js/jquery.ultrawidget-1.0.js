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
    var getInt = function (pxValue) {
        var pattern = /\d+/g;
        return parseInt(pxValue.match(pattern)[0]);
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
        params.width = params.width ? getInt(new String(params.width)) : this.width();
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
            var paddingLeft = getInt(dropDownUL.css("padding-left"));
            var paddingRight = getInt(dropDownUL.css("padding-right"));
            var paddingTop = getInt(dropDownUL.css("padding-top"));
            var paddingBottom = getInt(dropDownUL.css("padding-bottom"));
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
            var paddingLeft = getInt(dropDownUL.css("padding-left"));
            var paddingRight = getInt(dropDownUL.css("padding-right"));
            var paddingTop = getInt(dropDownUL.css("padding-top"));
            var paddingBottom = getInt(dropDownUL.css("padding-bottom"));
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
        var holder = this;
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

    $.fn.convertToButton = function(params) {
        params = $.extend({
            "width": null,
            "height" : null,
            "click": function() { return false; }
        },params || {});
        return this.each(function() {
            var button_wrapper = $(this);
            if( !params.width ) {
                params.width = button_wrapper.width();
            }
            if( !params.height) {
                params.height = button_wrapper.height();
            }
            var childElements = button_wrapper.children().detach();
            var glow_layer = $("<div>").addClass("button_glow_layer");
            glow_layer.css({
                "width": params.width,
                "height": params.height
            });
            button_wrapper.append(glow_layer);
            var shadow_layer = $("<div>").addClass("button_shadow_layer");
            shadow_layer.css({
                "width": params.width,
                "height": params.height
            });
            glow_layer.append(shadow_layer);
            shadow_layer.append(childElements);

            var isPressed = false;
            button_wrapper.hover(function(event) {
                if(!isPressed) {
                    glow_layer.addClass("focused");
                }
            }, function(event){
                glow_layer.removeClass("focused");
                shadow_layer.removeClass("pressed");
            }).click(function(event) {
                event.preventDefault();
                return params.click(event);
            }).mousedown(function(event) {
                isPressed = true;
                shadow_layer.addClass("pressed");
            }).mouseup(function(event) {
                isPressed = false;
                shadow_layer.removeClass("pressed");
            });
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
            "currentPage:": 0,
            "num_display_entries": 5,
            "num_edge_entires": 1,
            "prev_page_text": "Prev",
            "next_page_text": "Next",
            "ellipsis_text": "...",
            "ajax":true
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
        function getInterval () {
            var half = Math.ceil(params.num_display_entries / 2);
            var totalPages = getTotalPages ();
            var upper_limit = totalPages - params.num_display_entries;
            var start = params.currentPage > half ? Math.max(Math.min(params.currentPage - half, upper_limit), 0) : 0;
            var end = params.currentPage > half ? Math.min(params.currentPage + half, params.totalPages) : Math.min(params.num_display_entries, totalPages);
            return [start, end];
        }

        return this.each(function() {
            var paginator = $(this);
            var interval = getInterval();
            function addPageButton(page_num, option) {
                var totalPages = getTotalPages();
                page_num = page_num > 0 ? ( page_num < totalPages ? page_num : totalPages-1) : 0;
                option =  $.extend({"text": page_num + 1, "class": "page_button_wrapper"});
                //this href attribute is useless when params.ajax is true. you should handle click event in your own callback.
                var pageButton = $("<a>").text(option.text).addClass(option.class).pageButton.attr("href", "#!/page/"+page_num+"/");
                
                paginator.append(pageButton);
            }

            function generatePaginator () {
                //Generate previous button
                if(params.prev_page_text) {
                    var option = {"text": params.prev_page_text};
                    if(params.currentPage==0) {
                        option.class = "page_button_wrapper disabled";
                    }
                    addPageButton(params.currentPage - 1, option);
                }
                //Generate first page and edge entries
                if(interval[0]>0 && params.num_edge_entires > 0){
                    var end = Math.min(interval[0], params.num_edge_entires);
                    for(var i=0;i<end;i++) {
                        addPageButton(i);
                    }
                    if(interval < params.num_edge_entires && params.ellipsis_text) {
                        $("<span>"+params.ellipsis_text+"</span>").appendTo(paginator);
                    }
                }
            }

            

        });
    };

    /**
     * 
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

        this.each(function(){
            var copyThis = $(this.cloneNode(true)).hide().css({
                'position': 'absolute',
                'width': 'auto',
                'overflow': 'visible'
            }); 
            if(params.useContainerPadding){
                params.padding = getInt($(this).css("padding-left")) + getInt($(this).css("padding-right"));    
            }
            if(params.useContainerMargin) {
                params.margin = getInt($(this).css("margin-left")) + getInt($(this).css("margin-right"));
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
            }else if(params.num) {
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
 })(jQuery);