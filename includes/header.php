<?php include_once('../controllers/index_controller.php') ?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HuuFuu</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link href="../css/style.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../icon/logo-dung.svg">
</head>

<body id="body">
    <div class="page-waiting" id="page-waiting">
        <img src="../icon/logo-dung.svg" alt="Logo">
    </div>
    <div id="body-content">
        <!-- menu-->
        <script src="../js/loading-page.js"></script>
        <nav class="navbar navbar-expand-lg nav-bg-menu">
            <div class="container-fluid d-flex justify-content-evenly menu-container">
                <div class="logo">
                    <a class="navbar-brand" href="#">
                        <img src="<?php if (isset($_SESSION['headerLogo'])) {
                                        echo $_SESSION['headerLogo'];
                                    } else {
                                        echo "../icon/logo-ngang.svg";
                                    } ?>" alt="logo" width="200" height="60">
                    </a>
                </div>
                <div class="nav-items">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link nav-text menu active" data-navsubmenuid='submenu0' href="index" id="menu-home"><p class="nav-text-hover">HOME</p></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-text menu" data-navsubmenuid='submenu1' href="service" id="menu-service"><p class="nav-text-hover">SERVICE</p></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-text menu" data-navsubmenuid='submenu3' href="feedback" id="menu-feedback">FEEDBACK</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-text menu" data-navsubmenuid='submenu2' href="contact_us" id="menu-contact">CONTACT US</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-text menu" data-navsubmenuid='submenu4' href="about_us" id="menu-about">ABOUT US</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-text menu" data-navsubmenuid='submenu5' href="blog" id="menu-blog">BLOG</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="nav-items-mobile" id="nav-items-mobile">
                    <div class="menu-mobile-icon ">
                        <i class="fa fa-bars"></i>
                    </div>
                </div>
                <div class="nav-social d-flex">
                    <a href="<?php if (isset($_SESSION['facebookLink'])) {
                                    echo $_SESSION['facebookLink'];
                                } else {
                                    echo "";
                                } ?>" target="_blank" title="Facebook" id="" class="icon-social px-3">
                        <i class="fa fa-facebook"></i>
                    </a>
                    <a href="<?php if (isset($_SESSION['twitterLink'])) {
                                    echo $_SESSION['twitterLink'];
                                } else {
                                    echo "";
                                } ?>" target="_blank" title="Twitter" class="icon-social px-3">
                        <i class="fa fa-twitter"></i>
                    </a>
                    <a href="<?php if (isset($_SESSION['linkedin'])) {
                                    echo $_SESSION['linkedin'];
                                } else {
                                    echo "";
                                } ?>" target="_blank" title="Linkedin" class="icon-social px-3">
                        <i class="fa fa-linkedin"></i>
                    </a>
                </div>
            </div>
        </nav>
        <!-- end menu-->
        <!--sub menu-->
        <nav class="navbar navbar-expand-lg nav-bg-submenu py-0 nav-submenu active" id="submenu0">
            <div class="container-fluid">
                <div class="collapse navbar-collapse justify-content-center">
                    <div class="navbar-nav ">
                        <?php
                        $categories = null;
                        if (isset($_SESSION['categories'])) {
                            $categories = $_SESSION['categories'];
                        }
                        if ($categories != null) {
                            for ($i = 0; $i < sizeof($categories); $i++) {
                                $categoryName = strtoupper($categories[$i]['category_name']);
                                $categoryId = $categories[$i]['category_id'];
                                $html = '<a class="nav-link nav-text nav-text-submenu" aria-current="page" href="index?category=' . $categoryId . '">' . $categoryName . '</a>';
                                echo $html;
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-expand-lg nav-bg-submenu py-0 nav-submenu " id="submenu1">
            <div class="container-fluid">
                <div class="collapse navbar-collapse justify-content-center">
                    <div class="navbar-nav ">
                    <?php
                        $categories = null;
                        if (isset($_SESSION['categories'])) {
                            $categories = $_SESSION['categories'];
                        }
                        if ($categories != null) {
                            for ($i = 0; $i < sizeof($categories); $i++) {
                                $categoryName = strtoupper($categories[$i]['category_name']);
                                $categoryId = $categories[$i]['category_id'];
                                $html = '<a class="nav-link nav-text nav-text-submenu" aria-current="page" href="index?category=' . $categoryId . '">' . $categoryName . '</a>';
                                echo $html;
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-expand-lg nav-bg-submenu py-0 nav-submenu" id="submenu2">
            <div class="container-fluid">
                <div class="collapse navbar-collapse justify-content-center">
                    <div class="navbar-nav ">
                        <a class="nav-link nav-text nav-text-submenu" aria-current="page" href="contact_us">CONTACT
                            US</a>
                        <a class="nav-link nav-text nav-text-submenu" href="faq">FAQ</a>
                    </div>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-expand-lg nav-bg-submenu py-0 nav-submenu" id="submenu3">
            <div class="container-fluid">
                <div class="collapse navbar-collapse justify-content-center">
                    <div class="navbar-nav ">
                        <a class="nav-link nav-text nav-text-submenu" aria-current="page" href="#">&#8203;</a>
                    </div>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-expand-lg nav-bg-submenu py-0 nav-submenu" id="submenu4">
            <div class="container-fluid">
                <div class="collapse navbar-collapse justify-content-center">
                    <div class="navbar-nav ">
                        <a class="nav-link nav-text nav-text-submenu" aria-current="page" href="#">&#8203;</a>
                    </div>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-expand-lg nav-bg-submenu py-0 nav-submenu" id="submenu5">
            <div class="container">
                <div class="collapse navbar-collapse justify-content-center">
                    <div class="navbar-nav ">
                        <a class="nav-link nav-text nav-text-submenu" aria-current="page" href="#">&#8203;</a>
                    </div>
                </div>
            </div>
        </nav>
        <!--end sub mneu-->
        <!--sub menu mobile-->
        <nav class="navbar navbar-expand-lg nav-bg-menu nav-submenu-mobile" id="nav-submenu-mobile">
            <a class="nav-link nav-text nav-text-submenu menu-mobile-item" aria-current="page" href="index">HOME</a>
            <a class="nav-link nav-text nav-text-submenu menu-mobile-item" aria-current="page" href="service">SERVICE</a>
            <a class="nav-link nav-text nav-text-submenu menu-mobile-item" aria-current="page" href="feedback">FEEDBACK</a>
            <a class="nav-link nav-text nav-text-submenu menu-mobile-item" aria-current="page" href="contact_us">CONTACT US</a>
            <a class="nav-link nav-text nav-text-submenu menu-mobile-item" aria-current="page" href="about_us">ABOUT US </a>
            <a class="nav-link nav-text nav-text-submenu menu-mobile-item" aria-current="page" href="blog">BLOG</a>
            <a class="nav-link nav-text nav-text-submenu menu-mobile-item" aria-current="page" href="faq">FAQ</a>

        </nav>
        <!--end sub mneu mobile-->
        <!-- end header-->