<?php include("../includes/header.php") ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">FAQ</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Add FAQ</li>
        </ol>
        <div class="row border rounded">
            <form style="padding-bottom:20px" id="form_faq" action="javascript:void(0);">
                <div class="row">
                    <div class="col">
                        <label for="question">Question</label>
                        <textarea class="form-control" id="faq_question" rows="2" placeholder="Enter question" required></textarea>
                    </div>
                    <div class="col">
                        <label for="answer">Answer</label>
                        <textarea class="form-control" id="faq_answer" rows="2" placeholder="Enter answer" required></textarea>
                    </div>
                </div>
                <div class="row">
                            <div class="col-md-6">
                                <label for="priority">Priority</label>
                                <input type="number" class="form-control" id="faq_priority" placeholder="Enter priority" value="1" pattern="[0-9]+" required>
                                <div class="invalid-feedback">Please enter number only</div>
                            </div>
                        </div>
                        <div class="row" style="padding-top:10px">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" checked id="faq_status">
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
                <div class="row">
                    <div style="margin-left:10px;margin-right:10px" class="col" id="return_message"></div>
                </div>
            </form>
        </div>
        <br>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">View FAQ</li>
        </ol>
        <div class="row">
            <table id="table_faq" class="cell-border stripe hover">
                <thead>
                    <tr>
                        <th>Index</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <br>



    <!-- Modal -->
    <div class="modal fade" id="modal-faq" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit FAQ </h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="faq_id">

                    <form style="padding-bottom:20px" id="edit_form_faq" action="javascript:void(0);">
                        <div class="row">
                            <div class="col">
                                <label for="question">Question</label>
                                <textarea class="form-control" id="edit_faq_question" rows="4" placeholder="Enter question" required></textarea>
                            </div>
                            <div class="col">
                                <label for="answer">Answer</label>
                                <textarea class="form-control" id="edit_faq_answer" rows="4" placeholder="Enter answer" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="priority">priority</label>
                                <input type="number" class="form-control" id="edit_faq_priority" placeholder="Enter priority" value="1" pattern="[0-9]+" required>
                                <div class="invalid-feedback">Please enter number only</div>
                            </div>
                        </div>
                        <div class="row" style="padding-top:10px">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" checked id="edit_faq_status">
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
<script src="../js/faq.js"></script>