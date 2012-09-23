function layoutWorkInfo () {
    $("#project_download_button").convertToButton();
    $("#project_favorite_button").convertToButton();
    $("#work_tags_list").convertToTags();
}

function layoutUserCPL () {
    var userSignature= $("user_signature");
    $("user_signature_wrapper").userSignature.Height();
}

$(document).ready(function(){
    layoutWorkInfo();
});