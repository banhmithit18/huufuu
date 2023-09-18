window.addEventListener("DOMContentLoaded", (event) => {
  //init ckeditor
  CKEDITOR.replace('editor');
  CKEDITOR.config.width = '100%';
  CKEDITOR.config.height = '500px';
  $PATH = '../../img/project_detail/';

  //get project detail
  $('select').on('change', function (e) {
    var valueSelected = this.value;
    if (valueSelected == 0){
      return false;
    }
    $.ajax({
      url: "../admin/controllers/project_controller.php",
      type: "POST",
      data: {
        function: "get_project_datail",
        project_id: valueSelected
      },
      success: function (data) {    
        //show content in ckeditor
        try {
          var content = $.parseJSON(data);
          if (content == '""'){
            content = "";
          }
          CKEDITOR.instances.editor.setData(content);
          $('#editor-content').css("display", "block")
        } catch (error) {
          $.alert({
            title: "Error",
            type: "red",
            typeAnimated: true,
            content: "Cannot get project detail content, error: " + error,
          });
        }
      },
      error: function (data) {
        alert("error");
      },
    });
  });

  //get project
  $.ajax({
    type: "POST",
    url: "../admin/controllers/project_controller.php",
    data: {
      function: "get_list_project",
    },
    success: function (data) {
      try {
        data = $.parseJSON(data);
        //add project to select
        $.each(data, function (index, value) {
          //check if status = 1 (active)
          if (value.project_status == 1) {
            $("#project_id").append(
              '<option value="' +
              value.project_id +
              '">' +
              value.project_name +
              "</option>"
            );
          }
        });
      } catch (error) {
        $.alert({
          title: "Error",
          type: "red",
          typeAnimated: true,
          content: "Cannot get project, error: " + error,
        });
      }
    },
  });


  //event button click
  $("#btn_save").click(function () {
    //get project selected 
    var project_id = $('#project_id').val();
    if (project_id == "Select project"){
      $.alert({
        title: "Error",
        type: "red",
        typeAnimated: true,
        content: "Please choose valid project!"
      });
      return false;
    }
    //get content ckeditor
    var content = encodeURIComponent(CKEDITOR.instances.editor.getData());
    //send ajax request
    $.ajax({
      url: "../admin/controllers/project_controller.php",
      type: "POST",
      dataType: 'text',
      data: {
        function: "update_project_detail",
        project_id: project_id,
        content: content
      },
      success: function (data) {
        console.log(data)
        var data = $.parseJSON(data);
        if (data.status == "1") {
          CKEDITOR.instances.editor.setData('');
          $('#editor-content').css("display", "none")
          var alert = '<div class="alert alert-success" role="alert">'
            + data.response
            + '</div>'
          //add alert to div
          $("#return_message").prepend(alert);
          //hide alert after 10s
          setTimeout(function () {
            $("#return_message").html("");
          }, 5000);

        } else {
          var alert = '<div class="alert alert-danger" role="alert">'
            + data.response
            + '</div>'
          console.log(data.error);
          //add alert to div
          $("#return_message").prepend(alert);
          //hide alert after 10s
          setTimeout(function () {
            $("#return_message").html("");
          }, 5000);
        }
      },
    });
  });
});
