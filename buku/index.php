<?php
include "../config/koneksi.php";

if (isset($_POST['simpan'])) {
    $judul = $_POST['Judul'];
    $penulis = $_POST['Penulis'];
    $penerbit = $_POST['Penerbit'];
    $tahunTerbit = $_POST['TahunTerbit'];

    // Direktori penyimpanan gambar
    $target_dir = "uploads/";
    
    // Buat nama unik untuk file gambar
    $sampul = time() . "_" . basename($_FILES["url_sampul"]["name"]); 
    $target_file = $target_dir . $sampul;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validasi file gambar
    $check = getimagesize($_FILES["url_sampul"]["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File bukan gambar!'); window.history.back();</script>";
        exit();
    }

    // Hanya izinkan format gambar tertentu
    $allowed_extensions = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowed_extensions)) {
        echo "<script>alert('Hanya format JPG, JPEG, PNG, dan GIF yang diperbolehkan!'); window.history.back();</script>";
        exit();
    }

    // Pindahkan gambar ke folder upload
    if (move_uploaded_file($_FILES["url_sampul"]["tmp_name"], $target_file)) {
        // Simpan data ke database
        $sql = "INSERT INTO buku (url_sampul, Judul, Penulis, Penerbit, TahunTerbit) VALUES (?, ?, ?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("ssssi", $sampul, $judul, $penulis, $penerbit, $tahunTerbit);

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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Buku</title>
</head>
<body>

<h1 style="text-align:center;"><strong>PERPUSTAKAAN DIGITAL</strong></h1>

<button style="background-color: skyblue;">
    <a href="form_tambah.php">Tambah</a>
</button>
<br>

<!-- Tabel Buku -->
<table width="97%" border="1" align="center" cellpadding="3" cellspacing="0">
    <thead>
        <tr style="background-color: pink;">
            <th>BukuID</th>
            <th>Sampul</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Penerbit</th>
            <th>Tahun Terbit</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include "../config/koneksi.php";

        $data = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY BukuID DESC"); // Menggunakan BukuID
        while ($hasil = mysqli_fetch_array($data)) {
            // Path gambar
            $gambarPath = "uploads/" . $hasil['url_sampul'];
        ?>
        <tr>
            <td><?php echo $hasil['BukuID']; ?></td>
            <td>
                <?php if (!empty($hasil['url_sampul']) && file_exists($gambarPath)) { ?>
                    <img src="<?php echo $gambarPath; ?>" alt="Sampul Buku" width="100">
                <?php } else { ?>
                    <img src="uploads/default.png" alt="No Image" width="100">
                <?php } ?>
            </td>
            <td><?php echo $hasil['Judul']; ?></td>
            <td><?php echo isset($hasil['Penulis']) ? $hasil['Penulis'] : 'N/A'; ?></td>
            <td><?php echo isset($hasil['Penerbit']) ? $hasil['Penerbit'] : 'N/A'; ?></td>
            <td><?php echo $hasil['TahunTerbit']; ?></td>
            <td align="center">
                <a href="edit.php?id=<?php echo $hasil['BukuID']; ?>">Edit</a> |
                <a href="hapus.php?id=<?php echo $hasil['BukuID']; ?>" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>
