window.addEventListener("DOMContentLoaded", (event) => {
  //init ckeditor
  CKEDITOR.replace("editor1");
  CKEDITOR.replace("editor1_edit");
  CKEDITOR.config.width = "100%";
  CKEDITOR.config.height = "200px";
  //get project detail
  $('#project_id').on('change', function (e) {
    var valueSelected = this.value;
    if (valueSelected == 'Select project') {
      return false;
    }
    //get last priority 
    getLastPriority(valueSelected);
    try {
      //remove old one
      $("#table_project_detail").DataTable().destroy();
      //init table
      var t = $("#table_project_detail").DataTable({
        ajax: {
          url: "../controllers/project_controller.php?function=get_project_detail&project_id=" + valueSelected,
          dataSrc: "",
        },
        rowId: "project_detail_id",
        columns: [
          { data: null },
          {
            data: "project_detail_type",
            render: function (data, type, row, meta) {
              if (data == "0") {
                return "Text";
              } else {
                return "Image";
              }
            }

          },
          { data: "project_detail_priority" },
          {
            data: "project_detail_id",
            className: "dt-body-center",
            render: function (data, type, row, meta) {
              if (row.project_detail_type == "1") {
                return (
                  "<button id=image_" +
                  data +
                  ' class="btn btn-sm btn-outline-success btn_edit">View</button>'
                );
              } else {
                return "";
              }
            },
          },
          {
            data: "project_detail_id",
            className: "dt-body-center",
            render: function (data, type, row, meta) {
              if (row.project_detail_type == "0") {
                return (
                  "<button id=edit_" +
                  data +
                  ' class="btn btn-sm btn-outline-success btn_edit">View</button>'
                );
              } else {
                return "";
              }
            },
          },
          {
            data: "project_detail_status",
            className: "dt-body-center",
            render: function (data, type, row) {
              if (data == "1") {
                return '<span class="badge badge-success">Active</span>';
              } else if (data == "0") {
                return '<span class="badge badge-danger">Inactive</span>';
              }
            },
          },
          {
            data: "project_detail_id",
            className: "dt-body-center",
            render: function (data, type, row) {
              return (
                "<button id=delete_" +
                data +
                ' class="btn btn-sm btn-outline-danger btn_delete">Delete</button>'
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
      $('#project-detail-content-wrapper').css("display", "flex")
    } catch (error) {
      $.alert({
        title: "Error",
        type: "red",
        typeAnimated: true,
        content: "Cannot get project detail content, error: " + error,
      });
    }
  });

  //show image preview
  $("#project_detail_image").change(function () {
    //empty class casousel inner and indicator
    $(".carousel-indicators").empty();
    $(".carousel-inner").empty();
    let flag = false;
    Array.from(this.files).map(function (f) {
      {
        if (!f.type.match("image.*")) {
          {
            $.alert({
              title: "Error",
              type: "red",
              typeAnimated: true,
              content: "Please upload image only",
            });
            return;
          }
        }
        flag = true;
        var reader = new FileReader();
        reader.onload = function (e) {
          $(
            '<div class="carousel-item"><img src="' +
            e.target.result +
            '" id="c-item_' +
            f.name +
            '" width="400px" height="400px"></div>'
          ).appendTo(".carousel-inner");
          $(
            '<li data-target="#carousel_image_project_detail" data-slide-to="0"></li>'
          ).appendTo(".carousel-indicators");
          $(".carousel-item").first().addClass("active");
          $(".carousel-indicators > li").first().addClass("active");
          $(".carousel").carousel();
        };
        reader.readAsDataURL(f);
      }
      //show image preview modal
      if (flag == true) {
        //enable button preview image
        $("#btn-preview-image").removeAttr("disabled");
        $("#modal-proejct-detail-image").modal("show");
      }
    });
  });

  //get project
  $.ajax({
    type: "POST",
    url: "../controllers/project_controller.php",
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


  //start add service
  $("#btn_save").click(function () {
    var project_id = $('#project_id').val();
    if (project_id == "Select project") {
      $.alert({
        title: "Error",
        type: "red",
        typeAnimated: true,
        content: "Please choose valid project!"
      });
      return false;
    }
    //get data
    var project_detail_priority = $("#project_detail_priority").val();
    var project_detail_type = $("#project_detail_type").find(":selected").val();
    var project_detail_image = $('#project_detail_image').prop('files')[0];
    var project_detail_text = CKEDITOR.instances.editor1.getData();
    

    var project_detail_status = 0;
    if ($("#project_detail_status").is(":checked")) {
      project_detail_status = 1;
    }

    var project_detail_isSameRow = 0;
    if ($("#project_detail_isSameRow").is(":checked")) {
      project_detail_isSameRow = 1;
    }

    if (project_detail_type == "0") {
      if (project_detail_text == "") {
        $.alert({
          title: "Error",
          type: "red",
          typeAnimated: true,
          content: "Please enter text content",
        });
        return;
      }
    }

    if (project_detail_type == "1") {
      if ($('#project_detail_image').get(0).files.length === 0) {
        {
          $.alert({
            title: "Error",
            type: "red",
            typeAnimated: true,
            content: "Please choose image",
          });
          return;
        }
      }
    }

    if ((project_detail_priority == "")) {
      $.alert({
        title: "Error",
        type: "red",
        typeAnimated: true,
        content: "Please enter priority",
      });
      return;
    }

    //create form
    var formData = new FormData();
    formData.append("project_id", project_id);
    formData.append("project_detail_priority", project_detail_priority);
    formData.append("project_detail_type", project_detail_type);
    formData.append("project_detail_text", project_detail_text);
    formData.append("project_detail_image", project_detail_image);
    formData.append("project_detail_status", project_detail_status);
    formData.append("project_detail_isSameRow", project_detail_isSameRow);
    formData.append("function", "add_project_detail");

    //send data
    $.ajax({
      type: "POST",
      url: "../controllers/project_controller.php",
      data: formData,
      contentType: false,
      processData: false,
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
          //clear form
          CKEDITOR.instances.editor1.setData("")
          $("#project_detail_image").val("");
          //disable button
          $("#btn_preview_image").attr("disabled", true);
          //reload table
          $("#table_project_detail").DataTable().ajax.reload();

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
  });
  //end start add project detail
  //table event
  $("#table_project_detail").on("click", "button", function () {
    //get this row data
    var table = $("#table_project_detail").DataTable();
    var data = table.row($(this).parents("tr")).data();
    //set blog id
    $("#project_detail_id").val(data.project_detail_id);
    //get clicked button
    var id = this.id;
    //split first underscore
    var id_split = id.split("_");
    if (id_split[0] == "delete") {
      //confirm 
      $.confirm({
        title: "Alert!",
        content: "Are you sure you want delete this",
        type: "orange",
        typeAnimated: true,
        icon: "fa fa-exclamation-circle",
        closeIcon: true,
        closeIconClass: "fa fa-close",
        autoClose: "cancel|3000",
        animation: "zoom",
        closeAnimation: "zoom",
        animateFromElement: false,
        buttons: {
          confirm: function () {
            //send ajax request delete
            $.ajax({
              type: "POST",
              url: "../controllers/project_controller.php",
              data: {
                project_detail_id: data.project_detail_id,
                function: "delete_project_detail",
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
                  $("#table_project_detail").DataTable().ajax.reload();
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
          cancel: function () {
          }
        }
      });
    }
    if (id_split[0] == "edit") {
      $.ajax({
        type: "POST",
        url: "../controllers/project_controller.php",
        data: {
          project_detail_id: data.project_detail_id,
          function: "get_project_detail_text",
        },
        success: function (data) {
          try {
            data = $.parseJSON(data);
            let content = data[0].project_detail_text;
            CKEDITOR.instances.editor1_edit.setData(content);
            $("#modal-project-detail-text-edit").modal("show");
          } catch ($e) {
            $.alert({
              title: "Alert!",
              content: "Something went wrong! reason : " + $e,
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
    }
    if (id_split[0] == "image") {
      $.ajax({
        type: "POST",
        url: "../controllers/project_controller.php",
        data: {
          project_detail_id: data.project_detail_id,
          function: "get_project_detail_image",
        },
        success: function (data) {
          try {
            data = $.parseJSON(data);
            //empty class casousel inner and indicator
            $("#carousel-indicators-edit").empty();
            $("#carousel-inner-edit").empty();

            let count = 0;
            var dataTransfer = new DataTransfer();
            for (let i = 0; i < data.length; i++) {
              let image_name = data[i].image_path.split("/");
              image_name = image_name[image_name.length - 1];
              let image_extension = image_name.split(".");
              image_extension =
                "image/" + image_extension[image_extension.length - 1];
              loadURLToInputFiled(
                data[i].image_path,
                image_name,
                image_extension,
                dataTransfer
              );
              //create carousel inner
              $(
                '<div class="carousel-item image_edit"><img src="' +
                data[i].image_path +
                '" data-name ="' +
                data[i].project_detail_id +
                '" id="service_image_id_' +
                image_name +
                '" width="400px" height="400px"></div>'
              ).appendTo("#carousel-inner-edit");
              $(
                '<li data-target="#carousel_image_project_detail" class="image_edit" data-slide-to="' +
                count +
                '"></li>'
              ).appendTo("#carousel-indicators-edit");
              count++;
            }
            $(".carousel-item.image_edit").first().addClass("active");
            $("#carousel-indicators-edit > li").first().addClass("active");
            $(".carousel").carousel();
            $("#modal-project-detail-image-edit").modal("show");
          } catch ($e) {
            $.alert({
              title: "Alert!",
              content: "Something went wrong! reason : " + $e,
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
    }
  });

  $("#btn_save_text_edit").click(function () {
    var formData = new FormData();
    var project_detail_id = $("#project_detail_id").val();
    var data = CKEDITOR.instances.editor1_edit.getData();
    
    formData.append("project_detail_id", project_detail_id);
    formData.append("project_detail_text", data);
    formData.append("function", "save_project_detail_text_edit");
    $.ajax({
      url: "../controllers/project_controller.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
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
          $("#modal-project-detail-text-edit").modal("hide");
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
        } else {
          //clear form
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
  });

  $("#btn_save_image_edit").click(function () {
    var formData = new FormData();
    var project_detail_id = $("#project_detail_id").val();
    var project_detail_image = $('#image_edit').prop('files')[0];

    formData.append("project_detail_id", project_detail_id);
    formData.append("project_detail_image", project_detail_image);
    formData.append("function", "save_image_detail_edit");
    $.ajax({
      url: "../controllers/project_controller.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (data) {
        $("#image_edit").val(null);
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
          $("#modal-project-detail-image-edit").modal("hide");
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
        } else {
          //clear form
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
  });

  function loadURLToInputFiled(url, name, ext, dataTransfer) {
    getImgURL(url, (imgBlob) => {
      // Load img blob to input
      // WIP: UTF8 character error
      let fileName = name;
      var file = new File(
        [imgBlob],
        fileName,
        { type: ext, lastModified: new Date().getTime() },
        "utf-8"
      );
      dataTransfer.items.add(file);
      document.querySelector("#image_edit").files = dataTransfer.files;
    });
  }

  // xmlHTTP return blob respond
  function getImgURL(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.onload = function () {
      callback(xhr.response);
    };
    xhr.open("GET", url);
    xhr.responseType = "blob";
    xhr.send();
  }

  function getFiles(input) {
    const files = new Array(input.files.length);
    for (let i = 0; i < input.files.length; i++) files[i] = input.files.item(i);
    return files;
  }

  function setFiles(input, files) {
    const dataTransfer = new DataTransfer();
    for (const file of files) dataTransfer.items.add(file);
    input.files = dataTransfer.files;
  }

  //add edit image
  $("#upload_image_edit").change(function () {
    //get file name and replace label
    if (!this.files[0].type.match("image.*")) {
      {
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
        $("#project_detail_image_edit").val("");
        return;
      }
    }

    var old_name = $("#carousel-inner-edit .active img").attr("id");
    old_name = old_name.split("_")[3];
    var new_image = this.files[0];
    var reader = new FileReader();
    reader.onload = function (e) {
      $("#carousel-inner-edit .active img").attr("src", e.target.result);
      //chaneg id image
      $("#carousel-inner-edit .active img").attr(
        "id",
        "project_detail_image_id_" + new_image.name
      );
      //change input image
    };
    var input_image = $("#image_edit");
    var input_edit_image = $("#upload_image_edit");
    const files_image = getFiles(input_image[0]);
    const files_edit_image = getFiles(input_edit_image[0]);
    //get index of file name
    const index = files_image.findIndex((file) => file.name === old_name);
    //get index of image
    //remove image from input
    files_image.splice(index, 1);
    //Add new image to input
    files_image.push(files_edit_image[0]);
    //change input image
    input_image = setFiles(input_image[0], files_image);
    $(".carousel").carousel();
    reader.readAsDataURL(this.files[0]);
  });

  function getLastPriority(project_id) {
    $.ajax({
      type: "POST",
      url: "../controllers/project_controller.php",
      data: {
        function: "get_last_project_detail_priority",
        project_id: project_id
      },
      success: function (data) {
        $('#project_detail_priority').val(data);
      },
    });
  }

});

