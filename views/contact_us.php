<?php include_once('../controllers/contact_us_controller.php') ?>
<?php include_once('../includes/header.php') ?>
<?php 
    if(isset($_REQUEST['service_id'])){
        $_SESSION['service_id'] = $_REQUEST['service_id'];
    }
?>
<script>
    document.getElementById("menu-home").classList.remove('active');
    document.getElementById("menu-service").classList.remove('active');
    document.getElementById("menu-feedback").classList.remove('active');
    document.getElementById("menu-contact").classList.add('active');
    document.getElementById("menu-about").classList.remove('active');
    document.getElementById("menu-blog").classList.remove('active');

    document.getElementById("submenu0").classList.remove('active');
    document.getElementById("submenu1").classList.remove('active');
    document.getElementById("submenu3").classList.remove('active');
    document.getElementById("submenu2").classList.add('active');
    document.getElementById("submenu4").classList.remove('active');
    document.getElementById("submenu5").classList.remove('active');
</script>
<div class="body-content-wrapper fluid-container">
    <div class="body-content container">
        <div class="row body-content-title">
            <div class="col d-flex justify-content-start nav-container">
                <a class="footer-content-detail-link nav-name hover-underline-animation-footer" href="index.php">HOME</a>
                <a class="footer-content-detail-link nav-name" href="#a">&nbsp;/&nbsp; </a>
                <a class="footer-content-detail-link nav-name hover-underline-animation-footer" href="#a">CONTACT US</a>
            </div>
        </div>
        <div class="row body-content-detail contact-us-row-wrapper">
            <div class="contact-us-form-wrapper">
                <div class="contact-us-label contact-us-text">
                    Your Name (required)
                </div>
                <div class="contact-us-input-wrapper">
                    <input id="customer_name" type="text" aria-label="Input your name" required class="contact-us-input contact-us-text" placeholder="Input your name ">
                </div>
            </div>
            <div class="contact-us-form-wrapper pt-5">
                <div class="contact-us-label contact-us-text">
                    Your Mail (required)
                </div>
                <div class="contact-us-input-wrapper">
                    <input id="customer_mail" type="mail" aria-label="Input your mail" required class="contact-us-input contact-us-text" placeholder="Input your mail">
                </div>
            </div>
            <div class="contact-us-form-wrapper pt-5">
                <div class="contact-us-label contact-us-text">
                    Your Phone (required)
                </div>
                <div class="contact-us-input-wrapper">
                    <input id="customer_phone" type="phone" aria-label="Input your phone" required class="contact-us-input contact-us-text" placeholder="Input your phone">
                </div>
            </div>
            <div class="contact-us-form-wrapper pt-5">
                <div class="contact-us-label contact-us-text">
                    Your Message
                </div>
                <div class="contact-us-input-wrapper">
                    <textarea id="customer_message" class="contact-us-input contact-us-text" rows="4"></textarea>
                </div>
            </div>
            <div class="send-contact-us wrapper pt-3">
                <button id="send-contact-us" class="btn-clean hover-underline-animation-footer btn-contact-us">SEND</button>
            </div>
            <div class="contact-us-form-wrapper pt-5">
                <div id="notification-content" class="contact-us-label contact-us-text" style="color:red">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once('../includes/footer.php') ?>
<script src="../js/contact_us.js"></script>