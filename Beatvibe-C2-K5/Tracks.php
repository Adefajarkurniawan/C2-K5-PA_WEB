<?php
session_start();
require 'koneksi.php'; 

$sql = "SELECT lagu.judul_lagu, album.artis, lagu.file_lagu, album.sampul_album, lagu.lirik_lagu
    FROM lagu
    JOIN album ON lagu.id_album = album.id_album";

$hasil = mysqli_query($conn, $sql);

if (!$hasil) {
    die('Query Failed: ' . mysqli_error($conn));
}

$arrayLagu = [];
while ($baris = mysqli_fetch_assoc($hasil)) {
    $arrayLagu[] = [
    'title' => $baris['judul_lagu'],
    'artist' => $baris['artis'],
    'filePath' => 'lagu/' . $baris['file_lagu'],
    'imagePath' => 'sampul/' . $baris['sampul_album'],
    'lirikPath' => 'lirik/'. $baris['lirik_lagu']
    ];
}

$ubahekstension = json_encode($arrayLagu);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracks</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/tracks.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <?php require 'layout/sidebarUser.php'; ?>
        <!-- Sidebar -->

        <!-- Konten Utama -->
        <div class="main-content">
            <!-- Navbar -->

            <!-- Badan Konten Utama -->
            <div class="container-music">
            <img src="" alt="Album Cover" class="song-img" id="albumImage">
            <h1 id="judulLagu">Judul</h1> 
            <p id="penyanyi">Artist</p> 
            <audio id="song">
                <source src="" type="audio/mp3">
            </audio>
            <input type="range" value="0" id="progress">
            <div class="music-p">
                <nav>
                <button class="circ" onclick="lagusebelumnya()"><i class="fa-solid fa-backward-step"></i></button>
                <button class="circ" onclick="mainHenti()"><i class="fa-solid fa-play" id="contr"></i></button>
                <button class="circ" onclick="lagubrikutnya()"><i class="fa-solid fa-forward-step"></i></button>
                </nav>
            </div>
            </div>

            <!-- Sidebar Kanan untuk Lirik -->
            <div class="sidebar-right">
                <h2>Lirik</h2>
                <p id="lirikLagu">Here are the lyrics of the song currently playing...</p>
            </div>
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

    const song = document.getElementById('song');
    const progress = document.getElementById('progress');
    const contr = document.getElementById('contr');
    const judulLagu = document.getElementById('judulLagu');
    const penyanyi = document.getElementById('penyanyi');
    const albumImage = document.getElementById('albumImage');
    const lirikLagu = document.getElementById('lirikLagu');

    function muatkanLagu(indeks) {
        song.src = lagu[indeks].filePath;
        judulLagu.textContent = lagu[indeks].title;
        penyanyi.textContent = lagu[indeks].artist;
        albumImage.src = lagu[indeks].imagePath; 
        lirikLagu.textContent = lagu[indeks].lirikPath;
        song.load();
        song.play();
        contr.classList.add("fa-pause");
        contr.classList.remove("fa-play");
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
        indeksTekini = (indeksTekini + 1) % lagu.length;
        muatkanLagu(indeksTekini);
    }

    function lagusebelumnya() {
        indeksTekini = (indeksTekini - 1 + lagu.length) % lagu.length;
        muatkanLagu(indeksTekini);
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

    muatkanLagu(indeksTekini);

    </script>
    <script src="js/home.js"></script> 
</body>
</html>
