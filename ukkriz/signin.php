<?php
session_start();

$users = [
    'admin' => ['password' => 'adminpass', 'role' => 'admin'],
    'petugas' => ['password' => 'petugas', 'role' => 'petugas'],
    'peminjam' => ['password' => 'peminjam', 'role' => 'peminjam'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (isset($users[$username])) {
        $stored_password = $users[$username]['password'];
        $role = $users[$username]['role'];

        if ($password === $stored_password) {
            $_SESSION['user'] = $username;
            $_SESSION['role'] = $role;

            if ($role === 'admin') {
                header('Location: admin_dashboard.php');
            } elseif ($role === 'petugas') {
                header('Location: petugas_dashboard.php');
            } else {
                header('Location: peminjam_dashboard.php');
            }
            exit;
        }
    }

    echo 'error';
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
        /* Style untuk tampilan login */
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            background-color: #f0f0f0;
        }

        .login {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(233, 230, 230, 0.9);
            padding: 60px;
            width: 270px;
            box-shadow: 0px 0px 25px 10px rgb(106, 104, 104);
            border-radius: 15px;
        }

        .avatar {
            font-size: 30px;
            background: #ffffffc2;
            width: 100px;
            height: 100px;
            line-height: 100px;
            position: fixed;
            left: 50%;
            top: 11%;
            transform: translate(-50%, -50%);
            text-align: center;
            border-radius: 50%;
        }

        .login h2 {
            text-align: center;
            color: rgb(0, 0, 0);
            font-size: 30px;
            letter-spacing: 1px;
            padding-top: 25%;
            margin-top: -20px;
        }

        .login p {
            text-align: center;
            color: rgb(86, 84, 84);
            font-size: 16px;
            padding-top: 5%;
            margin-top: -20px;
        }

        .box-login {
            display: flex;
            justify-content: space-between;
            margin: 10px;
            border-bottom: 2px solid rgb(195, 195, 193);
            padding: 8px 0;
        }

        .box-login I {
            font-size: 23px;
            color: rgb(0, 0, 0);
            padding: 5px 0;
        }

        .box-login input {
            width: 85%;
            padding: 5px 0;
            background: none;
            border: none;
            outline: none;
            color: rgb(94, 104, 61);
            font-size: 18px;
        }

        .btn-login {
            margin-left: 10px;
            margin-bottom: 20px;
            background-color: rgba(72, 77, 54, 0.99);
            border: 1px solid rgb(255, 255, 255);
            width: 92.5%;
            padding: 15px;
            color: rgb(251, 251, 251);
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 10px;
        }

        .btn-login:hover {
            background: rgb(50, 81, 49);
        }
    </style>
</head>

<body>
    <div class="login">


        <h2><b>LOGIN DULU</b></h2>
        <br>
        <p>Masukan <b>Username</b> Dan <b>Password</b></p>

        <form id="loginForm">
            <div class="box-login">
                <I class="fa fa-user"></I>
                <input type="text" id="username" name="username" placeholder="Username" autocomplete="off" required>
            </div>

            <div class="box-login">
                <I class="fas fa-lock"></I>
                <input type="password" id="password" name="password" placeholder="Password" autocomplete="off" required>
            </div>

            <button type="submit" class="btn-login">SIGN IN</button>
        </form>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            fetch('signin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        username: username,
                        password: password,
                        login: true
                    })
                })
                .then(response => response.text())
                .then(data => {
                    if (data === 'error') {
                        alert('Username atau password salah!');
                    } else {

                        window.location.href = "admin_dashboard.php";
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi masalah saat login. Silakan coba lagi.');
                });
        });
    </script>
</body>

</html>