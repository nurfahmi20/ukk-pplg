<?php
session_start();

$users = [
    'admin' => ['password' => password_hash('adminpass', PASSWORD_DEFAULT), 'role' => 'admin'],
    'petugas' => ['password' => password_hash('petugas', PASSWORD_DEFAULT), 'role' => 'petugas'],
    'peminjam' => ['password' => password_hash('peminjam', PASSWORD_DEFAULT), 'role' => 'peminjam'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (isset($users[$username])) {
        $stored_hash = $users[$username]['password'];
        $role = $users[$username]['role'];

        if (password_verify($password, $stored_hash)) {
            $_SESSION['user'] = $username;
            $_SESSION['role'] = $role;

            switch ($role) {
                case 'admin':
                    header("Location: admin_dashboard.php");
                    break;
                case 'petugas':
                    header("Location: petugas_dashboard.php");
                    break;
                case 'peminjam':
                    header("Location: peminjam_dashboard.php");
                    break;
            }
            exit;
        }
    }
    $_SESSION['error'] = 'Username atau password salah!';
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <style>
        body { font-family: sans-serif; background-color: #f0f0f0; }
        .login { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #e9e6e6; padding: 40px; width: 270px; border-radius: 10px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.3); }
        .btn-login { width: 100%; padding: 10px; background-color: #4a5c36; color: white; border: none; cursor: pointer; border-radius: 5px; }
        .btn-login:hover { background-color: #34472a; }
    </style>
</head>
<body>
    <div class="login">
        <h2>LOGIN</h2>
        <p>Masukkan Username dan Password</p>
        <?php if (isset($_SESSION['error'])): ?>
            <p style="color: red;"> <?= $_SESSION['error']; unset($_SESSION['error']); ?> </p>
        <?php endif; ?>
        <form method="POST" action="">
            <div>
                <i class="fa fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div>
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="login" class="btn-login">SIGN IN</button>
        </form>
    </div>
</body>
</html>
