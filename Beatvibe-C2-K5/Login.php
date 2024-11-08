<?php
// Mulai sesi
session_start();
require 'koneksi.php';

// Proses login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Pengecekan untuk admin
    if ($username === 'admin' && $password === 'admin123') {
        // Simpan data admin di session
        $_SESSION['user_id'] = 'admin';
        $_SESSION['username'] = 'admin';

        echo "<script>
                alert('Login sebagai Admin Berhasil');
                window.location.href = 'Album_admin.php';
              </script>";
    } else {
        // Pengecekan untuk pengguna biasa
        $query = "SELECT * FROM user WHERE username = '$username'";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            // Simpan data pengguna di session
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['foto_user'] = $user['foto_user']; // Gunakan nama field yang benar
        
            echo "<script>
                    alert('Login Berhasil');
                    window.location.href = 'home.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Username atau Password salah');
                    document.location.href = 'Login.php';
                  </script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="login-container">
    <div class="login-box">
        <div class="login-logo">
            <h2 id="formTitle">Login to Bootbeats</h2>
        </div>
        <div class="have-acc">
            <p>Don't have an account yet? <a href="SignUp.php" >Sign Up</a></p>
        </div>
        
        <form id="dataForm" class="login-form" action="Login.php" method="POST" onsubmit="return validasiForm()" enctype="multipart/form-data" novalidate>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Username" required>
            <p class="error-message">Username tidak boleh kosong.</p>
               
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <p class="error-message">Password tidak boleh kosong.</p>
            
            <div class="submit-container">
                <button type="submit" name="login" class="submit-btn">Login</button>
            </div>
        </form>
    </div>
</div>
<script src="js/script.js"></script>

</body>
</html>
