<?php include("../includes/header.php") ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Logo</h1>
        <br>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">View logo</li>
        </ol>
        <div class="row">
            <table id="table_logo" class="cell-border stripe hover">
                <thead>
                    <tr>
                        <th>Index</th>
                        <th>Type</th>
                        <th>Image</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <br>
    <div class="modal fade" id="modal-upload-image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View image</h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="image_id">
                    <img id="image_upload_view" src="" alt="" style="width:100%;" >
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_update_image" data-dismiss="modal" aria-label="close" class="btn btn-secondary">Save</button>
                    <label id="logo_image_edit_label" class="btn btn-secondary">Upload <input type="file" hidden id="logo_image_edit" accept="image/*"></label> 
                    <button type="button" data-dismiss="modal" aria-label="close" class="btn btn-danger">Close</button>
                </div>
            </div>
        </div>
    </div>

</main>

<?php include("../includes/footer.php") ?>
<script src="../js/logo.js"></script>