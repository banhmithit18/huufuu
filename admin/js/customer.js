window.addEventListener("DOMContentLoaded", (event) => {
  //save
  $("#btn_save").click(function () {
    //add class to div
    $("#form_customer").addClass("was-validated");
    //check if email and phone right format
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-z]{2,4})+$/;
    var regex_number = /^[0-9]+$/;
    if (
      !regex.test($("#customer_email").val()) ||
      !regex_number.test($("#customer_phone").val())
    ) {
      return;
    }
    //get data
    var customer_email = $("#customer_email").val();
    var customer_phone = $("#customer_phone").val();
    var customer_age = $("#customer_age").val();
    var customer_name = $("#customer_name").val();
    var customer_address = $("#customer_address").val();
    var customer_gender = $("#customer_gender").find(":selected").val();

    //check if not null
    if (
      customer_email != "" &&
      customer_phone != "" &&
      customer_age != "" &&
      customer_name != ""
    ) {
      //send ajax
      $.ajax({
        type: "POST",
        url: "../controllers/customer_controller.php",
        data: {
          function: "add_customer",
          customer_email: customer_email,
          customer_phone: customer_phone,
          customer_age: customer_age,
          customer_name: customer_name,
          customer_address: customer_address,
          customer_gender: customer_gender,
        },
        success: function (data) {
          try {
            var data = $.parseJSON(data);
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

              //add row to table
              var t = $("#table_customer").DataTable();
              t.ajax.reload();
              //remove class was-validated
              $("#form_customer").removeClass("was-validated");
              //clear customer form
              $("#customer_email").val();
              $("#customer_phone").val();
              $("#customer_age").val();
              $("#customer_name").val();
              $("#customer_address").val();
            } else {
              $.alert({
                title: "Error!",
                content: data.response,
                type: "red",
                typeAnimated: true,
                icon: "fa fa-times-circle",
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
          } catch (e) {
            $.alert({
              title: "Error!",
              content: "Something went wrong! Reason: " + e,
              type: "red",
              typeAnimated: true,
              icon: "fa fa-times-circle",
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
    }
  });

  //get data from DataTable table by row id
  $("#table_customer").on("click", "tr", function () {
    //get row data
    var table = $("#table_customer").DataTable();
    //set data to form
    $("#edit_customer_id").val(table.row(this).data()["customer_id"]);
    $("#edit_customer_email").val(table.row(this).data()["customer_email"]);
    $("#edit_customer_phone").val(table.row(this).data()["customer_phone"]);
    $("#edit_customer_age").val(table.row(this).data()["customer_age"]);
    $("#edit_customer_name").val(table.row(this).data()["customer_name"]);
    $("#edit_customer_address").val(table.row(this).data()["customer_address"]);
    $("#edit_customer_gender").val(table.row(this).data()["customer_gender"]);
  });

  //event delete customer
  $("#btn_delete").click(function () {
    $.confirm({
      title: "Confirm!",
      content: "Are you sure to delete this customer?",
      type: "orange",
      typeAnimated: true,
      buttons: {
        confirm: function () {
          var id = $("#edit_customer_id").val();
          $.ajax({
            type: "POST",
            url: "../controllers/customer_controller.php",
            data: {
              function: "delete_customer",
              customer_id: id,
            },
            success: function (data) {
              try {
                var data = $.parseJSON(data);
                if (data.status == "1") {
                  $.alert({
                    title: "Success!",
                    type: "green",
                    typeAnimated: true,
                    content: "Customer has been deleted!",
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
                    content: "Cannot delete customer, error: " + data.error,
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
      },
      cancel: function () {},
    });
  });
  //event update customer
  $("#btn_save_edit").click(function () {
    //add class to div
    $("#form_customer_edit").addClass("was-validated");
    //check if email and phone right format
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-z]{2,4})+$/;
    var regex_number = /^[0-9]+$/;
    if (
      !regex.test($("#edit_customer_email").val()) ||
      !regex_number.test($("#edit_customer_phone").val())
    ) {
      return;
    }
    //get data
    var customer_id = $("#edit_customer_id").val();
    var customer_email = $("#edit_customer_email").val();
    var customer_phone = $("#edit_customer_phone").val();
    var customer_age = $("#edit_customer_age").val();
    var customer_name = $("#edit_customer_name").val();
    var customer_address = $("#edit_customer_address").val();
    var customer_gender = $("#edit_customer_gender").find(":selected").val();
    //check if not null
    if (
      customer_email != "" &&
      customer_phone != "" &&
      customer_age != "" &&
      customer_name != ""
    ) {
      //send ajax
      $.ajax({
        type: "POST",
        url: "../controllers/customer_controller.php",
        data: {
          function: "update_customer",
          customer_id: customer_id,
          customer_email: customer_email,
          customer_phone: customer_phone,
          customer_age: customer_age,
          customer_name: customer_name,
          customer_gender: customer_gender,
          customer_address: customer_address,
        },
        success: function (data) {
            try{
          var data = $.parseJSON(data);
          if (data.status == "1") {
            $.alert({
              title: "Success!",
              type: "green",
              typeAnimated: true,
              content: "customer has been updated !",
            });
            //hide modal
            $("#modal-customer").modal("hide");
            //reload table
            var t = $("#table_customer").DataTable();
            t.ajax.reload();
          } else {
            $.alert({
              title: "Error",
              type: "red",
              typeAnimated: true,
              content: "Cannot update customer ! Reason:" + data.error,
            });
          }
        }catch(e){
            $.alert({
                title: "Error",
                type: "red",
                typeAnimated: true,
                content: "Something went wrong! Reason: " + e,
            });
        }
        },
      });
    }
  });

  //init table
  $.fn.dataTableExt.sErrMode = "none";
  var t = $("#table_customer").DataTable({
    ajax: {
      url: "../controllers/customer_controller.php?function=get_customer",
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
                window.location.href = "../admin/index";
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

    rowId: "customer_id",
    columns: [
      { data: null },
      { data: "customer_name" },
      { data: "customer_age" },
      {
        data: "customer_gender",
        render: function (data, type, row) {
          if (data == "0") {
            return "Female";
          } else if (data == "1") {
            return "Male";
          } else {
            return "Other";
          }
        },
      },
      { data: "customer_email" },
      { data: "customer_phone" },
      { data: "customer_address" },
      {
        data: "customer_id",
        className: "dt-body-center",
        render: function (data, type, row) {
          return (
            "<button id=edit_" +
            data +
            ' class="btn btn-sm btn-outline-success btn_edit" data-toggle="modal" data-target="#modal-customer">Edit</button>'
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
