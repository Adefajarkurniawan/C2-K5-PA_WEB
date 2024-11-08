<?php
require 'koneksi.php';

// Mendapatkan ID album dari URL
$id_album = $_GET['id_album'];

// Mengambil data album dari database
$query = "SELECT * FROM album WHERE id_album = '$id_album'";
$result = mysqli_query($conn, $query);
$album = mysqli_fetch_assoc($result);

// Memproses form edit album jika disubmit
if (isset($_POST['update_album'])) {
    $nama_album = $_POST['album'];
    $artis = $_POST['artis'];
    
    // Periksa jika ada file sampul album yang diunggah
    if ($_FILES['sampul_album']['name']) {
        $sampul_album = $_FILES['sampul_album']['name'];
        $sampul_tmp = $_FILES['sampul_album']['tmp_name'];
        $upload_dir = 'sampul/';
        $sampul_path = $upload_dir . $sampul_album;

        // Hapus sampul album lama jika ada
        if (file_exists($upload_dir . $album['sampul_album'])) {
            unlink($upload_dir . $album['sampul_album']);
        }

        // Pindahkan file baru ke direktori
        if (move_uploaded_file($sampul_tmp, $sampul_path)) {
            $sql = "UPDATE album SET nama_album='$nama_album', artis='$artis',  sampul_album='$sampul_album' WHERE id_album='$id_album'";
        } else {
            echo "<script>alert('Gagal mengunggah sampul album.');</script>";
            exit;
        }
    } else {
        // Jika tidak ada file yang diunggah, hanya update data lainnya
        $sql = "UPDATE album SET nama_album='$nama_album', artis='$artis' WHERE id_album='$id_album'";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Album berhasil diperbarui!'); window.location.href = 'daftar_lagu_admin.php?id_album=$id_album';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui album: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Album</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/tambah_lagu.css">
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <?php require 'layout/sidebarAdmin.php'; ?>
        
        <!-- Main Content -->
        <div class="main-content">
            <h1>Edit Album</h1>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-section">
                    <label for="album">Nama Album</label>
                    <input type="text" name="album" value="<?php echo $album['nama_album']; ?>" required>

                    <label for="artis">Artis</label>
                    <input type="text" name="artis" value="<?php echo $album['artis']; ?>" required>

                    
                    <label for="sampul_album">Unggah Sampul Album (Opsional)</label>
                    <div class="file-upload">
                        <label for="sampul_album" class="upload-btn">Unggah Foto</label>
                        <span class="file-name">Tidak ada file dipilih</span>
                        <input type="file" id="sampul_album" name="sampul_album" onchange="showFileName(this)">
                    </div>
                </div>
                <div class="form-buttons">
                    <button type="submit" name="update_album" class="btn">Perbarui Album</button>
                </div>
            </form>
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
    <script src="js/home.js" defer></script>
</body>
</html>