window.addEventListener("DOMContentLoaded", (event) => {
  $("#login").click(function () {
    var username = $("#username").val();
    var password = $("#password").val();

    if (username == "" || username == null) {
      $.alert({
        title: "Alert!",
        content: "Please enter username!",
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
      return false;
    }
    if (password == "" || password == null) {
      $.alert({
        title: "Alert!",
        content: "Please enter password!",
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
      return false;
    }

    $.ajax({
      type: "POST",
      url: "../controllers/login.php",
      data: {
        function: "login",
        username: username,
        password: password,
      },
      success: function (data) {
        try {
          var data = $.parseJSON(data);
          if (data.status == "1") {
            window.location.href = "../views/index.php";
          } else {
            $.alert({
              title: "Login failed!",
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

 
});
