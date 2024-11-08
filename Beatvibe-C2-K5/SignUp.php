<?php
    require 'koneksi.php';

    if(isset($_POST['signup'])) {
        $username = $_POST['username'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST["password"], \PASSWORD_DEFAULT);

        $tempFile = $_FILES['foto']['tmp_name'];
        $fileName = $_FILES['foto']['name'];

        $eks = explode('.', $fileName);
        $eks = strtolower(end($eks));
        
        $checkQuery = "SELECT * FROM user WHERE username = '$username'";
        $checkResult = mysqli_query($conn, $checkQuery);
        if (mysqli_num_rows($checkResult) > 0) {
            echo "
                <script>
                alert('Username sudah digunakan! Silakan gunakan username lain.');
                document.location.href = 'SignUp.php';
                </script>
                ";
        } else {
            if (move_uploaded_file($tempFile, 'user-foto/'.$fileName)) {
                $query = "INSERT INTO user VALUES('', '$username', '$name', '$email', '$password', '$fileName')";
    
                $result = mysqli_query($conn, $query);
    
                if($result){
                    echo "
                        <script>
                            alert('Registrasi Akun Berhasil');
                            document.location.href = 'Login.php';
                        </script>
                    ";
                }else{
                    echo "
                        <script>
                            alert('Registrasi Akun Gagal');
                            document.location.href = 'SignUp.php';
                        </script>
                    ";
                }
            }else{
                echo "
                    <script>
                        alert('File Belom Terupload!!');
                        document.location.href = 'SignUp.php';
                    </script>
                ";
            }
        }
    }    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="login-container">
    
    <div class="login-box">
        <div class="login-logo">
            <h2 id="formTitle">Sign Up to Bootbeats</h2>
        </div>
        <div class="have-acc">
            <p>Already have account? <a href="Login.php" >Login</a></p>
        </div>
        
        <form id="dataForm" class="login-form" action="SignUp.php" method="POST" enctype="multipart/form-data" onsubmit="return validasiForm()">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Username" >
            <p class="error-message">Username tidak boleh kosong.</p>

            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Name" >
            <p class="error-message">Nama tidak boleh kosong.</p>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="youremail@gmail.com" >
            <p class="error-message">Email tidak boleh kosong.</p>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" >
            <p class="error-message">Password tidak boleh kosong.</p>
            
            <label for="Profile">Foto Profile</label>
            <label for="file" class="custom-file-label">Upload Foto Profile</label>
            <input type="file" id="file" name="foto" >
            <p class="file-name" id="fileName"></p>
            <p class="error-message" id="fileError">Ukuran file tidak boleh lebih dari 2MB</p>

            <div class="submit-container">
                <button type="submit" name="signup" class="submit-btn">Sign In</button>
            </div>
        </form>
    </div>
</div>

<script src="js/script.js"></script>

</body>
</html>
