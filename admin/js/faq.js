window.addEventListener("DOMContentLoaded", (event) => {
  //save
  $("#btn_save").click(function () {
    var regex_number = /^[0-9]+$/;
    $("#form_faq").addClass("was-validated");
    if (
      !regex_number.test($("#faq_priority").val())
    ) {
      return;
    }
    if($("#faq_question").val() == "" || $("#faq_answer").val() == ""){
      return;
    } 
    //get data
    var faq_question = $("#faq_question").val();
    var faq_answer = $("#faq_answer").val();
    var faq_priority = $("#faq_priority").val();
    var faq_status = "0";
    if ($("#faq_status").is(":checked")) {
      faq_status = "1";
    }
    //send ajax
    $.ajax({
      type: "POST",
      url: "../controllers/faq_controller.php",
      data: {
        function: "add_faq",
        faq_question: faq_question,
        faq_answer: faq_answer,
        faq_priority: faq_priority,
        faq_status: faq_status,
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
          var t = $("#table_faq").DataTable();
          t.ajax.reload();
           //clear add form
           //remove class was-validated
           $("#form_faq").removeClass("was-validated");
           $("#faq_question").val("");
           $("#faq_answer").val("");
           $("#faq_priority").val("");
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
  $("#table_faq").on("click", "tr", function () {
    //get row data
    var table = $("#table_faq").DataTable();
    //set data to form
    $("#faq_id").val(table.row(this).data()["faq_id"]);
    $("#edit_faq_question").val(table.row(this).data()["faq_question"]);
    $("#edit_faq_answer").val(table.row(this).data()["faq_answer"]);
    $("#edit_faq_priority").val(table.row(this).data()["faq_priority"]);
    var faq_status = table.row(this).data()["faq_status"];
    if (faq_status == "0") {
      $("#edit_faq_status").prop("checked", false);
    }
  });

  //event update 
  $("#btn_save_edit").click(function () {
    //add class to div
    $("#form_faq_edit").addClass("was-validated");
    //check if email and phone right format
    var regex_number = /^[0-9]+$/;
    if (
      !regex_number.test($("#edit_faq_priority").val())
    ) {
      return;
    }
    //get data
    var faq_id = $("#faq_id").val();
    var faq_answer = $("#edit_faq_answer").val();
    var faq_question = $("#edit_faq_question").val();
    var faq_priority = $("#edit_faq_priority").val();
    var faq_status = "0";
    if ($("#edit_faq_status").is(":checked")) {
      faq_status = "1";
    }   
    if(faq_answer == "" || faq_question == ""){
      return;
    } 
      //send ajax
      $.ajax({
        type: "POST",
        url: "../controllers/faq_controller.php",
        data: {
          function: "update_faq",
          faq_id : faq_id,
          faq_question: faq_question,
          faq_answer: faq_answer,
          faq_priority: faq_priority,
          faq_status: faq_status
        },
        success: function (data) {
          var data = $.parseJSON(data);
          if (data.status == "1") {
            $.alert({
              title: "Success!",
              type: "green",
              typeAnimated: true,
              content: "FAQ has been updated !",
            });
            //hide modal
            $("#modal-faq").modal("hide");
            //reload table
            var t = $("#table_faq").DataTable();
            t.ajax.reload();
          } else {
            $.alert({
              title: "Error",
              type: "red",
              typeAnimated: true,
              content: "Cannot update FAQ ! Reason:" + data.error,
            });
          }
        },
      });
  });

  //delete
  $("#btn_delete").click(function () {
    $.confirm({
      title: "Confirm!",
      content: "Are you sure to delete this FAQ?",
      type: "orange",
      typeAnimated: true,
      buttons: {
        confirm: function () {
          var id = $("#faq_id").val();
          $.ajax({
            type: "POST",
            url: "../controllers/faq_controller.php",
            data: {
              function: "delete_faq",
              faq_id: id,
            },
            success: function (data) {
              var data = $.parseJSON(data);
              if (data.status == "1") {
                $.alert({
                  title: "Success!",
                  type: "green",
                  typeAnimated: true,
                  content: "FAQ has been deleted!",
                });
                //reload table
                var t = $("#table_faq").DataTable();
                t.ajax.reload();
                //hide modal
                $("#modal-faq").modal("hide");
              } else {
                $.alert({
                  title: "Error",
                  type: "red",
                  typeAnimated: true,
                  content: "Cannot delete FAQ, error: " + data.error,
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
  var t = $("#table_faq").DataTable({
    ajax: {
      url: "../controllers/faq_controller.php?function=get_faq",
      dataSrc: "",
    },

    rowId: "faq_id",
    columns: [
      { data: null },
      { data: "faq_question" },
      { data: "faq_answer" },
      { data: "faq_priority" },
      {
        data: "faq_status",
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
        data: "faq_id",
        className: "dt-body-center",
        render: function (data, type, row) {
          return (
            "<button id=edit_" +
            data +
            ' class="btn btn-sm btn-outline-success btn_edit" data-toggle="modal" data-target="#modal-faq">Edit</button>'
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
