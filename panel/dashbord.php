<?php
include 'layout/header.php';
?>

<div class="content">
  <div class="judul">
    <h3>Dashbord</h3>
  </div>
  <style>
    .bg-pink {
      background-color: #fb6f92;
    }

    .dashbord .card i {
      text-align: center;
      font-size: 70px;
      color: #fff;
    }
    .sosmed .card i{
      text-align: center;
      font-size: 70px;
      color: #fb6f92;
    }
    
  </style>
  <?php
$koneksi = mysqli_connect('localhost', 'root', '', 'blog');


// Hitung jumlah data di tabel post
$queryPost = "SELECT COUNT(id) AS totalPost FROM post";
$resultPost = mysqli_query($koneksi, $queryPost);
$dataPost = mysqli_fetch_assoc($resultPost);
$totalPost = $dataPost['totalPost'];

// Hitung jumlah data di tabel kategori
$queryKategori = "SELECT COUNT(id) AS totalKategori FROM kategori";
$resultKategori = mysqli_query($koneksi, $queryKategori);
$dataKategori = mysqli_fetch_assoc($resultKategori);
$totalKategori = $dataKategori['totalKategori'];

// Hitung jumlah data di tabel admin
$queryAdmin = "SELECT COUNT(id) AS totalAdmin FROM admin";
$resultAdmin = mysqli_query($koneksi, $queryAdmin);
$dataAdmin = mysqli_fetch_assoc($resultAdmin);
$totalAdmin = $dataAdmin['totalAdmin'];

// Hitung jumlah data di tabel user
// $queryUser = "SELECT COUNT(id) AS totalUser FROM user";
// $resultUser = mysqli_query($koneksi, $queryUser);
// $dataUser = mysqli_fetch_assoc($resultUser);
// $totalUser = $dataUser['totalUser'];
?>

<div class="row dashbord mt-3">
    <div class="col-4">
        <div class="card card-body bg-pink bg-gradient text-center text-white">
            <i class="uil uil-blogger"></i>
            <h4><?php echo number_format($totalPost); ?></h4>
        </div>
    </div>
    <!-- <div class="col-3">
        <div class="card card-body bg-pink bg-gradient text-center text-white">
            <i class="uil uil-user"></i>
            <h4><?php echo number_format($totalUser); ?></h4>
        </div>
    </div> -->
    <div class="col-4">
        <div class="card card-body bg-pink bg-gradient text-center text-white">
            <i class="uil uil-user-circle"></i>
            <h4><?php echo number_format($totalAdmin); ?></h4>
        </div>
    </div>
    <div class="col-4">
        <div class="card card-body bg-pink bg-gradient text-center text-white">
            <i class="uil uil-apps"></i>
            <h4><?php echo number_format($totalKategori); ?></h4>
        </div>
    </div>
</div>



  <div class="row sosmed mt-4">
    <div class="col">
      <div class="card card-body bg-white text-center text-white" style="border:3px solid #fb6f92;">
      <i class="uil uil-facebook-f"></i>
      </div>
    </div>
    <div class="col">
      <div class="card card-body bg-white text-center text-white" style="border:3px solid #fb6f92;">
      <i class="uil uil-twitter"></i>
      </div>
    </div>
    <div class="col">
      <div class="card card-body bg-white text-center text-white" style="border:3px solid #fb6f92;">
      <i class="uil uil-youtube"></i>
      </div>
    </div>
    <div class="col">
      <div class="card card-body bg-white text-center text-white" style="border:3px solid #fb6f92;">
      <i class="uil uil-instagram-alt"></i>
      </div>
    </div>
    <div class="col">
      <a href="http://localhost/phpmyadmin/index.php?route=/database/structure&db=blog" target="_blank">
      <div class="card card-body bg-white text-center text-white" style="border:3px solid #fb6f92;">
      <i class="uil uil-database"></i>
      </div>
      </a>
    </div>
    
  </div>

</div>






<?php
include 'layout/footer.php';
?>