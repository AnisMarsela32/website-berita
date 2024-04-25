<?php
include 'layout/header.php';

$koneksi = mysqli_connect('localhost', 'root', '', 'blog');

// Fungsi tambah data
if (isset($_GET['aksi']) && $_GET['aksi'] == 'tambah') {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = ucfirst(strtolower($_POST['nama']));
    $slug = slugify($nama);
    // Query SQL untuk menambah data
    $query = "INSERT INTO kategori (nama, slug) VALUES ('$nama','$slug')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
      header("Location: kategori.php");
    } else {
      echo "Gagal menambahkan data: " . mysqli_error($koneksi);
    }
  } else {
    // Menampilkan form tambah data
?>

    <!-- Tambah Data Form -->
    <div class="content">
      <div class="judul">
        <h3>Blog</h3>
      </div>
      <div class="komponen p-3">
        <div class="row">
          <div class="col  justify-content-start">
            <h4>Tambah Kategori</h4>
            <!-- <input type="text" class="form-control" id="search"><i class="uil uil-plus-circle"></i> -->
          </div>

          <div class="col d-flex justify-content-end">
            <a href="kategori.php" class="btn btn-primary"><i class="uil uil-arrow-circle-left me-1"></i> Kembali</a>
          </div>
        </div>
      </div>
      <table class="tb">
        <form method="post">

          <tr>
            <td>Nama</td>
            <td><input type="text" name="nama" id="nama" required></input></td>
          </tr>


          <tr>
            <td colspan="2">
              <button type="submit" name="tambah_data" class="btn btn-danger">Simpan</button>
              <a href="kategori.php" class="btn btn-danger">Batal</a>
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
    $nama = ucfirst(strtolower($_POST['nama']));
    $slug = slugify($nama);


    // No new image uploaded, keep the old image
    $query = "UPDATE kategori SET nama='$nama', slug='$slug' WHERE id=$id";


    // Execute the query
    $result = mysqli_query($koneksi, $query);

    if ($result) {
      header("Location: kategori.php");
    } else {
      echo "Gagal mengedit data: " . mysqli_error($koneksi);
    }
  } else {
    // Menampilkan form edit data
    $id = $_GET['id'];
    $query = "SELECT * FROM kategori WHERE id=$id";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);
  ?>

    <!-- Edit Data Form -->
    <div class="content">
      <div class="judul">
        <h3>Kategori</h3>
      </div>
      <div class="komponen p-3">
        <div class="row">
          <div class="col  justify-content-start">
            <h4>Edit Kategori</h4>
            <!-- <input type="text" class="form-control" id="search"><i class="uil uil-plus-circle"></i> -->
          </div>

          <div class="col d-flex justify-content-end">
            <a href="kategori.php" class="btn btn-primary"><i class="uil uil-arrow-circle-left me-1"></i> Kembali</a>
          </div>
        </div>
      </div>
      <table class="tb">
        <form method="post" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

          <tr>
            <td>Nama</td>
            <td><input type="text" name="nama" style="width: 70%" value="<?php echo $data['nama']; ?>" required></td>
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



// Fungsi hapus data
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
  $id = $_GET['id'];
  $query = "DELETE FROM kategori WHERE id=$id";
  $result = mysqli_query($koneksi, $query);

  if ($result) {
    header("Location: kategori.php");
  } else {
    echo "Gagal menghapus data: " . mysqli_error($koneksi);
  }
}

// Tampilkan data post
?>

<!-- Tabel Data Post -->
<div class="content">
  <div class="judul">
    <h3>Data Kategori</h3>
  </div>
  <div class="komponen p-3">
    <div class="row">
      <div class="col justify-content-start">
        <!-- Form Pencarian -->
        <form method="get" action="kategori.php">
          <div class="input-group" style="width:300px !important;">
            <input type="text" name="search" class="form-control" placeholder="Cari Nama Kategori">
            <button type="submit" class="btn btn-primary"><i class="uil uil-search"></i></button>
          </div>
        </form>
        <?php
        // Tambahkan bagian pencarian ke dalam query jika parameter pencarian diset
        $searchKeywordKategori = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
        $whereClauseKategori = $searchKeywordKategori ? "WHERE nama LIKE '%$searchKeywordKategori%'" : '';

        // Kode untuk pagination
        $dataPerPage = 10; // Jumlah data per halaman
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Halaman saat ini

        // Hitung jumlah total data
        $queryCount = "SELECT COUNT(id) AS total FROM kategori $whereClauseKategori";
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
        $query = "SELECT * FROM kategori $whereClauseKategori ORDER BY create_at DESC LIMIT $offset, $dataPerPage";
        $result = mysqli_query($koneksi, $query);

        if (!$result) {
          die("Query error: " . mysqli_error($koneksi));
        }
        ?>
      </div>
      <div class="col d-flex justify-content-end">
      <?php 
        if(!isset($_SESSION["pimpinan_id"])){
          echo '<a href="kategori.php?aksi=tambah" class="btn btn-primary"><i class="uil uil-plus-circle"></i> Tambah Data</a>';
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
          echo '<th style="width: 100%;">Nama Kategori</th>';
          // echo '<th></th>';
        } else {
          // Jika tidak, tampilkan ikon
          echo '<th style="width: 70%;">Nama Kategori</th>';
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
          <td><?php echo $data['nama']; ?></td>
          <?php
          if (!isset($_SESSION['pimpinan_id'])) {
            echo '<td class="aksi">';
            echo '<a href="kategori.php?aksi=edit&id=' . $data['id'] . '" class="btn btn-primary me-1"><i class="uil uil-edit"></i></a>';
            echo '<a href="kategori.php?aksi=hapus&id=' . $data['id'] . '" class="btn btn-primary"><i class="uil uil-trash-alt"></i></a>';
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
          <a class="page-link" href="kategori.php?page=<?php echo $page; ?>"><?php echo $page; ?></a>
        </li>
      <?php endfor; ?>
    </ul>
  </nav>
</div>



<?php
include 'layout/footer.php';
?>