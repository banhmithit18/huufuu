
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
        if ($('#customer_name').val() == "") {
            $('#notification-content').text("Please input your namer")
            return;
        }
        $('#notification-content').text("");
        var customer_name = $('#customer_name').val();
        var customer_mail = $('#customer_mail').val();
        var customer_phone = $('#customer_phone').val();
        var answers = {};
        var flag_valid = true;
        //get answer
        $('.question').each(function () {
            var answer = $(this).val();
            if ($(this).is('[required]')) {
                if ($.trim(answer) === '') {
                    $.alert({
                        title: "Alert!",
                        content: "Please enter all required input",
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
                    flag_valid = false;
                }
            } else {
                //ignore 
            }
            var id = this.id;
            var question_id = id.split("_")[1];
            answers[question_id] = answer
        });
        //send ajax
        if (flag_valid) {
            $.ajax({
                type: "POST",
                url: "../controllers/contact_us_controller.php",
                data: {
                    function: "create_contact",
                    customer_name: customer_name,
                    customer_mail: customer_mail,
                    customer_phone: customer_phone,
                    answers: answers
                },
                success: function (data) {
                    console.log(data)
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
                            content: "Something went wrong! Please try again later",
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
    })
})