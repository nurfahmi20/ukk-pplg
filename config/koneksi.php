<?php
$host = "localhost";
$user = "root"; // Ganti dengan username database Anda
$pass = ""; // Ganti dengan password database Anda
$dbname = "perpustakaan"; // Ganti dengan nama database Anda

$koneksi = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
