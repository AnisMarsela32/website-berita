
<?php

include 'layout/header.php';

// include 'koneksi.php';
// $db = new database();

// session_start(); // Memulai sesi

// Pastikan Anda telah menghubungkan ke basis data

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    
    // Validasi input (contoh sederhana)
    if (empty($username) || empty($password)) {
        $error = "Username dan password harus diisi.";
    } else {

        // Query untuk mencari pengguna berdasarkan username
        $query = "SELECT * FROM pimpinan WHERE username='$username'";
        $result = mysqli_query($db->koneksi, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);

            if ($row && $password) {
                // Password cocok, pengguna berhasil login
                $_SESSION["pimpinan_id"] = $row["id"];
                $_SESSION["role"] = "2"; // Atur peran pengguna

                echo "<script>
                Swal.fire({
                    title: 'Login Berhasil',
                    text: 'Anda akan diarahkan ke halaman berita.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = 'index.php';
                });
                
                </script>";

                exit(); // Penting untuk menghentikan eksekusi kode selanjutnya
            } else {
                // Password salah
                $error = "Username atau password salah.";
            }
        } else {
            // Kesalahan dalam eksekusi query
            $error = "Terjadi kesalahan. Silakan coba lagi.";
        }

        // Query untuk mencari admin berdasarkan username
        $adminQuery = "SELECT * FROM admin WHERE username='$username'";
        $adminResult = mysqli_query($db->koneksi, $adminQuery);

        if ($adminResult) {
            $adminRow = mysqli_fetch_assoc($adminResult);

            if ($adminRow && $password) {
                // Password cocok, admin berhasil login
                $_SESSION["admin_id"] = $adminRow["id"];
                $_SESSION["role"] = "1"; // Atur peran admin
                
                echo "<script>
                Swal.fire({
                    title: 'Login Berhasil',
                    text: 'Anda akan diarahkan ke halaman berita.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = 'index.php?status=login';
                });
                
                </script>";

                exit(); // Penting untuk menghentikan eksekusi kode selanjutnya
            } else {
                // Password salah
                $error = "Username atau password salah.";
            }
        } else {
            // Kesalahan dalam eksekusi query
            $error = "Terjadi kesalahan. Silakan coba lagi.";
        }

    }
}

include 'layout/footer.php';
?>
