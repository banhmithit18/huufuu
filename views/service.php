<?php include_once('../controllers/service_controller.php') ?>
<?php include_once('../includes/header.php') ?>

<div class="body-content-wrapper fluid-container">
    <div class="body-content container">
        <div class="row body-content-title">
            <div class="col d-flex justify-content-start nav-container">
                <a class="footer-content-detail-link nav-name hover-underline-animation-footer" href="index.php">HOME</a>
                <a class="footer-content-detail-link nav-name" href="#">&nbsp;/&nbsp; </a>
                <a class="footer-content-detail-link nav-name hover-underline-animation-footer" href="#">SERVICE</a>
            </div>
        </div>
        <div class="row body-content-detail service-wrapper pt-3">
            <nav>
                <div class="nav nav-tabs serivce-nav" id="nav-tab" role="tablist">
                    <?php
                    $cateogories = null;
                    $if_first = true;
                    $active_category = 0;
                    if (isset($_SESSION['categories'])) {
                        $cateogories = $_SESSION['categories'];
                    }
                    if ($cateogories != null) {
                        $active_category = $cateogories[0]['category_id'];
                        for ($i = 0; $i < sizeof($cateogories); $i++) {
                            $html = "";
                            if ($if_first) {
                                $html = '<button class="nav-link active service-tab-text" onClick="switchTab(event,' . $cateogories[$i]['category_id'] . ',true)" id="nav-service-' . $cateogories[$i]['category_id'] . '" data-bs-toggle="tab" data-bs-target="#tab-service-' . $cateogories[$i]['category_id'] . '" type="button" role="tab" aria-controls="tab-service-' . $cateogories[$i]['category_id'] . '" aria-selected="true">' . $cateogories[$i]['category_name'] . '</button>';
                                $if_first = false;
                            } else {
                                $html = '<button class="nav-link service-tab-text" onClick="switchTab(event,' . $cateogories[$i]['category_id'] . ',false)" id="nav-service-' . $cateogories[$i]['category_id'] . '" data-bs-toggle="tab" data-bs-target="#tab-service-' . $cateogories[$i]['category_id'] . '" type="button" role="tab" aria-controls="tab-service-' . $cateogories[$i]['category_id'] . '" aria-selected="false">' . $cateogories[$i]['category_name'] . '</button>';
                            }
                            echo $html;
                        }
                    }
                    ?>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                <?php
                if ($cateogories != null) {
                    for ($i = 0; $i < sizeof($cateogories); $i++) {
                        if ($active_category == $cateogories[$i]['category_id']) {
                            $number_of_page = $_SESSION['number_of_page'];
                            $current_page = $_SESSION['current_page'];
                            //get detail                               
                            $html = '<div class="tab-pane fade show active"  id="tab-service-' . $cateogories[$i]['category_id'] . '" role="tabpanel" aria-labelledby="nav-service-' . $cateogories[$i]['category_id'] . '">
                                            <div class="container">
                                                <div class="row align-items-stretch" id="content-tab-service-' . $cateogories[$i]['category_id'].'">';
                            //get service
                            if (isset($_SESSION['services'])) {
                                $services = $_SESSION['services'];
                                for ($y = 0; $y < sizeof($services); $y++) {
                                    $id = $services[$i]['service_id'];
                                    $name = $services[$i]['service_name'];
                                    $price = $services[$i]['service_price'];
                                    $background = substr($services[$i]['image_path'], 3);
                                    $details = $services[$i]['details'];
                                    $html = $html . '<div class="col-lg-4 col-sm-12 mb-5">
                                                    <div class="pt-5"></div>
                                                    <div class="service-card" style="background-image: url(\'' . $background . '\');">
                                                        <div class="service-card-name service-title-text ">
                                                            ' . $name . '
                                                        </div>
                                                    <div class="service-price pt-4 pb-4">
                                                        ' . $price . '
                                                    </div>';

                                    //get detail
                                    $html = $html . '<div class="service-card-content-wrapper">';
                                    if ($details != "") {
                                        foreach ($details as $detail) {
                                            $html = $html . '<div class="service-card-text-wrapper service-line-top-border">
                                                            <div class="service-text">
                                                                ' . $detail['service_detail_value'] . '
                                                            </div>
                                                        </div>';
                                        }
                                    }
                                    $html = $html . '</div>';
                                    $html = $html . '<div class="service-button-wrapper">
                                                    <button onclick="location.href = \'contact_us.php?service_id=' . $id . '\';" type="button" class="service-button px-4 py-1">Liên hệ </button>
                                                </div>';
                                    $html = $html . '</div></div>';
                                }
                            }
                            $html = $html . '</div>';
                            //check if number page > 1 then show "Show More" button
                            if ($number_of_page > 1) {
                                $html = $html . '<div class="row pagination mb-5 mt-5" id="pagination">
                                                        <img id="loading-img" class="col loadmore-img" src="../icon//three-dots.svg" alt="Show more" style="display:none">
                                                        <div onClick="nextPage(event,' . $active_category . ')" id="loading-text" class="col pagination-text">SHOW MORE</div>
                                                    </div>';
                            }else{
                                $html = $html . '<div class="row mb-5 mt-5"></div>';
                            }
                            $html = $html . '</div></div>';
                        } else {
                            $html = '<div class="tab-pane fade show" id="tab-service-' . $cateogories[$i]['category_id'] . '" role="tabpanel" aria-labelledby="nav-service-' . $cateogories[$i]['category_id'] . '">';
                        }
                        echo $html;
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include_once('../includes/footer.php') ?>
<script src="../js/service.js"></script>