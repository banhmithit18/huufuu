
$(document).ready(function () {
    $('#send-contact-us').click(function () {
        //check if email and phone right format
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-z]{2,4})+$/;
        var regex_number = /^[0-9]+$/;
        if (!regex.test($("#customer_mail").val())) {
            $('#notification-content').text("Please input valid email")
            return;
        }
        if (!regex_number.test($("#customer_phone").val())) {
            $('#notification-content').text("Please input valid phone number")
            return;
        }
        if( $('#customer_name').val() == ""){
            $('#notification-content').text("Please input your namer")
            return;
        }
        $('#notification-content').text("");
        var customer_name = $('#customer_name').val();
        var customer_mail = $('#customer_mail').val();
        var customer_phone = $('#customer_phone').val();
        var customer_message = $('#customer_message').val();
        //send ajax
        $.ajax({
            type: "POST",
            url: "../controllers/contact_us_controller.php",
            data: {
                function: "create_contact",
                customer_name: customer_name,
                customer_mail: customer_mail,
                customer_phone: customer_phone,
                customer_message: customer_message
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
                        //remove class was-validated
                        $("#form_customer").removeClass("was-validated");
                        //clear customer form
                        $("#customer_mail").val("");
                        $("#customer_phone").val("");
                        $("#customer_name").val("");
                        $("#customer_message").val("");
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
    })
})