<?php
session_start();

// cek login
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}
?>

<?php
include 'koneksi.php'; // konek ke database

// ambil data dari form
$id = $_POST['id_siswa']; // id siswa
$sakit = $_POST['sakit']; // jumlah sakit
$izin = $_POST['izin']; // jumlah izin
$alpha = $_POST['alpha']; // jumlah alpha

// update data absensi (biar ga dobel)
mysqli_query($koneksi, "
UPDATE absensi 
SET 
    sakit='$sakit',
    izin='$izin',
    alpha='$alpha'
WHERE id_siswa='$id'
");

// balik lagi ke halaman absensi
header("Location: absensi.php");