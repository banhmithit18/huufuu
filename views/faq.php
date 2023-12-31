<?php include_once('../controllers/faq_controller.php') ?>
<?php include_once('../includes/header.php') ?>
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
                <a class="footer-content-detail-link nav-name hover-underline-animation-footer" href="index">HOME</a>
                <a class="footer-content-detail-link nav-name" href="#a">&nbsp;/&nbsp; </a>
                <a class="footer-content-detail-link nav-name hover-underline-animation-footer" href="#a">FREQUENTLY
                    ASKED QUESTION</a>
            </div>
        </div>
        <div class="row body-content-detail" style="padding-bottom:20px">

            <?php 
                $faqs = $_SESSION['faqs'];
                if($faqs != null){
                    for($i = 0 ; $i < sizeof($faqs); $i++){
                        $faq_answer = $faqs[$i]['faq_answer'];
                        $faq_question = $faqs[$i]['faq_question'];
                        $html = '<div class="d-flex text-muted pt-4">
                                    <img class="me-3" src="../icon/faq.png" alt="" width="32" height="32">
                                    <div class="accordion" id="#accordionFAQ_'.$i.'">
                                        <div class="accordion-item mb-0 small" style="background-color: #191919;">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed btn-clean" style="background-color: transparent; padding: 0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_'.$i.'" aria-expanded="true" aria-controls="collapse_'.$i.'">
                                                    <strong class="d-block faq-font faq-question">'.$faq_question.'</strong>
                                                </button>
                                             </h2>
                                            <div id="collapse_'.$i.'" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ_'.$i.'">
                                                <strong class="accordion-body faq-font">
                                                    '.$faq_answer.'
                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                        echo $html;
                    }
                }
            ?>

        </div>
    </div>
</div>
<?php include_once('../includes/footer.php') ?>