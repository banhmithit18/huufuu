<?php include("../includes/header.php") ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Feedback</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Add feedback</li>
        </ol>
        <div class="row border rounded">
            <form style="padding-bottom:20px" id="form_feedback" action="javascript:void(0);">
                <div class="row">
                    <div class="col">
                        <label for="name">Name</label>
                        <input class="form-control" id="feedback_name" type="text" placeholder="Enter feedback name" required>
                    </div>
                    <div class="col">
                        <label for="name">Priority</label>
                        <input class="form-control" value=" 1" id="feedback_priority" type="number" placeholder="Enter feedback priority" >
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="content">Content</label>
                        <textarea class="form-control" id="feedback_content" rows="2" placeholder="Enter content"></textarea>
                    </div>
                </div>
                <div class="row" style="padding-top:10px">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" checked id="feedback_status">
                            <label class="form-check-label" for="exampleCheck1">Active</label>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-top:10px">
                    <div class="col-md-6">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="feedback_image" accept="image/*" required>
                            <input type="hidden" id="feedback_image">
                            <label class="custom-file-label" id="label_image" for="customFile" name="files">Feedback Image</label>
                            <div class="invalid-feedback">Please add feedback image.</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <button class="btn btn-secondary" type="button" id="btn-preview-image" style="width:140px; height:40px;" data-toggle="modal" data-target="#modal-feedback-image" disabled>View Image</button>
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
            <li class="breadcrumb-item active">View Feedback</li>
        </ol>
        <div class="row">
            <table id="table_feedback" class="cell-border stripe hover">
                <thead>
                    <tr>
                        <th>Index</th>
                        <th>Name</th>
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
    <div class="modal fade" id="modal-feedback-image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Image </h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <input type="hidden" class="form-control" id="feedback_id">

                    <div id="carousel_image_feedback" class="carousel slide text-center" data-interval="false" data-ride="carousel">
                        <ol class="carousel-indicators">
                        </ol>
                        <div class="carousel-inner">

                        </div>
                        <a class="carousel-control-prev" href="#carousel_image_feedback" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel_image_feedback" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>

                </div>
                <div class="modal-footer">
                    <label id="blog_image_edit_label" class="btn btn-secondary">Upload <input type="file" hidden id="feedback_image_edit" accept="image/*"></label>
                    <label style ="display:none" id="blog_image_edit_label" class="btn btn-secondary">Add image <input style ="display:none" type="file" hidden id="feedback_image_add" accept="image/*"></label>

                    <button style="display:none" type="button" id="btn_delete_image" class="btn btn-danger">Delete</button>
                    <button type="button" data-dismiss="modal" aria-label="close" class="btn btn-danger">Close</button>

                </div>
            </div>
        </div>
    </div>

 <!-- Modal -->
 <div class="modal fade" id="modal-feedback-image-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Image </h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <input type="hidden" class="form-control" id="feedback_id">
                    <input type="hidden" class="form-control" id="image_edit_count">

                    <div id="carousel_image_feedback_edit" class="carousel slide text-center" data-interval="false" data-ride="carousel">
                        <ol class="carousel-indicators" id="carousel-indicators-edit">
                        </ol>
                        <div class="carousel-inner" id="carousel-inner-edit">

                        </div>
                        <a class="carousel-control-prev" href="#carousel_image_feedback_edit" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel_image_feedback_edit" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_save_image_edit" class="btn btn-secondary">Save</button>
                    <input type="file" hidden id="image_edit" accept="image/*" multiple>
                    <label id="blog_image_edit_label" class="btn btn-secondary">Upload <input type="file" hidden id="upload_image_edit" accept="image/*"></label>
                    <label style ="display:none" id="blog_image_edit_label" class="btn btn-secondary">Add image <input style ="display:none" type="file" hidden id="add_image_edit" accept="image/*" multiple></label>

                    <button style="display:none" type="button" id="btn_delete_image_edit" class="btn btn-danger">Delete</button>
                    <button type="button" data-dismiss="modal" aria-label="close" class="btn btn-danger">Close</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-feedback" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <input type="hidden" class="form-control" id="feedback_id">
                    <form style="padding-bottom:20px" id="form_feedback_edit" action="javascript:void(0);">
                        <div class="row">
                            <div class="col">
                                <label for="name">Name</label>
                                <input class="form-control" id="feedback_name_edit" type="text" placeholder="Enter feedback name" required>
                            </div>
                            <div class="col">
                        <label for="name">Priority</label>
                        <input class="form-control" id="feedback_priority_edit" type="number" placeholder="Enter feedback priority" >
                    </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="content">Content</label>
                                <textarea class="form-control" id="feedback_content_edit" rows="2" placeholder="Enter contnet"></textarea>
                            </div>
                        </div>
                        <input type="hidden" id="image_id">
                        <div class="row" style="padding-top:10px">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" checked id="feedback_status_edit">
                                    <label class="form-check-label" for="exampleCheck1">Active</label>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_save_feedback" class="btn btn-secondary">Save</button>
                    <button type="button" id="btn_delete_feedback" class="btn btn-danger">Delete</button>
                    <button type="button" data-dismiss="modal" aria-label="close" class="btn btn-danger">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>

<?php include("../includes/footer.php") ?>
<script src="../js/feedback.js"></script>