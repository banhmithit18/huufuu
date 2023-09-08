window.addEventListener("DOMContentLoaded", (event) => {
  
    //get data from DataTable table by row id pass to modal
    $("#table_media").on("click", "tr", function () {
      //get row data
      var table = $("#table_media").DataTable();
      //set data to form
      $("#media_id").val(table.row(this).data()["media_id"]);
      $("#edit_media_type").val(table.row(this).data()["media_type"]);
      $("#edit_media_value").val(table.row(this).data()["media_value"]);
    });
  
    //event update 
    $("#btn_save_edit").click(function () {
      //add class to div
      $("#form_media_edit").addClass("was-validated");
      //get data
      var media_id = $("#media_id").val();
      var media_value = $("#edit_media_value").val();
        //send ajax
        $.ajax({
          type: "POST",
          url: "../admin/controllers/media_controller.php",
          data: {
            function: "update_media",
            media_id : media_id,
            media_value: media_value,
          },
          success: function (data) {
            var data = $.parseJSON(data);
            if (data.status == "1") {
              $.alert({
                title: "Success!",
                type: "green",
                typeAnimated: true,
                content: "Media has been updated !",
              });
              //hide modal
              $("#modal-media").modal("hide");
              //reload table
              var t = $("#table_media").DataTable();
              t.ajax.reload();
            } else {
              $.alert({
                title: "Error",
                type: "red",
                typeAnimated: true,
                content: "Cannot update media ! Reason:" + data.error,
              });
            }
          },
        });
    });
  
  
    //init table
    var t = $("#table_media").DataTable({
      ajax: {
        url: "../admin/controllers/media_controller.php?function=get_media",
        dataSrc: "",
      },
  
      rowId: "media_id",
      columns: [
        { data: null },
        {
            data: "media_type",
            className: "dt-body-center",
            render: function (data, type, row) {
              if (data == "1") {
                return "Facebook"
              } else if (data == "2") {
                return 'Instargarm';
              }
              else if (data == "3") {
                return 'Linkedin';
              }
              else if (data == "4") {
                return 'Footer introduce ';
              }
            },
          },
        { data: "media_value" },       
        {
          data: "media_id",
          className: "dt-body-center",
          render: function (data, type, row) {
            return (
              "<button id=edit_" +
              data +
              ' class="btn btn-sm btn-outline-success btn_edit" data-toggle="modal" data-target="#modal-media">Edit</button>'
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
  