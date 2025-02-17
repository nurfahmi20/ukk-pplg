<?php
// Konfigurasi database
$host = "localhost";
$user = "root"; // Ganti dengan username database Anda
$pass = ""; // Ganti dengan password database Anda
$dbname = "perpustakaan"; // Ganti dengan nama database Anda

// Koneksi ke database
$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['Judul'];
    $penulis = $_POST['Penulis'];
    $penerbit = $_POST['Penerbit'];
    $tahunTerbit = $_POST['TahunTerbit'];
    
    // Direktori untuk menyimpan gambar
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Buat folder jika belum ada
    }

    $sampul = $_FILES["url_sampul"]["name"];
    $lokasiSementara = $_FILES["url_sampul"]["tmp_name"];
    $imageFileType = strtolower(pathinfo($sampul, PATHINFO_EXTENSION));
    
    // Buat nama unik untuk file
    $namaBaru = uniqid() . "." . $imageFileType;
    $target_file = $target_dir . $namaBaru;

    // Validasi apakah file benar-benar gambar
    $check = getimagesize($lokasiSementara);
    if ($check === false) {
        echo "<script>alert('File bukan gambar!'); window.history.back();</script>";
        exit();
    }

    // Validasi format file
    $allowed_extensions = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowed_extensions)) {
        echo "<script>alert('Hanya format JPG, JPEG, PNG, dan GIF yang diperbolehkan!'); window.history.back();</script>";
        exit();
    }

    // Pindahkan file ke folder uploads/
    if (move_uploaded_file($lokasiSementara, $target_file)) {
        // Simpan hanya nama file di database, bukan path lengkapnya
        $sql = "INSERT INTO buku (Judul, Penulis, Penerbit, TahunTerbit, url_sampul) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssis", $judul, $penulis, $penerbit, $tahunTerbit, $namaBaru);

        if ($stmt->execute()) {
            echo "<script>alert('Data berhasil disimpan!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data: " . $stmt->error . "'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Gagal mengunggah gambar!'); window.history.back();</script>";
    }
}

$conn->close();
?>
