window.addEventListener("DOMContentLoaded", (event) => {
  //save
  $("#btn_save").click(function () {
    //add class to div
    $("#form_user").addClass("was-validated");
    //check if email and phone right format
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-z]{2,4})+$/;
    var regex_number = /^[0-9]+$/;
    if (
      !regex.test($("#user_email").val()) ||
      !regex_number.test($("#user_phone").val())
    ) {
      return;
    }
    //get data
    var user_username = $("#user_username").val();
    var user_pwd = $("#user_pwd").val();
    var user_email = $("#user_email").val();
    var user_phone = $("#user_phone").val();
    var user_age = $("#user_age").val();
    var user_name = $("#user_name").val();
    var user_address = $("#user_address").val();
    var user_gender = $("#user_gender").find(":selected").val();
    var user_role = $("#user_role").find(":selected").val();
    var user_status = "0";
    if ($("#user_status").is(":checked")) {
      user_status = "1";
    }
    //check if not null
    if (
      user_username != "" &&
      user_pwd != "" &&
      user_email != "" &&
      user_phone != "" &&
      user_age != "" &&
      user_name != ""
    ) {
      //send ajax
      $.ajax({
        type: "POST",
        url: "../admin/controllers/user_controller.php",
        data: {
          function: "add_user",
          user_username: user_username,
          user_pwd: user_pwd,
          user_email: user_email,
          user_phone: user_phone,
          user_age: user_age,
          user_name: user_name,
          user_address: user_address,
          user_role: user_role,
          user_gender: user_gender,
          user_status: user_status,
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
            var t = $("#table_user").DataTable();
            t.ajax.reload();
            //remove class was-validated
            $("#form_user").removeClass("was-validated");
            //clear user form
            $("#user_username").val();
            $("#user_pwd").val();
            $("#user_email").val();
            $("#user_phone").val();
            $("#user_age").val();
            $("#user_name").val();
            $("#user_address").val();
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
    }
  });

  //get data from DataTable table by row id
  $("#table_user").on("click", "tr", function () {
    //get row data
    var table = $("#table_user").DataTable();
    //set data to form
    $("#edit_user_id").val(table.row(this).data()["user_id"]);
    $("#edit_user_username").val(table.row(this).data()["user_username"]);
    $("#edit_user_email").val(table.row(this).data()["user_email"]);
    $("#edit_user_phone").val(table.row(this).data()["user_phone"]);
    $("#edit_user_age").val(table.row(this).data()["user_age"]);
    $("#edit_user_name").val(table.row(this).data()["user_name"]);
    $("#edit_user_address").val(table.row(this).data()["user_address"]);
    $("#edit_user_role").val(table.row(this).data()["user_role"]);
    $("#edit_user_gender").val(table.row(this).data()["user_gender"]);
    var user_status = table.row(this).data()["user_status"];
    if (user_status == "0") {
      $("#edit_user_status").prop("checked", false);
    }
  });

  //event delete user
  $("#btn_delete").click(function () {
    $.confirm({
      title: "Confirm!",
      content: "Are you sure to delete this user?",
      type: "orange",
      typeAnimated: true,
      buttons: {
        confirm: function () {
          var id = $("#edit_user_id").val();
          $.ajax({
            type: "POST",
            url: "../admin/controllers/user_controller.php",
            data: {
              function: "delete_user",
              user_id: id,
            },
            success: function (data) {
              var data = $.parseJSON(data);
              if (data.status == "1") {
                $.alert({
                  title: "Success!",
                  type: "green",
                  typeAnimated: true,
                  content: "User has been deleted!",
                });
                //reload table
                var t = $("#table_user").DataTable();
                t.ajax.reload();
                //hide modal
                $("#modal-user").modal("hide");
              } else {
                $.alert({
                  title: "Error",
                  type: "red",
                  typeAnimated: true,
                  content: "Cannot delete user, error: " + data.error,
                });
              }
            },
          });
        },
      },
      cancel: function () {},
    });
  });
  //event update user
  $("#btn_save_edit").click(function () {
    //add class to div
    $("#form_user_edit").addClass("was-validated");
    //check if email and phone right format
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-z]{2,4})+$/;
    var regex_number = /^[0-9]+$/;
    if (
      !regex.test($("#edit_user_email").val()) ||
      !regex_number.test($("#edit_user_phone").val())
    ) {
      return;
    }
    //get data
    var user_id = $("#edit_user_id").val();
    var user_username = $("#edit_user_username").val();
    var user_email = $("#edit_user_email").val();
    var user_phone = $("#edit_user_phone").val();
    var user_age = $("#edit_user_age").val();
    var user_name = $("#edit_user_name").val();
    var user_address = $("#edit_user_address").val();
    var user_gender = $("#edit_user_gender").find(":selected").val();
    var user_role = $("#edit_user_role").find(":selected").val();
    var user_status = "0";
    if ($("#edit_user_status").is(":checked")) {
      user_status = "1";
    }
    //check if not null
    if (
      user_username != "" &&
      user_email != "" &&
      user_phone != "" &&
      user_age != "" &&
      user_name != ""
    ) {
      //send ajax
      $.ajax({
        type: "POST",
        url: "../admin/controllers/user_controller.php",
        data: {
          function: "update_user",
          user_id: user_id,
          user_username: user_username,
          user_email: user_email,
          user_phone: user_phone,
          user_age: user_age,
          user_name: user_name,
          user_gender: user_gender,
          user_address: user_address,
          user_role: user_role,
          user_status: user_status,
          page_type: "admin",
        },
        success: function (data) {
          var data = $.parseJSON(data);
          if (data.status == "1") {
            $.alert({
              title: "Success!",
              type: "green",
              typeAnimated: true,
              content: "User has been updated !",
            });
            //hide modal
            $("#modal-user").modal("hide");
            //reload table
            var t = $("#table_user").DataTable();
            t.ajax.reload();
          } else {
            $.alert({
              title: "Error",
              type: "red",
              typeAnimated: true,
              content: "Cannot update user ! Reason:" + data.error,
            });
          }
        },
      });
    }
  });

  //event reset password
  $("#btn_reset_password").click(function () {
    $.confirm({
      title: "Alert!",
      type: "orange",
      typeAnimated: true,
      content: "Are you sure to reset this user's password !",
      buttons: {
        confirm: function () {
          var user_id = $("#edit_user_id").val();
          $.ajax({
            type: "POST",
            url: "../admin/controllers/user_controller.php",
            data: {
              function: "reset_password",
              user_id: user_id,
            },
            success: function (data) {
              var data = $.parseJSON(data);
              if (data.status == "1") {
                $.alert({
                  title: "Success!",
                  type: "green",
                  typeAnimated: true,
                  content: "Password has been reseted !",
                });
              } else {
                $.alert({
                  title: "Error",
                  type: "red",
                  typeAnimated: true,
                  content: "Cannot reset password !",
                });
              }
            },
          });
        },
        cancel: function () {},
      },
    });
  });

  //init table
  $.fn.dataTableExt.sErrMode = "none";
  var t = $("#table_user").DataTable({
    ajax: {
      url: "../admin/controllers/user_controller.php?function=get_user",
      dataSrc: "",
    },
    rowId: "user_id",
    columns: [
      { data: null },
      { data: "user_username" },
      { data: "user_name" },
      { data: "user_age" },
      {
        data: "user_gender",
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
      { data: "user_email" },
      { data: "user_phone" },
      {
        data: "user_role",
        render: function (data, type, row) {
          if (data == "1") {
            return "User";
          } else if (data == "0") {
            return "Admin";
          }
        },
      },
      {
        data: "user_status",
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
        data: "user_id",
        className: "dt-body-center",
        render: function (data, type, row) {
          return (
            "<button id=edit_" +
            data +
            ' class="btn btn-sm btn-outline-success btn_edit" data-toggle="modal" data-target="#modal-user">Edit</button>'
          );
        },
      },
      { data: "user_address" },
    ],
    columnDefs: [
      {
        searchable: false,
        orderable: false,
        targets: 0,
      },
      {
        target: 10,
        visible: false,
        searchable: false,
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
