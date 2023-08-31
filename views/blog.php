<?php include_once('../controllers/blog_controller.php') ?>
<?php include_once('../includes/header.php') ?>
<script>
    document.getElementById("menu-home").classList.remove('active');
    document.getElementById("menu-service").classList.remove('active');
    document.getElementById("menu-feedback").classList.remove('active');
    document.getElementById("menu-contact").classList.remove('active');
    document.getElementById("menu-about").classList.remove('active');
    document.getElementById("menu-blog").classList.add('active');

    document.getElementById("submenu0").classList.remove('active');
    document.getElementById("submenu1").classList.remove('active');
    document.getElementById("submenu2").classList.remove('active');
    document.getElementById("submenu3").classList.remove('active');
    document.getElementById("submenu4").classList.remove('active');
    document.getElementById("submenu5").classList.add('active');
</script>
<div class="body-content-wrapper fluid-container">
    <div class="body-content container">
        <div class="row body-content-title">
            <div class="col d-flex justify-content-start nav-container">
                <a class="footer-content-detail-link nav-name hover-underline-animation-footer" href="index">HOME</a>
                <a class="footer-content-detail-link nav-name" href="#a">&nbsp;/&nbsp; </a>
                <a class="footer-content-detail-link nav-name hover-underline-animation-footer" href="#a">BLOG</a>
            </div>
        </div>
        <div class="row body-content-detail blog-row-wrapper" id="blog-content-wrapper" style="padding-bottom:20px">
            <?php
            $blogs = null;
            if (isset($_SESSION['blogs'])) {
                $blogs = $_SESSION['blogs'];
            }
            if ($blogs != null) {
                for ($i = 0; $i < sizeof($blogs); $i++) {
                    $blogTitle = $blogs[$i]['blog_title'];
                    $blogId = $blogs[$i]['blog_id'];
                    $background = substr($blogs[$i]['image_path'], 3);
                    $blogCreateDate = $blogs[$i]['blog_create_date'];
                    $blogPath  = substr($blogs[$i]['blog_content_path'],3);
                    $blogContent = "";
                    //get first 100 line contnet
                    $file = fopen($blogPath, 'r');
                    if ($file) {
                        $blogContent = fread($file, 100);
                        $blogContent = strip_tags($blogContent);
                        fclose($file);
                    } 
                    //change format date
                    $date = DateTime::createFromFormat('Y-m-d H:i:s', $blogCreateDate);
                    $blogCreateDateFormatted = $date->format('d M, Y');
                    $html = '<div class="col-xl-4 col-lg-6 col-md-12 blog-card-wrapper">
                                <div class="blog-card">
                                    <div class="blog-background"></div>
                                    <div class="blog-thumbnail" style="background-image:url(\''.$background.'\')"></div>
                                    <div class="blog-card-info">
                                        <a class="blog-title blog-text blog-text-title" href="blog_detail?id='.$blogId.'">
                                            '.$blogTitle.'
                                        </a>
                                        <div class="blog-time blog-text blog-text-time">
                                            '.$blogCreateDateFormatted.'
                                        </div>
                                        <div class="blog-content blog-text">       
                                            '.$blogContent.'                       
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    echo $html;
                }
            }
            ?>          
        </div>
        <?php 
        $numberOfPage = 1;
        $currentPage = 1;
        if(isset($_SESSION['number_of_page'])){
            $numberOfPage = $_SESSION['number_of_page'];
        }
        if(isset($_SESSION['current_page'])){
            $currentPage = $_SESSION['current_page'];
        }
        if($numberOfPage > $currentPage){
            echo '<div class="row pagination" id="pagination">
                    <img id="loading-img" class="col loadmore-img" src="../icon//three-dots.svg" alt="Show more" style="display:none">
                    <div onclick="nextPage(event)" id="loading-text" class="col pagination-text">SHOW MORE</div>
                  </div>';
        }
        else{
            echo '<div class="row pagination mt-5 mb-5" id="pagination"></div>';
        }
        
        ?>
    </div>
</div>
<?php include_once('../includes/footer.php') ?>
<script src="../js/blog.js"></script>