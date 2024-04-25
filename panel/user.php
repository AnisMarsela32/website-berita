<?php
include 'layout/header.php';

$koneksi = mysqli_connect('localhost', 'root', '', 'blog');

// Fungsi tambah data
if (isset($_GET['aksi']) && $_GET['aksi'] == 'tambah') {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Query SQL untuk menambah data
    $query = "INSERT INTO kategori (username, password, role_id) VALUES ('$username','$password','2')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
      header("Location: user.php");
    } else {
      echo "Gagal menambahkan data: " . mysqli_error($koneksi);
    }
  } else {
    // Menampilkan form tambah data
?>

    <!-- Tambah Data Form -->
    <div class="content">
      <div class="judul">
        <h3>User</h3>
      </div>
      <div class="komponen p-3">
        <div class="row">
          <div class="col  justify-content-start">
            <h4>Tambah User</h4>
            <!-- <input type="text" class="form-control" id="search"><i class="uil uil-plus-circle"></i> -->
          </div>

          <div class="col d-flex justify-content-end">
            <a href="user.php" class="btn btn-primary"><i class="uil uil-arrow-circle-left me-1"></i> Kembali</a>
          </div>
        </div>
      </div>
      <table class="tb">
        <form method="post">

          <tr>
            <td>Username</td>
            <td><input type="text" name="username" id="username" required></input></td>
          </tr>
          <tr>
            <td>Password</td>
            <td><input type="text" name="password" id="password" required></input></td>
          </tr>


          <tr>
            <td colspan="2">
              <button type="submit" name="tambah_data" class="btn btn-danger">Simpan</button>
              <a href="user.php" class="btn btn-danger">Batal</a>
            </td>
          </tr>
        </form>
      </table>
    </div>


  <?php
  }
}

// Fungsi edit data
if (isset($_GET['aksi']) && $_GET['aksi'] == 'edit') {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];

    // No new image uploaded, keep the old image
    $query = "UPDATE user SET username='$username' WHERE id=$id";


    // Execute the query
    $result = mysqli_query($koneksi, $query);

    if ($result) {
      header("Location: user.php");
    } else {
      echo "Gagal mengedit data: " . mysqli_error($koneksi);
    }
  } else {
    // Menampilkan form edit data
    $id = $_GET['id'];
    $query = "SELECT * FROM user WHERE id=$id";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);
  ?>

    <!-- Edit Data Form -->
    <div class="content">
      <div class="judul">
        <h3>User</h3>
      </div>
      <div class="komponen p-3">
        <div class="row">
          <div class="col  justify-content-start">
            <h4>Edit User</h4>
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
            <td>Username</td>
            <td><input type="text" name="username" style="width: 70%" value="<?php echo $data['username']; ?>" required></td>
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
  $query = "DELETE FROM user WHERE id=$id";
  $result = mysqli_query($koneksi, $query);

  if ($result) {
    header("Location: user.php");
  } else {
    echo "Gagal menghapus data: " . mysqli_error($koneksi);
  }
}

// Tampilkan data post
?>

<!-- Tabel Data Post -->
<div class="content">
  <div class="judul">
    <h3>Data User</h3>
  </div>
  <div class="komponen p-3">
    <div class="row">
      <div class="col justify-content-start">
        <!-- Form Pencarian -->
        <form method="get" action="user.php">
          <div class="input-group" style="width:300px !important;">
            <input type="text" name="search" class="form-control" placeholder="Cari User">
            <button type="submit" class="btn btn-primary"><i class="uil uil-search"></i></button>
          </div>
        </form>
        <?php
        // Tambahkan bagian pencarian ke dalam query jika parameter pencarian diset
        $searchKeyword = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
        $whereClause = $searchKeyword ? "WHERE username LIKE '%$searchKeyword%'" : '';

        // Hitung jumlah total data
        $queryCount = "SELECT COUNT(id) AS total FROM user $whereClause";
        $resultCount = mysqli_query($koneksi, $queryCount);
        $rowCount = mysqli_fetch_assoc($resultCount);
        $totalData = $rowCount['total'];

        // Kode untuk pagination
        $dataPerPage = 10; // Jumlah data per halaman
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Halaman saat ini

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
        $query = "SELECT * FROM user $whereClause LIMIT $offset, $dataPerPage";
        $result = mysqli_query($koneksi, $query);

        if (!$result) {
          die("Query error: " . mysqli_error($koneksi));
        }
        ?>
      </div>
      <div class="col d-flex justify-content-end">
        <!-- <a href="" class="btn btn-primary me-1"><i class="uil uil-print"></i></a> -->
        <a href="user.php?aksi=tambah" class="btn btn-primary"><i class="uil uil-plus-circle"></i> Tambah Data</a>
      </div>
    </div>
  </div>
  <table class="tb">
    <thead class="bg-primary">
      <tr>
        <th style="width: 5%;">No</th>
        <th style="width: 5%;">Id</th>
        <th style="width: 70%;">Username</th>
        <th><i class="uil uil-cog"></i></th>
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
          <td><?php echo $data['username']; ?></td>
          <td class="aksi">
            <a href="user.php?aksi=edit&id=<?php echo $data['id']; ?>" class="btn btn-primary"><i class="uil uil-edit"></i></a>
            <a href="user.php?aksi=hapus&id=<?php echo $data['id']; ?>" class="btn btn-primary"><i class="uil uil-trash-alt"></i></a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <!-- Tampilkan pagination dengan Bootstrap -->
  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-end mt-3">
      <?php for ($page = 1; $page <= $totalPages; $page++) : ?>
        <li class="page-item<?php echo ($page == $currentPage) ? ' active' : ''; ?>">
          <a class="page-link" href="user.php?page=<?php echo $page; ?>"><?php echo $page; ?></a>
        </li>
      <?php endfor; ?>
    </ul>
  </nav>
</div>



<?php
include 'layout/footer.php';
?>