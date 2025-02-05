<?php
session_start();
if ($_SESSION['role'] !== 'peminjam') {
    header("Location:signin_aksi.php");  // Jika bukan admin, arahkan ke login
    exit;
}

echo "Selamat datang, peminjam!";
?>
