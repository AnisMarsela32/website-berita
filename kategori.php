<?php
include 'layout/header.php';

// include 'koneksi.php';

// instansi class database
// $db = new database();

// menangkap data id dari url
$id = $_GET['id'];
$slug = $_GET['slug'];

// mengambil funtion tampil post
// $post_kategori = $db->tampil_post_kategori($db->koneksi, $id);
$post = $db->tampil_post($id);
$data_baru = $db->tampil_data();


// Menentukan jumlah item per halaman
$itemPerHalaman = 10;

// Menentukan halaman saat ini
$halamanSaatIni = isset($_GET['page']) ? $_GET['page'] : 1;

// Menghitung offset
$offset = ($halamanSaatIni - 1) * $itemPerHalaman;

// Mengambil data dari database
$post_kategori = $db->tampil_post_kategori($db->koneksi, $slug);

// Menghitung jumlah total data
$totalData = count($post_kategori);

// Menghitung jumlah total halaman
$totalHalaman = ceil($totalData / $itemPerHalaman);


?>


<div class="container mt-5 jarak2">
    <div class="row">

        <!-- left side -->
        <div class="col-12 col-md-8">


            <section class="kategori">
                <div class="card card-body" data-aos="fade-up">
                    
                    <div class="row">


                        <?php
                        for ($i = $offset; $i < min($offset + $itemPerHalaman, $totalData); $i++) {
                            $row = $post_kategori[$i];
                        ?>
                            <div class="col-12 mt-3" data-aos="fade-up">
                                <div class="position-relative">
                                    <a class="btn btn-primary tag"><?php echo $row['nama_kategori']; ?></a>
                                    <a href="blog.php?post=<?= $row['slug'] ?>"><img src="gambar/<?php echo $row['gambar']; ?>" alt="" style="height: 200px;"></a>
                                </div>
                                <div class="detail">
                                    <h4><a href="blog.php?post=<?= $row['slug'] ?>"><?php echo $row['judul']; ?></a></h4>
                                    <p class="rata-kk"><?php echo $row['ringkas']; ?></p>
                                </div>
                            </div>


                        <?php } ?>

                    </div>

                </div>


            </section>



            <!-- // Menampilkan tautan ke halaman-halaman lainnya -->
            
            <div class="container mt-3">
                <ul class="pagination justify-content-center" data-aos="fade-up">
                    <?php if ($halamanSaatIni > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?id=<?= $id ?>&page=<?= $halamanSaatIni - 1 ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalHalaman; $i++) : ?>
                        <?php if ($i == $halamanSaatIni) : ?>
                            <li class="page-item active" aria-current="page">
                                <span class="page-link"><?= $i ?></span>
                            </li>
                        <?php else : ?>
                            <li class="page-item">
                                <a class="page-link" href="?id=<?= $id ?>&page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($halamanSaatIni < $totalHalaman) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?id=<?= $id ?>&page=<?= $halamanSaatIni + 1 ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>






        </div> <!-- end col -->






        <!-- right side -->
        <div class="col-12 col-md-4">
            <div class="widget-4">
                <div class="card card-body sosmed">
                    <div class="row">
                        <div class="col-6 mb-2">
                            <a href="" style="background-color: #4267B2;"><i class="fab fa-facebook fs-5"></i></a>
                        </div>
                        <div class="col-6 mb-2">
                            <a href="" style="background-color: #1DA1F2;"><i class="fab fa-twitter fs-5"></i></a>
                        </div>
                        <div class="col-6">
                            <a href="" style="background-color: #f00;"><i class="fab fa-youtube fs-5"></i></a>
                        </div>
                        <div class="col-6">
                            <a href="" style="background: linear-gradient(42deg, rgba(249,206,52,1) 21%, rgba(242,70,141,1) 58%, rgba(150,87,194,1) 79%);"><i class="fab fa-instagram fs-5"></i></a>
                        </div>
                    </div>
                </div>

            </div>


            <div class="position-sticky" style="top: 1rem">
            <div class="widget-5 mt-3">
                <div class="card card-body">

                    <?php
                    // Acak urutan elemen dalam array
                    shuffle($data_baru);

                    $no = 1;
                    foreach ($data_baru as $d) {
                        if ($no == 1) {
                    ?>
                            <div class="main position-relative">
                                <img src="gambar/<?php echo $d['gambar']; ?>" alt="" style="height: 200px;">
                                <div class="overlay">
                                    <div class="teks">
                                        <a class="kat" href="kategori.php?id=<?= $d['kategori_id'] ?>"><?php echo $d['nama_kategori']; ?></a>
                                        <h4><a href="blog.php?post=<?= $d['slug'] ?>"><?php echo $d['judul']; ?></a></h4>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                        $no++;
                    }
                    ?>




                    <?php
                    // Acak urutan elemen dalam array
                    shuffle($data_baru);

                    $no = 1;
                    foreach ($data_baru as $d) {
                        if ($no >= 2 && $no <= 4) {
                    ?>
                            <div class="d-flex justify-content-start sub-widget">
                                <a href="blog.php?post=<?= $d['slug'] ?>"><img src="gambar/<?php echo $d['gambar']; ?>" alt=""></a>
                                <a class="judul" href="blog.php?post=<?= $d['slug'] ?>"><?php echo $d['judul']; ?></a>
                            </div>
                    <?php
                        }
                        $no++;
                    }
                    ?>


                </div>
            </div>



            <!-- Widget ke 6 Start -->

            <div class="widget-6 mt-3" data-aos="fade-up">
                    <h5 class="mb-3 fw-bold">Kategori</h5>
                    <?php
                    foreach ($kategori as $k) {
                    ?>
                        <a href="kategori.php?slug=<?php echo $k['slug']; ?>&id=<?php echo $k['id']; ?>"><?php echo $k['nama']; ?></a>
                    <?php } ?>
                </div>
                <!-- Widget ke 6 End -->
            </div>

        </div>





    </div> <!-- end row -->
</div> <!-- end container -->

<!-- Tombol "To the Top" -->
<button id="toTopBtn" onclick="scrollToTop()"><i class="fa-solid fa-angles-up"></i></button>








<?php
include 'layout/footer.php';

?>