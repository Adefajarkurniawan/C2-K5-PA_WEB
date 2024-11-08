<?php 
require 'koneksi.php';

// Mendapatkan id_lagu dari URL
$id_lagu = $_GET['id_lagu'];

// Mengambil data lagu dari database berdasarkan id_lagu
$song_result = $conn->query("SELECT * FROM lagu WHERE id_lagu = '$id_lagu'");
$song = $song_result->fetch_assoc();

// Mengambil data album untuk dropdown pilih album
$album_result = $conn->query("SELECT * FROM album");

if (isset($_POST['update_lagu'])) {
    $judul_lagu = $_POST['lagu'];
    $tanggal_rilis = $_POST['tanggal_lagu'];
    $lirik_lagu = $_POST['lirik'];
    $id_album = $_POST['album_id'];

    // Update data lagu ke database
    $sql = "UPDATE lagu SET judul_lagu = '$judul_lagu', tanggal_rilis = '$tanggal_rilis', lirik_lagu = '$lirik_lagu', id_album = '$id_album' WHERE id_lagu = '$id_lagu'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Lagu berhasil diperbarui!'); window.location.href = 'daftar_lagu_admin.php?id_album=$id_album';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui lagu: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lagu</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/tambah_lagu.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <?php require 'layout/sidebarAdmin.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <nav class="navbar">
                <h1 style="color: #ff66b2; font-size:32px; margin-top: 7px;">Edit Lagu</h1>
            </nav>

            <!-- Form Edit Lagu -->
            <div class="main-content-body">
                <h2 class="text-2xl font-bold mb-4">Edit Lagu</h2>
                <main class="form">
                    <form action="" method="POST">
                        <div class="form-section">
                            <label for="lagu">Judul Lagu</label>
                            <input type="text" id="lagu" name="lagu" value="<?php echo $song['judul_lagu']; ?>" placeholder="Nama lagu" required>

                            <label for="tanggal_lagu">Tanggal Rilis Lagu</label>
                            <input type="date" id="tanggal_lagu" name="tanggal_lagu" value="<?php echo $song['tanggal_rilis']; ?>" required>

                            <label for="lirik">Lirik Lagu</label>
                            <textarea id="lirik" name="lirik" placeholder="Masukkan lirik lagu" required><?php echo $song['lirik_lagu']; ?></textarea>
                        </div>

                        <div class="form-section">
                            <label for="album_id">Pilih Album</label>
                            <select id="album_id" name="album_id" required>
                                <?php
                                while ($album = $album_result->fetch_assoc()) {
                                    $selected = $album['id_album'] == $song['id_album'] ? 'selected' : '';
                                    echo "<option value='" . $album['id_album'] . "' $selected>" . $album['nama_album'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-buttons">
                            <button type="submit" name="update_lagu" class="btn bg-blue-500 text-white px-4 py-2 rounded">Update Lagu</button>
                            <a href="daftar_lagu_admin.php?id_album=<?php echo $song['id_album']; ?>" class="btn bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
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
</body>
</html>
