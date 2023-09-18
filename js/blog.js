
var currentPage = 1

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

function nextPage(event) {
    event.preventDefault();
    //check if this tab had been opened
    showLoading();
    currentPage = currentPage +1;
    $.ajax({
        url: "../controllers/blog_controller.php",
        type: 'POST',
        data: { "function": "next_page", "current_page": currentPage },
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
                    let blogs = respMap.data
                    for (let i = 0; i < blogs.length; i++) {
                        let blogTitle = blogs[i]['blog_title'];
                        let blogId = blogs[i]['blog_id'];
                        let background = (blogs[i]['image_path']).substring(3);
                        let blogCreateDate = blogs[i]['blog_create_date'];
                        let blogContent = blogs[i][0]['blog_content'];
                        //change format date
                        let date = new Date(blogCreateDate);
                        let options = { day: '2-digit', month: 'short', year: 'numeric' };
                        let blogCreateDateFormatted =  date.toLocaleDateString('en-US', options);
                        let html = '<div class="col-xl-4 col-lg-6 col-md-12 blog-card-wrapper">'
                             +       '<div class="blog-card">'
                             +           '<div class="blog-background"></div>'
                             +           '<div class="blog-thumbnail" style="background-image:url(\''+background+'\')"></div>'
                             +           '<div class="blog-card-info">'
                             +               '<a class="blog-title blog-text blog-text-title" href="blog-detail?id="'+blogId+'">'
                             +                   blogTitle
                             +               '</a>'
                             +               '<div class="blog-time blog-text blog-text-time">'
                             +                   blogCreateDateFormatted
                             +               '</div>'
                             +               '<div class="blog-content blog-text">'       
                             +                   blogContent                   
                             +               '</div>'
                             +           '</div>'
                             +       '</div>'
                             +   '</div>';
                        $('#blog-content-wrapper').append(html)
                        
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