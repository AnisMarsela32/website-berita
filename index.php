<?php
include 'layout/header.php';

// include 'koneksi.php';
// $db = new database();
$post = $db->tampil_data();
// $kategori = $db->tampil_kategori();
?>

<!-- Main Widget Start -->
<section class="main mt-5 mb-3">
    <div class="container jarak">
        <div class="row">


            <?php
            $no = 1;
            foreach ($post as $row) {
                if ($no == 1) {
            ?>
                    <div class="col-12 col-md-6" data-aos="fade-up">


                        <div class="main position-relative">
                            <img src="gambar/<?php echo $row['gambar']; ?>" class="img-main" alt="">
                            <div class="overlay">
                                <div class="teks">
                                    <a class="kat" href="kategori.php?id=<?= $row['kategori_id'] ?>"><?php echo $row['nama_kategori']; ?></a>
                                    <h3><a href="blog.php?post=<?= $row['slug'] ?>"><?php echo $row['judul']; ?></a></h3>
                                    <small class="text-light"><i class="fa-solid fa-calendar-days me-1"></i> <?php echo $row['tanggal_terbit']; ?></small>
                                </div>
                            </div>
                        </div>

                    </div>
            <?php
                }
                $no++;
            }
            ?>



            <?php
            $no = 1;
            foreach ($post as $row) {
                if ($no >= 2 && $no <= 3) {
            ?>
                    <div class="col-6 col-md-3" data-aos="fade-up">
                        <div class="card" style="height: 300px;">
                            <a href="blog.php?post=<?= $row['slug'] ?>"><img src="gambar/<?php echo $row['gambar']; ?>" class="card-img-top" alt="..."></a>
                            <div class="card-body">
                                <small class="text-secondary"><i class="fa-solid fa-calendar-days me-1"></i> <?php echo $row['tanggal_terbit']; ?></small>
                                <h6 class="card-text fw-bold"><a href="blog.php?post=<?= $row['slug'] ?>"><?php echo $row['judul']; ?></a></h6>
                            </div>
                        </div>
                    </div>
            <?php
                }
                $no++;
            }
            ?>





        </div>
    </div>
    </div>
</section>
<!-- Main Widget End -->



<div class="container jarak">
    <div class="row">

        <!-- Left Side Start-->
        <div class="col-12 col-md-8">


            <!-- Widget ke satu Start -->
            <section class="widget-1 mt-3">
                <div class="card card-body" data-aos="fade-up">
                    <div class="row">

                        <?php
                        $no = 1;
                        foreach ($post as $row) {
                            if ($no == 4) {
                        ?>
                                <div class="col-12 col-md-5 kolom-1">

                                    <div class="main position-relative" data-aos="fade-up">
                                        <img src="gambar/<?php echo $row['gambar']; ?>" alt="">
                                        <div class="overlay">
                                            <div class="teks">
                                                <a class="kat" href="kategori.php?id=<?= $row['kategori_id'] ?>"><?php echo $row['nama_kategori']; ?></a>
                                                <h5><a href="blog.php?post=<?= $row['slug'] ?>"><?php echo $row['judul']; ?></a></h5>
                                                <small class="text-white"><i class="fa-solid fa-calendar-days me-1"></i> <?php echo $row['tanggal_terbit']; ?></small>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                        <?php
                            }
                            $no++;
                        }
                        ?>



                        <div class="col-12 col-md-7 kolom-2 ">


                            <?php
                            $no = 1;
                            foreach ($post as $row) {
                                if ($no >= 5 && $no <= 8) {
                            ?>
                                    <div class="d-flex justify-content-start mb-3">
                                        <a href="blog.php?post=<?= $row['slug'] ?>"><img src="gambar/<?php echo $row['gambar']; ?>" alt=""></a>
                                        <a class="judul" href="blog.php?post=<?= $row['slug'] ?>"><?php echo $row['judul']; ?></a>
                                    </div>
                            <?php
                                }
                                $no++;
                            }
                            ?>


                        </div>


                    </div>
                </div>
            </section>
            <!-- Widget ke satu End -->



            <!-- Widget ke dua Start -->
            <section class="widget-2 mt-3">
                <div class="row">
                    <col-12 class="col-md-6 kolom">
                        <div class="card card-body" data-aos="fade-up">

                            <?php
                            $no = 1;
                            foreach ($post as $row) {
                                if ($no == 9) {
                            ?>
                                    <div class="kolom-1">
                                        <div class="main position-relative">
                                            <img src="gambar/<?php echo $row['gambar']; ?>" alt="">
                                            <div class="overlay">
                                                <div class="teks">
                                                    <a class="kat" href="kategori.php?id=<?= $row['kategori_id'] ?>"><?php echo $row['nama_kategori']; ?></a>
                                                    <h5><a href="blog.php?post=<?= $row['slug'] ?>"><?php echo $row['judul']; ?></a></h5>
                                                    <small class="text-white"><i class="fa-solid fa-calendar-days me-1"></i> <?php echo $row['tanggal_terbit']; ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                                $no++;
                            }
                            ?>


                            <?php
                            $no = 1;
                            foreach ($post as $row) {
                                if ($no >= 10 && $no <= 12) {
                            ?>
                                    <div class="d-flex justify-content-start sub-widget" data-aos="fade-up">
                                        <a href="blog.php?post=<?= $row['slug'] ?>"><img src="gambar/<?php echo $row['gambar']; ?>" alt=""></a>
                                        <a class="judul" href="blog.php?post=<?= $row['slug'] ?>"><?php echo $row['judul']; ?></a>
                                    </div>
                            <?php
                                }
                                $no++;
                            }
                            ?>


                        </div>
                    </col-12>

                    <col-12 class="col-md-6 kolom">
                        <div class="card card-body" data-aos="fade-up">

                            <?php
                            $no = 1;
                            foreach ($post as $row) {
                                if ($no == 13) {
                            ?>
                                    <div class="kolom-1">
                                        <div class="main position-relative">
                                            <img src="gambar/<?php echo $row['gambar']; ?>" alt="">
                                            <div class="overlay">
                                                <div class="teks">
                                                    <a class="kat" href="kategori.php?id=<?= $row['kategori_id'] ?>"><?php echo $row['nama_kategori']; ?></a>
                                                    <h5><a href="blog.php?post=<?= $row['slug'] ?>"><?php echo $row['judul']; ?></a></h5>
                                                    <small class="text-white"><i class="fa-solid fa-calendar-days me-1"></i> <?php echo $row['tanggal_terbit']; ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                                $no++;
                            }
                            ?>



                            <?php
                            $no = 1;
                            foreach ($post as $row) {
                                if ($no >= 14 && $no <= 16) {
                            ?>
                                    <div class="d-flex justify-content-start sub-widget" data-aos="fade-up">
                                        <a href="blog.php?post=<?= $row['slug'] ?>"><img src="gambar/<?php echo $row['gambar']; ?>" alt=""></a>
                                        <a class="judul" href="blog.php?post=<?= $row['slug'] ?>"><?php echo $row['judul']; ?></a>
                                    </div>
                            <?php
                                }
                                $no++;
                            }
                            ?>

                        </div>
                    </col-12>
                </div>
            </section>
            <!-- Widget ke dua End -->


            <section class="mt-3">
                <div class="card card-body">
                    <div class="row">
                        <?php
                        $no = 1;
                        foreach ($post as $row) {
                            if ($no >= 21 && $no <= 26) {
                        ?>
                                <div class="col-6 mb-3" data-aos="fade-up">
                                    <a href="blog.php?post=<?= $row['slug'] ?>"><img src="gambar/<?php echo $row['gambar']; ?>" class="mb-2" style="height: 170px;"></a>
                                    <small class="text-secondary"><i class="fa-solid fa-calendar-days me-1"></i>  <?php echo $row['tanggal_terbit']; ?></small><br>
                                    <a class="judul fw-bold" href="blog.php?post=<?= $row['slug'] ?>"><h5><?php echo $row['judul']; ?></h5></a>
                                    <a class="text-body-secondary font-6" href="blog.php?post=<?= $row['slug'] ?>"><?php echo $row['ringkas']; ?></a>
                                </div>
                        <?php
                            }
                            $no++;
                        }
                        ?>
                    </div>
                </div>
            </section>

            <!-- Widget ke tiga Start -->
            <section class="widget-3 mt-3">
                <div class="card card-body" data-aos="fade-up">
                    <div class="row">

                        <?php
                        $no = 1;
                        foreach ($post as $row) {
                            if ($no == 17) {
                        ?>
                                <div class="col-12 kolom-1">
                                    <div class="main position-relative">
                                        <img src="gambar/<?php echo $row['gambar']; ?>" alt="">
                                        <div class="overlay">
                                            <div class="teks">
                                                <a class="kat" href="blog.php?id=<?= $row['id'] ?>"><?php echo $row['nama_kategori']; ?></a>
                                                <h3><a href="blog.php?post=<?= $row['slug'] ?>"><?php echo $row['judul']; ?></a></h3>
                                                <small class="text-white"><i class="fa-solid fa-calendar-days me-1"></i> <?php echo $row['tanggal_terbit']; ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                            $no++;
                        }
                        ?>


                        <?php
                        $no = 1;
                        foreach ($post as $row) {
                            if ($no >= 18 && $no <= 20) {
                        ?>
                                <div class="col-6 col-md-4 mt-3 sub-widget" data-aos="fade-up">
                                    <a href="blog.php?post=<?= $row['slug'] ?>"><img src="gambar/<?php echo $row['gambar']; ?>" class="mb-2" alt=""></a>
                                    <small class="text-secondary"><i class="fa-solid fa-calendar-days me-1"></i> <?php echo $row['tanggal_terbit']; ?></small><br>
                                    <a class="judul" href="blog.php?post=<?= $row['slug'] ?>"><?php echo $row['judul']; ?></a>

                                </div>
                        <?php
                            }
                            $no++;
                        }
                        ?>


                    </div>
                </div>
            </section>
            <!-- Widget ke tiga End -->

            



        </div>
        <!-- Left Side End-->






        <!-- Right Side Start -->
        <div class="col-12 col-md-4">
            <!-- Widget ke 4 Start -->
            <div class="widget-4  mt-3">
                <div class="card card-body sosmed" data-aos="fade-up">
                    <div class="row">
                        <div class="col-6 mb-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=https://lorongberita.com" style="background-color: #4267B2;"><i class="fab fa-facebook-f"></i></a>
                        </div>
                        <div class="col-6 mb-2">
                            <a href="https://twitter.com/intent/tweet?url=https://lorongberita.com&text=Check%20out%20LorongBerita" style="background-color: #1DA1F2;"><i class="fab fa-twitter"></i></a>
                        </div>
                        <div class="col-6">
                            <a href="" style="background: linear-gradient(42deg, rgba(249,206,52,1) 21%, rgba(242,70,141,1) 58%, rgba(150,87,194,1) 79%);"><i class="fab fa-instagram"></i></a>
                        </div>
                        <div class="col-6">
                            <a href="" style="background-color: #f00;"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Widget ke 4 End -->
            <div class="position-sticky" style="top: 1rem;">


                <!-- Widget ke 5 Start -->
                <div class="widget-5 mt-3">
                    <div class="card card-body">

                        <?php
                        $no = 1;
                        foreach ($post as $row) {
                            if ($no == 30) {
                        ?>
                                <div class="main position-relative">
                                    <img src="gambar/<?php echo $row['gambar']; ?>" alt="" style="height: 200px;">
                                    <div class="overlay">
                                        <div class="teks">
                                            <a class="kat" href="blog.php?id=<?= $row['id'] ?>"><?php echo $row['nama_kategori']; ?></a>
                                            <h6><a href="blog.php?post=<?= $row['slug'] ?>"><?php echo $row['judul']; ?></a></h6>
                                            <small class="text-white"><i class="fa-solid fa-calendar-days me-1"></i> <?php echo $row['tanggal_terbit']; ?></small>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                            $no++;
                        }
                        ?>


                        <?php
                        $no = 1;
                        foreach ($post as $row) {
                            if ($no >= 32 && $no <= 34) {
                        ?>
                                <div class="d-flex justify-content-start sub-widget">
                                    <a href="blog.php?post=<?= $row['slug'] ?>"><img src="gambar/<?php echo $row['gambar']; ?>" alt=""></a>
                                    <a class="judul" href="blog.php?post=<?= $row['slug'] ?>"><?php echo $row['judul']; ?></a>
                                </div>
                        <?php
                            }
                            $no++;
                        }
                        ?>


                    </div>
                </div>
                <!-- Widget ke 5 End -->




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
        <!-- Right Side End -->




    </div> <!-- end row -->
</div> <!-- end container -->

<!-- Tombol "To the Top" -->
<button id="toTopBtn" onclick="scrollToTop()"><i class="fa-solid fa-angles-up"></i></button>


<?php

include 'layout/footer.php';

?>