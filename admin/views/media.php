<?php include("../includes/header.php") ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Media</h1>
        <br>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">View Media</li>
        </ol>
        <div class="row">
            <table id="table_media" class="cell-border stripe hover">
                <thead>
                    <tr>
                        <th>Index</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <br>
    <!-- Modal -->
    <div class="modal fade" id="modal-media" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit media </h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="media_id">

                    <form style="padding-bottom:20px" id="edit_form_media" action="javascript:void(0);">
                        <div class="row">
                            <div class="col">
                                <label for="name">Type</label>
                                <input class="form-control" id="edit_media_type" type="text" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="name">Value</label>
                                <input class="form-control" id="edit_media_value" type="text" placeholder="Enter value" required>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_save_edit" class="btn btn-danger">Save changes</button>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-secondary">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>

</main>

<?php include("../includes/footer.php") ?>
<script src="../admin/js/media.js"></script>