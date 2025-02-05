<?php
session_start();

// Jika user belum login, arahkan ke halaman login
if (!isset($_SESSION['user'])) {
    header('Location: signin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perpustakaan Digital</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar Menu -->
        <aside class="sidebar">
            <div class="logo">
                <img src="images/logo.png" alt="Logo Perpustakaan">
            </div>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="buku/index.php">Buku</a></li>
                <li><a href="#">Peminjaman</a></li>
                <li><a href="#">Pengembalian</a></li>
                <li><a href="#">Laporan</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <h1>Selamat datang di Dashboard Perpustakaan Digital</h1>

            <h2>Daftar Buku</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Tahun Terbit</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM buku";
                    $result = mysqli_query($conn, $sql);
                    
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>" . $row['id'] . "</td>
                                    <td>" . $row['judul_buku'] . "</td>
                                    <td>" . $row['penulis'] . "</td>
                                    <td>" . $row['tahun_terbit'] . "</td>
                                    <td>" . $row['stok'] . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data buku.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
