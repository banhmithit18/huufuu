window.addEventListener("DOMContentLoaded", (event) => {
  //init table
  var t = $("#table_contact_us").DataTable({
    ajax: {
      url: "../admin/controllers/contact_us_controller.php?function=get_contact",
      dataSrc: "",
    },
    rowId: "contact_us_id",
    columns: [
      { data: null },
      { data: "customer_name" },
      { data: "customer_phone" },
      { data: "customer_email" },
      {
        data: "contact_us_id",
        className: "dt-body-center",
        render: function (data, type, row, meta) {
          return (
            "<button id=view_" +
            data +
            ' class="btn btn-sm btn-outline-success btn_view_answer">View</button>'
          );
        },
      },
      {
        data: "contact_us_created_time",
        render: function (data, type, row, meta) {
          return moment(data).format("DD/MM/YYYY HH:mm:ss");
        },
      },
      {
        data: "contact_us_status",
        render: function (data, type, row, meta) {
          if (data == "1") {
            return "<span class='badge badge-success'>Handled</span>";
          } else {
            return "<span class='badge badge-danger'>Unhandled</span>";
          }
        },
      },
      {
        data: "contact_us_status",
        render: function (data, type, row, meta) {
          if (data == "0") {
            return '<button id="handle_' + data + '" class="btn btn-sm btn-outline-success">Handle</button>';
          } else {
            return '<button class="btn btn-sm btn-outline-success disabled">Handle</button>';
          }
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

  //handle contact us
  $("#table_contact_us").on("click", "button", function () {
    var table = $("#table_contact_us").DataTable();
    var data = table.row($(this).parents("tr")).data();
    var contact_us_id = data.contact_us_id;
    //get clicked button
    var id = this.id;
    //split first underscore
    var id_split = id.split("_");
    if (id_split[0] == 'handle') {
      $.alert({
        title: "Confirm",
        type: "orange",
        content: "Are you sure to handle this contact ?",
        buttons: {
          confirm: {
            text: "Yes",
            type: "red",
            btnClass: "btn-blue",
            action: function () {
              $.ajax({
                url: "../admin/controllers/contact_us_controller.php",
                type: "POST",
                data: {
                  function: "handle_contact",
                  contact_us_id: contact_us_id,
                },
                success: function (data) {
                  try {
                    data = $.parseJSON(data);
                    if (data.status == "1") {
                      $.alert({
                        title: "Success!",
                        type: "green",
                        typeAnimated: true,
                        content: "Contact has been handled!",
                      });
                      //reload table
                      var t = $("#table_contact_us").DataTable();
                      t.ajax.reload();
                    } else {
                      $.alert({
                        title: "Error",
                        type: "red",
                        typeAnimated: true,
                        content: "Cannot handle this contact, error: " + data.error,
                      });
                    }
                  }
                  catch (e) {
                    $.alert
                      ({
                        title: "Error",
                        type: "red",
                        typeAnimated: true,
                        content: "Something went wrong! Reason: " + e,
                      });
                    return;
                  }
                }
              })
            },
          },
          cancel: {
            text: "No",
          },
        },
      });
    } if (id_split[0] == 'view') {
      $.ajax({
        url: "../admin/controllers/contact_us_controller.php",
        type: "POST",
        data: {
          function: "get_contact_answer",
          'contact_us_id': contact_us_id,
        },
        success: function (data) {
          try {
            data = $.parseJSON(data);
            $("#contact_answer_detail").empty();
            if (data.length > 0) {
              for (let i = 0; i < data.length; i++) {
                console.log(data[i])
                $("#contact_answer_detail").append(
                      '<div class="row contact_answer_row">'
                  +     '<div class="contact_question">'+data[i].contact_question_content+' </div>'
                  +     '<div class="contact_answer">-  '+data[i].contact_answer_content+'</div>'
                  +  '</div>'
                );
              }
              $('#modal-contact-answer').modal('show');

            } else {
              $.alert({
                title: "Error",
                type: "red",
                typeAnimated: true,
                content: "Data not found"
              });
            }
          }
          catch (e) {
            $.alert
              ({
                title: "Error",
                type: "red",
                typeAnimated: true,
                content: "Something went wrong! Reason: " + e,
              });
            return;
          }
        }
      })
    }
  });
});
