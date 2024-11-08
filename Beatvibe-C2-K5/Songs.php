<?php
session_start();
require 'koneksi.php';

// Check if id_album is provided
if (!isset($_GET['id_album']) || empty($_GET['id_album'])) {
    echo "<script>window.location.href = 'Album_admin.php';</script>";
    exit;
}

$id_album = $_GET['id_album'];
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch album details
$album_result = $conn->query("SELECT * FROM album WHERE id_album = '$id_album'");
$album = $album_result->fetch_assoc();

// User authentication check
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
    exit;
}

$id_user = $_SESSION['user_id'];

// Fetch songs based on the search query
if ($search_query) {
    $song_result = $conn->query("SELECT * FROM lagu WHERE id_album = '$id_album' AND judul_lagu LIKE '%$search_query%'");
} else {
    $song_result = $conn->query("SELECT * FROM lagu WHERE id_album = '$id_album'");
}

// Fetch all songs with album details
$sql = "SELECT lagu.id_lagu, lagu.judul_lagu, album.artis, lagu.lirik_lagu, lagu.file_lagu, album.sampul_album
        FROM lagu INNER JOIN album ON lagu.id_album = album.id_album";
$hasil = mysqli_query($conn, $sql);

$arrayLagu = [];
while ($baris = mysqli_fetch_assoc($hasil)) {
    $arrayLagu[$baris['id_lagu']] = [
        'id' => $baris['id_lagu'],
        'title' => $baris['judul_lagu'],
        'artist' => $baris['artis'],
        'filePath' => 'lagu/' . $baris['file_lagu'],
        'lirikPath' => 'lirik/' . $baris['lirik_lagu'],
        'imagePath' => 'sampul/' . $baris['sampul_album']
    ];
}

$ubahekstension = json_encode($arrayLagu);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Songs</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/home.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <?php require 'layout/sidebarUser.php'; ?>
        
        <div class="main-content">
            <nav class="navbar">
                <div class="search">
                    <form action="Songs.php" method="GET">
                        <input type="hidden" name="id_album" value="<?php echo htmlspecialchars($id_album); ?>">
                        <i class="fa fa-search"></i>
                        <input type="text" name="search" placeholder="What do you want to listen to?" value="<?php echo htmlspecialchars($search_query); ?>">
                    </form>
                </div>
                <div class="account">
                    <?php if (isset($_SESSION['foto_user']) && isset($_SESSION['username'])): ?>
                        <img src="user-foto/<?php echo htmlspecialchars($_SESSION['foto_user']); ?>" alt="Profile" class="profile-img">
                        <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <?php else: ?>
                        <p>Pengguna tidak ditemukan. Silakan login.</p>
                    <?php endif; ?>
                </div>
            </nav>

            <div class="main-content-body">
                <div class="album-detail">
                    <img src="sampul/<?php echo htmlspecialchars($album['sampul_album']); ?>" alt="Album Cover" class="album">
                    <div class="album-details">
                        <h1><?php echo htmlspecialchars($album['nama_album']); ?></h1>
                        <p>Album <br> <?php echo $song_result->num_rows; ?> Songs</p>
                        <div class="album-controls">
                            
                            <audio id="song">
                                <source src="" type="audio/mp3">
                            </audio>
                            <input type="range" value="0" id="progress">
                            
                        </div>
                    </div>
                </div>

                <div class="song-list">
                    <div class="song-header">
                        <div class="song-no">No</div>
                        <div class="song-title">Title</div>
                        <div class="song-release">Release Date</div>    
                    </div>

                    <?php 
                    $no = 1;
                    if ($song_result->num_rows > 0) {
                        while ($song = $song_result->fetch_assoc()) {
                            $id_lagu = $song['id_lagu'];
                            $favorite_query = $conn->query("SELECT * FROM favorites WHERE id_user = '$id_user' AND id_lagu = '$id_lagu'");
                            $is_favorite = $favorite_query->num_rows > 0;
                            $heart_class = $is_favorite ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
                            $heart_color = $is_favorite ? '#ff66b2' : '#323232';

                            echo "
                                <div class='song-item' data-id='{$id_lagu}'>
                                    <div class='song-no'>{$no}</div>
                                    <div class='song-title'>{$song['judul_lagu']}<br><span>{$album['artis']}</span></div>
                                    <div class='song-release'>{$song['tanggal_rilis']}</div>
                                    <div class='song-favorite'>
                                        <form action='favorite.php' method='POST'>
                                            <input type='hidden' name='id_lagu' value='{$id_lagu}'>
                                            <input type='hidden' name='action' value='" . ($is_favorite ? 'remove' : 'add') . "'>
                                            <button type='submit' class='favorite-btn'>
                                                <i class='{$heart_class}' style='color: {$heart_color};'></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>";
                            $no++;
                        }
                    } else {
                        echo "<div class='no-results'>No songs found for \"{$search_query}\"</div>";
                    }
                    ?>
                </div>
            </div>
            <div class="now-playing">
                <div class="now-playing-info">
                    <div class="song-details">
                        <p class="song-title" id="judulLagu"> Judul</p>
                        <p class="artist" id="penyanyi">Artist</p>
                    </div>
                </div>
                <div class="music-controls">
                    <button class="control-btn kanan" onclick="lagusebelumnya()"><i class="fa fa-backward"></i></button>
                    <button class="control-btn tengah" onclick="mainHenti()"><i class="fa fa-play" id="contr"></i></button>
                    <button class="control-btn kiri" onclick="lagubrikutnya()"><i class="fa fa-forward"></i></button>
                </div>
                <div class="favorite"></div>
            </div>
            <div class="mobile-nav">
            <button class="mobile-nav-item">
                <a href="Home.php">
                <i class="fa-solid fa-house" style="font-size: 30px; color: #ff66b2;"></i>
                </a>
            </button>
            <button class="mobile-nav-item">
                <a href="Album.php">
                <i class="fa-solid fa-music" style="font-size: 30px; color: #ff66b2;"></i>
                </a>
            </button>
            <button class="mobile-nav-item">
                <a href="Tracks.php">
                <i class="fa-sharp fa-regular fa-circle-play" style="font-size: 30px; color: #ff66b2;"></i>
                </a>
            </button>
            <button class="mobile-nav-item">
                <a href="favorite.php">
                <i class="fa-solid fa-heart" style="font-size: 30px; color: #ff66b2;"></i>
                </a>
            </button>
            <button class="mobile-nav-item">
                    <a href="logout.php" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                        <i class="fa-solid fa-sign-out-alt" style="font-size: 30px; color: #ff66b2;"></i>
                        <span class="icon-text" style="margin-left: 8px; color: #ff66b2;">Logout</span>
                    </a>
            </button>
        </div>
        </div>

        <script>
            const lagu = <?php echo $ubahekstension; ?>;
            let indeksTekini = 0;
            const songIds = Object.keys(lagu);

            const song = document.getElementById('song');
            const progress = document.getElementById('progress');
            const contr = document.getElementById('contr');
            const judulLagu = document.getElementById('judulLagu');
            const penyanyi = document.getElementById('penyanyi');

            function muatkanLaguById(id) {
                const laguData = lagu[id];
                if (laguData) {
                    song.src = laguData.filePath;
                    judulLagu.textContent = laguData.title;
                    penyanyi.textContent = laguData.artist;
                    song.load();
                    song.play();
                    contr.classList.add("fa-pause");
                    contr.classList.remove("fa-play");
                }
            }

            function mainHenti() {
                if (song.paused) {
                    song.play();
                    contr.classList.add("fa-pause");
                    contr.classList.remove("fa-play");
                } else {
                    song.pause();
                    contr.classList.add("fa-play");
                    contr.classList.remove("fa-pause");
                }
            }

            function lagubrikutnya() {
                indeksTekini = (indeksTekini + 1) % songIds.length;
                muatkanLaguById(songIds[indeksTekini]); 
            }

            function lagusebelumnya() {
                indeksTekini = (indeksTekini - 1 + songIds.length) % songIds.length;
                muatkanLaguById(songIds[indeksTekini]); 
            }

            song.onloadedmetadata = function() {
                progress.max = song.duration;
            };

            song.ontimeupdate = function() {
                progress.value = song.currentTime;
            };

            progress.onchange = function() {
                song.currentTime = progress.value;
            };

            document.querySelectorAll('.song-item').forEach(item => {
                const id_lagu = item.getAttribute('data-id');
                item.addEventListener('click', () => muatkanLaguById(parseInt(id_lagu)));
            });
        </script>
    </div>
</body>
</html>
