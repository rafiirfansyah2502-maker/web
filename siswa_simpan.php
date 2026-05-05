<?php
include 'koneksi.php';

$nis = $_POST['nis'];
$nama = $_POST['nama'];
$id_kelas = $_POST['id_kelas'];

mysqli_query($koneksi, "
    INSERT INTO siswa (nis, nama, id_kelas)
    VALUES ('$nis', '$nama', '$id_kelas')
");

header("Location: data_siswa.php");