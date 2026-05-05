<?php
session_start();

// cek login
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}
?>

<?php
include 'koneksi.php'; 
// konek ke database

// ambil id dari URL
$id = $_GET['id'];

// query hapus data
mysqli_query($koneksi, "DELETE FROM siswa WHERE id_siswa='$id'");

// balik ke halaman data siswa
header("Location: data_siswa.php");
exit;
?>