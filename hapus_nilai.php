<?php
include 'koneksi.php'; /* koneksi */

// ambil id dari url
$id = $_GET['id'] ?? ''; /* id nilai */

// ambil data dulu buat tau id_siswa
$data = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_nilai='$id'");
$n = mysqli_fetch_assoc($data);

// hapus data
mysqli_query($koneksi, "DELETE FROM nilai WHERE id_nilai='$id'");

// balik lagi ke halaman nilai siswa
header("Location: data_nilai.php?id_siswa=".$n['id_siswa']);
?>