<?php include("../includes/header.php") ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Service</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Add service</li>
        </ol>
        <div class="row border rounded">
            <form style="padding-bottom:20px" id="form_service" action="javascript:void(0);">
                <div class="row">
                    <div class="col">
                        <label for="name">Name</label>
                        <input class="form-control" id="service_name" type="text" placeholder="Enter service name" required>
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
                        <label for="description">Description</label>
                        <textarea class="form-control" id="service_description" rows="2" placeholder="Enter description"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="priority">priority</label>
                        <input type="number" class="form-control" id="service_priority" placeholder="Enter priority" value="1" pattern="[0-9]+" required>
                        <div class="invalid-feedback">Please enter number only</div>
                    </div>
                </div>
                <div class="row" style="padding-top:10px">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" checked id="service_status">
                            <label class="form-check-label" for="exampleCheck1">Active</label>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-top:10px">
                    <div class="col-md-6">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="service_image" accept="image/*" multiple required>
                            <input type="hidden" id="service_image">
                            <label class="custom-file-label" id="label_image" for="customFile" name="files[]">Service Image</label>
                            <div><small>Note: Images will be sort by index, the first will be the service thumb image!</small></div>
                            <div class="invalid-feedback">Please add service image.</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <button class="btn btn-secondary" type="button" id="btn-preview-image" style="width:140px; height:40px;" data-toggle="modal" data-target="#modal-service-image" disabled>View Image</button>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-top:60px">
                    <div class="col">
                        <label>Service detail</label>
                        <button id="add_input" type="button" style="border:none;background-color:transparent"><i class="bi bi-plus-square-fill"></i></button>
                        <button id="delete_input" type="button" style="border:none;background-color:transparent"><i class="bi bi-dash-square-fill"></i></button>
                        <form id="service_detail">
                            <input type="hidden" id="service_detail_count" value="0">
                            <div id="detail">

                            </div>
                        </form>
                    </div>
                </div>


                <div class="row" style="padding-bottom:10px">
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
            <li class="breadcrumb-item active">View service</li>
        </ol>
        <div class="row">
            <table id="table_service" class="cell-border stripe hover">
                <thead>
                    <tr>
                        <th>Index</th>
                        <th>Name</th>
                        <th>Priority</th>
                        <th>Image</th>
                        <th>Detail</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <br>



    <!-- Modal -->
    <div class="modal fade" id="modal-service-image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Image </h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <input type="hidden" class="form-control" id="service_id">

                    <div id="carousel_image_service" class="carousel slide text-center" data-interval="false" data-ride="carousel">
                        <ol class="carousel-indicators">
                        </ol>
                        <div class="carousel-inner">

                        </div>
                        <a class="carousel-control-prev" href="#carousel_image_service" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel_image_service" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>

                </div>
                <div class="modal-footer">
                    <label id="blog_image_edit_label" class="btn btn-secondary">Upload <input type="file" hidden id="service_image_edit" accept="image/*"></label>
                    <label id="blog_image_edit_label" class="btn btn-secondary">Add image <input type="file" hidden id="service_image_add" accept="image/*" multiple></label>

                    <button type="button" id="btn_delete_image" class="btn btn-danger">Delete</button>
                    <button type="button" data-dismiss="modal" aria-label="close" class="btn btn-danger">Close</button>

                </div>
            </div>
        </div>
    </div>

 <!-- Modal -->
 <div class="modal fade" id="modal-service-image-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Image </h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <input type="hidden" class="form-control" id="service_id">
                    <input type="hidden" class="form-control" id="image_edit_count">

                    <div id="carousel_image_service_edit" class="carousel slide text-center" data-interval="false" data-ride="carousel">
                        <ol class="carousel-indicators" id="carousel-indicators-edit">
                        </ol>
                        <div class="carousel-inner" id="carousel-inner-edit">

                        </div>
                        <a class="carousel-control-prev" href="#carousel_image_service_edit" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel_image_service_edit" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_save_image_edit" class="btn btn-secondary">Save</button>
                    <input type="file" hidden id="image_edit" accept="image/*" multiple>
                    <label id="blog_image_edit_label" class="btn btn-secondary">Upload <input type="file" hidden id="upload_image_edit" accept="image/*"></label>
                    <label id="blog_image_edit_label" class="btn btn-secondary">Add image <input type="file" hidden id="add_image_edit" accept="image/*" multiple></label>

                    <button type="button" id="btn_delete_image_edit" class="btn btn-danger">Delete</button>
                    <button type="button" data-dismiss="modal" aria-label="close" class="btn btn-danger">Close</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-service" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <input type="hidden" class="form-control" id="service_id">
                    <form style="padding-bottom:20px" id="form_service_edit" action="javascript:void(0);">
                        <div class="row">
                            <div class="col">
                                <label for="name">Name</label>
                                <input class="form-control" id="service_name_edit" type="text" placeholder="Enter service name" required>
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
                                <label for="description">Description</label>
                                <textarea class="form-control" id="service_description_edit" rows="2" placeholder="Enter description"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="priority">Priority</label>
                                <input type="number" class="form-control" id="service_priority_edit" placeholder="Enter priority" value="1" pattern="[0-9]+" required>
                                <div class="invalid-feedback">Please enter number only</div>
                            </div>
                        </div>
                        <div class="row" style="padding-top:10px">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" checked id="service_status_edit">
                                    <label class="form-check-label" for="exampleCheck1">Active</label>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_save_service" class="btn btn-secondary">Save</button>
                    <button type="button" id="btn_delete_service" class="btn btn-danger">Delete</button>
                    <button type="button" data-dismiss="modal" aria-label="close" class="btn btn-danger">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-service-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit detail </h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>                        
                <div class="modal-body ">
                    <button id="add_input_edit" type="button" style="border:none;background-color:transparent"><i class="bi bi-plus-square-fill"></i></button>
                    <button id="delete_input_edit" type="button" style="border:none;background-color:transparent"><i class="bi bi-dash-square-fill"></i></button>                  
                    <input type="hidden" class="form-control" id="service_id">
                    <form style="padding-bottom:20px" id="form_service_edit" action="javascript:void(0);">
                        <input type="hidden" id="service_detail_count_edit" value="0">
                            <div id="detail_edit">
                            </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_save_detail" class="btn btn-secondary">Save</button>
                    <button type="button" data-dismiss="modal" aria-label="close" class="btn btn-danger">Close</button>
                </div>
            </div>
        </div>
    </div>

</main>

<?php include("../includes/footer.php") ?>
<script src="../js/service.js"></script>