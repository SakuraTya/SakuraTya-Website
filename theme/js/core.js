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

function buildList(argument) {
    
    var listAdapter = {
        "list": new Array(),
        "getCount": function() {return list.length;},
        "getView": function() {

        }
    };

    var gridList = $(".work_panel_wrapper").gridList();

    gridList.setAdapter(listAdapter);

}