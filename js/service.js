var openedTab = new Map();
var currentTab = "0";
var loadedContentTab = []

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
    $("#loading-img").remove();
    $("#loading-text").remove();
}



function switchTab(event, category, isDeafult) {
    event.preventDefault();
    if(isDeafult){
        if (!loadedContentTab.includes(category)) {
            loadedContentTab.push(category)
            currentTab = category
        }
    }
    //check if clicking same tab
    if (category != currentTab) {
        currentTab = category;
        //check if content is loaded
        if (!loadedContentTab.includes(currentTab)) {
            loadedContentTab.push(currentTab)
            //content is not load send ajax to load content
            $.ajax({
                url: "../controllers/service_controller.php",
                type: 'POST',
                data: { "function": "next_page", "current_category": category, "current_page": 1 },
                success: function (response) {
                    try {
                        var respMap = $.parseJSON(response);
                        if (respMap.status == "1") {
                            //show content 
                            var html = '<div class="container">'
                                    + '<div class="row align-items-stretch" id="content-tab-service-' + currentTab + '">';
                            let services = respMap.data
                            for (let i = 0; i < services.length; i++) {
                                let id = services[i]['service_id'];
                                let name = services[i]['service_name'];
                                let price = services[i]['service_price'];
                                let background = services[i]['image_path'].substring(3);
                                let details = services[i]['details'];
                                html = html + '<div class="col-lg-4 col-sm-12 mb-5">'
                                    + '<div class="pt-5"></div>'
                                    + '<div class="service-card" style="background-image: url(\'' + background + '\');">'
                                    + '<div class="service-card-name service-title-text ">'
                                    + name
                                    + '</div>'
                                    + '<div class="service-price pt-4 pb-4">'
                                    + price
                                    + '</div>';

                                //get detail
                                html = html + '<div class="service-card-content-wrapper">';
                                if (details != "") {
                                    for (let y = 0; y < details.length; y++) {
                                        html = html + '<div class="service-card-text-wrapper service-line-top-border">'
                                            + '<div class="flex-service-detail-row">'
                                            + '<img src="../icon/tick.png" class="left-image" style="width:25px;height:25px">'
                                            + '<div class="service-text">'
                                            +   details[y]['service_detail_value']
                                            + '</div>'
                                            + '</div>'
                                            + '</div>';

                                    }
                                }
                                html = html + '</div>';
                                html = html + '<div class="service-button-wrapper">'
                                    + ' <button onclick="location.href = \'contact_us.php?service_id=' + id + '\';" type="button" class="service-button px-4 py-1">Liên hệ </button>'
                                    + '</div>';
                                html = html + '</div></div>';

                            }
                            html = html + "</div>"                           
                            if (respMap.isHaveNextPage == true) {
                                html = html + '<div class="row pagination mb-5 mt-5" id="pagination">'
                                    + '<img id="loading-img" class="col loadmore-img" src="../icon/three-dots.svg" alt="Show more" style="display:none">'
                                    + '<div onClick="nextPage(event,\' . $active_category . \')" id="loading-text" class="col pagination-text">SHOW MORE</div>'
                                    + '</div>';
                            } else {
                                html = html + '<div class="row mb-5 mt-5"></div>';
                            }
                            html = html + "</div>"
                            $('#tab-service-' + category).append(html);

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
        } else {
            //content is loaded , do nothing 

        }
    }
}

function nextPage(event, category) {
    event.preventDefault();
    //check if this tab had been opened
    showLoading();
    var opendPage = openedTab.get(category);
    if (opendPage != undefined) {
        //get page to next one
        opendPage = opendPage + 1;

    } else {
        //send ajax to get second page
        opendPage = 2
    }
    openedTab.set(category, opendPage)
    $.ajax({
        url: "../controllers/service_controller.php",
        type: 'POST',
        data: { "function": "next_page", "current_category": category, "current_page": opendPage },
        success: function (response) {
            try {
                var respMap = $.parseJSON(response);
                if (respMap.status == "1") {
                    if (respMap.isHaveNextPage == true) {
                        hideLoading();
                    }
                    else {
                        removeLoading();
                    }
                    //show content 
                    let services = respMap.data
                    for (let i = 0; i < services.length; i++) {
                        let id = services[i]['service_id'];
                        let name = services[i]['service_name'];
                        let price = services[i]['service_price'];
                        let background = services[i]['image_path'].substring(3);
                        let details = services[i]['details'];
                        let html = '<div class="col-lg-4 col-sm-12 mb-5">'
                            + '<div class="pt-5"></div>'
                            + '<div class="service-card" style="background-image: url(\'' + background + '\');">'
                            + '<div class="service-card-name service-title-text ">'
                            + name
                            + '</div>'
                            + '<div class="service-price pt-4 pb-4">'
                            + price
                            + '</div>';

                        //get detail
                        html = html + '<div class="service-card-content-wrapper">';
                        if (details != "") {
                            for (let y = 0; y < details.length; y++) {
                                html = html + '<div class="service-card-text-wrapper service-line-top-border">'
                                            + '<div class="flex-service-detail-row">'
                                            + '<img src="../icon/tick.png" class="left-image" style="width:25px;height:25px">'
                                            + '<div class="service-text">'
                                            +   details[y]['service_detail_value']
                                            + '</div>'
                                            + '</div>'
                                            + '</div>';
                            }
                        }
                        html = html + '</div>';
                        html = html + '<div class="service-button-wrapper">'
                            + ' <button onclick="location.href = \'contact_us.php?service_id=' + id + '\';" type="button" class="service-button px-4 py-1">Liên hệ </button>'
                            + '</div>';
                        html = html + '</div></div>';
                        $('#content-tab-service-' + category).append(html);
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