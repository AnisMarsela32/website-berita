<?php
include 'koneksi.php';
$db = new database();
$kategori = $db->tampil_kategori();

// Pastikan Anda telah memulai sesi
session_start();


// Inisialisasi nilai awal untuk $navbarIcon
// $navbarIcon = '<a class="nav-link btn btn-info" href="login.php">Masuk/Daftar</a>';
$navbarIcon = '<a  class="nav-link btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal">Masuk <i class="fas fa-sign-in-alt"></i> </a>';

// Periksa apakah pengguna sudah login sebagai admin
if (isset($_SESSION["admin_id"]) && isset($_SESSION["role"]) && $_SESSION["role"] == "1") {
    $navbarIcon2 = '<a class="nav-link btn btn-warning me-2" href="panel/dashbord.php">Dashbord</a>';
    $navbarIcon = '<a class="nav-link btn btn-info" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>';
}

// Periksa apakah pengguna sudah login sebagai user
if (isset($_SESSION["pimpinan_id"]) && isset($_SESSION["role"]) && $_SESSION["role"] == "2") {
    $navbarIcon2 = '<a class="nav-link btn btn-warning me-2" href="panel/dashbord.php">Dashbord</a>';
    $navbarIcon = '<a class="nav-link btn btn-info" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>';
}
?>
<!-- Kemudian dalam navbar Anda dapat menggunakan $navbarIcon seperti ini: -->


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Lorong Berita</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="layout/css/colors.css">
    <link rel="stylesheet" href="layout/css/style.css">

</head>

<body>

    <section class="bg" style="height: 10px;"></section>
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="image/lorong_berita_logo.png" alt="" style="width: 130px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <!-- menampilkan kategori -->
                    <?php
                    $no = 1;
                    foreach ($kategori as $k) {
                        if ($no <= 4) {
                    ?>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="kategori.php?id=<?php echo $k['id']; ?>"><?php echo $k['nama']; ?></a>
                            </li>
                    <?php
                        }
                        $no++;
                    }
                    ?>


                    <li class="nav-item">
                        <?php if (isset($navbarIcon2)) {
                            echo $navbarIcon2;
                        } ?>
                    </li>
                    <li class="nav-item">
                        <?php echo $navbarIcon; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>





    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " style="width: 400px;">
            <div class="modal-content">
                <form action="proses_login.php" method="post">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Masuk</h1>
                        <button type="button" class="btn-close close-button text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-container mx-auto my-4">
                            <span class="icon"><i class="fas fa-user"></i></span>
                            <input type="text" name="username" class="input-field" placeholder="Username">
                        </div>
                        <div class="input-container mx-auto mb-4">
                            <!-- Ikon untuk Password menggunakan Font Awesome -->
                            <span class="icon"><i class="fas fa-lock"></i></span>
                            <!-- Input field untuk Password -->
                            <input type="password" name="password" class="input-field" id="password" placeholder="Password">
                            <!-- Toggle button untuk menunjukkan/hide password -->
                            <span class="toggle-password" onclick="togglePasswordVisibility()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </span>
                        </div>
                        <!-- Tombol Submit -->
                    </div>
                    <div class="modal-footer mx-auto">
                        <button type="submit" class="submit-button">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>