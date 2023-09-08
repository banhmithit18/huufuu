window.addEventListener("DOMContentLoaded", (event) => {
  //init table
  var t = $("#table_log").DataTable({
    ajax: { url: "../admin/controllers/log_controller.php", dataSrc: "" },
    columns: [
      {data: null},
      { data: "log_name" },
      { data: "log_detail" },
      { data: "log_time" , render: function(data, type, row, meta){
        return moment(data).format('DD/MM/YYYY HH:mm:ss');
      }},
      { data: "user_username" },
    ],columnDefs: [
      {
        searchable: false,
        orderable: false,
        targets: 0,
      },
    ],
    order: [[1, "asc"]],
    ordering: false
  });
  t.on("order.dt search.dt", function () {
    let i = 1;
    t.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1;
        t.cell(cell).invalidate('dom');
    });
}).draw()
});
