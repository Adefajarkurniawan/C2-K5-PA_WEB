<?php 
require 'koneksi.php';

// Mengambil input pencarian, jika ada
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk mengambil data album berdasarkan pencarian
if ($search) {
    $result = $conn->query("SELECT * FROM album WHERE nama_album LIKE '%$search%' ORDER BY id_album DESC");
} else {
    $result = $conn->query("SELECT * FROM album ORDER BY id_album DESC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album_admin</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/album_admin.css" />
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
               
                <div class="search">
                    <form method="GET" action="album_admin.php">
                        <i class="fa-solid fa-magnifying-glass" style="font-size: 17px; color: #ff66b2; background : #323232"></i>
                        <input type="text" name="search" placeholder="Cari album..." value="<?php echo htmlspecialchars($search); ?>">
                    </form>
                </div>
                <div class="account">
                    <img src="Logo/logo.png" alt="Profile" class="profile-img">
                    <span>Admin</span>
                </div>
            </nav>

            <!-- Main Content Body -->
            <div class="main-content-body">
                <div class="main-content-body-up">
                    <?php if ($search): ?>
                        <h1>Hasil Pencarian untuk "<?php echo htmlspecialchars($search); ?>"</h1>
                        <p><?php echo $result->num_rows; ?> album ditemukan.</p>
                    <?php else: ?>
                        <h1>Trend This Week</h1>
                    <?php endif; ?>

                    <div class="album-grid">
                        <?php 
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '
                                <a href="daftar_lagu_admin.php?id_album=' . $row['id_album'] . '">
                                    <div class="album-grid-item">
                                        <img src="sampul/' . $row['sampul_album'] . '" alt="' . $row['nama_album'] . '" class="album">
                                        <div class="album-info">
                                            <h2>' . htmlspecialchars($row['nama_album']) . '</h2>
                                            <p>' . htmlspecialchars($row['artis']) . '</p>
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
