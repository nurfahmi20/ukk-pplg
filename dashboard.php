<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit;
}

echo "<h2>Selamat datang, " . $_SESSION['NamaLengkap'] . "</h2>";
echo "<p>Email: " . $_SESSION['Email'] . "</p>";
echo "<p>Alamat: " . $_SESSION['Alamat'] . "</p>";
echo "<a href='logout.php'>Logout</a>";
?>
