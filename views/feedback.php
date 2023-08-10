<?php include_once('../controllers/feedback_controller.php') ?>
<?php include_once('../includes/header.php') ?>

<div class="body-content-wrapper fluid-container">
    <div class="body-content container">
        <div class="row body-content-title">
            <div class="col d-flex justify-content-start nav-container">
                <a class="footer-content-detail-link nav-name hover-underline-animation-footer" href="index.php">HOME</a>
                <a class="footer-content-detail-link nav-name" href="#">&nbsp;/&nbsp; </a>
                <a class="footer-content-detail-link nav-name hover-underline-animation-footer" href="#">FEEDBACK</a>
            </div>
        </div>
        <div class="row body-content-detail" style="padding-bottom:20px">
            <div class="tab-content module" id="nav-tabContent">
                <div class="tab-pane active" id="tab-testimonial-1" aria-labelledby="nav-testimonial-1">
                    <div class="container">
                        <div class="row align-items-stretch">
                            <div class="container-fluid">
                                <div class="row pt-4 mt-5">
                                    <section class="testimonial text-center">
                                        <div class="container">
                                            <div id="testimonial4" class="carousel slide testimonial4_indicators testimonial4_control_button thumb_scroll_x swipe_x" data-bs-pause="hover" data-bs-interval="5000" data-bs-duration="2000">
                                                <div class="carousel-inner" role="listbox">

                                                    <?php 
                                                        $feedbacks = null;
                                                        if(isset($_SESSION['feedbacks'])){
                                                            $feedbacks = $_SESSION['feedbacks'];
                                                        }
                                                        if ($feedbacks != null){
                                                            for($i = 0 ; $i < sizeof($feedbacks) ; $i++){
                                                                $feedbackName = $feedbacks[$i]['feedback_name'];
                                                                $feedbackContent = $feedbacks[$i]['feedback_content'];
                                                                $image = substr($feedbacks[$i]['image_path'], 3);
                                                                $html = ' <div class="carousel-item">';
                                                                if($i == 0){
                                                                    $html = ' <div class="carousel-item active">';
                                                                }
                                                                $html = $html . '<div class="testimonial4_slide">
                                                                                    <img src="'.$image.'" class="img-circle img-responsive" />
                                                                                    <p>'.$feedbackContent.'</p>
                                                                                    <h4>'.$feedbackName.'</h4>
                                                                                </div>
                                                                            </div>';
                                                                echo $html;
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                                <a class="carousel-control-prev" href="#testimonial4" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon"></span>
                                                </a>
                                                <a class="carousel-control-next" href="#testimonial4" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once('../includes/footer.php') ?>