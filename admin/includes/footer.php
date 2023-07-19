<!-- modal change information -->
<div class="modal fade" id="modal-user-change-information" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Information</h5>
                <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                $value  = null;
                if (isset($_SESSION['user_id'])) {
                    $value = $_SESSION['user_id'];
                    echo '<input type="hidden" class="form-control" value="' . $value . '" id="information_user_id">';
                }
                ?>
                <?php
                $value  = null;
                if (isset($_SESSION['user_role'])) {
                    $value = $_SESSION['user_role'];
                    echo '<input type="hidden" class="form-control" value="' . $value . '" id="information_user_role">';
                }
                ?>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="username">Username</label>
                        <?php
                        $value  = null;
                        if (isset($_SESSION['user_username'])) {
                            $value = $_SESSION['user_username'];
                            echo '<input type="text" class="form-control" id="information_user_username" value = "' . $value . '" placeholder="Enter username"  readonly>';
                        }
                        ?>
                    </div>
                </div>
                <form id="form_user_information" action="javascript:void(0);">

                    <div class="row">
                        <div class="col">
                            <label for="name">Name</label>
                            <?php
                            $value  = null;
                            if (isset($_SESSION['user_name'])) {
                                $value = $_SESSION['user_name'];
                            }
                            echo '<input type="text" class="form-control" id="information_user_name" value = "' . $value . '" placeholder="Enter name" required>';
                            ?>
                        </div>
                        <div class="col">
                            <label for="age">Age</label>
                            <?php
                            $value  = null;
                            if (isset($_SESSION['user_age'])) {
                                $value = $_SESSION['user_age'];
                            }
                            echo '<input type="text" class="form-control" id="information_user_age" value = "' . $value . '" placeholder="Enter age" min="0" max="200" required>';
                            ?>
                            <div class="invalid-feedback">Please enter age in range (0-200)</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="phone">Phone</label>
                            <?php
                            $value  = null;
                            if (isset($_SESSION['user_phone'])) {
                                $value = $_SESSION['user_phone'];
                            }
                            echo '<input type="text" class="form-control" id="information_user_phone" placeholder="Enter phone number" value= "' . $value . '" pattern="[0-9]+" required>';
                            ?>
                            <div class="invalid-feedback">Please enter number only</div>

                        </div>
                        <div class="col">
                            <label for="email">Email</label>
                            <?php
                            $value  = null;
                            if (isset($_SESSION['user_email'])) {
                                $value = $_SESSION['user_email'];
                            }
                            echo '<input type="email" class="form-control" id="information_user_email" value="' . $value . '" placeholder="Enter email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,4}$" required>';
                            ?>
                            <div class="invalid-feedback">Please enter a valid email, ex: example@example.com</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="address">Address</label>
                            <?php
                            $value  = null;
                            if (isset($_SESSION['user_address'])) {
                                $value = $_SESSION['user_address'];
                            }
                            echo '<textarea class="form-control" id="information_user_address" rows="2" value="' . $value . '" placeholder="Enter address">'. $value . '</textarea>';
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="gender">Gender</label>
                            <?php
                            $value  = null;
                            if (isset($_SESSION['user_gender'])) {
                                $value = $_SESSION['user_gender'];
                                $html = '<select class="form-control" id="information_user_gender">';
                            }
                            if ($value == "0") {
                                $html .= "<option value='0' selected>Female</option>
                                          <option value='1'>Male</option>
                                          <option value='2'>Other</option>
                                        </select>";
                            } else if ($value == "1") {
                                $html .= "<option value='0'>Female</option>
                                          <option value='1' selected>Male</option>
                                          <option value='2'>Other</option>
                                        </select>";
                            } else if ($value == "2") {
                                $html .= "<option value='0'>Female</option>
                                          <option value='1'>Male</option>
                                          <option value='2' selected>Other</option>
                                        </select>";
                            } else {
                                $html .= "<option value='0'>Female</option>
                                          <option value='1'>Male</option>
                                          <option value='2' selected>Other</option>
                                        </select>";
                            }
                            echo $html;
                            ?>

                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_information_edit" class="btn btn-secondary">Save changes</button>
                <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- modal change password -->
<div class="modal fade" id="modal-user-change-password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change password</h5>
                <button type="button" class="close btn-transparent" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="information_user_change_password_form">
                    <div class="row">
                        <div class="input-group">
                            <input type="password" name="password" id="information_user_old_password" placeholder="Enter old password" required class="form-control" data-toggle="password">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                            <div class="invalid-feedback">Please enter old password</div>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="input-group">
                            <input type="password" class="form-control" id="information_user_new_password" placeholder="Enter new password" data-toggle="password" required>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                            <div class="invalid-feedback">Please enter new password</div>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="input-group">
                            <input type="password" class="form-control" id="information_user_new_password_repeat" placeholder="Enter new password again" data-toggle="password" required>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                            <div class="invalid-feedback">Please enter password again</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_information_pass" class="btn btn-secondary">Save changes</button>
                <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; HuuFuu</div>
        </div>
    </div>
    <div class="modal-waiting">
        <!-- Place at bottom of page -->
    </div>
</footer>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script src="../js/scripts.js"></script>
<script src="../js/bootstrap-show-password.min.js"></script>

</body>

</html>