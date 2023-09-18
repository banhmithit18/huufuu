<?php include("../includes/header.php") ?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Project Detail</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Edit Project Detail</li>
        </ol>
        <div class="row">
            <div class="col-6">
                <label for="exampleFormControlSelect1">Select project</label>
                <select class="form-control" id="project_id">
                    <option id="0" selected>Select project</option>
                </select>
            </div>
        </div>
        <div class="row pt-3" id="editor-content" style="display:none">
            <class class="col-12">
                <textarea name="editor"></textarea>
            </class>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-5"></div>
        <div class="col-md-2">
            <button class="btn btn-secondary btn-lg" id="btn_save" style="width: 100px;">Lưu</button>
        </div>
        <div class="col-md-5"></div>

    </div>
    <br>
    <div class="row">
        <div style="margin-left:10px;margin-right:10px" class="col" id="return_message"></div>
    </div>
</main>

<script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
<?php include("../includes/footer.php") ?>
<script src="../js/project_detail.js"></script>