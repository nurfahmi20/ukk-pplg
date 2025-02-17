<?php
session_start();
include "config/koneksi.php";
                                                           
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

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

            echo json_encode(['status' => 'success', 'role' => $user['role']]);
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Password salah!']);
            exit;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Username tidak ditemukan!']);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Form tidak dikirim dengan benar!']);
    exit;
}
?>
