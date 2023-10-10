window.addEventListener("DOMContentLoaded", (event) => {
  //init table
  var t = $("#table_review").DataTable({
    ajax: {
      url: "../controllers/review_controller.php?function=get_review",
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
      { data: "review_comment" },
      { data: "review_star" },
      {
        data: "review_time",
        render: function (data, type, row, meta) {
          return moment(data).format("DD/MM/YYYY HH:mm:ss");
        },
      },
      {
        data: "review_status",
        render: function (data, type, row, meta) {
          if (data == "1") {
            return "<span class='badge badge-success'>Show</span>";
          } else {
            return "<span class='badge badge-danger'>Hide</span>";
          }
        },
      },
      {
        data: "review_status",
        render: function (data, type, row, meta) {
          if (data == "1") {
            return '<button class="btn btn-sm btn-outline-success" id="hide">Hide</button>';
          } else {
            return '<button class="btn btn-sm btn-outline-success" id="show">Show</button>';
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

  $("#table_review").on("click", "button", function () {
    var btn_type = this.id;
    var table = $("#table_review").DataTable();
    var data = table.row($(this).parents("tr")).data();
    var review_id = data.review_id;
    var review_status = btn_type == "show" ? "1" : "0";
    $.ajax({
      url: "../controllers/review_controller.php",
      type: "POST",
      data: {
        function: "update_review",
        review_id: review_id,
        review_status: review_status
      },
      success: function (data) {
        try {
          data = $.parseJSON(data);
          if (data.status == "1") {
            $.alert({
              title: "Success!",
              type: "green",
              typeAnimated: true,
              content: data.response,
            });
            //reload table
            var t = $("#table_review").DataTable();
            t.ajax.reload();
          } else {
            $.alert({
              title: "Error",
              type: "red",
              typeAnimated: true,
              content: "Cannot handle this contact, error: " + data.error,
            });
          }
        } catch (e) {
          $.alert({
            title: "Error",
            type: "red",
            typeAnimated: true,
            content: "Something went wrong! Reason: " + e,
          });
          return;
        }
      },
    });
  });
});
