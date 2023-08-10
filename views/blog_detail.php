<?php include_once('../controllers/blog_detail_controller.php') ?>
<?php include_once('../includes/header.php') ?>
<?php 
    $blog = null;
    if(isset($_SESSION['blog'])){
        $blog =  $_SESSION['blog'];
    }
    if($blog == null){
        header('Location: error_page.php');
        exit();
    }else{
        $blogId = $blog[0]['blog_id'];
        $blogTitle = $blog[0]['blog_title'];
        $blogId = $blog[0]['blog_id'];
        $background = substr($blog[0]['image_path'], 3);
        $blogPath  = substr($blog[0]['blog_content_path'],3);
        $blogContent = "";
        //get first 100 line contnet
        $file = fopen($blogPath, 'r');
        if ($file) {
            $blogContent = fread($file,filesize($blogPath));
            fclose($file);
        } 
    }
?>
<div class="body-content-wrapper fluid-container">
    <div class="body-content container">
        <div class="row body-content-title">
            <div class="col d-flex justify-content-start nav-container">
                <a class="footer-content-detail-link nav-name hover-underline-animation-footer" href="index.php">HOME</a>
                <a class="footer-content-detail-link nav-name" href="#">&nbsp;/&nbsp; </a>
                <a class="footer-content-detail-link nav-name hover-underline-animation-footer" href="blog.php">BLOG</a>
                <span class="footer-content-detail-link nav-name" href="#">&nbsp;/&nbsp; </span>
                    <a class="footer-content-detail-link nav-name hover-underline-animation-footer" href="#"><?php echo $blogTitle?></a>
            </div>
        </div>
    </div>
</div>
<div class="fluid-container">
        <div class="container">
            <div class="row blog-detail-wrapper">
                <div class="blog-detail-title">
                    <h2><?php echo $blogTitle; ?></h2>
                </div>
                <div class="blog-detail-content">
                    <?php echo $blogContent ?>
                </div>
            </div>
                <!--relating part-->
            <div class="row blog-relating-wrapper d-flex justify-content-center">
                    <div class="blog-relating-text">RELATED POST </div>
            </div>
            <div class="row body-content-detail blog-row-wrapper">
                <?php 
                    $blogs = null;
                    if (isset($_SESSION['relativeBlogs'])) {
                        $blogs = $_SESSION['relativeBlogs'];
                    }
                    if ($blogs != null) {
                        for ($i = 0; $i < sizeof($blogs); $i++) {
                            $blogRelativeTitle = $blogs[$i]['blog_title'];
                            $blogRelativeId = $blogs[$i]['blog_id'];
                            $backgroundRelative = substr($blogs[$i]['image_path'], 3);
                            $blogRelativeCreateDate = $blogs[$i]['blog_create_date'];
                            $blogRelativePath  = substr($blogs[$i]['blog_content_path'],3);
                            $blogRelativeContent = "";
                            //get first 100 line contnet
                            $fileRelative = fopen($blogRelativePath, 'r');
                            if ($fileRelative) {
                                $blogRelativeContent = fread($fileRelative, 100);
                                $blogRelativeContent = strip_tags($blogRelativeContent);
                                fclose($fileRelative);
                            } 
                            //change format date
                            $date = DateTime::createFromFormat('Y-m-d H:i:s', $blogRelativeCreateDate);
                            $blogRelativeCreateDateFormatted = $date->format('d M, Y');

                            $html = '<div class="col-lg-4 col-md-6 col-sm-8 blog-card-wrapper">
                                        <div class="blog-card-light">
                                            <div class="blog-card-info-light">
                                                <a class="blog-title blog-text-light blog-text-title-light" href="blog_detail.php?id='.$blogRelativeId.'">
                                                    '.$blogRelativeTitle.'
                                                </a>
                                                <div class="blog-time blog-text-light blog-text-time">
                                                    '.$blogRelativeCreateDateFormatted.'
                                                </div>
                                                <div class="blog-content blog-text-light">
                                                    '.$blogRelativeContent.'
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
