window.addEventListener("DOMContentLoaded", (event) => {
    
    $("#table_logo").on("click", "button", function () {
        //get this row data
        var table = $("#table_logo").DataTable();
        var data = table.row($(this).parents("tr")).data();
        //set logo id
        $("#logo_id").val(data.logo_id);
        //get clicked button
        var id = this.id;
        //split first underscore
        var id_split = id.split("_");
        if (id_split[0] == "image") {
          //show button
          $("#btn_update_image").show();
          $("#logo_image_edit_label").show();
          //set image id
          $("#image_id").val(data.image_id);
          //open image modal
          $("modal-upload-image").modal("show");
          //set image src
    
          $("#image_upload_view").attr("src", data.image_path);
          //show modal
          $("#modal-upload-image").modal("show");
        }
      });

     //save image edit
  $("#btn_update_image").click(function () {
    var logo_image = $("#logo_image_edit")[0].files[0];
    var image_id = $("#image_id").val();
    var form_data = new FormData();
    form_data.append("image", logo_image);
    form_data.append("image_id", image_id);
    form_data.append("function", "update_image");
    $.ajax({
      url: "../controllers/logo_controller.php",
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
  $("#logo_image_edit").change(function () {
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
      $("#logo_image_edit").val("");
      return;
    }
    //open imgae in modal
    var reader = new FileReader();
    reader.onload = function (e) {
      $("#image_upload_view").attr("src", e.target.result);
    };
    reader.readAsDataURL(this.files[0]);
  });
  
    //init table
    var t = $("#table_logo").DataTable({
      ajax: {
        url: "../controllers/logo_controller.php?function=get_logo",
        dataSrc: "",
      },
  
      rowId: "logo_id",
      columns: [
        { data: null },
        {
            data: "image_path",
            className: "dt-body-center",
            render: function (data, type, row, meta) {
              return (
                "<button id=image_" +
                data +
                ' class="btn btn-sm btn-outline-success btn_edit" data-toggle="modal" data-target="#modal-upload-image">View</button>'
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
  });
  