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

// ambil data dari form
$id       = $_POST['id'];
$nis      = $_POST['nis'];
$nama     = $_POST['nama'];
$id_kelas = $_POST['id_kelas'];

// update data ke database
mysqli_query($koneksi, "
    UPDATE siswa SET
    nis='$nis',
    nama='$nama',
    id_kelas='$id_kelas'
    WHERE id_siswa='$id'
");

// balik lagi ke halaman data siswa
header("Location: data_siswa.php");
exit;
?>