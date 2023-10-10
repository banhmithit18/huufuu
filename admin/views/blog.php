<?php include("../includes/header.php") ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">blog</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Add blog</li>
        </ol>
        <div class="row border rounded">
            <form style="padding-bottom:20px" id="form_blog" action="javascript:void(0);">
                <div class="row">
                    <div class="col">
                        <label for="title">Title</label>
                        <input class="form-control" id="blog_title" type="text" placeholder="Enter title" required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="blog_image" accept="image/*" required>
                            <label class="custom-file-label" id="label_image" for="customFile">Upload blog's thumb image</label>
                            <div class="invalid-feedback">Please add thumb image.</div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <label for="priority">priority</label>
                        <input type="number" class="form-control" id="blog_priority" placeholder="Enter priority" value="1" pattern="[0-9]+" required>
                        <div class="invalid-feedback">Please enter number only</div>
                    </div>
                </div>
                <div class="row" style="padding-top:10px">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" checked id="blog_status">
                            <label class="form-check-label" for="exampleCheck1">Active</label>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <label>Blog content</label>
                        <textarea name="editor"></textarea>
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
            <li class="breadcrumb-item active">View blog</li>
        </ol>
        <div class="row">
            <table id="table_blog" class="cell-border stripe hover">
                <thead>
                    <tr>
                        <th>Index</th>
                        <th>Title</th>
                        <th>Priority</th>
                        <th>Thumb image</th>
                        <th>Content</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <br>
    <!-- Modal -->
    <div class="modal fade" id="modal-blog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit blog </h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="blog_id">
                    <form style="padding-bottom:20px" id="form_blog_edit" action="javascript:void(0);">
                        <div class="row">
                            <div class="col">
                                <label for="title">Title</label>
                                <input class="form-control" id="edit_blog_title" type="text" placeholder="Enter title" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="priority">priority</label>
                                <input type="number" class="form-control" id="edit_blog_priority" placeholder="Enter priority" value="1" pattern="[0-9]+" required>
                                <div class="invalid-feedback">Please enter number only</div>
                            </div>
                        </div>
                        <div class="row" style="padding-top:10px">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" checked id="edit_blog_status">
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
                    <img id="image_upload_view" src="" alt="" style="width:100%;" >
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_update_image" data-dismiss="modal" aria-label="close" class="btn btn-secondary">Save</button>
                    <label id="blog_image_edit_label" class="btn btn-secondary">Upload <input type="file" hidden id="blog_image_edit" accept="image/*"></label> 
                    <button type="button" data-dismiss="modal" aria-label="close" class="btn btn-danger">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal show blog content -->
    <div class="modal fade" id="modal-upload-editor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Content</h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="content_id">
                    <textarea id="editor_upload_view"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_update_content" class="btn btn-secondary">Update</button>
                    <button type="button" data-dismiss="modal" aria-label="close" class="btn btn-danger">Close</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.ckeditor.com/4.19.1/full/ckeditor.js"></script>
<?php include("../includes/footer.php") ?>
<script src="../admin/js/blog.js"></script>