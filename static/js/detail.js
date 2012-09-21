function layoutWorkInfo () {
    $("#project_download_button").convertToButton();
    $("#project_favorite_button").convertToButton();
    $("#work_tags_list").convertToTags();
}

$(document).ready(function(){
    layoutWorkInfo();
});