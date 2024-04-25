<?php

$koneksi = mysqli_connect('localhost', 'root', '', 'blog');


if (isset($_GET['aksi']) && $_GET['aksi'] == 'print') {
  echo "<script>
      window.onload = function() {
          window.print();
      }
  </script>";

?>

      <head>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
      </head>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 1rem;
    }

    table,
    th,
    td {
      border: 1px solid black;
    }

    th,
    td {
      padding: 10px;
    }
  </style>
  <table>
    <div class="row">
      <div class="col d-flex align-content-center">
        <img src="../image/logo.png" style="width: 220px;">
      </div>
      <div class="col text-end">
        <h2>MyPangandaran</h2>
        <h3 class="text-secondary">Informasi Wisata Pangandara</h3>
        <p>Alamat: Jalan Pantai Indah No. 123, Pangandaran <br> Nomor Telepon: 0812-345-6789 <br> Email: info@mypangandaran.com</p>
      </div>
    </div>
  </table>
  <!-- <img src="../image/logo.png" alt="" style="width: 100%;height: 150px;"> -->
  <hr>
  <table border="1" cellpadding="0">
    <thead class="bg-primary">
      <tr>
        <th style="width: 5%;">No</th>
        <th style="width: 70%;">Judul</th>
        <th>Kategori</th>
      </tr>
    </thead>
    <tbody>



      <?php
      // Query SQL untuk menampilkan data dengan pagination, data 1 hingga 10
      $query = "SELECT post.*, kategori.nama AS nama_kategori FROM post 
      INNER JOIN kategori ON post.kategori_id = kategori.id 
      ORDER BY post.create_at DESC 
      LIMIT 0, 10"; // LIMIT (offset, jumlah data)
      $result = mysqli_query($koneksi, $query);


      $no = 1; // Nomor urutan data
      while ($data = mysqli_fetch_assoc($result)) {
      ?>
        <tr>
          <td><?php echo $no++; ?></td>
          <td><?php echo $data['judul']; ?></td>
          <td style="text-align: center;"><?php echo $data['nama_kategori']; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <?php
}


// Memasukkan layout/header.php hanya jika aksi bukan 'print'
if (!isset($_GET['aksi']) || $_GET['aksi'] != 'print') {
  include 'layout/header.php';
}


// Fungsi tambah data
if (isset($_GET['aksi']) && $_GET['aksi'] == 'tambah') {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $ringkas = $_POST['ringkas'];
    $isi = $_POST['isi'];

    // Periksa apakah kategori sudah ada atau perlu ditambahkan
    $kategori_nama = $_POST['kategori'];
    $query_kategori = "SELECT id FROM kategori WHERE nama = '$kategori_nama'";
    $result_kategori = mysqli_query($koneksi, $query_kategori);

    if (mysqli_num_rows($result_kategori) > 0) {
      // Kategori sudah ada, ambil ID kategori
      $row_kategori = mysqli_fetch_assoc($result_kategori);
      $kategori_id = $row_kategori['id'];
    } else {
      // Kategori belum ada, tambahkan kategori
      $query_tambah_kategori = "INSERT INTO kategori (nama) VALUES ('$kategori_nama')";
      $result_tambah_kategori = mysqli_query($koneksi, $query_tambah_kategori);

      if ($result_tambah_kategori) {
        // Ambil ID kategori yang baru saja ditambahkan
        $kategori_id = mysqli_insert_id($koneksi);
      } else {
        // Menampilkan pesan kesalahan jika gagal menambahkan kategori
        echo "Gagal menambahkan kategori: " . mysqli_error($koneksi);
        // Keluar dari skrip atau tampilkan pesan kesalahan ke pengguna
      }
    }

    // Buat slug dari judul
    $slug = slugify($judul);

    // Proses upload gambar (jika diperlukan)
    $gambar = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $lokasi_gambar = '../gambar/' . $gambar;

    move_uploaded_file($gambar_tmp, $lokasi_gambar);

    // Query SQL untuk menambah data
    $query = "INSERT INTO post (judul, ringkas, isi, gambar, kategori_id, slug) VALUES ('$judul', '$ringkas', '$isi', '$gambar', $kategori_id, '$slug')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
      echo "<script>
                  Swal.fire({
                      title: 'Sukses',
                      text: 'Berhasil Tambah Data',
                      icon: 'success',
                      confirmButtonText: 'OK'
                  }).then(function() {
                      window.location.href = 'blog.php';
                  });

                  </script>";
    } else {
      echo "<script>
                  Swal.fire({
                      title: 'Oopps',
                      text: 'Gagal Tambah Data',
                      icon: 'error',
                      confirmButtonText: 'OK'
                  }).then(function() {
                      window.location.href = 'blog.php';
                  });

                  </script>";
    }
  } else {
    // Menampilkan form tambah data
  ?>
    <!-- Formulir input data -->
    <div class="content">
      <div class="judul">
        <h3>Blog</h3>
      </div>
      <div class="komponen p-3">
        <div class="row">
          <div class="col  justify-content-start">
            <h4>Tambah Blog</h4>
          </div>
          <div class="col d-flex justify-content-end">
            <a href="blog.php" class="btn btn-primary"><i class="uil uil-arrow-circle-left me-1"></i> Kembali</a>
          </div>
        </div>
      </div>
      <table class="tb">
        <form method="post" enctype="multipart/form-data">
          <tr>
            <td style="width: 30%;">Kategori</td>
            <td><input type="text" name="kategori" style="width: fit-content" required></td>
          </tr>
          <tr>
            <td>Judul</td>
            <td><input type="text" name="judul" style="width: 400px;" required></td>
          </tr>
          <tr>
            <td>Ringkas</td>
            <td><textarea name="ringkas" id="ringkas" cols="60" rows="6" required></textarea></td>
          </tr>
          <tr>
            <td>Lengkap</td>
            <td><textarea name="isi" id="summernote" cols="30" rows="10"></textarea></td>
          </tr>
          <tr>
            <td>Gambar</td>
            <td><input type="file" name="gambar"></td>
          </tr>
          <tr>
            <td colspan="2">
              <button type="submit" name="tambah_data" class="btn btn-danger">Simpan</button>
              <a href="blog.php" class="btn btn-danger">Batal</a>
            </td>
          </tr>
        </form>
      </table>
    </div>
  <?php
  }
}

// Fungsi untuk membuat slug dari judul
function slugify($text)
{
  // Membuang karakter non-alfanumerik
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
  // Mengonversi teks menjadi huruf kecil
  $text = strtolower($text);
  // Menghapus karakter non-alfanumerik atau tanda hubung berlebihan
  $text = preg_replace('~[^-\w]+~', '', $text);
  // Menghapus tanda hubung di awal dan akhir
  $text = trim($text, '-');
  return $text;
}



// Fungsi edit data
if (isset($_GET['aksi']) && $_GET['aksi'] == 'edit') {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $ringkas = $_POST['ringkas'];
    $isi = $_POST['isi'];
    $kategori = $_POST['kategori']; // Menggunakan input teks untuk kategori

    // Check if a new image was uploaded
    if (!empty($_FILES['gambar']['name'])) {
      // Get the name of the uploaded image
      $gambar = $_FILES['gambar']['name'];
      $gambar_tmp = $_FILES['gambar']['tmp_name'];
      $lokasi_gambar = '../gambar/' . $gambar;

      // Move the uploaded image to the desired location
      move_uploaded_file($gambar_tmp, $lokasi_gambar);
    }

    // Periksa apakah nama kategori sudah ada di tabel kategori
    $query_kategori = "SELECT id FROM kategori WHERE nama = '$kategori'";
    $result_kategori = mysqli_query($koneksi, $query_kategori);

    if (mysqli_num_rows($result_kategori) > 0) {
      // Kategori sudah ada, ambil ID kategori
      $row_kategori = mysqli_fetch_assoc($result_kategori);
      $kategori_id = $row_kategori['id'];
    } else {
      // Kategori belum ada, tambahkan kategori
      $query_tambah_kategori = "INSERT INTO kategori (nama) VALUES ('$kategori')";
      $result_tambah_kategori = mysqli_query($koneksi, $query_tambah_kategori);

      if ($result_tambah_kategori) {
        // Ambil ID kategori yang baru saja ditambahkan
        $kategori_id = mysqli_insert_id($koneksi);
      } else {
        // Menampilkan pesan kesalahan jika gagal menambahkan kategori
        echo "Gagal menambahkan kategori: " . mysqli_error($koneksi);
        // Keluar dari skrip atau tampilkan pesan kesalahan ke pengguna
      }
    }

    // Buat slug dari judul
    $slug = slugify($judul);

    // Query SQL untuk memperbarui data
    if (!empty($_FILES['gambar']['name'])) {
      $query = "UPDATE post SET judul='$judul', ringkas='$ringkas', isi='$isi', gambar='$gambar', kategori_id=$kategori_id, slug='$slug' WHERE id=$id";
    } else {
      $query = "UPDATE post SET judul='$judul', ringkas='$ringkas', isi='$isi', kategori_id=$kategori_id, slug='$slug' WHERE id=$id";
    }

    // Execute the query
    $result = mysqli_query($koneksi, $query);

    if ($result) {
      echo "<script>
              Swal.fire({
                  title: 'Sukses',
                  text: 'Berhasil Ubah Data',
                  icon: 'success',
                  confirmButtonText: 'OK'
              }).then(function() {
                  window.location.href = 'blog.php';
              });

              </script>";
    } else {
      echo "Gagal mengedit data: " . mysqli_error($koneksi);
    }
  } else {
    // Menampilkan form edit data
    $id = $_GET['id'];
    $query = "SELECT * FROM post WHERE id=$id";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);
    $kategori_id = $data['kategori_id'];

    // Mengambil nama kategori berdasarkan kategori_id
    $kategori_query = "SELECT nama FROM kategori WHERE id = $kategori_id";
    $kategori_result = mysqli_query($koneksi, $kategori_query);
    $kategori_data = mysqli_fetch_assoc($kategori_result);
    $kategori_nama = $kategori_data['nama'];
  ?>

    <!-- Edit Data Form -->
    <div class="content">
      <div class="judul">
        <h3>Blog</h3>
      </div>
      <div class="komponen p-3">
        <div class="row">
          <div class="col  justify-content-start">
            <h4>Edit Blog</h4>
          </div>
          <div class="col d-flex justify-content-end">
            <a href="blog.php" class="btn btn-primary"><i class="uil uil-arrow-circle-left me-1"></i> Kembali</a>
          </div>
        </div>
      </div>
      <table class="tb">
        <form method="post" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
          <tr>
            <td style="width: 30%;">Kategori</td>
            <td><input type="text" name="kategori" style="width: fit-content" value="<?php echo $kategori_nama; ?>" required></td>
          </tr>
          <tr>
            <td>Judul</td>
            <td><input type="text" name="judul" style="width: 400px;" value="<?php echo $data['judul']; ?>" required></td>
          </tr>
          <tr>
            <td>Ringkas</td>
            <td><textarea name="ringkas" id="ringkas" cols="60" rows="6" required><?php echo $data['ringkas']; ?></textarea></td>
          </tr>
          <tr>
            <td>Lengkap</td>
            <td><textarea name="isi" id="summernote" cols="30" rows="10"><?php echo $data['isi']; ?></textarea></td>
          </tr>
          <tr>
            <td>Gambar</td>
            <td>
              <img src="../gambar/<?php echo $data['gambar']; ?>" style="width: 150px;" class="mb-2"><br>
              <input type="file" name="gambar">
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <button type="submit" name="edit_data" class="btn btn-danger">Simpan Perubahan</button>
            </td>
          </tr>
        </form>
      </table>
    </div>

  <?php
  }
}


// Fungsi detail data
if (isset($_GET['aksi']) && $_GET['aksi'] == 'detail') {
  $id = $_GET['id'];
  $query = "SELECT post.*, kategori.nama AS nama_kategori, kategori.slug AS kategori_slug 
FROM post 
JOIN kategori ON post.kategori_id = kategori.id 
WHERE post.id = $id;";
  $result = mysqli_query($koneksi, $query);
  $data = mysqli_fetch_assoc($result);
  ?>

  <!-- Detail Data -->
  <!-- <div class="content">
    <div class="judul">
      <h3>Detail Data</h3>f
    </div>
    <div class="komponen p-3">
      <h5 class="text-danger"><?php echo $data['judul']; ?></h5>
      <p><?php echo $data['ringkas']; ?></p>
      <p><?php echo $data['isi']; ?></p>
      <p>Kategori ID: <?php echo $data['kategori_id']; ?></p>
    </div>
  </div> -->

  <div class="content">
    <div class="judul">
      <h3>Blog</h3>
    </div>
    <div class="komponen p-3">
      <div class="row">
        <div class="col  justify-content-start">
          <h4>Detail Blog</h4>
          <!-- <input type="text" class="form-control" id="search"><i class="uil uil-plus-circle"></i> -->
        </div>

        <div class="col d-flex justify-content-end">
          <a href="blog.php" class="btn btn-primary"><i class="uil uil-arrow-circle-left me-1"></i> Kembali</a>
        </div>
      </div>
    </div>
    <table class="tb">
      <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
      <tr>
        <td style="width: 30%;">Kategori</td>
        <td>
          <!-- <select name="kategori_id" id="kategori_id" required> -->
            <!-- Tambahkan pilihan kategori dari database di sini -->
            <?php
            // $kategori_query = "SELECT * FROM kategori";
            // $kategori_result = mysqli_query($koneksi, $kategori_query);
            // while ($kategori_data = mysqli_fetch_assoc($kategori_result)) {
            //   $selected = ($kategori_data['id'] == $data['kategori_id']) ? 'selected' : '';
            //   echo "<option value='" . $kategori_data['id'] . "' $selected>" . $kategori_data['nama'] . "</option>";
            // }
            ?>
          </select>
          <input type="text" value="<?php echo $data['nama_kategori']; ?>">
        </td>
      </tr>
      <tr>
        <td>Judul</td>
        <td><input type="text" name="judul" style="width: 400px;" value="<?php echo $data['judul']; ?>" required></td>
      </tr>
      <tr>
        <td>Slug</td>
        <td><input type="text" name="slug" style="width: 400px;" value="<?php echo $data['slug']; ?>" required></td>
      </tr>
      <tr>
        <td>Ringkas</td>
        <td><textarea name="ringkas" id="ringkas" cols="60" rows="6" required><?php echo $data['ringkas']; ?></textarea></td>
      </tr>
      <tr>
        <td>Lengkap</td>
        <td><textarea name="isi" id="summernote" cols="30" rows="10"><?php echo $data['isi']; ?></textarea></td>
      </tr>
      <tr>
        <td>Gambar</td>
        <td>
          <img src="../gambar/<?php echo $data['gambar']; ?>" style="width: 150px;" class="mb-2"><br>
          <input type="file" name="gambar" required>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <a href="blog.php" name="edit_data" class="btn btn-danger">Ok</a>
        </td>
      </tr>
    </table>
  </div>

<?php
}



if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus' && isset($_GET['id'])) {
  $id = $_GET['id'];

  // Tambahkan SweetAlert konfirmasi penghapusan
  echo "<script>
      Swal.fire({
          title: 'Konfirmasi',
          text: 'Apakah Anda yakin ingin menghapus data ini?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, Hapus!'
      }).then((result) => {
          if (result.isConfirmed) {
              // Jika pengguna mengonfirmasi penghapusan, arahkan ke halaman yang sama dengan parameter 'confirm'
              window.location.href = 'blog.php?aksi=hapus&id=$id&confirm=1';
          }
      });
  </script>";

  // Lakukan penghapusan dari database jika konfirmasi diterima
  if (isset($_GET['confirm']) && $_GET['confirm'] == '1') {
    $query = "DELETE FROM post WHERE id=$id";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
      // Jika penghapusan berhasil, tampilkan SweetAlert
      echo "<script>
              Swal.fire({
                  title: 'Sukses',
                  text: 'Berhasil Hapus Data',
                  icon: 'success',
                  confirmButtonText: 'OK'
              }).then(function() {
                  window.location.href = 'blog.php';
              });
            </script>";
    } else {
      // Jika penghapusan gagal, tampilkan pesan kesalahan
      echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
  }
}


?>
<?php
if (!isset($_GET['aksi']) || $_GET['aksi'] != 'print') {

?>


  <!-- Tabel Data Post -->
  <div class="content">
    <div class="judul">
      <h3>Data Post</h3>
    </div>
    <div class="komponen p-3">
      <div class="row">
        <div class="col justify-content-start">
          <!-- Form Pencarian -->
          <form method="get" action="blog.php">
            <div class="input-group" style="width:300px !important;">
              <input type="text" name="search" class="form-control" placeholder="Cari Judul atau Ringkas">
              <button type="submit" class="btn btn-primary"><i class="uil uil-search"></i></button>
            </div>
          </form>
          <?php
          // Tambahkan bagian pencarian ke dalam query jika parameter pencarian diset
          $searchKeywordPost = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
          $whereClausePost = $searchKeywordPost ? "WHERE judul LIKE '%$searchKeywordPost%' OR ringkas LIKE '%$searchKeywordPost%'" : '';

          // Kode untuk pagination
          $dataPerPage = 10; // Jumlah data per halaman
          $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Halaman saat ini

          // Hitung jumlah total data
          $queryCount = "SELECT COUNT(id) AS total FROM post $whereClausePost";
          $resultCount = mysqli_query($koneksi, $queryCount);
          $rowCount = mysqli_fetch_assoc($resultCount);
          $totalData = $rowCount['total'];

          // Hitung jumlah halaman
          $totalPages = ceil($totalData / $dataPerPage);

          // Pastikan halaman saat ini tidak kurang dari 1 dan tidak lebih dari total halaman yang tersedia
          if ($currentPage < 1) {
            $currentPage = 1;
          } elseif ($currentPage > $totalPages) {
            $currentPage = $totalPages;
          }

          // Hitung offset
          $offset = ($currentPage - 1) * $dataPerPage;

          // Query SQL untuk menampilkan data dengan pagination
          $query = "SELECT * FROM post $whereClausePost ORDER BY create_at DESC LIMIT $offset, $dataPerPage";
          $result = mysqli_query($koneksi, $query);

          if (!$result) {
            die("Query error: " . mysqli_error($koneksi));
          }
          ?>
        </div>
        <div class="col d-flex justify-content-end">
          <a href="blog.php?aksi=print" class="btn btn-primary me-1" target="_blank"><i class="uil uil-print"></i></a>
          <?php
          if (!isset($_SESSION["pimpinan_id"])) {
            echo '<a href="blog.php?aksi=tambah" class="btn btn-primary"><i class="uil uil-plus-circle"></i> Tambah Data</a>';
          }
          ?>
        </div>
      </div>
    </div>
    <table class="tb">
      <thead class="bg-primary">
        <tr>
          <th style="width: 5%;">No</th>
          <th style="width: 5%;">Id</th>
          <?php
          // Periksa apakah $_SESSION['pimpinan_id'] telah diatur
          if (isset($_SESSION['pimpinan_id'])) {
            // Jika iya, jangan tampilkan ikon
            echo '<th style="width: 100%;">Judul</th>';
            // echo '<th></th>';
          } else {
            // Jika tidak, tampilkan ikon
            echo '<th style="width: 70%;">Judul</th>';
            echo '<th><i class="uil uil-cog"></i></th>';
          }
          ?>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = ($currentPage - 1) * $dataPerPage + 1; // Nomor urutan data
        while ($data = mysqli_fetch_assoc($result)) {
        ?>
          <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $data['id']; ?></td>
            <td>
              <h6 class="text-danger"><?php echo $data['judul']; ?></h6>
              <?php echo $data['ringkas']; ?>
            </td>
            <?php
            // Periksa apakah $_SESSION['petugas_id'] telah diatur
            if (!isset($_SESSION['pimpinan_id'])) {
              // Jika tidak diatur, tambahkan kelas aksi
              echo '<td class="aksi">';
              echo '<a href="blog.php?aksi=detail&id=' . $data['id'] . '" class="btn btn-primary me-1"><i class="uil uil-eye"></i></a>';
              echo '<a href="blog.php?aksi=edit&id=' . $data['id'] . '" class="btn btn-primary me-1"><i class="uil uil-edit"></i></a>';
              echo '<a href="blog.php?aksi=hapus&id=' . $data['id'] . '" class="btn btn-primary"><i class="uil uil-trash-alt"></i></a>';
              echo '</td>';
            }
            ?>
          </tr>

        <?php } ?>
      </tbody>
    </table>

    <!-- Tampilkan pagination dengan Bootstrap -->
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-end mt-3">
        <?php for ($page = 1; $page <= $totalPages; $page++) : ?>
          <li class="page-item<?php echo ($page == $currentPage) ? ' active' : ''; ?>">
            <a class="page-link" href="blog.php?page=<?php echo $page; ?>"><?php echo $page; ?></a>
          </li>
        <?php endfor; ?>
      </ul>
    </nav>
  </div>



<?php
}
// Memasukkan layout/footer.php hanya jika aksi bukan 'print'
if (!isset($_GET['aksi']) || $_GET['aksi'] != 'print') {
  include 'layout/footer.php';
}
?>