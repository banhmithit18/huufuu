<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8 without BOM" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <title>Admin</title>
    <link rel="icon" type="image/x-icon" href="../admin/css/admin-logo.ico">
    <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link href="../admin/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">


</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index">Admin</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <div class="d-none d-md-inline-block form-inline"></div>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-user-change-information">Change information</a></li>
                    <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-user-change-password">Change password</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" id="logout">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="project">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-image"></i></div>
                            Project
                        </a>
                        <a class="nav-link" href="contact_us">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-address-book"></i></div>
                            Contact
                        </a>
                        <a class="nav-link" href="review">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-message"></i></div>
                            Review
                        </a>
                        <a class="nav-link" href="feedback">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-message"></i></div>
                            Feedback
                        </a>
                        <a class="nav-link" href="service">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-solid fa-box"></i></div>
                            Service
                        </a>
                        <a class="nav-link" href="blog">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-square-pen"></i></div>
                            Blog
                        </a>
                        <a class="nav-link" href="faq">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-question"></i></div>
                            FAQ
                        </a>
                        <a class="nav-link" href="customer">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                            Customer
                        </a>
                        <a class="nav-link" href="banner">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-panorama"></i></div>
                            Banner
                        </a>
                        <a class="nav-link" href="image">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-image"></i></div>
                            Image
                        </a>
                        <a class="nav-link" href="category">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-table-cells-large"></i></div>
                            Category
                        </a>
                        <a class="nav-link" href="user">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-id-badge"></i></div>
                            User
                        </a>
                        <a class="nav-link" href="about_us">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-circle-info"></i></div>
                            About us
                        </a>
                        <a class="nav-link" href="media">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-location-dot"></i></div>
                            Media
                        </a>
                        <a class="nav-link" href="logo">
                            <div class="sb-nav-link-icon"><i class="fas fa-store"></i></div>
                            Logo
                        </a>
                        <a class="nav-link" href="log">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-file-lines"></i></div>
                            Log
                        </a>                       
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">