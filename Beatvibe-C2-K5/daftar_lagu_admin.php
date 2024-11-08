<?php 
require 'koneksi.php';

// Periksa apakah 'id_album' ada di URL
if (!isset($_GET['id_album']) || empty($_GET['id_album'])) {
    echo "<script>window.location.href = 'Album_admin.php';</script>";
    exit;
}

$id_album = $_GET['id_album'];

// Mengambil data album berdasarkan ID
$album_result = $conn->query("SELECT * FROM album WHERE id_album = '$id_album'");
$album = $album_result->fetch_assoc();

// Jika album tidak ditemukan, tampilkan pesan dan kembali ke halaman album
if (!$album) {
    echo "<script>alert('Album tidak ditemukan.'); window.location.href = 'Album_admin.php';</script>";
    exit;
}

// Query untuk mengambil daftar lagu berdasarkan id_album
$song_result = $conn->query("SELECT * FROM lagu WHERE id_album = '$id_album'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lagu admin</title>
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
            <!-- Navbar -->
            <nav class="navbar">
                <div class="account">
                    <img src="Logo/logo.png" alt="Profile" class="profile-img">
                    <span>Admin</span>
                </div>
            </nav>

            <!-- Main Content Body -->
            <div class="main-content-body">
                <div class="album-detail">
                    <img src="sampul/<?php echo $album['sampul_album']; ?>" alt="Album Cover" class="album">
                    <div class="album-details">
                        <h1><?php echo $album['nama_album']; ?></h1>
                        <p>Album • <?php echo $album['artis']; ?></p>
                        <div class="album-controls">
                            <a href="edit_album.php?id_album=<?php echo $id_album; ?>" class="btn-edit"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="delete_album.php?id_album=<?php echo $id_album; ?>" class="btn-delete"  onclick="return confirm('Apakah Anda yakin ingin menghapus album ini?');"><i class="fa-solid fa-trash-can"></i></a>
                        </div>
                    </div>
                </div>

                <div class="song-list">
                    <div class="song-header">
                        <div class="song-no">No</div>
                        <div class="song-title">Title</div>
                        <div class="song-release">Release date</div>
                        <div class="song-edit">Edit</div>
                        <div class="song-delete">Delete</div>
                    </div>

                    <?php
                    $no = 1;
                    while ($song = $song_result->fetch_assoc()) {
                        echo '
                        <div class="song-item">
                            <div class="song-no">' . $no++ . '</div>
                            <div class="song-title">' . $song['judul_lagu'] . '<br><span>' . $album['artis'] . '</span></div>
                            <div class="song-release">' . $song['tanggal_rilis'] . '</div>
                            <div class="song-edit"><a href="edit_song.php?id_lagu=' . $song['id_lagu'] . '"><i class="fa-solid fa-pen-to-square"></i></a></div>
                            <div class="song-delete"><a href="delete_song.php?id_lagu=' . $song['id_lagu'] . '"><i class="fa-solid fa-trash-can"></i></a></div>
                        </div>';
                    }
                    ?>
                </div>
            </div> 
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