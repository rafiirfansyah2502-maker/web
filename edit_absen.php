<?php
session_start(); 
// mulai session biar bisa cek login user

// cek apakah user sudah login
if(!isset($_SESSION['login'])){
    header("Location: login.php"); 
    // kalau belum login, lempar ke halaman login
    exit; 
    // stop script biar gak lanjut
}
?>

<?php
include 'koneksi.php'; 
// koneksi ke database mysql

$id = $_GET['id']; 
// ambil id absensi dari url (contoh: ?id=1)

// ambil data lama dari database berdasarkan id
$data = mysqli_query($koneksi, "select * from absensi where id_absensi='$id'");

// ubah hasil query jadi array biar gampang dipakai
$d = mysqli_fetch_assoc($data);

// cek kalau tombol update ditekan
if(isset($_POST['update'])){

    $sakit = $_POST['sakit']; 
    // ambil input sakit dari form

    $izin = $_POST['izin']; 
    // ambil input izin dari form

    $alpha = $_POST['alpha']; 
    // ambil input alpha dari form

    // update data ke database
    mysqli_query($koneksi, "
        update absensi 
        set sakit='$sakit', izin='$izin', alpha='$alpha'
        where id_absensi='$id'
    ");

    // setelah update, balik ke halaman absensi
    header("Location: absensi.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <!-- biar karakter aman (utf-8) -->

    <title>edit absensi</title>
    <!-- judul tab browser -->

    <link rel="stylesheet" href="rapot_css/absensi.css">
    <!-- css biar tampilannya sama kayak halaman absensi -->
</head>

<body>

<div class="container">
<!-- pembungkus utama biar form di tengah -->

    <div class="form-card">
    <!-- card form putih -->

        <h2>edit absensi</h2>
        <!-- judul halaman -->

        <form method="POST">
        <!-- form kirim data pakai POST -->

            <label>sakit</label>
            <!-- label input sakit -->

            <input type="number" name="sakit" value="<?= $d['sakit'] ?>" required>
            <!-- input sakit + diisi data lama dari database -->

            <label>izin</label>
            <!-- label input izin -->

            <input type="number" name="izin" value="<?= $d['izin'] ?>" required>
            <!-- input izin + data lama -->

            <label>alpha</label>
            <!-- label input alpha -->

            <input type="number" name="alpha" value="<?= $d['alpha'] ?>" required>
            <!-- input alpha + data lama -->

            <div class="btn-group">
            <!-- pembungkus tombol -->

                <a href="absensi.php" class="btn-back">
                <!-- tombol kembali -->
                    ← kembali
                </a>

                <button type="submit" name="update" class="btn-submit">
                <!-- tombol update data -->
                    update
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>