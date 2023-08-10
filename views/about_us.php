<?php include_once('../controllers/about_us_controller.php')?>
<?php include_once('../includes/header.php')?>

<div class="body-content-wrapper fluid-container">
        <div class="body-content container">
            <div class="row body-content-title">
                <div class="col d-flex justify-content-start nav-container">
                    <a class="footer-content-detail-link nav-name hover-underline-animation-footer" href="index.php">HOME</a>
                    <span class="footer-content-detail-link nav-name" href="#">&nbsp;/&nbsp; </span>
                    <a class="footer-content-detail-link nav-name hover-underline-animation-footer" href="about-us.php">ABOUT
                        US</a>
                </div>
            </div>
            <div class="row body-content-detail contact-us-row-wrapper" style="color:rgba(255, 255, 255, 0.8) !important">
                <?php echo $_SESSION['content'] ?>        
            </div>
        </div>
    </div>
<?php include_once('../includes/footer.php')?>