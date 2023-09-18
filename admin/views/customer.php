<?php include("../includes/header.php") ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Customer</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Add customer</li>
        </ol>
        <div class="row border rounded">
            <form style="padding-bottom:20px" id="form_customer" action="javascript:void(0);">
                <div class="row">
                    <div class="col">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="customer_name" placeholder="Enter name" required>
                    </div>
                    <div class="col">
                        <label for="age">Age</label>
                        <input type="number" class="form-control" id="customer_age" placeholder="Enter age" min='0' max="200">
                        <div class="invalid-feedback">Please enter age in range (0-200)</div>

                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="customer_phone" placeholder="Enter phone number" pattern="[0-9]+" required>
                        <div class="invalid-feedback">Please enter number only</div>

                    </div>
                    <div class="col">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="customer_email" placeholder="Enter email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,4}$" required>
                        <div class="invalid-feedback">Please enter a valid email, ex: example@example.com</div>

                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="customer_address" rows="2" placeholder="Enter address"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="customer_gender">
                            <option value='0'>Female</option>
                            <option value='1'>Male</option>
                            <option value='2'>Other</option>
                        </select>
                    </div>
                </div>
                <div class="row" style="padding-top: 10px ;">
                    <div class="col-md-5"></div>
                    <div class="col-md-2">
                        <button class="btn btn-secondary btn-lg" id="btn_save" style="width: 100px;">Save</button>
                    </div>
                    <div class="col-md-5"></div>
                </div>
                <br>

            </form>
        </div>
        <br>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">View customer</li>
        </ol>
        <div class="row">
            <table id="table_customer" class="cell-border stripe hover">
                <thead>
                    <tr>
                        <th>Index</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <br>



    <!-- Modal -->
    <div class="modal fade" id="modal-customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit customer </h5>
                    <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="edit_customer_id">
                    <form id="form_customer_edit" action="javascript:void(0);">
                    <div class="row">
                        <div class="col">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="edit_customer_name" placeholder="Enter name" required>
                        </div>
                        <div class="col">
                            <label for="age">Age</label>
                            <input type="number" class="form-control" id="edit_customer_age" placeholder="Enter age" min='0' max="200" required>
                            <div class="invalid-feedback">Please enter age in range (0-200)</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="edit_customer_phone" placeholder="Enter phone number" pattern="[0-9]+" required>
                            <div class="invalid-feedback">Please enter number only</div>

                        </div>
                        <div class="col">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="edit_customer_email" placeholder="Enter email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,4}$" required>
                            <div class="invalid-feedback">Please enter a valid email, ex: example@example.com</div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="edit_customer_address" rows="2" placeholder="Enter address"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="gender">Gender</label>
                            <select class="form-control" id="edit_customer_gender">
                                <option value='0'>Female</option>
                                <option value='1'>Male</option>
                                <option value='2'>Other</option>
                            </select>
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
<script src="../admin/js/customer.js"></script>