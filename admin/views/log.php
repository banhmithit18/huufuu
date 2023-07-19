<?php include("../includes/header.php") ?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Log</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">View log</li>
        </ol>
        <div class="row">
            <table id="table_log" class="cell-border stripe hover">
                <thead>
                    <tr>
                        <th>Index</th>
                        <th>Log</th>
                        <th>Detail</th>
                        <th>Time</th>
                        <th>User</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <br>


</main>

<?php include("../includes/footer.php") ?>
<script src="../js/log.js"></script>