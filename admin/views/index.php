<?php include("../includes/header.php") ?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Contact</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">View Contact</li>
        </ol>
        <div class="row">
            <table id="table_contact_us" class="cell-border stripe hover">
                <thead>
                    <tr>
                        <th>Index</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Answer</th>
                        <th>Created at</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <br>


</main>
<div class="modal fade" id="modal-contact-answer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Answer </h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body container" id="contact_answer_detail">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" aria-label="close" class="btn btn-danger">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php include("../includes/footer.php") ?>
<script src="../admin/js/contact_us.js"></script>