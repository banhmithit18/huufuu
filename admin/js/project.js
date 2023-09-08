window.addEventListener("DOMContentLoaded", (event) => {
    //get cateogry
    //get category
    $.ajax({
        type: "POST",
        url: "../admin/controllers/category_controller.php",
        data: {
            function: "get_category",
        },
        success: function (data) {
            try {
                data = $.parseJSON(data);
                //add category to select
                $.each(data, function (index, value) {
                    //check if status = 1 (active)
                    if (value.category_status == 1) {
                        $("#category_id").append(
                            '<option value="' +
                            value.category_id +
                            '">' +
                            value.category_name +
                            "</option>"
                        );
                        $("#category_id_edit").append(
                            '<option value="' +
                            value.category_id +
                            '">' +
                            value.category_name +
                            "</option>"
                        );
                    }
                });
            } catch (error) {
                $.alert({
                    title: "Error",
                    type: "red",
                    typeAnimated: true,
                    content: "Cannot get category, error: " + error,
                });
            }
        },
    });
    //init table
    var t = $("#table_project").DataTable({
        ajax: {
            url: "../admin/controllers/project_controller.php?function=get_project",
            dataSrc: "",
        },
        rowId: "project_id",
        columns: [
            { data: null },
            { data: "project_name" },
            { data: "category_name" },
            {
                data: "project_id",
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
                data: "project_id",
                className: "dt-body-center",
                render: function (data, type, row, meta) {
                    return (
                        "<button id=background_image_" +
                        data +
                        ' class="btn btn-sm btn-outline-success btn_edit">View</button>'
                    );
                },
            },
            {
                data: "project_status",
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
                data: "project_id",
                className: "dt-body-center",
                render: function (data, type, row) {
                    return (
                        "<button id=edit_" +
                        data +
                        ' class="btn btn-sm btn-outline-success btn_edit" data-toggle="modal" data-target="#modal-project">Edit</button>'
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
    $("#project_background_image").change(function () {
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
                    $('#background-image-preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(f);
            }
            //show image preview modal
            if (flag == true) {
                //enable button preview image
                $("#btn-preview-background-image").removeAttr("disabled");
                $("#modal-project_background-image").modal("show");
            }
        });
    });


    //show image preview
    $("#project_image").change(function () {
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
                        '" width="400px" height="400px"></div>'
                    ).appendTo(".carousel-inner");
                    $(
                        '<li data-target="#carousel_image_project" data-slide-to="' +
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
                $("#modal-project-image").modal("show");
            }
        });
        //set last image id
        $("#project_image_count").val(count);
    });
    //show image preview
    $("#project_image_add").change(function () {
        var last_image_id = $("#project_image_count").val();
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
                        '" width="400px" height="400px"></div>'
                    ).appendTo(".carousel-inner");
                    $(
                        '<li data-target="#carousel_image_project" id"c-indi_' +
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
        var input_image = $("#project_image");
        var input_add_image = $("#project_image_add");
        const files_image = getFiles(input_image[0]);
        const files_add_image = getFiles(input_add_image[0]);
        //Add new image to input
        files_image.push(...files_add_image);
        //change input image
        input_image = setFiles(input_image[0], files_image);
        $("#project_image_count").val(count);
    });

    //event delete background_image
    $('#btn_delete_background_image').click(function () {
        //clear input
        $('#project_background_image').val("");
        //clear preview
        $("#background-image-preview").attr("src", "");
        //hide modal
        $('#modal-project_background-image').modal('hide');
        //set preview to false
        $('#btn-preview-background-image').prop("disabled", true);
    })
    //event delete background_image
    $('#btn_delete_background_image_edit').click(function () {
        //clear input
        $('#upload_background_image_edit').val("");
        //clear preview
        $("#background-image-preview-edit").attr('src', 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==');
    })
    //delete current image
    $("#btn_delete_image").click(function () {
        var count = $("#project_image_count").val();

        //get current active image
        var current_image = $(".carousel-item.active img");
        //get current image id
        var current_image_id = current_image.attr("id");
        current_image_id = current_image_id.replace("c-item_", "");
        //get current input
        var input_image = $("#project_image");
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
        $("#project_image_count").val(files_image.length);
        //set active image
        $(".carousel-item").first().addClass("active");
        $(".carousel-indicators > li").first().addClass("active");
        $(".carousel").carousel();
        $("#project_image_count").val(count - 1);
    });
    //change image
    $("#project_image_edit").change(function () {
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
                    $("#project_image_edit").val("");
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
            var input_image = $("#project_image");
            var input_edit_image = $("#project_image_edit");
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
    //start add project
    $("#btn_save").click(function () {
        //add class validate
        $("#form_project").addClass("was-validated");
        //get data
        var project_name = $("#project_name").val();
        var project_content = $("#project_content").val();
        var project_image = getFiles($("#project_image")[0]);
        var project_background_image = $("#project_background_image ").prop('files')[0];
        var project_status = 0;
        var category_id = $("#category_id").find(":selected").val();

        if (category_id == "0") {
            $.alert({
              title: "Error",
              type: "red",
              typeAnimated: true,
              content: "Please select category",
            });
            return;
          }
        if ($("#project_status").is(":checked")) {
            project_status = 1;
        }
        if ((project_name == "", project_image == "")) {
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
        formData.append("project_name", project_name);
        formData.append("project_content", project_content);
        formData.append("project_status", project_status);
        formData.append("category_id", category_id);
        formData.append("project_background_image", project_background_image);
        formData.append("function", "add_project");
        var project_image_count = 0;
        for (var i = 0; i < project_image.length; i++) {
            formData.append("project_image_" + i, project_image[i]);
            project_image_count++;
        }
        formData.append("project_image_count", project_image_count);

        //send data
        $.ajax({
            type: "POST",
            url: "../admin/controllers/project_controller.php",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                try {
                    console.log(data)
                    data = JSON.parse(data);
                    if (data.status == "1") {
                        //clear form
                        $("#project_name").val("");
                        $("#project_content").val("");
                        $("#project_image").val("");
                        //disable button
                        $("#btn_preview_image").attr("disabled", true);
                        $("#form_project").removeClass("was-validated");
                        //reload table
                        $("#table_project").DataTable().ajax.reload();

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
                        $("#project_name").val("");
                        $("#project_content").val("");
                        $("#project_image").val(null);
                        $("#btn_preview_image").attr("disabled", true);
                        $("#form_project").removeClass("was-validated");
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
        return false;
    });
    //end start add project
    //start edit project

    $("#table_project").on("click", "button", function () {
        //get this row data
        var table = $("#table_project").DataTable();
        var data = table.row($(this).parents("tr")).data();
        //set blog id
        $("#project_id").val(data.project_id);
        //get clicked button
        var id = this.id;
        //split first underscore
        var id_split = id.split("_");
        if (id_split[0] == "edit") {
            $('#image_id').val(data.image_id);
            $('#background_image_id').val(data.backgroud_image_id);
            $("#project_name_edit").val(data.project_name);
            $("#project_content_edit").val(data.project_content);
            $("#category_id_edit").val(data.category_id);
            if (data.project_status == "0") {
                $("#edit_project_status").prop("checked", false);
            } else {
                $("#edit_project_status").prop("checked", true);
            }
        }
        if (id_split[0] == "background") {
            $.ajax({
                type: "POST",
                url: "../admin/controllers/project_controller.php",
                data: {
                    project_id: data.project_id,
                    function: "get_background_image",
                },
                success: function (data) {
                    try {
                        data = $.parseJSON(data);
                        console.log(data)
                        if (data != "") {
                            var dataTransfer = new DataTransfer();
                            let image_name = data[0].image_path.split("/");
                            image_name = image_name[image_name.length - 1];
                            let image_extension = image_name.split(".");
                            image_extension =
                                "image/" + image_extension[image_extension.length - 1];
                            loadURLToInputFiled(
                                data[0].image_path,
                                image_name,
                                image_extension,
                                dataTransfer,
                                "background"

                            );
                            $('#background-image-preview-edit').attr('src', data[0].image_path);

                        }

                        $("#modal-project_background-image-edit").modal("show");
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
        if (id_split[0] == "image") {
            project_image_delete = [];
            $.ajax({
                type: "POST",
                url: "../admin/controllers/project_controller.php",
                data: {
                    project_id: data.project_id,
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
                                dataTransfer,
                                "image"
                            );
                            //create carousel inner
                            $(
                                '<div class="carousel-item image_edit"><img src="' +
                                data[i].image_path +
                                '" data-name ="' +
                                data[i].project_image_id +
                                '" id="project_image_id_' +
                                image_name +
                                '" width="400px" height="400px"></div>'
                            ).appendTo("#carousel-inner-edit");
                            $(
                                '<li data-target="#carousel_image_project" class="image_edit" data-slide-to="' +
                                count +
                                '"></li>'
                            ).appendTo("#carousel-indicators-edit");
                            count++;
                        }
                        $("#image_edit_count").val(count);
                        $(".carousel-item.image_edit").first().addClass("active");
                        $("#carousel-indicators-edit > li").first().addClass("active");
                        $(".carousel").carousel();
                        $("#modal-project-image-edit").modal("show");
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
    function loadURLToInputFiled(url, name, ext, dataTransfer, type) {
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
            if (type != "background") {
                document.querySelector("#image_edit").files = dataTransfer.files;
            } else {
                document.querySelector("#upload_background_image_edit").files = dataTransfer.files;
            }

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
                $("#project_image_edit").val("");
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
                "project_image_id_" + new_image.name
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

    //add edit image background
    $("#upload_background_image_edit").change(function () {
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
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#background-image-preview-edit').attr('src', e.target.result);
                };
                reader.readAsDataURL(f);
            }
        });
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
                        '" id="project_image_id_' +
                        f.name +
                        '" width="400px" height="400px"></div>'
                    ).appendTo("#carousel-inner-edit");
                    $(
                        '<li data-target="#carousel_image_project" class="image_edit" id"project_image_edit_' +
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
        var project_image_id = $(".carousel-item.image_edit.active img").attr(
            "data-name"
        );
        project_image_delete.push(project_image_id);
        //get current image id
        var current_image_id = current_image.attr("id");
        current_image_id = current_image_id.replace("project_image_edit_", "");
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
        $("#project_image_count").val(files_image.length);
        //set active image
        $(".carousel-item.image_edit").first().addClass("active");
        $(".carousel-indicators.image_edit > li").first().addClass("active");
        $(".carousel").carousel();
        $("#image_edit_count").val(count - 1);
    });
    $("#btn_save_image_edit").click(function () {
        var formData = new FormData();
        var count = 0;
        var project_id = $("#project_id").val();
        var project_image = getFiles($("#image_edit")[0]);
        for (var i = 0; i < project_image.length; i++) {
            formData.append("project_image_" + i, project_image[i]);
            //get data attribute
            formData.append(
                "project_image_id_" + i,
                $("#project_image_id_" + $.escapeSelector(project_image[i].name)).attr(
                    "data-name"
                )
            );
            count++;
        }
        formData.append("project_id", project_id);
        formData.append("project_image_count", count);
        formData.append("function", "save_image_edit");
        formData.append("project_image_delete", project_image_delete);
        $.ajax({
            url: "../admin/controllers/project_controller.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $("#image_edit").val(null);
                try {
                    data = JSON.parse(data);
                    if (data.status == "1") {
                        $("#modal-project-image-edit").modal("hide");
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

    $("#btn_save_background_image_edit").click(function () {
        var formData = new FormData();
        var project_id = $("#project_id").val();
        let project_image_input = $("#upload_background_image_edit")[0];
        let project_image = project_image_input.files[0];
        if (project_image == undefined) {
            project_image = null
        }
        console.log(project_image)
        formData.append("project_id", project_id);
        formData.append("function", "save_background_image_edit");
        formData.append("project_background_image", project_image);
        $.ajax({
            url: "../admin/controllers/project_controller.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $("#background_image_edit").val(null);
                try {
                    console.log(data)
                    data = JSON.parse(data);
                    if (data.status == "1") {

                        $("#modal-project_background-image-edit").modal("hide");
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

    $("#btn_save_project").click(function () {
        $("#form_project_edit").addClass("was-validated");
        var project_id = $("#project_id").val();
        var project_name = $("#project_name_edit").val();
        var project_content = $("#project_content_edit").val();
        var image_id = $('#image_id').val();
        var background_image_id = $('#background_image_id').val();
        var category_id = $("#category_id_edit").find(":selected").val();

        var project_status = 0;
        if ($("#project_status_edit").is(":checked")) {
            project_status = 1;
        }
        if ((project_name == "" || project_content == "")) {
            $.alert({
                title: "Error",
                type: "red",
                typeAnimated: true,
                content: "Please fill all fields",
            });
            return;
        }
        $.ajax({
            url: "../admin/controllers/project_controller.php",
            type: "POST",
            data: {
                project_id: project_id,
                project_name: project_name,
                project_content: project_content,
                image_id: image_id,
                background_image_id: background_image_id,
                project_status: project_status,
                category_id:category_id,
                function: "save_project_edit",
            },
            success: function (data) {
                //remove validate class
                $("#form_project_edit").removeClass("was-validated");
                try {
                    data = JSON.parse(data);
                    if (data.status == "1") {
                        $("#modal-project").modal("hide");
                        $("#table_project").DataTable().ajax.reload();
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

    $("#btn_delete_project").click(function (e) {
        e.preventDefault();
        var project_id = $("#project_id").val();
        //alert confirm
        $.alert({
            scrollToPreviousElement: false,
            scrollToPreviousElementAnimate: false,
            title: "Confirm!",
            content: "Are you sure you want to delete this project ?",
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
                            url: "../admin/controllers/project_controller.php",
                            type: "POST",
                            data: {
                                project_id: project_id,
                                function: "delete_project",
                            },
                            success: function (data) {
                                try {
                                    data = JSON.parse(data);
                                } catch (e) {
                                    $.alert({
                                        scrollToPreviousElement: false,
                                        scrollToPreviousElementAnimate: false,
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
                                    $("#table_project").DataTable().ajax.reload();
                                    $("#modal-project").modal("hide");
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
                                                action: function () {
                                                    //Changed to body and added stop
                                                    $('body').stop().animate({
                                                        scrollTop: $('#voters_guide_form').offset().top
                                                    }, 500);
                                                }

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
    return false;
});
