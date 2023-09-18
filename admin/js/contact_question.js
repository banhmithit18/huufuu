window.addEventListener("DOMContentLoaded", (event) => {
    //save
    $("#btn_save").click(function () {
      var regex_number = /^[0-9]+$/;
      $("#form_contact_question").addClass("was-validated");
      if (
        !regex_number.test($("#contact_question_priority").val())
      ) {
        return;
      }
      if($("#contact_question_content").val() == "" || $("#contact_question_answer").val() == ""){
        return;
      } 
      //get data
      var contact_question_content = $("#contact_question_content").val();
      var contact_question_priority = $("#contact_question_priority").val();
      var contact_question_status = "0";
      if ($("#contact_question_status").is(":checked")) {
        contact_question_status = "1";
      }
      var contact_question_required = "0";
      if ($("#contact_question_required").is(":checked")) {
        contact_question_required = "1";
      }
      //send ajax
      $.ajax({
        type: "POST",
        url: "../admin/controllers/contact_question_controller.php",
        data: {
          function: "add_contact_question",
          contact_question_content: contact_question_content,
          contact_question_priority: contact_question_priority,
          contact_question_status: contact_question_status,
          contact_question_required: contact_question_required
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
            var t = $("#table_contact_question").DataTable();
            t.ajax.reload();
             //clear add form
             //remove class was-validated
             $("#form_contact_question").removeClass("was-validated");
             $("#contact_question_content").val("");
             $("#contact_question_priority").val("");
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
    $("#table_contact_question").on("click", "tr", function () {
      //get row data
      var table = $("#table_contact_question").DataTable();
      //set data to form
      $("#contact_question_id").val(table.row(this).data()["contact_question_id"]);
      $("#edit_contact_question_content").val(table.row(this).data()["contact_question_content"]);
      $("#edit_contact_question_priority").val(table.row(this).data()["contact_question_priority"]);
      var contact_question_status = table.row(this).data()["contact_question_status"];
      if (contact_question_status == "0") {
        $("#edit_contact_question_status").prop("checked", false);
      }
      var contact_question_required = table.row(this).data()["contact_question_required"];
      if (contact_question_required == "0") {
        $("#edit_contact_question_required").prop("checked", false);
      }
    });
  
    //event update 
    $("#btn_save_edit").click(function () {
      //add class to div
      $("#form_contact_question_edit").addClass("was-validated");
      //check if email and phone right format
      var regex_number = /^[0-9]+$/;
      if (
        !regex_number.test($("#edit_contact_question_priority").val())
      ) {
        return;
      }
      //get data
      var contact_question_id = $("#contact_question_id").val();
      var contact_question_content = $("#edit_contact_question_content").val();
      var contact_question_priority = $("#edit_contact_question_priority").val();
      var contact_question_status = "0";
      var contact_question_required = "0";
      if ($("#edit_contact_question_status").is(":checked")) {
        contact_question_status = "1";
      }  
      if ($("#edit_contact_question_required").is(":checked")) {
        contact_question_required = "1";
      }  
      if(contact_question_content == ""){
        return;
      } 
        //send ajax
        $.ajax({
          type: "POST",
          url: "../admin/controllers/contact_question_controller.php",
          data: {
            function: "update_contact_question",
            contact_question_id : contact_question_id,
            contact_question_content: contact_question_content,
            contact_question_priority: contact_question_priority,
            contact_question_status: contact_question_status,
            contact_question_required: contact_question_required
          },
          success: function (data) {
            var data = $.parseJSON(data);
            if (data.status == "1") {
              $.alert({
                title: "Success!",
                type: "green",
                typeAnimated: true,
                content: "Contact Question has been updated !",
              });
              //hide modal
              $("#modal-contact_question").modal("hide");
              //reload table
              var t = $("#table_contact_question").DataTable();
              t.ajax.reload();
            } else {
              $.alert({
                title: "Error",
                type: "red",
                typeAnimated: true,
                content: "Cannot update contact question ! Reason:" + data.error,
              });
            }
          },
        });
    });
  
    //init table
    var t = $("#table_contact_question").DataTable({
      ajax: {
        url: "../admin/controllers/contact_question_controller.php?function=get_contact_question",
        dataSrc: "",
      },
  
      rowId: "contact_question_id",
      columns: [
        { data: null },
        { data: "contact_question_content" },
        { data: "contact_question_priority" },
        {
          data: "contact_question_status",
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
          data: "contact_question_id",
          className: "dt-body-center",
          render: function (data, type, row) {
            return (
              "<button id=edit_" +
              data +
              ' class="btn btn-sm btn-outline-success btn_edit" data-toggle="modal" data-target="#modal-contact_question">Edit</button>'
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
  