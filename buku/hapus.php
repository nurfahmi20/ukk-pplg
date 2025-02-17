<?php
include "../config/koneksi.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID tidak valid!'); window.history.back();</script>";
    exit();
}

$id = intval($_GET['id']);

// Cek koneksi database
if (!$koneksi) {
    die("<script>alert('Koneksi database gagal!'); window.history.back();</script>");
}

// Menggunakan prepared statement untuk keamanan
$query = $koneksi->prepare("SELECT url_sampul FROM buku WHERE BukuID = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$data = $result->fetch_assoc();

// Cek apakah data ditemukan
if ($data) {
    // Hapus file gambar jika ada
    if (!empty($data['url_sampul'])) {
        $file_path = realpath("uploads/" . $data['url_sampul']); // Hindari manipulasi path
        if ($file_path && file_exists($file_path)) {
            unlink($file_path);
        }
    }

    // Hapus data dari database
    $deleteQuery = $koneksi->prepare("DELETE FROM buku WHERE BukuID = ?");
    $deleteQuery->bind_param("i", $id);

    if ($deleteQuery->execute()) {
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='index.php';</script>";
        exit();
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.history.back();</script>";
        exit();
    }
} else {
    echo "<script>alert('Data tidak ditemukan!'); window.history.back();</script>";
    exit();
}
?>
