<!-- footer-->
<footer class="nav-bg-menu-footer">
        <div class="d-flex justify-content-start">
            <div class="footer-img ps-4">
                <img class="footer-logo img-fluid." src="<?php if(isset($_SESSION['footerLogo'])){ echo $_SESSION['footerLogo'];} else{echo "../icon/logo-ngang.svg";}?>" alt="logo" width="200"
                    height="160">
            </div>

            <div class="container">
                <div class="row">
                    <div class="footer-content col-lg-3 col-md-6 col-sm-12">
                        <a href="about_us.php" class="footer-content-menu-link hover-underline-animation-footer">INTRODUCE</a>
                        <p class="footer-content-detail">
                            <?php if(isset($_SESSION['introduce'])){ echo $_SESSION['introduce'];} else{echo "";}?>
                        </p>
                    </div>
                    <div class="footer-content col-lg-3 col-md-6 col-sm-12 footer-content-contact">
                        <a href="contact_us.php" class="footer-content-menu-link hover-underline-animation-footer">CONTACT US</a>
                        <div class="footer-content-wrapper">
                            <a href="<?php if(isset($_SESSION['facebookLink'])){ echo $_SESSION['facebookLink'];} else{echo "";}?>"
                                class="footer-content-detail-link pt-1 hover-underline-animation-footer">FACEBOOK</a>
                        </div>
                        <div class="footer-content-wrapper">
                            <a href="<?php if(isset($_SESSION['twitterLink'])){ echo $_SESSION['twitterLink'];} else{echo "";}?>"
                                class="footer-content-detail-link pt-1 hover-underline-animation-footer">TWITTER</a>
                        </div>
                        <div class="footer-content-wrapper">
                            <a href="<?php if(isset($_SESSION['linkedinLink'])){ echo $_SESSION['linkedinLink'];} else{echo "";}?>" class="footer-content-detail-link pt-1 hover-underline-animation-footer">LINKED
                                IN</a>
                        </div>
                    </div>
                    <div class="footer-content col-lg-3 col-md-6 col-sm-12">
                        <a href="service.php" class="footer-content-menu-link hover-underline-animation-footer">SERVICE</a>
                    </div>
                    <div class="footer-content col-lg-3 col-md-6 col-sm-122">
                        <a href="feedback.php" class="footer-content-menu-link hover-underline-animation-footer">FEEDBACK</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-4 mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex justify-content-center small">
                    <div class="text-muted">Copyright &copy; HuuFuu</div>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src="../js/bootstrap.bundle.js"></script>
    <script src="../js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

</body>

</html>