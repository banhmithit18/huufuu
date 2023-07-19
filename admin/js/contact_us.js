window.addEventListener("DOMContentLoaded", (event) => {
  //init table
  var t = $("#table_contact_us").DataTable({
    ajax: {
      url: "../controllers/contact_us_controller.php?function=get_contact",
      dataSrc: "",
    },
    rowId: "contact_us_id",
    columns: [
      { data: null },
      { data: "customer_name" },
      { data: "customer_phone" },
      { data: "customer_email" },

      {
        data: "service_name",
        render: function (data, type, row, meta) {
          return (
            "<a target='_blank' href='../../service-detail.php?id=" +
            row.service_id +
            "'>" +
            data +
            "</a>"
          );
        },
      },
      { data: "contact_us_messenger" },
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
            return '<button class="btn btn-sm btn-outline-success">Handle</button>';
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
                url: "../controllers/contact_us_controller.php",
                type: "POST",
                data: {
                    function: "handle_contact",
                    contact_us_id: contact_us_id,
                },
                success: function (data) {
                    try{
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
                    catch(e)
                    {
                        $.alert
                        ({
                            title: "Error",
                            type: "red",
                            typeAnimated: true,
                            content: "Something went wrong! Reason: " + e,
                        });
                        return;
                    }
                }})
          },
        },
        cancel: {
          text: "No",
        },
      },
    });
  });
});
