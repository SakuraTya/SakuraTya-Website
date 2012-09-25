function navMenuBuilding(currentItem) {
    $("#nav_menu").lavaLamp({
        "speed": 300,
        "click": function(){

        },
        "starItem" : currentItem,
        "returnStart": function(homeElement) {
            $("#nav_menu").find("a").each(function(){
                $(this).removeClass("hot");
            });
        },
        "returnFinish": function(homeElement) {
            var homeAnchor = homeElement.children("a");
            homeAnchor.addClass("hot");
        },
        "hoverStart": function(hoverElement) {
            $("#nav_menu").find("a").each(function(){
                $(this).removeClass("hot");
            });
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
