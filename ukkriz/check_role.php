<?php
session_start();
echo $_SESSION['role'] ?? '';  // Mengembalikan role pengguna yang ada dalam session
exit;
