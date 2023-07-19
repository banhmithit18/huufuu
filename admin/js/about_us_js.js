window.addEventListener("DOMContentLoaded", (event) => {
  //init ckeditor
  CKEDITOR.replace('editor');
  CKEDITOR.config.width = '100%';
  CKEDITOR.config.height = '500px'; 

  //event button click
  $("#btn_save").click(function () {
    //get content ckeditor
    var content = encodeURIComponent(CKEDITOR.instances.editor.getData());
    //send ajax request
    $.ajax({
      url: "../controllers/about_us_controller.php",
      type: "POST",
      dataType: 'text',
      data: {
        function: "update_about_us",
        content: content,
      },
      success: function (data) {
        var data = $.parseJSON(data);
        console.log(data);
        if (data.status == "1") {
            var alert = '<div class="alert alert-success" role="alert">'
            +data.response 
            +'</div>'
            //add alert to div
            $("#return_message").prepend(alert);
            //hide alert after 10s
            setTimeout(function () {
                $("#return_message").html("");
            }   , 5000);
            
        } else {
            var alert = '<div class="alert alert-danger" role="alert">'
            +data.response
            +'</div>'
            console.log(data.error);
            //add alert to div
            $("#return_message").prepend(alert);
            //hide alert after 10s
            setTimeout(function () {
                $("#return_message").html("");
            }   , 5000);
        }
      },
    });
  });

  //send ajax request to get content
  $.ajax({
    url: "../controllers/about_us_controller.php",
    type: "POST",
    data: {
      function: "get_about_us",
    },
    success: function (data) {
      //show content in ckeditor
      var content = $.parseJSON(data);
      CKEDITOR.instances.editor.setData(content);
    },
    error: function (data) {
      alert("error");
    },
  });
});
