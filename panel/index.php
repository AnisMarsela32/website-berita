<?php
session_start(); // Memulai session

// Koneksi ke database MySQL (gantilah dengan informasi koneksi Anda)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Inisialisasi variabel untuk pesan kesalahan
$login_error = "";

// Cek apakah formulir login telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data dari formulir login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Melakukan hashing terhadap password (gunakan metode hash yang aman)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Periksa apakah username dan password sesuai dengan database admin
    $sqlAdmin = "SELECT * FROM Admin WHERE username='$username'";
    $resultAdmin = mysqli_query($conn, $sqlAdmin);

    if (mysqli_num_rows($resultAdmin) == 1) {
        $rowAdmin = mysqli_fetch_assoc($resultAdmin);

        // Memeriksa apakah password sesuai
        if (password_verify($password, $rowAdmin['password'])) {
            $_SESSION['admin_id'] = $rowAdmin['id'];
            $_SESSION['admin_username'] = $rowAdmin['username'];
            $_SESSION['admin_role'] = $rowAdmin['role_id'];

            header("Location: dashbord.php"); // Alihkan ke halaman dashboard jika autentikasi berhasil
            exit();
        } else {
            $login_error = "Password salah.";
        }
    }

    // Periksa apakah username dan password sesuai dengan database pimpinan
    $sqlPimpinan = "SELECT * FROM pimpinan WHERE username='$username'";
    $resultPimpinan = mysqli_query($conn, $sqlPimpinan);

    if (mysqli_num_rows($resultPimpinan) == 1) {
        $rowPimpinan = mysqli_fetch_assoc($resultPimpinan);

        // Memeriksa apakah password sesuai
        if (password_verify($password, $rowPimpinan['password'])) {
            $_SESSION['pimpinan_id'] = $rowPimpinan['id'];
            $_SESSION['pimpinan_username'] = $rowPimpinan['username'];
            $_SESSION['pimpinan_role'] = $rowPimpinan['role_id'];

            header("Location: dashbord.php"); // Alihkan ke halaman dashboard pimpinan jika autentikasi berhasil
            exit();
        } else {
            $login_error = "Password salah.";
        }
    }

    // Jika tidak ada kecocokan dengan admin atau pimpinan
    $login_error = "Username tidak ditemukan atau password salah.";
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $fulldomain = "http://localhost/lorong_berita/";
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= $fulldomain ?>panel/style.css">
</head>

<body>

    <style>
        body {
            background-image: url(image/bg.jpg);
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
    
    <div class="card card-body login mx-auto" style="width: 18rem; margin: 200px auto">
        <div class="form-title">
            <h1>Login</h1>
        </div>
        <!-- main form -->
        <form action="" method="POST"> <!-- Ganti action dengan file ini sendiri (index.php) -->
            <div class="single-input">
                <span><i class="uil uil-user"></i></span>
                <input type="text" name="username" placeholder="Username"> <!-- Tambahkan name attribute untuk input -->
            </div>
            <div class="single-input">
                <span><i class="uil uil-lock-alt"></i></span>
                <input type="password" name="password" placeholder="Password"> <!-- Tambahkan name attribute untuk input -->
            </div>

            <button type="submit" class="btn btn-danger w-100">Login</button>
        </form>

        <!-- Menampilkan pesan kesalahan jika ada -->
        <p style="color: red;"><?php echo $login_error; ?></p>
    </div>
</body>

</html>
