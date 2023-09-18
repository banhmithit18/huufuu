<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_REQUEST['category'])) {
    $_SESSION['category_id'] = $_REQUEST['category'];
}
?>
<?php include_once('../controllers/project_controller.php') ?>
<?php include_once('../includes/header.php') ?>
<div class="container-fluid" style="background-color: black;">
    <div class="row" id="project-wrapper">
        <?php
        $projects = $_SESSION['projects'];
        if ($projects != null && $projects != "") {
            for ($i = 0; $i < sizeof($projects); $i++) {
                $project_id = $projects[$i]['project_id'];
                $project_name = $projects[$i]['project_name'];
                $project_content = $projects[$i]['project_content'];
                $image_path = substr($projects[$i]['image_path'], 3);
                $background_image_path = substr($projects[$i]['background_image_path'], 3);
                $hasDetail = $projects[$i]['hasDetail'];
                $link = $hasDetail == 0 ? "#a" : "project_detail?id=".$project_id;
                $html = '<div class="col-md-3 col-sm-12 grid-img">
                                    <div class="production">
                                        <div class="overlay"></div>
                                        <div class="img-holder"  style="background-image:url(\'' . $background_image_path . '\')">                                           
                                            <a href="'.$link.'">
                                                <img class=" img-prop img-pos" src="' . $image_path . '" alt="img">
                                            </a>
                                        </div>
                                        <img src="../icon/top-left.png"  class="top-left corner-img" >
                                        <img src="../icon/top-right.png" class="top-right corner-img">
                                        <img src="../icon/bot-left.png" class="bottom-left corner-img">
                                        <img src="../icon/bot-right.png" class="bottom-right corner-img">
                                        <div class="item-description alt">
                                            <h6 class="text-main-description">' . $project_name . '</h6>
                                            <div class="item-description loader"></div>
                                            <div class="text-sub-description">' . $project_content . '</div>
                                        </div>
                                    </div>
                                </div>';
                echo $html;
            }
        }
        ?>
    </div>
    <?php
    $current_page = $_SESSION['current_page'];
    $number_of_page = $_SESSION['number_of_page'];

    if ($current_page < $number_of_page) {
        $html = '<div class="row pagination" id="pagination">
                            <img id="loading-img" class="col loadmore-img" src="../icon/three-dots.svg" alt="Show more"
                                style="display:none">
                            <div id="loading-text" class="col pagination-text" onclick="nextPage(event)" >SHOW MORE</div>
                        </div>';
        echo $html;
    }
    ?>
</div>


<?php include_once('../includes/footer.php') ?>
<script src="../js/index.js"></script>