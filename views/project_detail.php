<?php include_once('../controllers/project_detail_controller.php') ?>
<?php include_once('../includes/header.php') ?>
<?php
$project_id == 0;
$content = "";
$project_name = "";
if (isset($_SESSION['project_id'])) {
    $project_id =  $_SESSION['project_id'];
    $content = $_SESSION['content'];
    $project_name = $_SESSION['project_name'];
}
if ($project_id == 0) {
    header('Location: error_page.php');
    exit();
}
?>
<div class="body-content-wrapper fluid-container">
    <div class="body-content container">
        <div class="row body-content-title">
            <div class="col d-flex justify-content-start nav-container">
                <a class="footer-content-detail-link nav-name hover-underline-animation-footer" href="index.php">HOME</a>
                <span class="footer-content-detail-link nav-name" href="#a">&nbsp;/&nbsp; </span>
                <a class="footer-content-detail-link nav-name hover-underline-animation-footer" href="#"><?php echo  $project_name ?>
                </a>
            </div>
        </div>
        <div class="row body-content-detail" style="color:rgba(255, 255, 255, 0.8) !important">
            <?php echo $_SESSION['content'] ?>
        </div>
    </div>
</div>
<?php include_once('../includes/footer.php') ?>