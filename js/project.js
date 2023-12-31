var currentPage = 1;
//loading event
function showLoading() {
    $("#loading-text").css("visibility", "hidden");
    $("#loading-img").show();
}

function hideLoading() {
    $("#loading-img").hide();
    $("#loading-text").css("visibility", "visible");
}

function removeLoading() {
    ;
    $("#loading-img").remove();
    $("#loading-text").remove();
}

function nextPage(event) {
    event.preventDefault();
    //check if this tab had been opened
    showLoading();
    if (currentPage != 1) {
        //get page to next one
        currentPage = currentPage + 1;

    } else {
        //send ajax to get second page
        currentPage = 2
    }
    $.ajax({
        url: "../controllers/project_controller.php",
        type: 'POST',
        data: { "function": "next_page", "current_page": currentPage },
        success: function (response) {
            try {
                var respMap = $.parseJSON(response);
                var projects = respMap.data;
                if (respMap.status == "1") {                   
                    if (respMap.isHaveNextPage == true) {
                        hideLoading();
                    }
                    else {
                        removeLoading();
                    }
                    //show content 
                    if(projects != null && projects != ""){
                        for (let i = 0 ; i < projects.length ; i++){
                            projectName = projects[i]['project_name'];
                            projectContent = projects[i]['project_content'];
                            imagePath = (projects[i]['image_path']).substring(3);
                            backgroundImagePath = (projects[i]['background_image_path']).substring(3);
                           
                        }
                    }
                }
            } catch (e) {
                removeLoading();
                $.alert({
                    title: "Error!",
                    content: "Something went wrong! Reason: " + e,
                    type: "red",
                    typeAnimated: true,
                    icon: "fa fa-times-circle",
                    closeIcon: true,
                    closeIconClass: "fa fa-close",
                    autoClose: "ok|3000",
                    animation: "zoom",
                    closeAnimation: "zoom",
                    animateFromElement: false,
                    buttons: {
                        ok: {
                            text: "OK",
                            btnClass: "btn-red",
                        },
                    },
                });
            }
        }
    })

}