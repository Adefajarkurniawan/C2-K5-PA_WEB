<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
    exit;
}

$id_user = $_SESSION['user_id'];

// Retrieve favorite songs with search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';
$favorites_query = "SELECT lagu.id_lagu, lagu.judul_lagu, lagu.tanggal_rilis, album.artis, album.sampul_album
                    FROM favorites 
                    JOIN lagu ON favorites.id_lagu = lagu.id_lagu 
                    JOIN album ON lagu.id_album = album.id_album 
                    WHERE favorites.id_user = '$id_user'";

if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);
    $favorites_query .= " AND (lagu.judul_lagu LIKE '%$search%' OR album.artis LIKE '%$search%')";
}

$favorites_result = $conn->query($favorites_query);

if (!$favorites_result) {
    die("Query gagal: " . $conn->error);
}

// Handle POST request for adding/removing favorites
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_lagu'], $_POST['action'])) {
    $id_lagu = mysqli_real_escape_string($conn, $_POST['id_lagu']);
    $action = $_POST['action'];

    if ($action === "add") {
        $query = "INSERT INTO favorites (id_user, id_lagu) VALUES ('$id_user', '$id_lagu')";
    } elseif ($action === "remove") {
        $query = "DELETE FROM favorites WHERE id_user = '$id_user' AND id_lagu = '$id_lagu'";
    } else {
        echo "<script>alert('Aksi tidak valid.'); window.history.back();</script>";
        exit;
    }

    if ($conn->query($query)) {
        header("Location: favorite.php");
        exit;
    } else {
        echo "<script>alert('Gagal memperbarui favorit: " . $conn->error . "'); window.history.back();</script>";
    }
}

// Fetch all songs with album and artist details
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
        'lirikPath' => 'lirik/'. $baris['lirik_lagu'],
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
    <title>Favorite</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/favorite.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <?php require 'layout/sidebarUser.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Navbar -->
            <nav class="navbar">
                <div class="search">
                    <form method="GET" action="favorite.php">
                        <i class="fa-solid fa-magnifying-glass" style="font-size: 17px; color: #ff66b2; background: #323232"></i>
                        <input type="text" name="search" placeholder="Cari lagu favorit..." value="<?php echo htmlspecialchars($search); ?>">
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

            <!-- Main Content Body -->
            <div class="main-content-body">
                <div class="favorite-detail">
                    <i class="fa-solid fa-heart" style="font-size: 150px; color: #141414; margin: 20px; background-color: #ff66b2;"></i>
                    <div class="favorite-details">
                        <h1>Favorite</h1>
                        <div class="account">
                            <?php if (isset($_SESSION['foto_user']) && isset($_SESSION['username'])): ?>
                                <img src="user-foto/<?php echo htmlspecialchars($_SESSION['foto_user']); ?>" alt="Profile" class="profile-img">
                                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                            <?php else: ?>
                                <p>Pengguna tidak ditemukan. Silakan login.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            <!-- Main Content Body -->
            <div class="main-content-body">
                <div class="album-controls">
                    
                </div>

                
                <div class="song-list">
                    <?php 
                        $no = 1;
                        if ($favorites_result->num_rows > 0) {
                            while ($song = $favorites_result->fetch_assoc()) {
                                $id_lagu = $song['id_lagu'];
                                $favorite_query = $conn->query("SELECT * FROM favorites WHERE id_user = '$id_user' AND id_lagu = '$id_lagu'");
                                $is_favorite = $favorite_query->num_rows > 0;
                                $heart_class = $is_favorite ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
                                $heart_color = $is_favorite ? '#ff66b2' : '#323232';

                                echo '
                                    <div class="song-item" data-id="' . $id_lagu . '">
                                        <div class="song-no">' . $no++ . '</div>
                                        <div class="song-title">' . htmlspecialchars($song['judul_lagu']) . '<br><span>' . htmlspecialchars($song['artis']) . '</span></div>
                                        <div class="song-release">' . htmlspecialchars($song['tanggal_rilis']) . '</div>
                                        <div class="song-favorite">
                                            <form action="favorite.php" method="POST">
                                                <input type="hidden" name="id_lagu" value="' . $id_lagu . '">
                                                <input type="hidden" name="action" value="' . ($is_favorite ? 'remove' : 'add') . '">
                                                <button type="submit" class="favorite-btn" style="background: none; border: none;">
                                                    <i class="' . $heart_class . '" style="font-size: 20px; color: ' . $heart_color . ';"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>';
                            }
                        } else {
                            echo '<div class="no-results">No songs found for "' . htmlspecialchars($search) . '"</div>';
                        }
                    ?>
                    </div>
            </div>
        </div>

        <!-- Sidebar Right for Lyrics and Song Details -->
        <div class="sidebar-right">
            <h2>Lyrics</h2>
            <p id="lirikLagu">Here are the lyrics of the song currently playing...</p>
        </div>
        <div class="now-playing">
            <div class="now-playing-info">
                <div class="song-details">
                    <p class="song-title" id="judulLagu">Judul</p>
                    <p class="artist" id="penyanyi">Artist</p>
                </div>
            </div>
            <audio id="song">
                <source src="" type="audio/mp3">
            </audio>
            <div class="progress-container">
                <input type="range" value="0" id="progress">
            </div>
            <div class="music-controls">
                <button class="circ" onclick="lagusebelumnya()"><i class="fa-solid fa-backward-step"></i></button>
                <button class="circ" onclick="mainHenti()"><i class="fa-solid fa-play" id="contr"></i></button>
                <button class="circ" onclick="lagubrikutnya()"><i class="fa-solid fa-forward-step"></i></button>
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
                    document.getElementById('lirikLagu').textContent = laguData.lirikPath;
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

            document.querySelectorAll('.song-item').forEach(item => {
                item.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    muatkanLaguById(id);
                    indeksTekini = songIds.indexOf(id);
                });
            });

            function lagusebelumnya() {
                indeksTekini = (indeksTekini > 0) ? indeksTekini - 1 : songIds.length - 1;
                muatkanLaguById(songIds[indeksTekini]);
            }

            function lagubrikutnya() {
                indeksTekini = (indeksTekini < songIds.length - 1) ? indeksTekini + 1 : 0;
                muatkanLaguById(songIds[indeksTekini]);
            }
        </script>

    </div>
    <script src="js/home.js"></script>
</body>
</html>
