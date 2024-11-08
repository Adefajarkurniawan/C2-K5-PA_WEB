<?php 
require 'koneksi.php';

// Mendapatkan id_lagu dari URL
$id_lagu = $_GET['id_lagu'];

// Ambil nama file lagu dari database
$query = "SELECT file_lagu FROM lagu WHERE id_lagu = '$id_lagu'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $file_lagu = $row['file_lagu'];

    // Path ke file lagu
    $lagu_path = 'lagu/' . $file_lagu;

    // Periksa apakah file ada dan hapus
    if (file_exists($lagu_path)) {
        unlink($lagu_path); // Hapus file dari direktori
    }
}

// Menghapus data lagu berdasarkan id_lagu
$sql = "DELETE FROM lagu WHERE id_lagu = '$id_lagu'";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Lagu berhasil dihapus!'); window.location.href = 'Album_admin.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus lagu: " . mysqli_error($conn) . "'); window.history.back();</script>";
}
?>
