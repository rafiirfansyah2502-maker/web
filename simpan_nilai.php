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

// ambil dari form
$id_siswa = $_POST['id_siswa'];
$id_mapel = $_POST['id_mapel'];
$tugas = $_POST['tugas'];
$uts = $_POST['uts'];
$uas = $_POST['uas'];

// hitung rata (dibuletin biar ga 59.3333)
$rata = round(($tugas + $uts + $uas) / 3);

$cek = mysqli_query($koneksi,"
SELECT * FROM nilai 
WHERE id_siswa='$id_siswa' 
AND id_mapel='$id_mapel'
");

if(mysqli_num_rows($cek) > 0){
    // kalo udah ada → update
    mysqli_query($koneksi,"
    UPDATE nilai SET 
        tugas='$tugas',
        uts='$uts',
        uas='$uas',
        rata_rata='$rata'
    WHERE id_siswa='$id_siswa' 
    AND id_mapel='$id_mapel'
    ");
} else {
    // kalo belum → insert
    mysqli_query($koneksi,"
    INSERT INTO nilai (id_siswa,id_mapel,tugas,uts,uas,rata_rata)
    VALUES ('$id_siswa','$id_mapel','$tugas','$uts','$uas','$rata')
    ");
}

// balik ke data nilai (bawa id biar ga error)
header("Location: data_nilai.php?id_siswa=$id_siswa");
exit;
?>