<?php
session_start();
if ($_SESSION['role'] !== 'administrator') {
    header("Location:signin_aksi.php");  // Jika bukan admin, arahkan ke login
    exit;
}

echo "Selamat datang, Administrator!";
?>

<?php
session_start();
include "config/koneksi.php"; // Koneksi ke database

// Cek apakah user sudah login dan memiliki role admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php"); // Redirect ke halaman login jika bukan admin
    exit;
}

// Ambil username admin yang sedang login
$username = $_SESSION['username'];

// Ambil data pengguna dari database
$query = "SELECT id, username, role FROM user ORDER BY role";
$result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        .logout {
            text-align: right;
            margin-bottom: 20px;
        }
        .logout a {
            color: red;
            text-decoration: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, <strong><?php echo htmlspecialchars($username); ?></strong>!</p>
        
        <h2>Daftar Pengguna</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo ucfirst($row['role']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
