<?php
session_start();

// cek login
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}
?>

<?php
include 'koneksi.php'; // koneksi database

$id = $_GET['id']; // ambil id dari URL

mysqli_query($koneksi, "DELETE FROM absensi WHERE id_absensi='$id'"); 
// hapus data berdasarkan id

header("Location: absensi.php"); 
// balik ke halaman utama
?>