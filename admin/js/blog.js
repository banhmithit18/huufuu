window.addEventListener("DOMContentLoaded", (event) => {
  //init ckeditor
  CKEDITOR.replace("editor");
  CKEDITOR.replace("editor_upload_view");
  CKEDITOR.config.width = "100%";
  CKEDITOR.config.height = "300px";
  //init table
  var t = $("#table_blog").DataTable({
    ajax: {
      url: "../controllers/blog_controller.php?function=get_blog",
      dataSrc: "",
    },
    rowId: "blog_id",
    columns: [
      { data: null },
      { data: "blog_title" },
      { data: "blog_priority" },
      {
        data: "image_path",
        className: "dt-body-center",
        render: function (data, type, row, meta) {
          return (
            "<button id=image_" +
            data +
            ' class="btn btn-sm btn-outline-success btn_edit" data-toggle="modal" data-target="#modal-blog-view">View</button>'
          );
        },
      },
      {
        data: "blog_content_path",
        className: "dt-body-center",
        render: function (data, type, row, meta) {
          return (
            "<button id=content_" +
            data +
            ' class="btn btn-sm btn-outline-success btn_edit" data-toggle="modal" data-target="#modal-blog-content">View</button>'
          );
        },
      },
      {
        data: "blog_status",
        className: "dt-body-center",
        render: function (data, type, row) {
          if (data == "1") {
            return '<span class="badge badge-success">Active</span>';
          } else if (data == "0") {
            return '<span class="badge badge-danger">Inactive</span>';
          }
        },
      },
      { data: "blog_create_date",render:function(data,type,row){
          let dateParts = data.split(' ');
          let date = dateParts[0].split('-');
          let time = dateParts[1];
          return `${date[2]}-${date[1]}-${date[0]} ${time}`;       
        } 
      },
      {
        data: "blog_id",
        className: "dt-body-center",
        render: function (data, type, row) {
          return (
            "<button id=edit_" +
            data +
            ' class="btn btn-sm btn-outline-success btn_edit" data-toggle="modal" data-target="#modal-blog">Edit</button>'
          );
        },
      },
    ],
    columnDefs: [
      {
        searchable: false,
        orderable: false,
        targets: 0,
      },
    ],

    order: [[1, "asc"]],
    ordering: false,
  });
  t.on("order.dt search.dt", function () {
    let i = 1;
    t.column(0, { search: "applied", order: "applied" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1;
        t.cell(cell).invalidate("dom");
      });
  }).draw();

  //save edit
  $("#btn_save_edit").click(function () {
    //add class validate
    $("#form_edit_blog").addClass("was-validated");
    var blog_id = $("#blog_id").val();
    var blog_title = $("#edit_blog_title").val();
    var blog_priority = $("#edit_blog_priority").val();
    var blog_status = 0;
    if ($("#edit_blog_status").is(":checked")) {
      blog_status = 1;
    } else {
      blog_status = 0;
    }
    if (blog_title == "" || blog_priority == "") {
      $.alert({
        title: "Alert!",
        content: "Please fill all fields!",
        type: "red",
        typeAnimated: true,
        buttons: {
          tryAgain: {
            text: "Ok",
            btnClass: "btn-red",
            action: function () {},
          },
        },
      });
      return;
    }

    //send ajax
    $.ajax({
      url: "../controllers/blog_controller.php",
      type: "POST",
      data: {
        blog_id: blog_id,
        blog_title: blog_title,
        blog_priority: blog_priority,
        blog_status: blog_status,
        function: "edit_blog",
      },
      success: function (data) {
        try {
          data = JSON.parse(data);
        } catch (e) {
          $.alert({
            title: "Alert!",
            content: "Something went wrong ! reason : " + e,
            type: "red",
            typeAnimated: true,
            icon: "fa fa-exclamation-circle",
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
          return;
        }
        if (data.status == "1") {
          //close modal
          $("#modal-blog").modal("hide");
          //reload table
          t.ajax.reload();
          //remove class validate
          $("#form_blog_edit").removeClass("was-validated");

          $.alert({
            title: "Success!",
            content: data.response,
            type: "green",
            typeAnimated: true,
            icon: "fa fa-check-circle",
            closeIcon: true,
            closeIconClass: "fa fa-close",
            autoClose: "ok|3000",
            animation: "zoom",
            closeAnimation: "zoom",
            animateFromElement: false,
            buttons: {
              ok: {
                text: "OK",
                btnClass: "btn-green",
              },
            },
          });
          $("#modal-upload-editor").modal("hide");
          t.ajax.reload();
        } else {
          $.alert({
            title: "Alert!",
            content: data.response,
            type: "red",
            typeAnimated: true,
            icon: "fa fa-exclamation-circle",
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
      },
    });
  });

  //save blog content edit
  $("#btn_update_content").click(function () {
    //get CKEDITOR content
    var blog_id = $("#blog_id").val();
    var content = CKEDITOR.instances.editor_upload_view.getData();
    var content_path = $("#content_id").val();
    $.ajax({
      url: "../controllers/blog_controller.php",
      type: "POST",
      data: {
        content_path: content_path,
        blog_id: blog_id,
        content: encodeURIComponent(content),
        function: "update_content",
      },
      success: function (data) {
        try {
          data = $.parseJSON(data);
        } catch (e) {
          $.alert({
            title: "Alert!",
            content: "Something went wrong ! reason : " + e,
            type: "red",
            typeAnimated: true,
            icon: "fa fa-exclamation-circle",
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
          return;
        }
        if (data.status == "1") {
          $.alert({
            title: "Success!",
            content: data.response,
            type: "green",
            typeAnimated: true,
            icon: "fa fa-check-circle",
            closeIcon: true,
            closeIconClass: "fa fa-close",
            autoClose: "ok|3000",
            animation: "zoom",
            closeAnimation: "zoom",
            animateFromElement: false,
            buttons: {
              ok: {
                text: "OK",
                btnClass: "btn-green",
              },
            },
          });
          $("#modal-upload-editor").modal("hide");
          t.ajax.reload();
        } else {
          $.alert({
            title: "Alert!",
            content: data.response,
            type: "red",
            typeAnimated: true,
            icon: "fa fa-exclamation-circle",
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
      },
    });
  });

  //save image edit
  $("#btn_update_image").click(function () {
    var blog_image = $("#blog_image_edit")[0].files[0];
    var image_id = $("#image_id").val();
    var form_data = new FormData();
    form_data.append("image", blog_image);
    form_data.append("image_id", image_id);
    form_data.append("function", "update_image");
    $.ajax({
      url: "../controllers/blog_controller.php",
      type: "POST",
      data: form_data,
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        try {
          data = $.parseJSON(data);
        } catch (e) {
          $.alert({
            title: "Alert!",
            content: "Something went wrong ! reason : " + e,
            type: "red",
            typeAnimated: true,
            icon: "fa fa-exclamation-circle",
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
          return;
        }
        if (data.status == "1") {
          $.alert({
            title: "Success!",
            content: data.response,
            type: "green",
            typeAnimated: true,
            icon: "fa fa-check-circle",
            closeIcon: true,
            closeIconClass: "fa fa-close",
            autoClose: "ok|3000",
            animation: "zoom",
            closeAnimation: "zoom",
            animateFromElement: false,
            buttons: {
              ok: {
                text: "OK",
                btnClass: "btn-green",
              },
            },
          });
          $("#modal-upload-image").modal("hide");
          t.ajax.reload();
        } else {
          $.alert({
            title: "Alert!",
            content: data.response,
            type: "red",
            typeAnimated: true,
            icon: "fa fa-exclamation-circle",
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
      },
    });
  });

  //import image to modal show image after browse
  $("#blog_image_edit").change(function () {
    //get file name and replace label
    var fileName = $(this).val().replace(/\\/g, "/").replace(/.*\//, "");
    //check if extension is valid
    var fileExt = fileName.split(".").pop();
    if (fileExt == "jpg" || fileExt == "png" || fileExt == "jpeg") {
    } else {
      //alert form invalid
      $.alert({
        title: "Invalid file type",
        content: "Please select a valid image file",
        type: "red",
        typeAnimated: true,
        closeIcon: true,
        closeIconClass: "fa fa-close",
        closeBtnClass: "btn-danger",
        closeBtn: "Close",
        buttons: {
          close: {
            text: "Close",
            btnClass: "btn-danger",
          },
        },
      });
      //reset file input
      $("#blog_image_edit").val("");
      return;
    }
    //open imgae in modal
    var reader = new FileReader();
    reader.onload = function (e) {
      $("#image_upload_view").attr("src", e.target.result);
    };
    reader.readAsDataURL(this.files[0]);
  });

  $("#table_blog").on("click", "button", function () {
    //get this row data
    var table = $("#table_blog").DataTable();
    var data = table.row($(this).parents("tr")).data();
    //set blog id
    $("#blog_id").val(data.blog_id);
    //get clicked button
    var id = this.id;
    //split first underscore
    var id_split = id.split("_");
    if (id_split[0] == "image") {
      //show button
      $("#btn_update_image").show();
      $("#blog_image_edit_label").show();
      //set image id
      $("#image_id").val(data.image_id);
      //open image modal
      $("modal-upload-image").modal("show");
      //set image src

      $("#image_upload_view").attr("src", data.image_path);
      //show modal
      $("#modal-upload-image").modal("show");
    }
    if (id_split[0] == "content") {
      $("#content_id").val(data.blog_content_path);
      //get content
      $.ajax({
        url: "../controllers/blog_controller.php",
        type: "POST",
        data: {
          function: "get_content_blog",
          content_path: data.blog_content_path,
        },
        success: function (data) {
          //set content to ckeditor
          try {
            data = $.parseJSON(data);
          } catch (e) {}
          CKEDITOR.instances.editor_upload_view.setData(data);
          //show modal
          $("#modal-upload-editor").modal("show");
        },
      });
    }
    if (id_split[0] == "edit") {
      $("#blog_id").val(data.blog_id);
      $("#edit_blog_title").val(data.blog_title);
      $("#edit_blog_priority").val(data.blog_priority);
      if (data.blog_status == "0") {
        $("#edit_blog_status").prop("checked", false);
      } else {
        $("#edit_blog_status").prop("checked", true);
      }
      $("#modal-blog").modal("show");
    }
  });

  $("#blog_image").change(function () {
    //get file name
    var file = $("#blog_image")[0].files[0];
    if (file.name != "" || file.name != null) {
      $("#label_image").text(file.name);
    }
  });
  //delete
  $("#btn_delete").click(function () {
    var blog_id = $("#blog_id").val();
    $.confirm({
      title: "Confirm!",
      content: "Are you sure to delete this blog?",
      type: "orange",
      typeAnimated: true,
      buttons: {
        confirm: function () {
          $.ajax({
            type: "POST",
            url: "../controllers/blog_controller.php",
            data: {
              blog_id: blog_id,
              function: "delete_blog",
            },
            success: function (data) {
              try {
                data = JSON.parse(data);
              } catch (e) {
                $.alert({
                  title: "Alert!",
                  content: "Something went wrong! reason : " + e,
                  type: "red",
                  typeAnimated: true,
                  icon: "fa fa-exclamation-circle",
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
              if (data.status == "1") {
                $("#modal-blog").modal("hide");
                $.alert({
                  title: "Success!",
                  content: data.response,
                  type: "green",
                  typeAnimated: true,
                  icon: "fa fa-check-circle",
                  closeIcon: true,
                  closeIconClass: "fa fa-close",
                  autoClose: "ok|3000",
                  animation: "zoom",
                  closeAnimation: "zoom",
                  animateFromElement: false,
                  buttons: {
                    ok: {
                      text: "OK",
                      btnClass: "btn-green",
                    },
                  },
                });
                var table = $("#table_blog").DataTable();
                table.ajax.reload();
              } else {
                $.alert({
                  title: "Error!",
                  content: data.error,
                  type: "red",
                  typeAnimated: true,
                  icon: "fa fa-exclamation-circle",
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
            },
          });
        },
        cancel: function () {},
      },
    });
  });
  //save
  $("#btn_save").click(function () {
    //add class validate
    $("#form_blog").addClass("was-validated");
    var blog_content = CKEDITOR.instances.editor.getData();
    var blog_title = $("#blog_title").val();
    var blog_priority = $("#blog_priority").val();
    var blog_status = 0;
    if ($("#blog_status").is(":checked")) {
      blog_status = 1;
    }

    //get image file
    var blog_image = $("#blog_image")[0].files[0];

    if (
      blog_content == "" ||
      blog_content == null ||
      blog_title == "" ||
      blog_priority == "" ||
      blog_image == null
    ) {
      $.alert({
        title: "Alert!",
        content:
          "Blog content, title, priority, thumb image should not be empty!",
        type: "red",
        typeAnimated: true,
        icon: "fa fa-exclamation-circle",
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
            action: function () {
              $("#blog_content").focus();
            },
          },
        },
      });
      return;
    }
    //send ajax request
    var data = new FormData();
    data.append("function", "add_blog");
    data.append("blog_content", encodeURIComponent(blog_content));
    data.append("blog_title", blog_title);
    data.append("blog_priority", blog_priority);
    data.append("blog_image", blog_image);
    data.append("blog_status", blog_status);
    $.ajax({
      type: "POST",
      processData: false,
      contentType: false,
      url: "../controllers/blog_controller.php",
      data: data,
      success: function (data) {
        try {
          data = JSON.parse(data);
        } catch (e) {
          $.alert({
            title: "Alert!",
            content: "Something went wrong! reason : " + e,
            type: "red",
            typeAnimated: true,
            icon: "fa fa-exclamation-circle",
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
        if (data.status == "1") {
          //alert
          $.alert({
            title: "Success!",
            content: data.response,
            type: "green",
            typeAnimated: true,
            icon: "fa fa-check-circle",
            closeIcon: true,
            closeIconClass: "fa fa-close",
            autoClose: "ok|3000",
            animation: "zoom",
            closeAnimation: "zoom",
            animateFromElement: false,
            buttons: {
              ok: {
                text: "OK",
                btnClass: "btn-green",
              },
            },
          });
          //remove class validate
          $("#form_blog").removeClass("was-validated");
          //clear form
          $("#blog_title").val("");
          $("#blog_priority").val(1);
          $("#label_image").text("Upload blog's thumb image");
          $("#blog_image").val("");
          //set ckeditor content to empty
          CKEDITOR.instances.editor.setData("");
          //reset table
          var table = $("#table_blog").DataTable();
          table.ajax.reload();
        } else {
          $.alert({
            title: "Error!",
            content: data.error,
            type: "red",
            typeAnimated: true,
            icon: "fa fa-exclamation-circle",
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
          $("#form_blog").removeClass("was-validated");
          //clear form
          $("#blog_title").val("");
          $("#blog_priority").val(1);
          $("#label_image").text("Upload blog's thumb image");
          $("#blog_image").val("");
          //renname label image
          $("#label_image").text("Choose Image");
          //set ckeditor content to empty
          CKEDITOR.instances.editor.setData("");
        }
      },
    });
  });
});
