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
        <div class="row pt-3" id="project-detail-content-wrapper" style="display:none">

            <form style="padding-bottom:20px" id="form_project_detail" action="javascript:void(0);">
                <div class="row">
                    <div class="col-md-6">
                        <label for="priority">Priority</label>
                        <input type="number" class="form-control" id="project_detail_priority" placeholder="Enter priority" value="0" pattern="[0-9]+" required>
                    </div>
                    <div class="col-md-6">
                        <label for="category>">Type</label>
                        <select class="form-control" id="project_detail_type">
                            <option value="0">Text</option>
                            <option value="1">Image</option>
                        </select>
                    </div>
                </div>

                <div class="row" style="padding-top:10px">
                    <div class="col">
                        <textarea name="editor1" class="form-control"></textarea>
                    </div>
                </div>

                <div class="row" style="padding-top:10px">
                    <div class="col-md-6">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="project_detail_image" accept="image/*">
                            <input type="hidden" id="project_detail_image">
                            <label class="custom-file-label" id="label_image" for="customFile" name="file">Image</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <button class="btn btn-secondary" type="button" id="btn-preview-image" style="width:140px; height:38px;" data-toggle="modal" data-target="#modal-proejct-detail-image" disabled>View Image</button>
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top:10px">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" checked id="project_detail_status">
                            <label class="form-check-label" for="exampleCheck1">Active</label>
                        </div>
                    </div>
                    <div class="col-md-6" style="display:none">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="project_detail_isSameRow">
                            <label class="form-check-label" for="exampleCheck1">Same row</label>
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-bottom:0px;padding-top:10px">
                    <div class="col" style="text-align:center">
                        <button class="btn btn-secondary btn-lg" id="btn_save" style="width: 100px;">Save</button>
                    </div>
                </div>
            </form>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">View Detail</li>
            </ol>
            <div class="row">
                <table id="table_project_detail" class="cell-border stripe hover">
                    <thead>
                        <tr>
                            <th>Index</th>
                            <th>Type</th>
                            <th>Priority</th>
                            <th>Image</th>
                            <th>Text</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <br>
</main>

<!-- Modal -->
<div class="modal fade" id="modal-project-detail-text-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
                <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="row" style="padding-top:10px">
                    <div class="col">
                        <label for="name">Text</label>
                        <textarea name="editor1_edit" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_text_edit" class="btn btn-secondary">Save</button>
                <button type="button" data-dismiss="modal" aria-label="close" class="btn btn-danger">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-proejct-detail-image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Image </h5>
                <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <input type="hidden" class="form-control" id="project_detail_id">

                <div id="carousel_image_project_detail" class="carousel slide text-center" data-interval="false" data-ride="carousel">
                    <ol class="carousel-indicators">
                    </ol>
                    <div class="carousel-inner">

                    </div>
                    <a class="carousel-control-prev" href="#carousel_image_project_detail" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel_image_project_detail" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-project-detail-image-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Image </h5>
                <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div id="carousel_image_project_detail_edit" class="carousel slide text-center" data-interval="false" data-ride="carousel">
                    <ol class="carousel-indicators" id="carousel-indicators-edit">
                    </ol>
                    <div class="carousel-inner" id="carousel-inner-edit">

                    </div>
                    <a class="carousel-control-prev" href="#carousel_image_project_detail_edit" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel_image_project_detail_edit" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_image_edit" class="btn btn-secondary">Save</button>
                <input type="file" hidden id="image_edit" accept="image/*">
                <label id="project_detail_image_edit_label" class="btn btn-secondary">Upload <input type="file" hidden id="upload_image_edit" accept="image/*"></label>
                <!-- <label id="blog_image_edit_label" class="btn btn-secondary">Add image <input type="file" hidden id="add_image_edit" accept="image/*" multiple></label> -->
                <button type="button" data-dismiss="modal" aria-label="close" class="btn btn-danger">Close</button>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.ckeditor.com/4.19.1/full/ckeditor.js"></script>
<?php include("../includes/footer.php") ?>
<script src="../js/project_detail.js"></script>