<?php
include 'layout/header.php';

$koneksi = mysqli_connect('localhost', 'root', '', 'blog');

// Fungsi tambah data
if (isset($_GET['aksi']) && $_GET['aksi'] == 'tambah') {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Query SQL untuk menambah data
    $query = "INSERT INTO admin (username, password, role_id) VALUES ('$username','$password','1')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
      header("Location: admin.php");
    } else {
      echo "Gagal menambahkan data: " . mysqli_error($koneksi);
    }
  } else {
    // Menampilkan form tambah data
?>

    <!-- Tambah Data Form -->
    <div class="content">
      <div class="judul">
        <h3>Admin</h3>
      </div>
      <div class="komponen p-3">
        <div class="row">
          <div class="col  justify-content-start">
            <h4>Tambah Admin</h4>
            <!-- <input type="text" class="form-control" id="search"><i class="uil uil-plus-circle"></i> -->
          </div>

          <div class="col d-flex justify-content-end">
            <a href="admin.php" class="btn btn-primary"><i class="uil uil-arrow-circle-left me-1"></i> Kembali</a>
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
              <a href="admin.php" class="btn btn-danger">Batal</a>
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
    $query = "UPDATE admin SET username='$username' WHERE id=$id";


    // Execute the query
    $result = mysqli_query($koneksi, $query);

    if ($result) {
      header("Location: admin.php");
    } else {
      echo "Gagal mengedit data: " . mysqli_error($koneksi);
    }
  } else {
    // Menampilkan form edit data
    $id = $_GET['id'];
    $query = "SELECT * FROM admin WHERE id=$id";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);
  ?>

    <!-- Edit Data Form -->
    <div class="content">
      <div class="judul">
        <h3>Admin</h3>
      </div>
      <div class="komponen p-3">
        <div class="row">
          <div class="col  justify-content-start">
            <h4>Edit Admin</h4>
            <!-- <input type="text" class="form-control" id="search"><i class="uil uil-plus-circle"></i> -->
          </div>

          <div class="col d-flex justify-content-end">
            <a href="admin.php" class="btn btn-primary"><i class="uil uil-arrow-circle-left me-1"></i> Kembali</a>
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
  $query = "DELETE FROM admin WHERE id=$id";
  $result = mysqli_query($koneksi, $query);

  if ($result) {
    header("Location: admin.php");
  } else {
    echo "Gagal menghapus data: " . mysqli_error($koneksi);
  }
}

// Tampilkan data post
?>

<!-- Tabel Data Admin -->
<div class="content">
  <div class="judul">
    <h3>Data Admin</h3>
  </div>
  <div class="komponen p-3">
    <div class="row">
      <div class="col justify-content-start">
        <!-- Form Pencarian -->
        <form method="get" action="admin.php">
          <div class="input-group" style="width:300px !important;">
            <input type="text" name="search" class="form-control" placeholder="Cari Admin">
            <button type="submit" class="btn btn-primary"><i class="uil uil-search"></i></button>
          </div>
        </form>
        <?php
        // Tambahkan bagian pencarian ke dalam query jika parameter pencarian diset
        $searchKeywordAdmin = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
        $whereClauseAdmin = $searchKeywordAdmin ? "WHERE username LIKE '%$searchKeywordAdmin%'" : '';

        // Hitung jumlah total data admin
        $queryCountAdmin = "SELECT COUNT(id) AS total FROM admin $whereClauseAdmin";
        $resultCountAdmin = mysqli_query($koneksi, $queryCountAdmin);
        $rowCountAdmin = mysqli_fetch_assoc($resultCountAdmin);
        $totalDataAdmin = $rowCountAdmin['total'];

        // Kode untuk pagination admin
        $dataPerPageAdmin = 10; // Jumlah data per halaman
        $currentPageAdmin = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Halaman saat ini

        // Hitung jumlah halaman admin
        $totalPagesAdmin = ceil($totalDataAdmin / $dataPerPageAdmin);

        // Pastikan halaman saat ini tidak kurang dari 1 dan tidak lebih dari total halaman yang tersedia
        if ($currentPageAdmin < 1) {
          $currentPageAdmin = 1;
        } elseif ($currentPageAdmin > $totalPagesAdmin) {
          $currentPageAdmin = $totalPagesAdmin;
        }

        // Hitung offset admin
        $offsetAdmin = ($currentPageAdmin - 1) * $dataPerPageAdmin;

        // Query SQL untuk menampilkan data admin dengan pagination
        $queryAdmin = "SELECT * FROM admin $whereClauseAdmin LIMIT $offsetAdmin, $dataPerPageAdmin";
        $resultAdmin = mysqli_query($koneksi, $queryAdmin);

        if (!$resultAdmin) {
          die("Query error: " . mysqli_error($koneksi));
        }
        ?>
      </div>
      <div class="col d-flex justify-content-end">
      <?php 
        if(!isset($_SESSION["pimpinan_id"])){
          echo '<a href="admin.php?aksi=tambah" class="btn btn-primary"><i class="uil uil-plus-circle"></i> Tambah Data</a>';
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
          echo '<th style="width: 100%;">Username</th>';
          // echo '<th></th>';
        } else {
          // Jika tidak, tampilkan ikon
          echo '<th style="width: 70%;">Username</th>';
          echo '<th><i class="uil uil-cog"></i></th>';
        }
        ?>
      </tr>
    </thead>
    <tbody>
      <?php
      $noAdmin = ($currentPageAdmin - 1) * $dataPerPageAdmin + 1; // Nomor urutan data admin
      while ($dataAdmin = mysqli_fetch_assoc($resultAdmin)) {
      ?>
        <tr>
          <td><?php echo $noAdmin++; ?></td>
          <td><?php echo $dataAdmin['id']; ?></td>
          <td><?php echo $dataAdmin['username']; ?></td>
          <?php
          if (!isset($_SESSION['pimpinan_id'])) {
            echo '<td class="aksi">';
            echo '<a href="admin.php?aksi=edit&id=' . $dataAdmin['id'] . '" class="btn btn-primary me-1"><i class="uil uil-edit"></i></a>';
            echo '<a href="admin.php?aksi=hapus&id=' . $dataAdmin['id'] . '" class="btn btn-primary"><i class="uil uil-trash-alt"></i></a>';
            echo '</td>';
          }
          ?>

        </tr>
      <?php } ?>
    </tbody>
  </table>

  <!-- Tampilkan pagination admin dengan Bootstrap -->
  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-end mt-3">
      <?php for ($pageAdmin = 1; $pageAdmin <= $totalPagesAdmin; $pageAdmin++) : ?>
        <li class="page-item<?php echo ($pageAdmin == $currentPageAdmin) ? ' active' : ''; ?>">
          <a class="page-link" href="admin.php?page=<?php echo $pageAdmin; ?>"><?php echo $pageAdmin; ?></a>
        </li>
      <?php endfor; ?>
    </ul>
  </nav>
</div>



<?php
include 'layout/footer.php';
?>