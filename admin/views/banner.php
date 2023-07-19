<?php include("../includes/header.php") ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Banner</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Add banner</li>
        </ol>
        <div class="row border rounded">
            <form style="padding-bottom:20px" id="form_banner" action="javascript:void(0);">
                <div class="row">
                    <div class="col-6">
                        <label for="title">Title</label>
                        <input class="form-control" id="banner_title" type="text" placeholder="Enter title" required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="col-6">
                        <label for="title">Type</label>
                        <select class="form-control" id="banner_type">
                            <option value='0'>Select type</option>
                            <option value='1'>Banner</option>
                            <option value='2'>Quote</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-6">
                        <label for="image">Image</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="banner_image" accept="image/*" required>
                            <label class="custom-file-label" id="label_image" for="customFile">Upload banner image</label>
                            <div class="invalid-feedback">Please add image.</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="priority">Priority</label>
                        <input type="number" class="form-control" id="banner_priority" placeholder="Enter priority" value="1" pattern="[0-9]+" required>
                        <div class="invalid-feedback">Please enter number only</div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <label for="">Link</label>
                        <input class="form-control" id="banner_link" type="text" placeholder="Enter link" required>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <label for="">Content</label>
                        <textarea class="form-control" id="banner_content" rows="3"></textarea>
                    </div>
                </div>
                <div class="row" style="padding-top:10px">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" checked id="banner_status">
                            <label class="form-check-label" for="exampleCheck1">Active</label>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-5"></div>
                    <div class="col-md-2">
                        <button class="btn btn-secondary btn-lg" id="btn_save" style="width: 100px;">Save</button>
                    </div>
                    <div class="col-md-5"></div>
                </div>
                <br>
                <div class="row">
                    <div style="margin-left:10px;margin-right:10px" class="col" id="return_message"></div>
                </div>
            </form>
        </div>
        <br>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">View banner</li>
        </ol>
        <div class="row">
            <table id="table_banner" class="cell-border stripe hover">
                <thead>
                    <tr>
                        <th>Index</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Priority</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <br>
    <!-- Modal -->
    <div class="modal fade" id="modal-banner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit banner </h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="banner_id">
                    <form style="padding-bottom:20px" id="form_banner_edit" action="javascript:void(0);">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="title">Title</label>
                                <input class="form-control" id="edit_banner_title" type="text" placeholder="Enter title" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="title">Type</label>
                                <select class="form-control" id="edit_banner_type">
                                    <option value='1'>Banner</option>
                                    <option value='2'>Quote</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="priority">Priority</label>
                                <input type="number" class="form-control" id="edit_banner_priority" placeholder="Enter priority" value="1" pattern="[0-9]+" required>
                                <div class="invalid-feedback">Please enter number only</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="">Link</label>
                                <input class="form-control" id="edit_banner_link" type="text" placeholder="Enter link" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="">Content</label>
                                <textarea class="form-control" id="edit_banner_content" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row" style="padding-top:10px">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" checked id="edit_banner_status">
                                    <label class="form-check-label" for="exampleCheck1">Active</label>
                                </div>
                            </div>
                        </div>
                        <br>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_save_edit" class="btn btn-secondary">Save changes</button>
                    <button type="button" id="btn_delete" class="btn btn-danger">Delete</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal show image upload -->
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
                    <img id="image_upload_view" src="" alt="" style="width:100%;">
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_update_image" data-dismiss="modal" aria-label="close" class="btn btn-secondary">Save</button>
                    <label id="banner_image_edit_label" class="btn btn-secondary">Upload <input type="file" hidden id="banner_image_edit" accept="image/*"></label>
                    <button type="button" data-dismiss="modal" aria-label="close" class="btn btn-danger">Close</button>
                </div>
            </div>
        </div>
    </div>

</main>

<?php include("../includes/footer.php") ?>
<script src="../js/banner.js"></script>