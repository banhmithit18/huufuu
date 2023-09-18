<?php include_once('../controllers/about_us_controller.php')?>
<?php include_once('../includes/header.php')?>
<script>
    document.getElementById("menu-home").classList.remove('active');
    document.getElementById("menu-service").classList.remove('active');
    document.getElementById("menu-feedback").classList.remove('active');
    document.getElementById("menu-contact").classList.remove('active');
    document.getElementById("menu-about").classList.add('active');
    document.getElementById("menu-blog").classList.remove('active');

    document.getElementById("submenu0").classList.remove('active');
    document.getElementById("submenu1").classList.remove('active');
    document.getElementById("submenu2").classList.remove('active');
    document.getElementById("submenu3").classList.remove('active');
    document.getElementById("submenu4").classList.add('active');
    document.getElementById("submenu5").classList.remove('active');
</script>
<div class="body-content-wrapper fluid-container">
        <div class="body-content container">
            <div class="row body-content-title">
                <div class="col d-flex justify-content-start nav-container">
                    <a class="footer-content-detail-link nav-name hover-underline-animation-footer" href="index">HOME</a>
                    <span class="footer-content-detail-link nav-name" href="#a">&nbsp;/&nbsp; </span>
                    <a class="footer-content-detail-link nav-name hover-underline-animation-footer" href="about-us">ABOUT
                        US</a>
                </div>
            </div>
            <div class="row body-content-detail contact-us-row-wrapper" style="color:rgba(255, 255, 255, 0.8) !important">
                <?php echo $_SESSION['content'] ?>        
            </div>
        </div>
    </div>
<?php include_once('../includes/footer')?>