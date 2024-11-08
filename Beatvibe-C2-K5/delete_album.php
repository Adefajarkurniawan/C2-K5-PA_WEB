<?php
require 'koneksi.php';

// Mendapatkan ID album dari URL
$id_album = $_GET['id_album'];

// Cek apakah masih ada lagu yang terkait dengan album ini
$query_lagu = "SELECT * FROM lagu WHERE id_album = '$id_album'";
$result_lagu = mysqli_query($conn, $query_lagu);

if ($result_lagu && mysqli_num_rows($result_lagu) > 0) {
    // Jika ada lagu terkait, tampilkan pesan alert dan hentikan eksekusi
    echo "<script>alert('Tidak dapat menghapus album. Harap hapus semua lagu dalam album terlebih dahulu.'); window.location.href = 'daftar_lagu_admin.php?id_album=$id_album';</script>";
    exit;
}

// Ambil informasi sampul album dari database
$query = "SELECT sampul_album FROM album WHERE id_album = '$id_album'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $sampul_album = $row['sampul_album'];

    // Path ke file sampul album
    $sampul_path = __DIR__ . '/sampul/' . $sampul_album;

    // Periksa apakah file sampul ada dan hapus
    if (file_exists($sampul_path)) {
        unlink($sampul_path); // Hapus file sampul album dari direktori
    }
}

// Menghapus data album dari database
$sql = "DELETE FROM album WHERE id_album = '$id_album'";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Album berhasil dihapus!'); window.location.href = 'daftar_lagu_admin.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus album: " . mysqli_error($conn) . "'); window.history.back();</script>";
}
?>
