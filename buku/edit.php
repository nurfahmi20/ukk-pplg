<?php
include "../config/koneksi.php";

// Cek apakah parameter id valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID tidak valid!'); window.location.href='index.php';</script>";
    exit();
}

$id = intval($_GET['id']);
$query = $koneksi->prepare("SELECT * FROM buku WHERE BukuID = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location.href='index.php';</script>";
    exit();
}

// Jika tombol update ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = trim($_POST['Judul']);
    $penulis = trim($_POST['Penulis']);
    $penerbit = trim($_POST['Penerbit']);
    $tahunTerbit = intval($_POST['TahunTerbit']);

    if (empty($judul) || empty($penulis) || empty($penerbit) || empty($tahunTerbit)) {
        echo "<script>alert('Harap isi semua field!'); window.history.back();</script>";
        exit();
    }

    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $new_image = $data['url_sampul']; // Default pakai gambar lama
    if (!empty($_FILES["url_sampul"]["name"])) {
        $imageFileType = strtolower(pathinfo($_FILES["url_sampul"]["name"], PATHINFO_EXTENSION));
        $allowed_extensions = ["jpg", "jpeg", "png", "gif"];

        if (!in_array($imageFileType, $allowed_extensions)) {
            echo "<script>alert('Hanya format JPG, JPEG, PNG, dan GIF yang diperbolehkan!'); window.history.back();</script>";
            exit();
        }

        $new_image = uniqid() . "." . $imageFileType;
        $target_file = $target_dir . $new_image;

        if (move_uploaded_file($_FILES["url_sampul"]["tmp_name"], $target_file)) {
            // Hapus gambar lama jika ada
            if (!empty($data['url_sampul']) && file_exists($target_dir . $data['url_sampul'])) {
                unlink($target_dir . $data['url_sampul']);
            }
        } else {
            echo "<script>alert('Gagal mengunggah gambar!'); window.history.back();</script>";
            exit();
        }
    }

    $updateQuery = "UPDATE buku SET Judul=?, Penulis=?, Penerbit=?, TahunTerbit=?, url_sampul=? WHERE BukuID=?";
    $stmt = $koneksi->prepare($updateQuery);
    $stmt->bind_param("sssisi", $judul, $penulis, $penerbit, $tahunTerbit, $new_image, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!'); window.history.back();</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
</head>
<body>
    <h2>Edit Data Buku</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label>Judul:</label>
        <input type="text" name="Judul" value="<?php echo htmlspecialchars($data['Judul']); ?>" required><br>

        <label>Penulis:</label>
        <input type="text" name="Penulis" value="<?php echo htmlspecialchars($data['Penulis']); ?>" required><br>

        <label>Penerbit:</label>
        <input type="text" name="Penerbit" value="<?php echo htmlspecialchars($data['Penerbit']); ?>" required><br>

        <label>Tahun Terbit:</label>
        <input type="number" name="TahunTerbit" value="<?php echo htmlspecialchars($data['TahunTerbit']); ?>" required><br>

        <label>Sampul Buku:</label>
        <input type="file" name="url_sampul"><br>
        <?php if (!empty($data['url_sampul'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($data['url_sampul']); ?>" width="100"><br>
        <?php endif; ?>

        <button type="submit">Update</button>
    </form>
    <a href="index.php">Kembali</a>
</body>
</html>
