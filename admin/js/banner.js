window.addEventListener("DOMContentLoaded", (event) => {

    //init table
    var t = $("#table_banner").DataTable({
      ajax: {
        url: "../admin/controllers/banner_controller.php?function=get_banner",
        dataSrc: "",
      },
      rowId: "banner_id",
      columns: [
        { data: null },
        { data: "banner_title" },
        { data: "banner_type", render: function(data, type, row, meta){
            if(data == "1")
            {
                return "Banner";
            }
            else
            {
                return "Quote";
            }
        } },
        { data: "banner_priority" },
        {
          data: "image_path",
          className: "dt-body-center",
          render: function (data, type, row, meta) {
            return (
              "<button id=image_" +
              data +
              ' class="btn btn-sm btn-outline-success btn_edit" data-toggle="modal" data-target="#modal-banner-view">View</button>'
            );
          },
        },
        {
          data: "banner_status",
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
          data: "banner_id",
          className: "dt-body-center",
          render: function (data, type, row) {
            return (
              "<button id=edit_" +
              data +
              ' class="btn btn-sm btn-outline-success btn_edit" data-toggle="modal" data-target="#modal-banner">Edit</button>'
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
  
    $('#banner_image').change(function(){
        //get file name
        var file = $("#banner_image")[0].files[0];
        if (file.name != '' || file.name != null)
        {
          $("#label_image").text(file.name)
        }
      })

    //save edit
    $("#btn_save_edit").click(function () {
      //add class validate
      $("#form_edit_banner").addClass("was-validated");
      var banner_id = $("#banner_id").val();
      var banner_title = $("#edit_banner_title").val();
      var banner_link = $("#edit_banner_link").val();
      var banner_type = $("#edit_banner_type").find(":selected").val();
      var banner_priority = $("#edit_banner_priority").val();
      var banner_content = $('#edit_banner_content').val();
      var banner_status = 0;
      if ($("#edit_banner_status").is(":checked")) {
        banner_status = 1;
      } else {
        banner_status = 0;
      }
      if (banner_title == "" || banner_priority == "") {
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
        url: "../admin/controllers/banner_controller.php",
        type: "POST",
        data: {
          banner_id: banner_id,
          banner_title: banner_title,
          banner_priority: banner_priority,
          banner_type: banner_type,
          banner_content: banner_content,
          banner_link: banner_link,
          banner_status: banner_status,
          function: "edit_banner",
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
            $("#modal-banner").modal("hide");
            //reload table
            t.ajax.reload();
            //remove class validate
            $("#form_banner_edit").removeClass("was-validated");
  
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
   //delete
  $("#btn_delete").click(function () {
    var banner_id = $("#banner_id").val();
    $.confirm({
      title: "Confirm!",
      content: "Are you sure to delete this banner?",
      type: "orange",
      typeAnimated: true,
      buttons: {
        confirm: function () {
          $.ajax({
            type: "POST",
            url: "../admin/controllers/banner_controller.php",
            data: {
              banner_id: banner_id,
              function: "delete_banner",
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
                $("#modal-banner").modal("hide");
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
                var table = $("#table_banner").DataTable();
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
    //save image edit
    $("#btn_update_image").click(function () {
      var banner_image = $("#banner_image_edit")[0].files[0];
      var image_id = $("#image_id").val();
      var form_data = new FormData();
      form_data.append("image", banner_image);
      form_data.append("image_id", image_id);
      form_data.append("function", "update_image");
      $.ajax({
        url: "../admin/controllers/banner_controller.php",
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
    $("#banner_image_edit").change(function () {
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
        $("#banner_image_edit").val("");
        return;
      }
      //open imgae in modal
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#image_upload_view").attr("src", e.target.result);
      };
      reader.readAsDataURL(this.files[0]);
    });
  
    $("#table_banner").on("click", "button", function () {
      //get this row data
      var table = $("#table_banner").DataTable();
      var data = table.row($(this).parents("tr")).data();
      //set banner id
      $("#banner_id").val(data.banner_id);
      //get clicked button
      var id = this.id;
      //split first underscore
      var id_split = id.split("_");
      if (id_split[0] == "image") {
        //show button
        $("#btn_update_image").show();
        $("#banner_image_edit_label").show();
        //set image id
        $("#image_id").val(data.image_id);
        //open image modal
        $("modal-upload-image").modal("show");
        //set image src
  
        $("#image_upload_view").attr("src", data.image_path);
        //show modal
        $("#modal-upload-image").modal("show");
      }
      if (id_split[0] == "edit") {
        $("#banner_id").val(data.banner_id);
        $("#edit_banner_title").val(data.banner_title);
        $("#edit_banner_priority").val(data.banner_priority);
        $('#edit_banner_type').val(data.banner_type);
        $('#edit_banner_link').val(data.banner_link);
        $('#edit_banner_content').val(data.banner_content);
        if (data.banner_status == "0") {
          $("#edit_banner_status").prop("checked", false);
        } else {
          $("#edit_banner_status").prop("checked", true);
        }
        $("#modal-banner").modal("show");
      }
    });
  
    

    //save
    $("#btn_save").click(function () {
      //add class validate
      $("#form_banner").addClass("was-validated");
      var banner_content = $('#banner_content').val();
      var banner_title = $("#banner_title").val();
      var banner_type = $("#banner_type").find(":selected").val();
      var banner_link = $("#banner_link").val();
      var banner_priority = $("#banner_priority").val();
      var banner_status = 0;
      if ($("#banner_status").is(":checked")) {
        banner_status = 1;
      }
  
      //get image file
      var banner_image = $("#banner_image")[0].files[0];
  
      if (
        banner_content == "" ||
        banner_content == null ||
        banner_title == "" ||
        banner_priority == ""
      ) {
        $.alert({
          title: "Alert!",
          content:
            "banner content, title, priority should not be empty!",
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
              },
            },
          },
        });
        return;
      }
      //send ajax request
      var data = new FormData();
      data.append("function", "add_banner");
      data.append("banner_content",banner_content);
      data.append("banner_title", banner_title);
      data.append("banner_type", banner_type);
      data.append("banner_link", banner_link)
      data.append("banner_priority", banner_priority);
      data.append("banner_image", banner_image);
      data.append("banner_status", banner_status);
      $.ajax({
        type: "POST",
        processData: false,
        contentType: false,
        url: "../admin/controllers/banner_controller.php",
        data: data,
        success: function (data) {
            console.log(data)
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
            $("#form_banner").removeClass("was-validated");
            //clear form
            $("#banner_title").val("");
            $("#banner_priority").val(1);
            $("#label_image").text("Upload banner's thumb image");
            $("#banner_image").val("");
            $('#banner_content').val("");
            $('#banner_link').val("");
            $('#banner_type').val(0);
            //reset table
            var table = $("#table_banner").DataTable();
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
    });;
  });
  