window.addEventListener("DOMContentLoaded", (event) => {
    //init table
    var t = $("#table_feedback").DataTable({
        ajax: {
            url: "../controllers/feedback_controller.php?function=get_feedback",
            dataSrc: "",
        },
        rowId: "feedback_id",
        columns: [
            { data: null },
            { data: "feedback_name" },
            { data: "feedback_priority" },
            {
                data: "feedback_id",
                className: "dt-body-center",
                render: function (data, type, row, meta) {
                    return (
                        "<button id=image_" +
                        data +
                        ' class="btn btn-sm btn-outline-success btn_edit">View</button>'
                    );
                },
            },
            {
                data: "feedback_status",
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
                data: "feedback_id",
                className: "dt-body-center",
                render: function (data, type, row) {
                    return (
                        "<button id=edit_" +
                        data +
                        ' class="btn btn-sm btn-outline-success btn_edit" data-toggle="modal" data-target="#modal-feedback">Edit</button>'
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
    

    //show image preview
    $("#feedback_image").change(function () {
        //hidden button save change
        $("#btn_save_image").hide();
        //empty class casousel inner and indicator
        $(".carousel-indicators").empty();
        $(".carousel-inner").empty();
        let flag = false;
        let count = 0;

        Array.from(this.files).map(function (f) {
            {
                if (!f.type.match("image.*")) {
                    {
                        $.alert({
                            title: "Error",
                            type: "red",
                            typeAnimated: true,
                            content: "Please upload image only",
                        });
                        return;
                    }
                }
                flag = true;
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(
                        '<div class="carousel-item"><img src="' +
                        e.target.result +
                        '" id="c-item_' +
                        f.name +
                        '" width="450px" height="300px"></div>'
                    ).appendTo(".carousel-inner");
                    $(
                        '<li data-target="#carousel_image_feedback" data-slide-to="' +
                        count +
                        '"></li>'
                    ).appendTo(".carousel-indicators");
                    count++;
                    $(".carousel-item").first().addClass("active");
                    $(".carousel-indicators > li").first().addClass("active");
                    $(".carousel").carousel();
                };
                reader.readAsDataURL(f);
            }
            //show image preview modal
            if (flag == true) {
                //enable button preview image
                $("#btn-preview-image").removeAttr("disabled");
                $("#modal-feedback-image").modal("show");
            }
        });
        //set last image id
        $("#feedback_image_count").val(count);
    });
    //show image preview
    $("#feedback_image_add").change(function () {
        var last_image_id = $("#feedback_image_count").val();
        let flag = false;
        var count = 0;
        if (last_image_id != "" && last_image_id != "0") {
            count = parseInt(last_image_id);
        }
        Array.from(this.files).map(function (f) {
            {
                if (!f.type.match("image.*")) {
                    {
                        $.alert({
                            title: "Error",
                            type: "red",
                            typeAnimated: true,
                            content: "Please upload image only",
                        });
                        return;
                    }
                }
                flag = true;
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(
                        '<div class="carousel-item"><img src="' +
                        e.target.result +
                        '" id="c-item_' +
                        f.name +
                        '" width="450px" height="300px"></div>'
                    ).appendTo(".carousel-inner");
                    $(
                        '<li data-target="#carousel_image_feedback" id"c-indi_' +
                        f.name +
                        '" data-slide-to="' +
                        count +
                        '"></li>'
                    ).appendTo(".carousel-indicators");
                    count++;
                    $(".carousel").carousel();
                };
                reader.readAsDataURL(f);
            }
        });
        //set input
        var input_image = $("#feedback_image");
        var input_add_image = $("#feedback_image_add");
        const files_image = getFiles(input_image[0]);
        const files_add_image = getFiles(input_add_image[0]);
        //Add new image to input
        files_image.push(...files_add_image);
        //change input image
        input_image = setFiles(input_image[0], files_image);
        $("#feedback_image_count").val(count);
    });
    //delete current image
    $("#btn_delete_image").click(function () {
        var count = $("#feedback_image_count").val();

        //get current active image
        var current_image = $(".carousel-item.active img");
        //get current image id
        var current_image_id = current_image.attr("id");
        current_image_id = current_image_id.replace("c-item_", "");
        //get current input
        var input_image = $("#feedback_image");
        const files_image = getFiles(input_image[0]);
        const index = files_image.findIndex(
            (file) => file.name === current_image_id
        );
        //remove image from input
        files_image.splice(index, 1);
        //change input image
        input_image = setFiles(input_image[0], files_image);
        //remove carousel which active
        $(".carousel-item.active").remove();
        //remove indicator which active
        $(".carousel-indicators > li.active").remove();
        //set last image id
        $("#feedback_image_count").val(files_image.length);
        //set active image
        $(".carousel-item").first().addClass("active");
        $(".carousel-indicators > li").first().addClass("active");
        $(".carousel").carousel();
        $("#feedback_image_count").val(count - 1);
    });
    //change image
    $("#feedback_image_edit").change(function () {
        {
            //get file name and replace label
            if (!this.files[0].type.match("image.*")) {
                {
                    $.alert({
                        title: "Invalid file type",
                        content: "Please select a valid image file",
                        type: "red",
                        typeAnimated: true,
                        closeIcon: true,
                        closeIconClass: "fa fa-close",
                        closeBtnClass: "btn-danger",
                        closeBtn: "Close",
                        buttons: {
                            close: {
                                text: "Close",
                                btnClass: "btn-danger",
                            },
                        },
                    });
                    $("#feedback_image_edit").val("");
                    return;
                }
            }

            var old_name = $(".carousel-inner .active img").attr("id");
            var new_image = this.files[0];
            var reader = new FileReader();
            reader.onload = function (e) {
                $(".carousel-inner .active img").attr("src", e.target.result);
                //chaneg id image
                $(".carousel-inner .active img").attr(
                    "id",
                    "c-item_id_" + new_image.name
                );
                //change input image
                $(".carousel-indicators > li.active").attr(
                    "id",
                    "c-indi_" + new_image.name
                );
            };
            var input_image = $("#feedback_image");
            var input_edit_image = $("#feedback_image_edit");
            const files_image = getFiles(input_image[0]);
            const files_edit_image = getFiles(input_edit_image[0]);
            //get index of file name
            const index = files_image.findIndex((file) => file.name === old_name);
            //get index of image
            //remove image from input
            files_image.splice(index, 1);
            //Add new image to input
            files_image.push(files_edit_image[0]);
            //change input image
            input_image = setFiles(input_image[0], files_image);
            $(".carousel").carousel();
            reader.readAsDataURL(this.files[0]);
        }
    });

    function getFiles(input) {
        const files = new Array(input.files.length);
        for (let i = 0; i < input.files.length; i++) files[i] = input.files.item(i);
        return files;
    }

    function setFiles(input, files) {
        const dataTransfer = new DataTransfer();
        for (const file of files) dataTransfer.items.add(file);
        input.files = dataTransfer.files;
    }
    //end enit
    //start add feedback
    $("#btn_save").click(function () {
        //add class validate
        $("#form_feedback").addClass("was-validated");
        //get data
        var feedback_name = $("#feedback_name").val();
        var feedback_priority = $("#feedback_priority").val();
        var feedback_content = $("#feedback_content").val();
        var feedback_image = getFiles($("#feedback_image")[0]);
        var feedback_status = 0;
        if ($("#feedback_status").is(":checked")) {
            feedback_status = 1;
        }
        if ((feedback_name == "", feedback_image == "")) {
            $.alert({
                title: "Error",
                type: "red",
                typeAnimated: true,
                content: "Please fill all fields",
            });
            return;
        }
        //create form
        var formData = new FormData();
        formData.append("feedback_name", feedback_name);
        formData.append("feedback_content", feedback_content);
        formData.append("feedback_priority",feedback_priority);
        formData.append("feedback_status", feedback_status);
        formData.append("function", "add_feedback");
        var feedback_image_count = 0;
        for (var i = 0; i < feedback_image.length; i++) {
            formData.append("feedback_image_" + i, feedback_image[i]);
            feedback_image_count++;
        }
        formData.append("feedback_image_count", feedback_image_count);

        //send data
        $.ajax({
            type: "POST",
            url: "../controllers/feedback_controller.php",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                try {
                    data = JSON.parse(data);
                    if (data.status == "1") {
                        //clear form
                        $("#feedback_name").val("");
                        $("#feedback_content").val("");
                        $("#feedback_image").val("");
                        //disable button
                        $("#btn_preview_image").attr("disabled", true);
                        $("#form_feedback").removeClass("was-validated");
                        //reload table
                        $("#table_feedback").DataTable().ajax.reload();
    
                        //alert
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
                    } else {
                        //clear form
                        $("#feedback_name").val("");
                        $("#feedback_content").val("");
                        $("#feedback_image").val(null);
                        $("#btn_preview_image").attr("disabled", true);
                        $("#form_feedback").removeClass("was-validated");
                        $.alert({
                            title: "Error!",
                            content: data.error,
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
    //end start add feedback
    //start edit feedback

    $("#table_feedback").on("click", "button", function () {
        //get this row data
        var table = $("#table_feedback").DataTable();
        var data = table.row($(this).parents("tr")).data();
        //set blog id
        $("#feedback_id").val(data.feedback_id);
        //get clicked button
        var id = this.id;
        //split first underscore
        var id_split = id.split("_");
        if (id_split[0] == "edit") {
            $('#image_id').val(data.image_id);
            $("#feedback_name_edit").val(data.feedback_name);
            $('#feedback_priority_edit').val(data.feedback_priority);
            $("#feedback_content_edit").val(data.feedback_content);
            if (data.feedback_status == "0") {
                $("#edit_feedback_status").prop("checked", false);
            } else {
                $("#edit_feedback_status").prop("checked", true);
            }
        }
        if (id_split[0] == "image") {
            feedback_image_delete = [];
            $.ajax({
                type: "POST",
                url: "../controllers/feedback_controller.php",
                data: {
                    feedback_id: data.feedback_id,
                    function: "get_image",
                },
                success: function (data) {
                    try {
                        data = $.parseJSON(data);
                        //empty class casousel inner and indicator
                        $("#carousel-indicators-edit").empty();
                        $("#carousel-inner-edit").empty();

                        let count = 0;
                        var dataTransfer = new DataTransfer();
                        for (let i = 0; i < data.length; i++) {
                            let image_name = data[i].image_path.split("/");
                            image_name = image_name[image_name.length - 1];
                            let image_extension = image_name.split(".");
                            image_extension =
                                "image/" + image_extension[image_extension.length - 1];
                            loadURLToInputFiled(
                                data[i].image_path,
                                image_name,
                                image_extension,
                                dataTransfer
                            );
                            //create carousel inner
                            $(
                                '<div class="carousel-item image_edit"><img src="' +
                                data[i].image_path +
                                '" data-name ="' +
                                data[i].feedback_image_id +
                                '" id="feedback_image_id_' +
                                image_name +
                                '" width="450px" height="300px"></div>'
                            ).appendTo("#carousel-inner-edit");
                            $(
                                '<li data-target="#carousel_image_feedback" class="image_edit" data-slide-to="' +
                                count +
                                '"></li>'
                            ).appendTo("#carousel-indicators-edit");
                            count++;
                        }
                        $("#image_edit_count").val(count);
                        $(".carousel-item.image_edit").first().addClass("active");
                        $("#carousel-indicators-edit > li").first().addClass("active");
                        $(".carousel").carousel();
                        $("#modal-feedback-image-edit").modal("show");
                    } catch ($e) {
                        $.alert({
                            title: "Alert!",
                            content: "Something went wrong! reason : " + $e,
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
        }
    });
    function loadURLToInputFiled(url, name, ext, dataTransfer) {
        getImgURL(url, (imgBlob) => {
            // Load img blob to input
            // WIP: UTF8 character error
            let fileName = name;
            var file = new File(
                [imgBlob],
                fileName,
                { type: ext, lastModified: new Date().getTime() },
                "utf-8"
            );
            dataTransfer.items.add(file);
            document.querySelector("#image_edit").files = dataTransfer.files;
        });
    }
    // xmlHTTP return blob respond
    function getImgURL(url, callback) {
        var xhr = new XMLHttpRequest();
        xhr.onload = function () {
            callback(xhr.response);
        };
        xhr.open("GET", url);
        xhr.responseType = "blob";
        xhr.send();
    }
    //add edit image
    $("#upload_image_edit").change(function () {
        //get file name and replace label
        if (!this.files[0].type.match("image.*")) {
            {
                $.alert({
                    title: "Invalid file type",
                    content: "Please select a valid image file",
                    type: "red",
                    typeAnimated: true,
                    closeIcon: true,
                    closeIconClass: "fa fa-close",
                    closeBtnClass: "btn-danger",
                    closeBtn: "Close",
                    buttons: {
                        close: {
                            text: "Close",
                            btnClass: "btn-danger",
                        },
                    },
                });
                $("#feedback_image_edit").val("");
                return;
            }
        }

        var old_name = $("#carousel-inner-edit .active img").attr("id");
        old_name = old_name.split("_")[3];
        var new_image = this.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#carousel-inner-edit .active img").attr("src", e.target.result);
            //chaneg id image
            $("#carousel-inner-edit .active img").attr(
                "id",
                "feedback_image_id_" + new_image.name
            );
            //change input image
        };
        var input_image = $("#image_edit");
        var input_edit_image = $("#upload_image_edit");
        const files_image = getFiles(input_image[0]);
        const files_edit_image = getFiles(input_edit_image[0]);
        //get index of file name
        const index = files_image.findIndex((file) => file.name === old_name);
        //get index of image
        //remove image from input
        files_image.splice(index, 1);
        //Add new image to input
        files_image.push(files_edit_image[0]);
        //change input image
        input_image = setFiles(input_image[0], files_image);
        $(".carousel").carousel();
        reader.readAsDataURL(this.files[0]);
    });

    $("#add_image_edit").change(function () {
        var count = $("#image_edit_count").val();
        Array.from(this.files).map(function (f) {
            {
                if (!f.type.match("image.*")) {
                    {
                        $.alert({
                            title: "Error",
                            type: "red",
                            typeAnimated: true,
                            content: "Please upload image only",
                        });
                        return;
                    }
                }
                flag = true;
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(
                        '<div class="carousel-item image_edit"><img src="' +
                        e.target.result +
                        '" id="feedback_image_id_' +
                        f.name +
                        '" width="450px" height="300px"></div>'
                    ).appendTo("#carousel-inner-edit");
                    $(
                        '<li data-target="#carousel_image_feedback" class="image_edit" id"feedback_image_edit_' +
                        f.name +
                        '" data-slide-to="' +
                        count +
                        '"></li>'
                    ).appendTo("#carousel-indicators-edit");
                    count++;
                    $(".carousel").carousel();
                };
                reader.readAsDataURL(f);
                count++;
            }
        });
        //set input
        var input_image = $("#image_edit");
        var input_add_image = $("#add_image_edit");
        const files_image = getFiles(input_image[0]);
        const files_add_image = getFiles(input_add_image[0]);
        //Add new image to input
        files_image.push(...files_add_image);
        //change input image
        input_image = setFiles(input_image[0], files_image);
        $("#image_edit_count").val(count);
    });
    //remove image
    $("#btn_delete_image_edit").click(function () {
        var count = $("#image_edit_count").val();
        var current_image = $(".carousel-item.image_edit.active img");
        var feedback_image_id = $(".carousel-item.image_edit.active img").attr(
            "data-name"
        );
        feedback_image_delete.push(feedback_image_id);
        //get current image id
        var current_image_id = current_image.attr("id");
        current_image_id = current_image_id.replace("feedback_image_edit_", "");
        //get current input
        var input_image = $("#image_edit");
        const files_image = getFiles(input_image[0]);
        const index = files_image.findIndex(
            (file) => file.name === current_image_id
        );
        //remove image from input
        files_image.splice(index, 1);
        //change input image
        input_image = setFiles(input_image[0], files_image);
        //remove carousel which active
        $(".carousel-item.image_edit.active").remove();
        //remove indicator which active
        $(".carousel-indicators > li.active").remove();
        //set last image id
        $("#feedback_image_count").val(files_image.length);
        //set active image
        $(".carousel-item.image_edit").first().addClass("active");
        $(".carousel-indicators.image_edit > li").first().addClass("active");
        $(".carousel").carousel();
        $("#image_edit_count").val(count - 1);
    });
    $("#btn_save_image_edit").click(function () {
        var formData = new FormData();
        var count = 0;
        var feedback_id = $("#feedback_id").val();
        var feedback_image = getFiles($("#image_edit")[0]);
        for (var i = 0; i < feedback_image.length; i++) {
            formData.append("feedback_image_" + i, feedback_image[i]);
            //get data attribute
            formData.append(
                "feedback_image_id_" + i,
                $("#feedback_image_id_" + $.escapeSelector(feedback_image[i].name)).attr(
                    "data-name"
                )
            );
            count++;
        }
        formData.append("feedback_id", feedback_id);
        formData.append("feedback_image_count", count);
        formData.append("function", "save_image_edit");
        formData.append("feedback_image_delete", feedback_image_delete);
        $.ajax({
            url: "../controllers/feedback_controller.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $("#image_edit").val(null);
                try {
                    data = JSON.parse(data);
                    if (data.status == "1") {
                        $("#modal-feedback-image-edit").modal("hide");
                        //alert
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
                    } else {
                        //clear form
                        $.alert({
                            title: "Error!",
                            content: data.error,
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

    $("#btn_save_feedback").click(function () {
        $("#form_feedback_edit").addClass("was-validated");
        var feedback_id = $("#feedback_id").val();
        var feedback_name = $("#feedback_name_edit").val();
        var feedback_content = $("#feedback_content_edit").val();
        var feedback_priority = $('#feedback_priority_edit').val();
        var image_id = $('#image_id').val();
        var feedback_status = 0;
        if ($("#feedback_status_edit").is(":checked")) {
            feedback_status = 1;
        }
        if ((feedback_name == "" || feedback_content == "" )) {
            $.alert({
                title: "Error",
                type: "red",
                typeAnimated: true,
                content: "Please fill all fields",
            });
            return;
        }
        $.ajax({
            url: "../controllers/feedback_controller.php",
            type: "POST",
            data: {
                feedback_id: feedback_id,
                feedback_name: feedback_name,
                feedback_content: feedback_content,
                feedback_priority: feedback_priority,
                image_id: image_id,
                feedback_status: feedback_status,
                function: "save_feedback_edit",
            },
            success: function (data) {
                //remove validate class
                $("#form_feedback_edit").removeClass("was-validated");
                try {
                    data = JSON.parse(data);
                    if (data.status == "1") {
                        $("#modal-feedback").modal("hide");
                        $("#table_feedback").DataTable().ajax.reload();
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
                    } else {
                        //clear form
                        $.alert({
                            title: "Error!",
                            content: data.error,
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

    $("#btn_delete_feedback").click(function () {
        var feedback_id = $("#feedback_id").val();
        //alert confirm
        $.alert({
            title: "Confirm!",
            content: "Are you sure you want to delete this feedback ?",
            type: "red",
            typeAnimated: true,
            icon: "fa fa-exclamation-circle",
            closeIcon: true,
            closeIconClass: "fa fa-close",
            animation: "zoom",
            closeAnimation: "zoom",
            animateFromElement: false,
            buttons: {
                ok: {
                    text: "OK",
                    btnClass: "btn-red",
                    action: function () {
                        $.ajax({
                            url: "../controllers/feedback_controller.php",
                            type: "POST",
                            data: {
                                feedback_id: feedback_id,
                                function: "delete_feedback",
                            },
                            success: function (data) {
                                try {
                                    data = JSON.parse(data);
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
                                if (data.status == "1") {
                                    $("#table_feedback").DataTable().ajax.reload();
                                    $("#modal-feedback").modal("hide");
                                    //alert
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
                                } else {
                                    //clear form
                                    $.alert({
                                        title: "Error!",
                                        content: data.error,
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
                    },
                },
                cancel: {
                    text: "Cancel",
                    btnClass: "btn-blue",
                },
            },
        });
    });
});
