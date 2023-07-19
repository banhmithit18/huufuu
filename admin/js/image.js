window.addEventListener("DOMContentLoaded", (event) => {
  //init table
  var t = $("#table_image").DataTable({
    ajax: {
      url: "../controllers/image_controller.php?function=get_image",
      cache: true,
      dataSrc: function (data) {
        if (data.status == "0") {
          //alert confirm
          $.confirm({
            title: "Error!",
            type: "red",
            typeAnimated: true,
            content: "Cannot load data ! Reason: " + data.error,
            buttons: {
              OK: function () {
                //href to index
                window.location.href = "../index.php";
              },
              //try load the page
              "Try again": function () {
                //reload page
                location.reload();
              },
            },
          });
        } else {
          return data;
        }
      },
    },
    rowId: "image_id",
    columns: [
      { data: null },
      { data: "image_path" },
      { data: "type" },
      {
        data: "status",
        render: function (data, type, row, meta) {
          if (data == "Active") {
            return '<span class="badge badge-success">Active</span>';
          } else {
            return '<span class="badge badge-danger">Inactive</span>';
          }
        },
      },
      {
        data: "image_path",
        render: function (data, type, row, meta) {
          return (
            "<button id=btn_view" +
            ' class="btn btn-sm btn-outline-success">View</button>'
          );
        },
      },
      {
        data: "image_id",
        className: "dt-body-center",
        render: function (data, type, row) {
          return (
            "<button id=btn_delete" +
            ' class="btn btn-sm btn-outline-success">Delete</button>'
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
  $("#table_image").on("click", "button", function () {
    var table = $("#table_image").DataTable();
    var row = table.row($(this).parents("tr"));
    var data = row.data();
    var id = data.image_id;
    var btn = this.id;
    if (btn == "btn_view") {
      var image_path = data.image_path;
      $("#image_view_div").attr("src", image_path);
      $("#image_view_modal").modal("show");
    }
    if (btn == "btn_delete") {
      $.alert({
        title: "Confirm!",
        type: "orange",
        content: "Are you sure you want to delete this image?",
        buttons: {
          confirm: function () {
            $.ajax({
              url: "../controllers/image_controller.php",
              type: "POST",
              data: {
                image_id: id,
                function: "delete_image",
              },
              success: function (data) {
                try {
                  var data = JSON.parse(data);
                  if (data.status == "1") {
                    row.remove().draw();
                    $.alert({
                      title: "Success!",
                      type: "green",
                      typeAnimated: true,
                      content: "Image has been deleted!",
                    });
                    //reload table
                    var t = $("#table_customer").DataTable();
                    t.ajax.reload();
                    //hide modal
                    $("#modal-customer").modal("hide");
                  } else {
                    $.alert({
                      title: "Error",
                      type: "red",
                      typeAnimated: true,
                      content: data.error,
                    });
                  }
                } catch (e) {
                  $.alert({
                    title: "Error",
                    type: "red",
                    typeAnimated: true,
                    content: "Something went wrong! Reason: " + e,
                  });
                }
              },
            });
          },
          cancel: function () {},
        },
      });
    }
  });
});
