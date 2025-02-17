<?php
// Koneksi ke database
$host = 'localhost'; // Nama host, misalnya localhost
$username = 'root';  // Username MySQL
$password = '';      // Password MySQL (kosong jika belum diset)
$dbname = 'perpustakaan'; // Nama database

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses registrasi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $UserID = $_POST['UserID'];
    $Username = $_POST['Username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
   
    $email = $_POST['email'];
    $NamaLengkap = $_POST['NamaLengkap'];
    $Alamat = $_POST['Alamat'];

    // Cek apakah email sudah terdaftar
    $checkEmail = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $checkEmail->bind_param('s', $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo "Email sudah terdaftar!";
    } else {
      // Menyimpan data pengguna baru
$stmt = $conn->prepare("INSERT INTO user (UserID, Username, password, Email, NamaLengkap, Alamat) 
VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param('ssssss', $UserID, $Username, $password, $email, $NamaLengkap, $Alamat);

if ($stmt->execute()) {

header("Location: berhasil.html"); 
exit;
} else {
echo "Terjadi kesalahan. Silakan coba lagi.";
}

        



        $stmt->close();
    }

    $checkEmail->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Perpustakaan Digital</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 400px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color:rgb(45, 255, 55);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color:rgb(104, 76, 175);
        }
        .message {
            text-align: center;
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Registrasi Perpus</h2>
    <form method="POST" action="">
        <label for="UserID">UserID</label>
        <input type="text" id="UserID" name="UserID" required>

        <label for="Username">Username</label>
        <input type="text" id="Username" name="Username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="NamaLengkap">NamaLengkap</label>
        <input type="text" id="NamaLengkap" name="NamaLengkap" required>

        <label for="Alamat">Alamat</label>
        <input type="text" id="Alamat" name="Alamat" required>

        <input type="submit" value="Daftar">
    </form>
    <p>Sudah punya akun? <a href="signin.php">Login di sini</a></p>
</div>

</body>
</html>
