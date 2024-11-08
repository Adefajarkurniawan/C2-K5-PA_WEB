<?php 
session_start();
require 'koneksi.php';

// Ambil data album berdasarkan pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';
if ($search) {
    $album_result = $conn->query("SELECT * FROM album WHERE nama_album LIKE '%$search%' ORDER BY id_album DESC");
} else {
    $album_result = $conn->query("SELECT * FROM album ORDER BY id_album DESC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album_Beatvibes</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/home.css" />
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
                    <form method="GET" action="album.php">
                        <i class="fa-solid fa-magnifying-glass" style="font-size: 17px; color: #ff66b2; background: #323232"></i>
                        <input type="text" name="search" placeholder="Cari album..." value="<?php echo htmlspecialchars($search); ?>">
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
                <div class="main-content-body-up">
                    <?php if ($search): ?>
                        <h1>Hasil Pencarian untuk "<?php echo htmlspecialchars($search); ?>"</h1>
                        <p><?php echo $album_result->num_rows; ?> album ditemukan.</p>
                    <?php else: ?>
                        <h1>Trend This Week</h1>
                    <?php endif; ?>

                    <div class="album-grid">
                        <?php 
                        if ($album_result->num_rows > 0) {
                            while ($album = $album_result->fetch_assoc()) {
                                echo '
                                <a href="Songs.php?id_album=' . $album['id_album'] . '">
                                    <div class="album-grid-item">
                                        <img src="sampul/' . htmlspecialchars($album['sampul_album']) . '" alt="Album" class="album">
                                        <div class="album-info">
                                            <h2>' . htmlspecialchars($album['nama_album']) . '</h2>
                                            <p>' . htmlspecialchars($album['artis']) . '</p>
                                        </div>
                                    </div>
                                </a>';
                            }
                        } else {
                            echo '<p>Album tidak ditemukan.</p>';
                        }
                        ?>
                    </div>       
                </div>
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
    <script src="js/home.js" defer></script>
</body>
</html>
