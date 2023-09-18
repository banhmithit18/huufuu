<?php include("../includes/header.php") ?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Image</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">View image</li>
        </ol>
        <div class="row">
            <table id="table_image" class="cell-border stripe hover">
                <thead>
                    <tr>
                        <th>Index</th>
                        <th>Path</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>View</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <br>
</main>

<div class="modal fade" id="image_view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View image</h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="image_view_div" src="" alt="" style="width:100%;" >
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" aria-label="close" class="btn btn-danger">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php include("../includes/footer.php") ?>
<script src="../admin/js/image.js"></script>