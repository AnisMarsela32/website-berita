<?php
include 'layout/header.php';

// include 'koneksi.php';

// instansi class database
// $db = new database();
// menangkap data id dari url

$post_id = $_GET['post'];

// mengambil funtion tampil post
$post = $db->tampil_post($post_id);
$data_baru = $db->tampil_data();
// $kategori = $db->tampil_kategori();

?>



<div class="container jarak2 mt-5">
    <div class="row">

        <!-- left side -->
        <div class="col-12 col-md-8">

            <?php
            foreach ($post as $row) {
            ?>
                <section>
                    <div class="card card-body px-4" data-aos="fade-up">

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="kategori.php?id=<?php echo $row['kategori_id']; ?>"><?php echo $row['nama_kategori']; ?></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Blog</li>
                            </ol>
                        </nav>

                        <h1><?php echo $row['judul']; ?></h1>
                        <small><i class="fa-solid fa-calendar-days me-1"></i><?php echo $row['tanggal_terbit']; ?></small>
                        <img src="gambar/<?php echo $row['gambar']; ?>" class="mt-3" alt="">

                        <p class="mt-3"><?php echo $row['isi']; ?></p>

                        <!-- <div class="share my-3">
                            <a><i class="fas fa-share-alt"></i></a>
                            <a href=""><i class="fab fa-facebook-f"></i> Facebook</a>
                            <a href=""><i class="fab fa-twitter"></i> Twitter</a>
                            <a href=""><i class="fab fa-whatsapp"></i></a>
                            <a href=""><i class="far fa-envelope"></i></a>
                            <a href="" data-bs-toggle="modal" data-bs-target="#share"><i class="fas fa-plus"></i></a>
                        </div> -->
                        <div class="share my-3">
                            <a><i class="fas fa-share-alt"></i></a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $row['slug']; ?>" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo $row['slug']; ?>" target="_blank"><i class="fab fa-twitter"></i> Twitter</a>
                            <a href="https://api.whatsapp.com/send?text=<?php echo $row['slug']; ?>" target="_blank"><i class="fab fa-whatsapp"></i></a>
                            <a href="mailto:?body=<?php echo $row['slug']; ?>"><i class="far fa-envelope"></i></a>
                            <a href="" data-bs-toggle="modal" data-bs-target="#share"><i class="fas fa-plus"></i></a>
                        </div>

                    </div>


                    <!-- membuat komentar  -->
                    <?php
                    // Check if the form is submitted
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        // Get the comment and user information from the form
                        $name = $_POST['name'];
                        $comment = $_POST['comment'];
                        $post_id = $_POST['post_id']; // Mengambil post_id dari form

                        // Insert the comment into the database
                        $query = "INSERT INTO komentar (post_id, name, comment) VALUES ('$post_id','$name', '$comment')";
                        $result = mysqli_query($db->koneksi, $query);

                        if ($result) {
                            // Comment added successfully
                            echo '<script>alert("Berhasil menambahkan komentar!");</script>';
                        } else {
                            // Error adding comment
                            echo '<script>alert("Gagal menambahkan komentar!");</script>';
                        }
                    }

                    // Retrieve comments for a specific post from the database
                    $query = "SELECT * FROM komentar WHERE post_id = $post_id ORDER BY id DESC LIMIT 3"; // Ubah sesuai kebutuhan
                    $result = mysqli_query($db->koneksi, $query);

                    // Pastikan query berhasil sebelum menggunakan mysqli_fetch_all
                    if ($result) {
                        $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    } else {
                        $comments = array(); // Atur ke array kosong jika query tidak berhasil
                    }
                    ?>

                    <div class="card card-body mt-3" data-aos="fade-up">
                        <h3>Komentar</h3>

                        <!-- Comment form -->
                        <form method="post">
                            <div class="my-3">
                                <label for="name" class="form-label">Nama:</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-1">
                                <label for="comment" class="form-label">Tulis Komentarmu :</label>
                                <textarea class="form-control" name="comment" rows="3" required></textarea>
                            </div>
                            <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-primary rounded-0">Kirim</button>
                        </form>

                        <hr>

                        <!-- Display existing comments -->
                        <?php foreach ($comments as $comment) : ?>
                            <div class="media mb-1 mt-3">
                                <div class="media-body">
                                    <div class="row">
                                        <div class="col-1">

                                            <img src="image/avatar.jpg" class="me-3 mt-1 rounded-circle" alt="User Avatar" style="width: 40px;">
                                        </div>
                                        <div class="col">

                                            <h6 class="mt-0 text-biru"><?php echo htmlspecialchars($comment['name']); ?></h6>
                                            <p><?php echo htmlspecialchars($comment['comment']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>



                    </div>



                    <!-- berita terkait -->
                    <div class="card card-body mt-3" data-aos="fade-up">
                        <h3>Berita Terkait</h3>
                        <div class="row">

                            <?php

                            $berita_lain = $db->tampil_post_kategori($db->koneksi, $row['kategori_slug']);

                            // Acak array
                            shuffle($berita_lain);

                            $counter = 0;
                            foreach ($berita_lain as $berita) {
                                if ($counter >= 3) {
                                    break;
                                }
                            ?>
                                <div class="col-6 col-md-4">
                                    <a href="blog.php?post=<?= $berita['slug'] ?>"><img src="gambar/<?php echo $berita['gambar']; ?>" class="mb-2" style="height: 150px;" alt=""></a>
                                    <small><i class="fa-solid fa-calendar-days me-1"></i><?php echo $berita['tanggal_terbit']; ?></small><br>
                                    <a href="blog.php?post=<?= $berita['slug'] ?>"><?php echo $berita['judul']; ?></a><br>
                                </div>
                            <?php
                                $counter++;
                            }
                            ?>


                        </div>
                    </div>
                </section>
            <?php } ?>



        </div> <!-- end col -->






        <!-- right side -->
        <div class="col-12 col-md-4">
            <div class="widget-4">
                <div class="card card-body sosmed" data-aos="fade-up">
                    <div class="row">
                        <div class="col-6 mb-2">
                            <a href="" style="background-color: #4267B2;"><i class="fab fa-facebook fs-5"></i></a>
                        </div>
                        <div class="col-6 mb-2">
                            <a href="" style="background-color: #1DA1F2;"><i class="fab fa-twitter fs-5"></i></a>
                        </div>
                        <div class="col-6">
                            <a href="" style="background: linear-gradient(42deg, rgba(249,206,52,1) 21%, rgba(242,70,141,1) 58%, rgba(150,87,194,1) 79%);"><i class="fab fa-instagram fs-5"></i></a>
                        </div>
                        <div class="col-6">
                            <a href="" style="background-color: #f00;"><i class="fab fa-youtube fs-5"></i></a>
                        </div>

                    </div>
                </div>

            </div>


            <div class="position-sticky" style="top: 1rem;">
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