<?php
// Mulai sesi jika belum dimulai
if (!isset($_SESSION)) {
    session_start();
}

// Hapus semua data sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login atau halaman beranda setelah logout
header("Location: index.php"); // Ganti "login.php" dengan halaman login yang sesuai
exit();
?>
