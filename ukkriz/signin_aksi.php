<?php
session_start();
include "config/koneksi.php";
                                                          
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mencegah SQL Injection dengan prepared statement
    $query = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_array(MYSQLI_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['status'] = 'login';
            $_SESSION['role'] = $user['role']; 

            // Redirect sesuai role
            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } elseif ($user['role'] == 'petugas') {
                header("Location: petugas_dashboard.php"); 
            } else {
                header("Location: peminjam_dashboard.php"); 
            }
            exit;
        } else {
            echo 'error'; // Password salah
        }
    } else {
        echo 'error'; // Username tidak ditemukan
    }
} else {
    echo 'error'; // Form tidak dikirim dengan benar
}
?>
