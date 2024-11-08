<?php 
require 'koneksi.php';

if (isset($_POST['tambah_album'])) {
    $nama_album = $_POST['album'];
    $artis = $_POST['artis'];
    $tanggal_rilis = $_POST['tanggal_album'];

    // Upload sampul album
    $sampul_album = $_FILES['sampul_album']['name'];
    $sampul_tmp = $_FILES['sampul_album']['tmp_name'];
    $upload_dir = 'sampul/';
    $sampul_path = $upload_dir . $sampul_album;

    // Validasi tipe file sampul album
    $allowed_image_types = ['image/jpeg', 'image/png', 'image/jpg'];
    $sampul_type = mime_content_type($sampul_tmp);

    if (!in_array($sampul_type, $allowed_image_types)) {
        echo "<script>alert('Sampul album hanya dapat berupa file JPEG, PNG, atau JPG.');</script>";
    } elseif (move_uploaded_file($sampul_tmp, $sampul_path)) {
        $sql = "INSERT INTO album (nama_album, artis, sampul_album) VALUES ('$nama_album', '$artis', '$sampul_album')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Album berhasil ditambahkan!');</script>";
        } else {
            echo "<script>alert('Gagal menambahkan album: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Gagal mengunggah sampul album.');</script>";
    }
}

if (isset($_POST['tambah_lagu'])) {
    $judul_lagu = $_POST['lagu'];
    $tanggal_rilis = $_POST['tanggal_lagu'];
    $lirik_lagu = $_POST['lirik'];
    $id_album = $_POST['album_id'];

    // Escape data untuk menghindari masalah karakter khusus
    $judul_lagu = mysqli_real_escape_string($conn, $judul_lagu);
    $tanggal_rilis = mysqli_real_escape_string($conn, $tanggal_rilis);
    $lirik_lagu = mysqli_real_escape_string($conn, $lirik_lagu);
    $id_album = mysqli_real_escape_string($conn, $id_album);

    // Upload file lagu
    $file_lagu = $_FILES['lagu']['name'];
    $lagu_tmp = $_FILES['lagu']['tmp_name'];
    $lagu_upload_dir = 'lagu/';
    $lagu_path = $lagu_upload_dir . $file_lagu;

    // Validasi tipe file lagu
    $allowed_audio_types = ['audio/mpeg'];
    $lagu_type = mime_content_type($lagu_tmp);

    if (!in_array($lagu_type, $allowed_audio_types)) {
        echo "<script>alert('File lagu hanya dapat berupa file MP3.');</script>";
    } elseif (move_uploaded_file($lagu_tmp, $lagu_path)) {
        // Query untuk menambahkan data lagu
        $sql = "INSERT INTO lagu (judul_lagu, tanggal_rilis, lirik_lagu, id_album, file_lagu) VALUES ('$judul_lagu', '$tanggal_rilis', '$lirik_lagu', '$id_album', '$file_lagu')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Lagu berhasil ditambahkan!');</script>";
        } else {
            echo "<script>alert('Gagal menambahkan lagu: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Gagal mengunggah file lagu.');</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/tambah_lagu.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <?php require 'layout/sidebarAdmin.php' ?>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Navbar -->
            <nav class="navbar">
                
                <h1 style="color: #ff66b2; font-size: 32px; margin-top: 7px;">Tambah Lagu dan Album</h1>
                <div class="account">
                    <img src="Logo/logo.png" alt="Profile" class="profile-img">
                    <span>Admin</span>
                </div>
            </nav>

            <!-- Main Content Body -->
            <div class="main-content-body mb-10">
                <h2 class="text-2xl font-bold mb-4" style="color: #ff66b2;">Tambah Album</h2>
                <main class="form">
                    <form action="Tambah_lagu.php" method="POST" enctype="multipart/form-data">
                        <div class="form-section">
                            <label for="album">Nama Album</label>
                            <input type="text" name="album" placeholder="Nama Album" required>

                            <label for="artis">Artis</label>
                            <input type="text" name="artis" placeholder="Nama Artis" required>

                            <label for="tanggal_album">Tanggal Rilis Album</label>
                            <input type="date" name="tanggal_album" required>

                            <label for="sampul_album">Unggah Foto Sampul Lagu</label>
                            <div class="file-upload">
                                <label for="sampul_album" class="upload-btn">Unggah Foto</label>
                                <span class="file-name">Tidak ada file dipilih</span>
                                <input type="file" id="sampul_album" name="sampul_album" required onchange="showFileName(this)">
                            </div>

                        </div>
                        <div class="form-buttons">
                            <button type="submit" name="tambah_album" class="btn">Tambah Album</button>
                        </div>
                    </form>
                </main>
            </div>

            <div class="main-content-body mb-10">
                <h2 class="text-2xl font-bold mb-4">Tambah Lagu</h2>
                <main class="form">
                    <form action="Tambah_lagu.php" method="POST" enctype="multipart/form-data">
                        <div class="form-section">
                            <label for="judul_lagu">Judul Lagu</label>
                            <input type="text" id="judul_lagu" name="lagu" placeholder="Nama Lagu" required>

                            <label for="tanggal_lagu">Tanggal Rilis Lagu</label>
                            <div class="custom-date">
                                <input type="date" id="tanggal_lagu" name="tanggal_lagu" required>
                            </div>

                            <label for="lirik">Lirik Lagu</label>
                            <div class="lirik">
                                <input type="text" id="lirik" name="lirik" required>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <label for="album_id">Pilih Album</label>
                            <select id="album_id" name="album_id" class="w-full p-2 border border-gray-300 rounded" required>
                                <?php
                                include 'koneksi.php';
                                $result = $conn->query("SELECT id_album, nama_album FROM album");
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id_album'] . "'>" . $row['nama_album'] . "</option>";
                                }
                                ?>
                            </select>                        
                        </div>

                        <div class="form-section">
                            <label for="file_lagu">Unggah Lagu</label>
                            <div class="file-upload">
                                <label for="file_lagu" class="upload-btn">Unggah Lagu</label>
                                <span class="file-name-lagu">Tidak ada file dipilih</span>
                                <input type="file" id="file_lagu" name="lagu" required onchange="showFileNameLagu(this)">

                            </div>
                        </div>

                        <div class="form-buttons">
                            <button type="submit" name="tambah_lagu" class="btn bg-blue-500 text-white px-4 py-2 rounded">Tambah Lagu</button>
                        </div>
                    </form>
                </main>
            </div>
            <div class="mobile-nav">
                <button class="mobile-nav-item">
                    <a href="Tambah_lagu.php">
                        <i class="fa-solid fa-plus-circle" style="font-size: 30px; color: #ff66b2;"></i>
                    </a>
                </button>
                <button class="mobile-nav-item">
                    <a href="Album_admin.php">
                        <i class="fa-solid fa-music" style="font-size: 30px; color: #ff66b2;"></i>
                    </a>
                </button>
                <button class="mobile-nav-item">
                    <a href="logout.php">
                        <i class="fa-solid fa-sign-out-alt" style="font-size: 30px; color: #ff66b2;"></i>
                    </a>
                </button>
            </div>
        </div>   
    </div>
    <script src="js/home.js" defer></script>
</body>
</html>
