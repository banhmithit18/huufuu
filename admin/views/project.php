<?php include("../includes/header.php") ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Project</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Add project</li>
        </ol>
        <div class="row border rounded">
            <form style="padding-bottom:20px" id="form_project" action="javascript:void(0);">
                <div class="row">
                    <div class="col">
                        <label for="name">Name</label>
                        <input class="form-control" id="project_name" type="text" placeholder="Enter project name" required>
                    </div>
                    <div class="col">
                        <label for="category>">Category</label>
                        <select class="form-control" id="category_id">
                            <option value="0">Select category</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="content">Content</label>
                        <textarea class="form-control" id="project_content" rows="2" placeholder="Enter content"></textarea>
                    </div>
                </div>
                <div class="row" style="padding-top:10px">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" checked id="project_status">
                            <label class="form-check-label" for="exampleCheck1">Active</label>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-top:10px">
                    <div class="col-md-6">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="project_image" accept="image/*" required>
                            <input type="hidden" id="project_image">
                            <label class="custom-file-label" id="label_image" for="customFile" name="files">Project Image</label>
                            <div class="invalid-feedback">Please add project image.</div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <button class="btn btn-secondary" type="button" id="btn-preview-image" style="width:140px; height:40px;" data-toggle="modal" data-target="#modal-project-image" disabled>View Image</button>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-top:10px">
                    <div class="col-md-6">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="project_background_image" accept="image/*">
                            <label class="custom-file-label" id="label_image" for="customFile" name="files">Background Project Image</label>
                            <div><small>Note: if not input, black background will be shown</small></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <button class="btn btn-secondary" type="button" id="btn-preview-background-image" style="width:140px; height:40px;" data-toggle="modal" data-target="#modal-project_background-image" disabled>View Image</button>
                        </div>
                    </div>
                </div>


                <div class="row pt-5" style="padding-bottom:10px">
                    <div class="col-md-5"></div>
                    <div class="col-md-2">
                        <button class="btn btn-secondary btn-lg" id="btn_save" style="width: 100px;">Save</button>
                    </div>
                    <div class="col-md-5"></div>
                </div>
                <br>
                <br>
            </form>
        </div>
        <br>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">View Project</li>
        </ol>
        <div class="row">
            <table id="table_project" class="cell-border stripe hover">
                <thead>
                    <tr>
                        <th>Index</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Image background</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <br>



    <!-- Modal -->
    <div class="modal fade" id="modal-project-image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Image </h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <input type="hidden" class="form-control" id="project_id">

                    <div id="carousel_image_project" class="carousel slide text-center" data-interval="false" data-ride="carousel">
                        <ol class="carousel-indicators">
                        </ol>
                        <div class="carousel-inner">

                        </div>
                        <a class="carousel-control-prev" href="#carousel_image_project" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel_image_project" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>

                </div>
                <div class="modal-footer">
                    <label id="blog_image_edit_label" class="btn btn-secondary">Upload <input type="file" hidden id="project_image_edit" accept="image/*"></label>
                    <label style="display:none" id="blog_image_edit_label" class="btn btn-secondary">Add image <input style="display:none" type="file" hidden id="project_image_add" accept="image/*"></label>

                    <button style="display:none" type="button" id="btn_delete_image" class="btn btn-danger">Delete</button>
                    <button type="button" data-dismiss="modal" aria-label="close" class="btn btn-danger">Close</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-project_background-image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Image </h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <input type="hidden" class="form-control" id="project_id">

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <img style="width:400px;height:400px" class=" mx-auto d-block" src="" alt="" id="background-image-preview" onerror="this.style.display='none'">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_delete_background_image" class="btn btn-secondary">Delete</button>
                    <button type="button" data-dismiss="modal" aria-label="close" class="btn btn-danger">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-project_background-image-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Image </h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <input type="hidden" class="form-control" id="project_id">

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <img style="width:400px;height:400px" class="mx-auto d-block" src="" id="background-image-preview-edit" alt="">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_save_background_image_edit" class="btn btn-secondary">Save</button>
                    <button type="button" id="btn_delete_background_image_edit" class="btn btn-secondary">Delete</button>
                    <label id="blog_image_edit_label" class="btn btn-secondary">Upload <input type="file" hidden id="upload_background_image_edit" accept="image/*"></label>
                    <button type="button" data-dismiss="modal" aria-label="close" class="btn btn-danger">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-project-image-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Image </h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <input type="hidden" class="form-control" id="project_id">
                    <input type="hidden" class="form-control" id="image_edit_count">

                    <div id="carousel_image_project_edit" class="carousel slide text-center" data-interval="false" data-ride="carousel">
                        <ol class="carousel-indicators" id="carousel-indicators-edit">
                        </ol>
                        <div class="carousel-inner" id="carousel-inner-edit">

                        </div>
                        <a class="carousel-control-prev" href="#carousel_image_project_edit" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel_image_project_edit" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_save_image_edit" class="btn btn-secondary">Save</button>
                    <input type="file" hidden id="image_edit" accept="image/*" multiple>
                    <label id="blog_image_edit_label" class="btn btn-secondary">Upload <input type="file" hidden id="upload_image_edit" accept="image/*"></label>
                    <label style="display:none" id="blog_image_edit_label" class="btn btn-secondary">Add image <input style="display:none" type="file" hidden id="add_image_edit" accept="image/*" multiple></label>

                    <button style="display:none" type="button" id="btn_delete_image_edit" class="btn btn-danger">Delete</button>
                    <button type="button" data-dismiss="modal" aria-label="close" class="btn btn-danger">Close</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-project" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <input type="hidden" class="form-control" id="project_id">
                    <form style="padding-bottom:20px" id="form_project_edit" action="javascript:void(0);">
                        <div class="row">
                            <div class="col">
                                <label for="name">Name</label>
                                <input class="form-control" id="project_name_edit" type="text" placeholder="Enter project name" required>
                            </div>
                            <div class="col">
                                <label for="category>">Category</label>
                                <select class="form-control" id="category_id_edit">
                                    <option value="0">Select category</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="content">Content</label>
                                <textarea class="form-control" id="project_content_edit" rows="2" placeholder="Enter contnet"></textarea>
                            </div>
                        </div>
                        <input type="hidden" id="image_id">
                        <input type="hidden" id="background_image_id">

                        <div class="row" style="padding-top:10px">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" checked id="project_status_edit">
                                    <label class="form-check-label" for="exampleCheck1">Active</label>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_save_project" class="btn btn-secondary">Save</button>
                    <button type="button" id="btn_delete_project" class="btn btn-danger">Delete</button>
                    <button type="button" data-dismiss="modal" aria-label="close" class="btn btn-danger">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>

<?php include("../includes/footer.php") ?>
<script src="../js/project.js"></script>