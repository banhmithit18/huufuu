<?php include_once('../controllers/project_detail_controller.php') ?>
<?php include_once('../includes/header.php') ?>

<div class="body-content-wrapper fluid-container">
    <div class="body-content container">
        <div class="row body-content-title">
            <div class="col d-flex justify-content-start nav-container">
                <a class="footer-content-detail-link nav-name hover-underline-animation-footer" href="index.php">HOME</a>
                <span class="footer-content-detail-link nav-name" href="#a">&nbsp;/&nbsp; </span>
                <a class="footer-content-detail-link nav-name hover-underline-animation-footer" href="#"><?php echo  $_SESSION['project_name'] ?>
                </a>
            </div>
        </div>
        <div class="fluid-container body-content-detail">
            <?php
            $project_details = null;
            if (isset($_SESSION['project_detail'])) {
                $project_details = $_SESSION['project_detail'];
            }
            if ($project_details != null) {
                foreach ($project_details as $project_detail) {
                    $html = "<div class='row'>";
                    for ($y = 0; $y < sizeof($project_detail); $y++) {
                        $path = substr($project_detail[$y]['image_path'], 3);
                        $text = $project_detail[$y]['project_detail_text'];
                        $type = $project_detail[$y]['project_detail_type'];
                        $priority = $project_detail[$y]['project_detail_priority'];
                        //check if next is same row 
                        if ($type == 0) {
                            $html = $html . "<div class='col'> 
                                        <div class='project_detail_text'> " . $text . " </div>
                                    </div>";
                        } else {
                            $html = $html . "<div class='col'> 
                                        <img class='project_detail_image' src='" . $path . "'>
                                    </div>";
                        }
                    }
                    $html = $html . "</div>";
                    echo $html;
                }
            }
            ?>
        </div>
    </div>
</div>
<?php include_once('../includes/footer.php') ?>