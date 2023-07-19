<?php include("../includes/header.php") ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Category</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Add category</li>
        </ol>
        <div class="row border rounded">
            <form style="padding-bottom:20px" id="form_category" action="javascript:void(0);">
                <div class="row">
                    <div class="col">
                        <label for="question">Name</label>
                        <input type="text" class="form-control" id="category_name" placeholder="Enter category's name" required>
                    </div>
                </div>
                <div class="row" style="padding-top:10px">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" checked id="category_status">
                            <label class="form-check-label" for="exampleCheck1">Active</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5"></div>
                    <div class="col-md-2">
                        <button class="btn btn-secondary btn-lg" id="btn_save" style="width: 100px;">Save</button>
                    </div>
                    <div class="col-md-5"></div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div style="margin-left:10px;margin-right:10px" class="col" id="return_message"></div>
                </div>
            </form>
        </div>
        <br>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">View category</li>
        </ol>
        <div class="row">
            <table id="table_category" class="cell-border stripe hover">
                <thead>
                    <tr>
                        <th>Index</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <br>



    <!-- Modal -->
    <div class="modal fade" id="modal-category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit category </h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="category_id">

                    <form style="padding-bottom:20px" id="edit_form_category" action="javascript:void(0);">
                        <div class="row">
                            <div class="col">
                                <label for="name">Name</label>
                                <input class="form-control" id="edit_category_name" type="text" placeholder="Enter category's name" required>
                            </div>  
                        </div>        
                        <div class="row" style="padding-top:10px">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" checked id="edit_category_status">
                                    <label class="form-check-label" for="exampleCheck1">Active</label>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_save_edit" class="btn btn-secondary">Save changes</button>
                    <button type="button" id="btn_delete" class="btn btn-danger">Delete</button>
                </div>
                </form>
            </div>
        </div>
    </div>

</main>

<?php include("../includes/footer.php") ?>
<script src="../js/category.js"></script>