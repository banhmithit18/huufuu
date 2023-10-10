<?php  include("../includes/header.php") ?>

                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">About us</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Edit About us content</li>
                        </ol>
                        <div class="row">                                                 
                        <textarea name="editor"></textarea>
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
<?php  include("../includes/footer.php") ?>
<script src="../admin/js/about_us_js.js"></script>

