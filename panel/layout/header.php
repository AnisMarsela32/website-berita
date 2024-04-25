<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    session_start();
    $fulldomain = "http://localhost/lorong_berita/";
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Management System</title>

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?= $fulldomain ?>panel/style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top ">
        <div class="container-fluid">
            <a class="navbar-brand ms-5" href="dashbord.php">Adminitrator</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarScroll">
                <ul class="navbar-nav mx-auto my-2 my-lg-0 navbar-nav-scroll d-lg-none" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="dashbord.php">Dashbord</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kategori.php">Kategori</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="user.php">User</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <li class="nav-item dropdown d-lg-none">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="uil uil-user-circle"></i>
                        </a>
                        <!-- <ul class="dropdown-menu">
                            <li><a class="dropdown-item " href="#"><i class="uil uil-sign-out-alt"></i> Logout</a></li>
                        </ul> -->
                    </li>

                </ul>
            </div>
        </div>
    </nav>


    <aside>
        <ul type="none">
            <li>
                <img src="<?= $fulldomain ?>panel/image/user_pink.png" alt="ini gambar" style="width: 40px;">
                Administrator
            </li>
            <li><a href="dashbord.php"><i class="uil uil-dashboard"></i> Dashbord</a></li>
            <li><a href="blog.php"><i class="uil uil-blogger"></i> Blog</a></li>
            <li><a href="kategori.php"><i class="uil uil-apps"></i> Kategori</a></li>
            <!-- <li><a href="user.php"><i class="uil uil-user"></i> User</a></li> -->
            <li><a href="admin.php"><i class="uil uil-user-circle"></i> Admin</a></li>
            <li><a href="<?php echo $fulldomain;?>"><i class="uil uil-newspaper"></i> Berita</a></li>
            <li><a href="logout.php"><i class="uil uil-signout"></i> Logout</a></li>
        </ul>
    </aside>