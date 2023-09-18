window.addEventListener("DOMContentLoaded", (event) => {
  //save
  $("#btn_save").click(function () {
    //add class was-validated
    $("#form_category").addClass("was-validated");
    var category_name = $("#category_name").val();
    var category_status = "0";
    if ($("#category_status").is(":checked")) {
      category_status = "1";
    }
    if (category_name == "") {
      return;
    }
    //send ajax
    $.ajax({
      type: "POST",
      url: "../admin/controllers/category_controller.php",
      data: {
        function: "add_category",
        category_name: category_name,
        category_status: category_status,
      },
      success: function (data) {
        var data = $.parseJSON(data);
        if (data.status == "1") {
          var alert =
            '<div class="alert alert-success" role="alert">' +
            data.response +
            "</div>";
          //add alert to div
          $("#return_message").prepend(alert);
          //hide alert after 10s
          setTimeout(function () {
            $("#return_message").html("");
          }, 5000);
          //add row to table
          var t = $("#table_category").DataTable();
          t.ajax.reload();
          //clear add form
          //remove class was-validated
          $("#form_category").removeClass("was-validated");
          $("#category_name").val("");
        } else {
          var alert =
            '<div class="alert alert-danger" role="alert">' +
            data.response +
            "</div>";
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

  //get data from DataTable table by row id pass to modal
  $("#table_category").on("click", "tr", function () {
    //get row data
    var table = $("#table_category").DataTable();
    //set data to form
    $("#category_id").val(table.row(this).data()["category_id"]);
    $("#edit_category_name").val(table.row(this).data()["category_name"]);
    var category_status = table.row(this).data()["category_status"];
    if (category_status == "0") {
      $("#edit_category_status").prop("checked", false);
    }
  });

  //event update
  $("#btn_save_edit").click(function () {
    $("#form_edit_category").addClass("was-validated");
    var category_id = $("#category_id").val();
    var category_name = $("#edit_category_name").val();
    var category_status = "0";
    if ($("#edit_category_status").is(":checked")) {
      category_status = "1";
    }
    if (category_name == "") {
      return;
    }
    //send ajax
    $.ajax({
      type: "POST",
      url: "../admin/controllers/category_controller.php",
      data: {
        function: "update_category",
        category_id: category_id,
        category_name: category_name,
        category_status: category_status,
      },
      success: function (data) {
        var data = $.parseJSON(data);
        if (data.status == "1") {
          $.alert({
            title: "Success!",
            type: "green",
            typeAnimated: true,
            content: "Category has been updated !",
          });
          //hide modal
          $("#modal-category").modal("hide");
          //reload table
          var t = $("#table_category").DataTable();
          t.ajax.reload();
        } else {
          $.alert({
            title: "Error",
            type: "red",
            typeAnimated: true,
            content: "Cannot update category ! Reason:" + data.error,
          });
        }
      },
    });
  });

  //delete
  $("#btn_delete").click(function () {
    $.confirm({
      title: "Confirm!",
      content: "Are you sure to delete this category?",
      type: "orange",
      typeAnimated: true,
      buttons: {
        confirm: function () {
          var id = $("#category_id").val();
          $.ajax({
            type: "POST",
            url: "../admin/controllers/category_controller.php",
            data: {
              function: "delete_category",
              category_id: id,
            },
            success: function (data) {
              var data = $.parseJSON(data);
              if (data.status == "1") {
                $.alert({
                  title: "Success!",
                  type: "green",
                  typeAnimated: true,
                  content: "Category has been deleted!",
                });
                //reload table
                var t = $("#table_category").DataTable();
                t.ajax.reload();
                //hide modal
                $("#modal-category").modal("hide");
              } else {
                $.alert({
                  title: "Error",
                  type: "red",
                  typeAnimated: true,
                  content: "Cannot delete category, error: " + data.error,
                });
              }
            },
          });
        },
      },
      cancel: function () {},
    });
  });

  //init table
  var t = $("#table_category").DataTable({
    ajax: {
      url: "../admin/controllers/category_controller.php?function=get_category",
      dataSrc: "",
    },

    rowId: "category_id",
    columns: [
      { data: null },
      { data: "category_name" },
      {
        data: "category_status",
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
        data: "category_id",
        className: "dt-body-center",
        render: function (data, type, row) {
          return (
            "<button id=edit_" +
            data +
            ' class="btn btn-sm btn-outline-success btn_edit" data-toggle="modal" data-target="#modal-category">Edit</button>'
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
