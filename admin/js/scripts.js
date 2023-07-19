window.addEventListener("DOMContentLoaded", (event) => {
  // Toggle the side navigation
  const sidebarToggle = document.body.querySelector("#sidebarToggle");
  if (sidebarToggle) {
    // Uncomment Below to persist sidebar toggle between refreshes
    // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
    //     document.body.classList.toggle('sb-sidenav-toggled');
    // }
    sidebarToggle.addEventListener("click", (event) => {
      event.preventDefault();
      document.body.classList.toggle("sb-sidenav-toggled");
      localStorage.setItem(
        "sb|sidebar-toggle",
        document.body.classList.contains("sb-sidenav-toggled")
      );
    });
  }

  $body = $("body");
  $(document).on({
    ajaxStart: function () {
      $body.addClass("loading");
    },
    ajaxStop: function () {
      $body.removeClass("loading");
    },
  });

  //log out
  $("#logout").click(function () {
    $.ajax({
      type: "POST",
      url: "../controllers/login.php",
      data: {
        function: "logout",
      },
      success: function (data) {
        window.location.href = "../../admin/views/login.php";
      },
    });
  });

  //change password
  $("#btn_save_information_pass").click(function () {
    $("#information_user_change_password_form").addClass("was-validated");
    var old_password = $("#information_user_old_password").val();
    var new_password = $("#information_user_new_password").val();
    var new_password_repeat = $("#information_user_new_password_repeat").val();
    if (
      old_password == null ||
      old_password == "" ||
      new_password == null ||
      new_password == "" ||
      new_password_repeat == "" ||
      new_password_repeat == null
    ) {
      return;
    }
    if (new_password != new_password_repeat) {
      $.alert({
        title: "Alert!",
        content: "Password and confirm password does not match",
        type: "red",
        typeAnimated: true,
        icon: "fa fa-exclamation-circle",
        closeIcon: true,
        closeIconClass: "fa fa-close",
        autoClose: "ok|5000",
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
      return;
    }
    var user_id = $("#information_user_id").val();
    $.ajax({
      type: "POST",
      url: "../controllers/user_controller.php",
      data: {
        function: "change_password",
        user_id: user_id,
        old_password: old_password,
        new_password: new_password,
      },
      success: function (data) {
        try {
          var data = $.parseJSON(data);
          if (data.status == "1") {
            $.alert({
              title: "Sucessfully !",
              content: data.response,
              type: "green",
              typeAnimated: true,
              icon: "fa fa-exclamation-circle",
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
            $("#modal-user-change-password").modal("hide");
            $("#information_user_old_password").val();
            $("#information_user_new_password").val();
            $("#information_user_new_password_repeat").val();
            $("#information_user_change_password_form").removeClass("was-validated");

          } else {
            $.alert({
              title: "Failed!",
              content: data.response,
              type: "red",
              typeAnimated: true,
              icon: "fa fa-exclamation-circle",
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
            title: "Alert!",
            content: "Something went wrong! reason : " + e,
            type: "red",
            typeAnimated: true,
            icon: "fa fa-exclamation-circle",
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
  });

  //save edit information
  $("#btn_save_information_edit").click(function () {
    //add class to div
    $("#form_user_information").addClass("was-validated");
    //check if email and phone right format
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-z]{2,4})+$/;
    var regex_number = /^[0-9]+$/;
    if (
      !regex.test($("#information_user_email").val()) ||
      !regex_number.test($("#information_user_phone").val())
    ) {
      return;
    }
    //get data
    var user_id = $("#information_user_id").val();
    var user_username = $("#information_user_username").val();
    var user_email = $("#information_user_email").val();
    var user_phone = $("#information_user_phone").val();
    var user_age = $("#information_user_age").val();
    var user_name = $("#information_user_name").val();
    var user_address = $("#information_user_address").val();
    var user_gender = $("#information_user_gender").find(":selected").val();
    var user_role = $("#information_user_role").val();
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
        url: "../controllers/user_controller.php",
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
          user_status: true,
          page_type: "user",
        },
        success: function (data) {
          var data = $.parseJSON(data);
          if (data.status == "1") {
            $.alert({
              title: "Success!",
              type: "green",
              typeAnimated: true,
              content: "Information has been updated !",
              buttons: {
                ok: function () {
                  location.reload();
                },
              },
            });
          } else {
            $.alert({
              title: "Error",
              type: "red",
              typeAnimated: true,
              content: "Cannot update information, please try again later !",
            });
          }
        },
      });
    }
  });
});
